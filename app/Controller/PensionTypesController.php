<?php

App::uses('AppController', 'Controller');

class PensionTypesController extends AppController {

    var $name = "PensionTypes";
    var $disabledAction = array(
    );

    function beforeFilter() {
        parent::beforeFilter();
        $this->_setPageInfo("admin_index", "");
        $this->_setPageInfo("admin_add", "");
        $this->_setPageInfo("admin_edit", "");
    }

    function admin_index() {
        $this->_activePrint(func_get_args(), "data_jenis_pensiun");
        parent::admin_index();
    }

    function view_data_pension($id = null) {
        $this->autoRender = false;
        if ($this->PensionType->exists($id)) {
            if ($this->request->is("GET")) {
                $data = $this->PensionType->find("first", ["conditions" => ["PensionType.id" => $id]]);
                return json_encode($data);
            } else {
                return json_encode($this->_generateStatusCode(400));
            }
        } else {
            throw new NotFoundException(__("Data Not Found"));
        }
    }

}
