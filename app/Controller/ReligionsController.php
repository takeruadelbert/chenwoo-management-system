<?php

App::uses('AppController', 'Controller');

class ReligionsController extends AppController {

    var $name = "Religions";
    var $disabledAction = array(
    );

    function beforeFilter() {
        parent::beforeFilter();
        $this->_setPageInfo("admin_index", "");
        $this->_setPageInfo("admin_add", "");
        $this->_setPageInfo("admin_edit", "");
    }

    function admin_index() {
        $this->_activePrint(func_get_args(), "data_agama");
        parent::admin_index();
    }

    function view_data_religion($id = null) {
        $this->autoRender = false;
        if ($this->Religion->exists($id)) {
            if ($this->request->is("GET")) {
                $data = $this->Religion->find("first", ["conditions" => ["Religion.id" => $id]]);
                return json_encode($data);
            } else {
                return json_encode($this->_generateStatusCode(400));
            }
        } else {
            throw new NotFoundException(__("Data Not Found"));
        }
    }

}
