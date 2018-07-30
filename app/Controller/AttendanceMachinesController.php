<?php

App::uses('AppController', 'Controller');

class AttendanceMachinesController extends AppController {

    var $name = "AttendanceMachines";
    var $disabledAction = array(
    );

    function beforeFilter() {
        parent::beforeFilter();
        $this->_setPageInfo("admin_index", "");
        $this->_setPageInfo("admin_add", "");
        $this->_setPageInfo("admin_edit", "");
    }

    function admin_index() {
        $this->_activePrint(func_get_args(), "data_mesin_absensi");
        parent::admin_index();
    }

    function view_data_machine($id = null) {
        $this->autoRender = false;
        if ($this->AttendanceMachine->exists($id)) {
            if ($this->request->is("GET")) {
                $data = $this->AttendanceMachine->find("first", ["conditions" => ["AttendanceMachine.id" => $id]]);
                return json_encode($data);
            } else {
                return json_encode($this->_generateStatusCode(400));
            }
        } else {
            throw new NotFoundException(__("Data Not Found"));
        }
    }

}
