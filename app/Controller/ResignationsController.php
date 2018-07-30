<?php

App::uses('AppController', 'Controller');

class ResignationsController extends AppController {

    var $name = "Resignations";
    var $disabledAction = array(
    );

    function admin_index() {
        $this->_activePrint(func_get_args(), "data_pegawai_keluar");
        $this->_setPeriodeLaporanDate("awal_Resignation_resignation_date", "akhir_Resignation_resignation_date");
        $this->contain = [
            "ResignationType",
            "Employee" => [
                "Account" => [
                    "Biodata" => [
                        "Religion"
                    ]
                ],
                "Office",
                "Department"
            ],
            "VerifyStatus"
        ];
        parent::admin_index();
    }

    function admin_index_validate() {
        $this->_activePrint(func_get_args(), "data_pegawai_keluar_validasi");
        $this->_setPeriodeLaporanDate("awal_Resignation_resignation_date", "akhir_Resignation_resignation_date");
        $this->contain = [
            "ResignationType",
            "Employee" => [
                "Account" => [
                    "Biodata" => [
                        "Religion"
                    ]
                ],
                "Office",
                "Department"
            ],
            "VerifyStatus"
        ];
        $this->conds = [
            "Resignation.verify_status_id" => 1,
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

    function admin_edit($id = null) {
        if ($this->request->is("post") || $this->request->is("put")) {
            $this->{ Inflector::classify($this->name) }->set($this->data);
            if ($this->{ Inflector::classify($this->name) }->validates()) {
                if (!is_null($id)) {
                    $this->{ Inflector::classify($this->name) }->id = $id;
                    $this->Resignation->data['Resignation']['id'] = $id;
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

    function view_data_resignation($id = null) {
        $this->autoRender = false;
        if ($this->Resignation->exists($id)) {
            if ($this->request->is("GET")) {
                $data = $this->Resignation->find("first", ["conditions" => ["Resignation.id" => $id], "recursive" => 4]);
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
                $this->Resignation->data["Resignation"]["verify_status_id"] = 1;
                $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
                $this->Session->setFlash(__("Data berhasil disimpan"), 'default', array(), 'success');
                $this->redirect(array('action' => 'admin_index'));
            } else {
                $this->validationErrors = $this->{ Inflector::classify($this->name) }->validationErrors;
                $this->Session->setFlash(__("Harap mengecek kembali kesalahan dibawah."), 'default', array(), 'danger');
            }
        }
    }

    function _options() {
        $this->set("resignationTypes", $this->Resignation->ResignationType->find("list", array("fields" => array("ResignationType.id", "ResignationType.name"))));
        $this->set("departments", ClassRegistry::init("Department")->find("list", array("fields" => array("Department.id", "Department.name"))));
        $this->set("branchOffices", $this->Resignation->Employee->BranchOffice->find("list", array("fields" => array("BranchOffice.id", "BranchOffice.name"))));
        $this->set("verifyStatuses", $this->Resignation->VerifyStatus->find("list", array("fields" => array("VerifyStatus.id", "VerifyStatus.name"))));
        $this->set("employeeTypes", $this->Resignation->Employee->EmployeeType->find("list", array("fields" => array("EmployeeType.id", "EmployeeType.name"))));
        $this->set("permitCategories", ClassRegistry::init("PermitCategory")->find("list", ["fields" => ["PermitCategory.name", "PermitCategory.label"]]));
        $this->set("employees", ClassRegistry::init("Employee")->getListWithFullnameExcludedEmployee());
    }

    function admin_change_status_verify() {
        $this->autoRender = false;
        if ($this->request->is("PUT")) {
            $this->Resignation->data['Resignation']['id'] = $this->request->data['id'];
            $this->Resignation->data['Resignation']['verify_status_id'] = $this->request->data['status'];
            if ($this->request->data['status'] == '3') {
                $idResignation = ClassRegistry::init("Resignation")->find("first", [
                    "conditions" => [
                        "Resignation.id" => $this->request->data['id'],
                    ],
                ]);
                $employee = $this->Resignation->Employee->find("first", [
                    "conditions" => [
                        "Employee.id" => $idResignation['Resignation']['employee_id'],
                    ],
                ]);
                $this->Resignation->data['Employee']['id'] = $idResignation['Resignation']['employee_id'];
                $this->Resignation->data['Employee']['employee_work_status_id'] = 4;

                $this->Resignation->data['Resignation']['verified_by_id'] = $this->_getEmployeeId();
                $this->Resignation->data['Resignation']['verified_datetime'] = date("Y-m-d H:i:s");
            } else if ($this->request->data['status'] == '2') {
                $this->Resignation->data['Resignation']['verified_by_id'] = $this->_getEmployeeId();
                $this->Resignation->data['Resignation']['verified_datetime'] = date("Y-m-d H:i:s");
            } else if ($this->request->data['status'] == '1') {
                $this->Resignation->data['Resignation']['verified_by_id'] = null;
                $this->Resignation->data['Resignation']['verified_datetime'] = null;
            }
            $this->Resignation->saveAll();
            $data = $this->Resignation->find("first", array("conditions" => array("Resignation.id" => $this->request->data['id']), "recursive" => 3));
            echo json_encode($this->_generateStatusCode(207, null, array("status_label" => $data['VerifyStatus']['name'])));
        } else {
            echo json_encode($this->_generateStatusCode(400));
        }
    }

    function admin_laporan_kehadiran_pegawai_keluar() {
        $this->_activePrint(func_get_args(), "laporan_kehadiran_pegawai_keluar");
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
        $conds = [];
        if(isset($this->request->query['employee_id']) && !empty($this->request->query['employee_id'])) {
            $conds[] = [
                "Employee.id" => $this->request->query['employee_id']
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
        $result = ClassRegistry::init("Attendance")->buildReport($start_date, $end_date, $employee, true);
        $this->set(compact('result', 'start_date', 'end_date'));
    }

}
