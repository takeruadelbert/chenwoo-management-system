<?php

App::uses('AppController', 'Controller');

class PensionsController extends AppController {

    var $name = "Pensions";
    var $disabledAction = array(
    );

    function admin_index() {
        $this->_activePrint(func_get_args(), "data_pensiun");
        $this->_setPeriodeLaporanDate("awal_Pension_tanggal_sk", "akhir_Pension_tanggal_sk");
        $this->contain = [
            "PensionType",
            "Employee" => [
                "Account" => [
                    "Biodata" => [
                        "Religion"
                    ]
                ],
                "Office",
                "Department",
            ],
            "VerifyStatus",
        ];
        parent::admin_index();
    }

    function admin_index_validate() {
        $this->_activePrint(func_get_args(), "data_pensiun_validasi");
        $this->_setPeriodeLaporanDate("awal_Pension_tanggal_sk", "akhir_Pension_tanggal_sk");
        $this->contain = [
            "PensionType",
            "Employee" => [
                "Account" => [
                    "Biodata" => [
                        "Religion"
                    ]
                ],
                "Office",
                "Department",
            ],
            "VerifyStatus",
        ];
        $this->conds = [
            "Pension.verify_status_id" => 1,
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
                    $this->Pension->data['Pension']['id'] = $id;
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

    function view_data_pension($id = null) {
        $this->autoRender = false;
        if ($this->Pension->exists($id)) {
            if ($this->request->is("GET")) {
                $data = $this->Pension->find("first", ["conditions" => ["Pension.id" => $id], "recursive" => 4]);
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
                $this->Pension->data["Pension"]["verify_status_id"] = 1;
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
        $this->set("pensionTypes", $this->Pension->PensionType->find("list", array("fields" => array("PensionType.id", "PensionType.name"))));
        $this->set("departments", ClassRegistry::init("Department")->find("list", array("fields" => array("Department.id", "Department.name"))));
        $this->set("branchOffices", $this->Pension->Employee->BranchOffice->find("list", array("fields" => array("BranchOffice.id", "BranchOffice.name"))));
        $this->set("verifyStatuses", $this->Pension->VerifyStatus->find("list", array("fields" => array("VerifyStatus.id", "VerifyStatus.name"))));
        $this->set("employeeTypes", $this->Pension->Employee->EmployeeType->find("list", array("fields" => array("EmployeeType.id", "EmployeeType.name"))));
    
    }

    function admin_change_status_verify() {
        $this->autoRender = false;
        if ($this->request->is("PUT")) {
            $this->Pension->data['Pension']['id'] = $this->request->data['id'];
            $this->Pension->data['Pension']['verify_status_id'] = $this->request->data['status'];
            if ($this->request->data['status'] == '3') {
                $idPension = ClassRegistry::init("Pension")->find("first", [
                    "conditions" => [
                        "Pension.id" => $this->request->data['id'],
                    ],
                ]);
                $employee = $this->Pension->Employee->find("first", [
                    "conditions" => [
                        "Employee.id" => $idPension['Pension']['employee_id'],
                    ],
                ]);
                $this->Pension->data['Employee']['id'] = $idPension['Pension']['employee_id'];
                $this->Pension->data['Employee']['employee_work_status_id'] = 3;

                $this->Pension->data['Pension']['verified_by_id'] = $this->_getEmployeeId();
                $this->Pension->data['Pension']['verified_datetime'] = date("Y-m-d H:i:s");
            } else if ($this->request->data['status'] == '2') {
                $this->Pension->data['Pension']['verified_by_id'] = $this->_getEmployeeId();
                $this->Pension->data['Pension']['verified_datetime'] = date("Y-m-d H:i:s");
            } else if ($this->request->data['status'] == '1') {
                $this->Pension->data['Pension']['verified_by_id'] = null;
                $this->Pension->data['Pension']['verified_datetime'] = null;
            }
            $this->Pension->saveAll();
            $data = $this->Pension->find("first", array("conditions" => array("Pension.id" => $this->request->data['id']), "recursive" => 3));
            echo json_encode($this->_generateStatusCode(207, null, array("status_label" => $data['VerifyStatus']['name'])));
        } else {
            echo json_encode($this->_generateStatusCode(400));
        }
    }

}
