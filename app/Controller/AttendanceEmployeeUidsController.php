<?php

App::uses('AppController', 'Controller');

class AttendanceEmployeeUidsController extends AppController {

    var $name = "AttendanceEmployeeUids";
    var $disabledAction = array(
    );

    function beforeFilter() {
        parent::beforeFilter();
        $this->_setPageInfo("admin_index", "");
        $this->_setPageInfo("admin_add", "");
        $this->_setPageInfo("admin_edit", "");
    }

    function admin_index() {
        $this->_activePrint(func_get_args(), "data_uid_pegawai");
        $this->contain = [
            "AttendanceMachine",
            "Employee" => [
                "Account" => [
                    "Biodata",
                ],
            ],
        ];
        parent::admin_index();
    }

    function admin_edit($id = null) {
        if ($this->request->is("post") || $this->request->is("put")) {
            $this->{ Inflector::classify($this->name) }->set($this->data);
            if ($this->{ Inflector::classify($this->name) }->validates()) {
                if (!is_null($id)) {
                    $this->{ Inflector::classify($this->name) }->id = $id;
                    $this->{ Inflector::classify($this->name) }->save();
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

    function beforeRender() {
        $this->_options();
        parent::beforeRender();
    }

    function _options() {
        $this->set("attendanceMachines", $this->AttendanceEmployeeUid->AttendanceMachine->find("list", array(
                    "fields" => array(
                        "AttendanceMachine.id",
                        "AttendanceMachine.label",
                    )
        )));
        $this->set("employees", $this->AttendanceEmployeeUid->Employee->getListWithFullname());
        $this->set("employeeTypes", $this->AttendanceEmployeeUid->Employee->EmployeeType->find("list", array("fields" => array("EmployeeType.id", "EmployeeType.name"))));
        $this->set("branchOffices", $this->AttendanceEmployeeUid->Employee->BranchOffice->find("list", array("fields" => array("BranchOffice.id", "BranchOffice.name"))));
    }

    function view_data_uid_pegawai($id = null) {
        $this->autoRender = false;
        if ($this->AttendanceEmployeeUid->exists($id)) {
            if ($this->request->is("GET")) {
                $data = $this->AttendanceEmployeeUid->find("first", ["conditions" => ["AttendanceEmployeeUid.id" => $id], "recursive" => 4]);
                return json_encode($data);
            } else {
                return json_encode($this->_generateStatusCode(400));
            }
        } else {
            throw new NotFoundException(__("Data Not Found"));
        }
    }

    function admin_simple_view() {
        $this->_activePrint(func_get_args(), "data_uid_pegawai_simple_view");
        if ($this->request->is("post") || $this->request->is("put")) {
            $this->{ Inflector::classify($this->name) }->saveMany($this->data["AttendanceEmployeeUid"]);
            $this->Session->setFlash(__("Data berhasil disimpan"), 'default', array(), 'success');
        }
        $dataEmployee = $this->AttendanceEmployeeUid->Employee->find("all", array(
            'contain' => [
                "AttendanceEmployeeUid",
                "Account" => [
                    "Biodata",
                ],
            ],
            "conditions" => [
                "NOT" => [
                    "Account.id" => $this->AttendanceEmployeeUid->Employee->excludedEmployee(),
                ],
            ],
        ));
        $dataAttendanceMachine = $this->AttendanceEmployeeUid->AttendanceMachine->find("all", [
            "recursive" => -1
        ]);
        $this->set(compact("dataEmployee", "dataAttendanceMachine"));
    }

}
