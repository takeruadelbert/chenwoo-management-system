<?php

App::uses('AppController', 'Controller');

class EmployeeDataLoanDetailsController extends AppController {

    var $name = "EmployeeDataLoanDetails";
    var $disabledAction = array(
    );
    var $contain = [
        "EmployeeDataLoan" => [
            "Employee" => [
                "Account" => [
                    "Biodata"
                ],
                "Department",
            ],
        ],
        "Creator" => [
            "Account" => [
                "Biodata"
            ],
            "Department",
        ],
    ];

    function beforeRender() {
        $this->_options();
        parent::beforeRender();
    }

    function _options() {
        $this->set("branchOffices", $this->EmployeeDataLoanDetail->EmployeeDataLoan->Employee->BranchOffice->find("list", array("fields" => array("BranchOffice.id", "BranchOffice.name"))));
        $this->set("cooperativeCashes", ClassRegistry::init("CooperativeCash")->getListWithFullLabel());
    }

    function beforeFilter() {
        parent::beforeFilter();
        $this->_setPageInfo("admin_index", "");
        $this->_setPageInfo("admin_add", "");
        $this->_setPageInfo("admin_edit", "");
        $this->_setPageInfo("admin_view", "");
    }

    function admin_index() {
        $this->_activePrint(func_get_args(), "data_transaksi_angsuran");
        $this->_setPeriodeLaporanDate("awal_EmployeeDataLoanDetail_paid_date", "akhir_EmployeeDataLoanDetail_paid_date");
        parent::admin_index();
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
                        "CooperativeLoanInterest"
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
                $this->EmployeeDataLoanDetail->_numberSeperatorRemover();
                $this->EmployeeDataLoanDetail->data["EmployeeDataLoanDetail"]["creator_id"] = $this->stnAdmin->getEmployeeId();
                $this->{ Inflector::classify($this->name) }->data['EmployeeDataLoanDetail']['branch_office_id'] = $this->stnAdmin->getBranchId();
                $employeeDataLoan = ClassRegistry::init("EmployeeDataLoan")->find("first", [
                    "conditions" => [
                        "EmployeeDataLoan.id" => $this->data['EmployeeDataLoanDetail']['employee_data_loan_id']
                    ],
                ]);
                $this->EmployeeDataLoanDetail->data["EmployeeDataLoanDetail"]["installment_of"] = $employeeDataLoan["EmployeeDataLoan"]["total_installment_paid"] + 1;
                if ($employeeDataLoan['EmployeeDataLoan']['remaining_loan'] < $this->EmployeeDataLoanDetail->data['EmployeeDataLoanDetail']['amount']) {
                    $this->Session->setFlash(__("Jumlah pembayaran melebihi sisa jumlah pinjaman"), 'default', array(), 'danger');
                    $this->redirect(array('action' => 'admin_add'));
                } else {
                    $remainingLoan = $this->EmployeeDataLoanDetail->data['EmployeeDataLoanDetail']['remaining_loan'] - $this->EmployeeDataLoanDetail->data['EmployeeDataLoanDetail']['amount'];
                    $this->EmployeeDataLoanDetail->data['EmployeeDataLoanDetail']['remaining_loan'] = $remainingLoan;

                    /* Update the Number of Installment Payment */
                    $dataLoanToUpdate = [];
                    $dataLoanToUpdate['EmployeeDataLoan']['id'] = $this->data['EmployeeDataLoanDetail']['employee_data_loan_id'];
                    $dataLoanToUpdate['EmployeeDataLoan']['total_installment_paid'] = $employeeDataLoan['EmployeeDataLoan']['total_installment_paid'] + 1;
                    $dataLoanToUpdate['EmployeeDataLoan']['remaining_loan'] = $remainingLoan;

                    ClassRegistry::init("EmployeeDataLoan")->save($dataLoanToUpdate);
                    $this->{ Inflector::classify($this->name) }->save($this->EmployeeDataLoanDetail->data);
                    $this->EmployeeDataLoanDetail->generateNomor($this->EmployeeDataLoanDetail->getLastInsertID());
                    $employeeDataLoanDetail = $this->EmployeeDataLoanDetail->find("first", [
                        "conditions" => [
                            "EmployeeDataLoanDetail.id" => $this->EmployeeDataLoanDetail->getLastInsertID(),
                        ],
                        "recursive" => -1,
                    ]);
                    $entity = $employeeDataLoanDetail["EmployeeDataLoanDetail"];
                    //update to cooperative cash
                    ClassRegistry::init("CooperativeTransactionMutation")->addMutation($entity["cooperative_cash_id"], $entity["id"], "ANSR", $entity["amount"], date("Y-m-d H:i:s"));
                    //update to cooperative entry
                    ClassRegistry::init("CooperativeEntry")->addForLoanPayment($entity["id"]);
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
                        $this->EmployeeDataLoanDetail->_numberSeperatorRemover();
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
                    'recursive' => 4
                ));
                $this->data = $rows;
            }
        }
    }

    function admin_view($id = null) {
        if (!$this->EmployeeDataLoanDetail->exists($id)) {
            throw new NotFoundException(__('Invalid user'));
        } else {
            $this->{ Inflector::classify($this->name) }->id = $id;
            $this->EmployeeDataLoanDetail->data['Employee']['id'] = $id;
            $rows = $this->{ Inflector::classify($this->name) }->find("first", array('conditions' => array(Inflector::classify($this->name) . ".id" => $id), "recursive" => 4));
            $this->data = $rows;
        }
    }

    function view_installment_history($employee_data_loan_id = null) {
        $this->autoRender = false;
        if ($this->request->is("GET")) {
            $data = $this->EmployeeDataLoanDetail->find("all", [
                "conditions" => [
                    "EmployeeDataLoanDetail.employee_data_loan_id" => $employee_data_loan_id,
                ]
            ]);
            return json_encode($data);
        } else {
            return json_encode($this->_generateStatusCode(400));
        }
    }

    function generateReceiptNumber($employeeDataLoanId) {
        $inc_id = 1;
        $currentYear = date("Y");
        $numOfPayment = $this->EmployeeDataLoanDetail->find("count", ["conditions" => ["EmployeeDataLoanDetail.employee_data_loan_id" => $employeeDataLoanId]]);
        $latestNumOfPaymentInRoman = romanic_number($numOfPayment);
        if (!empty($numOfPayment)) {
            $currentNumOfPaymentInRoman = romanic_number($numOfPayment + 1);
        } else {
            $currentNumOfPaymentInRoman = romanic_number(1);
        }
        $lastRecord = $this->EmployeeDataLoanDetail->find("all");
        $inc_id = count($lastRecord) + 1;
        $inc_id = sprintf("%03d", $inc_id);
        $code = "KW-BA/$inc_id/$currentNumOfPaymentInRoman/$currentYear"; /* BA = Bayar Angsuran */
        return $code;
    }

    function admin_loan_history() {
        $this->_activePrint(func_get_args(), "data_histori_transaksi_angsuran");
        $conds = [];
//        if (!empty($this->request->query['select_Employee_branch_office_id'])) {
//            $conds = [
//                "Employee.branch_office_id" => $this->request->query['select_Employee_branch_office_id']
//            ];
//        }
        if (isset($this->request->query)) {
            if (!empty($this->request->query['start_date'])) {
                $startDate = $this->request->query['start_date'];
                $newStartDate = date("Y-m-d H:i:s", strtotime($startDate));
                $conds[] = [
                    "DATE_FORMAT(EmployeeDataLoanDetail.paid_date, '%Y-%m-%d %H:%i:%s') >=" => $newStartDate
                ];
                unset($_GET['start_date']);
            }
            if (!empty($this->request->query['end_date'])) {
                $endDate = $this->request->query['end_date'];
                $newEndDate = date("Y-m-d H:i:s", strtotime($endDate));
                $conds[] = [
                    "DATE_FORMAT(EmployeeDataLoanDetail.paid_date, '%Y-%m-%d %H:%i:%s') <=" => $newEndDate
                ];
                unset($_GET['end_date']);
            }
        }
        $this->conds = [
            "EmployeeDataLoanDetail.id !=" => null,
            $conds,
        ];
        $this->contain = [
            "EmployeeDataLoan" => [
                "Employee" => [
                    "Account" => [
                        "Biodata",
                    ],
                ],
            ],
        ];
        parent::admin_index();
    }

    function admin_print_loan_history($id = null) {
        $rows = $this->{ Inflector::classify($this->name) }->find('first', array(
            'conditions' => array(
                Inflector::classify($this->name) . '.id' => $id,
            ),
            'contain' => [
                "EmployeeDataLoan" => [
                    "Employee" => [
                        "Account" => [
                            "Biodata",
                        ],
                    ],
                ],
            ],
        ));
        $this->data = $rows;
        $data = array(
            'title' => 'Bukti Pembayaran',
            'rows' => $rows,
        );
        $this->set(compact('data'));
        $this->_activePrint(["print"], "print_loan_history", "kwitansi");
    }

    function admin_list() {
        $this->autoRender = false;
        $conds = [];
        if (isset($this->request->query['q'])) {
            $q = $this->request->query['q'];
            $conds[] = array(
                "or" => array(
                    "EmployeeDataLoanDetail.coop_receipt_number like" => "%$q%",
            ));
        }
        $suggestions = ClassRegistry::init("EmployeeDataLoanDetail")->find("all", array(
            "conditions" => [
                $conds,
            ],
            "contain" => [
                "EmployeeDataLoan" => [
                    "Employee" => [
                        "Account" => [
                            "Biodata",
                        ],
                    ],
                ],
            ],
            "limit"=>10,
        ));
        $result = [];
        foreach ($suggestions as $item) {
            if (!empty($item)) {
                $result[] = [
                    "id" => @$item['EmployeeDataLoanDetail']['id'],
                    "receipt_number" => @$item['EmployeeDataLoanDetail']['coop_receipt_number'],
                    "amount" => @$item['EmployeeDataLoanDetail']['amount'],
                    "employee" => @$item['EmployeeDataLoan']['Employee']['Account']['Biodata']['full_name'],
                ];
            }
        }
        echo json_encode($result);
    }

    function addMonths($date, $num_of_month) {
        $this->autoRender = false;
        if ($this->request->is("GET")) {
            $output = date('Y-m-d', strtotime("+" . $num_of_month . "months", strtotime($date)));
            return json_encode($output);
        } else {
            return json_encode($this->_generateStatusCode(400));
        }
    }

    function get_data_loan($employee_id, $month, $year) {
        $this->autoRender = false;
        if (!empty($employee_id)) {
            if ($this->request->is("GET")) {
                $data = $this->EmployeeDataLoanDetail->find("all", [
                    "conditions" => [
                        "EmployeeDataLoan.employee_id" => $employee_id,
                        "EmployeeDataLoan.remaining_loan >" => 0,
                        "EmployeeDataLoan.verify_status_id" => 3,
                        "MONTH(EmployeeDataLoanDetail.paid_date)" => $month,
                        "YEAR(EmployeeDataLoanDetail.paid_date)" => $year
                    ],
                    "contain" => [
                        "EmployeeDataLoan"
                    ]
                ]);
                if (!empty($data)) {
                    $temp = $data[0]['EmployeeDataLoan']['cooperative_loan_type_id'];
                    return json_encode($temp);
                } else {
                    $temp = ClassRegistry::init("EmployeeDataLoan")->find("all", [
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
                    return json_encode($temp);
                }
            } else {
                return json_encode($this->_generateStatusCode(400));
            }
        } else {
            throw new NotFoundException(__("404 Data Not Found"));
        }
    }

}
