<?php

App::uses('AppController', 'Controller');

class TransactionMutationsController extends AppController {

    var $name = "TransactionMutations";
    var $disabledAction = array(
    );
    var $contain = [
    ];

    function beforeFilter() {
        parent::beforeFilter();
        $this->_setPageInfo("admin_index", "");
        $this->_setPageInfo("admin_add", "");
        $this->_setPageInfo("admin_edit", "");
        $this->_setPageInfo("admin_view", "");
    }

    function beforeRender() {
        $this->_options();
        parent::beforeRender();
    }

    function _options() {
        $this->set("initialBalances", ClassRegistry::init("InitialBalance")->find("list", [
            "fields" => [
                "InitialBalance.id", 
                "GeneralEntryType.name"
            ],
            "conditions" => [
                "GeneralEntryType.parent_id" => [2,3,4]
            ],
            "contain" => [
                "GeneralEntryType"
            ]
        ]));
    }

    function admin_ledger() {
        $conds = [];
        $currentMonth = date("m");
        $conds[] = [
            "MONTH(TransactionMutation.transaction_date)" => $currentMonth
        ];
        if (!empty($this->request->query['start_date']) && empty($this->request->query['end_date'])) {
            $startDate = $this->request->query['start_date'];
            $conds[] = [
                "DATE_FORMAT(TransactionMutation.transaction_date, '%Y-%m-%d') >=" => $startDate
            ];
            unset($_GET['start_date']);
        }
        if (empty($this->request->query['start_date']) && !empty($this->request->query['end_date'])) {
            $endDate = $this->request->query['end_date'];
            $conds[] = [
                "DATE_FORMAT(TransactionMutation.transaction_date, '%Y-%m-%d') <=" => $endDate
            ];
            unset($_GET['end_date']);
        }
        if (!empty($this->request->query['start_date']) && !empty($this->request->query['end_date'])) {
            $startDate = $this->request->query['start_date'];
            $endDate = $this->request->query['end_date'];
            $conds[] = [
                "DATE_FORMAT(TransactionMutation.transaction_date, '%Y-%m-%d') >=" => $startDate,
                "DATE_FORMAT(TransactionMutation.transaction_date, '%Y-%m-%d') <=" => $endDate
            ];
            unset($_GET['start_date']);
            unset($_GET['end_date']);
        }
        $dataTransactions = $this->TransactionMutation->find("all", [
            "conditions" => [
                $conds
            ],
            "order" => [
                "TransactionMutation.transaction_date",
                "TransactionType.id"
            ],
        ]);
        $dataCashIn = $this->TransactionMutation->find("all", [
            "conditions" => [
                "TransactionMutation.transaction_type_id" => 1,
                $conds
            ],
            "order" => [
                "TransactionMutation.transaction_date",
                "TransactionMutation.id"
            ]
        ]);
        $dataCashOut = $this->TransactionMutation->find("all", [
            "conditions" => [
                "TransactionMutation.transaction_type_id" => 2,
                $conds
            ],
            "order" => [
                "TransactionMutation.transaction_date",
                "TransactionMutation.id"
            ]
        ]);
        $dataPaymentSale = $this->TransactionMutation->find("all", [
            "conditions" => [
                "TransactionMutation.transaction_type_id" => 3,
                $conds
            ],
            "order" => [
                "TransactionMutation.transaction_date",
                "TransactionMutation.id"
            ]
        ]);
        $dataPaymentPurchase = $this->TransactionMutation->find("all", [
            "conditions" => [
                "TransactionMutation.transaction_type_id" => 4,
                $conds
            ],
            "order" => [
                "TransactionMutation.transaction_date",
                "TransactionMutation.id"
            ]
        ]);
        $dataCashMutation = $this->TransactionMutation->find("all", [
            "conditions" => [
                "TransactionMutation.transaction_type_id" => 5,
                $conds
            ],
            "order" => [
                "TransactionMutation.transaction_date",
                "TransactionMutation.id"
            ]
        ]);
        $this->set(compact("startDate"));
        $this->set(compact("endDate"));
        $this->set(compact("dataTransactions"));
        $this->set(compact("dataCashIn"));
        $this->set(compact("dataCashOut"));
        $this->set(compact("dataPaymentSale"));
        $this->set(compact("dataPaymentPurchase"));
        $this->set(compact("dataCashMutation"));
        $this->_activePrint(func_get_args(), "data_buku_besar", "print_no_border");
    }

    function admin_cash_flow_statement() {
        $conds = [];
        if (isset($this->request->query['select_TransactionMutation_initial_balance_id']) && !empty($this->request->query['select_TransactionMutation_initial_balance_id'])) {
//            if ($this->request->query['TransactionMutation_initial_balance_id']) {
//                $conds[] = [
//                    "TransactionMutation.initial_balance_id" => $this->request->query['TransactionMutation_initial_balance_id']
//                ];
//            }
            if (!empty($this->request->query['start_date'])) {
                $startDate = $this->request->query['start_date'];
                $conds[] = [
                    "DATE_FORMAT(TransactionMutation.transaction_date, '%Y-%m-%d') >=" => $startDate
                ];
                unset($_GET['start_date']);
            }
            if (!empty($this->request->query['end_date'])) {
                $endDate = $this->request->query['end_date'];
                $conds[] = [
                    "DATE_FORMAT(TransactionMutation.transaction_date, '%Y-%m-%d') <=" => $endDate
                ];
                unset($_GET['end_date']);
            }
            $rows = $this->{ Inflector::classify($this->name) }->find('all', array(
                'conditions' => array(
                    $conds,
                    "TransactionMutation.initial_balance_id !=" => null,
                    "TransactionMutation.initial_balance_id" => $this->request->query['select_TransactionMutation_initial_balance_id'],
                    "TransactionMutation.initial_balance !=" => null,
                    "TransactionMutation.mutation_balance !=" => null
                ),
                'order' => [
                    "TransactionMutation.id",
                    "TransactionMutation.transaction_date"
                ],
                "contain" => [
                    "EmployeeSalary" => [
                        "Employee",
                        "ParameterEmployeeSalary"
                    ],
                    "Shipment" => [
                        "Sale" => [
                            "Buyer"
                        ]
                    ]
                ]
            ));
            $this->data = $rows;

            $data = array(
                'title' => 'LAPORAN ARUS KAS RANGKUMAN',
                'rows' => $rows,
            );
            $dataCurrency = ClassRegistry::init("InitialBalance")->find("first", [
                "conditions" => [
                    "InitialBalance.id" => $this->request->query['select_TransactionMutation_initial_balance_id']
                ],
                "contain" => [
                    "Currency"
                ]
            ]);
            $currency_type = $dataCurrency['Currency']['id'];
            if($currency_type == 1) {
                $currency = "Rp.";
            } else {
                $currency = "$";
            }
            $this->set(compact('data', 'currency', 'currency_type'));
            $this->_activePrint(["print"], "print_laporan_arus_kas_rangkuman", "print_arus_kas");
        }
    }

    function admin_cash_flow_detail_statement() {
        $conds = [];
        if (!empty($this->request->query['select_TransactionMutation_initial_balance_id'])) {
//            $conds[] = [
//                "TransactionMutation.initial_balance_id" => $this->request->query['TransactionMutation_initial_balance_id']
//            ];
            if (!empty($this->request->query['start_date'])) {
                $startDate = $this->request->query['start_date'];
                $conds[] = [
                    "DATE_FORMAT(TransactionMutation.transaction_date, '%Y-%m-%d') >=" => $startDate
                ];
                unset($_GET['start_date']);
            }

            if (!empty($this->request->query['end_date'])) {
                $endDate = $this->request->query['end_date'];
                $conds[] = [
                    "DATE_FORMAT(TransactionMutation.transaction_date, '%Y-%m-%d') <=" => $endDate
                ];
                unset($_GET['end_date']);
            }

            $rows = $this->{ Inflector::classify($this->name) }->find('all', array(
                'conditions' => array(
                    $conds,
                    "TransactionMutation.initial_balance_id !=" => null,
                    "TransactionMutation.initial_balance_id" => $this->request->query['select_TransactionMutation_initial_balance_id'],
                    "TransactionMutation.initial_balance !=" => null,
                    "TransactionMutation.mutation_balance !=" => null
                ),
                'order' => [
                    "TransactionMutation.id",
                    "TransactionMutation.transaction_date"
                ],
                "contain" => [
                    "Shipment" => [
                        "Sale" => [
                            "Buyer"
                        ]
                    ]
                ]
            ));
            $this->data = $rows;

            $data = array(
                'title' => 'LAPORAN ARUS KAS RINCIAN',
                'rows' => $rows,
            );
            $dataDailySalary = $this->{ Inflector::classify($this->name) }->find('all', array(
                'conditions' => array(
                    "TransactionMutation.transaction_type_id" => 6,
                    "TransactionMutation.transaction_name" => "Biaya Gaji Buruh Harian (Tenaga Kerja Langsung)",
                    "TransactionMutation.initial_balance_id" => $this->request->query['select_TransactionMutation_initial_balance_id'],
                    $conds
                ),
                "contain" => [
                    "EmployeeSalary" => [
                        "Employee",
                        "ParameterEmployeeSalary"
                    ]
                ]
            ));
            $dataMonthlySalary = $this->{ Inflector::classify($this->name) }->find('all', array(
                'conditions' => array(
                    "TransactionMutation.transaction_type_id" => 6,
                    "TransactionMutation.transaction_name" => "Biaya Gaji Direksi dan Karyawan",
                    "TransactionMutation.initial_balance_id" => $this->request->query['select_TransactionMutation_initial_balance_id'],
                    $conds
                ),
                "contain" => [
                    "EmployeeSalary" => [
                        "Employee",
                        "ParameterEmployeeSalary"
                    ]
                ]
            ));
            $dataCurrency = ClassRegistry::init("InitialBalance")->find("first", [
                "conditions" => [
                    "InitialBalance.id" => $this->request->query['select_TransactionMutation_initial_balance_id']
                ],
                "contain" => [
                    "Currency"
                ]
            ]);
            $currency_type = $dataCurrency['Currency']['id'];
            if($currency_type == 1) {
                $currency = "Rp.";
            } else {
                $currency = "$";
            }
            $this->set(compact('data', "dataDailySalary", "dataMonthlySalary", "currency", "currency_type"));
            $this->_activePrint(["print"], "print_laporan_arus_kas_detail", "print_cash_flow_detail_statement");
        }
    }

    function admin_trial_balance() {
        $conds = [];
        $currentMonth = date("m");
        if (!empty($this->request->query)) {
            if ($this->request->query['start_date']) {
                $startDate = $this->request->query['start_date'];
                $conds[] = [
                    "DATE_FORMAT(TransactionMutation.transaction_date, '%Y-%m-%d') >=" => $startDate
                ];
                unset($_GET['start_date']);
            }
            if ($this->request->query['end_date']) {
                $endDate = $this->request->query['end_date'];
                $conds[] = [
                    "DATE_FORMAT(TransactionMutation.transaction_date, '%Y-%m-%d') <=" => $endDate
                ];
                unset($_GET['end_date']);
            }
            $rows = $this->{ Inflector::classify($this->name) }->find('all', array(
                'conditions' => array(
                    $conds
                ),
                'order' => [
                    "TransactionMutation.id",
                    "TransactionMutation.transaction_date"
                ]
            ));
            $this->data = $rows;

            $data = array(
                'title' => 'NERACA SALDO',
                'rows' => $rows,
            );
            $this->set(compact('data'));
            $this->_activePrint(["print"], "print_neraca_saldo", "print_neraca_saldo");
        }
    }

//    function admin_income_statement() {
//        $conds = [];
//        if (isset($this->request->query['start_date']) && !empty($this->request->query['end_date'])) {
//            if ($this->request->query['start_date']) {
//                $startDate = $this->request->query['start_date'];
//                $conds[] = [
//                    "DATE_FORMAT(TransactionMutation.transaction_date, '%Y-%m-%d') >=" => $startDate
//                ];
//                unset($_GET['start_date']);
//            }
//
//            if ($this->request->query['end_date']) {
//                $endDate = $this->request->query['end_date'];
//                $conds[] = [
//                    "DATE_FORMAT(TransactionMutation.transaction_date, '%Y-%m-%d') <=" => $endDate
//                ];
//                unset($_GET['end_date']);
//            }
//
//            $dataCashIn = $this->TransactionMutation->find("all", [
//                "conditions" => [
//                    "TransactionMutation.transaction_type_id" => 1,
//                    $conds
//                ]
//            ]);
//            $totalCashIn = 0;
//            foreach ($dataCashIn as $cashIn) {
//                $totalCashIn += $cashIn['TransactionMutation']['debit'];
//            }
//
//            $dataCashDisbursement = $this->TransactionMutation->find("all", [
//                "conditions" => [
//                    "TransactionMutation.transaction_type_id" => 2,
//                    $conds
//                ]
//            ]);
//            $totalCashDisbursement = 0;
//            foreach ($dataCashDisbursement as $cashDisbursement) {
//                $totalCashDisbursement += $cashDisbursement['TransactionMutation']['credit'];
//            }
//
//            $dataPaymentSale = $this->TransactionMutation->find("all", [
//                "conditions" => [
//                    "TransactionMutation.transaction_type_id" => 3,
//                    $conds
//                ]
//            ]);
//            $totalPaymentSale = 0;
//            foreach ($dataPaymentSale as $paymentSale) {
//                $totalPaymentSale += $paymentSale['TransactionMutation']['debit'] * $paymentSale['PaymentSale']['exchange_rate'];
//            }
//
//            $dataPaymentPurchase = $this->TransactionMutation->find("all", [
//                "conditions" => [
//                    "TransactionMutation.transaction_type_id" => 4,
//                    $conds
//                ]
//            ]);
//            $totalPaymentPurchase = 0;
//            foreach ($dataPaymentPurchase as $paymentPurchase) {
//                $totalPaymentPurchase += $paymentPurchase['TransactionMutation']['credit'];
//            }
//
//            $dataEmployeeSalary = $this->TransactionMutation->find("all", [
//                "conditions" => [
//                    "TransactionMutation.transaction_type_id" => 6,
//                    $conds
//                ]
//            ]);
//            $totalEmployeeSalary = 0;
//            foreach ($dataEmployeeSalary as $employeeSalary) {
//                $totalEmployeeSalary += $employeeSalary['TransactionMutation']['credit'];
//            }
//
//            $this->set(compact("totalCashIn", "totalCashDisbursement", "totalPaymentSale", "totalPaymentPurchase", "totalEmployeeSalary", "currentMonth"));
//        }
//    }

//    function admin_annual_income_statement() {
//        $conds = [];
//        $currentYear = date("Y");
//        if (!empty($this->request->query['year'])) {
//            $conds[] = [
//                "YEAR(TransactionMutation.transaction_date)" => $this->request->query['year']
//            ];
//        } else {
//            $conds[] = [
//                "YEAR(TransactionMutation.transaction_date)" => $currentYear
//            ];
//        }
//        $dataCashIn = $this->TransactionMutation->find("all", [
//            "conditions" => [
//                "TransactionMutation.transaction_type_id" => 1,
//                $conds
//            ]
//        ]);
//        $totalCashIn = 0;
//        foreach ($dataCashIn as $cashIn) {
//            $totalCashIn += $cashIn['TransactionMutation']['debit'];
//        }
//
//        $dataCashDisbursement = $this->TransactionMutation->find("all", [
//            "conditions" => [
//                "TransactionMutation.transaction_type_id" => 2,
//                $conds
//            ]
//        ]);
//        $totalCashDisbursement = 0;
//        foreach ($dataCashDisbursement as $cashDisbursement) {
//            $totalCashDisbursement += $cashDisbursement['TransactionMutation']['credit'];
//        }
//
//        $dataPaymentSale = $this->TransactionMutation->find("all", [
//            "conditions" => [
//                "TransactionMutation.transaction_type_id" => 3,
//                $conds
//            ]
//        ]);
//        $totalPaymentSale = 0;
//        foreach ($dataPaymentSale as $paymentSale) {
//            $totalPaymentSale += $paymentSale['TransactionMutation']['debit'] * $paymentSale['PaymentSale']['exchange_rate'];
//        }
//
//        $dataPaymentPurchase = $this->TransactionMutation->find("all", [
//            "conditions" => [
//                "TransactionMutation.transaction_type_id" => 4,
//                $conds
//            ]
//        ]);
//        $totalPaymentPurchase = 0;
//        foreach ($dataPaymentPurchase as $paymentPurchase) {
//            $totalPaymentPurchase += $paymentPurchase['TransactionMutation']['credit'];
//        }
//
//        $dataEmployeeSalary = $this->TransactionMutation->find("all", [
//            "conditions" => [
//                "TransactionMutation.transaction_type_id" => 6,
//                $conds
//            ]
//        ]);
//        $totalEmployeeSalary = 0;
//        foreach ($dataEmployeeSalary as $employeeSalary) {
//            $totalEmployeeSalary += $employeeSalary['TransactionMutation']['credit'];
//        }
//
//        $view = new View($this);
//        $html = $view->loadHelper('Html');
//        $annualLength = 12;
//        $dataAnnualTotalCashIn = [];
//        $i = 1;
//        for ($v = 0; $v < $annualLength; $v++) {
//            $totalAmount = 0;
//            $temp = $this->TransactionMutation->find("all", [
//                "conditions" => [
//                    "TransactionMutation.transaction_type_id" => 1,
//                    "MONTH(TransactionMutation.transaction_date)" => $i,
//                    $conds
//                ]
//            ]);
//            foreach ($temp as $amounts) {
//                $totalAmount += $amounts['TransactionMutation']['debit'];
//            }
//            $dataAnnualTotalCashIn[$v] = [
//                [
//                    $html->getNamaBulan($i),
//                    $totalAmount
//                ]
//            ];
//            $i++;
//        }
//
//        $dataAnnualTotalCashDisbursement = [];
//        $i = 1;
//        for ($v = 0; $v < $annualLength; $v++) {
//            $totalAmount = 0;
//            $temp = $this->TransactionMutation->find("all", [
//                "conditions" => [
//                    "TransactionMutation.transaction_type_id" => 2,
//                    "MONTH(TransactionMutation.transaction_date)" => $i,
//                    $conds
//                ]
//            ]);
//            foreach ($temp as $amounts) {
//                $totalAmount += $amounts['TransactionMutation']['credit'];
//            }
//            $dataAnnualTotalCashDisbursement[$v] = [
//                [
//                    $html->getNamaBulan($i),
//                    $totalAmount
//                ]
//            ];
//            $i++;
//        }
//
//        $dataAnnualTotalPaymentSale = [];
//        $i = 1;
//        for ($v = 0; $v < $annualLength; $v++) {
//            $totalAmount = 0;
//            $temp = $this->TransactionMutation->find("all", [
//                "conditions" => [
//                    "TransactionMutation.transaction_type_id" => 3,
//                    "MONTH(TransactionMutation.transaction_date)" => $i,
//                    $conds
//                ]
//            ]);
//            foreach ($temp as $amounts) {
//                $totalAmount += $amounts['TransactionMutation']['debit'] * $amounts['PaymentSale']['exchange_rate'];
//            }
//            $dataAnnualTotalPaymentSale[$v] = [
//                [
//                    $html->getNamaBulan($i),
//                    $totalAmount
//                ]
//            ];
//            $i++;
//        }
//
//        $dataAnnualTotalPaymentPurchase = [];
//        $i = 1;
//        for ($v = 0; $v < $annualLength; $v++) {
//            $totalAmount = 0;
//            $temp = $this->TransactionMutation->find("all", [
//                "conditions" => [
//                    "TransactionMutation.transaction_type_id" => 4,
//                    "MONTH(TransactionMutation.transaction_date)" => $i,
//                    $conds
//                ]
//            ]);
//            foreach ($temp as $amounts) {
//                $totalAmount += $amounts['TransactionMutation']['credit'];
//            }
//            $dataAnnualTotalPaymentPurchase[$v] = [
//                [
//                    $html->getNamaBulan($i),
//                    $totalAmount
//                ]
//            ];
//            $i++;
//        }
//
//        $dataAnnualTotalEmployeeSalary = [];
//        $i = 1;
//        for ($v = 0; $v < $annualLength; $v++) {
//            $totalAmount = 0;
//            $temp = $this->TransactionMutation->find("all", [
//                "conditions" => [
//                    "TransactionMutation.transaction_type_id" => 6,
//                    "MONTH(TransactionMutation.transaction_date)" => $i,
//                    $conds
//                ]
//            ]);
//            foreach ($temp as $amounts) {
//                $totalAmount += $amounts['TransactionMutation']['credit'];
//            }
//            $dataAnnualTotalEmployeeSalary[$v] = [
//                [
//                    $html->getNamaBulan($i),
//                    $totalAmount
//                ]
//            ];
//            $i++;
//        }
//
//        $this->set(compact("totalCashIn", "totalCashDisbursement", "totalPaymentSale", "totalPaymentPurchase", "totalEmployeeSalary", "currentYear"));
//        $this->set(compact("dataAnnualTotalCashIn", "dataAnnualTotalCashDisbursement", "dataAnnualTotalPaymentSale", "dataAnnualTotalPaymentPurchase", "dataAnnualTotalEmployeeSalary"));
//    }
}