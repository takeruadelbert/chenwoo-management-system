<?php

App::uses('AppController', 'Controller');

class EmployeeDataDepositsController extends AppController {

    var $name = "EmployeeDataDeposits";
    var $disabledAction = array(
    );
    var $contain = [
        "Employee" => [
            "Account" => [
                "Biodata"
            ],
        ],
        "Creator" => [
            "Account" => [
                "Biodata"
            ],
        ],
        "EmployeeBalance",
        "VerifyStatus",
        "DepositIoType",
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
        $this->set("departments", $this->EmployeeDataDeposit->Employee->Department->find("list", ["fields" => ["Department.id", "Department.name"]]));
        $this->set("cooperativeCashes", $this->EmployeeDataDeposit->CooperativeCash->getListWithFullLabel());
        $this->set("branchOffices", $this->EmployeeDataDeposit->Employee->BranchOffice->find("list", array("fields" => array("BranchOffice.id", "BranchOffice.name"))));
        $this->set("verifyStatuses", $this->EmployeeDataDeposit->VerifyStatus->find("list", ["fields" => ["VerifyStatus.id", "VerifyStatus.name"]]));
        $this->set("depositIoTypes", $this->EmployeeDataDeposit->DepositIoType->find("list", ["fields" => ["DepositIoType.id", "DepositIoType.name"]]));
    }

    function admin_index() {
        $this->_activePrint(func_get_args(), "data_simpanan_pegawai");
        $this->_setPeriodeLaporanDate("awal_EmployeeDataDeposit_transaction_date", "akhir_EmployeeDataDeposit_transaction_date");
        $this->conds = [
            "EmployeeDataDeposit.deposit_io_type_id" => 1,
        ];
        parent::admin_index();
    }

    function admin_transaction() {
        $this->_activePrint(func_get_args(), "data_transaksi_simpanan_pegawai");
        $this->_setPeriodeLaporanDate("awal_EmployeeDataDeposit_transaction_date", "akhir_EmployeeDataDeposit_transaction_date");
        if (isset($this->request->query["select_EmployeeDataDeposit_employee_id"]) && !empty($this->request->query["select_EmployeeDataDeposit_employee_id"])) {
            $employeeId = $this->request->query["select_EmployeeDataDeposit_employee_id"];
            $conds = [];
            if (isset($this->request->query["awal_EmployeeDataDeposit_transaction_date"]) && !empty($this->request->query["awal_EmployeeDataDeposit_transaction_date"])) {
                $conds["date(EmployeeDataDeposit.verified_datetime) >="] = $this->request->query["awal_EmployeeDataDeposit_transaction_date"];
            }
            if (isset($this->request->query["akhir_EmployeeDataDeposit_transaction_date"]) && !empty($this->request->query["akhir_EmployeeDataDeposit_transaction_date"])) {
                $conds["date(EmployeeDataDeposit.verified_datetime) <="] = $this->request->query["akhir_EmployeeDataDeposit_transaction_date"];
            }
            $employee = ClassRegistry::init("Employee")->find("first", [
                "conditions" => [
                    "Employee.id" => $employeeId,
                ],
                "contain" => [
                    "Account" => [
                        "Biodata",
                    ],
                ],
            ]);
            $employeeDataDeposits = $this->EmployeeDataDeposit->find("all", [
                "conditions" => [
                    "EmployeeDataDeposit.employee_id" => $employeeId,
                    $conds,
                ],
                "order" => "EmployeeDataDeposit.verified_datetime asc",
                "contain" => [
                    "DepositIoType",
                ],
            ]);
            $this->set(compact("employeeDataDeposits","employee"));
        }
    }

    function admin_deposit_report() {
        $this->_activePrint(func_get_args(), "laporan_simpanan_pegawai");
        $this->_setPeriodeLaporanDate("awal_EmployeeDataDeposit_transaction_date", "akhir_EmployeeDataDeposit_transaction_date");
        $this->conds = [
            "EmployeeDataDeposit.deposit_io_type_id" => [1, 2],
            "EmployeeDataDeposit.verify_status_id" => 3,
        ];
        parent::admin_index();
    }

    function admin_withdrawal() {
        $this->_activePrint(func_get_args(), "data_penarikan_simpanan_pegawai");
        $this->_setPeriodeLaporanDate("awal_EmployeeDataDeposit_transaction_date", "akhir_EmployeeDataDeposit_transaction_date");
        $this->conds = [
            "EmployeeDataDeposit.deposit_io_type_id" => 2,
        ];
        parent::admin_index();
    }

    function view_employee_data_deposit($id = null) {
        if ($this->EmployeeDataDeposit->exists($id)) {
            $this->autoRender = false;
            if ($this->request->is("GET")) {
                $data = $this->EmployeeDataDeposit->find("first", [
                    "conditions" => [
                        "EmployeeDataDeposit.id" => $id
                    ],
                    "contain" => [
                        "Employee" => [
                            "Account" => [
                                "Biodata"
                            ],
                            "Department",
                            "Office"
                        ],
                        "CooperativeDeposit",
                        "CooperativeCash"
                    ]
                ]);
                return json_encode($data);
            } else {
                return json_encode($this->_generateStatusCode(400));
            }
        } else {
            throw new NotFoundException(__("Data Not Found"));
        }
    }

    function admin_add() {
        if ($this->request->is("post")) {
            $this->{ Inflector::classify($this->name) }->set($this->data);
            if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                $this->EmployeeDataDeposit->_numberSeperatorRemover();
                $this->EmployeeDataDeposit->data['EmployeeDataDeposit']['deposit_io_type_id'] = 1;

                $this->EmployeeDataDeposit->data['EmployeeDataDeposit']['creator_id'] = $this->stnAdmin->getEmployeeId();


                $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
                $employeeDataDepositId = $this->EmployeeDataDeposit->getLastInsertID();
                $this->EmployeeDataDeposit->generateNomorSimpanan($employeeDataDepositId);
                $data = $this->EmployeeDataDeposit->find("first", array("conditions" => array("EmployeeDataDeposit.id" => $this->EmployeeDataDeposit->getLastInsertId()), "recursive" => -1));
                $entity = $data["EmployeeDataDeposit"];
                //create account number
                $this->EmployeeDataDeposit->EmployeeBalance->createAccountNumber($entity["employee_id"]);
                $this->Session->setFlash(__("Simpanan berhasil ditambahkan"), 'default', array(), 'success');
                $this->redirect(array('action' => 'admin_index'));
            } else {
                $this->validationErrors = $this->{ Inflector::classify($this->name) }->validationErrors;
                $this->Session->setFlash(__("Harap mengecek kembali kesalahan dibawah."), 'default', array(), 'danger');
            }
        }
    }

    function admin_change_status_verify() {
        $this->autoRender = false;
        if ($this->request->is("PUT")) {
            $this->EmployeeDataDeposit->data['EmployeeDataDeposit']['id'] = $this->request->data['id'];
            $this->EmployeeDataDeposit->data['EmployeeDataDeposit']['verify_status_id'] = $this->request->data['status'];
            if ($this->request->data['status'] !== '1') {
                $this->EmployeeDataDeposit->data['EmployeeDataDeposit']['verified_by_id'] = $this->_getEmployeeId();
                $this->EmployeeDataDeposit->data['EmployeeDataDeposit']['verified_datetime'] = date("Y-m-d H:i:s");
            } else {
                $this->EmployeeDataDeposit->data['EmployeeDataDeposit']['verified_by_id'] = null;
                $this->EmployeeDataDeposit->data['EmployeeDataDeposit']['verified_datetime'] = null;
            }
            $this->EmployeeDataDeposit->saveAll();
            $data = $this->EmployeeDataDeposit->find("first", array("conditions" => array("EmployeeDataDeposit.id" => $this->request->data['id'])));
            $entity = $data["EmployeeDataDeposit"];
            if ($this->request->data["status"] == 3) {
                //update to cooperative cash
                ClassRegistry::init("CooperativeTransactionMutation")->addMutation($entity["cooperative_cash_id"], $entity["id"], "SMPS", $entity["amount"], $entity["transaction_date"]);
                //top up balance
                $this->EmployeeDataDeposit->EmployeeBalance->topupBalanceByEmployeeDataDeposit($entity["id"], $entity["amount"]);
            }
            echo json_encode($this->_generateStatusCode(207, null, array("status_label" => $data['VerifyStatus']['name'])));
        } else {
            echo json_encode($this->_generateStatusCode(400));
        }
    }

    function admin_get_balance($employee_id = null) {
        $this->autoRender = false;
        if (!empty($employee_id)) {
            if ($this->request->is("GET")) {
                $data = $this->EmployeeDataDeposit->EmployeeBalance->find("first", [
                    "conditions" => [
                        "EmployeeBalance.employee_id" => $employee_id
                    ],
                ]);
                $isNew = false;
                if (empty($data)) {
                    $balance = 0;
                    $isNew = true;
                    $accountNumber = "";
                } else {
                    $balance = $data["EmployeeBalance"]["amount"];
                    $isNew = false;
                    $accountNumber = $data["EmployeeBalance"]["account_number"];
                }
                return json_encode($this->_generateStatusCode(206, null, ["is_new" => $isNew, "balance" => $balance, "employee_id" => $employee_id, "account_number" => $accountNumber]));
            } else {
                return json_encode($this->_generateStatusCode(400));
            }
        } else {
            return json_encode($this->_generateStatusCode(405));
        }
    }

    function admin_add_withdrawal() {
        if ($this->request->is("post")) {
            $this->{ Inflector::classify($this->name) }->set($this->data);
            if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                $this->EmployeeDataDeposit->_numberSeperatorRemover();
                $this->EmployeeDataDeposit->data['EmployeeDataDeposit']['deposit_io_type_id'] = 2;
                $this->EmployeeDataDeposit->data['EmployeeDataDeposit']['creator_id'] = $this->stnAdmin->getEmployeeId();
                $employeeBalance = $this->EmployeeDataDeposit->EmployeeBalance->find("first", [
                    "conditions" => [
                        "EmployeeBalance.employee_id" => $this->data['EmployeeDataDeposit']['employee_id']
                    ]
                ]);
                $this->EmployeeDataDeposit->data['EmployeeDataDeposit']['employee_balance_id'] = $employeeBalance["EmployeeBalance"]["id"];
                if ($this->EmployeeDataDeposit->data['EmployeeDataDeposit']['amount'] > $employeeBalance["EmployeeBalance"]["amount"]) {
                    $this->Session->setFlash(__("Jumlah penarikan melebihi saldo tabungan!!!"), 'default', array(), 'danger');
                    $this->redirect(array('action' => 'admin_add_withdrawal'));
                } else {
                    $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
                    $this->EmployeeDataDeposit->generateNomorPenarikan($this->EmployeeDataDeposit->getLastInsertId());
                    $this->Session->setFlash(__("Data berhasil disimpan"), 'default', array(), 'success');
                    $this->redirect(array('action' => 'admin_withdrawal'));
                }
            } else {
                $this->validationErrors = $this->{ Inflector::classify($this->name) }->validationErrors;
                $this->Session->setFlash(__("Harap mengecek kembali kesalahan dibawah."), 'default', array(), 'danger');
            }
        }
    }

    function admin_change_status_verify_withdrawal() {
        $this->autoRender = false;
        if ($this->request->is("PUT")) {
            $this->EmployeeDataDeposit->data['EmployeeDataDeposit']['id'] = $this->request->data['id'];
            $this->EmployeeDataDeposit->data['EmployeeDataDeposit']['verify_status_id'] = $this->request->data['status'];
            if ($this->request->data['status'] !== '1') {
                $this->EmployeeDataDeposit->data['EmployeeDataDeposit']['verified_by_id'] = $this->_getEmployeeId();
                $this->EmployeeDataDeposit->data['EmployeeDataDeposit']['verified_datetime'] = date("Y-m-d H:i:s");
            } else {
                $this->EmployeeDataDeposit->data['EmployeeDataDeposit']['verified_by_id'] = null;
                $this->EmployeeDataDeposit->data['EmployeeDataDeposit']['verified_datetime'] = null;
            }
            $this->EmployeeDataDeposit->saveAll();
            $data = $this->EmployeeDataDeposit->find("first", array("conditions" => array("EmployeeDataDeposit.id" => $this->request->data['id'])));
            $entity = $data["EmployeeDataDeposit"];
            if ($this->request->data["status"] == 3) {
                //update to cooperative cash
                ClassRegistry::init("CooperativeTransactionMutation")->addMutation($entity["cooperative_cash_id"], $entity["id"], "SMPT", $entity["amount"], $entity["transaction_date"]);
                //top up balance
                $this->EmployeeDataDeposit->EmployeeBalance->reduceBalanceByEmployeeDataDeposit($entity["id"], $entity["amount"]);
            }
            echo json_encode($this->_generateStatusCode(207, null, array("status_label" => $data['VerifyStatus']['name'])));
        } else {
            echo json_encode($this->_generateStatusCode(400));
        }
    }

    function admin_list() {
        $this->autoRender = false;
        $conds = [];
        if (isset($this->request->query['q'])) {
            $q = $this->request->query['q'];
            $conds[] = array(
                "or" => array(
                    "Biodata.first_name like" => "%$q%",
                    "Biodata.last_name like" => "%$q%",
            ));
        }
        $suggestions = ClassRegistry::init("Account")->find("all", array(
            "conditions" => $conds,
            "contain" => array(
                "Biodata",
                "Employee" => [
                    "EmployeeBalance",
                    "Office",
                    "Department"
                ]
            ),
            "limit"=>10,
        ));
        $result = [];
        foreach ($suggestions as $item) {
            if (!empty($item['Employee']['EmployeeBalance'])) {
                $result[] = [
                    "id" => $item['Employee']['id'],
                    "full_name" => $item['Biodata']['full_name'],
                    "nip" => @$item['Employee']['nip'],
                    "jabatan" => @$item['Employee']['Office']['name'],
                    "jabatan_id" => @$item['Employee']['Office']['id'],
                    "department" => @$item['Employee']['Department']['name'],
                    "department_uniq_name" => @$item['Employee']['Department']['uniq_name'],
                ];
            }
        }
        echo json_encode($result);
    }

    function admin_simpanan_index() {
        $this->_activePrint(func_get_args(), "simpanan");

//        $this->conds = [
//            "EmployeeDataDeposit.employee_id" => $this->_getEmployeeId(),
//            am($this->conds, $dtConds),
//        ];
//        $this->order = "EmployeeDataDeposit.id DESC";

        $dataDeposit = ClassRegistry::init("EmployeeDataDeposit")->find("first", [
            "conditions" => [
                "EmployeeDataDeposit.employee_id" => $this->Session->read("credential.admin.Employee.id"),
            ],
            "order" => "EmployeeDataDeposit.id DESC",
        ]);
        $this->set(compact("dataDeposit"));
    }

    function admin_get_deposit_interest($amount) {
        $this->autoRender = false;
        if ($this->request->is("GET")) {
            $data = $this->EmployeeDataDeposit->CooperativeDeposit->find("first", [
                "conditions" => [
                    "CooperativeDeposit.bottom_limit <=" => $amount,
                    "CooperativeDeposit.upper_limit >=" => $amount
                ]
            ]);
            return json_encode($data);
        } else {
            return json_encode($this->_generateStatusCode(400));
        }
    }

    function admin_print_deposit($id = null) {
        if ($this->EmployeeDataDeposit->exists($id)) {
            $rows = $this->{ Inflector::classify($this->name) }->find('first', array(
                'conditions' => array(
                    Inflector::classify($this->name) . '.id' => $id,
//                    Inflector::classify($this->name) . '.verify_status_id' => 1,
                ),
                'contain' => [
                    "Employee" => [
                        "Account" => [
                            "Biodata" => [
                            ],
                        ],
                        "Department",
                        "Office",
                        "EmployeeType",
                    ],
                    "EmployeeBalance",
                ],
            ));
            $this->data = $rows;
            $data = array(
                'title' => 'KOPERASI KARYAWAN "MANDIRI" PT. CHEN WOO FISHERY <br> BUKTI KAS MASUK',
                'title2' => 'KOPERASI KARYAWAN "MANDIRI" PT. CHEN WOO FISHERY <br> BUKTI SETORAN TABUNGAN',
                'rows' => $rows,
            );
            $this->set(compact('data'));
            $this->_activePrint(["print"], "print_deposit", "bukti_kas_masuk");
        } else {
            throw new NotFoundException(__("404 Data Not Found."));
        }
    }

    function admin_print_withdrawal($id = null) {
        if ($this->EmployeeDataDeposit->exists($id)) {
            $rows = $this->{ Inflector::classify($this->name) }->find('first', array(
                'conditions' => array(
                    Inflector::classify($this->name) . '.id' => $id,
                ),
                'contain' => [
                    "Employee" => [
                        "Account" => [
                            "Biodata" => [
                            ],
                        ],
                        "Department",
                        "Office",
                        "EmployeeType",
                    ],
                    "EmployeeBalance",
                ],
            ));
            $this->data = $rows;
            $data = array(
                'title' => 'KOPERASI KARYAWAN "MANDIRI" PT. CHEN WOO FISHERY <br> BUKTI KAS KELUAR',
                'title2' => 'KOPERASI KARYAWAN "MANDIRI" PT. CHEN WOO FISHERY',
                'rows' => $rows,
            );
            $this->set(compact('data'));
            $this->_activePrint(["print"], "print_withdrawal", "bukti_kas_masuk");
        } else {
            throw new NotFoundException(__("404 Data Not Found."));
        }
    }

    function cron_interest() {
        $this->autoRender = false;
        $employeeBalances = $this->EmployeeDataDeposit->EmployeeBalance->find("all", [
            "recursive" => -1,
        ]);
        foreach ($employeeBalances as $employeeBalance) {
            $employeeDataDeposit = $this->EmployeeDataDeposit->find("first", [
                "recursive" => -1,
                "order" => "EmployeeDataDeposit.verified_datetime asc",
                "limit" => 1,
                "conditions" => [
                    "EmployeeDataDeposit.employee_balance_id" => $employeeBalance["EmployeeBalance"]["id"],
                    "EmployeeDataDeposit.verify_status_id" => 3,
                    "EmployeeDataDeposit.deposit_io_type_id" => 1,
                ],
            ]);
            $employeeBalanceId = $employeeBalance["EmployeeBalance"]["id"];
            $lastestEmployeeBalance = $employeeBalance["EmployeeBalance"]["amount"];
            $proccesingMY = date("Y-m", strtotime($employeeDataDeposit["EmployeeDataDeposit"]["verified_datetime"]));
            $currentMY = date("Y-m");
            while (strtotime($proccesingMY) < strtotime($currentMY)) {
                $year = date("Y", strtotime($proccesingMY));
                $month = date("m", strtotime($proccesingMY));
                //check if this month interest have been added
                $employeeDataDepositInterest = $this->EmployeeDataDeposit->find("first", [
                    "recursive" => -1,
                    "limit" => 1,
                    "conditions" => [
                        "EmployeeDataDeposit.employee_balance_id" => $employeeBalance["EmployeeBalance"]["id"],
                        "EmployeeDataDeposit.verify_status_id" => 3,
                        "EmployeeDataDeposit.deposit_io_type_id" => 3,
                        "YEAR(EmployeeDataDeposit.verified_datetime)" => $year,
                        "MONTH(EmployeeDataDeposit.verified_datetime)" => $month,
                    ],
                ]);
                //if no interest added, procced to this
                if (empty($employeeDataDepositInterest)) {
                    $employeeDataDeposit = $this->EmployeeDataDeposit->find("first", [
                        "recursive" => -1,
                        "order" => "EmployeeDataDeposit.verified_datetime desc",
                        "conditions" => [
                            "EmployeeDataDeposit.employee_balance_id" => $employeeBalance["EmployeeBalance"]["id"],
                            "EmployeeDataDeposit.verify_status_id" => 3,
                            "EmployeeDataDeposit.deposit_io_type_id" => [1, 2],
                            "YEAR(EmployeeDataDeposit.verified_datetime)" => $year,
                            "MONTH(EmployeeDataDeposit.verified_datetime)" => $month,
                        ],
                    ]);
                    if (empty($employeeDataDeposit)) {
                        $employeeDataDeposit = $this->EmployeeDataDeposit->find("first", [
                            "recursive" => -1,
                            "order" => "EmployeeDataDeposit.verified_datetime desc",
                            "conditions" => [
                                "EmployeeDataDeposit.employee_balance_id" => $employeeBalance["EmployeeBalance"]["id"],
                                "EmployeeDataDeposit.verify_status_id" => 3,
                                "DATE(EmployeeDataDeposit.verified_datetime) <" => date("Y-m-01 00:00:00", strtotime($proccesingMY)),
                            ],
                        ]);
                    }
                    $lastestBalance = 0;
                    if ($employeeDataDeposit["EmployeeDataDeposit"]["deposit_io_type_id"] == 2) {
                        $lastestBalance = $employeeDataDeposit["EmployeeDataDeposit"]["deposit_previous_balance"] - $employeeDataDeposit["EmployeeDataDeposit"]["amount"];
                    } else {
                        $lastestBalance = $employeeDataDeposit["EmployeeDataDeposit"]["deposit_previous_balance"] + $employeeDataDeposit["EmployeeDataDeposit"]["amount"];
                    }
                    $cooperativeDeposit = ClassRegistry::init("CooperativeDeposit")->find("first", [
                        "recursive" => -1,
                        "conditions" => [
                            "CooperativeDeposit.bottom_limit <= $lastestBalance",
                            "$lastestBalance <= CooperativeDeposit.upper_limit",
                        ]
                    ]);
                    $interestRate = 0;
                    if (!empty($cooperativeDeposit)) {
                        $interestRate = $cooperativeDeposit["CooperativeDeposit"]["interest"];
                    }
                    $interest = floor($interestRate / 12 / 100 * $lastestBalance);
                    ClassRegistry::init("CooperativeEntry")->addManual(ClassRegistry::init("CooperativeEntryType")->getIdByCode(202), $interest, date("Y-m-d H:i:s"), null);
                    $lastestEmployeeBalance+=$interest;
                    $this->EmployeeDataDeposit->EmployeeBalance->save([
                        "id" => $employeeBalanceId,
                        "amount" => $lastestEmployeeBalance,
                    ]);
                    $this->EmployeeDataDeposit->create();
                    $this->EmployeeDataDeposit->save([
                        "employee_balance_id" => $employeeBalanceId,
                        "deposit_io_type_id" => 3,
                        "creator_id" => 1,
                        "employee_id" => $employeeBalance["EmployeeBalance"]["employee_id"],
                        "amount" => $interest,
                        "deposit_previous_balance" => $lastestBalance,
                        "transaction_date" => date("Y-m-t 23:59:59", strtotime($proccesingMY)),
                        "note" => "Proceed by system",
                        "verify_status_id" => 3,
                        "verified_by_id" => 1,
                        "verified_datetime" => date("Y-m-t 23:59:59", strtotime($proccesingMY)),
                    ]);
                    $this->EmployeeDataDeposit->generateNomorBunga($this->EmployeeDataDeposit->getLastInsertID());
                    //fix all previous balance afterward
                    $employeeDataDeposits = $this->EmployeeDataDeposit->find("all", [
                        "recursive" => -1,
                        "order" => "EmployeeDataDeposit.verified_datetime asc",
                        "conditions" => [
                            "EmployeeDataDeposit.employee_balance_id" => $employeeBalance["EmployeeBalance"]["id"],
                            "EmployeeDataDeposit.verify_status_id" => 3,
                            "EmployeeDataDeposit.deposit_io_type_id" => [1, 2],
                            "DATE(EmployeeDataDeposit.verified_datetime) >" => date("Y-m-t", strtotime($proccesingMY)),
                        ],
                    ]);
                    foreach ($employeeDataDeposits as $employeeDataDeposit) {
                        $this->EmployeeDataDeposit->save([
                            "id" => $employeeDataDeposit["EmployeeDataDeposit"]["id"],
                            "deposit_previous_balance" => $employeeDataDeposit["EmployeeDataDeposit"]["deposit_previous_balance"] + $interest,
                        ]);
                    }
                }

                $proccesingMY = date("Y-m", strtotime("+1 month", strtotime($proccesingMY)));
            }
        }
    }

}
