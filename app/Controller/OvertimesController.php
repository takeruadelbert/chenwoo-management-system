<?php

App::uses('AppController', 'Controller');

class OvertimesController extends AppController {

    var $name = "Overtimes";
    var $disabledAction = array(
    );

    function admin_index() {
        $this->_activePrint(func_get_args(), "data_lembur_pegawai");
        $this->_setPeriodeLaporanDate("awal_Overtime_overtime_date", "akhir_Overtime_overtime_date");
        $this->contain = [
            "Employee" => [
                "Account" => [
                    "Biodata"
                ],
                "Office",
                "Department"
            ],
            "ValidateStatus"
        ];
        parent::admin_index();
    }

    function beforeFilter() {
        parent::beforeFilter();
        $this->_setPageInfo("admin_index", "");
        $this->_setPageInfo("admin_add", "");
        $this->_setPageInfo("admin_view", "");
    }

    function beforeRender() {
        $this->_options();
        parent::beforeRender();
    }

    function kirim_sms() {
        $departments = ClassRegistry::init("Department")->find("list", ["fields" => ["Department.id", "Department.name"]]);
        foreach ($departments as $k => $v) {
            $departments["d_$k"] = $v;
            unset($departments[$k]);
        }
        $tujuan = [
            "p" => "- Perorangan -",
            "s" => "- Semua -",
            "Departemen" => $departments,
        ];
        $pegawai = ClassRegistry::init("Employee")->getListWithFullname();
        $this->data = [];
        $this->set(compact("tujuan", "pegawai"));
    }

    function admin_add() {
        if ($this->request->is("post")) {
            $this->{ Inflector::classify($this->name) }->set($this->data);
            if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                $destinationArray = explode("_", $this->data["Overtime"]["tujuan"]);
                switch ($destinationArray[0]) {
                    case "p":
                        foreach ($this->data["Overtime"]["nomor"] as $employee_id) {
                            $this->{ Inflector::classify($this->name) }->create();
                            $this->{ Inflector::classify($this->name) }->data['Overtime']['overtime_status_id'] = 1;
                            $this->{ Inflector::classify($this->name) }->data['Overtime']['verify_status_id'] = 1;
                            $this->{ Inflector::classify($this->name) }->data['Overtime']['validate_status_id'] = 1;
                            $this->{ Inflector::classify($this->name) }->data['Overtime']['employee_id'] = $employee_id;
                            $this->{ Inflector::classify($this->name) }->data['Overtime']['overtime_date'] = $this->data['Overtime']['overtime_date'];
                            $this->{ Inflector::classify($this->name) }->data['Overtime']['start_time'] = $this->data['Overtime']['start_time'];
                            $this->{ Inflector::classify($this->name) }->data['Overtime']['end_time'] = $this->data['Overtime']['end_time'];
                            $this->{ Inflector::classify($this->name) }->data['Overtime']['note'] = $this->data['Overtime']['note'];
                            $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
                        }
                        break;
                    case "s":
                        $employees = ClassRegistry::init("Employee")->find("all", [
                            "contain" => [
                                "Account" => [
                                    "Biodata",
                                ],
                            ],
                            "conditions" => [
                                "NOT" => [
                                    "Account.id" => ClassRegistry::init("Employee")->excludedEmployee(),
                                ],
                            ],
                        ]);
                        foreach ($employees as $employee) {
                            $this->{ Inflector::classify($this->name) }->create();
                            $this->{ Inflector::classify($this->name) }->data['Overtime']['overtime_status_id'] = 1;
                            $this->{ Inflector::classify($this->name) }->data['Overtime']['verify_status_id'] = 1;
                            $this->{ Inflector::classify($this->name) }->data['Overtime']['validate_status_id'] = 1;
                            $this->{ Inflector::classify($this->name) }->data['Overtime']['employee_id'] = $employee['Employee']['id'];
                            $this->{ Inflector::classify($this->name) }->data['Overtime']['overtime_date'] = $this->data['Overtime']['overtime_date'];
                            $this->{ Inflector::classify($this->name) }->data['Overtime']['start_time'] = $this->data['Overtime']['start_time'];
                            $this->{ Inflector::classify($this->name) }->data['Overtime']['end_time'] = $this->data['Overtime']['end_time'];
                            $this->{ Inflector::classify($this->name) }->data['Overtime']['note'] = $this->data['Overtime']['note'];
                            $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
                        }
                        break;
                    case "d":
                        $departmentId = str_replace("d_", "", $this->data["Overtime"]["tujuan"]);
                        $employees = ClassRegistry::init("Employee")->find("all", [
                            "contain" => [
                                "Account" => [
                                    "Biodata",
                                ],
                            ],
                            "conditions" => [
                                "Employee.department_id" => $departmentId,
                            ],
                        ]);
                        foreach ($employees as $employee) {
                            $this->{ Inflector::classify($this->name) }->create();
                            $this->{ Inflector::classify($this->name) }->data['Overtime']['overtime_status_id'] = 1;
                            $this->{ Inflector::classify($this->name) }->data['Overtime']['verify_status_id'] = 1;
                            $this->{ Inflector::classify($this->name) }->data['Overtime']['validate_status_id'] = 1;
                            $this->{ Inflector::classify($this->name) }->data['Overtime']['employee_id'] = $employee['Employee']['id'];
                            $this->{ Inflector::classify($this->name) }->data['Overtime']['overtime_date'] = $this->data['Overtime']['overtime_date'];
                            $this->{ Inflector::classify($this->name) }->data['Overtime']['start_time'] = $this->data['Overtime']['start_time'];
                            $this->{ Inflector::classify($this->name) }->data['Overtime']['end_time'] = $this->data['Overtime']['end_time'];
                            $this->{ Inflector::classify($this->name) }->data['Overtime']['note'] = $this->data['Overtime']['note'];
                            $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
                        }
                        break;
                }
                $this->Session->setFlash(__("Data berhasil disimpan"), 'default', array(), 'success');
                $this->redirect(array('action' => 'admin_index'));
            } else {
                $this->validationErrors = $this->{ Inflector::classify($this->name) }->validationErrors;
                $this->Session->setFlash(__("Harap mengecek kembali kesalahan dibawah."), 'default', array(), 'danger');
            }
        } else {
            $this->kirim_sms();
        }
    }

    function admin_view($id = null) {
        if (!$this->Overtime->exists($id)) {
            throw new NotFoundException(__('Invalid data'));
        } else {
            $this->{ Inflector::classify($this->name) }->id = $id;
            $this->Overtime->data['Overtime']['id'] = $id;
            $rows = $this->{ Inflector::classify($this->name) }->find("first", array('conditions' => array(Inflector::classify($this->name) . ".id" => $id),
                "contain" => [
                    "Employee" => [
                        "Account" => [
                            "Biodata",
                        ],
                    ],
            ]));
            $this->data = $rows;
        }
    }

    function _options() {
        $this->set("validateStatuses", $this->Overtime->ValidateStatus->find("list", ["fields" > ["ValidateStatus.id", "ValidateStatus.name"]]));
        $this->set("departments", $this->Overtime->Employee->Department->find("list", array("fields" => array("Department.id", "Department.name"))));
        $this->set("branchOffices", $this->Overtime->Employee->BranchOffice->find("list", array("fields" => array("BranchOffice.id", "BranchOffice.name"))));
        $this->set("employeeTypes", $this->Overtime->Employee->EmployeeType->find("list", array("fields" => array("EmployeeType.id", "EmployeeType.name"))));
    }

    function admin_change_status_validate() {
        $this->autoRender = false;
        if ($this->request->is("PUT")) {
            $this->Overtime->data['Overtime']['id'] = $this->request->data['id'];
            $this->Overtime->data['Overtime']['validate_status_id'] = $this->request->data['status'];
            if ($this->request->data['status'] == '2') {
                $this->Overtime->data['Overtime']['validate_by_id'] = $this->_getEmployeeId();
                $this->Overtime->data['Overtime']['validate_datetime'] = date("Y-m-d H:i:s");
            } else if ($this->request->data['status'] == '3') {
                $this->Overtime->data['Overtime']['validate_by_id'] = $this->_getEmployeeId();
                $this->Overtime->data['Overtime']['validate_datetime'] = date("Y-m-d H:i:s");
            } else {
                $this->Overtime->data['Overtime']['validate_by_id'] = null;
                $this->Overtime->data['Overtime']['validate_datetime'] = null;
            }
            $this->Overtime->saveAll();
            $data = $this->Overtime->find("first", array("conditions" => array("Overtime.id" => $this->request->data['id']), "recursive" => -1,"contain"=>["ValidateStatus"]));
            echo json_encode($this->_generateStatusCode(207, null, array("status_label" => $data['ValidateStatus']['name'])));
        } else {
            echo json_encode($this->_generateStatusCode(400));
        }
    }

}
