<?php

App::uses('AppController', 'Controller');

class AttendancesController extends AppController {

    var $name = "Attendances";
    var $disabledAction = array(
        "admin_add",
        "admin_edit",
    );

    function _options() {
        $this->set("employees", ClassRegistry::init("Employee")->getListWithFullname());
        $this->set("excludedEmployees", ClassRegistry::init("Employee")->getListWithFullnameExcludedEmployee());
        $this->set("employeeTypes", ClassRegistry::init("EmployeeType")->find("list", ["fields" => ["EmployeeType.id", "EmployeeType.name"]]));
        $this->set("departments", ClassRegistry::init("Department")->find("list", array("fields" => array("Department.id", "Department.name"))));
        $this->set("branchOffices", ClassRegistry::init("BranchOffice")->find("list", array("fields" => array("BranchOffice.id", "BranchOffice.name"))));
        $this->set("employeeTypes", ClassRegistry::init("EmployeeType")->find("list", array("fields" => array("EmployeeType.id", "EmployeeType.name"))));
        $this->set("permitCategories", ClassRegistry::init("PermitCategory")->find("list", ["fields" => ["PermitCategory.name", "PermitCategory.label"]]));
    }

    function beforeRender() {
        $this->_options();
        parent::beforeRender();
    }

    function beforeFilter() {
        parent::beforeFilter();
        $this->_setPageInfo("admin_index", "");
        $this->_setPageInfo("admin_add", "");
        $this->_setPageInfo("admin_edit", "");
    }

    function admin_index() {
        $this->_activePrint(func_get_args(), "data_absensi");
        $this->_setPeriodeLaporanDate("awal_Attendance_dt", "akhir_Attendance_dt");
        $this->contain = [
            "AttendanceType",
            "Employee" => [
                "Account" => [
                    "Biodata"
                ]
            ]
        ];
        $this->order = "Attendance.dt desc";
        parent::admin_index();
    }

    function admin_import_from_machine() {
        if ($this->request->is("post")) {
            if (!empty($this->data['Attendance']['attendance_machine_id'])) {
                $from = $this->data['Attendance']['from'];
                $to = $this->data['Attendance']['to'];
                if (empty($from)) {
                    $from = date("Y-m-d");
                }
                if (empty($to)) {
                    $to = date("Y-m-d");
                }
                $result = $this->_importData($this->data['Attendance']['attendance_machine_id'], $from, $to);
                switch ($result["code"]) {
                    case 206:
                        $this->Session->setFlash(__("Data berhasil diimport"), 'default', array(), 'success');
                        $this->redirect(array('action' => 'admin_index'));
                        break;
                    case 410:
                        $this->Session->setFlash(__("Mesin Absensi Tidak Ada"), 'default', array(), 'danger');
                        break;
                    case 411:
                        $this->Session->setFlash(__("Tidak dapat terhubung dengan mesin absensi"), 'default', array(), 'danger');
                        break;
                }
            } else {
                //parameter salah
            }
        }
        $this->set("attendanceMachines", ClassRegistry::init("AttendanceMachine")->find("list", array("fields" => array("AttendanceMachine.id", "AttendanceMachine.label"))));
        $this->set(compact('data'));
    }

    function admin_laporan_detail_absensi() {
        $this->_activePrint(func_get_args(), "laporan_detail_absensi");
        $nofilter = false;
        if (isset($this->request->query['Laporan_tanggal_awal']) && !empty($this->request->query['Laporan_tanggal_awal']) && isset($this->request->query['Laporan_tanggal_akhir']) && !empty($this->request->query['Laporan_tanggal_akhir'])) {
            $start_date = $this->request->query['Laporan_tanggal_awal'];
            $end_date = $this->request->query['Laporan_tanggal_akhir'];
        } else if (isset($this->request->query['Laporan_bulan']) && !empty($this->request->query['Laporan_bulan']) && isset($this->request->query['Laporan_tahun']) && !empty($this->request->query['Laporan_tahun'])) {
            $start_date = date("Y-m-01", strtotime("01-" . $this->request->query['Laporan_bulan'] . "-" . $this->request->query['Laporan_tahun']));
            $end_date = $date = date("Y-m-t", strtotime("01-" . $this->request->query['Laporan_bulan'] . "-" . $this->request->query['Laporan_tahun']));
        } else {
//            $start_date = date("Y-m-01");
//            $end_date = $date = date("Y-m-t");
            $nofilter = true;
        }
        if ($nofilter === false) {
            if (isset($this->request->query['Laporan_pegawai']) && !empty($this->request->query['Laporan_pegawai'])) {
                $employee = [$this->request->query['Laporan_pegawai']];
            } else {
                $employee = false;
            }
            if (isset($this->request->query['Laporan_pegawai']) && !empty($this->request->query['Laporan_pegawai'])) {
                $employee = [$this->request->query['Laporan_pegawai']];
            } else {
                $conds = [];
                if (isset($this->request->query['select_Employee_employee_type_id']) && !empty($this->request->query['select_Employee_employee_type_id'])) {
                    $type = $this->request->query['select_Employee_employee_type_id'];
                    $conds = [
                        "Employee.employee_type_id" => $type,
                    ];
                    $employee = ClassRegistry::init("Employee")->find("list", [
                        "conditions" => [
                            $conds
                        ],
                        "fields" => [
                            "Employee.id"
                        ]
                    ]);
//                    debug($type);
//                    debug($employee);
//                    die;
                } else {
                    $employee = false;
                }
            }
            $result = $this->Attendance->buildReport($start_date, $end_date, $employee);
            $this->set(compact('result', 'start_date', 'end_date'));
        }
    }

    function admin_laporan_absensi_individu() {
        $this->set("employees", ClassRegistry::init("Employee")->getListWithFullname());
        if (isset($this->request->query["show"]) && $this->request->query["show"] == 1) {
            if (isset($this->request->query['Laporan_tanggal_awal']) && !empty($this->request->query['Laporan_tanggal_awal']) && isset($this->request->query['Laporan_tanggal_akhir']) && !empty($this->request->query['Laporan_tanggal_akhir'])) {
                $start_date = $this->request->query['Laporan_tanggal_awal'];
                $end_date = $this->request->query['Laporan_tanggal_akhir'];
            } else if (isset($this->request->query['Laporan_bulan']) && !empty($this->request->query['Laporan_bulan']) && isset($this->request->query['Laporan_tahun']) && !empty($this->request->query['Laporan_tahun'])) {
                $start_date = date("Y-m-01", strtotime("01-" . $this->request->query['Laporan_bulan'] . "-" . $this->request->query['Laporan_tahun']));
                $end_date = $date = date("Y-m-t", strtotime("01-" . $this->request->query['Laporan_bulan'] . "-" . $this->request->query['Laporan_tahun']));
            } else {
                $start_date = date("Y-m-01");
                $end_date = $date = date("Y-m-t");
            }
        } else {
            $start_date = date("Y-m-01");
            $end_date = $date = date("Y-m-t");
        }
        $employee = $this->Session->read("credential.admin.Employee.id");
        $result = $this->Attendance->buildReport($start_date, $end_date, $employee);
        $this->set(compact('result', 'start_date', 'end_date'));
        $this->_activePrint(func_get_args(), "laporan_absensi_individu");
    }

    function admin_laporan_kehadiran() {
        $this->_activePrint(func_get_args(), "laporan_kehadiran");
        if (isset($this->request->query['Laporan_tanggal_awal']) && !empty($this->request->query['Laporan_tanggal_awal']) && isset($this->request->query['Laporan_tanggal_akhir']) && !empty($this->request->query['Laporan_tanggal_akhir'])) {
            $start_date = $this->request->query['Laporan_tanggal_awal'];
            $end_date = $this->request->query['Laporan_tanggal_akhir'];
        } else if (isset($this->request->query['Laporan_bulan']) && !empty($this->request->query['Laporan_bulan']) && isset($this->request->query['Laporan_tahun']) && !empty($this->request->query['Laporan_tahun'])) {
            $start_date = date("Y-m-01", strtotime("01-" . $this->request->query['Laporan_bulan'] . "-" . $this->request->query['Laporan_tahun']));
            $end_date = $date = date("Y-m-t", strtotime("01-" . $this->request->query['Laporan_bulan'] . "-" . $this->request->query['Laporan_tahun']));
        } else {
            $start_date = date("Y-m-01");
            $end_date = $date = date("Y-m-t");
        }
        if (isset($this->request->query['Laporan_pegawai']) && !empty($this->request->query['Laporan_pegawai'])) {
            $employee = [$this->request->query['Laporan_pegawai']];
        } else {
            $conds = [];
            if (isset($this->request->query['select_Employee_employee_type_id']) && !empty($this->request->query['select_Employee_employee_type_id'])) {
                $type = $this->request->query['select_Employee_employee_type_id'];
                $conds = [
                    "Employee.employee_type_id" => $type,
                ];
                $employee = ClassRegistry::init("Employee")->find("list", [
                    "conditions" => [
                        $conds
                    ],
                    "fields" => [
                        "Employee.id"
                    ]
                ]);
            } else {
                $employee = false;
            }
        }
        $result = $this->Attendance->buildReport($start_date, $end_date, $employee);
        $this->set(compact('result', 'start_date', 'end_date'));
    }

    function admin_rekap_jam_kerja() {
        $this->_activePrint(func_get_args(), "rekap_jam_kerja");
        if (isset($this->request->query['Laporan_tanggal_awal']) && !empty($this->request->query['Laporan_tanggal_awal']) && isset($this->request->query['Laporan_tanggal_akhir']) && !empty($this->request->query['Laporan_tanggal_akhir'])) {
            $start_date = $this->request->query['Laporan_tanggal_awal'];
            $end_date = $this->request->query['Laporan_tanggal_akhir'];
        } else if (isset($this->request->query['Laporan_bulan']) && !empty($this->request->query['Laporan_bulan']) && isset($this->request->query['Laporan_tahun']) && !empty($this->request->query['Laporan_tahun'])) {
            $start_date = date("Y-m-01", strtotime("01-" . $this->request->query['Laporan_bulan'] . "-" . $this->request->query['Laporan_tahun']));
            $end_date = $date = date("Y-m-t", strtotime("01-" . $this->request->query['Laporan_bulan'] . "-" . $this->request->query['Laporan_tahun']));
        } else {
            if (date('D') === 'Sat') {
                $start_date = date("Y-m-d", strtotime("last Saturday"));
                $end_date = $date = date("Y-m-d", strtotime("last Friday"));
            } else if (date('D') === 'Fri') {
                $start_date = date("Y-m-d", strtotime("last Saturday"));
                $end_date = $date = date("Y-m-d");
            } else {
                $start_date = date("Y-m-d", strtotime("last Saturday"));
                $end_date = $date = date("Y-m-d", strtotime("next Friday"));
            }
        }
        if (isset($this->request->query['Laporan_cabang']) && !empty($this->request->query['Laporan_cabang'])) {
            if (isset($this->request->query['Laporan_pegawai']) && !empty($this->request->query['Laporan_pegawai'])) {
                $employee = [$this->request->query['Laporan_pegawai']];
            } else if (isset($this->request->query['Laporan_jenis_pegawai']) && !empty($this->request->query['Laporan_jenis_pegawai'])) {
                $employee = ClassRegistry::init("Employee")->find("list", [
                    "fields" => [
                        "Employee.id"
                    ],
                    "conditions" => [
                        "Employee.employee_type_id" => $this->request->query['Laporan_jenis_pegawai'],
                        "Employee.branch_office_id" => $this->request->query['Laporan_cabang'],
                    ]
                ]);
            } else {
                $employee = ClassRegistry::init("Employee")->getEmployeeIdByBranch($this->request->query['Laporan_cabang']);
            }
        } else {
            if (isset($this->request->query['Laporan_pegawai']) && !empty($this->request->query['Laporan_pegawai'])) {
                $employee = [$this->request->query['Laporan_pegawai']];
            } else if (isset($this->request->query['Laporan_jenis_pegawai']) && !empty($this->request->query['Laporan_jenis_pegawai'])) {
                $employee = ClassRegistry::init("Employee")->find("list", ["fields" => ["Employee.id"], "conditions" => ["Employee.employee_type_id" => $this->request->query['Laporan_jenis_pegawai']]]);
            } else {
                $employee = false;
            }
        }
        $dataHoliday = ClassRegistry::init("Holiday")->findFromRange($start_date, $end_date);
        $this->_setPeriodeLaporanDate($start_date, $end_date);
        $result = $this->Attendance->buildReport($start_date, $end_date, $employee);
        $this->set(compact('result', 'start_date', 'end_date', 'dataHoliday'));
    }

    function admin_absensi_kehadiran() {
        $this->_activePrint(func_get_args(), "absensi_kehadiran_default");
        if (isset($this->request->query['Laporan_bulan']) && !empty($this->request->query['Laporan_bulan']) && isset($this->request->query['Laporan_tahun']) && !empty($this->request->query['Laporan_tahun'])) {
            $start_date = date("Y-m-01", strtotime("01-" . $this->request->query['Laporan_bulan'] . "-" . $this->request->query['Laporan_tahun']));
            $end_date = $date = date("Y-m-t", strtotime("01-" . $this->request->query['Laporan_bulan'] . "-" . $this->request->query['Laporan_tahun']));
        } else {
            $start_date = date("Y-m-01");
            $end_date = $date = date("Y-m-t");
        }
        $conds = [];
        if (isset($this->request->query['select_Employee_employee_type_id']) && !empty($this->request->query['select_Employee_employee_type_id'])) {
            $type = $this->request->query['select_Employee_employee_type_id'];
            $conds = [
                "Employee.employee_type_id" => $type,
            ];
        }
        $data = ClassRegistry::init("Employee")->find("all", [
            "contain" => [
                "Account" => [
                    "Biodata",
                    "User",
                ],
                "Department",
                "Office",
            ],
            "conditions" => [
                "not" => [
                    "Account.id" => ClassRegistry::init("Employee")->excludedEmployee(),
                ],
                $conds,
            ]
        ]);

        $empData = [];
        foreach ($data as $emp) {
            $empData[$emp['Employee']['id']] = $emp;
        }
        $defaultResult = $this->Attendance->buildReport($start_date, $end_date, array_column(array_column($empData, "Employee"), "id"));
//        debug($defaultResult[116]);
//        die;
        $this->set(compact('defaultResult', 'empData', 'start_date', 'end_date'));
        $this->set("departments", ClassRegistry::init("Department")->find("list", array("fields" => array("Department.id", "Department.name"))));
    }
    
    function admin_absensi_kehadiran_per_pegawai($id=null) {
        $this->_activePrint(func_get_args(), "absensi_kehadiran_per_pegawai");
        if(isset($this->request->query['employee_id']) && !empty($this->request->query['employee_id'])) {
            $id = $this->request->query['employee_id'];
        } else {
            $dataExcludedEmployee = ClassRegistry::init("Employee")->find("first",[
                "conditions" => [
                    "Employee.employee_work_status_id" => 4
                ],
                "contain" => [
                    "Account" => [
                        "Biodata"
                    ]
                ],
                "order" => "Employee.id DESC"
            ]);
            $id = $dataExcludedEmployee['Employee']['id'];
        }
        if (isset($this->request->query['Laporan_bulan']) && !empty($this->request->query['Laporan_bulan']) && isset($this->request->query['Laporan_tahun']) && !empty($this->request->query['Laporan_tahun'])) {
            $start_date = date("Y-m-01", strtotime("01-" . $this->request->query['Laporan_bulan'] . "-" . $this->request->query['Laporan_tahun']));
            $end_date = $date = date("Y-m-t", strtotime("01-" . $this->request->query['Laporan_bulan'] . "-" . $this->request->query['Laporan_tahun']));
        } else {
            $start_date = date("Y-m-01");
            $end_date = $date = date("Y-m-t");
        }
        $conds = [];
        $data = ClassRegistry::init("Employee")->find("first", [
            "contain" => [
                "Account" => [
                    "Biodata",
                    "User",
                ],
                "Department",
                "Office",
            ],
            "conditions" => [
                "Employee.id" => $id,
                $conds,
            ]
        ]);
        $empData = $data;
        $defaultResult = $this->Attendance->buildReport($start_date, $end_date, $data['Employee']['id'], true);
        $emp_id = $data['Employee']['id'];
        $this->set(compact('defaultResult', 'empData', 'start_date', 'end_date', 'emp_id'));
        $this->set("departments", ClassRegistry::init("Department")->find("list", array("fields" => array("Department.id", "Department.name"))));
    }

    function admin_laporan_daftar_hadir() {
        $this->_activePrint(func_get_args(), "laporan_daftar_hadir", ["print" => "print_nokop", "excel" => "excel_nokop"]);
        if (isset($this->request->query['Laporan_tanggal_awal']) && !empty($this->request->query['Laporan_tanggal_awal']) && isset($this->request->query['Laporan_tanggal_akhir']) && !empty($this->request->query['Laporan_tanggal_akhir'])) {
            $start_date = $this->request->query['Laporan_tanggal_awal'];
            $end_date = $this->request->query['Laporan_tanggal_akhir'];
        } else {
            $start_date = date("Y-m-01");
            $end_date = $date = date("Y-m-t");
        }
        if (isset($this->request->query['Laporan_department']) && !empty($this->request->query['Laporan_department'])) {
            $departmentId = $this->request->query['Laporan_department'];
        } else {
            $departmentId = "";
        }
        $pegawaiConds = [];
        if (!empty($departmentId)) {
            $pegawaiConds = [
                "Employee.department_id" => $departmentId,
            ];
        }
        $pegawaiConds["not"] = [
            "Account.id" => ClassRegistry::init("Employee")->excludedEmployee(),
        ];
        $data = ClassRegistry::init("Employee")->find("all", [
            "conditions" => [
                $pegawaiConds
            ],
            "contain" => [
                "Account" => [
                    "Biodata",
                    "User",
                ],
                "Department",
                "Office",
                "UnitPosition",
                "EmployeeClass",
            ]
        ]);

        $empData = [];
        foreach ($data as $emp) {
            $empData[$emp['Employee']['id']] = $emp;
        }

        $pegawais = ClassRegistry::init("Employee")->find("list", [
            "conditions" => [
                $pegawaiConds
            ],
            "fields" => [
                "Employee.id",
                "Employee.id",
            ]
        ]);
        $defaultResult = $this->Attendance->buildReport($start_date, $end_date, $pegawais);
        $this->set(compact('defaultResult', 'empData', 'start_date', 'end_date'));
    }

    function admin_rekap_absensi() {
        $this->_activePrint(func_get_args(), "rekap_absensi");
        if (isset($this->request->query['Laporan_bulan']) && !empty($this->request->query['Laporan_bulan']) && isset($this->request->query['Laporan_tahun']) && !empty($this->request->query['Laporan_tahun'])) {
            $start_date = date("Y-m-01", strtotime("01-" . $this->request->query['Laporan_bulan'] . "-" . $this->request->query['Laporan_tahun']));
            $end_date = $date = date("Y-m-t", strtotime("01-" . $this->request->query['Laporan_bulan'] . "-" . $this->request->query['Laporan_tahun']));
            $currentMY = $this->request->query['Laporan_tahun'] . "-" . $this->request->query['Laporan_bulan'];
        } else if (isset($this->request->query['Laporan_bulan']) && empty($this->request->query['Laporan_bulan'])) {
            $start_date = date("Y-01-01");
            $end_date = $date = date("Y-12-31");
            $currentYear = $this->request->query['Laporan_tahun'];
        } else {
            $start_date = date("Y-m-01");
            $end_date = $date = date("Y-m-t");
            $currentMY = date("Y-m");
        }
        
        if(isset($this->request->query['Laporan_tanggal_mulai']) && !empty($this->request->query['Laporan_tanggal_mulai']) && isset($this->request->query['Laporan_tanggal_akhir']) && !empty($this->request->query['Laporan_tanggal_akhir'])) {
            $start_date = $this->request->query['Laporan_tanggal_mulai'];
            $end_date = $this->request->query['Laporan_tanggal_akhir'];
        }
        
        if (isset($this->request->query['Laporan_department']) && !empty($this->request->query['Laporan_department'])) {
            $departmentId = $this->request->query['Laporan_department'];
        } else {
            $departmentId = "";
        }
        $pegawaiConds = [];
        if (!empty($departmentId)) {
            $pegawaiConds = [
                "Employee.department_id" => $departmentId,
            ];
        }
        if (isset($this->request->query['select_Employee_employee_type_id']) && !empty($this->request->query['select_Employee_employee_type_id'])) {
            $type = $this->request->query['select_Employee_employee_type_id'];
            $pegawaiConds = [
                "Employee.employee_type_id" => $type,
            ];
        }
        $pegawaiConds["not"] = [
            "Employee.id" => ClassRegistry::init("Employee")->excludedEmployee(),
        ];
        $data = ClassRegistry::init("Employee")->find("all", [
            "conditions" => [
                $pegawaiConds
            ],
            "contain" => [
                "Account" => [
                    "Biodata",
                    "User",
                ],
                "Department",
                "Office",
            ]
        ]);

        $empData = [];
        foreach ($data as $emp) {
            $empData[$emp['Employee']['id']] = $emp;
        }

        $pegawais = ClassRegistry::init("Employee")->find("list", [
            "conditions" => [
                $pegawaiConds
            ],
            "fields" => [
                "Employee.id",
                "Employee.id",
            ]
        ]);
        $result = $this->Attendance->buildReport($start_date, $end_date, $pegawais);
        $this->set(compact('currentYear', 'currentMY', 'result', 'empData', 'start_date', 'end_date'));
        $this->set("departments", ClassRegistry::init("Department")->find("list", array("fields" => array("Department.id", "Department.name"))));
        $this->set("employees", ClassRegistry::init("Employee")->getListWithFullname());
        $this->set("permitTypeList", ClassRegistry::init("PermitType")->find("all", ["fields" => ["PermitType.uniq_name", "PermitType.name", "PermitCategory.name"], "contain" => ["PermitCategory"]]));
    }

    function _importData($machine_id = null, $from = null, $to = null) {
        $attendanceMachine = ClassRegistry::init("AttendanceMachine")->find("first", array(
            "conditions" => array(
                "AttendanceMachine.id" => $machine_id,
            ),
            "recursive" => 1,
        ));
        if (!empty($attendanceMachine)) {
            App::import('Vendor', 'ConnectionTester');
            $connection = new ConnectionTester();
            if ($connection->testIP4($attendanceMachine['AttendanceMachine']['ipv4'], $attendanceMachine['AttendanceMachine']['port'])) {
//                $count = count($attendanceMachine['AttendanceEmployeeUid']);
                $relation = ClassRegistry::init("AttendanceEmployeeUid")->find("list", array(
                    "fields" => array(
                        "AttendanceEmployeeUid.uid",
                        "AttendanceEmployeeUid.employee_id",
                    ),
                    "conditions" => array(
                        "AttendanceEmployeeUid.attendance_machine_id" => $machine_id,
                    ),
                ));
                $attTypes = ClassRegistry::init("AttendanceType")->find("list", array(
                    "fields" => array(
                        "AttendanceType.name",
                        "AttendanceType.id",
                    ),
                ));
                $attPidTypes = ClassRegistry::init("AttendanceType")->find("list", array(
                    "fields" => array(
                        "AttendanceType.pid",
                        "AttendanceType.id",
                    ),
                ));
                $employees = $this->Attendance->Employee->find("all", [
                    "contain" => [
                        "WorkingHourType" => [
                            "WorkingHourTypeDetail" => [
                                "Day",
                            ],
                        ]
                    ]
                ]);
                $employeWorkingHours = [];
                foreach ($employees as $employee) {
                    foreach ($employee["WorkingHourType"]["WorkingHourTypeDetail"] as $workingHourTypeDetail) {
                        $employeWorkingHours[$employee["Employee"]["id"]][$workingHourTypeDetail["Day"]["php_n"]] = [
                            "start_in" => date("H:i:s", strtotime($workingHourTypeDetail["start_in"])),
                            "end_in" => date("H:i:s", strtotime($workingHourTypeDetail["end_in"])),
                            "start_home" => date("H:i:s", strtotime($workingHourTypeDetail["start_home"])),
                            "end_home" => date("H:i:s", strtotime($workingHourTypeDetail["end_home"])),
                            "start_out" => date("H:i:s", strtotime($workingHourTypeDetail["start_out"])),
                            "end_out" => date("H:i:s", strtotime($workingHourTypeDetail["end_out"])),
                            "overtime_in" => date("H:i:s", strtotime($workingHourTypeDetail["overtime_in"])),
                            "overtime_out" => date("H:i:s", strtotime($workingHourTypeDetail["overtime_out"])),
                        ];
                        $employeWorkingHours[$employee["Employee"]["id"]]["auto"] = !$employee["WorkingHourType"]["is_custom"];
                    }
                }
                $count = 1000;
                $start = 0;
                $fence = 50;
                while ($start < $count) {
                    $uids = "";
                    for ($start; $start <= $fence; $start++) {
//                        $uids.="uid=" . $attendanceMachine['AttendanceEmployeeUid'][$start]['uid'] . "&";
                        $uids.="uid=" . $start . "&";
                    }
                    $uids = rtrim($uids, "&");
                    $url = 'http://' . $attendanceMachine['AttendanceMachine']['ipv4'] . ":" . $attendanceMachine['AttendanceMachine']['port'] . '/form/Download?sdate=' . $from . '&edate=' . $to . '&period=0&' . $uids;
                    $targetLog = APP . _PRIVATE_DIR . DS . 'attlog/' . $from . "-" . $to . "." . time() . "." . rand(100000, 999999) . ".tsv";
                    $src = @fopen($url, 'r');
                    $dest = @fopen($targetLog, 'w');
                    @stream_copy_to_stream($src, $dest);
                    $content = file($targetLog);
                    @fclose($dest);
                    @fclose($src);
                    $data = [];
                    foreach ($content as $log) {
                        $data[] = explode("\t", $log);
                    }

                    foreach ($data as $entry) {
                        $this->Attendance->create();
                        $php_n = date("N", strtotime($entry[2]));
                        if (!isset($relation[trim($entry[0])])) {
                            continue;
                        }
                        $employee_id = $relation[$entry[0]];
                        $dt = $entry[2];
                        $pid = trim($entry[4]);
                        $clock_time = date("H:i:s", strtotime($dt));
                        $clock_date = date("Y-m-d", strtotime($dt));
                        $attendance_type_id = false;
                        if ($employeWorkingHours[$employee_id]["auto"]) {
                            if (isset($employeWorkingHours[$employee_id][$php_n])) {
                                if (isBetween($employeWorkingHours[$employee_id][$php_n]["start_in"], $employeWorkingHours[$employee_id][$php_n]["end_in"], $clock_time)) {
                                    $attendance_type_id = $attTypes["work_in"];
                                } else if (isBetween($employeWorkingHours[$employee_id][$php_n]["start_home"], $employeWorkingHours[$employee_id][$php_n]["end_home"], $clock_time)) {
                                    $attendance_type_id = $attTypes["work_out"];
                                } else if (isBetween($employeWorkingHours[$employee_id][$php_n]["start_out"], $employeWorkingHours[$employee_id][$php_n]["end_out"], $clock_time)) {
                                    $countBreak = $this->Attendance->find("count", [
                                        "recursive" => -1,
                                        "conditions" => [
                                            "Attendance.dt between '$clock_date {$employeWorkingHours[$employee_id][$php_n]["start_out"]}'and '$clock_date {$employeWorkingHours[$employee_id][$php_n]["end_out"]}'",
                                            "Attendance.employee_id" => $employee_id,
                                        ],
                                    ]);
                                    if ($countBreak == 0) {
                                        $attendance_type_id = $attTypes["break_out"];
                                    } else {
                                        $attendance_type_id = $attTypes["break_in"];
                                    }
                                } else if (isBetween($employeWorkingHours[$employee_id][$php_n]["overtime_in"], $employeWorkingHours[$employee_id][$php_n]["overtime_out"], $clock_time)) {
                                    $overtime_in = new DateTime("$clock_date {$employeWorkingHours[$employee_id][$php_n]["overtime_in"]}");
                                    $overtime_out = new DateTime("$clock_date {$employeWorkingHours[$employee_id][$php_n]["overtime_out"]}");
                                    if ($overtime_in > $overtime_out)
                                        $overtime_out->modify('+1 day');
                                    $testClock = new DateTime("$clock_date $clock_time");
                                    if ($overtime_in <= $testClock && $overtime_out <= $testClock) {
                                        
                                    } else {
                                        $overtime_in->modify('-1 day');
                                        $overtime_out->modify('-1 day');
                                    };
                                    $countOT = $this->Attendance->find("count", [
                                        "recursive" => -1,
                                        "conditions" => [
                                            "DATE_FORMAT(Attendance.dt,'%Y-%m-%d')" => $clock_date,
                                            "Attendance.employee_id" => $employee_id,
                                            "Attendance.attendance_type_id" => [$attTypes["ot_out"], $attTypes["ot_in"]],
                                        ],
                                    ]);
                                    $checkHome = $this->Attendance->find("count", [
                                        "recursive" => -1,
                                        "conditions" => [
                                            "DATE_FORMAT(Attendance.dt,'%Y-%m-%d')" => $clock_date,
                                            "Attendance.employee_id" => $employee_id,
                                            "Attendance.attendance_type_id" => $attTypes["work_out"],
                                        ],
                                    ]);
                                    if ($checkHome == 0) {
                                        if ($countOT == 0) {
                                            $attendance_type_id = $attTypes["ot_out"];
                                        } else {
                                            $attendance_type_id = $attTypes["ot_in"];
                                        }
                                    } else {
                                        if ($countOT == 0) {
                                            $attendance_type_id = $attTypes["ot_in"];
                                        } else {
                                            $attendance_type_id = $attTypes["ot_out"];
                                        }
                                    }
                                }
                            } else {
                                if ($clock_time < "13:00") {
                                    $attendance_type_id = $attTypes["work_in"];
                                } else {
                                    $attendance_type_id = $attTypes["ot_out"];
                                }
                            }
                        } else {
                            $attendance_type_id = $attPidTypes[$pid];
                        }
                        if ($attendance_type_id && !$this->Attendance->hasAny([
                                    "employee_id" => $employee_id,
//                                    "attendance_type_id" => $attendance_type_id,
                                    "dt" => $dt,
                                ])) {
                            $this->Attendance->save([
                                "employee_id" => $employee_id,
                                "attendance_type_id" => $attendance_type_id,
                                "dt" => $dt,
                            ]);
                        }
                    }
                    $fence+=50;
                }
                return ["code" => 206];
            } else {
                return ["code" => 411];
            }
        } else {
            //mesin absensi tidak ditemukan
            return ["code" => 410];
        }
    }

    function test_import() {
        $this->autoRender = FALSE;
        $machine_id = 1;
        $url = "http://localhost/test/absenbulananchenwoo.dat";
        $src = @fopen($url, 'r+');
        $targetLog = APP . _PRIVATE_DIR . DS . 'attlog/' . rand(1000, 9999) . ".tsv";
        $src = @fopen($url, 'r');
        $dest = @fopen($targetLog, 'w');
        @stream_copy_to_stream($src, $dest);
        $content = file($targetLog);
        $data = [];
        foreach ($content as $log) {
            $data[] = explode("\t", $log);
        }
        $relation = ClassRegistry::init("AttendanceEmployeeUid")->find("list", array(
            "fields" => array(
                "AttendanceEmployeeUid.uid",
                "AttendanceEmployeeUid.employee_id",
            ),
            "conditions" => array(
                "AttendanceEmployeeUid.attendance_machine_id" => $machine_id,
            ),
        ));
        $attTypes = ClassRegistry::init("AttendanceType")->find("list", array(
            "fields" => array(
                "AttendanceType.name",
                "AttendanceType.id",
            ),
        ));
        $employees = $this->Attendance->Employee->find("all", [
            "contain" => [
                "WorkingHourType" => [
                    "WorkingHourTypeDetail" => [
                        "Day",
                    ],
                ]
            ]
        ]);
        $employeWorkingHours = [];
        foreach ($employees as $employee) {
            foreach ($employee["WorkingHourType"]["WorkingHourTypeDetail"] as $workingHourTypeDetail) {
                $employeWorkingHours[$employee["Employee"]["id"]][$workingHourTypeDetail["Day"]["php_n"]] = [
                    "start_in" => date("H:i:s", strtotime($workingHourTypeDetail["start_in"])),
                    "end_in" => date("H:i:s", strtotime($workingHourTypeDetail["end_in"])),
                    "start_home" => date("H:i:s", strtotime($workingHourTypeDetail["start_home"])),
                    "end_home" => date("H:i:s", strtotime($workingHourTypeDetail["end_home"])),
                    "start_out" => date("H:i:s", strtotime($workingHourTypeDetail["start_out"])),
                    "end_out" => date("H:i:s", strtotime($workingHourTypeDetail["end_out"])),
                    "overtime_in" => date("H:i:s", strtotime($workingHourTypeDetail["overtime_in"])),
                    "overtime_out" => date("H:i:s", strtotime($workingHourTypeDetail["overtime_out"])),
                ];
            }
        }
        foreach ($data as $i => $entry) {
            $this->Attendance->create();
            $php_n = date("N", strtotime($entry[1]));
            if ($i % 500 == 0) {
                echo "Memproses data ke $i<br/>";
            }
            if (!isset($relation[trim($entry[0])])) {
                continue;
            }
            $employee_id = $relation[trim($entry[0])];
            $dt = $entry[1];
            $clock_time = date("H:i:s", strtotime($dt));
            $clock_date = date("Y-m-d", strtotime($dt));
            $attendance_type_id = false;
            if (isset($employeWorkingHours[$employee_id][$php_n])) {
                if (isBetween($employeWorkingHours[$employee_id][$php_n]["start_in"], $employeWorkingHours[$employee_id][$php_n]["end_in"], $clock_time)) {
                    $attendance_type_id = $attTypes["work_in"];
                } else if (isBetween($employeWorkingHours[$employee_id][$php_n]["start_home"], $employeWorkingHours[$employee_id][$php_n]["end_home"], $clock_time)) {
                    $attendance_type_id = $attTypes["work_out"];
                } else if (isBetween($employeWorkingHours[$employee_id][$php_n]["start_out"], $employeWorkingHours[$employee_id][$php_n]["end_out"], $clock_time)) {
                    $countBreak = $this->Attendance->find("count", [
                        "recursive" => -1,
                        "conditions" => [
                            "Attendance.dt between '$clock_date {$employeWorkingHours[$employee_id][$php_n]["start_out"]}'and '$clock_date {$employeWorkingHours[$employee_id][$php_n]["end_out"]}'",
                            "Attendance.employee_id" => $employee_id,
                        ],
                    ]);
                    if ($countBreak == 0) {
                        $attendance_type_id = $attTypes["break_out"];
                    } else {
                        $attendance_type_id = $attTypes["break_in"];
                    }
                } else if (isBetween($employeWorkingHours[$employee_id][$php_n]["overtime_in"], $employeWorkingHours[$employee_id][$php_n]["overtime_out"], $clock_time)) {
                    $overtime_in = new DateTime("$clock_date {$employeWorkingHours[$employee_id][$php_n]["overtime_in"]}");
                    $overtime_out = new DateTime("$clock_date {$employeWorkingHours[$employee_id][$php_n]["overtime_out"]}");
                    if ($overtime_in > $overtime_out)
                        $overtime_out->modify('+1 day');
                    $testClock = new DateTime("$clock_date $clock_time");
                    if ($overtime_in <= $testClock && $overtime_out <= $testClock) {
                        
                    } else {
                        $overtime_in->modify('-1 day');
                        $overtime_out->modify('-1 day');
                    };
                    $countOT = $this->Attendance->find("count", [
                        "recursive" => -1,
                        "conditions" => [
                            "DATE_FORMAT(Attendance.dt,'%Y-%m-%d')" => $clock_date,
                            "Attendance.employee_id" => $employee_id,
                            "Attendance.attendance_type_id" => [$attTypes["ot_out"], $attTypes["ot_in"]],
                        ],
                    ]);
                    $checkHome = $this->Attendance->find("count", [
                        "recursive" => -1,
                        "conditions" => [
                            "DATE_FORMAT(Attendance.dt,'%Y-%m-%d')" => $clock_date,
                            "Attendance.employee_id" => $employee_id,
                            "Attendance.attendance_type_id" => $attTypes["work_out"],
                        ],
                    ]);
                    if ($checkHome == 0) {
                        if ($countOT == 0) {
                            $attendance_type_id = $attTypes["ot_out"];
                        } else {
                            $attendance_type_id = $attTypes["ot_in"];
                        }
                    } else {
                        if ($countOT == 0) {
                            $attendance_type_id = $attTypes["ot_in"];
                        } else {
                            $attendance_type_id = $attTypes["ot_out"];
                        }
                    }
                }
            } else {
                if ($clock_time < "12:00") {
                    $attendance_type_id = $attTypes["work_in"];
                } else {
                    $attendance_type_id = $attTypes["ot_out"];
                }
            }
            if ($attendance_type_id && !$this->Attendance->hasAny([
                        "employee_id" => $employee_id,
//                        "attendance_type_id" => $attendance_type_id,
                        "dt" => $dt,
                    ])) {
                $this->Attendance->save([
                    "employee_id" => $employee_id,
                    "attendance_type_id" => $attendance_type_id,
                    "dt" => $dt,
                ]);
            }
        }
    }

    function cron_import_data() {
        $this->autoRender = false;
        $attendanceMachineIds = ClassRegistry::init("AttendanceMachine")->find("list", array(
            "fields" => array(
                "AttendanceMachine.id",
            ),
        ));
        $result = [];
        foreach ($attendanceMachineIds as $attendanceMachineId) {
            $result[] = $this->_importData($attendanceMachineId, date("Y-m-d"), date("Y-m-d"));
        }
    }

}
