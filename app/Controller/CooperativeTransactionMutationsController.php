<?php

App::uses('AppController', 'Controller');

class CooperativeTransactionMutationsController extends AppController {

    var $name = "CooperativeTransactionMutations";
    var $disabledAction = array(
    );
    var $contain = [
        "EmployeeDataDeposit" => [
            "CooperativeCash"
        ],
        "EmployeeDataLoan" => [
            "CooperativeCash"
        ],
        "CooperativeCashReceipt" => [
            "CooperativeCash"
        ],
        "CooperativeCashDisbursement" => [
            "CooperativeCash"
        ],
        "Employee" => [
            "Account" => [
                "Biodata"
            ],
            "Department"
        ],
        "CooperativeTransactionType",
        "CooperativeCash",
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

    function admin_transaction_data() {
        $this->periodeLaporanField = "CooperativeTransactionMutation_transaction_date";
        $this->_activePrint(func_get_args(), "data_transaksi_koperasi");
        $conds = [];
        $this->conds = [
            "CooperativeTransactionType.code" => ["PNJL", "PMBL"],
        ];
        $this->contain = am([
            "CooperativeTransactionType",
            "Employee" => [
                "Account" => [
                    "Biodata",
                ],
            ],
            "CooperativeCash",
                ], $this->CooperativeTransactionMutation->_getRelatedModel("jualbeli"));
        parent::admin_index();
    }

    function admin_transaction_report() {
        $this->_activePrint(func_get_args(), "laporan_transaksi_koperasi");
        $this->_setPeriodeLaporanDate("awal_CooperativeTransactionMutation_transaction_date", "akhir_CooperativeTransactionMutation_transaction_date");
        $this->contain = am([
            "CooperativeTransactionType",
            "Employee" => [
                "Account" => [
                    "Biodata",
                ],
            ],
            "CooperativeCash",
                ], $this->CooperativeTransactionMutation->_getRelatedModel(["reduction", "increase"]));
        if (isset($this->request->query["nomor_transaksi"]) && !empty($this->request->query["nomor_transaksi"])) {
            $nomorTransaksi = $this->request->query["nomor_transaksi"];
            unset($this->request->query["nomor_transaksi"]);
            $this->conds = $this->_generateFilterNomorTransaksi($nomorTransaksi, ["reduction", "increase"]);
        }
        parent::admin_index();
        if (isset($nomorTransaksi)) {
            $this->request->query["nomor_transaksi"] = $nomorTransaksi;
        }
        
        // get the initial amount & latest amount of each Cooperative Cashes
        $dataCoopCash = ClassRegistry::init("CooperativeCash")->find("all", ['recursive' => -1]);
        $data_amount_coop_cash = [];
        foreach ($dataCoopCash as $coopCash) {
            $dataTransMutation = $this->CooperativeTransactionMutation->find("first",[
                "conditions" => [
                    "CooperativeTransactionMutation.cooperative_cash_id" => $coopCash['CooperativeCash']['id']
                ],
                "order" => "CooperativeTransactionMutation.id",
                "recursive" => -1
            ]);
            if(!empty($dataTransMutation)) {
                $data_amount_coop_cash[] = [
                    "name" => $coopCash['CooperativeCash']['name'],
                    "initial_balance" => $dataTransMutation['CooperativeTransactionMutation']['balance_before_transaction'],
                    "latest_balance" => $coopCash['CooperativeCash']['nominal']
                ];
            }
        }
        $this->set(compact('data_amount_coop_cash'));
    }

    function admin_earning() {
        $this->_activePrint(func_get_args(), "laporan_pendapatan_koperasi");
        $conds = [];
        if (!empty($this->request->query['select_Employee_branch_office_id'])) {
            $conds = [
                "Employee.branch_office_id" => $this->request->query['select_Employee_branch_office_id']
            ];
        }
        if (isset($this->request->query)) {
            if (!empty($this->request->query['start_date'])) {
                $startDate = $this->request->query['start_date'];
                $newStartDate = date("Y-m-d H:i:s", strtotime($startDate));
                $conds = [
                    "DATE_FORMAT(CooperativeTransactionMutation.transaction_date, '%Y-%m-%d %H:%i:%s') >=" => $newStartDate
                ];
                unset($_GET["start_date"]);
            }

            if (!empty($this->request->query['end_date'])) {
                $endDate = $this->request->query['end_date'];
                $newEndDate = date("Y-m-d H:i:s", strtotime($endDate));
                $conds = [
                    "DATE_FORMAT(CooperativeTransactionMutation.transaction_date, '%Y-%m-%d %H:%i:%s') <=" => $newEndDate
                ];
                unset($_GET['end_date']);
            }
        }
        $this->conds = [
            "CooperativeTransactionMutation.cooperative_transaction_type_id" => [2, 5, 6],
            $conds
        ];
        parent::admin_index();
    }

    function admin_expenditure() {
        $this->_activePrint(func_get_args(), "laporan_pengeluaran_koperasi");
        $conds = [];
        if (isset($this->request->query)) {
            if (!empty($this->request->query['start_date'])) {
                $startDate = $this->request->query['start_date'];
                $newStartDate = date("Y-m-d H:i:s", strtotime($startDate));
                $conds = [
                    "DATE_FORMAT(CooperativeTransactionMutation.transaction_date, '%Y-%m-%d %H:%i:%s') >=" => $newStartDate
                ];
                unset($_GET["start_date"]);
            }

            if (!empty($this->request->query['end_date'])) {
                $endDate = $this->request->query['end_date'];
                $newEndDate = date("Y-m-d H:i:s", strtotime($endDate));
                $conds = [
                    "DATE_FORMAT(CooperativeTransactionMutation.transaction_date, '%Y-%m-%d %H:%i:%s') <=" => $newEndDate
                ];
                unset($_GET['end_date']);
            }
        }
        $this->conds = [
            "CooperativeTransactionMutation.cooperative_transaction_type_id" => [1, 3, 4, 7],
            $conds
        ];
        parent::admin_index();
    }

    function admin_cash_in() {
        $this->_activePrint(func_get_args(), "cooperative-transaction-mutation_cash_in");
        $this->_setPeriodeLaporanDate("awal_CooperativeTransactionMutation_transaction_date", "akhir_CooperativeTransactionMutation_transaction_date");
        $this->contain = am([
            "CooperativeTransactionType",
            "Employee" => [
                "Account" => [
                    "Biodata",
                ],
            ],
            "CooperativeCash",
                ], $this->CooperativeTransactionMutation->_getRelatedModel("increase")
        );
        $this->conds = [
            "CooperativeTransactionType.operation" => "increase",
        ];
        if (isset($this->request->query["nomor_transaksi"]) && !empty($this->request->query["nomor_transaksi"])) {
            $nomorTransaksi = $this->request->query["nomor_transaksi"];
            unset($this->request->query["nomor_transaksi"]);
            $this->conds = $this->_generateFilterNomorTransaksi($nomorTransaksi, "increase");
        }
        $this->order = "CooperativeTransactionMutation.transaction_date desc";
        parent::admin_index();
        if (isset($nomorTransaksi)) {
            $this->request->query["nomor_transaksi"] = $nomorTransaksi;
        }
    }

    function admin_cash_out() {
        $this->_activePrint(func_get_args(), "cooperative-transaction-mutation_cash_out");
        $this->_setPeriodeLaporanDate("awal_CooperativeTransactionMutation_transaction_date", "akhir_CooperativeTransactionMutation_transaction_date");
        $this->contain = am([
            "CooperativeTransactionType",
            "Employee" => [
                "Account" => [
                    "Biodata",
                ],
            ],
            "CooperativeCash",
                ], $this->CooperativeTransactionMutation->_getRelatedModel("reduction"));
        $this->conds = [
            "CooperativeTransactionType.operation" => "reduction",
        ];
        if (isset($this->request->query["nomor_transaksi"]) && !empty($this->request->query["nomor_transaksi"])) {
            $nomorTransaksi = $this->request->query["nomor_transaksi"];
            unset($this->request->query["nomor_transaksi"]);
            $this->conds = $this->_generateFilterNomorTransaksi($nomorTransaksi, "reduction");
        }
        $this->order = "CooperativeTransactionMutation.transaction_date desc";
        parent::admin_index();
        if (isset($nomorTransaksi)) {
            $this->request->query["nomor_transaksi"] = $nomorTransaksi;
        }
    }

    function _options() {
        $this->set("departments", $this->CooperativeTransactionMutation->Employee->Department->find("list", ["fields" => ["Department.id", "Department.name"]]));
        $this->set("branchOffices", $this->CooperativeTransactionMutation->Employee->BranchOffice->find("list", array("fields" => array("BranchOffice.id", "BranchOffice.name"))));
        $this->set("cooperativeCashes", ClassRegistry::init("CooperativeCash")->getListWithFullLabel());
        $this->set("cooperativeTransactionTypes", $this->CooperativeTransactionMutation->CooperativeTransactionType->find("list", array("fields" => array("CooperativeTransactionType.id", "CooperativeTransactionType.name"))));
    }

    function _generateFilterNomorTransaksi($nomorTransaksi, $type) {
        $this->CooperativeTransactionMutation->mapNomor;
        $result = [];
        foreach ($this->CooperativeTransactionMutation->_getRelatedModel($type, "code") as $code => $modelName) {
            $result["$modelName.{$this->CooperativeTransactionMutation->mapNomor["$code"]} like"] = "%$nomorTransaksi%";
        }
        return ["or" => $result];
    }

    function admin_print_transaction_mutation($id) {
        $this->_activePrint(["print"], "print_cooperative_transaction_mutation", "kwitansi");
        $this->_setPeriodeLaporanDate("awal_CooperativeTransactionMutation_transaction_date", "akhir_CooperativeTransactionMutation_transaction_date");
        $rows = $this->CooperativeTransactionMutation->find("first", [
            "conditions" => [
                "CooperativeTransactionMutation.id" => $id
            ],
            "contain" => [
                "CooperativeTransactionType",
                "Employee" => [
                    "Account" => [
                        "Biodata"
                    ]
                ]
            ]
        ]);
        $data = [
            'title' => 'Transaksi Kas Masuk Koperasi',
            'rows' => $rows
        ];
        $this->set(compact('data'));
    }
    
    /*
     * WARNING!!!
     * For general purpose, this function generates the balance before and after the transaction.
     * call this function ONLY when necessary.
     */
    function admin_generate_balance_before_and_after_transaction() {
        $this->autoRender = false;
        $this->CooperativeTransactionMutation->generate_balance_before_and_after_transaction();
    }
}
