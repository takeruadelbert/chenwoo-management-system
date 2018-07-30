<?php

App::uses('AppController', 'Controller');

class PaymentPurchasesController extends AppController {

    var $name = "PaymentPurchases";
    var $disabledAction = array(
    );
    var $contain = [
        "TransactionEntry" => [
            "MaterialEntry",
            "TransactionMaterialEntry",
            "Supplier"
        ],
        "PaymentType",
        "InitialBalance" => [
            "GeneralEntryType"
        ],
        "VerifyStatus",
        "Employee" => [
            "Account" => [
                "Biodata"
            ],
            "Department",
            "Office",
        ],
        "BranchOffice"
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
        $this->set("paymentTypes", $this->PaymentPurchase->PaymentType->find("list", ["fields" => ["PaymentType.id", "PaymentType.name"]]));
        $this->set("initialBalances", $this->PaymentPurchase->InitialBalance->find("list", ["fields" => ["InitialBalance.id", "GeneralEntryType.name"], "conditions" => ["InitialBalance.currency_id" => 1], "contain" => ["GeneralEntryType"]]));
        $this->set("branchOffices", $this->PaymentPurchase->BranchOffice->find("list", array("fields" => array("BranchOffice.id", "BranchOffice.name"))));
        $this->set("suppliers", $this->PaymentPurchase->TransactionEntry->Supplier->find("list", array("fields" => array("Supplier.id", "Supplier.name"))));
        $this->set("verifyStatuses", $this->PaymentPurchase->VerifyStatus->find("list", array("fields" => array("VerifyStatus.id", "VerifyStatus.name"))));
    }

    function admin_index() {
        $this->_activePrint(func_get_args(), "data_tagihan_pembelian");
        parent::admin_index();
    }

    function admin_index_validate() {
        $this->_activePrint(func_get_args(), "data_tagihan_pembelian_validasi");
        $this->conds = [
            "PaymentPurchase.verify_status_id" => 1,
            "PaymentPurchase.verified_by_id" => null
        ];
        parent::admin_index();
    }

    function admin_add() {
        if ($this->request->is("post")) {
            $this->{ Inflector::classify($this->name) }->set($this->data);
            if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                $this->{ Inflector::classify($this->name) }->data['PaymentPurchase']['verify_status_id'] = 1;
                $this->{ Inflector::classify($this->name) }->data['PaymentPurchase']['branch_office_id'] = $this->stnAdmin->getBranchId();
                $this->PaymentPurchase->_numberSeperatorRemover();
                $this->PaymentPurchase->data['PaymentPurchase']['receipt_number'] = $this->generateReceiptNumber($this->PaymentPurchase->data['PaymentPurchase']['transaction_entry_id']);
                $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
                $this->Session->setFlash(__("Data berhasil disimpan"), 'default', array(), 'success');
                $this->redirect(array('action' => 'admin_index'));
            } else {
                $this->validationErrors = $this->{ Inflector::classify($this->name) }->validationErrors;
                $this->Session->setFlash(__("Harap mengecek kembali kesalahan dibawah."), 'default', array(), 'danger');
            }
        }
    }

    function admin_payment_debt() {
        if ($this->request->is("post")) {
            $this->{ Inflector::classify($this->name) }->set($this->data);
            $this->PaymentPurchase->_numberSeperatorRemover();
            foreach ($this->PaymentPurchase->data['PaymentPurchase'] as $index => $paymentPurchases) {
                $this->PaymentPurchase->data['PaymentPurchase'][$index]['verify_status_id'] = 1;
                $this->PaymentPurchase->data['PaymentPurchase'][$index]['receipt_number'] = $this->generateReceiptNumber($paymentPurchases['transaction_entry_id']);
                $transactionEntry = ClassRegistry::init("TransactionEntry")->find("first", [
                    "conditions" => [
                        "TransactionEntry.id" => $paymentPurchases['transaction_entry_id'],
                    ],
                    "contain" => [
                        "Employee"
                    ]
                ]);
                $this->PaymentPurchase->data['PaymentPurchase'][$index]['branch_office_id'] = $transactionEntry['Employee']['branch_office_id'];
                $this->PaymentPurchase->data['PaymentPurchase'][$index]['employee_id'] = $this->Session->read("credential.admin.Employee.id");
                $this->PaymentPurchase->saveAll($this->PaymentPurchase->data['PaymentPurchase'][$index]);
            }
            $this->Session->setFlash(__("Data berhasil disimpan"), 'default', array(), 'success');
            $this->redirect(array('action' => 'admin_payment_debt_index', 'controller' => 'transaction_entries'));
        } else {
            $data_transaction_entry = $this->request->query['transaction_entry_ids'];
            $transaction_entry_ids = explode(",", $data_transaction_entry);
            $dataTransactionEntry = ClassRegistry::init("TransactionEntry")->find("all", [
                "conditions" => [
                    "TransactionEntry.id" => $transaction_entry_ids
                ],
                "contain" => [
                    "Supplier"
                ]
            ]);
            $this->set(compact('dataTransactionEntry'));
        }
    }

    function generateReceiptNumber($transactionId) {
        $inc_id = 1;
        $currentYear = date("Y");
        $numOfPayment = $this->PaymentPurchase->find("count", ["conditions" => ["PaymentPurchase.transaction_entry_id" => $transactionId]]);
        $latestNumOfPaymentInRoman = romanic_number($numOfPayment);
        if (!empty($numOfPayment)) {
            $currentNumOfPaymentInRoman = romanic_number($numOfPayment + 1);
        } else {
            $currentNumOfPaymentInRoman = romanic_number(1);
        }
        $lastRecord = $this->PaymentPurchase->find("all");
        $inc_id = count($lastRecord) + 1;
        $inc_id = sprintf("%03d", $inc_id);
        $code = "KW/$inc_id/$currentNumOfPaymentInRoman/$currentYear";
        return $code;
    }

    function get_data_invoice($transactionId = null) {
        $this->autoRender = false;
        if ($this->request->is("GET")) {
            $data = $this->PaymentPurchase->find("first", [
                "conditions" => [
                    "PaymentPurchase.transaction_entry_id" => $transactionId
                ],
                "order" => "PaymentPurchase.id DESC",
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

    function admin_print_purchase_receipt($id = null) {
        $rows = $this->{ Inflector::classify($this->name) }->find('first', array(
            'conditions' => array(
                Inflector::classify($this->name) . '.id' => $id,
            ),
            'contain' => [
                "TransactionEntry" => [
                    "TransactionMaterialEntry",
                    "Supplier"
                ],
            ],
        ));
        $this->data = $rows;
        $data = array(
            'title' => 'Kwitansi Pembelian',
            'rows' => $rows,
        );
        $this->set(compact('data'));
        $this->_activePrint(["print"], "print_purchase_receipt", "kwitansi");
    }

    function admin_list() {
        $this->autoRender = false;
        $conds = [];
        if (isset($this->request->query['q'])) {
            $q = $this->request->query['q'];
            $conds[] = array(
                "or" => array(
                    "PaymentPurchase.receipt_number like" => "%$q%",
            ));
        }
        $suggestions = ClassRegistry::init("PaymentPurchase")->find("all", array(
            "conditions" => [
                $conds,
            ],
            "contain" => [
                "TransactionEntry" => [
                    "TransactionMaterialEntry" => [
                        "MaterialDetail",
                        "MaterialSize"
                    ],
                    "Supplier"
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
                        "id" => @$item['PaymentPurchase']['id'],
                        "receipt_number" => @$item['PaymentPurchase']['receipt_number'],
                        "amount" => @$item['PaymentPurchase']['amount'],
                        "supplier" => @$item['TransactionEntry']['Supplier']['name'],
                    ];
                }
            }
        }
        echo json_encode($result);
    }

    function admin_change_status_verify() {
        $this->autoRender = false;
        if ($this->request->is("PUT")) {
            $this->PaymentPurchase->data['PaymentPurchase']['id'] = $this->request->data['id'];
            $this->PaymentPurchase->data['PaymentPurchase']['verify_status_id'] = $this->request->data['status'];
            if ($this->request->data['status'] == '3') {
                $this->PaymentPurchase->data['PaymentPurchase']['verified_by_id'] = $this->_getEmployeeId();
                $this->PaymentPurchase->data['PaymentPurchase']['verified_datetime'] = date("Y-m-d H:i:s");
                $idPaymentPurchase = ClassRegistry::init("PaymentPurchase")->find("first", [
                    "conditions" => [
                        "PaymentPurchase.id" => $this->request->data['id'],
                    ],
                    "contain" => [
                        "InitialBalance" => [
                            "GeneralEntryType"
                        ],
                    ]
                ]);
                $note = strip_tags($idPaymentPurchase['PaymentPurchase']['note']);
                $transaction_date = !empty($idPaymentPurchase['PaymentPurchase']['payment_date']) ? $idPaymentPurchase['PaymentPurchase']['payment_date'] : date("Y-m-d");
                $dataInvoice = $this->PaymentPurchase->find("first", [
                    "conditions" => [
                        "PaymentPurchase.transaction_entry_id" => $idPaymentPurchase['PaymentPurchase']['transaction_entry_id'],
                    ],
                    "order" => "PaymentPurchase.id DESC",
                ]);
                $this->PaymentPurchase->data['TransactionEntry']['id'] = $idPaymentPurchase['PaymentPurchase']['transaction_entry_id'];
                if (empty($dataInvoice)) {
                    $remaining = $idPaymentPurchase['PaymentPurchase']['total_invoice_amount'] - $idPaymentPurchase['PaymentPurchase']['amount'];
                    $this->PaymentPurchase->data['PaymentPurchase']['remaining'] = $remaining;
                    $this->PaymentPurchase->data['TransactionEntry']['remaining'] = $remaining;
                    if ($remaining == 0) {
                        $this->PaymentPurchase->data['TransactionEntry']['transaction_entry_status_id'] = 4;
                    }
                } else {
                    $remaining = $dataInvoice['PaymentPurchase']['remaining'] - $idPaymentPurchase['PaymentPurchase']['amount'];
                    $this->PaymentPurchase->data['PaymentPurchase']['remaining'] = $remaining;
                    $this->PaymentPurchase->data['TransactionEntry']['remaining'] = $remaining;
                    if ($remaining == 0) {
                        $this->PaymentPurchase->data['TransactionEntry']['transaction_entry_status_id'] = 4;
                    }
                }
                $initialBalance = ClassRegistry::init("InitialBalance")->find("first", [
                    "conditions" => [
                        "InitialBalance.id" => $idPaymentPurchase['PaymentPurchase']['initial_balance_id'],
                    ]
                ]);
                $this->PaymentPurchase->data['InitialBalance']['id'] = $idPaymentPurchase['PaymentPurchase']['initial_balance_id'];
                $mutation_balance = $initialBalance['InitialBalance']['nominal'] - $idPaymentPurchase['PaymentPurchase']['amount'];
                $this->PaymentPurchase->data['InitialBalance']['nominal'] = $mutation_balance;

                $updatedData = [];
                $updatedData['GeneralEntryType']['id'] = $initialBalance['GeneralEntryType']['id'];
                $updatedData['GeneralEntryType']['latest_balance'] = $mutation_balance;
                ClassRegistry::init("GeneralEntryType")->saveAll($updatedData);

                /* Updating to the General Entry Table */
                $hutang_dagang_id = 35;
                $generalEntryType = ClassRegistry::init("GeneralEntryType")->find("first", [
                    "conditions" => [
                        "GeneralEntryType.id" => $hutang_dagang_id
                    ]
                ]);
                $receiptNumber = $this->generateReceiptNumber($idPaymentPurchase['PaymentPurchase']['transaction_entry_id']);
                $this->PaymentPurchase->data['GeneralEntry'][0]['reference_number'] = $receiptNumber;
                $this->PaymentPurchase->data['GeneralEntry'][0]['transaction_name'] = $generalEntryType['GeneralEntryType']['name'] . " - " . $note;
                $this->PaymentPurchase->data['GeneralEntry'][0]['transaction_date'] = $transaction_date;
                $this->PaymentPurchase->data['GeneralEntry'][0]['transaction_type_id'] = 4;
                $this->PaymentPurchase->data['GeneralEntry'][0]['general_entry_type_id'] = $hutang_dagang_id;
                $this->PaymentPurchase->data['GeneralEntry'][0]['debit'] = $idPaymentPurchase['PaymentPurchase']['amount'];
                $this->PaymentPurchase->data['GeneralEntry'][0]['initial_balance'] = $initialBalance['InitialBalance']['nominal'];
                $this->PaymentPurchase->data['GeneralEntry'][0]['mutation_balance'] = $mutation_balance;
                $this->PaymentPurchase->data['GeneralEntry'][0]['initial_balance_id'] = $initialBalance['InitialBalance']['id'];
                $this->PaymentPurchase->data['GeneralEntry'][0]['general_entry_account_type_id'] = 1;
                $this->PaymentPurchase->data['GeneralEntry'][1]['reference_number'] = $receiptNumber;
                $this->PaymentPurchase->data['GeneralEntry'][1]['transaction_name'] = $idPaymentPurchase['InitialBalance']['GeneralEntryType']['name'] . " - " . $note;
                $this->PaymentPurchase->data['GeneralEntry'][1]['transaction_date'] = $transaction_date;
                $this->PaymentPurchase->data['GeneralEntry'][1]['transaction_type_id'] = 4;
                $this->PaymentPurchase->data['GeneralEntry'][1]['general_entry_type_id'] = $idPaymentPurchase['InitialBalance']['GeneralEntryType']['id'];
                $this->PaymentPurchase->data['GeneralEntry'][1]['credit'] = $idPaymentPurchase['PaymentPurchase']['amount'];
                $this->PaymentPurchase->data['GeneralEntry'][1]['initial_balance'] = $initialBalance['InitialBalance']['nominal'];
                $this->PaymentPurchase->data['GeneralEntry'][1]['mutation_balance'] = $mutation_balance;
                $this->PaymentPurchase->data['GeneralEntry'][1]['initial_balance_id'] = $initialBalance['InitialBalance']['id'];
                $this->PaymentPurchase->data['GeneralEntry'][1]['general_entry_account_type_id'] = 1;

                /* updating to the Transaction Mutation Table */
                $this->PaymentPurchase->data['TransactionMutation']['reference_number'] = $receiptNumber;
                $this->PaymentPurchase->data['TransactionMutation']['transaction_name'] = "Pengeluaran - " . $note;
                $this->PaymentPurchase->data['TransactionMutation']['transaction_date'] = $transaction_date;
                $this->PaymentPurchase->data['TransactionMutation']['transaction_type_id'] = 4;
                $this->PaymentPurchase->data['TransactionMutation']['credit'] = $idPaymentPurchase['PaymentPurchase']['amount'];
                $this->PaymentPurchase->data['TransactionMutation']['initial_balance'] = $initialBalance['InitialBalance']['nominal'];
                $this->PaymentPurchase->data['TransactionMutation']['mutation_balance'] = $mutation_balance;
                $this->PaymentPurchase->data['TransactionMutation']['initial_balance_id'] = $initialBalance['InitialBalance']['id'];
            } else if ($this->request->data['status'] == '2') {
                $this->PaymentPurchase->data['PaymentPurchase']['verified_by_id'] = $this->_getEmployeeId();
                $this->PaymentPurchase->data['PaymentPurchase']['verified_datetime'] = date("Y-m-d H:i:s");
            } else {
                $this->PaymentPurchase->data['PaymentPurchase']['verified_by_id'] = null;
                $this->PaymentPurchase->data['PaymentPurchase']['verified_datetime'] = null;
            }
            $this->PaymentPurchase->saveAll();
            $data = $this->PaymentPurchase->find("first", array("conditions" => array("PaymentPurchase.id" => $this->request->data['id']), "recursive" => 3));
            echo json_encode($this->_generateStatusCode(207, null, array("status_label" => $data['VerifyStatus']['name'])));
        } else {
            echo json_encode($this->_generateStatusCode(400));
        }
    }

}
