<?php

App::uses('AppController', 'Controller');

class RejectedGradeTypesController extends AppController {

    var $name = "RejectedGradeTypes";
    var $disabledAction = array(
    );

    function beforeFilter() {
        parent::beforeFilter();
        $this->_setPageInfo("admin_index", "");
        $this->_setPageInfo("admin_add", "");
        $this->_setPageInfo("admin_edit", "");
    }

    function admin_index() {
        $this->_activePrint(func_get_args(), "data_alasan_turun_grade");
        parent::admin_index();
    }

    function view_data_rejected_grade_type($id = null) {
        $this->autoRender = false;
        if ($this->RejectedGradeType->exists($id)) {
            if ($this->request->is("GET")) {
                $data = $this->RejectedGradeType->find("first", ["conditions" => ["RejectedGradeType.id" => $id]]);
                return json_encode($data);
            } else {
                return json_encode($this->_generateStatusCode(400));
            }
        } else {
            throw new NotFoundException(__("Data Not Found"));
        }
    }

}
