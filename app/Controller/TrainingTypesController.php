<?php

App::uses('AppController', 'Controller');

class TrainingTypesController extends AppController {

    var $name = "TrainingTypes";
    var $disabledAction = array(
    );

    function beforeFilter() {
        parent::beforeFilter();
        $this->_setPageInfo("admin_index", "");
        $this->_setPageInfo("admin_add", "");
        $this->_setPageInfo("admin_edit", "");
    }

    function admin_index() {
        $this->_activePrint(func_get_args(), "data_jenis_diklat");
        parent::admin_index();
    }

    function view_data_training($id = null) {
        $this->autoRender = false;
        if ($this->TrainingType->exists($id)) {
            if ($this->request->is("GET")) {
                $data = $this->TrainingType->find("first", ["conditions" => ["TrainingType.id" => $id]]);
                return json_encode($data);
            } else {
                return json_encode($this->_generateStatusCode(400));
            }
        } else {
            throw new NotFoundException(__("Data Not Found"));
        }
    }

}
