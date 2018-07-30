<?php

App::uses('AppController', 'Controller');

class MissAttendancesController extends AppController {

    var $name = "MissAttendances";
    var $disabledAction = array(
    );

    function admin_index() {
        $this->_activePrint(func_get_args(), "data_lupa_absen");
        $this->_setPeriodeLaporanDate("awal_MissAttendance_miss_date", "akhir_MissAttendance_miss_date");
        $this->contain = [
            "Employee" => [
                "Account" => [
                    "Biodata"
                ],
                "Office",
                "Department"
            ],
            "Supervisor" => [
                "Account" => [
                    "Biodata"
                ],
                "Office",
                "Department"
            ],
            "MissAttendanceStatus",
            "VerifyStatus",
            "ValidateStatus",
            "AttendanceType",
        ];
        parent::admin_index();
    }

    function admin_index_validate() {
        $this->_activePrint(func_get_args(), "data_lupa_absen_validasi");
        $this->_setPeriodeLaporanDate("awal_MissAttendance_miss_date", "akhir_MissAttendance_miss_date");
        $this->contain = [
            "Employee" => [
                "Account" => [
                    "Biodata"
                ],
                "Office",
                "Department"
            ],
            "Supervisor" => [
                "Account" => [
                    "Biodata"
                ],
                "Office",
                "Department"
            ],
            "MissAttendanceStatus",
            "VerifyStatus",
            "ValidateStatus"
        ];
        if ($this->stnAdmin->isAdmin()) {
            $conds = [];
        } else {
            $conds = [
                "MissAttendance.supervisor_id" => $this->stnAdmin->getEmployeeId(),
            ];
        }
        $this->conds = [
            "MissAttendance.verify_status_id" => 1,
            $conds,
        ];
        parent::admin_index();
    }

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

    function admin_add() {
        if ($this->request->is("post")) {
            $this->{ Inflector::classify($this->name) }->set($this->data);
            if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                $this->{ Inflector::classify($this->name) }->data['MissAttendance']['miss_attendance_status_id'] = 1;
                $this->{ Inflector::classify($this->name) }->data['MissAttendance']['verify_status_id'] = 1;
                $this->{ Inflector::classify($this->name) }->data['MissAttendance']['validate_status_id'] = 1;
                $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
                $this->Session->setFlash(__("Data berhasil disimpan"), 'default', array(), 'success');
                $this->redirect(array('action' => 'admin_index'));
            } else {
                $this->validationErrors = $this->{ Inflector::classify($this->name) }->validationErrors;
                $this->Session->setFlash(__("Harap mengecek kembali kesalahan dibawah."), 'default', array(), 'danger');
            }
        }
    }

    function admin_edit($id = null) {
        if ($this->request->is("post") || $this->request->is("put")) {
            $this->{ Inflector::classify($this->name) }->set($this->data);
            if ($this->{ Inflector::classify($this->name) }->validates()) {
                if (!is_null($id)) {
                    $this->{ Inflector::classify($this->name) }->id = $id;
                    $this->MissAttendance->data['MissAttendance']['id'] = $id;
                    $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
                    $rows = $this->{ Inflector::classify($this->name) }->find("first", array('conditions' => array(Inflector::classify($this->name) . ".id" => $id), "recursive" => 4));

                    $this->data = $rows;
                    $this->Session->setFlash(__("Data berhasil diubah"), 'default', array(), 'success');
                    $this->redirect(array('action' => 'admin_index'));
                } else {
                    
                }
            } else {
                $this->validationErrors = $this->{ Inflector::classify($this->name) }->validationErrors;
            }
        } else {
            $rows = $this->{ Inflector::classify($this->name) }->find("first", array('conditions' => array(Inflector::classify($this->name) . ".id" => $id), "recursive" => 4));
            $this->data = $rows;
        }
    }

    function admin_view($id = null) {
        if (!$this->MissAttendance->exists($id)) {
            throw new NotFoundException(__('Invalid data'));
        } else {
            $this->{ Inflector::classify($this->name) }->id = $id;
            $this->MissAttendance->data['MissAttendance']['id'] = $id;
            $rows = $this->{ Inflector::classify($this->name) }->find("first", array('conditions' => array(Inflector::classify($this->name) . ".id" => $id),
                "contain" => [
                    "Employee" => [
                        "Account" => [
                            "Biodata"
                        ],
                        "Office",
                        "Department",
                    ],
                    "Supervisor" => [
                        "Account" => [
                            "Biodata"
                        ],
                    ],
                    "VerifiedBy" => [
                        "Account" => [
                            "Biodata"
                        ],
                    ],
                    "ValidateBy" => [
                        "Account" => [
                            "Biodata"
                        ],
                    ],
                    "AttendanceType",
            ]));
            $this->data = $rows;
        }
    }

    function _options() {
        $this->set("missAttendanceStatuses", $this->MissAttendance->MissAttendanceStatus->find("list", ["fields" > ["MissAttendanceStatus.id", "MissAttendanceStatus.name"]]));
        $this->set("verifyStatuses", $this->MissAttendance->VerifyStatus->find("list", ["fields" > ["VerifyStatus.id", "VerifyStatus.name"]]));
        $this->set("validateStatuses", $this->MissAttendance->ValidateStatus->find("list", ["fields" > ["ValidateStatus.id", "ValidateStatus.name"]]));
        $this->set("departments", ClassRegistry::init("Department")->find("list", array("fields" => array("Department.id", "Department.name"))));
        $this->set("employeeTypes", $this->MissAttendance->Employee->EmployeeType->find("list", array("fields" => array("EmployeeType.id", "EmployeeType.name"))));
        $this->set("branchOffices", $this->MissAttendance->Employee->BranchOffice->find("list", array("fields" => array("BranchOffice.id", "BranchOffice.name"))));
        $this->set("attendanceTypes", $this->MissAttendance->AttendanceType->find("list", array("fields" => array("AttendanceType.id", "AttendanceType.label"))));
    }

    function admin_selfadd() {
        if ($this->request->is("post")) {
            $this->{ Inflector::classify($this->name) }->set($this->data);
            $this->MissAttendance->data["MissAttendance"]["employee_id"] = $this->_getEmployeeId();
            if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
                $savedData = $this->MissAttendance->find("first", [
                    "conditions" => [
                        'MissAttendance.id' => $this->MissAttendance->getLastInsertID(),
                    ],
                    "contain" => [
                        "Employee" => [
                            "Account" => [
                                "Biodata"
                            ],
                        ],
                        "Supervisor",
                    ]
                ]);
                $this->loadModel("Notification");
                $this->Notification->addNotification(null, $savedData['MissAttendance']['id'], null, $savedData["Supervisor"]["id"], "Pegawai {$savedData["Employee"]["Account"]["Biodata"]["full_name"]} mengajukan permohonan lupa absen", "/admin/miss_attendances/index");
                $this->Session->setFlash(__("Pengajuan lupa absen berhasil dikirim"), 'default', array(), 'success');
                $this->redirect(array('action' => 'admin_selfadd'));
            } else {
                $this->validationErrors = $this->{ Inflector::classify($this->name) }->validationErrors;
                $this->Session->setFlash(__("Harap mengecek kembali kesalahan dibawah."), 'default', array(), 'danger');
            }
        }
    }

    function admin_change_status_verify() {
        $this->autoRender = false;
        if ($this->request->is("PUT")) {
            $this->MissAttendance->data['MissAttendance']['id'] = $this->request->data['id'];
            $this->MissAttendance->data['MissAttendance']['verify_status_id'] = $this->request->data['status'];
            if ($this->request->data['status'] == '3') {
                $this->MissAttendance->data['MissAttendance']['verified_by_id'] = $this->_getEmployeeId();
                $this->MissAttendance->data['MissAttendance']['verified_datetime'] = date("Y-m-d H:i:s");
            } else if ($this->request->data['status'] == '2') {
                $this->MissAttendance->data['MissAttendance']['verified_by_id'] = $this->_getEmployeeId();
                $this->MissAttendance->data['MissAttendance']['verified_datetime'] = date("Y-m-d H:i:s");
                $this->MissAttendance->data['MissAttendance']['validate_status_id'] = 3;
                $this->MissAttendance->data['MissAttendance']['miss_attendance_status_id'] = 3;
            } else {
                $this->MissAttendance->data['MissAttendance']['verified_by_id'] = null;
                $this->MissAttendance->data['MissAttendance']['verified_datetime'] = null;
            }
            $this->MissAttendance->saveAll();
            $data = $this->MissAttendance->find("first", array("conditions" => array("MissAttendance.id" => $this->request->data['id']), "recursive" => 3));
            echo json_encode($this->_generateStatusCode(207, null, array("status_label" => $data['VerifyStatus']['name'])));
        } else {
            echo json_encode($this->_generateStatusCode(400));
        }
    }

    function admin_change_status_validate() {
        $this->autoRender = false;
        if ($this->request->is("PUT")) {
            $missAttendance = $this->MissAttendance->find("first", [
                "conditions" => [
                    "MissAttendance.id" => $this->request->data['id']
                ],
                "recursive" => -1,
            ]);
            if (!empty($missAttendance)) {
                $this->MissAttendance->data['MissAttendance']['id'] = $this->request->data['id'];
                $this->MissAttendance->data['MissAttendance']['validate_status_id'] = $this->request->data['status'];
                if ($this->request->data['status'] == '2') {
                    $this->MissAttendance->data['MissAttendance']['validate_by_id'] = $this->_getEmployeeId();
                    $this->MissAttendance->data['MissAttendance']['validate_datetime'] = date("Y-m-d H:i:s");
                    $this->MissAttendance->data['MissAttendance']['miss_attendance_status_id'] = 2;
                    $this->MissAttendance->data['Attendance']['dt'] = $missAttendance["MissAttendance"]["miss_date"]." ".$missAttendance["MissAttendance"]["miss_time"];
                    $this->MissAttendance->data['Attendance']['attendance_type_id'] = $missAttendance["MissAttendance"]["attendance_type_id"];
                    $this->MissAttendance->data['Attendance']['employee_id'] = $missAttendance["MissAttendance"]["employee_id"];
                } else if ($this->request->data['status'] == '3') {
                    $this->MissAttendance->data['MissAttendance']['validate_by_id'] = $this->_getEmployeeId();
                    $this->MissAttendance->data['MissAttendance']['validate_datetime'] = date("Y-m-d H:i:s");
                    $this->MissAttendance->data['MissAttendance']['miss_attendance_status_id'] = 3;
                } else {
                    $this->MissAttendance->data['MissAttendance']['validate_by_id'] = null;
                    $this->MissAttendance->data['MissAttendance']['validate_datetime'] = null;
                }
                $this->MissAttendance->saveAll();
                $data = $this->MissAttendance->find("first", array("conditions" => array("MissAttendance.id" => $this->request->data['id']), "recursive" => 1));
                echo json_encode($this->_generateStatusCode(207, null, array("status_label" => $data['ValidateStatus']['name'])));
            } else {
                echo json_encode($this->_generateStatusCode(400));
            }
        } else {
            echo json_encode($this->_generateStatusCode(400));
        }
    }

    function admin_get_atasan($id) {
        $this->autoRender = false;
        if (!empty($id)) {
            if ($this->request->is("GET")) {
                $supervisorId = ClassRegistry::init("Office")->find("first", [
                    "conditions" => [
                        "Office.id" => $id,
                    ]
                ]);
                $data = ClassRegistry::init("Employee")->find("first", [
                    "conditions" => [
                        "Employee.office_id" => $supervisorId['Office']['supervisor_id'],
                    ],
                    "contain" => [
                        "Account" => [
                            "Biodata",
                        ]
                    ],
                ]);

                return json_encode($data);
            } else {
                return json_encode($this->_generateStatusCode(400));
            }
        }
    }

}
