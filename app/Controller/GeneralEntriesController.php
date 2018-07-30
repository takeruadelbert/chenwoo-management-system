<?php

App::uses('AppController', 'Controller');

class GeneralEntriesController extends AppController {

    var $name = "GeneralEntries";
    var $disabledAction = array(
    );
    var $contain = [
        "CashIn",
        "CashDisbursement",
        "PaymentPurchase",
        "PaymentSale" => [
            "Sale"
        ],
        "CashMutation",
        "TransactionType",
        "EmployeeSalary",
        "GeneralEntryType",
        "InitialBalance" => [
            "Currency"
        ],
        "Shipment" => [
            "Sale" => [
                "Buyer"
            ]
        ]
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
        $this->set("transactionTypes", $this->GeneralEntry->TransactionType->find("list", ["fields" => ["TransactionType.id", "TransactionType.name"]]));
        $this->set("initialBalances", $this->GeneralEntry->GeneralEntryType->find("list", [
                    "fields" => [
                        "GeneralEntryType.id",
                        "GeneralEntryType.name"
                    ],
                    "conditions" => [
                        "GeneralEntryType.parent_id" => [2, 3, 4]
                    ]
        ]));
        $this->set("generalEntryAccountTypes", ClassRegistry::init("GeneralEntryAccountType")->find("list", ["fields" => ["GeneralEntryAccountType.id", "GeneralEntryAccountType.full_name"]]));
        $generalEntryTypes = ClassRegistry::init("GeneralEntryType")->listWithFullLabel();
        $this->set(compact("generalEntryTypes"));
    }

    function admin_index() {
        $conds = [];
        $today = date("Y-m-d");
        $currentMonth = date("m");
        $currentYear = date("Y");
        $defaultConds = [
            "DATE_FORMAT(GeneralEntry.transaction_date, '%Y-%m-%d')" => $today
        ];
        if (!empty($this->request->query['start_date']) && empty($this->request->query['end_date'])) {
            $defaultConds = [];
            $startDate = $this->request->query['start_date'];
            $conds[] = [
                "DATE_FORMAT(GeneralEntry.transaction_date, '%Y-%m-%d') >=" => $startDate
            ];
            unset($_GET['start_date']);
        }
        if (empty($this->request->query['start_date']) && !empty($this->request->query['end_date'])) {
            $defaultConds = [];
            $endDate = $this->request->query['end_date'];
            $conds[] = [
                "DATE_FORMAT(GeneralEntry.transaction_date, '%Y-%m-%d') <=" => $endDate
            ];
            unset($_GET['end_date']);
        }
        if (!empty($this->request->query['start_date']) && !empty($this->request->query['end_date'])) {
            $defaultConds = [];
            $startDate = $this->request->query['start_date'];
            $endDate = $this->request->query['end_date'];
            $conds[] = [
                "DATE_FORMAT(GeneralEntry.transaction_date, '%Y-%m-%d') >=" => $startDate,
                "DATE_FORMAT(GeneralEntry.transaction_date, '%Y-%m-%d') <=" => $endDate
            ];
            unset($_GET['start_date']);
            unset($_GET['end_date']);
        }
        $generalEntries = $this->GeneralEntry->find("all", [
            "conditions" => [
                $conds,
                $defaultConds
            ],
            "order" => [
//                "GeneralEntry.id",
                "GeneralEntry.transaction_date"
            ],
            "contain" => [
                "CashIn",
                "CashDisbursement",
                "PaymentPurchase",
                "PaymentSale" => [
                    "Sale"
                ],
                "CashMutation",
                "TransactionType",
                "EmployeeSalary",
                "GeneralEntryType",
                "InitialBalance" => [
                    "Currency"
                ],
                "Sale",
                "Shipment" => [
                    "Sale" => [
                        "Buyer"
                    ]
                ]
            ]
        ]);
        $this->set(compact("generalEntries", "startDate", "endDate", "currentMonth", "currentYear"));
        $this->_activePrint(func_get_args(), "print_transaksi_jurnal_umum", ["excel" => "excel", "print" => "print_transaksi_jurnal_umum"]);
    }

    function admin_cash_in() {
        $conds = [];
        $currentMonth = date("m");
        $conds[] = [
            "MONTH(GeneralEntry.transaction_date)" => $currentMonth
        ];
        if (!empty($this->request->query['start_date']) && empty($this->request->query['end_date'])) {
            $startDate = $this->request->query['start_date'];
            $conds[] = [
                "DATE_FORMAT(GeneralEntry.transaction_date, '%Y-%m-%d') >=" => $startDate
            ];
            unset($_GET['start_date']);
        }
        if (empty($this->request->query['start_date']) && !empty($this->request->query['end_date'])) {
            $endDate = $this->request->query['end_date'];
            $conds[] = [
                "DATE_FORMAT(GeneralEntry.transaction_date, '%Y-%m-%d') <=" => $endDate
            ];
            unset($_GET['end_date']);
        }
        if (!empty($this->request->query['start_date']) && !empty($this->request->query['end_date'])) {
            $startDate = $this->request->query['start_date'];
            $endDate = $this->request->query['end_date'];
            $conds[] = [
                "DATE_FORMAT(GeneralEntry.transaction_date, '%Y-%m-%d') >=" => $startDate,
                "DATE_FORMAT(GeneralEntry.transaction_date, '%Y-%m-%d') <=" => $endDate
            ];
            unset($_GET['start_date']);
            unset($_GET['end_date']);
        }
        $generalEntries = $this->GeneralEntry->find("all", [
            "conditions" => [
                "OR" => [
                    "GeneralEntry.cash_in_id !=" => null,
                    "GeneralEntry.payment_sale_id !=" => null,
                    "AND" => [
                        "GeneralEntry.initial_balance_id !=" => null,
                        "GeneralEntry.cash_in_id" => null,
                        "GeneralEntry.cash_disbursement_id" => null,
                        "GeneralEntry.payment_sale_id" => null,
                        "GeneralEntry.payment_purchase_id" => null,
                        "GeneralEntry.cash_mutation_id" => null,
                        "GeneralEntry.employee_salary_id" => null,
                        "GeneralEntry.sale_id" => null,
//                        "GeneralEntry.material_additional_entry_id" => null,
                        "GeneralEntry.transaction_entry_id" => null,
                        "GeneralEntry.shipment_id" => null,
                        "GeneralEntry.return_order_id" => null
                    ]
                ],
                $conds
            ],
            "order" => [
                "GeneralEntry.id",
                "GeneralEntry.transaction_date"
            ],
            "contain" => [
                "GeneralEntryType",
                "InitialBalance" => [
                    "Currency"
                ],
                "PaymentSale" => [
                    "Sale"
                ]
            ]
        ]);
        $this->set(compact("generalEntries"));
        $this->_activePrint(func_get_args(), "print_transaksi_jurnal_kas_masuk", ["excel" => "excel", "print" => "print"]);
        $this->_setPeriodeLaporanDate("start_date", "end_date");
    }

    function admin_cash_out() {
        $conds = [];
        $currentMonth = date("m");
        $conds[] = [
            "MONTH(GeneralEntry.transaction_date)" => $currentMonth
        ];
        if (!empty($this->request->query['start_date']) && empty($this->request->query['end_date'])) {
            $startDate = $this->request->query['start_date'];
            $conds[] = [
                "DATE_FORMAT(GeneralEntry.transaction_date, '%Y-%m-%d') >=" => $startDate
            ];
            unset($_GET['start_date']);
        }
        if (empty($this->request->query['start_date']) && !empty($this->request->query['end_date'])) {
            $endDate = $this->request->query['end_date'];
            $conds[] = [
                "DATE_FORMAT(GeneralEntry.transaction_date, '%Y-%m-%d') <=" => $endDate
            ];
            unset($_GET['end_date']);
        }
        if (!empty($this->request->query['start_date']) && !empty($this->request->query['end_date'])) {
            $startDate = $this->request->query['start_date'];
            $endDate = $this->request->query['end_date'];
            $conds[] = [
                "DATE_FORMAT(GeneralEntry.transaction_date, '%Y-%m-%d') >=" => $startDate,
                "DATE_FORMAT(GeneralEntry.transaction_date, '%Y-%m-%d') <=" => $endDate
            ];
            unset($_GET['start_date']);
            unset($_GET['end_date']);
        }
        $generalEntries = $this->GeneralEntry->find("all", [
            "conditions" => [
                "OR" => [
                    "GeneralEntry.cash_disbursement_id !=" => null,
                    "GeneralEntry.payment_purchase_id !=" => null,
                ],
                $conds
            ],
            "order" => [
                "GeneralEntry.id",
                "GeneralEntry.transaction_date"
            ],
            "contain" => [
                "GeneralEntryType"
            ]
        ]);
        $this->set(compact("generalEntries"));
        $this->_activePrint(func_get_args(), "print_transaksi_jurnal_kas_keluar", ["excel" => "excel", "print" => "print"]);
        $this->_setPeriodeLaporanDate("start_date", "end_date");
    }

    function admin_ledger() {
        $conds = [];
        $today = date("Y-m-d");
        $currentMonth = date("m");
        $currentYear = date("Y");
        $defaultConds = [
            "DATE_FORMAT(GeneralEntry.transaction_date, '%Y-%m-%d')" => $today
        ];
        if (!empty($this->request->query['start_date']) && empty($this->request->query['end_date'])) {
            $defaultConds = [];
            $startDate = $this->request->query['start_date'];
            $conds[] = [
                "DATE_FORMAT(GeneralEntry.transaction_date, '%Y-%m-%d') >=" => $startDate
            ];
            unset($_GET['start_date']);
        }
        if (empty($this->request->query['start_date']) && !empty($this->request->query['end_date'])) {
            $defaultConds = [];
            $endDate = $this->request->query['end_date'];
            $conds[] = [
                "DATE_FORMAT(GeneralEntry.transaction_date, '%Y-%m-%d') <=" => $endDate
            ];
            unset($_GET['end_date']);
        }
        if (!empty($this->request->query['start_date']) && !empty($this->request->query['end_date'])) {
            $defaultConds = [];
            $startDate = $this->request->query['start_date'];
            $endDate = $this->request->query['end_date'];
            $conds[] = [
                "DATE_FORMAT(GeneralEntry.transaction_date, '%Y-%m-%d') >=" => $startDate,
                "DATE_FORMAT(GeneralEntry.transaction_date, '%Y-%m-%d') <=" => $endDate
            ];
            unset($_GET['start_date']);
            unset($_GET['end_date']);
        }
        $dataTransactions = $this->GeneralEntry->find("all", [
            "conditions" => [
                $conds,
                $defaultConds
            ],
            "order" => [
                "GeneralEntry.transaction_date",
                "TransactionType.id"
            ],
            "contain" => [
                "InitialBalance" => [
                    "Currency"
                ],
                "PaymentSale" => [
                    "Sale"
                ],
                "Sale",
                "Shipment" => [
                    "Sale" => [
                        "Buyer"
                    ]
                ],
                "TransactionType",
                "GeneralEntryType"
            ]
        ]);
        $dataGeneralEntry = [];
        $dataGeneralEntryType = ClassRegistry::init("GeneralEntryType")->find("all", ["order" => ["GeneralEntryType.code"], "recursive" => -1]);
        foreach ($dataGeneralEntryType as $types) {
            $temp = $this->GeneralEntry->find("all", [
                "conditions" => [
                    "GeneralEntry.general_entry_type_id" => $types['GeneralEntryType']['id'],
                    $conds,
                    $defaultConds
                ],
                "contain" => [
                    "InitialBalance" => [
                        "Currency"
                    ],
                    "PaymentSale" => [
                        "Sale"
                    ],
                    "Shipment" => [
                        "Sale" => [
                            "Buyer"
                        ]
                    ],
                    "GeneralEntryAccountType",
                    "GeneralEntryType" => [
                        "Currency"
                    ]
                ],
                "order" => "GeneralEntry.transaction_date"
            ]);
            $dataGeneralEntry[] = $temp;
        }
        $this->set(compact("startDate"));
        $this->set(compact("endDate", 'currentMonth', 'currentYear'));
        $this->set(compact("dataTransactions", "dataGeneralEntry"));
        $this->_activePrint(func_get_args(), "data_buku_besar", ["excel" => "excel", "print" => "print_no_border"]);
    }

    function admin_trial_balance() {
        $currentMonth = date("m");
        if (isset($this->request->query['bulan']) && isset($this->request->query['tahun'])) {
            $dataGeneralEntryType = ClassRegistry::init("GeneralEntryType")->find("all", [
                "order" => "GeneralEntryType.code",
                "conditions" => [
                    "GeneralEntryType.code !=" => null
                ],
                "recursive" => -1
            ]);
            $this->set(compact('dataGeneralEntryType'));
            $this->_activePrint(["print"], "print_neraca_saldo", "print_neraca_saldo");
        }
    }

    function admin_balance_sheet() {
        $conds = [];
        $currentMonth = date("m");
        if (isset($this->request->query['bulan']) && isset($this->request->query['tahun'])) {
            if (!empty($this->request->query['bulan'])) {
                $bulan = intval($this->request->query['bulan']);
                $conds[] = [
                    "MONTH(GeneralEntry.transaction_date)" => $bulan
                ];
                unset($_GET['bulan']);
            }
            if (!empty($this->request->query['tahun'])) {
                $tahun = intval($this->request->query['tahun']);
                $conds[] = [
                    "YEAR(GeneralEntry.transaction_date)" => $tahun
                ];
                unset($_GET['tahun']);
            }
            $categoryCash = $this->GeneralEntry->GeneralEntryType->find("all", [
                "conditions" => [
                    "GeneralEntryType.parent_id" => [2, 3, 4]
                ],
                "recursive" => -1
            ]);
            $dataCOAPiutang = ClassRegistry::init("GeneralEntryType")->find("all", [
                "conditions" => [
                    "OR" => [
                        "GeneralEntryType.id" => [34, 39, 52],
                        "GeneralEntryType.parent_id" => [34, 39, 52]
                    ]
                ],
                "recursive" => -1,
                "order" => "GeneralEntryType.code"
            ]);
            $dataPiutangSupplier = $this->GeneralEntry->find("all", [
                "conditions" => [
                    "GeneralEntryType.parent_id" => 51,
                    $conds
                ],
                "contain" => [
                    "GeneralEntryType"
                ]
            ]);
            $dataPersediaanBahanBaku = $this->GeneralEntry->find("all", [
                "conditions" => [
                    "GeneralEntry.general_entry_type_id" => 50,
                    $conds
                ],
                "order" => [
                    "GeneralEntry.transaction_date",
                    "GeneralEntry.id"
                ]
            ]);
            $dataPersediaanBahanPembantu = $this->GeneralEntry->find("all", [
                "conditions" => [
                    "GeneralEntry.general_entry_type_id" => 45,
                    $conds
                ],
                "order" => [
                    "GeneralEntry.transaction_date",
                    "GeneralEntry.id"
                ]
            ]);
            $dataAssetBerwujud = ClassRegistry::init("AssetProperty")->find("all", [
                "conditions" => [
                    "GeneralEntryType.parent_id" => [58, 61],
                    "MONTH(AssetProperty.created)" => $this->request->query['bulan'],
                    "YEAR(AssetProperty.created)" => $this->request->query['tahun']
                ],
                "contain" => [
                    "GeneralEntryType"
                ],
                "order" => "GeneralEntryType.code"
            ]);
            $dataKenaikanNilaiAset = ClassRegistry::init("GeneralEntry")->find("all", [
                "conditions" => [
                    "GeneralEntry.general_entry_type_id" => 65,
                    "GeneralEntry.revaluation_asset_id !=" => null,
                    $conds
                ],
                "contain" => [
                    "GeneralEntryType"
                ]
            ]);
            $dataAssetTakBerwujud = ClassRegistry::init("AssetProperty")->find("all", [
                "conditions" => [
                    "GeneralEntryType.parent_id" => 59,
                    "MONTH(AssetProperty.created)" => $this->request->query['bulan'],
                    "YEAR(AssetProperty.created)" => $this->request->query['tahun']
                ],
                "contain" => [
                    "GeneralEntryType"
                ],
                "order" => "GeneralEntryType.code"
            ]);
            $dataPenyusutanAsset = ClassRegistry::init("DepreciationAsset")->find("all", [
                "contain" => [
                    "GeneralEntryType"
                ],
                "conditions" => [
                    "DATE_ADD(DepreciationAsset.created, INTERVAL DepreciationAsset.depreciation_duration MONTH) >=" => date("Y-m-d")
                ]
            ]);
            $dataSubChild = $this->GeneralEntry->find("all", [
                "conditions" => [
                    "GeneralEntry.general_entry_type_id" => 85,
                    $conds
                ],
                'order' => "GeneralEntry.transaction_date",
                "contain" => [
                    "GeneralEntryType"
                ]
            ]);
            $dataModalDisetor = $this->GeneralEntry->find("all", [
                "conditions" => [
                    "GeneralEntryType.parent_id" => 36,
                    $conds
                ],
                "contain" => [
                    "InitialBalance" => [
                        "Currency"
                    ],
                    "GeneralEntryType"
                ]
            ]);
            $dataRevaluasiAset = $this->GeneralEntry->find("all", [
                "conditions" => [
                    "GeneralEntry.general_entry_type_id" => 37,
                    "GeneralEntry.revaluation_asset_id !=" => null,
                    $conds
                ],
                "contain" => [
                    "GeneralEntryType"
                ]
            ]);
            $dataLabaRugi = ClassRegistry::init("ProfitAndLoss")->find("all", [
                "conditions" => [
                    "ProfitAndLoss.month" => $this->request->query['bulan'],
                    "ProfitAndLoss.year" => $this->request->query['tahun']
                ]
            ]);
            $dataLabaDitahan = ClassRegistry::init("RetainedEarning")->find("all", [
                "conditions" => [
                    "MONTH(RetainedEarning.datetime)" => $this->request->query['bulan'],
                    "YEAR(RetainedEarning.datetime)" => $this->request->query['tahun']
                ]
            ]);
            $title = "NERACA SALDO";
//            $exchangeRate = intval(str_replace(".", "", $this->request->query['exchange_rate']));
            $this->set(compact('title', "categoryCash", "dataLabaDitahan"));
            $this->set(compact("dataCOAPiutang", "dataSubChild", "dataModalDisetor", "dataLabaRugi"));
            $this->set(compact("dataPersediaanBahanBaku", "dataPersediaanBahanPembantu", "dataPiutangSupplier", "dataAssetBerwujud", "dataKenaikanNilaiAset", "dataAssetTakBerwujud", "dataPenyusutanAsset", "dataRevaluasiAset"));
            $this->_activePrint(["print"], "print_neraca_standar", "print_neraca_standar");
        }
    }

    function admin_annual_balance() {
        $conds = [];
        $year = date("Y");
        if (isset($this->request->query['year'])) {
//            $exchangeRate = intval(str_replace(".", "", $this->request->query['exchange_rate']));
            if (!empty($this->request->query['year'])) {
                $year = $this->request->query['year'];
            }
            $conds[] = [
                "YEAR(GeneralEntry.transaction_date)" => $year
            ];
            $annualLength = 12;

            $dataAnnualKas = [];
            $dataKas = ClassRegistry::init("GeneralEntryType")->find("all", [
                "conditions" => [
                    "GeneralEntryType.id" => [2, 3, 4]
                ],
                "order" => "GeneralEntryType.code",
                "recursive" => -1
            ]);
            $j = 0;
            for ($i = 1; $i <= $annualLength; $i++) {
                $totalCashDebit = 0;
                $totalCashCredit = 0;
                foreach ($dataKas as $kas) {
                    $temp = $this->GeneralEntry->find("all", [
                        "conditions" => [
                            "MONTH(GeneralEntry.transaction_date)" => $i,
                            "GeneralEntryType.parent_id" => $kas['GeneralEntryType']['id'],
                            $conds
                        ],
                        "contain" => [
                            "GeneralEntryType",
                            "InitialBalance"
                        ]
                    ]);
                    foreach ($temp as $cash) {
                        if (!empty($cash['GeneralEntry']['initial_balance_id'])) {
                            if ($cash['InitialBalance']['currency_id'] == 1) {
                                $totalCashDebit += $cash['GeneralEntry']['debit'];
                                $totalCashCredit += $cash['GeneralEntry']['credit'] * -1;
                            } else {
                                if ($cash['GeneralEntry']['is_from_general_transaction']) {
                                    $totalCashDebit += $cash['GeneralEntry']['debit'] * $cash['GeneralEntry']['exchange_rate'];
                                    $totalCashCredit += $cash['GeneralEntry']['credit'] * -1 * $cash['GeneralEntry']['exchange_rate'];
                                } else {
                                    $totalCashDebit += $cash['GeneralEntry']['debit'] * $cash['InitialBalance']['exchange_rate'];
                                    $totalCashCredit += $cash['GeneralEntry']['credit'] * -1 * $cash['InitialBalance']['exchange_rate'];
                                }
                            }
                        } else {
                            $totalCashDebit += $cash['GeneralEntry']['debit'];
                            $totalCashCredit += $cash['GeneralEntry']['credit'] * -1;
                        }
                    }
                }
                $dataAnnualKas[$j] = $totalCashDebit + $totalCashCredit;
                $j++;
            }

            $dataCOAPiutang = ClassRegistry::init("GeneralEntryType")->find("all", [
                "conditions" => [
                    "OR" => [
                        "GeneralEntryType.id" => [34, 39, 52],
                        "GeneralEntryType.parent_id" => [34, 39, 52]
                    ]
                ],
                "recursive" => -1,
                "order" => "GeneralEntryType.code"
            ]);

            $dataAnnualPiutangSupplier = [];
            $dataRincianPiutangSupplier = [];
            $dataPiutangSupplier = ClassRegistry::init("GeneralEntryType")->find("all", [
                "conditions" => [
                    "GeneralEntryType.parent_id" => 51
                ],
                "recursive" => -1,
                "order" => "GeneralEntryType.code"
            ]);
            $j = 0;
            for ($i = 1; $i <= $annualLength; $i++) {
                $temp = $this->GeneralEntry->find("all", [
                    "conditions" => [
                        "MONTH(GeneralEntry.transaction_date)" => $i,
                        "GeneralEntryType.parent_id" => 51,
                        $conds
                    ],
                    "contain" => [
                        "Shipment" => [
                            "Sale"
                        ],
                        "InitialBalance" => [
                            "Currency"
                        ],
                        "GeneralEntryType"
                    ]
                ]);
                $dataRincianPiutangSupplier[$i] = $temp;
                $totalCashDebit = 0;
                $totalCashCredit = 0;
                foreach ($temp as $cash) {
                    if ($cash['InitialBalance']['Currency']['id'] == 1) {
                        $totalCashDebit += $cash['GeneralEntry']['debit'];
                        $totalCashCredit += $cash['GeneralEntry']['credit'] * -1;
                    } else {
                        $totalCashDebit += $cash['GeneralEntry']['debit'] * $cash['Shipment']['Sale']['exchange_rate'];
                        $totalCashCredit += $cash['GeneralEntry']['credit'] * $cash['Shipment']['Sale']['exchange_rate'] * -1;
                    }
                }
                $dataAnnualPiutangSupplier[$j] = $totalCashDebit + $totalCashCredit;
                $j++;
            }
//            debug($dataRincianPiutangSupplier);
//            die;
            $dataAnnualPersediaanBahanBaku = [];
            $dataPersediaanBahanBaku = ClassRegistry::init("GeneralEntryType")->find("first", [
                "conditions" => [
                    "GeneralEntryType.id" => 50
                ],
                "recursive" => -1
            ]);
            $j = 0;
            for ($i = 1; $i <= $annualLength; $i++) {
                $temp = $this->GeneralEntry->find("all", [
                    "conditions" => [
                        "MONTH(GeneralEntry.transaction_date)" => $i,
                        "GeneralEntry.general_entry_type_id" => 50,
                        $conds
                    ],
                    "recursive" => 2
                ]);
                $totalCashDebit = 0;
                $totalCashCredit = 0;
                foreach ($temp as $cash) {
                    $totalCashDebit += $cash['GeneralEntry']['debit'];
                    $totalCashCredit += $cash['GeneralEntry']['credit'];
                }
                $dataAnnualPersediaanBahanBaku[$j] = $totalCashDebit + $totalCashCredit;
                $j++;
            }

            $dataAnnualPersediaanBahanPembantu = [];
            $dataPersediaanBahanPembantu = ClassRegistry::init("GeneralEntryType")->find("first", [
                "conditions" => [
                    "GeneralEntryType.id" => 45
                ],
                "recursive" => -1
            ]);
            $j = 0;
            for ($i = 1; $i <= $annualLength; $i++) {
                $temp = $this->GeneralEntry->find("all", [
                    "conditions" => [
                        "MONTH(GeneralEntry.transaction_date)" => $i,
                        "GeneralEntry.general_entry_type_id" => 45,
                        $conds
                    ],
                    "recursive" => 2
                ]);
                $totalCashDebit = 0;
                $totalCashCredit = 0;
                foreach ($temp as $cash) {
                    $totalCashDebit += $cash['GeneralEntry']['debit'];
                    $totalCashCredit += $cash['GeneralEntry']['credit'];
                }
                $dataAnnualPersediaanBahanPembantu[$j] = $totalCashDebit + $totalCashCredit;
                $j++;
            }

            $dataAnnualAssetBerwujud = [];
            $dataAssetBerwujud = ClassRegistry::init("AssetProperty")->find("all", [
                "conditions" => [
                    "AssetProperty.asset_property_type_id" => 1
                ],
                "contain" => [
                    "GeneralEntryType"
                ]
            ]);
            $j = 0;
            for ($i = 1; $i <= $annualLength; $i++) {
                $totalCashDebit = 0;
                $totalCashCredit = 0;
                foreach ($dataAssetBerwujud as $assetBerwujud) {
                    $temp = $this->GeneralEntry->find("all", [
                        "conditions" => [
                            "MONTH(GeneralEntry.transaction_date)" => $i,
                            "GeneralEntryType.id" => $assetBerwujud['AssetProperty']['general_entry_type_id'],
                            $conds
                        ],
                        "contain" => [
                            "GeneralEntryType"
                        ]
                    ]);
                    foreach ($temp as $cash) {
                        $totalCashDebit += $cash['GeneralEntry']['debit'];
                        $totalCashCredit += $cash['GeneralEntry']['credit'] * -1;
                    }
                }
                $dataAnnualAssetBerwujud[$j] = $totalCashDebit + $totalCashCredit;
                $j++;
            }

            $dataAnnualAssetTakBerwujud = [];
            $dataAssetTakBerwujud = ClassRegistry::init("AssetProperty")->find("all", [
                "conditions" => [
                    "AssetProperty.asset_property_type_id" => 2
                ]
            ]);
            $j = 0;
            for ($i = 1; $i <= $annualLength; $i++) {
                $temp = $this->GeneralEntry->find("all", [
                    "conditions" => [
                        "MONTH(GeneralEntry.transaction_date)" => $i,
                        "GeneralEntryType.parent_id" => 59,
                        $conds
                    ],
                    "contain" => [
                        "GeneralEntryType"
                    ]
                ]);
                $totalCashDebit = 0;
                $totalCashCredit = 0;
                foreach ($temp as $cash) {
                    $totalCashDebit += $cash['GeneralEntry']['debit'];
                    $totalCashCredit += $cash['GeneralEntry']['credit'] * -1;
                }
                $dataAnnualAssetTakBerwujud[$j] = $totalCashDebit + $totalCashCredit;
                $j++;
            }

            $dataAnnualPenyusutanAsset = [];
            $dataPenyusutanAsset = ClassRegistry::init("DepreciationAsset")->find("all", [
                "conditions" => [
                    "DATE_ADD(DepreciationAsset.created, INTERVAL DepreciationAsset.depreciation_duration MONTH) >=" => date("Y-m-d")
                ]
            ]);
            $j = 0;
            for ($i = 1; $i <= $annualLength; $i++) {
                $totalCashDebit = 0;
                $totalCashCredit = 0;
                $dataTransactionThisMonth = ClassRegistry::init("GeneralEntry")->find("first", [
                    "conditions" => [
                        "MONTH(GeneralEntry.transaction_date)" => $i
                    ]
                ]);
                if (!empty($dataPenyusutanAsset) && !empty($dataTransactionThisMonth)) {
                    foreach ($dataPenyusutanAsset as $penyusutanAsset) {
                        $temp = $this->GeneralEntry->find("all", [
                            "conditions" => [
                                "GeneralEntryType.id" => $penyusutanAsset['DepreciationAsset']['general_entry_type_id'],
                            ],
                            "contain" => [
                                "GeneralEntryType"
                            ]
                        ]);
                        foreach ($temp as $cash) {
                            $totalCashDebit += $cash['GeneralEntry']['debit'];
                            $totalCashCredit += $cash['GeneralEntry']['credit'] * -1;
                        }
                    }
                    $dataAnnualPenyusutanAsset[$j] = $totalCashDebit + $totalCashCredit;
                } else {
                    $dataAnnualPenyusutanAsset[$j] = 0;
                }
                $j++;
            }

            $dataAnnualGajiHarian = [];
            $dataGajiHarian = ClassRegistry::init("GeneralEntryType")->find("first", [
                "conditions" => [
                    "GeneralEntryType.id" => 29
                ],
                "recursive" => -1
            ]);
            $j = 0;
            for ($i = 1; $i <= $annualLength; $i++) {
                $temp = $this->GeneralEntry->find("all", [
                    "conditions" => [
                        "MONTH(GeneralEntry.transaction_date)" => $i,
                        "GeneralEntry.general_entry_type_id" => 29,
                        $conds
                    ],
                    "contain" => [
                        "InitialBalance" => [
                            "Currency"
                        ],
                        "PaymentSale" => [
                            "Sale"
                        ]
                    ]
                ]);
                $totalCashDebit = 0;
                $totalCashCredit = 0;
                foreach ($temp as $cash) {
                    if ($cash['InitialBalance']['Currency']['id'] == 1) {
                        $totalCashDebit += $cash['GeneralEntry']['debit'];
                        $totalCashCredit += $cash['GeneralEntry']['credit'];
                    } else {
                        if (!empty($cash['GeneralEntry']['payment_sale_id']) && empty($cash['GeneralEntry']['sale_id'])) {
                            $totalCashDebit += $cash['GeneralEntry']['debit'] * $cash['PaymentSale']['Sale']['exchange_rate'];
                            $totalCashCredit += $cash['GeneralEntry']['credit'] * $cash['PaymentSale']['Sale']['exchange_rate'];
                        } else if (empty($cash['GeneralEntry']['payment_sale)id']) && !empty($cash['GeneralEntry']['sale_id'])) {
                            $totalCashDebit += $cash['GeneralEntry']['debit'] * $cash['Sale']['exchange_rate'];
                            $totalCashCredit += $cash['GeneralEntry']['credit'] * $cash['Sale']['exchange_rate'];
                        } else {
                            $totalCashDebit += $cash['GeneralEntry']['debit'] * $cash['InitialBalance']['exchange_rate'];
                            $totalCashCredit += $cash['GeneralEntry']['credit'] * $cash['InitialBalance']['exchange_rate'];
                        }
                    }
                }
                $dataAnnualGajiHarian[$j] = $totalCashDebit + $totalCashCredit;
                $j++;
            }

            $dataAnnualGajiBulanan = [];
            $dataGajiBulanan = ClassRegistry::init("GeneralEntryType")->find("first", [
                "conditions" => [
                    "GeneralEntryType.id" => 30
                ],
                "recursive" => -1
            ]);
            $j = 0;
            for ($i = 1; $i <= $annualLength; $i++) {
                $temp = $this->GeneralEntry->find("all", [
                    "conditions" => [
                        "MONTH(GeneralEntry.transaction_date)" => $i,
                        "GeneralEntry.general_entry_type_id" => 30,
                        $conds
                    ],
                    "contain" => [
                        "InitialBalance" => [
                            "Currency"
                        ],
                        "PaymentSale" => [
                            "Sale"
                        ]
                    ]
                ]);
                $totalCashDebit = 0;
                $totalCashCredit = 0;
                foreach ($temp as $cash) {
                    if ($cash['InitialBalance']['Currency']['id'] == 1) {
                        $totalCashDebit += $cash['GeneralEntry']['debit'];
                        $totalCashCredit += $cash['GeneralEntry']['credit'];
                    } else {
                        if (!empty($cash['GeneralEntry']['payment_sale_id']) && empty($cash['GeneralEntry']['sale_id'])) {
                            $totalCashDebit += $cash['GeneralEntry']['debit'] * $cash['PaymentSale']['Sale']['exchange_rate'];
                            $totalCashCredit += $cash['GeneralEntry']['credit'] * $cash['PaymentSale']['Sale']['exchange_rate'];
                        } else if (empty($cash['GeneralEntry']['payment_sale)id']) && !empty($cash['GeneralEntry']['sale_id'])) {
                            $totalCashDebit += $cash['GeneralEntry']['debit'] * $cash['Sale']['exchange_rate'];
                            $totalCashCredit += $cash['GeneralEntry']['credit'] * $cash['Sale']['exchange_rate'];
                        } else {
                            $totalCashDebit += $cash['GeneralEntry']['debit'] * $cash['InitialBalance']['exchange_rate'];
                            $totalCashCredit += $cash['GeneralEntry']['credit'] * $cash['InitialBalance']['exchange_rate'];
                        }
                    }
                }
                $dataAnnualGajiBulanan[$j] = $totalCashDebit + $totalCashCredit;
                $j++;
            }

            $dataHutangUsaha = ClassRegistry::init("GeneralEntryType")->find("all", [
                "conditions" => [
                    "OR" => [
                        "GeneralEntryType.id" => [28, 35],
                        "GeneralEntryType.parent_id" => 327
                    ]
                ],
                "order" => "GeneralEntryType.code",
                "contain" => [
                    "Parent",
                    "Child"
                ]
            ]);

            $dataHutangLain = ClassRegistry::init("GeneralEntryType")->find("all", [
                "conditions" => [
                    "GeneralEntryType.parent_id" => 338
                ],
                "recursive" => -1,
                "order" => "GeneralEntryType.code"
            ]);

            $dataAnnualModalDisetor = [];
            $dataModalDisetor = ClassRegistry::init("GeneralEntryType")->find("first", [
                "conditions" => [
                    "GeneralEntryType.id" => 36
                ],
                "recursive" => -1
            ]);
            $j = 0;
            for ($i = 1; $i <= $annualLength; $i++) {
                $temp = $this->GeneralEntry->find("all", [
                    "conditions" => [
                        "MONTH(GeneralEntry.transaction_date)" => $i,
                        "GeneralEntryType.parent_id" => 36,
                        $conds
                    ],
                    "contain" => [
                        "InitialBalance" => [
                            "Currency"
                        ],
                        "PaymentSale" => [
                            "Sale"
                        ],
                        "GeneralEntryType"
                    ]
                ]);
                $totalCashDebit = 0;
                $totalCashCredit = 0;
                foreach ($temp as $cash) {
                    if (!empty($cash['InitialBalance']['id'])) {
                        if ($cash['InitialBalance']['Currency']['id'] == 1) {
                            $totalCashDebit += $cash['GeneralEntry']['debit'];
                            $totalCashCredit += $cash['GeneralEntry']['credit'];
                        } else {
                            if (!empty($cash['GeneralEntry']['payment_sale_id']) && empty($cash['GeneralEntry']['sale_id'])) {
                                $totalCashDebit += $cash['GeneralEntry']['debit'] * $cash['PaymentSale']['Sale']['exchange_rate'];
                                $totalCashCredit += $cash['GeneralEntry']['credit'] * $cash['PaymentSale']['Sale']['exchange_rate'];
                            } else if (empty($cash['GeneralEntry']['payment_sale)id']) && !empty($cash['GeneralEntry']['sale_id'])) {
                                $totalCashDebit += $cash['GeneralEntry']['debit'] * $cash['Sale']['exchange_rate'];
                                $totalCashCredit += $cash['GeneralEntry']['credit'] * $cash['Sale']['exchange_rate'];
                            } else {
                                $totalCashDebit += $cash['GeneralEntry']['debit'] * $cash['InitialBalance']['exchange_rate'];
                                $totalCashCredit += $cash['GeneralEntry']['credit'] * $cash['InitialBalance']['exchange_rate'];
                            }
                        }
                    } else {
                        $totalCashDebit += $cash['GeneralEntry']['debit'];
                        $totalCashCredit += $cash['GeneralEntry']['credit'];
                    }
                }
                $dataAnnualModalDisetor[$j] = $totalCashDebit + $totalCashCredit;
                $j++;
            }

            $dataAnnualLabaRugiBerjalan = [];
            $dataLabaRugiBerjalan = ClassRegistry::init("GeneralEntryType")->find("first", [
                "conditions" => [
                    "GeneralEntryType.id" => 43
                ],
                "recursive" => -1
            ]);
            $j = 0;
            for ($i = 1; $i <= $annualLength; $i++) {
                $temp = ClassRegistry::init("ProfitAndLoss")->find("first", [
                    "conditions" => [
                        "ProfitAndLoss.month" => $i,
                        "ProfitAndLoss.year" => $this->request->query['year']
                    ],
                ]);
                if (!empty($temp)) {
                    $total = $temp['ProfitAndLoss']['nominal'];
                } else {
                    $total = 0;
                }
                $dataAnnualLabaRugiBerjalan[$j] = $total;
                $j++;
            }

            $dataAnnualLabaDitahan = [];
            $dataLabaDitahan = ClassRegistry::init("GeneralEntryType")->find("first", [
                "conditions" => [
                    "GeneralEntryType.id" => 42
                ],
                "recursive" => -1
            ]);
            $j = 0;
            for ($i = 1; $i <= $annualLength; $i++) {
                $temp = ClassRegistry::init("RetainedEarning")->find("all", [
                    "conditions" => [
                        "MONTH(RetainedEarning.datetime)" => $i,
                        "YEAR(RetainedEarning.datetime)" => $this->request->query['year']
                    ],
                ]);
                if (!empty($temp)) {
                    foreach ($temp as $item) {
                        $total += $item['RetainedEarning']['nominal'];
                    }
                } else {
                    $total = 0;
                }
                $dataAnnualLabaDitahan[$j] = $total;
                $j++;
            }

            $dataRevaluasiAsset = ClassRegistry::init("GeneralEntryType")->find("first", ["conditions" => ["GeneralEntryType.id" => 37], "recursive" => -1]);
            $dataAnnualRevaluationAsset = [];
            $j = 0;
            for ($i = 1; $i <= $annualLength; $i++) {
                $temp = $this->GeneralEntry->find("all", [
                    "conditions" => [
                        "MONTH(GeneralEntry.transaction_date)" => $i,
                        "GeneralEntry.general_entry_type_id" => 37,
                        $conds
                    ],
                    "contain" => [
                        "GeneralEntryType"
                    ]
                ]);
                $total = 0;
                foreach ($temp as $cash) {
                    $total += $cash['GeneralEntry']['credit'];
                }
                $dataAnnualRevaluationAsset[$j] = $total;
                $j++;
            }

            $this->set(compact("year", "dataAnnualKas", "dataKas"));
            $this->set(compact("dataKasKecil", "dataKasBesar", "dataKasBesarUSD"));
            $this->set(compact("dataPersediaanBahanBaku", "dataAnnualPersediaanBahanBaku"));
            $this->set(compact("dataPersediaanBahanPembantu", "dataAnnualPersediaanBahanPembantu"));
            $this->set(compact("dataCOAPiutang"));
            $this->set(compact("dataPiutangSupplier", "dataAnnualPiutangSupplier", "dataRincianPiutangSupplier"));
            $this->set(compact("dataGajiHarian", "dataAnnualGajiHarian", "dataGajiBulanan", "dataAnnualGajiBulanan"));
            $this->set(compact("dataHutangUsaha", "dataAnnualHutangUsaha", 'dataHutangLain'));
            $this->set(compact("dataAnnualAssetBerwujud", "dataAssetBerwujud", "dataAnnualAssetTakBerwujud", "dataAssetTakBerwujud", "dataAnnualPenyusutanAsset", "dataPenyusutanAsset"));
            $this->set(compact("dataModalDisetor", "dataAnnualModalDisetor"));
            $this->set(compact("dataLabaRugiBerjalan", "dataAnnualLabaRugiBerjalan"));
            $this->set(compact("dataAnnualLabaDitahan", "dataLabaDitahan", "dataAnnualRevaluationAsset", "dataRevaluasiAsset"));
            $this->_activePrint(["print"], "print_neraca_tahunan", "print_neraca_tahunan");
        }
    }

    function admin_income_statement() {
        if (!empty($this->request->query['bulan']) && !empty($this->request->query['tahun'])) {
            $conds = [
                "MONTH(GeneralEntry.transaction_date)" => $this->request->query['bulan'],
                "YEAR(GeneralEntry.transaction_date)" => $this->request->query['tahun'],
            ];
            $dataPenjualan = $this->GeneralEntry->find("all", [
                "conditions" => [
                    $conds,
                    "GeneralEntryType.parent_id" => 6
                ],
                "contain" => [
                    "GeneralEntryType",
                    "Shipment" => [
                        "Sale" => [
                            "Buyer"
                        ]
                    ],
                    "DebitInvoiceSale"
                ]
            ]);
            $dataGajiHarian = $this->GeneralEntry->find("all", [
                "conditions" => [
                    "GeneralEntryType.id" => 29,
                    $conds
                ],
                "contain" => [
                    "GeneralEntryType"
                ]
            ]);
            $accountNameGajiHarian = ClassRegistry::init("GeneralEntryType")->find("first", [
                "conditions" => [
                    "GeneralEntryType.id" => 29
                ],
                "recursive" => -1
            ]);
            $dataGajiBulanan = $this->GeneralEntry->find("all", [
                "conditions" => [
                    "GeneralEntryType.id" => 30,
                    $conds
                ],
                "contain" => [
                    "GeneralEntryType"
                ]
            ]);
            $accountNameGajiBulanan = ClassRegistry::init("GeneralEntryType")->find("first", [
                "conditions" => [
                    "GeneralEntryType.id" => 30
                ],
                "recursive" => -1
            ]);
            $dataPembelianIkan = $this->GeneralEntry->find("all", [
                "conditions" => [
                    "GeneralEntry.general_entry_type_id" => 50,
                    $conds
                ],
                "contain" => [
                    "GeneralEntryType"
                ]
            ]);
            $totalPembelianIkan = 0;
            foreach ($dataPembelianIkan as $pembelianIkan) {
                $totalPembelianIkan += $pembelianIkan['GeneralEntry']['debit'] - $pembelianIkan['GeneralEntry']['credit'];
            }
            $dataPengirimanMaterialPembantu = $this->GeneralEntry->find("all", [
                "conditions" => [
                    "GeneralEntry.general_entry_type_id" => 46,
                    $conds
                ],
                "contain" => [
                    "GeneralEntryType"
                ]
            ]);
            $totalPengirimanMaterialPembantu = 0;
            foreach ($dataPengirimanMaterialPembantu as $pengirimanMaterialPembantu) {
                $totalPengirimanMaterialPembantu += $pengirimanMaterialPembantu['GeneralEntry']['debit'] - $pengirimanMaterialPembantu['GeneralEntry']['credit'];
            }
            $dataPembelianMaterialPembantu = $this->GeneralEntry->find("all", [
                "conditions" => [
                    "OR" => [
                        "GeneralEntry.general_entry_type_id" => 45,
                        "GeneralEntryType.parent_id" => 11
                    ],
                    $conds
                ],
                "contain" => [
                    "GeneralEntryType"
                ]
            ]);
            $totalPembelianMaterialPembantu = 0;
            foreach ($dataPembelianMaterialPembantu as $pembelianMaterialPembantu) {
                $totalPembelianMaterialPembantu += $pembelianMaterialPembantu['GeneralEntry']['debit'];
            }
            $dataPemasaran = $this->GeneralEntry->find("all", [
                "conditions" => [
                    "GeneralEntryType.parent_id" => 19,
                    $conds
                ],
                "contain" => [
                    "GeneralEntryType",
                    "Shipment" => [
                        "Sale" => [
                            "Buyer"
                        ]
                    ]
                ]
            ]);
            $dataPendapatanNonOperasional = $this->GeneralEntry->find("all", [
                "conditions" => [
                    "GeneralEntryType.parent_id" => 22,
                    $conds
                ],
                "contain" => [
                    "GeneralEntryType",
                    "CashIn"
                ]
            ]);
            $dataPengeluaranLuarUsaha = $this->GeneralEntry->find("all", [
                "conditions" => [
                    "GeneralEntryType.parent_id" => [24, 161],
                    $conds
                ],
                "contain" => [
                    "GeneralEntryType",
                    "CashDisbursement",
                    "InitialBalance"
                ],
                "order" => "GeneralEntryType.code"
            ]);
            $dataPenyusutan = ClassRegistry::init("DepreciationAsset")->find("all", [
                "conditions" => [
                    "DATE_ADD(DepreciationAsset.created, INTERVAL DepreciationAsset.depreciation_duration YEAR) >=" => date("Y-m-d")
                ],
                "contain" => [
                    "GeneralEntryType"
                ]
            ]);
            $dataBiayaPenyusutan = [];
            if (!empty($dataPenyusutan)) {
                foreach ($dataPenyusutan as $penyusutan) {
                    $dataBiayaPenyusutan[] = ClassRegistry::init("GeneralEntry")->find("first", [
                        "conditions" => [
                            "GeneralEntry.general_entry_type_id" => 69
                        ],
                        "contain" => [
                            "GeneralEntryType"
                        ]
                    ]);
                }
            }
            $this->_activePrint(["print"], "print_laporan_laba_rugi", "print_laporan_laba_rugi");
            $this->set(compact("totalPembelianIkan", "totalPembelianMaterialPembantu", 'totalPengirimanMaterialPembantu'));
            $this->set(compact("dataPenjualan", "dataPembelianIkan", "dataPembelianMaterialPembantu", "dataPengirimanMaterialPembantu", "dataProduksi", "dataPemasaran", "dataPendapatanNonOperasional", "dataPengeluaranLuarUsaha", 'dataBiayaPenyusutan'));
            $this->set(compact("dataGajiHarian", "dataGajiBulanan", "accountNameGajiHarian", "accountNameGajiBulanan"));
        }
    }

    function admin_annual_income_statement() {
        if (!empty($this->request->query['year'])) {
            $conds = [
                "YEAR(GeneralEntry.transaction_date)" => $this->request->query['year']
            ];
            $view = new View($this);
            $html = $view->loadHelper('Html');

            $totalPendapatan = [];
            $totalHargaPokokPenjualan = [];
            $totalAdminUmum = [];
            $totalPemasaran = [];
            $totalPendapatanLuarUsaha = [];
            $totalPengeluaranLuarUsaha = [];
            $labaRugiKotor = [];
            $labaRugiOperasi = [];
            $labaRugiBersih = [];

            $dataPenjualan = $this->GeneralEntry->find("all", [
                "conditions" => [
                    $conds,
                    "GeneralEntryType.parent_id" => 6
                ],
                "contain" => [
                    "GeneralEntryType",
                    "Shipment" => [
                        "Sale" => [
                            "Buyer"
                        ]
                    ]
                ]
            ]);
            $dataAnnualPenjualan = [];
            $dataRincianPenjualan = [];
            $length = 12;
            $month = 1;
            for ($i = 0; $i < $length; $i++) {
                $totalAmount = 0;
                $temp = $this->GeneralEntry->find("all", [
                    "conditions" => [
                        "GeneralEntryType.parent_id" => 6,
                        "MONTH(GeneralEntry.transaction_date)" => $month,
                        $conds
                    ],
                    "contain" => [
                        "GeneralEntryType",
                        "Shipment" => [
                            "Sale" => [
                                "Buyer"
                            ]
                        ]
                    ]
                ]);
                $dataRincianPenjualan[$i] = $temp;
                foreach ($temp as $amounts) {
                    if (!empty($amounts['GeneralEntry']['shipment_id'])) {
                        $totalAmount += $amounts['GeneralEntry']['credit'] * $amounts['Shipment']['Sale']['exchange_rate'];
                    } else if (!empty($amounts['GeneralEntry']['sale_product_additional_id'])) {
                        $totalAmount += $amounts['GeneralEntry']['credit'];
                    } else if (!empty($amounts['GeneralEntry']['payment_sale_material_additional_id'])) {
                        $totalAmount += $amounts['GeneralEntry']['credit'];
                    }
                }
                $dataAnnualPenjualan[$i] = [
                    [
                        "Bulan" => $html->getNamaBulan($month),
                        "Nominal" => $totalAmount
                    ]
                ];
                $totalPendapatan[$i] = $totalAmount;
                $month++;
            }

            $dataAnnualPembelianIkan = [];
            $dataRincianPembelianIkan = [];
            $length = 12;
            $month = 1;
            for ($i = 0; $i < $length; $i++) {
                $totalAmount = 0;
                $temp = $this->GeneralEntry->find("all", [
                    "conditions" => [
                        "GeneralEntryType.id" => 50,
                        "MONTH(GeneralEntry.transaction_date)" => $month,
                        $conds
                    ],
                    "contain" => [
                        "GeneralEntryType",
                    ]
                ]);
                $dataRincianPembelianIkan[$i] = $temp;
                foreach ($temp as $amounts) {
                    $totalAmount += $amounts['GeneralEntry']['debit'];
                }
                $dataAnnualPembelianIkan[$i] = [
                    [
                        "Bulan" => $html->getNamaBulan($month),
                        "Nominal" => $totalAmount
                    ]
                ];
                $month++;
            }

            // Biaya Pengiriman Material Pembantu
            $dataAnnualPembelianMaterialPembantu = [];
            $dataRincianPembelianMaterialPembantu = [];
            $length = 12;
            $month = 1;
            for ($i = 0; $i < $length; $i++) {
                $totalAmount = 0;
                $temp = $this->GeneralEntry->find("all", [
                    "conditions" => [
                        "OR" => [
                            "GeneralEntry.general_entry_type_id" => 46,
//                            "GeneralEntryType.parent_id" => 5
                        ],
                        "MONTH(GeneralEntry.transaction_date)" => $month,
                        $conds
                    ],
                ]);
                $dataRincianPembelianMaterialPembantu[$i] = $temp;
                foreach ($temp as $amounts) {
                    $totalAmount += $amounts['GeneralEntry']['debit'];
                }
                $dataAnnualPembelianMaterialPembantu[$i] = [
                    [
                        "Bulan" => $html->getNamaBulan($month),
                        "Nominal" => $totalAmount
                    ]
                ];
                $month++;
            }

            $dataAnnualBiayaOverhead = [];
            $dataRincianBiayaOverhead = [];
            $length = 12;
            $month = 1;
            for ($i = 0; $i < $length; $i++) {
                $totalAmount = 0;
                $temp = $this->GeneralEntry->find("all", [
                    "conditions" => [
                        "GeneralEntryType.parent_id" => 11,
                        "MONTH(GeneralEntry.transaction_date)" => $month,
                        $conds
                    ],
                    "contain" => [
                        "GeneralEntryType"
                    ]
                ]);
                $dataRincianBiayaOverhead[$i] = $temp;
                foreach ($temp as $amounts) {
                    $totalAmount += $amounts['GeneralEntry']['debit'];
                }
                $dataAnnualBiayaOverhead[$i] = [
                    [
                        "Bulan" => $html->getNamaBulan($month),
                        "Nominal" => $totalAmount
                    ]
                ];
                $month++;
            }

            $dataPembelianIkan = ClassRegistry::init("GeneralEntryType")->find("first", [
                "conditions" => [
                    "GeneralEntryType.id" => 50,
                ],
                "recursive" => -1
            ]);

            $dataPembelianMaterialPembantu = ClassRegistry::init("GeneralEntryType")->find("first", [
                "conditions" => [
                    "GeneralEntryType.id" => 46,
                ],
                "recursive" => -1
            ]);
            $dataBiayaOverhead = ClassRegistry::init("GeneralEntry")->find("all", [
                "conditions" => [
                    "GeneralEntryType.parent_id" => 11,
                ],
                "contain" => [
                    "GeneralEntryType"
                ],
                "group" => "GeneralEntryType.id"
            ]);
            $dataGajiHarian = ClassRegistry::init("GeneralEntryType")->find("first", [
                "conditions" => [
                    "GeneralEntryType.id" => 29
                ],
                "recursive" => -1
            ]);
            $dataAnnualGajiHarian = [];
            $dataRincianGajiHarian = [];
            $length = 12;
            $month = 1;
            for ($i = 0; $i < $length; $i++) {
                $totalAmount = 0;
                $temp = $this->GeneralEntry->find("all", [
                    "conditions" => [
                        "GeneralEntryType.id" => 29,
                        "MONTH(GeneralEntry.transaction_date)" => $month,
                        $conds
                    ],
                    "contain" => [
                        "GeneralEntryType",
                    ]
                ]);
                $dataRincianGajiHarian[$i] = $temp;
                foreach ($temp as $amounts) {
                    $totalAmount += $amounts['GeneralEntry']['debit'];
                }
                $dataAnnualGajiHarian[$i] = [
                    [
                        "Bulan" => $html->getNamaBulan($month),
                        "Nominal" => $totalAmount
                    ]
                ];
                $month++;
            }

            $dataGajiBulanan = ClassRegistry::init("GeneralEntryType")->find("first", [
                "conditions" => [
                    "GeneralEntryType.id" => 30
                ],
                "recursive" => -1
            ]);
            $dataAnnualGajiBulanan = [];
            $dataRincianGajiBulanan = [];
            $length = 12;
            $month = 1;
            for ($i = 0; $i < $length; $i++) {
                $totalAmount = 0;
                $temp = $this->GeneralEntry->find("all", [
                    "conditions" => [
                        "GeneralEntryType.id" => 30,
                        "MONTH(GeneralEntry.transaction_date)" => $month,
                        $conds
                    ],
                    "contain" => [
                        "GeneralEntryType",
                    ]
                ]);
                $dataRincianGajiBulanan[$i] = $temp;
                foreach ($temp as $amounts) {
                    $totalAmount += $amounts['GeneralEntry']['debit'];
                }
                $dataAnnualGajiBulanan[$i] = [
                    [
                        "Bulan" => $html->getNamaBulan($month),
                        "Nominal" => $totalAmount
                    ]
                ];
                $month++;
            }

            $dataAdminUmum = $this->GeneralEntry->find("all", [
                "conditions" => [
                    $conds,
                    "GeneralEntryType.parent_id" => 92
                ],
                "contain" => [
                    "GeneralEntryType"
                ],
                "group" => "GeneralEntryType.id"
            ]);
            $dataAnnualAdminUmum = [];
            $dataRincianAdminUmum = [];
            $length = 12;
            $month = 1;
            for ($i = 0; $i < $length; $i++) {
                $totalAmount = 0;
                $temp = $this->GeneralEntry->find("all", [
                    "conditions" => [
                        "GeneralEntryType.parent_id" => 92,
                        "MONTH(GeneralEntry.transaction_date)" => $month,
                        $conds,
                        "GeneralEntryType.id !=" => 30
                    ],
                    "contain" => [
                        "GeneralEntryType"
                    ]
                ]);
                $dataRincianAdminUmum[$i] = $temp;
                foreach ($temp as $amounts) {
                    $totalAmount += $amounts['GeneralEntry']['debit'];
                }
                $dataAnnualAdminUmum[$i] = [
                    [
                        "Bulan" => $html->getNamaBulan($month),
                        "Nominal" => $totalAmount
                    ]
                ];
                $month++;
            }

            $dataPemasaran = $this->GeneralEntry->find("all", [
                "conditions" => [
                    $conds,
                    "GeneralEntryType.parent_id" => 19
                ],
                "contain" => [
                    "GeneralEntryType",
                    "PaymentSale"
                ]
            ]);
            $dataAnnualPemasaran = [];
            $dataRincianPemasaran = [];
            $length = 12;
            $month = 1;
            for ($i = 0; $i < $length; $i++) {
                $totalAmount = 0;
                $temp = $this->GeneralEntry->find("all", [
                    "conditions" => [
                        "GeneralEntryType.parent_id" => 19,
                        "MONTH(GeneralEntry.transaction_date)" => $month,
                        $conds
                    ],
                    "contain" => [
                        "GeneralEntryType",
                        "Shipment" => [
                            "Sale" => [
                                "Buyer"
                            ]
                        ]
                    ]
                ]);
                $dataRincianPemasaran[$i] = $temp;
                foreach ($temp as $amounts) {
                    if (!empty($amounts['Shipment']['id'])) {
                        if ($amounts['Shipment']['Sale']['Buyer']['buyer_type_id'] == 1) {
                            $totalAmount += $amounts['GeneralEntry']['debit'];
                        } else {
                            $totalAmount += $amounts['GeneralEntry']['debit'] * $amounts['Shipment']['Sale']['exchange_rate'];
                        }
                    } else {
                        $totalAmount += $amounts['GeneralEntry']['debit'];
                    }
                }
                $dataAnnualPemasaran[$i] = [
                    [
                        "Bulan" => $html->getNamaBulan($month),
                        "Nominal" => $totalAmount
                    ]
                ];
                $month++;
            }
            $dataPendapatanLuarUsaha = $this->GeneralEntry->find("all", [
                "conditions" => [
                    $conds,
                    "GeneralEntryType.parent_id" => 22
                ],
                "contain" => [
                    "GeneralEntryType",
                    "CashIn"
                ]
            ]);
            $dataAnnualPendapatanLuarUsaha = [];
            $dataRincianPendapatanLuarUsaha = [];
            $length = 12;
            $month = 1;
            for ($i = 0; $i < $length; $i++) {
                $totalAmount = 0;
                $temp = $this->GeneralEntry->find("all", [
                    "conditions" => [
                        "GeneralEntryType.parent_id" => 22,
                        "MONTH(GeneralEntry.transaction_date)" => $month,
                        $conds
                    ],
                    "contain" => [
                        "GeneralEntryType",
                        "CashIn"
                    ]
                ]);
                $dataRincianPendapatanLuarUsaha[$i] = $temp;
                foreach ($temp as $amounts) {
                    $totalAmount += $amounts['GeneralEntry']['credit'];
                }
                $dataAnnualPendapatanLuarUsaha[$i] = [
                    [
                        "Bulan" => $html->getNamaBulan($month),
                        "Nominal" => $totalAmount
                    ]
                ];
                $month++;
            }
            $dataPengeluaranLuarUsaha = $this->GeneralEntry->find("all", [
                "conditions" => [
                    $conds,
                    "GeneralEntryType.parent_id" => [24, 161]
                ],
                "contain" => [
                    "GeneralEntryType"
                ],
                "group" => "GeneralEntryType.id",
                "order" => "GeneralEntryType.code"
            ]);
            $dataAnnualPengeluaranLuarUsaha = [];
            $dataRincianPengeluaranLuarUsaha = [];
            $length = 12;
            $month = 1;
            for ($i = 0; $i < $length; $i++) {
                $totalAmount = 0;
                $temp = $this->GeneralEntry->find("all", [
                    "conditions" => [
                        "GeneralEntryType.parent_id" => [24, 161],
                        "MONTH(GeneralEntry.transaction_date)" => $month,
                        $conds
                    ],
                    "contain" => [
                        "GeneralEntryType"
                    ]
                ]);
                $dataRincianPengeluaranLuarUsaha[$i] = $temp;
                foreach ($temp as $amounts) {
                    $totalAmount += $amounts['GeneralEntry']['debit'];
                }
                $dataAnnualPengeluaranLuarUsaha[$i] = [
                    [
                        "Bulan" => $html->getNamaBulan($month),
                        "Nominal" => $totalAmount
                    ]
                ];
                $month++;
            }

            $dataBiayaPenyusutan = $this->GeneralEntry->find("all", [
                "conditions" => [
                    $conds,
                    "GeneralEntry.general_entry_type_id" => 69
                ],
                "contain" => [
                    "GeneralEntryType"
                ]
            ]);
            $dataRincianBiayaPenyusutan = [];
            $dataPenyusutan = ClassRegistry::init("DepreciationAsset")->find("all", [
                "conditions" => [
                    "DATE_ADD(DepreciationAsset.created, INTERVAL DepreciationAsset.depreciation_duration YEAR) >=" => date("Y-m-d")
                ]
            ]);

            for ($i = 0; $i < $length; $i++) {
                $dataRincianBiayaPenyusutan[$i] = 0;
                $dataTransactionThisMonth = ClassRegistry::init("GeneralEntry")->find("first", [
                    "conditions" => [
                        "MONTH(GeneralEntry.transaction_date)" => ($i + 1)
                    ],
                    "recursive" => -1
                ]);
                if (!empty($dataPenyusutan) && !empty($dataTransactionThisMonth)) {
                    $temp2 = $this->GeneralEntry->find("all", [
                        "conditions" => [
                            "GeneralEntry.general_entry_type_id" => 69,
                            "MONTH(GeneralEntry.transaction_date)" => ($i + 1)
                        ],
                        "recursive" => -1
                    ]);
                    if(!empty($temp2)) {
                        foreach ($temp2 as $amounts2) {
                            $dataRincianBiayaPenyusutan[$i] += $amounts2['GeneralEntry']['debit'];
                        }
                    } else {
                        $dataRincianBiayaPenyusutan[$i] = 0;
                    }
                } else {
                    $dataRincianBiayaPenyusutan[$i] = 0;
                }
            }

            for ($i = 0; $i < 12; $i++) {
                /* calculating total harga pokok penjualan */
                $totalPembelian[$i] = $dataAnnualPembelianIkan[$i][0]['Nominal'] + $dataAnnualPembelianMaterialPembantu[$i][0]['Nominal'] + $dataAnnualBiayaOverhead[$i][0]['Nominal'];
                $totalBiayaProduksi[$i] = $dataAnnualGajiHarian[$i][0]['Nominal'];

                /* calculating laba/rugi kotor */
                $labaRugiKotor[$i] = $totalPendapatan[$i] - ($totalPembelian[$i] + $totalBiayaProduksi[$i]);

                /* calcultaing laba/rugi operasi */
                $labaRugiOperasi[$i] = $labaRugiKotor[$i] - $dataAnnualGajiBulanan[$i][0]['Nominal'] - $dataAnnualPemasaran[$i][0]['Nominal'] - $dataAnnualAdminUmum[$i][0]['Nominal'];

                /* claculating laba/rugi bersih */
                $labaRugiBersih[$i] = $labaRugiOperasi[$i] + $dataAnnualPendapatanLuarUsaha[$i][0]['Nominal'] - $dataAnnualPengeluaranLuarUsaha[$i][0]['Nominal'];
            }

            $this->_activePrint(["print"], "print_laporan_laba_rugi_tahunan", "print_laporan_laba_rugi_tahunan");
            $this->set(compact("dataPembelianIkan", "dataPembelianMaterialPembantu", "dataBiayaOverhead"));
            $this->set(compact("dataRincianPenjualan", "dataRincianPembelianIkan", "dataRincianPembelianMaterialPembantu", "dataRincianBiayaOverhead", "dataRincianProduksi", "dataRincianAdminUmum", "dataRincianPemasaran", "dataRincianPendapatanLuarUsaha", "dataRincianPengeluaranLuarUsaha"));
            $this->set(compact("dataPenjualan", "dataGajiHarian", "dataGajiBulanan", "dataAdminUmum", "dataPemasaran", "dataPendapatanLuarUsaha", "dataPengeluaranLuarUsaha", "dataMaterialPembantu"));
            $this->set(compact("dataAnnualPenjualan", "dataAnnualPembelianIkan", "dataAnnualPembelianMaterialPembantu", "dataAnnualBiayaOverhead", "dataAnnualGajiHarian", "dataAnnualGajiBulanan", "dataAnnualAdminUmum", "dataAnnualPemasaran", "dataAnnualPendapatanLuarUsaha", "dataAnnualPengeluaranLuarUsaha", "dataAnnualMaterialPembantu"));
            $this->set(compact("totalPembelian", "totalPendapatan", "labaRugiKotor", "labaRugiOperasi", "labaRugiBersih", 'dataBiayaPenyusutan', 'dataRincianBiayaPenyusutan'));
            $this->set(compact("totalPembelianIkan", "totalPembelianMaterialPembantu"));
            $this->set(compact("dataGajiHarian", "dataGajiBulanan"));
        }
    }

    function admin_save_data_laba_rugi($amount, $month, $year) {
        $this->autoRender = false;
        if ($this->request->is("GET")) {
            if ($amount != null) {
                $dataLabaRugi = ClassRegistry::init("ProfitAndLoss")->find("first", [
                    "conditions" => [
                        "MONTH(ProfitAndLoss.created)" => $month,
                        "YEAR(ProfitAndLoss.created)" => $year
                    ]
                ]);
                if (!empty($dataLabaRugi)) {
                    $updatedData = [];
                    $updatedData['ProfitAndLoss']['id'] = $dataLabaRugi['ProfitAndLoss']['id'];
                    $updatedData['ProfitAndLoss']['nominal'] = $amount;
                    $updatedData['ProfitAndLoss']['print_date'] = date("Y-m-d H:i:s");
                    $updatedData['ProfitAndLoss']['month'] = $month;
                    $updatedData['ProfitAndLoss']['year'] = $year;
                    ClassRegistry::init("ProfitAndLoss")->save($updatedData);
                    return "Data has been successfully modified.";
                } else {
                    $newData = [];
                    $newData['ProfitAndLoss']['nominal'] = $amount;
                    $newData['ProfitAndLoss']['print_date'] = date("Y-m-d H:i:s");
                    $newData['ProfitAndLoss']['month'] = $month;
                    $newData['ProfitAndLoss']['year'] = $year;
                    ClassRegistry::init("ProfitAndLoss")->save($newData);
                    return "Data has been successfully saved.";
                }
            } else {
                return json_encode("Invalid Input.");
            }
        } else {
            return json_encode("Invalid Response!");
        }
    }

    function admin_add() {
        if ($this->request->is("post")) {
            $this->{ Inflector::classify($this->name) }->set($this->data);
            $this->{ Inflector::classify($this->name) }->_numberSeperatorRemover();
            if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                if ($this->GeneralEntry->data['GeneralEntry']['total_debit'] == $this->GeneralEntry->data['GeneralEntry']['total_credit']) {
                    $index = 0;
//                    debug($this->GeneralEntry->data);
                    if (!empty($this->GeneralEntry->data['GeneralEntry']['reference_number'])) {
                        $reference_number = $this->GeneralEntry->data['GeneralEntry']['reference_number'];
                    } else {
                        $reference_number = "TRANSAKSI UMUM";
                    }
                    $totalDebit = 0;
                    $totalCredit = 0;
                    $transaction_date = $this->GeneralEntry->data['GeneralEntry']['transaction_date'];
                    $transaction_type_id = $this->GeneralEntry->data['GeneralEntry']['transaction_type_id'];
                    $general_entry_account_type_id = $this->GeneralEntry->data['GeneralEntry']['general_entry_account_type_id'];
                    $transaction_name = !empty($this->GeneralEntry->data['GeneralEntry']['note']) ? $this->GeneralEntry->data['GeneralEntry']['note'] : "TRANSAKSI UMUM";
                    $note = !empty($this->GeneralEntry->data['GeneralEntry']['note']) ? " - " . $this->GeneralEntry->data['GeneralEntry']['note'] : "";
                    if (isset($this->GeneralEntry->data['GeneralEntry']['exchange_rate'])) {
                        $exchange_rate = $this->GeneralEntry->data['GeneralEntry']['exchange_rate'];
                    }
                    unset($this->GeneralEntry->data['GeneralEntry']);

                    /* Process Data Debit */
                    foreach ($this->GeneralEntry->data['GeneralEntryDebit'] as $debit) {
                        $totalDebit += $debit['debit'];
                        $dataGeneralEntryType = ClassRegistry::init("GeneralEntryType")->find("first", [
                            "conditions" => [
                                "GeneralEntryType.id" => $debit['general_entry_type_id']
                            ],
                            "recursive" => -1
                        ]);
                        $this->GeneralEntry->data['GeneralEntry'][$index]['transaction_name'] = $dataGeneralEntryType['GeneralEntryType']['name'] . $note;
                        $this->GeneralEntry->data['GeneralEntry'][$index]['reference_number'] = $reference_number;
                        if ($debit['currency'] == 'dollar') {
                            $this->GeneralEntry->data['GeneralEntry'][$index]['exchange_rate'] = $exchange_rate;
                        }
                        if ($dataGeneralEntryType['GeneralEntryType']['parent_id'] == 2 || $dataGeneralEntryType['GeneralEntryType']['parent_id'] == 3 || $dataGeneralEntryType['GeneralEntryType']['parent_id'] == 4) {
                            $this->GeneralEntry->data['GeneralEntry'][$index]['initial_balance'] = $dataGeneralEntryType['GeneralEntryType']['latest_balance'];
                            $this->GeneralEntry->data['GeneralEntry'][$index]['mutation_balance'] = $dataGeneralEntryType['GeneralEntryType']['latest_balance'] + $totalDebit;
                            $dataInitialBalance = ClassRegistry::init("InitialBalance")->find("first", [
                                "conditions" => [
                                    "InitialBalance.general_entry_type_id" => $debit['general_entry_type_id']
                                ]
                            ]);
                            $this->GeneralEntry->data['GeneralEntry'][$index]['initial_balance_id'] = $dataInitialBalance['InitialBalance']['id'];

                            /* update latest balance if coa type is cash */
                            $updatedData = [];
                            $updatedData['InitialBalance']['id'] = $dataInitialBalance['InitialBalance']['id'];
                            $updatedData['InitialBalance']['nominal'] = $dataGeneralEntryType['GeneralEntryType']['latest_balance'] + $totalDebit;
//                            debug("Initial Balance Debit");
//                            debug($updatedData);
                            ClassRegistry::init("InitialBalance")->save($updatedData);

                            /* posting to Transaction Mutation Table */
                            $dataTransactionMutation = [];
                            $dataTransactionMutation['TransactionMutation']['initial_balance_id'] = $dataInitialBalance['InitialBalance']['id'];
                            $dataTransactionMutation['TransactionMutation']['reference_number'] = $reference_number;
                            $dataTransactionMutation['TransactionMutation']['transaction_name'] = $transaction_name;
                            $dataTransactionMutation['TransactionMutation']['debit'] = $totalDebit;
                            $dataTransactionMutation['TransactionMutation']['transaction_date'] = $transaction_date;
                            $dataTransactionMutation['TransactionMutation']['initial_balance'] = $dataGeneralEntryType['GeneralEntryType']['latest_balance'];
                            $dataTransactionMutation['TransactionMutation']['mutation_balance'] = $dataGeneralEntryType['GeneralEntryType']['latest_balance'] + $totalDebit;
                            $dataTransactionMutation['TransactionMutation']['transaction_type_id'] = $transaction_type_id;
//                            debug("Transaction Mutation Debit");
//                            debug($dataTransactionMutation);
                            ClassRegistry::init("TransactionMutation")->save($dataTransactionMutation);
                        }
                        $this->GeneralEntry->data['GeneralEntry'][$index]['debit'] = $debit['debit'];
                        $this->GeneralEntry->data['GeneralEntry'][$index]['transaction_date'] = $transaction_date;
                        $this->GeneralEntry->data['GeneralEntry'][$index]['general_entry_type_id'] = $debit['general_entry_type_id'];
                        $this->GeneralEntry->data['GeneralEntry'][$index]['transaction_type_id'] = $transaction_type_id;
                        $this->GeneralEntry->data['GeneralEntry'][$index]['general_entry_account_type_id'] = $general_entry_account_type_id;
                        $this->GeneralEntry->data['GeneralEntry'][$index]['is_from_general_transaction'] = 1;

                        /* update the latest balance of each COAs */
                        $coa_code = $dataGeneralEntryType['GeneralEntryType']['code'];
                        $classification_coa_code = substr($coa_code, 0, 1);
                        if ($classification_coa_code == '1' || $classification_coa_code == '5' || $classification_coa_code == '6' || $classification_coa_code == '7' || $classification_coa_code == '9') {
                            ClassRegistry::init("GeneralEntryType")->increaseLatestBalance($debit['general_entry_type_id'], $debit['debit']);
                        } else {
                            ClassRegistry::init("GeneralEntryType")->decreaseLatestBalance($debit['general_entry_type_id'], $debit['debit']);
                        }
                        $index++;
                    }
                    unset($this->GeneralEntry->data['GeneralEntryDebit']);

                    /* Process Data Credit */
                    foreach ($this->GeneralEntry->data['GeneralEntryCredit'] as $credit) {
                        $totalCredit += $credit['credit'];
                        $dataGeneralEntryType = ClassRegistry::init("GeneralEntryType")->find("first", [
                            "conditions" => [
                                "GeneralEntryType.id" => $credit['general_entry_type_id']
                            ],
                            "recursive" => -1
                        ]);
                        $this->GeneralEntry->data['GeneralEntry'][$index]['transaction_name'] = $dataGeneralEntryType['GeneralEntryType']['name'] . $note;
                        $this->GeneralEntry->data['GeneralEntry'][$index]['reference_number'] = $reference_number;
                        if ($credit['currency'] == 'dollar') {
                            $this->GeneralEntry->data['GeneralEntry'][$index]['exchange_rate'] = $exchange_rate;
                        }
                        if ($dataGeneralEntryType['GeneralEntryType']['parent_id'] == 2 || $dataGeneralEntryType['GeneralEntryType']['parent_id'] == 3 || $dataGeneralEntryType['GeneralEntryType']['parent_id'] == 4) {
                            $this->GeneralEntry->data['GeneralEntry'][$index]['initial_balance'] = $dataGeneralEntryType['GeneralEntryType']['latest_balance'];
                            $this->GeneralEntry->data['GeneralEntry'][$index]['mutation_balance'] = $dataGeneralEntryType['GeneralEntryType']['latest_balance'] - $totalCredit;
                            $dataInitialBalance = ClassRegistry::init("InitialBalance")->find("first", [
                                "conditions" => [
                                    "InitialBalance.general_entry_type_id" => $credit['general_entry_type_id']
                                ]
                            ]);
                            $this->GeneralEntry->data['GeneralEntry'][$index]['initial_balance_id'] = $dataInitialBalance['InitialBalance']['id'];

                            /* update latest balance if coa type is cash */
                            $updatedData = [];
                            $updatedData['InitialBalance']['id'] = $dataInitialBalance['InitialBalance']['id'];
                            $updatedData['InitialBalance']['nominal'] = $dataGeneralEntryType['GeneralEntryType']['latest_balance'] - $totalCredit;
//                            debug("Initial Balance credit");
//                            debug($updatedData);
                            ClassRegistry::init("InitialBalance")->save($updatedData);

                            /* posting to Transaction Mutation Table */
                            $dataTransactionMutation = [];
                            $dataTransactionMutation['TransactionMutation']['initial_balance_id'] = $dataInitialBalance['InitialBalance']['id'];
                            $dataTransactionMutation['TransactionMutation']['reference_number'] = $reference_number;
                            $dataTransactionMutation['TransactionMutation']['transaction_name'] = $transaction_name;
                            $dataTransactionMutation['TransactionMutation']['credit'] = $totalCredit;
                            $dataTransactionMutation['TransactionMutation']['transaction_date'] = $transaction_date;
                            $dataTransactionMutation['TransactionMutation']['initial_balance'] = $dataGeneralEntryType['GeneralEntryType']['latest_balance'];
                            $dataTransactionMutation['TransactionMutation']['mutation_balance'] = $dataGeneralEntryType['GeneralEntryType']['latest_balance'] - $totalCredit;
                            $dataTransactionMutation['TransactionMutation']['transaction_type_id'] = $transaction_type_id;
//                            debug("Transaction Mutation Credit");
//                            debug($dataTransactionMutation);
                            ClassRegistry::init("TransactionMutation")->save($dataTransactionMutation);
                        }
                        $this->GeneralEntry->data['GeneralEntry'][$index]['credit'] = $credit['credit'];
                        $this->GeneralEntry->data['GeneralEntry'][$index]['transaction_date'] = $transaction_date;
                        $this->GeneralEntry->data['GeneralEntry'][$index]['general_entry_type_id'] = $credit['general_entry_type_id'];
                        $this->GeneralEntry->data['GeneralEntry'][$index]['transaction_type_id'] = $transaction_type_id;
                        $this->GeneralEntry->data['GeneralEntry'][$index]['general_entry_account_type_id'] = $general_entry_account_type_id;
                        $this->GeneralEntry->data['GeneralEntry'][$index]['is_from_general_transaction'] = 1;

                        /* update the latest balance of each COAs */
                        $coa_code = $dataGeneralEntryType['GeneralEntryType']['code'];
                        $classification_coa_code = substr($coa_code, 0, 1);
                        if ($classification_coa_code == '2' || $classification_coa_code == '3' || $classification_coa_code == '4' || $classification_coa_code == '8') {
                            ClassRegistry::init("GeneralEntryType")->increaseLatestBalance($credit['general_entry_type_id'], $credit['credit']);
                        } else {
                            ClassRegistry::init("GeneralEntryType")->decreaseLatestBalance($credit['general_entry_type_id'], $credit['credit']);
                        }
                        $index++;
                    }
                    unset($this->GeneralEntry->data['GeneralEntryCredit']);
//                    debug($this->GeneralEntry->data);
//                    die;
                    foreach ($this->GeneralEntry->data as $data) {
                        $this->GeneralEntry->saveAll($data);
                    }

                    $this->Session->setFlash(__("Data berhasil disimpan"), 'default', array(), 'success');
                    $this->redirect(array('action' => 'admin_general_transaction'));
                } else {
                    $this->Session->setFlash(__("Total Debit & Kredit Tidak Seimbang."), 'default', array(), 'danger');
                }
            } else {
                $this->validationErrors = $this->{ Inflector::classify($this->name) }->validationErrors;
                $this->Session->setFlash(__("Harap mengecek kembali kesalahan dibawah."), 'default', array(), 'danger');
            }
        }
    }

    function admin_general_transaction() {
        $this->_activePrint(func_get_args(), "data_general_transaction");
        $this->_setPeriodeLaporanDate("awal_GeneralEntry_transaction_date", "akhir_GeneralEntry_transaction_date");
        $conds = ["GeneralEntry.is_from_general_transaction" => 1];
        $today = date("Y-m-d");
        $defaultConds = [
            "DATE_FORMAT(GeneralEntry.transaction_date, '%Y-%m-%d')" => $today
        ];
        if (!empty($this->request->query['awal_GeneralEntry_transaction_date']) && empty($this->request->query['akhir_GeneralEntry_transaction_date'])) {
            $defaultConds = [];
            $startDate = $this->request->query['awal_GeneralEntry_transaction_date'];
            $conds[] = [
                "DATE_FORMAT(GeneralEntry.transaction_date, '%Y-%m-%d') >=" => $startDate
            ];
            unset($_GET['awal_GeneralEntry_transaction_date']);
        }
        if (empty($this->request->query['awal_GeneralEntry_transaction_date']) && !empty($this->request->query['akhir_GeneralEntry_transaction_date'])) {
            $defaultConds = [];
            $endDate = $this->request->query['akhir_GeneralEntry_transaction_date'];
            $conds[] = [
                "DATE_FORMAT(GeneralEntry.transaction_date, '%Y-%m-%d') <=" => $endDate
            ];
            unset($_GET['end_date']);
        }
        if (!empty($this->request->query['awal_GeneralEntry_transaction_date']) && !empty($this->request->query['akhir_GeneralEntry_transaction_date'])) {
            $defaultConds = [];
            $startDate = $this->request->query['awal_GeneralEntry_transaction_date'];
            $endDate = $this->request->query['akhir_GeneralEntry_transaction_date'];
            $conds[] = [
                "DATE_FORMAT(GeneralEntry.transaction_date, '%Y-%m-%d') >=" => $startDate,
                "DATE_FORMAT(GeneralEntry.transaction_date, '%Y-%m-%d') <=" => $endDate
            ];
            unset($_GET['awal_GeneralEntry_transaction_date']);
            unset($_GET['akhir_GeneralEntry_transaction_date']);
        }
        $generalEntries = $this->GeneralEntry->find("all", [
            "conditions" => [
                $conds,
                $defaultConds
            ],
            "order" => [
                "GeneralEntry.id",
                "GeneralEntry.transaction_date"
            ],
            "contain" => [
                "CashIn",
                "CashDisbursement",
                "PaymentPurchase",
                "PaymentSale" => [
                    "Sale"
                ],
                "CashMutation",
                "TransactionType",
                "EmployeeSalary",
                "GeneralEntryType",
                "InitialBalance" => [
                    "Currency"
                ],
                "Sale",
                "Shipment" => [
                    "Sale" => [
                        "Buyer"
                    ]
                ]
            ]
        ]);
        $this->set(compact("generalEntries", "startDate", "endDate"));
        parent::admin_index();
    }

}
