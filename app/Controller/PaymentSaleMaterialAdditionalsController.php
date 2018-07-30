<?php

App::uses('AppController', 'Controller');

class PaymentSaleMaterialAdditionalsController extends AppController {

    var $name = "PaymentSaleMaterialAdditionals";
    var $disabledAction = array(
    );
    var $contain = [
        "PaymentType",
        "MaterialAdditionalSale" => [
            "BranchOffice",
            "Supplier"
        ],
        "InitialBalance" => [
            "GeneralEntryType"
        ],
        "Employee" => [
            "Account" => [
                "Biodata"
            ]
        ]
    ];

    function beforeFilter() {
        parent::beforeFilter();
        $this->_setPageInfo("admin_index", "");
        $this->_setPageInfo("admin_add", "");
        $this->_setPageInfo("admin_edit", "");
    }

    function beforeRender() {
        $this->_options();
        parent::beforeRender();
    }

    function _options() {
        $this->set("branchOffices", ClassRegistry::init("BranchOffice")->find("list", ['fields' => ['BranchOffice.id', 'BranchOffice.name']]));
        $this->set("paymentTypes", $this->PaymentSaleMaterialAdditional->PaymentType->find("list", ["fields" => ["PaymentType.id", "PaymentType.name"]]));
        $this->set("initialBalances", $this->PaymentSaleMaterialAdditional->InitialBalance->find("list", [
                    "fields" => [
                        "InitialBalance.id",
                        "GeneralEntryType.name"
                    ],
                    "conditions" => [
                        "InitialBalance.currency_id" => 1,
                        "GeneralEntryType.parent_id" => [2, 3, 4]
                    ],
                    "contain" => [
                        "GeneralEntryType"
                    ]
        ]));
    }

    function admin_add() {
        if ($this->request->is("post")) {
            $this->{ Inflector::classify($this->name) }->set($this->data);
            if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                $dataInvoice = $this->PaymentSaleMaterialAdditional->find("first", [
                    "conditions" => [
                        "PaymentSaleMaterialAdditional.material_additional_sale_id" => $this->data['PaymentSaleMaterialAdditional']['material_additional_sale_id']
                    ],
                    "contain" => [
                        "MaterialAdditionalSale" => [
                            "Supplier" => [
                                "GeneralEntryType"
                            ]
                        ]
                    ]
                ]);
                $this->PaymentSaleMaterialAdditional->data['MaterialAdditionalSale']['id'] = $this->data['PaymentSaleMaterialAdditional']['material_additional_sale_id'];
                $this->PaymentSaleMaterialAdditional->_numberSeperatorRemover();
                $initialBalance = ClassRegistry::init("InitialBalance")->find("first", [
                    "conditions" => [
                        "InitialBalance.id" => $this->data['PaymentSaleMaterialAdditional']['initial_balance_id'],
                    ],
                    "contain" => [
                        "GeneralEntryType"
                    ]
                ]);
                $mutation_balance = $initialBalance['InitialBalance']['nominal'] + $this->PaymentSaleMaterialAdditional->data['PaymentSaleMaterialAdditional']['amount'];

                $this->PaymentSaleMaterialAdditional->data['InitialBalance']['id'] = $this->data['PaymentSaleMaterialAdditional']['initial_balance_id'];
                $this->PaymentSaleMaterialAdditional->data['InitialBalance']['nominal'] = $mutation_balance;
                if (!empty($dataInvoice)) {
                    $remaining = $dataInvoice['PaymentSaleMaterialAdditional']['remaining'] - $this->PaymentSaleMaterialAdditional->data['PaymentSaleMaterialAdditional']['amount'];
                } else {
                    $remaining = $this->PaymentSaleMaterialAdditional->data['PaymentSaleMaterialAdditional']['total_invoice_amount'] - $this->PaymentSaleMaterialAdditional->data['PaymentSaleMaterialAdditional']['amount'];
                }
                $receiptNumber = $this->generateReceiptNumber($this->PaymentSaleMaterialAdditional->data['PaymentSaleMaterialAdditional']['material_additional_sale_id']);
                $this->PaymentSaleMaterialAdditional->data['PaymentSaleMaterialAdditional']['remaining'] = $remaining;
                $this->PaymentSaleMaterialAdditional->data['MaterialAdditionalSale']['total_remaining'] = $remaining;
                $this->PaymentSaleMaterialAdditional->data['PaymentSaleMaterialAdditional']['receipt_number'] = $receiptNumber;
                $transaction_date = $this->PaymentSaleMaterialAdditional->data['PaymentSaleMaterialAdditional']['payment_date'];
                unset($this->PaymentSaleMaterialAdditional->data['Dummy']);
                unset($this->PaymentSaleMaterialAdditional->data['Supplier']);
                
                try {
                    /* update to the Transaction Mutation Table */
                    $dataMaterialAdditionalSale = ClassRegistry::init("MaterialAdditionalSale")->find("first", [
                        "conditions" => [
                            "MaterialAdditionalSale.id" => $this->data['PaymentSaleMaterialAdditional']['material_additional_sale_id']
                        ],
                        "contain" => [
                            "Supplier" => [
                                "GeneralEntryType"
                            ]
                        ]
                    ]);
                    $transaction_name = $dataMaterialAdditionalSale['Supplier']['GeneralEntryType']['name'];
                    $transaction_type_id = 3;
                    $debit_or_credit_type = "debit";
                    $amount = $this->PaymentSaleMaterialAdditional->data['PaymentSaleMaterialAdditional']['amount'];
                    $relation_table_name = "material_additional_sale_id";
                    $relation_table_id = $dataMaterialAdditionalSale['MaterialAdditionalSale']['id'];
                    $initial_balance_id = $initialBalance['InitialBalance']['id'];
                    $initial_balance = $initialBalance['InitialBalance']['nominal'];
                    ClassRegistry::init("TransactionMutation")->post_transaction($receiptNumber, $transaction_name, $transaction_date, $transaction_type_id, $debit_or_credit_type, $amount, $relation_table_name, $relation_table_id, $initial_balance_id, $initial_balance, $mutation_balance);

                    // Update to the General Entry Table
                    $transaction_names = [$initialBalance['GeneralEntryType']['name'], $dataMaterialAdditionalSale['Supplier']['GeneralEntryType']['name']];
                    $debits_or_credits = ["debit", "credit"];
                    $general_entry_type_ids = [$initialBalance['GeneralEntryType']['id'], $dataMaterialAdditionalSale['Supplier']['GeneralEntryType']['id']];
                    $amounts = [$amount, $amount];
                    $general_entry_account_type_id = 2;
                    ClassRegistry::init("GeneralEntry")->post_to_journal($receiptNumber, $transaction_names, $debits_or_credits, $transaction_date, $transaction_type_id, $general_entry_type_ids, $amounts, $general_entry_account_type_id, $relation_table_name, $relation_table_id, $initial_balance_id, $initial_balance, $mutation_balance);

                    // update latest balance of each COAs
                    ClassRegistry::init("GeneralEntryType")->increaseLatestBalance($initialBalance['GeneralEntryType']['id'], $amount);
                    ClassRegistry::init("GeneralEntryType")->increaseLatestBalance($dataMaterialAdditionalSale['Supplier']['GeneralEntryType']['id'], $amount);

                    $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
                    $this->Session->setFlash(__("Data berhasil disimpan"), 'default', array(), 'success');
                    $this->redirect(array('action' => 'admin_index'));
                } catch (Exception $ex) {
                    $this->Session->setFlash(__("Terjadi Kesalahan."), 'default', array(), 'danger');
                }
            } else {
                $this->validationErrors = $this->{ Inflector::classify($this->name) }->validationErrors;
                $this->Session->setFlash(__("Harap mengecek kembali kesalahan dibawah."), 'default', array(), 'danger');
            }
        }
    }

    function generateReceiptNumber($material_additional_sale_id) {
        $inc_id = 1;
        $currentYear = date("Y");
        $numOfPayment = $this->PaymentSaleMaterialAdditional->find("count", ["conditions" => ["PaymentSaleMaterialAdditional.material_additional_sale_id" => $material_additional_sale_id]]);
        $latestNumOfPaymentInRoman = romanic_number($numOfPayment);
        if (!empty($numOfPayment)) {
            $currentNumOfPaymentInRoman = romanic_number($numOfPayment + 1);
        } else {
            $currentNumOfPaymentInRoman = romanic_number(1);
        }
        $lastRecord = $this->PaymentSaleMaterialAdditional->find("all");
        $inc_id = count($lastRecord) + 1;
        $inc_id = sprintf("%03d", $inc_id);
        $code = "KW-Sale-MP/$inc_id/$currentNumOfPaymentInRoman/$currentYear";
        return $code;
    }

    function admin_print_material_additional_sale_receipt($id = null) {
        $rows = $this->{ Inflector::classify($this->name) }->find('first', array(
            'conditions' => array(
                Inflector::classify($this->name) . '.id' => $id,
            ),
            'contain' => [
                "MaterialAdditionalSale" => [
                    "Supplier"
                ],
            ],
        ));
        $this->data = $rows;
        $data = array(
            'title' => 'Kwitansi Penjualan Material Pembantu',
            'rows' => $rows,
        );
        $this->set(compact('data'));
        $this->_activePrint(["print"], "print_payment_material_additional_sale_receipt", "kwitansi");
    }

    function admin_get_data_invoice($material_additional_sale_id = null) {
        $this->autoRender = false;
        if ($this->request->is("GET")) {
            $data = $this->PaymentSaleMaterialAdditional->find("first", [
                "conditions" => [
                    "PaymentSaleMaterialAdditional.material_additional_sale_id" => $material_additional_sale_id
                ],
                'recursive' => -1
            ]);
            return json_encode($data);
        } else {
            return json_encode($this->_generateStatusCode(400));
        }
    }

    function admin_list() {
        $this->autoRender = false;
        $conds = [];
        if (isset($this->request->query['q'])) {
            $q = $this->request->query['q'];
            $conds[] = array(
                "or" => array(
                    "PaymentSaleMaterialAdditional.receipt_number like" => "%$q%",
            ));
        }
        $suggestions = ClassRegistry::init("PaymentSaleMaterialAdditional")->find("all", array(
            "conditions" => [
                $conds,
            ],
            "contain" => [
                "MaterialAdditionalSale" => [
                    "Supplier",
                ],
            ],
            "limit" => 10,
        ));
        $result = [];
        foreach ($suggestions as $item) {
            if (!empty($item)) {
                if ($item['MaterialAdditionalSale']['branch_office_id'] == $this->Session->read("credential.admin.Employee.branch_office_id")) {
                    $result[] = [
                        "id" => @$item['PaymentSaleMaterialAdditional']['id'],
                        "receipt_number" => @$item['PaymentSaleMaterialAdditional']['receipt_number'],
                        "amount" => @$item['PaymentSaleMaterialAdditional']['amount'],
                        "supplier_name" => @$item['MaterialAdditionalSale']['Supplier']['name'],
                    ];
                }
            }
        }
        echo json_encode($result);
    }

    function admin_index() {
        $this->_activePrint(func_get_args(), "data_penerimaan_piutang_penjualan_material_pembantu");
        $this->_setPeriodeLaporanDate("awal_PaymentSaleMaterialAdditional_payment_date", "akhir_PaymentSaleMaterialAdditional_payment_date");
        $this->conds = [
            "MaterialAdditionalSale.branch_office_id" => $this->stnAdmin->roleBranchId()
        ];
        parent::admin_index();
    }

}
