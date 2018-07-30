<?php

App::uses('AppController', 'Controller');

class EmployeeSalariesController extends AppController {

    var $name = "EmployeeSalaries";
    var $disabledAction = array(
    );
    var $contain = [
        "MadeBy" => [
            "Account" => [
                "Biodata",
            ],
        ],
        "Employee" => [
            "Account" => [
                "Biodata",
            ],
            "Department",
            "Office",
            "EmployeeType",
        ],
        "ParameterEmployeeSalary" => [
            "ParameterSalary" => [
                "ParameterSalaryType",
            ],
        ],
        "ValidateBy" => [
            "Account" => [
                "Biodata",
            ],
        ],
        "CashierOperator" => [
            "Account" => [
                "Biodata",
            ],
        ],
        "ValidateStatus",
        "InitialBalance" => [
            "GeneralEntryType"
        ],
        "EmployeeSalaryCashierStatus"
    ];

    function beforeFilter() {
        parent::beforeFilter();
        $this->_setPageInfo("admin_index", "Gaji Pegawai");
        $this->_setPageInfo("admin_add", "Tambah Gaji Pegawai");
        $this->_setPageInfo("admin_edit", "Ubah Gaji Pegawai");
    }

    function beforeRender() {
        $this->_options();
        parent::beforeRender();
    }

    function _options() {
        $this->set("incomeParameterSalaries", ClassRegistry::init("ParameterSalary")->find("list", array("fields" => array("ParameterSalary.id", "ParameterSalary.name"), "conditions" => array("ParameterSalary.parameter_salary_type_id" => 1))));
        $this->set("debtParameterSalaries", ClassRegistry::init("ParameterSalary")->find("list", array("fields" => array("ParameterSalary.id", "ParameterSalary.name"), "conditions" => array("ParameterSalary.parameter_salary_type_id" => 2))));
        $this->set("employeeTypes", ClassRegistry::init("EmployeeType")->find("list", array("fields" => array("EmployeeType.id", "EmployeeType.name"))));
        $this->set("initialBalances", ClassRegistry::init("InitialBalance")->find("list", ["fields" => ["InitialBalance.id", "GeneralEntryType.name"], "conditions" => ["InitialBalance.currency_id" => 1], "contain" => "GeneralEntryType"]));
        $this->set("potonganKoperasi", ClassRegistry::init("ParameterSalary")->find("list", ["fields" => ["ParameterSalary.id", "ParameterSalary.name"], "conditions" => ["ParameterSalary.id" => [11, 12]]]));
        $this->set("validateStatuses", ClassRegistry::init("ValidateStatus")->find("list", ["fields" => ["ValidateStatus.id", "ValidateStatus.name"]]));
        $this->set("employeeSalaryCashierStatuses", ClassRegistry::init("EmployeeSalaryCashierStatus")->find("list", ["fields" => ["EmployeeSalaryCashierStatus.id", "EmployeeSalaryCashierStatus.name"]]));
    }

    function admin_index() {
        $this->_activePrint(func_get_args(), "data_gaji_pegawai");
        $this->conds = [
            "EmployeeSalary.validate_status_id" => 2,
            "Employee.employee_type_id" => 1,
        ];
        parent::admin_index();
    }

    function admin_earning_setup() {
        if ($this->request->is("post")) {
            $this->{ Inflector::classify($this->name) }->set($this->data);
            if ($this->data["Employee"]["employee_type_id"] == 1) {
                $this->redirect(array('action' => 'admin_add_harian'));
            } else if ($this->data["Employee"]["employee_type_id"] == 2) {
                $this->redirect(array('action' => 'admin_add_bulanan'));
            }
        }
    }

    function admin_add_bulanan() {
        if ($this->request->is("post")) {
            $this->{ Inflector::classify($this->name) }->set($this->data);
            if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                $this->{ Inflector::classify($this->name) }->data['EmployeeSalary']['made_by_id'] = $this->_getEmployeeId();
                $this->{ Inflector::classify($this->name) }->data['EmployeeSalary']['validate_status_id'] = 1;
                $this->EmployeeSalary->_numberSeperatorRemover();
                foreach ($this->{ Inflector::classify($this->name) }->data['ParameterEmployeeSalary'] as $key => $value) {
                    if (!empty($value['parameter_salary_id'])) {
                        $dataParameterSalary = ClassRegistry::init("ParameterSalary")->find("first", [
                            "conditions" => [
                                "ParameterSalary.id" => $value['parameter_salary_id'],
                            ],
                        ]);
                        if ($dataParameterSalary['ParameterSalary']['parameter_salary_type_id'] === '2') {
                            $this->{ Inflector::classify($this->name) }->data['ParameterEmployeeSalary'][$key]['nominal'] *= -1;
                        }
                    } else {
                        unset($this->{ Inflector::classify($this->name) }->data['ParameterEmployeeSalary'][$key]);
                    }
                }
                $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
                $savedData = $this->EmployeeSalary->find("first", [
                    "conditions" => [
                        'EmployeeSalary.id' => $this->EmployeeSalary->getLastInsertID(),
                    ],
                    "contain" => [
                        "Employee" => [
                            "Account" => [
                                "Biodata"
                            ],
                        ],
                    ]
                ]);
                $this->loadModel("Notification");
                $dataSupervisors = ClassRegistry::init("Employee")->find("all", [
                    "conditions" => [
                        "Employee.office_id" => [5, 6]
                    ]
                ]);
                foreach ($dataSupervisors as $supervisors) {
                    $this->Notification->addNotification(null, null, $savedData["EmployeeSalary"]["id"], $supervisors['Employee']['id'], "Gaji bulanan untuk Pegawai {$savedData["Employee"]["Account"]["Biodata"]["full_name"]} menunggu verifikasi", "/admin/employee_salaries/verify_index");
                }
                $this->Session->setFlash(__("Data berhasil disimpan"), 'default', array(), 'success');
                $this->redirect(array('action' => 'admin_add_bulanan'));
            } else {
                $this->validationErrors = $this->{ Inflector::classify($this->name) }->validationErrors;
                $this->Session->setFlash(__("Harap mengecek kembali kesalahan dibawah."), 'default', array(), 'danger');
            }
        }
    }

    function admin_add_harian() {
        if ($this->request->is("post")) {
            $this->{ Inflector::classify($this->name) }->set($this->data);
            if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                $this->{ Inflector::classify($this->name) }->data['EmployeeSalary']['made_by_id'] = $this->_getEmployeeId();
                $this->{ Inflector::classify($this->name) }->data['EmployeeSalary']['validate_status_id'] = 1;
                $this->{ Inflector::classify($this->name) }->_numberSeperatorRemover();
                foreach ($this->{ Inflector::classify($this->name) }->data['ParameterEmployeeSalary'] as $key => $value) {
                    if (!empty($value['parameter_salary_id'])) {
                        $dataParameterSalary = ClassRegistry::init("ParameterSalary")->find("first", [
                            "conditions" => [
                                "ParameterSalary.id" => $value['parameter_salary_id'],
                            ],
                            "recursive" => -1,
                        ]);
                        if ($dataParameterSalary['ParameterSalary']['parameter_salary_type_id'] === '2') {
                            $this->{ Inflector::classify($this->name) }->data['ParameterEmployeeSalary'][$key]['nominal'] *= -1;
                        }
                    } else {
                        unset($this->{ Inflector::classify($this->name) }->data['ParameterEmployeeSalary'][$key]);
                    }
                }
                $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
                $savedData = $this->EmployeeSalary->find("first", [
                    "conditions" => [
                        'EmployeeSalary.id' => $this->EmployeeSalary->getLastInsertID(),
                    ],
                    "contain" => [
                        "Employee" => [
                            "Account" => [
                                "Biodata"
                            ],
                        ],
                    ]
                ]);
                $dataSupervisors = ClassRegistry::init("Employee")->find("all", [
                    "conditions" => [
                        "Employee.office_id" => [5, 6]
                    ]
                ]);
                $this->loadModel("Notification");
                foreach ($dataSupervisors as $supervisors) {
                    $this->Notification->addNotification(null, null, $savedData["EmployeeSalary"]["id"], $supervisors['Employee']['id'], "Gaji harian untuk Pegawai {$savedData["Employee"]["Account"]["Biodata"]["full_name"]} menunggu verifikasi", "/admin/employee_salaries/verify_index");
                }
                $this->Session->setFlash(__("Data berhasil disimpan"), 'default', array(), 'success');
                $this->redirect(array('action' => 'admin_earning_setup'));
            } else {
                $this->validationErrors = $this->{ Inflector::classify($this->name) }->validationErrors;
                $this->Session->setFlash(__("Harap mengecek kembali kesalahan dibawah."), 'default', array(), 'danger');
            }
        }
    }

    function admin_edit_harian($id = null) {
        if (!$this->{ Inflector::classify($this->name) }->exists($id)) {
            throw new NotFoundException(__('Data tidak ditemukan'));
        } else {
            if ($this->request->is("post") || $this->request->is("put")) {
                $this->{ Inflector::classify($this->name) }->set($this->data);
                $this->{ Inflector::classify($this->name) }->data[Inflector::classify($this->name)]['id'] = $id;
                if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                    if (!is_null($id)) {
                        foreach ($this->data['ParameterEmployeeSalary'] as $k => $params) {
                            if (isset($params['id']) && !empty($params['id'])) {
                                $this->EmployeeSalary->ParameterEmployeeSalary->data['ParameterEmployeeSalary']['id'] = $params['id'];
                            }
                            $dataParameterSalary = ClassRegistry::init("ParameterSalary")->find("first", ["conditions" => ["ParameterSalary.id" => $params['parameter_salary_id']]]);
                            if ($dataParameterSalary['ParameterSalary']['parameter_salary_type_id'] == 2) {
                                $this->{ Inflector::classify($this->name) }->data['ParameterEmployeeSalary'][$k]['nominal'] *= -1;
                            }
                        }

                        $this->EmployeeSalary->_deleteableHasmany();
                        $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
                        $this->Session->setFlash(__("Data berhasil diubah"), 'default', array(), 'success');
                        $this->redirect(array('action' => 'admin_verify_index'));
                    }
                } else {
                    $this->validationErrors = $this->{ Inflector::classify($this->name) }->validationErrors;
                }
            } else {
                $rows = $this->{ Inflector::classify($this->name) }->find("first", array(
                    'conditions' => array(
                        Inflector::classify($this->name) . ".id" => $id
                    ),
                    'contain' => [
                        "MadeBy" => [
                            "Account" => [
                                "Biodata"
                            ]
                        ],
                        "Employee" => [
                            "Account" => [
                                "Biodata"
                            ]
                        ],
                        "ParameterEmployeeSalary" => [
                            "ParameterSalary" => [
                                "ParameterSalaryType"
                            ]
                        ]
                    ]
                ));
                $this->data = $rows;
            }
        }
    }

    function admin_edit_bulanan($id = null) {
        if (!$this->{ Inflector::classify($this->name) }->exists($id)) {
            throw new NotFoundException(__('Data tidak ditemukan'));
        } else {
            if ($this->request->is("post") || $this->request->is("put")) {
                $this->{ Inflector::classify($this->name) }->set($this->data);
                $this->{ Inflector::classify($this->name) }->data[Inflector::classify($this->name)]['id'] = $id;
                if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                    if (!is_null($id)) {
                        $this->EmployeeSalary->_deleteableHasmany();
                        foreach ($this->data['ParameterEmployeeSalary'] as $k => $params) {
                            if (isset($params['id']) && !empty($params['id'])) {
                                $this->EmployeeSalary->ParameterEmployeeSalary->data['ParameterEmployeeSalary']['id'] = $params['id'];
                            }

                            $dataParameterSalary = ClassRegistry::init("ParameterSalary")->find("first", ["conditions" => ["ParameterSalary.id" => $params['parameter_salary_id']]]);
                            if ($dataParameterSalary['ParameterSalary']['parameter_salary_type_id'] == 2) {
                                $this->{ Inflector::classify($this->name) }->data['ParameterEmployeeSalary'][$k]['nominal'] *= -1;
                            }
                        }
                        $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
                        $this->Session->setFlash(__("Data berhasil diubah"), 'default', array(), 'success');
                        $this->redirect(array('action' => 'admin_verify_index'));
                    }
                } else {
                    $this->validationErrors = $this->{ Inflector::classify($this->name) }->validationErrors;
                }
            } else {
                $rows = $this->{ Inflector::classify($this->name) }->find("first", array(
                    'conditions' => array(
                        Inflector::classify($this->name) . ".id" => $id
                    ),
                    'contain' => [
                        "MadeBy" => [
                            "Account" => [
                                "Biodata"
                            ]
                        ],
                        "Employee" => [
                            "Account" => [
                                "Biodata"
                            ]
                        ],
                        "ParameterEmployeeSalary" => [
                            "ParameterSalary" => [
                                "ParameterSalaryType"
                            ]
                        ]
                    ]
                ));
                $this->data = $rows;
            }
        }
    }

    function admin_validate_index() {
        $this->_activePrint(func_get_args(), "data_validate_salary");
        $this->_setPeriodeLaporanDate("awal_EmployeeSalary_validate_datetime", "akhir_EmployeeSalary_validate_datetime");
        $this->conds = [
            "Employee.employee_type_id" => 2,
        ];
        parent::admin_index();
    }

    function admin_validate_edit($id = null) {
        if (!$this->{ Inflector::classify($this->name) }->exists($id)) {
            throw new NotFoundException(__('Data tidak ditemukan'));
        } else {
            if ($this->request->is("post") || $this->request->is("put")) {
                $this->{ Inflector::classify($this->name) }->set($this->data);
                $this->{ Inflector::classify($this->name) }->data[Inflector::classify($this->name)]['id'] = $id;
                if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                    if (!is_null($id)) {
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

    function admin_verify_index() {
        $conds = $this->_filter($_GET, $this->filterCond);
        if (empty($conds)) {
            $conds = $this->defaultConds;
        }
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

    function admin_verify_edit($id = null) {
        if (!$this->{ Inflector::classify($this->name) }->exists($id)) {
            throw new NotFoundException(__('Data tidak ditemukan'));
        } else {
            if ($this->request->is("post") || $this->request->is("put")) {
                $this->{ Inflector::classify($this->name) }->set($this->data);
                $this->{ Inflector::classify($this->name) }->data[Inflector::classify($this->name)]['id'] = $id;
                if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                    if (!is_null($id)) {
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

    function admin_earning_index() {
        $this->_activePrint(func_get_args(), "earning");
        $startDt = date("Y-m-01");
        $endDt = date("Y-m-t");
        if (isset($this->request->query["awalint_EmployeeSalary_month_period"]) && isset($this->request->query["akhirint_EmployeeSalary_month_period"]) && isset($this->request->query["awalint_EmployeeSalary_year_period"]) && isset($this->request->query["akhirint_EmployeeSalary_year_period"])) {
            $defaultCond = [
                "EmployeeSalary.employee_id" => $this->_getEmployeeId(),
            ];
            unset($_GET['awalint_EmployeeSalary_month_period']);
            unset($_GET['akhirint_EmployeeSalary_month_period']);
            unset($_GET['awalint_EmployeeSalary_year_period']);
            unset($_GET['akhirint_EmployeeSalary_year_period']);
        } else {
            $defaultCond = [
                "EmployeeSalary.employee_id" => $this->_getEmployeeId(),
                "EmployeeSalary.start_date_period >=" => $startDt,
                "EmployeeSalary.end_date_period <=" => $endDt,
                "EmployeeSalary.validate_status_id" => 2,
            ];
        }
        $conds = $this->_filter($_GET, $this->filterCond);
        if (empty($conds)) {
            $conds = $this->defaultConds;
        }
        $conds['AND'] = am($conds, array(
            $defaultCond,
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

    function admin_print_employee_salary($id = null) {
        $this->_activePrint(["print"], "print_employee_salary", "kwitansi");
        $rows = $this->{ Inflector::classify($this->name) }->find('first', array(
            'conditions' => array(
                Inflector::classify($this->name) . '.id' => $id,
                Inflector::classify($this->name) . '.validate_status_id' => 2,
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
                "MadeBy" => [
                    "Account" => [
                        "Biodata",
                    ],
                    "Office",
                ],
                "ValidateBy" => [
                    "Account" => [
                        "Biodata",
                    ],
                    "Office",
                ],
                "ParameterEmployeeSalary" => [
                    "ParameterSalary",
                ],
            ],
        ));
        $this->data = $rows;
        $data = array(
            'title' => 'Slip Gaji',
            'rows' => $rows,
        );
        $this->set(compact('data'));
    }

//    function generateReceiptSalaryNumber() {
//        $inc_id = 1;
//        $m = date('n');
//        $mRoman = romanic_number($m);
//        $Y = date('Y');
//        $testCode = "CHENWOO-GAJI-KWITANSI/$mRoman/$Y/[0-9]{3}";
//        $lastRecord = $this->EmployeeSalary->ReceiptSalary->find('first', array('conditions' => array('and' => array("ReceiptSalary.receipt_salary_number regexp" => $testCode)), 'order' => array('ReceiptSalary.receipt_salary_number' => 'DESC')));
//        if (!empty($lastRecord)) {
//            $current = explode("/", $lastRecord['ReceiptSalary']['receipt_salary_number']);
//            $inc_id+=$current[count($current) - 1];
//        }
//        $inc_id = sprintf("%03d", $inc_id);
//        $kode = "IM-GAJI-KWITANSI/$mRoman/$Y/$inc_id";
//        return $kode;
//    }

    function admin_getEmployeeTypeahead() {
        $this->autoRender = false;
        if (isset($this->request->query['q'])) {
            $q = $this->request->query['q'];
            $conds = array(
                "or" => array(
                    "Biodata.first_name like" => "%$q%",
                    "Biodata.last_name like" => "%$q%",
                    "Biodata.gelar_depan like" => "%$q%",
                    "Biodata.gelar_belakang like" => "%$q%",
                    "Employee.nip like" => "%$q%",
                ),
                "not" => [
                    "Employee.id" => null,
                ],
            );
        } else {
            $conds = [
                "not" => [
                    "Employee.id" => null,
                ],
            ];
        }
        $data = ClassRegistry::init("Employee")->Account->find("all", array(
            "fields" => [
            ],
            "conditions" => $conds,
            "contain" => [
                "Biodata",
                "Employee" => [
                    "Department",
                    "Office",
                    "EmployeeType",
                ],
            ],
        ));
        $result = [];
        foreach ($data as $item) {
            if (!empty($item['Employee'])) {
                $result[] = [
                    "id" => @$item['Employee']['id'],
                    "name" => @$item['Biodata']['full_name'],
                    "nip" => @$item['Employee']['nip'],
                    "department" => @$item['Employee']['Department']['name'],
                    "position" => @$item['Employee']['Office']['name'],
                ];
            }
        }
        echo json_encode($result);
    }

    function admin_change_status_validate() {
        $this->autoRender = false;
        if ($this->request->is("PUT")) {
            $this->EmployeeSalary->data['EmployeeSalary']['id'] = $this->request->data['id'];
            $this->EmployeeSalary->data['EmployeeSalary']['validate_status_id'] = $this->request->data['status'];
            if ($this->request->data['status'] == '2' || $this->request->data['status'] == '3') {
                $this->EmployeeSalary->data['EmployeeSalary']['validate_by_id'] = $this->_getEmployeeId();
                $this->EmployeeSalary->data['EmployeeSalary']['validate_datetime'] = date("Y-m-d H:i:s");
            } else {
                $this->EmployeeSalary->data['EmployeeSalary']['validate_by_id'] = null;
                $this->EmployeeSalary->data['EmployeeSalary']['validate_datetime'] = null;
            }
            $this->EmployeeSalary->saveAll();
            $data = $this->EmployeeSalary->find("first", array("conditions" => array("EmployeeSalary.id" => $this->request->data['id']), "recursive" => -1, "contain" => ["ValidateStatus"]));
            echo json_encode($this->_generateStatusCode(207, null, array("status_label" => $data['ValidateStatus']['name'])));
        } else {
            echo json_encode($this->_generateStatusCode(400));
        }
    }

    function admin_change_status_verify() {
        $this->autoRender = false;
        if ($this->request->is("PUT")) {
            $this->EmployeeSalary->data['EmployeeSalary']['id'] = $this->request->data['id'];
            $this->EmployeeSalary->data['EmployeeSalary']['verify_status_id'] = $this->request->data['status'];
            if ($this->request->data['status'] !== '1') {
                $this->EmployeeSalary->data['EmployeeSalary']['verified_by_id'] = $this->_getEmployeeId();
                $this->EmployeeSalary->data['EmployeeSalary']['verified_datetime'] = date("Y-m-d H:i:s");
                $notification = ClassRegistry::init("Notification")->find("all", [
                    "conditions" => [
                        "Notification.employee_salary_id" => $this->request->data['id'],
                    ],
                ]);
                $dataNotificationUpdated = [];
                foreach ($notification as $notif) {
                    $dataNotificationUpdated['Notification']['id'] = $notif['Notification']['id'];
                    $dataNotificationUpdated['Notification']['message'] = str_replace("verifikasi", "validasi", $notif['Notification']['message']);
                    ClassRegistry::init("Notification")->save($dataNotificationUpdated);
                }
            } else {
                $this->EmployeeSalary->data['EmployeeSalary']['verified_by_id'] = null;
                $this->EmployeeSalary->data['EmployeeSalary']['verified_datetime'] = null;
            }
            $this->EmployeeSalary->saveAll();
            $data = $this->EmployeeSalary->find("first", array("conditions" => array("EmployeeSalary.id" => $this->request->data['id']), "recursive" => 3));
            echo json_encode($this->_generateStatusCode(207, null, array("status_label" => $data['VerifyStatus']['name'])));
        } else {
            echo json_encode($this->_generateStatusCode(400));
        }
    }

    function view_data_gaji($gajiId) {
        if (!empty($gajiId) && $gajiId != null) {
            $this->autoRender = false;
            $data = ClassRegistry::init("EmployeeSalary")->find("first", [
                "conditions" => [
                    "EmployeeSalary.id" => $gajiId,
                ],
                "contain" => [
                    "MadeBy" => [
                        "Account" => [
                            "Biodata",
                        ],
                    ],
                    "Employee" => [
                        "Account" => [
                            "Biodata",
                        ],
                    ],
                    "ParameterEmployeeSalary" => [
                        "ParameterSalary" => [
                            "ParameterSalaryType",
                        ],
                    ],
//                    "VerifiedBy" => [
//                        "Account" => [
//                            "Biodata",
//                        ],
//                    ],
//                    "VerifyStatus",
                    "ValidateBy" => [
                        "Account" => [
                            "Biodata",
                        ],
                    ],
                    "ValidateStatus",
                    "InitialBalance"
                ],
            ]);
            return json_encode($data);
        } else {
            throw new NotFoundException(__('Data Not Found'));
        }
    }

    function getParameterSalaryTardinessId() {
        $this->autoRender = false;
        $data = ClassRegistry::init("ParameterSalary")->find("first", [
            "conditions" => [
                "ParameterSalary.uniq_name" => "tardiness",
            ],
            "recursive" => -1,
        ]);
        if (!empty($data)) {
            return json_encode($data['ParameterSalary']['id']);
        } else {
            throw new NotFoundException(__('Data Not Found'));
        }
    }

    function getParameterSalaryAbsenceId() {
        $this->autoRender = false;
        $data = ClassRegistry::init("ParameterSalary")->find("first", [
            "conditions" => [
                "ParameterSalary.uniq_name" => "absence",
            ],
            "recursive" => -1,
        ]);
        if (!empty($data)) {
            return json_encode($data['ParameterSalary']['id']);
        } else {
            throw new NotFoundException(__('Data Not Found'));
        }
    }

    function getSummaryReportTardiness($year, $month, $employeeId) {
        $this->autoRender = false;
        $start_date = date("Y-m-01", strtotime($year . "-" . $month . "-01"));
        $end_date = date("Y-m-t", strtotime($year . "-" . $month . "-01"));
        $data = ClassRegistry::init("Attendance")->buildReport($start_date, $end_date, $employeeId);
        return $data[$employeeId]['summary']['total_detik_terlambat'];
    }

    function getSummaryReportAbsence($year, $month, $employeeId) {
        $this->autoRender = false;
        $start_date = date("Y-m-01", strtotime($year . "-" . $month . "-01"));
        $end_date = date("Y-m-t", strtotime($year . "-" . $month . "-01"));
        $data = ClassRegistry::init("Attendance")->buildReport($start_date, $end_date, $employeeId);
        return $data[$employeeId]['summary']['jumlah_tidak_hadir'];
    }

    function admin_print_receipt_salary($id = null) {
        if ($this->request->is("post") || $this->request->is("put")) {
            $conds = [];
            if ($this->data['EmployeeSalary']['aim'] === '1') {
                $conds = [
                    "Employee.department_id" => $this->data['Employee']['department_id'],
                ];
            } else if ($this->data['EmployeeSalary']['aim'] === '2') {
                $conds = [
                    "EmployeeSalary.employee_id" => $this->data['EmployeeSalary']['employee_id'],
                ];
            } else {
                
            }
            $rows = $this->{ Inflector::classify($this->name) }->find('all', array(
                'conditions' => array(
                    $conds,
                    Inflector::classify($this->name) . '.month_period' => $this->data['EmployeeSalary']['month_period'],
                    Inflector::classify($this->name) . '.year_period' => $this->data['EmployeeSalary']['year_period'],
                    Inflector::classify($this->name) . '.validate_status_id' => 2,
                ),
                'contain' => [
                    "Employee" => [
                        "Account" => [
                            "Biodata"
                        ],
                        "Department",
                        "Office",
                    ],
                    "MadeBy" => [
                        "Account" => [
                            "Biodata",
                        ],
                        "Office",
                    ],
                    "ValidateBy" => [
                        "Account" => [
                            "Biodata",
                        ],
                        "Office",
                    ],
                    "ParameterEmployeeSalary" => [
                        "ParameterSalary",
                    ],
                ],
            ));
            $this->data = $rows;

            $data = array(
                'title' => 'Slip Gaji',
                'rows' => $rows,
            );
            $this->set(compact('data'));
            $this->_activePrint(["print"], "print_receipt_salary", "print_receipt_salary");
        } else {
            $this->set("departments", ClassRegistry::init("Department")->find("list", array("fields" => array("Department.id", "Department.name"))));
        }
    }

    function admin_cashier_confirm_harian() {
        $this->_activePrint(func_get_args(), "pembayaran_gaji_harian");
        $this->_setPeriodeLaporanDate("awal_EmployeeSalary_confirmed_date_by_cashier_operator", "akhir_EmployeeSalary_confirmed_date_by_cashier_operator");
        $this->conds = [
            "EmployeeSalary.validate_status_id" => 2,
            "Employee.employee_type_id" => 1,
        ];
        parent::admin_index();
    }

    function admin_cashier_confirm_bulanan() {
        $this->_activePrint(func_get_args(), "pembayaran_gaji_bulanan");
        $this->_setPeriodeLaporanDate("awal_EmployeeSalary_confirmed_date_by_cashier_operator", "akhir_EmployeeSalary_confirmed_date_by_cashier_operator");
        $this->conds = [
            "EmployeeSalary.validate_status_id" => 2,
            "Employee.employee_type_id" => 2,
        ];
        parent::admin_index();
    }

    function admin_cashier_confirm($employee_salary_id, $initial_balance_id) {
        $this->autoRender = false;
        if (!empty($employee_salary_id) && $this->EmployeeSalary->hasAny(["EmployeeSalary.id" => $employee_salary_id, "EmployeeSalary.employee_salary_cashier_status_id" => 1])) {
            $dataInitialBalance = ClassRegistry::init("InitialBalance")->find("first", [
                "conditions" => [
                    "InitialBalance.id" => $initial_balance_id
                ],
                "contain" => [
                    "GeneralEntryType"
                ]
            ]);
            $salary = 0;
            $employeeSalary = ClassRegistry::init("EmployeeSalary")->find("first", [
                "conditions" => [
                    "EmployeeSalary.id" => $employee_salary_id,
                ],
                "contain" => [
                    "InitialBalance" => [
                        "GeneralEntryType"
                    ],
                    "ParameterEmployeeSalary",
                    "Employee" => [
                        "Account" => [
                            "Biodata"
                        ],
                        "EmployeeType"
                    ],
                    "EmployeeSalaryItemLoan",
                    "CashierOperator" => [
                        "Account" => [
                            "Biodata",
                        ],
                    ],
                    "EmployeeSalarySaleProductAdditional",
                ]
            ]);
            $salary_number = $this->EmployeeSalary->generateSalaryNumber($employeeSalary['Employee']['employee_type_id'], $employee_salary_id);
            $potonganKasbon = 0;
            foreach ($employeeSalary['ParameterEmployeeSalary'] as $parameterEmployeeSalary) {
                if ($parameterEmployeeSalary["parameter_salary_id"] == ClassRegistry::init("ParameterSalary")->translateCodeToId("PKS")) {
                    $potonganKasbon = abs($parameterEmployeeSalary["nominal"]);
                }
                $salary += $parameterEmployeeSalary['nominal'];
            }
            // check if the current balance is have sufficient money to paying the employee salary
            if ($dataInitialBalance['GeneralEntryType']['latest_balance'] > $salary) {
                /* saving table employee salary first */
                $this->EmployeeSalary->data['EmployeeSalary']['id'] = $employee_salary_id;
                $this->EmployeeSalary->data['EmployeeSalary']['initial_balance_id'] = $initial_balance_id;
                $this->EmployeeSalary->data['EmployeeSalary']['employee_salary_cashier_status_id'] = 2;
                $this->EmployeeSalary->data['EmployeeSalary']['cashier_operator_id'] = $this->stnAdmin->getEmployeeId();
                $this->EmployeeSalary->data['EmployeeSalary']['confirmed_date_by_cashier_operator'] = date("Y-m-d H:i:s");
                $this->EmployeeSalary->saveAll();
                $employeeSalary = ClassRegistry::init("EmployeeSalary")->find("first", [
                    "conditions" => [
                        "EmployeeSalary.id" => $employee_salary_id,
                    ],
                    "contain" => [
                        "InitialBalance" => [
                            "GeneralEntryType"
                        ],
                        "ParameterEmployeeSalary",
                        "Employee" => [
                            "Account" => [
                                "Biodata"
                            ],
                            "EmployeeType"
                        ],
                        "EmployeeSalaryItemLoan",
                        "CashierOperator" => [
                            "Account" => [
                                "Biodata",
                            ],
                        ],
                        "EmployeeSalarySaleProductAdditional" => [
                            "SaleProductAdditional"
                        ],
                    ]
                ]);

                $updatedDataInitialBalance = [];
                $updatedDataInitialBalance['InitialBalance']['id'] = $employeeSalary['InitialBalance']['id'];
                $updatedDataInitialBalance['InitialBalance']['nominal'] = $employeeSalary['InitialBalance']['nominal'] - $salary;
                ClassRegistry::init("InitialBalance")->save($updatedDataInitialBalance);

                $updatedData = [];
                $updatedData['GeneralEntryType']['id'] = $employeeSalary['InitialBalance']['GeneralEntryType']['id'];
                $updatedData['GeneralEntryType']['latest_balance'] = $employeeSalary['InitialBalance']['nominal'] - $salary;
                ClassRegistry::init("GeneralEntryType")->save($updatedData);

                if ($employeeSalary['Employee']['EmployeeType']['id'] == 1) {
                    $account_employee_type = 29;
                } else {
                    $account_employee_type = 30;
                }
                $dataGeneralEntry = ClassRegistry::init("GeneralEntryType")->find("first", [
                    "conditions" => [
                        "GeneralEntryType.id" => $account_employee_type
                    ],
                    "recursive" => -1,
                ]);
                $mutation_balance = $employeeSalary['InitialBalance']['nominal'] - $salary;

                /* posting to general entry table */
                $dataUpdatedGeneralEntry = [];
                $dataUpdatedGeneralEntry[0]['employee_salary_id'] = $employee_salary_id;
                $dataUpdatedGeneralEntry[0]['reference_number'] = $salary_number;
                $dataUpdatedGeneralEntry[0]['transaction_name'] = $dataGeneralEntry['GeneralEntryType']['name'];
                $dataUpdatedGeneralEntry[0]['debit'] = $salary;
                $dataUpdatedGeneralEntry[0]['transaction_date'] = date("Y-m-d");
                $dataUpdatedGeneralEntry[0]['transaction_type_id'] = 6;
                $dataUpdatedGeneralEntry[0]['general_entry_type_id'] = $account_employee_type;
                $dataUpdatedGeneralEntry[0]['initial_balance'] = $employeeSalary['InitialBalance']['nominal'];
                $dataUpdatedGeneralEntry[0]['mutation_balance'] = $mutation_balance;
                $dataUpdatedGeneralEntry[0]['initial_balance_id'] = $employeeSalary['InitialBalance']['id'];
                $dataUpdatedGeneralEntry[0]['general_entry_account_type_id'] = 1;
                $dataUpdatedGeneralEntry[1]['employee_salary_id'] = $employee_salary_id;
                $dataUpdatedGeneralEntry[1]['reference_number'] = $salary_number;
                $dataUpdatedGeneralEntry[1]['transaction_name'] = $employeeSalary['InitialBalance']['GeneralEntryType']['name'];
                $dataUpdatedGeneralEntry[1]['credit'] = $salary;
                $dataUpdatedGeneralEntry[1]['transaction_date'] = date("Y-m-d");
                $dataUpdatedGeneralEntry[1]['transaction_type_id'] = 6;
                $dataUpdatedGeneralEntry[1]['general_entry_type_id'] = $employeeSalary['InitialBalance']['GeneralEntryType']['id'];
                $dataUpdatedGeneralEntry[1]['initial_balance'] = $employeeSalary['InitialBalance']['nominal'];
                $dataUpdatedGeneralEntry[1]['mutation_balance'] = $mutation_balance;
                $dataUpdatedGeneralEntry[1]['initial_balance_id'] = $employeeSalary['InitialBalance']['id'];
                $dataUpdatedGeneralEntry[1]['general_entry_account_type_id'] = 1;
                ClassRegistry::init("GeneralEntry")->saveMany($dataUpdatedGeneralEntry, ["validate" => false]);

                /* posting to transaction mutation entry */
                $dataUpdatedTransactionMutation = [];
                $dataUpdatedTransactionMutation['TransactionMutation']['employee_salary_id'] = $employee_salary_id;
                $dataUpdatedTransactionMutation['TransactionMutation']['reference_number'] = $salary_number;
                $dataUpdatedTransactionMutation['TransactionMutation']['transaction_name'] = $dataGeneralEntry['GeneralEntryType']['name'];
                $dataUpdatedTransactionMutation['TransactionMutation']['credit'] = $salary;
                $dataUpdatedTransactionMutation['TransactionMutation']['transaction_date'] = date("Y-m-d");
                $dataUpdatedTransactionMutation['TransactionMutation']['transaction_type_id'] = 6;
                $dataUpdatedTransactionMutation['TransactionMutation']['initial_balance'] = $employeeSalary['InitialBalance']['nominal'];
                $dataUpdatedTransactionMutation['TransactionMutation']['mutation_balance'] = $mutation_balance;
                $dataUpdatedTransactionMutation['TransactionMutation']['initial_balance_id'] = $employeeSalary['InitialBalance']['id'];
                ClassRegistry::init("TransactionMutation")->save($dataUpdatedTransactionMutation);
                
                // update iuran
                ClassRegistry::init("CooperativeContribution")->addByEmployeeSalary($employee_salary_id);
                
                // update Potongan Kasbon
                if ($potonganKasbon > 0) {
                    ClassRegistry::init("EmployeeDataLoanDetail")->paymentFromSalary($employeeSalary["EmployeeSalary"]["employee_id"], $employee_salary_id, $employeeSalary['Employee']['EmployeeType']['id']);
                }

                // update potongan sembako
                if (!empty($employeeSalary["EmployeeSalaryItemLoan"])) {
                    ClassRegistry::init("CooperativeItemLoanPaymentDetail")->updatePayment($employeeSalary["EmployeeSalaryItemLoan"]["cooperative_item_loan_payment_detail_id"], $employeeSalary["EmployeeSalaryItemLoan"]["amount"]);
                }
                
                // update kas koperasi & posting ke table transaksi mutasi koperasi
                $cooperative_item_loan_payment_id = $employeeSalary['EmployeeSalaryItemLoan']['cooperative_item_loan_id'];
                $amount = $employeeSalary["EmployeeSalaryItemLoan"]["amount"];
                $cooperative_cash_id = 2; // Kas kecil Koperasi
                ClassRegistry::init("CooperativeTransactionMutation")->addMutation($cooperative_cash_id, $cooperative_item_loan_payment_id, "ANSR-SMBK", $amount, $paid_date, ClassRegistry::init("CooperativeEntryType")->getIdByCode(105));

                // update data penjaulan produk tambahan && posting hibah ke koperasi
                foreach ($employeeSalary["EmployeeSalarySaleProductAdditional"] as $employeeSalarySaleProductAdditional) {
                    $this->EmployeeSalary->EmployeeSalarySaleProductAdditional->SaleProductAdditional->save([
                        "SaleProductAdditional" => [
                            "id" => $employeeSalarySaleProductAdditional["sale_product_additional_id"],
                            "payment_status_id" => 3,
                            "initial_balance_id" => $initial_balance_id
                        ],
                    ]);

                    $nominal = $employeeSalarySaleProductAdditional['SaleProductAdditional']['grand_total'];

                    // update amount of initial balance
                    $updatedDataSaleProductAdditional = [];
                    $updatedDataSaleProductAdditional['InitialBalance']['id'] = $initial_balance_id;
                    $mutation_balance = $dataInitialBalance['InitialBalance']['nominal'] + $employeeSalarySaleProductAdditional['SaleProductAdditional']['grand_total'];
                    $updatedDataSaleProductAdditional['InitialBalance']['nominal'] = $mutation_balance;
                    ClassRegistry::init("InitialBalance")->saveAll($updatedDataSaleProductAdditional);
                    
                    // update amount of general entry type
                    ClassRegistry::init("GeneralEntryType")->increaseLatestBalance($dataInitialBalance['GeneralEntryType']['id'], $nominal);
                    
                    // posting to Transaction Mutation Table
                    $reference_number = $employeeSalarySaleProductAdditional['SaleProductAdditional']['reference_number'];
                    $transaction_name = "Penjualan Produk Tambahan";
                    $transaction_date = date("Y-m-d");
                    $transaction_type_id = 3;
                    $debit_or_credit_type = "debit";
                    $relation_table_name = "sale_product_additional_id";
                    $relation_table_id = $employeeSalarySaleProductAdditional['sale_product_additional_id'];
                    $initial_balance = $dataInitialBalance['InitialBalance']['nominal'];
                    ClassRegistry::init("TransactionMutation")->post_transaction($reference_number, $transaction_name, $transaction_date, $transaction_type_id, $debit_or_credit_type, $nominal, $relation_table_name, $relation_table_id, $initial_balance_id, $initial_balance, $mutation_balance);

                    // posting to General Entry Table
                    $transaction_names = [$dataInitialBalance['GeneralEntryType']['name'], "Penjualan Produk Tambahan"];
                    $debit_or_credits = ["debit", "credit"];
                    $general_entry_type_ids = [$dataInitialBalance['GeneralEntryType']['id'], 9];
                    $general_entry_account_type_id = 2;
                    $amounts = [$nominal, $nominal];
                    ClassRegistry::init("GeneralEntry")->post_to_journal($reference_number, $transaction_names, $debit_or_credits, $transaction_date, $transaction_type_id, $general_entry_type_ids, $amounts, $general_entry_account_type_id, $relation_table_name, $relation_table_id, $initial_balance_id, $initial_balance, $mutation_balance);

                    //post hibah ke koperasi
                    $hibah_penjualan_produk_tambahan = ClassRegistry::init("CooperativeTransactionMutation")->postProductAdditionalShare($employeeSalarySaleProductAdditional["sale_product_additional_id"]);
                    if ($hibah_penjualan_produk_tambahan > 0) {
                        // update nominal of initial balance
                        $mutation = $initial_balance + $hibah_penjualan_produk_tambahan;
                        $updatedInitialBalance = [
                            "InitialBalance" => [
                                "id" => $dataInitialBalance['InitialBalance']['id'],
                                "nominal" => $mutation
                            ]
                        ];
                        ClassRegistry::init("InitialBalance")->save($updatedInitialBalance);

                        // update COA Initial Balance
                        ClassRegistry::init("GeneralEntryType")->increaseLatestBalance($dataInitialBalance['GeneralEntryType']['id'], $hibah_penjualan_produk_tambahan);

                        // update COA Hibah Penjualan Produk Tambahan
                        ClassRegistry::init("GeneralEntryType")->increaseLatestBalance(16, $hibah_penjualan_produk_tambahan);

                        // posting to Transaction Mutation Table
                        $dataHibahPenjualanPT = ClassRegistry::init("GeneralEntryType")->find("first", [
                            "conditions" => [
                                "GeneralEntryType.id" => 16
                            ],
                            "recursive" => -1
                        ]);
                        $reference_no = "HIBAH-PNJL-PT-KOP";
                        $trans_name = $dataHibahPenjualanPT['GeneralEntryType']['name'];
                        ClassRegistry::init("TransactionMutation")->post_transaction($reference_no, $trans_name, $transaction_date, $transaction_type_id, $debit_or_credit_type, $hibah_penjualan_produk_tambahan, $relation_table_name, $relation_table_id, $initial_balance_id, $initial_balance, $mutation);

                        // posting to General Entry Table
                        $trans_names = [$dataInitialBalance['GeneralEntryType']['name'], $dataHibahPenjualanPT['GeneralEntryType']['name']];
                        $debit_or_credits = ["debit", "credit"];
                        $general_entry_type_ids = [$dataInitialBalance['GeneralEntryType']['id'], 16];
                        $general_entry_account_type_id = 2;
                        $amounts = [$hibah_penjualan_produk_tambahan, $hibah_penjualan_produk_tambahan];
                        ClassRegistry::init("GeneralEntry")->post_to_journal($reference_no, $trans_names, $debit_or_credits, $transaction_date, $transaction_type_id, $general_entry_type_ids, $amounts, $general_entry_account_type_id, $relation_table_name, $relation_table_id, $initial_balance_id, $initial_balance, $mutation);
                    }
                }
                return json_encode($this->_generateStatusCode(200, "Sukses", $employeeSalary));
            } else {
                return json_encode($this->_generateStatusCode(407, 'Gagal. Uang di Kas Tidak Cukup.'));
            }
        } else {
            return json_encode($this->_generateStatusCode(405, 'Gagal'));
        }
    }

    function admin_fix_status() {
        $this->autoRender = false;
        $employeeSalarySaleProductAdditionals = $this->EmployeeSalary->EmployeeSalarySaleProductAdditional->find("all", [
            "conditions" => [
                "EmployeeSalary.employee_salary_cashier_status_id" => 2,
                "SaleProductAdditional.payment_status_id" => 1,
            ],
            "contain" => [
                "EmployeeSalary",
                "SaleProductAdditional",
            ],
        ]);
        foreach ($employeeSalarySaleProductAdditionals as $employeeSalarySaleProductAdditional) {
            $this->EmployeeSalary->EmployeeSalarySaleProductAdditional->SaleProductAdditional->save([
                "SaleProductAdditional.id" => $employeeSalarySaleProductAdditional["EmployeeSalarySaleProductAdditional"]["sale_product_additional_id"],
                "SaleProductAdditional.payment_status_id" => 3,
            ]);
        }
        $employeeSalaryLoans = $this->EmployeeSalary->EmployeeSalaryLoan->find("all", [
            "contain" => [
                "EmployeeSalary.employee_salary_cashier_status_id" => 2,
                "EmployeeSalaryLoan.is_processed" => 0,
            ],
            "contain" => [
                "EmployeeSalary" => [
                    "Employee",
                ],
            ],
            "group" => "EmployeeSalaryLoan.employee_data_loan_id",
        ]);
        foreach ($employeeSalaryLoans as $employeeSalaryLoan) {
            ClassRegistry::init("EmployeeDataLoanDetail")->paymentFromSalary($employeeSalaryLoan["EmployeeSalary"]["employee_id"], $employeeSalaryLoan["EmployeeSalary"]["id"], $employeeSalaryLoan["EmployeeSalary"]["Employee"]["employee_type_id"]);
        }
    }

}
