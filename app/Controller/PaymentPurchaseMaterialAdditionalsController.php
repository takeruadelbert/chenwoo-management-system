<?php

App::uses('AppController', 'Controller');

class PaymentPurchaseMaterialAdditionalsController extends AppController {

    var $name = "PaymentPurchaseMaterialAdditionals";
    var $disabledAction = array(
    );
    var $contain = [
        "PurchaseOrderMaterialAdditional" => [
            "PurchaseOrderMaterialAdditionalDetail",
            "MaterialAdditionalSupplier"
        ],
        "PaymentType",
        "InitialBalance" => [
            "GeneralEntryType"
        ],
        "BranchOffice",
        "VerifyStatus",
        "Employee" => [
            "Account" => [
                "Biodata"
            ]
        ],
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
        $this->set("paymentTypes", $this->PaymentPurchaseMaterialAdditional->PaymentType->find("list", ["fields" => ["PaymentType.id", "PaymentType.name"]]));
        $this->set("verifyStatuses", $this->PaymentPurchaseMaterialAdditional->VerifyStatus->find("list", array("fields" => array("VerifyStatus.id", "VerifyStatus.name"))));
        $this->set("initialBalances", $this->PaymentPurchaseMaterialAdditional->InitialBalance->find("list", ["fields" => ["InitialBalance.id", "GeneralEntryType.name"], "conditions" => ["InitialBalance.currency_id" => 1], "contain" => ["GeneralEntryType"]]));
        $this->set("branchOffices", $this->PaymentPurchaseMaterialAdditional->BranchOffice->find("list", array("fields" => array("BranchOffice.id", "BranchOffice.name"))));
        $this->set("suppliers", $this->PaymentPurchaseMaterialAdditional->PurchaseOrderMaterialAdditional->MaterialAdditionalSupplier->find("list", array("fields" => array("MaterialAdditionalSupplier.id", "MaterialAdditionalSupplier.name"))));
    }

    function admin_index() {
        $this->_activePrint(func_get_args(), "data_tagihan_pembelian_material_pembantu");
        parent::admin_index();
    }

    function admin_index_validate() {
        $this->_activePrint(func_get_args(), "data_tagihan_pembelian_material_pembantu_validasi");
        $this->conds = [
            "PaymentPurchaseMaterialAdditional.verify_status_id" => 1,
            "PaymentPurchaseMaterialAdditional.verified_by_id" => null
        ];
        parent::admin_index();
    }

    function admin_add() {
        if ($this->request->is("post")) {
            $this->{ Inflector::classify($this->name) }->set($this->data);
            if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                $this->{ Inflector::classify($this->name) }->data['PaymentPurchaseMaterialAdditional']['verify_status_id'] = 1;
                $this->PaymentPurchaseMaterialAdditional->_numberSeperatorRemover();
                $this->PaymentPurchaseMaterialAdditional->data['PaymentPurchaseMaterialAdditional']['receipt_number'] = $this->generateReceiptNumber($this->PaymentPurchaseMaterialAdditional->data['PaymentPurchaseMaterialAdditional']['purchase_order_material_additional_id']);
                $purchaseOrderMaterialAdditional = ClassRegistry::init("PurchaseOrderMaterialAdditional")->find("first", [
                    "conditions" => [
                        "PurchaseOrderMaterialAdditional.id" => $this->data['PaymentPurchaseMaterialAdditional']['purchase_order_material_additional_id'],
                    ],
                    "contain" => [
                        "Employee"
                    ]
                ]);
                $this->PaymentPurchaseMaterialAdditional->data['PaymentPurchaseMaterialAdditional']['branch_office_id'] = $purchaseOrderMaterialAdditional['Employee']['branch_office_id'];
                $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
                $this->Session->setFlash(__("Data berhasil disimpan"), 'default', array(), 'success');
                $this->redirect(array('action' => 'admin_index'));
            } else {
                $this->validationErrors = $this->{ Inflector::classify($this->name) }->validationErrors;
                $this->Session->setFlash(__("Harap mengecek kembali kesalahan dibawah."), 'default', array(), 'danger');
            }
        }
    }

    function generateReceiptNumber($transactionId) {
        $inc_id = 1;
        $currentYear = date("Y");
        $numOfPayment = $this->PaymentPurchaseMaterialAdditional->find("count", ["conditions" => ["PaymentPurchaseMaterialAdditional.purchase_order_material_additional_id" => $transactionId]]);
        $latestNumOfPaymentInRoman = romanic_number($numOfPayment);
        if (!empty($numOfPayment)) {
            $currentNumOfPaymentInRoman = romanic_number($numOfPayment + 1);
        } else {
            $currentNumOfPaymentInRoman = romanic_number(1);
        }
        $lastRecord = $this->PaymentPurchaseMaterialAdditional->find("all");
        $inc_id = count($lastRecord) + 1;
        $inc_id = sprintf("%03d", $inc_id);
        $code = "KW-Material_Pembantu/$inc_id/$currentNumOfPaymentInRoman/$currentYear";
        return $code;
    }

    function get_data_payment_purchase($po_id = null) {
        $this->autoRender = false;
        if ($this->request->is("GET")) {
            $data = $this->PaymentPurchaseMaterialAdditional->find("first", [
                "conditions" => [
                    "PaymentPurchaseMaterialAdditional.purchase_order_material_additional_id" => $po_id
                ],
                "order" => "PaymentPurchaseMaterialAdditional.id DESC",
            ]);
            return json_encode($data);
        } else {
            return json_encode($this->_generateStatusCode(400));
        }
    }

    /* source : http://stackoverflow.com/questions/6265596/how-to-convert-a-roman-numeral-to-integer-in-php */

    function convertRomanToNumber($roman) {
        $romans = array(
            'M' => 1000,
            'CM' => 900,
            'D' => 500,
            'CD' => 400,
            'C' => 100,
            'XC' => 90,
            'L' => 50,
            'XL' => 40,
            'X' => 10,
            'IX' => 9,
            'V' => 5,
            'IV' => 4,
            'I' => 1,
        );
        $result = 0;
        foreach ($romans as $key => $value) {
            while (strpos($roman, $key) === 0) {
                $result += $value;
                $roman = substr($roman, strlen($key));
            }
        }
        return $result;
    }

    function admin_print_purchase_material_additional_receipt($id = null) {
        $rows = $this->{ Inflector::classify($this->name) }->find('first', array(
            'conditions' => array(
                Inflector::classify($this->name) . '.id' => $id,
            ),
            'contain' => [
                "PurchaseOrderMaterialAdditional" => [
                    "PurchaseOrderMaterialAdditionalDetail",
                    "MaterialAdditionalSupplier"
                ],
            ],
        ));
        $this->data = $rows;
        $data = array(
            'title' => 'Kwitansi Pembelian',
            'rows' => $rows,
        );
        $this->set(compact('data'));
        $this->_activePrint(["print"], "print_purchase_material_additional_receipt", "kwitansi");
    }

    function admin_list() {
        $this->autoRender = false;
        $conds = [];
        if (isset($this->request->query['q'])) {
            $q = $this->request->query['q'];
            $conds[] = array(
                "or" => array(
                    "PaymentPurchaseMaterialAdditional.receipt_number like" => "%$q%",
            ));
        }
        $suggestions = ClassRegistry::init("PaymentPurchaseMaterialAdditional")->find("all", array(
            "conditions" => [
                $conds,
            ],
            "contain" => [
                "PurchaseOrderMaterialAdditional" => [
                    "PurchaseOrderMaterialAdditionalDetail",
                    "MaterialAdditionalSupplier"
                ],
                "BranchOffice"
            ],
            "limit"=>10,
        ));
        $result = [];
        foreach ($suggestions as $item) {
            if (!empty($item)) {
                if ($item['BranchOffice']['id'] == $this->Session->read("credential.admin.Employee.branch_office_id")) {
                    $result[] = [
                        "id" => @$item['PaymentPurchaseMaterialAdditional']['id'],
                        "receipt_number" => @$item['PaymentPurchaseMaterialAdditional']['receipt_number'],
                        "amount" => @$item['PaymentPurchaseMaterialAdditional']['amount'],
                        "supplier" => @$item['PurchaseOrderMaterialAdditional']['MaterialAdditionalSupplier']['name'],
                    ];
                }
            }
        }
        echo json_encode($result);
    }

    function admin_change_status_verify() {
        $this->autoRender = false;
        if ($this->request->is("PUT")) {
            $this->PaymentPurchaseMaterialAdditional->data['PaymentPurchaseMaterialAdditional']['id'] = $this->request->data['id'];
            $this->PaymentPurchaseMaterialAdditional->data['PaymentPurchaseMaterialAdditional']['verify_status_id'] = $this->request->data['status'];
            if ($this->request->data['status'] == '3') {
                $this->PaymentPurchaseMaterialAdditional->data['PaymentPurchaseMaterialAdditional']['verified_by_id'] = $this->_getEmployeeId();
                $this->PaymentPurchaseMaterialAdditional->data['PaymentPurchaseMaterialAdditional']['verified_datetime'] = date("Y-m-d H:i:s");
                $idPaymentPurchaseMaterialAdditional = ClassRegistry::init("PaymentPurchaseMaterialAdditional")->find("first", [
                    "conditions" => [
                        "PaymentPurchaseMaterialAdditional.id" => $this->request->data['id'],
                    ],
                    "contain" => [
                        "InitialBalance" => [
                            "GeneralEntryType"
                        ],
                        "PurchaseOrderMaterialAdditional"
                    ]
                ]);
                $note = strip_tags($idPaymentPurchaseMaterialAdditional['PaymentPurchaseMaterialAdditional']['note']);
                $dataInvoice = $this->PaymentPurchaseMaterialAdditional->find("first", [
                    "conditions" => [
                        "PaymentPurchaseMaterialAdditional.purchase_order_material_additional_id" => $idPaymentPurchaseMaterialAdditional['PaymentPurchaseMaterialAdditional']['purchase_order_material_additional_id'],
                    ],
                    "order" => "PaymentPurchaseMaterialAdditional.id DESC",
                ]);
                $this->PaymentPurchaseMaterialAdditional->data['PurchaseOrderMaterialAdditional']['id'] = $idPaymentPurchaseMaterialAdditional['PaymentPurchaseMaterialAdditional']['purchase_order_material_additional_id'];
                if (empty($dataInvoice)) {
                    $remaining = $idPaymentPurchaseMaterialAdditional['PaymentPurchaseMaterialAdditional']['total_amount'] - $idPaymentPurchaseMaterialAdditional['PaymentPurchaseMaterialAdditional']['amount'];
                    $this->PaymentPurchaseMaterialAdditional->data['PaymentPurchaseMaterialAdditional']['remaining'] = $remaining;
                    $this->PaymentPurchaseMaterialAdditional->data['PurchaseOrderMaterialAdditional']['remaining'] = $remaining;
                } else {
                    $remaining = $dataInvoice['PaymentPurchaseMaterialAdditional']['remaining'] - $idPaymentPurchaseMaterialAdditional['PaymentPurchaseMaterialAdditional']['amount'];
                    $this->PaymentPurchaseMaterialAdditional->data['PaymentPurchaseMaterialAdditional']['remaining'] = $remaining;
                    $this->PaymentPurchaseMaterialAdditional->data['PurchaseOrderMaterialAdditional']['remaining'] = $remaining;
                }
                $initialBalance = ClassRegistry::init("InitialBalance")->find("first", [
                    "conditions" => [
                        "InitialBalance.id" => $idPaymentPurchaseMaterialAdditional['PaymentPurchaseMaterialAdditional']['initial_balance_id'],
                    ],
                    "contain" => [
                        "GeneralEntryType"
                    ]
                ]);
                $this->PaymentPurchaseMaterialAdditional->data['InitialBalance']['id'] = $idPaymentPurchaseMaterialAdditional['PaymentPurchaseMaterialAdditional']['initial_balance_id'];
                $mutation_balance = $initialBalance['InitialBalance']['nominal'] - $idPaymentPurchaseMaterialAdditional['PaymentPurchaseMaterialAdditional']['amount'];
                $this->PaymentPurchaseMaterialAdditional->data['InitialBalance']['nominal'] = $mutation_balance;
                
                $updatedData = [];
                $updatedData['GeneralEntryType']['id'] = $initialBalance['GeneralEntryType']['id'];
                $updatedData['GeneralEntryType']['latest_balance'] = $mutation_balance;
                ClassRegistry::init("GeneralEntryType")->saveAll($updatedData);
                
                /* updating remaining of PO Material Additional table */
                $this->PaymentPurchaseMaterialAdditional->data['PurchaseOrderMaterialAdditional']['id'] = $idPaymentPurchaseMaterialAdditional['PurchaseOrderMaterialAdditional']['id'];
                $this->PaymentPurchaseMaterialAdditional->data['PurchaseOrderMaterialAdditional']['remaining'] = $remaining;

                /* Updating to the General Entry Table */
                $receiptNumber = $idPaymentPurchaseMaterialAdditional['PaymentPurchaseMaterialAdditional']['receipt_number'];
                $this->PaymentPurchaseMaterialAdditional->data['GeneralEntry'][0]['reference_number'] = $receiptNumber;
                $this->PaymentPurchaseMaterialAdditional->data['GeneralEntry'][0]['transaction_name'] = "Hutang Dagang - " . $note;
                $this->PaymentPurchaseMaterialAdditional->data['GeneralEntry'][0]['transaction_date'] = date("Y-m-d");
                $this->PaymentPurchaseMaterialAdditional->data['GeneralEntry'][0]['transaction_type_id'] = 4;
                $this->PaymentPurchaseMaterialAdditional->data['GeneralEntry'][0]['general_entry_type_id'] = 35;
                $this->PaymentPurchaseMaterialAdditional->data['GeneralEntry'][0]['debit'] = $idPaymentPurchaseMaterialAdditional['PaymentPurchaseMaterialAdditional']['amount'];
                $this->PaymentPurchaseMaterialAdditional->data['GeneralEntry'][0]['initial_balance'] = $initialBalance['InitialBalance']['nominal'];
                $this->PaymentPurchaseMaterialAdditional->data['GeneralEntry'][0]['mutation_balance'] = $mutation_balance;
                $this->PaymentPurchaseMaterialAdditional->data['GeneralEntry'][0]['initial_balance_id'] = $idPaymentPurchaseMaterialAdditional['PaymentPurchaseMaterialAdditional']['initial_balance_id'];
                $this->PaymentPurchaseMaterialAdditional->data['GeneralEntry'][0]['general_entry_account_type_id'] = 1;
                $this->PaymentPurchaseMaterialAdditional->data['GeneralEntry'][1]['reference_number'] = $receiptNumber;
                $this->PaymentPurchaseMaterialAdditional->data['GeneralEntry'][1]['transaction_name'] = $idPaymentPurchaseMaterialAdditional['InitialBalance']['GeneralEntryType']['name'] . " - " . $note;
                $this->PaymentPurchaseMaterialAdditional->data['GeneralEntry'][1]['transaction_date'] = date("Y-m-d");
                $this->PaymentPurchaseMaterialAdditional->data['GeneralEntry'][1]['transaction_type_id'] = 4;
                $this->PaymentPurchaseMaterialAdditional->data['GeneralEntry'][1]['general_entry_type_id'] = $initialBalance['GeneralEntryType']['id'];
                $this->PaymentPurchaseMaterialAdditional->data['GeneralEntry'][1]['credit'] = $idPaymentPurchaseMaterialAdditional['PaymentPurchaseMaterialAdditional']['amount'];
                $this->PaymentPurchaseMaterialAdditional->data['GeneralEntry'][1]['initial_balance'] = $initialBalance['InitialBalance']['nominal'];
                $this->PaymentPurchaseMaterialAdditional->data['GeneralEntry'][1]['mutation_balance'] = $mutation_balance;
                $this->PaymentPurchaseMaterialAdditional->data['GeneralEntry'][1]['initial_balance_id'] = $idPaymentPurchaseMaterialAdditional['PaymentPurchaseMaterialAdditional']['initial_balance_id'];
                $this->PaymentPurchaseMaterialAdditional->data['GeneralEntry'][1]['general_entry_account_type_id'] = 1;
                
                /* posting to Transaction Mutation Table */
                $this->PaymentPurchaseMaterialAdditional->data['TransactionMutation']['initial_balance_id'] = $idPaymentPurchaseMaterialAdditional['PaymentPurchaseMaterialAdditional']['initial_balance_id'];
                $this->PaymentPurchaseMaterialAdditional->data['TransactionMutation']['reference_number'] = $receiptNumber;
                $this->PaymentPurchaseMaterialAdditional->data['TransactionMutation']['transaction_name'] = "Transaksi Pembelian - " . $note;
                $this->PaymentPurchaseMaterialAdditional->data['TransactionMutation']['credit'] = $idPaymentPurchaseMaterialAdditional['PaymentPurchaseMaterialAdditional']['amount'];
                $this->PaymentPurchaseMaterialAdditional->data['TransactionMutation']['transaction_date'] = date("Y-m-d");
                $this->PaymentPurchaseMaterialAdditional->data['TransactionMutation']['initial_balance'] = $initialBalance['InitialBalance']['nominal'];
                $this->PaymentPurchaseMaterialAdditional->data['TransactionMutation']['mutation_balance'] = $mutation_balance;
                $this->PaymentPurchaseMaterialAdditional->data['TransactionMutation']['transaction_type_id'] = 4;
            } else if ($this->request->data['status'] == '2') {
                $this->PaymentPurchaseMaterialAdditional->data['PaymentPurchaseMaterialAdditional']['verified_by_id'] = $this->_getEmployeeId();
                $this->PaymentPurchaseMaterialAdditional->data['PaymentPurchaseMaterialAdditional']['verified_datetime'] = date("Y-m-d H:i:s");
            } else {
                $this->PaymentPurchaseMaterialAdditional->data['PaymentPurchaseMaterialAdditional']['verified_by_id'] = null;
                $this->PaymentPurchaseMaterialAdditional->data['PaymentPurchaseMaterialAdditional']['verified_datetime'] = null;
            }
            $this->PaymentPurchaseMaterialAdditional->saveAll();
            $data = $this->PaymentPurchaseMaterialAdditional->find("first", array("conditions" => array("PaymentPurchaseMaterialAdditional.id" => $this->request->data['id']), "recursive" => 3));
            echo json_encode($this->_generateStatusCode(207, null, array("status_label" => $data['VerifyStatus']['name'])));
        } else {
            echo json_encode($this->_generateStatusCode(400));
        }
    }
    
    function admin_payment_debt_material_additional() {
        if ($this->request->is("post")) {
            $this->{ Inflector::classify($this->name) }->set($this->data);
            $this->PaymentPurchaseMaterialAdditional->_numberSeperatorRemover();
            foreach ($this->PaymentPurchaseMaterialAdditional->data['PaymentPurchaseMaterialAdditional'] as $index => $paymentPurchases) {
                $this->PaymentPurchaseMaterialAdditional->data['PaymentPurchaseMaterialAdditional'][$index]['verify_status_id'] = 1;
                $this->PaymentPurchaseMaterialAdditional->data['PaymentPurchaseMaterialAdditional'][$index]['receipt_number'] = $this->generateReceiptNumber($paymentPurchases['purchase_order_material_additional_id']);
                $transactionEntry = ClassRegistry::init("PurchaseOrderMaterialAdditional")->find("first", [
                    "conditions" => [
                        "PurchaseOrderMaterialAdditional.id" => $paymentPurchases['purchase_order_material_additional_id'],
                    ],
                    "contain" => [
                        "Employee"
                    ]
                ]);
                $this->PaymentPurchaseMaterialAdditional->data['PaymentPurchaseMaterialAdditional'][$index]['branch_office_id'] = $transactionEntry['Employee']['branch_office_id'];
                $this->PaymentPurchaseMaterialAdditional->data['PaymentPurchaseMaterialAdditional'][$index]['employee_id'] = $this->Session->read("credential.admin.Employee.id");
                $this->PaymentPurchaseMaterialAdditional->saveAll($this->PaymentPurchaseMaterialAdditional->data['PaymentPurchaseMaterialAdditional'][$index]);
            }
            $this->Session->setFlash(__("Data berhasil disimpan"), 'default', array(), 'success');
            $this->redirect(array('action' => 'admin_payment_debt_material_additional_index', 'controller' => 'purchase_order_material_additionals'));
        } else {
            $data_transaction_entry = $this->request->query['po_material_additional_ids'];
            $transaction_entry_ids = explode(",", $data_transaction_entry);
            $dataPOMaterialAdditional = ClassRegistry::init("PurchaseOrderMaterialAdditional")->find("all", [
                "conditions" => [
                    "PurchaseOrderMaterialAdditional.id" => $transaction_entry_ids
                ],
                "contain" => [
                    "MaterialAdditionalSupplier"
                ]
            ]);
            $this->set(compact('dataPOMaterialAdditional'));
        }
    }
}