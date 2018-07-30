<?php

App::uses('AppController', 'Controller');

class EmployeeDataLoansController extends AppController {

    var $name = "EmployeeDataLoans";
    var $disabledAction = array(
    );
    var $contain = [
        "CooperativeLoanInterest",
        "Employee" => [
            "Account" => [
                "Biodata"
            ],
            "Department",
        ],
        "CooperativeLoanType",
        "Creator" => [
            "Account" => [
                "Biodata"
            ],
            "Department",
        ],
        "VerifyStatus"
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
        $this->set("departments", $this->EmployeeDataLoan->Employee->Department->find("list", ["fields" => ["Department.id", "Department.name"]]));
        $this->set("cooperativeCashes", $this->EmployeeDataLoan->CooperativeCash->getListWithFullLabel());
        $this->set("branchOffices", $this->EmployeeDataLoan->Employee->BranchOffice->find("list", array("fields" => array("BranchOffice.id", "BranchOffice.name"))));
        $this->set("cooperativeLoanTypes", $this->EmployeeDataLoan->CooperativeLoanType->find("list", ["fields" => ["CooperativeLoanType.id", "CooperativeLoanType.name"]]));
        $this->set("allCooperativeLoanTypes", $this->EmployeeDataLoan->CooperativeLoanType->find("list", ["fields" => ["CooperativeLoanType.id", "CooperativeLoanType.name"]]));
        $this->set("verifyStatuses", $this->EmployeeDataLoan->VerifyStatus->find("list", ["fields" => ["VerifyStatus.id", "VerifyStatus.name"]]));
        $this->set("employeeTypes", $this->EmployeeDataLoan->Employee->EmployeeType->find("list", ["fields" => ["EmployeeType.id", "EmployeeType.name"]]));
    }

    function view_employee_data_loan($id = null) {
        if ($this->EmployeeDataLoan->exists($id)) {
            $this->autoRender = false;
            if ($this->request->is("GET")) {
                $data = $this->EmployeeDataLoan->find("first", [
                    "conditions" => [
                        "EmployeeDataLoan.id" => $id
                    ],
                    "contain" => [
                        "Employee" => [
                            "Account" => [
                                "Biodata"
                            ],
                            "Department"
                        ],
                        "Creator" => [
                            "Account" => [
                                "Biodata"
                            ],
                            "Department"
                        ],
                        "CooperativeLoanInterest",
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
                $this->EmployeeDataLoan->_numberSeperatorRemover();
                $this->EmployeeDataLoan->data['EmployeeDataLoan']['creator_id'] = $this->stnAdmin->getEmployeeId();
                $this->{ Inflector::classify($this->name) }->data['EmployeeDataLoan']['branch_office_id'] = $this->stnAdmin->getBranchId();
                $this->EmployeeDataLoan->data['EmployeeDataLoan']['remaining_loan'] = $this->EmployeeDataLoan->data['EmployeeDataLoan']['total_amount_loan'];
                $cooperativeLoanInterest = $this->EmployeeDataLoan->CooperativeLoanInterest->find("first", [
                    "conditions" => [
                        "CooperativeLoanInterest.id" => $this->EmployeeDataLoan->data['EmployeeDataLoan']['cooperative_loan_interest_id'],
                    ],
                ]);
                $this->EmployeeDataLoan->data['EmployeeDataLoan']['interest_rate'] = $cooperativeLoanInterest["CooperativeLoanInterest"]["interest"];
                $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
                $this->EmployeeDataLoan->generateNomor($this->EmployeeDataLoan->getLastInsertID());
                $this->Session->setFlash(__("Data berhasil disimpan"), 'default', array(), 'success');
//                $this->redirect(array('action' => 'admin_index'));
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
            $this->EmployeeDataLoan->data['EmployeeDataLoan']['id'] = $this->request->data['id'];
            $this->EmployeeDataLoan->data['EmployeeDataLoan']['verify_status_id'] = $this->request->data['status'];
            if ($this->request->data['status'] !== 1) {
                if ($this->request->data['status'] == 3) {
                    $employeeDataLoan = $this->EmployeeDataLoan->find("first", [
                        "conditions" => [
                            "EmployeeDataLoan.id" => $this->request->data['id'],
                        ],
                        "recursive" => -1,
                    ]);
                    $entity = $employeeDataLoan["EmployeeDataLoan"];
                    if($employeeDataLoan['EmployeeDataLoan']['cooperative_loan_type_id'] == 1) {
                        $code = "PNJB";
                    } else {
                        $code = "PNJU";
                    }
                    //update to cooperative cash
                    ClassRegistry::init("CooperativeTransactionMutation")->addMutation($entity["cooperative_cash_id"], $entity["id"], $code, $entity["amount_loan"], $entity["date"]);
                }
            } else {
                $this->EmployeeDataLoan->data['EmployeeDataLoan']['verified_by_id'] = null;
                $this->EmployeeDataLoan->data['EmployeeDataLoan']['verified_datetime'] = null;
            }
            $this->EmployeeDataLoan->saveAll();
            $data = $this->EmployeeDataLoan->find("first", array("conditions" => array("EmployeeDataLoan.id" => $this->request->data['id']), "recursive" => 3));
            echo json_encode($this->_generateStatusCode(207, null, array("status_label" => $data['VerifyStatus']['name'])));
        } else {
            echo json_encode($this->_generateStatusCode(400));
        }
    }

    function admin_add_pinjaman_barang() {
        if ($this->request->is("post")) {
            $this->{ Inflector::classify($this->name) }->set($this->data);
            if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                $this->EmployeeDataLoan->_numberSeperatorRemover();
                $cooperativeLoanInterest = ClassRegistry::init("CooperativeLoanInterest")->find("first", array(
                    "conditions" => [
                        "CooperativeLoanInterest.id" => $this->data["EmployeeDataLoan"]["cooperative_loan_interest_id"],
                    ],
                ));
                if ($this->EmployeeDataLoan->data['EmployeeDataLoan']['amount_loan'] > $cooperativeLoanInterest['CooperativeLoanInterest']['limited_loan']) {
                    $this->Session->setFlash(__("Jumlah pinjaman melebihi batas maksimal pinjaman"), 'default', array(), 'danger');
                    $this->redirect(array('action' => 'admin_add'));
                } else {
                    $this->EmployeeDataLoan->data['EmployeeDataLoan']['remaining_loan'] = $this->EmployeeDataLoan->data['EmployeeDataLoan']['total_amount_loan'];
                    $cooperativeCash = ClassRegistry::init("CooperativeCash")->find("first", array(
                        "conditions" => [
                            "CooperativeCash.id" => $this->data["EmployeeDataLoan"]["cooperative_cash_id"],
                        ],
                    ));

                    /* adding data loan to transaction mutations */
                    $this->EmployeeDataLoan->data['CooperativeTransactionMutation']['employee_id'] = $this->data['EmployeeDataLoan']['employee_id'];
                    $this->EmployeeDataLoan->data['CooperativeTransactionMutation']['cooperative_transaction_type_id'] = 1;
                    $this->EmployeeDataLoan->data['CooperativeTransactionMutation']['nominal'] = $this->EmployeeDataLoan->data['EmployeeDataLoan']['amount_loan'];
                    $this->EmployeeDataLoan->data['CooperativeTransactionMutation']['transaction_date'] = $this->data['EmployeeDataLoan']['date'];
                    $this->EmployeeDataLoan->data['CooperativeTransactionMutation']['employee_data_loan_id'] = $this->EmployeeDataLoan->getLastInsertID();

                    $cooperativeCashUpdate = [];
                    $cooperativeCashUpdate['CooperativeCash']['id'] = $this->data['EmployeeDataLoan']['cooperative_cash_id'];
                    $cooperativeCashUpdate['CooperativeCash']['nominal'] = $cooperativeCash['CooperativeCash']['nominal'] - $this->EmployeeDataLoan->data['EmployeeDataLoan']['amount_loan'];
                    $this->EmployeeDataLoan->data['EmployeeDataLoan']['receipt_loan_number'] = $this->generateReceiptLoanNumber($this->data['EmployeeDataLoan']['employee_id']);
                    ClassRegistry::init("CooperativeCash")->save($cooperativeCashUpdate);

                    $this->EmployeeDataLoan->data['EmployeeDataLoan']['cooperative_loan_type_id'] = 1;

                    $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
                    $this->Session->setFlash(__("Data berhasil disimpan"), 'default', array(), 'success');
                    $this->redirect(array('action' => 'admin_index'));
                }
            } else {
                $this->validationErrors = $this->{ Inflector::classify($this->name) }->validationErrors;
                $this->Session->setFlash(__("Harap mengecek kembali kesalahan dibawah."), 'default', array(), 'danger');
            }
        }
    }

    function admin_edit($id = null) {
        if (!$this->{ Inflector::classify($this->name) }->exists($id)) {
            throw new NotFoundException(__('Data tidak ditemukan'));
        } else {
            if ($this->request->is("post") || $this->request->is("put")) {
                $this->{ Inflector::classify($this->name) }->set($this->data);
                $this->{ Inflector::classify($this->name) }->data[Inflector::classify($this->name)]['id'] = $id;
                if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                    if (!is_null($id)) {
                        $this->EmployeeDataLoan->_numberSeperatorRemover();
                        $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
                        $this->Session->setFlash(__("Data berhasil diubah"), 'default', array(), 'success');
                        $this->redirect(array('action' => 'admin_index'));
                    } else {
                        
                    }
                } else {
                    $this->validationErrors = $this->{ Inflector::classify($this->name) }->validationErrors;
                }
            } else {
                $rows = $this->{ Inflector::classify($this->name) }->find("first", array(
                    'conditions' => array(
                        Inflector::classify($this->name) . ".id" => $id
                    ),
                    'recursive' => 2
                ));
                $this->data = $rows;
            }
        }
    }

    function admin_receipt_loan_number_list() {
        $this->autoRender = false;
        $conds = [];
        if (isset($this->request->query['q'])) {
            $q = $this->request->query['q'];
            $employees = ClassRegistry::init("Account")->find("list", [
                "fields" => [
                    "Employee.id",
                ],
                "contain" => [
                    "Biodata",
                    "Employee",
                ],
                "conditions" => [
                    "or" => [
                        "Biodata.first_name like" => "%$q%",
                        "Biodata.last_name like" => "%$q%",
                        "Employee.nip like" => "%$q%",
                    ],
                ]
            ]);
            $conds[] = array(
                "or" => array(
                    "EmployeeDataLoan.receipt_loan_number like" => "%$q%",
                    "EmployeeDataLoan.employee_id" => $employees,
                ),
            );
        }
        $suggestions = ClassRegistry::init("EmployeeDataLoan")->find("all", array(
            "conditions" => [
                $conds,
                "verify_status_id" => 3
            ],
            "contain" => array(
                "Employee" => [
                    "Office",
                    "Department",
                    "Account" => [
                        "Biodata"
                    ]
                ],
                "CooperativeLoanInterest"
            ),
            "limit" => 10,
        ));
        $result = [];
        foreach ($suggestions as $item) {
            if (!empty($item)) {
                $result[] = [
                    "id" => $item['EmployeeDataLoan']['id'],
                    "full_name" => $item['Employee']['Account']['Biodata']['full_name'],
                    "nip" => @$item['Employee']['nip'],
                    "jabatan" => @$item['Employee']['Office']['name'],
                    "department" => @$item['Employee']['Department']['name'],
                    "installment_number" => ($item["Employee"]["employee_type_id"] == 1 ? 4 : 1) * $item['EmployeeDataLoan']['installment_number'],
                    "interest" => @$item['CooperativeLoanInterest']['interest'],
                    "date" => @$item['EmployeeDataLoan']['date'],
                    "amount_loan" => @$item['EmployeeDataLoan']['amount_loan'],
                    "total_amount_loan" => @$item['EmployeeDataLoan']['total_amount_loan'],
                    "total_installment_paid" => @$item['EmployeeDataLoan']['total_installment_paid'],
                    "employee_data_loan_id" => @$item['EmployeeDataLoan']['id'],
                    "remaining_loan" => @$item['EmployeeDataLoan']['remaining_loan'],
                    "receipt_loan_number" => @$item['EmployeeDataLoan']['receipt_loan_number'],
                    "cooperative_cash_id" => @$item['EmployeeDataLoan']['cooperative_cash_id'],
                    "payment_type" => $item["Employee"]["employee_type_id"] == 1 ? "weekly" : "monthly",
                ];
            }
        }
        echo json_encode($result);
    }

    function generateReceiptLoanNumber($employee_id) {
        $inc_id = 1;
        $currentYear = date("Y");
        $employeeData = ClassRegistry::init("Account")->find("first", [
            "conditions" => [
                "Employee.id" => $employee_id
            ],
            "contain" => [
                "Employee",
                "Biodata"
            ]
        ]);
        $initialFirstName = $employeeData['Biodata']['first_name'];
        $initialLastName = $employeeData['Biodata']['last_name'];
        $initialEmployeeName = @$initialFirstName[0] . @$initialLastName[0];
        $lastRecord = $this->EmployeeDataLoan->find("all");
        $inc_id = count($lastRecord) + 1;
        $inc_id = sprintf("%03d", $inc_id);
        $code = "$initialEmployeeName/$inc_id/$currentYear";
        return $code;
    }

    function admin_index() {
        $this->_activePrint(func_get_args(), "data_pinjaman_pegawai");
        $this->_setPeriodeLaporanDate("awal_EmployeeDataLoan_date", "awal_EmployeeDataLoan_date");
        parent::admin_index();
    }

    function admin_index_verify() {
        $this->conds = [
            "EmployeeDataLoan.verify_status_id" => 1,
        ];
        parent::admin_index();
    }

    function admin_loan_report() {
        $this->_activePrint(func_get_args(), "laporan_pinjaman_pegawai");
        $this->_setPeriodeLaporanDate("awal_EmployeeDataLoan_date", "awal_EmployeeDataLoan_date");
        $this->conds = [
            "EmployeeDataLoan.verify_status_id" => 3,
        ];
        parent::admin_index();
    }

    function admin_pinjaman_index() {
        $this->_activePrint(func_get_args(), "pinjaman");
        $dtConds = [
            "EmployeeDataLoan.employee_id" => $this->_getEmployeeId(),
        ];
        $this->conds = [
            am($this->conds, $dtConds),
        ];
        parent::admin_index();
    }

    function get_data_loan($employee_id) {
        $this->autoRender = false;
        if (!empty($employee_id)) {
            if ($this->request->is("GET")) {
                $data = $this->EmployeeDataLoan->find("all", [
                    "conditions" => [
                        "EmployeeDataLoan.employee_id" => $employee_id,
                        "EmployeeDataLoan.remaining_loan >" => 0,
                        "EmployeeDataLoan.verify_status_id" => 3,
                    ],
                    "contain" => [
                        "CooperativeLoanInterest",
                        "CooperativeLoanType"
                    ]
                ]);
                return json_encode($data);
            } else {
                return json_encode($this->_generateStatusCode(400));
            }
        } else {
            throw new NotFoundException(__("404 Data Not Found"));
        }
    }

    function admin_print_request_loan($id = null) {
        if ($this->EmployeeDataLoan->exists($id)) {
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
                ],
            ));
            $this->data = $rows;
            $data = array(
                'title' => 'KOPERASI "MANDIRI" PT. CHEN WOO FISHERY <br> FORM PERMOHONAN PINJAMAN',
                'rows' => $rows,
            );
            $this->set(compact('data'));
            $this->_activePrint(["print"], "print_request_loan", "form");
        } else {
            throw new NotFoundException(__("404 Data Not Found."));
        }
    }

}
