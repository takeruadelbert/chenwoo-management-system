<?php

App::uses('AppController', 'Controller');

class PaymentSalesController extends AppController {

    var $name = "PaymentSales";
    var $disabledAction = array(
    );
    var $contain = [
        "PaymentType",
        "Sale" => [
            "BranchOffice",
            "Buyer"
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
        $this->set("buyerTypes", ClassRegistry::init("BuyerType")->find("list", array("fields" => array("BuyerType.id", "BuyerType.name"))));
        $this->set("paymentTypes", $this->PaymentSale->PaymentType->find("list", ["fields" => ["PaymentType.id", "PaymentType.name"]]));
        $this->set("productSizes", ClassRegistry::init("ProductSize")->find("list", ["fields" => ["ProductSize.id", "ProductSize.name"]]));
        $this->set("products", ClassRegistry::init("Product")->find("list", ["fields" => ["Product.id", "Product.name"]]));
        $this->set("initialBalances", $this->PaymentSale->InitialBalance->find("list", [
                    "fields" => [
                        "InitialBalance.id",
                        "GeneralEntryType.name"
                    ],
                    "conditions" => [
                        "InitialBalance.currency_id" => 2,
                        "GeneralEntryType.parent_id" => [2, 3, 4]
                    ],
                    "contain" => [
                        "GeneralEntryType"
                    ]
        ]));
        $this->set("initialBalanceRupiahs", $this->PaymentSale->InitialBalance->find("list", [
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
        $this->set("branchOffices", $this->PaymentSale->Sale->BranchOffice->find("list", array("fields" => array("BranchOffice.id", "BranchOffice.name"))));
    }

    function admin_debt_list() {
        $conds = [];
        $still_in_debt = [];
        $data_invoices = $this->PaymentPurchase->find("all", [
            "conditions" => [
                "PaymentPurchase.remaining <=" => 0,
            ],
        ]);
        foreach ($data_invoices as $k => $temp) {
            $still_in_debt[$k] = $temp['PaymentPurchase']['transaction_entry_id'];
        }
        foreach ($still_in_debt as $debt) {
            $conds = [
                "PaymentPurchase.transaction_entry_id !=" => $debt
            ];
        }
        $conds[] = $this->_filter($_GET, $this->filterCond);
        $conds['AND'] = am($conds, array(
                ), $this->conds);
        if ($this->order === false) {
            $this->order = Inflector::classify($this->name) . '.created desc';
        }
        $this->Paginator->settings = array(
            Inflector::classify($this->name) => array(
                'conditions' => $conds,
                'limit' => $this->paginate['limit'],
                'maxLimit' => $this->paginate['maxLimit'],
                'order' => $this->order,
                'recursive' => -1,
                'contain' => $this->contain,
            )
        );
        $rows = $this->Paginator->paginate($this->{ Inflector::classify($this->name) });
        $data = array(
            'rows' => $rows,
        );
        $this->set(compact('data'));
    }

    function admin_payment_sale_setup() {
        if ($this->request->is("post")) {
            $this->{ Inflector::classify($this->name) }->set($this->data);
            if ($this->data["Buyer"]["buyer_type_id"] == 1) {
                $this->redirect(array('action' => 'admin_add_local'));
            } else if ($this->data["Buyer"]["buyer_type_id"] == 2) {
                $this->redirect(array('action' => 'admin_add_export'));
            }
        }
    }

    function admin_add_export() {
        if ($this->request->is("post")) {
            $this->{ Inflector::classify($this->name) }->set($this->data);
            if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                $dataInvoice = $this->PaymentSale->find("first", [
                    "conditions" => [
                        "PaymentSale.sale_id" => $this->data['PaymentSale']['sale_id']
                    ],
                    "order" => "PaymentSale.id DESC",
                ]);
                $this->PaymentSale->data['Sale']['id'] = $this->data['PaymentSale']['sale_id'];
                $initialBalance = ClassRegistry::init("InitialBalance")->find("first", [
                    "conditions" => [
                        "InitialBalance.id" => $this->data['PaymentSale']['initial_balance_id'],
                    ],
                    "contain" => [
                        "GeneralEntryType"
                    ]
                ]);
                $this->PaymentSale->data['InitialBalance']['id'] = $this->data['PaymentSale']['initial_balance_id'];
                $totalInvoiceAmount = str_replace(",", "", $this->PaymentSale->data['PaymentSale']['total_invoice_amount']);
                if ($this->data['PaymentSale']['shipment_payment_type_id'] == 1) {
                    if (empty($dataInvoice)) {
                        $remaining = $totalInvoiceAmount - $this->PaymentSale->data['PaymentSale']['amount'];
                        $this->PaymentSale->data['PaymentSale']['remaining'] = $remaining;
                        $this->PaymentSale->data['Sale']['remaining'] = $remaining;
                    } else {
                        $remaining = $dataInvoice['PaymentSale']['remaining'] - $this->PaymentSale->data['PaymentSale']['amount'];
                        $this->PaymentSale->data['PaymentSale']['remaining'] = $remaining;
                        $this->PaymentSale->data['Sale']['remaining'] = $remaining;
                    }
                    $this->PaymentSale->data['InitialBalance']['nominal'] = $initialBalance['InitialBalance']['nominal'] + $this->PaymentSale->data['PaymentSale']['amount'];
                } else if ($this->data['PaymentSale']['shipment_payment_type_id'] == 2) {
                    if (empty($dataInvoice)) {
                        $remaining = $totalInvoiceAmount - $this->PaymentSale->data['PaymentSale']['amount'];
                        $this->PaymentSale->data['PaymentSale']['remaining'] = $remaining;
                        $this->PaymentSale->data['Sale']['remaining'] = $remaining;
                        $this->PaymentSale->data['InitialBalance']['nominal'] = $initialBalance['InitialBalance']['nominal'] + $this->PaymentSale->data['PaymentSale']['amount'];
                    } else {
                        $remaining = $dataInvoice['PaymentSale']['remaining'] - $this->PaymentSale->data['PaymentSale']['amount'];
                        $this->PaymentSale->data['PaymentSale']['remaining'] = $remaining;
                        $this->PaymentSale->data['Sale']['remaining'] = $remaining;
                        $this->PaymentSale->data['InitialBalance']['nominal'] = $initialBalance['InitialBalance']['nominal'] + $this->PaymentSale->data['PaymentSale']['amount'];
                    }
                }
                $this->PaymentSale->data['PaymentSale']['receipt_number'] = $this->generateReceiptNumber($this->PaymentSale->data['PaymentSale']['sale_id']);
                $transaction_date = $this->PaymentSale->data['PaymentSale']['payment_date'];
                
                $note = strip_tags($this->PaymentSale->data['PaymentSale']['note']);
                        
                $updatedData = [];
                $updatedData['GeneralEntryType']['id'] = $initialBalance['GeneralEntryType']['id'];
                $updatedData['GeneralEntryType']['latest_balance'] = $this->PaymentSale->data['InitialBalance']['nominal'];
                ClassRegistry::init("GeneralEntryType")->saveAll($updatedData);

                /* update to the general entries table */
                $receiptNumber = $this->generateReceiptNumber($this->PaymentSale->data['PaymentSale']['sale_id']);
                $this->PaymentSale->data['GeneralEntry'][0]['reference_number'] = $receiptNumber;
                $this->PaymentSale->data['GeneralEntry'][0]['transaction_name'] = $initialBalance['GeneralEntryType']['name'] . " - " . $note;
                $this->PaymentSale->data['GeneralEntry'][0]['transaction_date'] = $transaction_date;
                $this->PaymentSale->data['GeneralEntry'][0]['transaction_type_id'] = 3;
                $this->PaymentSale->data['GeneralEntry'][0]['general_entry_type_id'] = $initialBalance['GeneralEntryType']['id'];
                $this->PaymentSale->data['GeneralEntry'][0]['debit'] = $this->PaymentSale->data['PaymentSale']['amount'];
                $this->PaymentSale->data['GeneralEntry'][0]['initial_balance'] = $initialBalance['InitialBalance']['nominal'];
                $this->PaymentSale->data['GeneralEntry'][0]['mutation_balance'] = $this->PaymentSale->data['InitialBalance']['nominal'];
                $this->PaymentSale->data['GeneralEntry'][0]['initial_balance_id'] = $initialBalance['InitialBalance']['id'];
                $this->PaymentSale->data['GeneralEntry'][0]['general_entry_account_type_id'] = 2;
                $this->PaymentSale->data['GeneralEntry'][1]['reference_number'] = $receiptNumber;
                $this->PaymentSale->data['GeneralEntry'][1]['transaction_name'] = "Piutang Export " . $note;
                $this->PaymentSale->data['GeneralEntry'][1]['transaction_date'] = $transaction_date;
                $this->PaymentSale->data['GeneralEntry'][1]['transaction_type_id'] = 3;
                $this->PaymentSale->data['GeneralEntry'][1]['general_entry_type_id'] = 34;
                $this->PaymentSale->data['GeneralEntry'][1]['credit'] = $this->PaymentSale->data['PaymentSale']['amount'];
                $this->PaymentSale->data['GeneralEntry'][1]['initial_balance'] = $initialBalance['InitialBalance']['nominal'];
                $this->PaymentSale->data['GeneralEntry'][1]['mutation_balance'] = $this->PaymentSale->data['InitialBalance']['nominal'];
                $this->PaymentSale->data['GeneralEntry'][1]['initial_balance_id'] = $initialBalance['InitialBalance']['id'];
                $this->PaymentSale->data['GeneralEntry'][1]['general_entry_account_type_id'] = 2;
                $dataPaymentSale = $this->PaymentSale->find("count", [
                    "conditions" => [
                        "PaymentSale.sale_id" => $this->data['PaymentSale']['sale_id']
                    ]
                ]);
                $dataSale = $this->PaymentSale->Sale->find("first", [
                    "conditions" => [
                        "Sale.id" => $this->data['PaymentSale']['sale_id']
                    ]
                ]);
//                if ($dataPaymentSale == 0) {
//                    $this->PaymentSale->data['GeneralEntry'][2]['reference_number'] = $receiptNumber;
//                    $this->PaymentSale->data['GeneralEntry'][2]['transaction_name'] = "Biaya Freight Kapal dan Pesawat";
//                    $this->PaymentSale->data['GeneralEntry'][2]['transaction_date'] = date("Y-m-d");
//                    $this->PaymentSale->data['GeneralEntry'][2]['transaction_type_id'] = 3;
//                    $this->PaymentSale->data['GeneralEntry'][2]['general_entry_type_id'] = 20;
//                    $this->PaymentSale->data['GeneralEntry'][2]['debit'] = $dataSale['Sale']['shipping_cost'];
//                    $this->PaymentSale->data['GeneralEntry'][2]['initial_balance'] = $initialBalance['InitialBalance']['nominal'];
//                    $this->PaymentSale->data['GeneralEntry'][2]['mutation_balance'] = $this->PaymentSale->data['InitialBalance']['nominal'];
//                    $this->PaymentSale->data['GeneralEntry'][2]['initial_balance_id'] = $initialBalance['InitialBalance']['id'];
//                    $this->PaymentSale->data['GeneralEntry'][2]['general_entry_account_type_id'] = 2;
//                    $this->PaymentSale->data['GeneralEntry'][3]['reference_number'] = $receiptNumber;
//                    $this->PaymentSale->data['GeneralEntry'][3]['transaction_name'] = "Kas Besar (USD)";
//                    $this->PaymentSale->data['GeneralEntry'][3]['transaction_date'] = date("Y-m-d");
//                    $this->PaymentSale->data['GeneralEntry'][3]['transaction_type_id'] = 3;
//                    $this->PaymentSale->data['GeneralEntry'][3]['general_entry_type_id'] = 4;
//                    $this->PaymentSale->data['GeneralEntry'][3]['credit'] = $dataSale['Sale']['shipping_cost'];
//                    $this->PaymentSale->data['GeneralEntry'][3]['initial_balance'] = $initialBalance['InitialBalance']['nominal'];
//                    $this->PaymentSale->data['GeneralEntry'][3]['mutation_balance'] = $this->PaymentSale->data['InitialBalance']['nominal'];
//                    $this->PaymentSale->data['GeneralEntry'][3]['initial_balance_id'] = $initialBalance['InitialBalance']['id'];
//                    $this->PaymentSale->data['GeneralEntry'][3]['general_entry_account_type_id'] = 2;
//                }

                /* updating to the Transaction Mutation Table */
                $this->PaymentSale->data['TransactionMutation']['reference_number'] = $receiptNumber;
                $this->PaymentSale->data['TransactionMutation']['transaction_name'] = "Piutang Export " . $note;
                $this->PaymentSale->data['TransactionMutation']['transaction_date'] = $transaction_date;
                $this->PaymentSale->data['TransactionMutation']['transaction_type_id'] = 3;
                $this->PaymentSale->data['TransactionMutation']['debit'] = $this->PaymentSale->data['PaymentSale']['amount'];
                $this->PaymentSale->data['TransactionMutation']['initial_balance'] = $initialBalance['InitialBalance']['nominal'];
                $this->PaymentSale->data['TransactionMutation']['mutation_balance'] = $this->PaymentSale->data['InitialBalance']['nominal'];
                $this->PaymentSale->data['TransactionMutation']['initial_balance_id'] = $initialBalance['InitialBalance']['id'];

                $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
                $this->Session->setFlash(__("Data berhasil disimpan"), 'default', array(), 'success');
                $this->redirect(array('action' => 'admin_index'));
            } else {
                $this->validationErrors = $this->{ Inflector::classify($this->name) }->validationErrors;
                $this->Session->setFlash(__("Harap mengecek kembali kesalahan dibawah."), 'default', array(), 'danger');
            }
        }
    }

    function admin_add_local() {
        if ($this->request->is("post")) {
            $this->{ Inflector::classify($this->name) }->set($this->data);
            if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                $dataInvoice = $this->PaymentSale->find("first", [
                    "conditions" => [
                        "PaymentSale.sale_id" => $this->data['PaymentSale']['sale_id']
                    ],
                    "order" => "PaymentSale.id DESC",
                ]);
                $this->PaymentSale->data['Sale']['id'] = $this->data['PaymentSale']['sale_id'];
                $this->PaymentSale->_numberSeperatorRemover();
                $initialBalance = ClassRegistry::init("InitialBalance")->find("first", [
                    "conditions" => [
                        "InitialBalance.id" => $this->data['PaymentSale']['initial_balance_id'],
                    ],
                    "contain" => [
                        "GeneralEntryType"
                    ]
                ]);
                $this->PaymentSale->data['InitialBalance']['id'] = $this->data['PaymentSale']['initial_balance_id'];

                if ($this->data['PaymentSale']['shipment_payment_type_id'] == 1) {
                    if (empty($dataInvoice)) {
                        $remaining = $this->PaymentSale->data['PaymentSale']['total_invoice_amount'] - $this->PaymentSale->data['PaymentSale']['amount'];
                        $this->PaymentSale->data['PaymentSale']['remaining'] = $remaining;
                        $this->PaymentSale->data['Sale']['remaining'] = $remaining;
                    } else {
                        $remaining = $dataInvoice['PaymentSale']['remaining'] - $this->PaymentSale->data['PaymentSale']['amount'];
                        $this->PaymentSale->data['PaymentSale']['remaining'] = $remaining;
                        $this->PaymentSale->data['Sale']['remaining'] = $remaining;
                    }
                    $this->PaymentSale->data['InitialBalance']['nominal'] = $initialBalance['InitialBalance']['nominal'] + $this->PaymentSale->data['PaymentSale']['amount'];
                } else if ($this->data['PaymentSale']['shipment_payment_type_id'] == 2) {
                    if (empty($dataInvoice)) {
                        $remaining = $this->PaymentSale->data['PaymentSale']['total_invoice_amount'] - $this->PaymentSale->data['PaymentSale']['amount'];
                        $this->PaymentSale->data['PaymentSale']['remaining'] = $remaining;
                        $this->PaymentSale->data['Sale']['remaining'] = $remaining;
//                        $shipmentCost = $this->data['PaymentSale']['shipping_cost'];
                        $this->PaymentSale->data['InitialBalance']['nominal'] = $initialBalance['InitialBalance']['nominal'] + $this->PaymentSale->data['PaymentSale']['amount'];
                    } else {
                        $remaining = $dataInvoice['PaymentSale']['remaining'] - $this->PaymentSale->data['PaymentSale']['amount'];
                        $this->PaymentSale->data['PaymentSale']['remaining'] = $remaining;
                        $this->PaymentSale->data['Sale']['remaining'] = $remaining;
                        $this->PaymentSale->data['InitialBalance']['nominal'] = $initialBalance['InitialBalance']['nominal'] + $this->PaymentSale->data['PaymentSale']['amount'];
                    }
                }

                $this->PaymentSale->data['PaymentSale']['receipt_number'] = $this->generateReceiptNumber($this->PaymentSale->data['PaymentSale']['sale_id']);
                $transaction_date = $this->PaymentSale->data['PaymentSale']['payment_date'];
                
                $note = strip_tags($this->PaymentSale->data['PaymentSale']['note']);
                        
                /* update to the general entries table */
                $receiptNumber = $this->generateReceiptNumber($this->PaymentSale->data['PaymentSale']['sale_id']);
                $this->PaymentSale->data['GeneralEntry'][0]['reference_number'] = $receiptNumber;
                $this->PaymentSale->data['GeneralEntry'][0]['transaction_name'] = $initialBalance['GeneralEntryType']['name'] . " - " . $note;
                $this->PaymentSale->data['GeneralEntry'][0]['transaction_date'] = $transaction_date;
                $this->PaymentSale->data['GeneralEntry'][0]['transaction_type_id'] = 3;
                $this->PaymentSale->data['GeneralEntry'][0]['general_entry_type_id'] = $initialBalance['GeneralEntryType']['id'];
                $this->PaymentSale->data['GeneralEntry'][0]['debit'] = $this->PaymentSale->data['PaymentSale']['amount'];
                $this->PaymentSale->data['GeneralEntry'][0]['initial_balance'] = $initialBalance['InitialBalance']['nominal'];
                $this->PaymentSale->data['GeneralEntry'][0]['mutation_balance'] = $this->PaymentSale->data['InitialBalance']['nominal'];
                $this->PaymentSale->data['GeneralEntry'][0]['initial_balance_id'] = $initialBalance['InitialBalance']['id'];
                $this->PaymentSale->data['GeneralEntry'][0]['general_entry_account_type_id'] = 2;
                $this->PaymentSale->data['GeneralEntry'][1]['reference_number'] = $receiptNumber;
                $this->PaymentSale->data['GeneralEntry'][1]['transaction_name'] = "Piutang Lokal " . $note;
                $this->PaymentSale->data['GeneralEntry'][1]['transaction_date'] = $transaction_date;
                $this->PaymentSale->data['GeneralEntry'][1]['transaction_type_id'] = 3;
                $this->PaymentSale->data['GeneralEntry'][1]['general_entry_type_id'] = 39;
                $this->PaymentSale->data['GeneralEntry'][1]['credit'] = $this->PaymentSale->data['PaymentSale']['amount'];
                $this->PaymentSale->data['GeneralEntry'][1]['initial_balance'] = $initialBalance['InitialBalance']['nominal'];
                $this->PaymentSale->data['GeneralEntry'][1]['mutation_balance'] = $this->PaymentSale->data['InitialBalance']['nominal'];
                $this->PaymentSale->data['GeneralEntry'][1]['initial_balance_id'] = $initialBalance['InitialBalance']['id'];
                $this->PaymentSale->data['GeneralEntry'][1]['general_entry_account_type_id'] = 2;

                /* updating to the Transaction Mutation Table */
                $this->PaymentSale->data['TransactionMutation']['reference_number'] = $receiptNumber;
                $this->PaymentSale->data['TransactionMutation']['transaction_name'] = "Piutang Lokal " . $note;
                $this->PaymentSale->data['TransactionMutation']['transaction_date'] = $transaction_date;
                $this->PaymentSale->data['TransactionMutation']['transaction_type_id'] = 3;
                $this->PaymentSale->data['TransactionMutation']['debit'] = $this->PaymentSale->data['PaymentSale']['amount'];
                $this->PaymentSale->data['TransactionMutation']['initial_balance'] = $initialBalance['InitialBalance']['nominal'];
                $this->PaymentSale->data['TransactionMutation']['mutation_balance'] = $this->PaymentSale->data['InitialBalance']['nominal'];
                $this->PaymentSale->data['TransactionMutation']['initial_balance_id'] = $initialBalance['InitialBalance']['id'];
//                $dataPaymentSale = $this->PaymentSale->find("count", [
//                    "conditions" => [
//                        "PaymentSale.sale_id" => $this->data['PaymentSale']['sale_id']
//                    ]
//                ]);
//                $dataSale = $this->PaymentSale->Sale->find("first", [
//                    "conditions" => [
//                        "Sale.id" => $this->data['PaymentSale']['sale_id']
//                    ]
//                ]);
//                if ($dataPaymentSale == 0) {
//                    $this->PaymentSale->data['GeneralEntry'][2]['reference_number'] = $receiptNumber;
//                    $this->PaymentSale->data['GeneralEntry'][2]['transaction_name'] = "Biaya Freight Kapal dan Pesawat";
//                    $this->PaymentSale->data['GeneralEntry'][2]['transaction_date'] = date("Y-m-d");
//                    $this->PaymentSale->data['GeneralEntry'][2]['transaction_type_id'] = 3;
//                    $this->PaymentSale->data['GeneralEntry'][2]['general_entry_type_id'] = 20;
//                    $this->PaymentSale->data['GeneralEntry'][2]['debit'] = $dataSale['Sale']['shipping_cost'];
//                    $this->PaymentSale->data['GeneralEntry'][2]['initial_balance'] = $initialBalance['InitialBalance']['nominal'];
//                    $this->PaymentSale->data['GeneralEntry'][2]['mutation_balance'] = $this->PaymentSale->data['InitialBalance']['nominal'];
//                    $this->PaymentSale->data['GeneralEntry'][2]['initial_balance_id'] = $initialBalance['InitialBalance']['id'];
//                    $this->PaymentSale->data['GeneralEntry'][2]['general_entry_account_type_id'] = 2;
//                    $this->PaymentSale->data['GeneralEntry'][3]['reference_number'] = $receiptNumber;
//                    $this->PaymentSale->data['GeneralEntry'][3]['transaction_name'] = "Kas Besar (USD)";
//                    $this->PaymentSale->data['GeneralEntry'][3]['transaction_date'] = date("Y-m-d");
//                    $this->PaymentSale->data['GeneralEntry'][3]['transaction_type_id'] = 3;
//                    $this->PaymentSale->data['GeneralEntry'][3]['general_entry_type_id'] = 4;
//                    $this->PaymentSale->data['GeneralEntry'][3]['credit'] = $dataSale['Sale']['shipping_cost'];
//                    $this->PaymentSale->data['GeneralEntry'][3]['initial_balance'] = $initialBalance['InitialBalance']['nominal'];
//                    $this->PaymentSale->data['GeneralEntry'][3]['mutation_balance'] = $this->PaymentSale->data['InitialBalance']['nominal'];
//                    $this->PaymentSale->data['GeneralEntry'][3]['initial_balance_id'] = $initialBalance['InitialBalance']['id'];
//                    $this->PaymentSale->data['GeneralEntry'][3]['general_entry_account_type_id'] = 2;
//                }
                $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
                $this->Session->setFlash(__("Data berhasil disimpan"), 'default', array(), 'success');
                $this->redirect(array('action' => 'admin_index'));
            } else {
                $this->validationErrors = $this->{ Inflector::classify($this->name) }->validationErrors;
                $this->Session->setFlash(__("Harap mengecek kembali kesalahan dibawah."), 'default', array(), 'danger');
            }
        }
    }

    function generateReceiptNumber($saleId) {
        $inc_id = 1;
        $currentYear = date("Y");
        $numOfPayment = $this->PaymentSale->find("count", ["conditions" => ["PaymentSale.sale_id" => $saleId]]);
        $latestNumOfPaymentInRoman = romanic_number($numOfPayment);
        if (!empty($numOfPayment)) {
            $currentNumOfPaymentInRoman = romanic_number($numOfPayment + 1);
        } else {
            $currentNumOfPaymentInRoman = romanic_number(1);
        }
        $lastRecord = $this->PaymentSale->find("all");
        $inc_id = count($lastRecord) + 1;
        $inc_id = sprintf("%03d", $inc_id);
        $code = "KW-Sale/$inc_id/$currentNumOfPaymentInRoman/$currentYear";
        return $code;
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

    function admin_print_sale_receipt($id = null) {
        $rows = $this->{ Inflector::classify($this->name) }->find('first', array(
            'conditions' => array(
                Inflector::classify($this->name) . '.id' => $id,
            ),
            'contain' => [
                "Sale" => [
                    "Buyer"
                ],
            ],
        ));
        $this->data = $rows;
        $data = array(
            'title' => 'Kwitansi Penjualan',
            'rows' => $rows,
        );
        $this->set(compact('data'));
        $this->_activePrint(["print"], "print_sale_receipt", "kwitansi");
    }

    function admin_print_sale_receipt_export($id = null) {
        $rows = $this->{ Inflector::classify($this->name) }->find('first', array(
            'conditions' => array(
                Inflector::classify($this->name) . '.id' => $id,
            ),
            'contain' => [
                "Sale" => [
                    "Buyer"
                ],
            ],
        ));
        $this->data = $rows;
        $data = array(
            'title' => 'Sale Receipt',
            'rows' => $rows,
        );
        $this->set(compact('data'));
        $this->_activePrint(["print"], "print_sale_receipt_export", "kwitansi");
    }

    function get_data_invoice($saleId = null) {
        $this->autoRender = false;
        if ($this->request->is("GET")) {
            $data = $this->PaymentSale->find("first", [
                "conditions" => [
                    "PaymentSale.sale_id" => $saleId
                ],
                "order" => "PaymentSale.id DESC",
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
                    "PaymentSale.receipt_number like" => "%$q%",
            ));
        }
        $suggestions = ClassRegistry::init("PaymentSale")->find("all", array(
            "conditions" => [
                $conds,
            ],
            "contain" => [
                "Sale" => [
                    "Buyer",
                ],
            ],
            "limit"=>10,
        ));
        $result = [];
        foreach ($suggestions as $item) {
            if (!empty($item)) {
                if ($item['Sale']['branch_office_id'] == $this->Session->read("credential.admin.Employee.branch_office_id")) {
                    $result[] = [
                        "id" => @$item['PaymentSale']['id'],
                        "receipt_number" => @$item['PaymentSale']['receipt_number'],
                        "amount" => @$item['PaymentSale']['amount'],
                        "company_name" => @$item['Sale']['Buyer']['company_name'],
                    ];
                }
            }
        }
        echo json_encode($result);
    }

    function admin_index() {
        $this->_activePrint(func_get_args(), "data_tagihan_penjualan");
        $conds = [];
        if (isset($this->request->query)) {
            if (!empty($this->request->query['start_date'])) {
                $startDate = $this->request->query['start_date'];
                $newStartDate = date("Y-m-d H:i:s", strtotime($startDate));
                $conds[] = [
                    "DATE_FORMAT(PaymentSale.created, '%Y-%m-%d %H:%i:%s') >=" => $newStartDate
                ];
                unset($_GET['start_date']);
            }
            if (!empty($this->request->query['end_date'])) {
                $endDate = $this->request->query['end_date'];
                $newEndDate = date("Y-m-d H:i:s", strtotime($endDate));
                $conds[] = [
                    "DATE_FORMAT(PaymentSale.created, '%Y-%m-%d %H:%i:%s') <=" => $newEndDate
                ];
                unset($_GET['end_date']);
            }
        }
        $this->conds = [
            $conds
        ];
        parent::admin_index();
    }

}
