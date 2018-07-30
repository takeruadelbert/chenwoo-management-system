<?php

App::uses('AppController', 'Controller');

class EducationsController extends AppController {

    var $name = "Educations";
    var $disabledAction = array(
    );

    function beforeFilter() {
        parent::beforeFilter();
        $this->_setPageInfo("admin_index", "");
        $this->_setPageInfo("admin_add", "");
        $this->_setPageInfo("admin_edit", "");
    }

    function admin_index() {
        $this->_activePrint(func_get_args(), "data_tingkat_pendidikan");
        $this->order = "Education.ordering";
        parent::admin_index();
    }

    function view_data_education($id = null) {
        $this->autoRender = false;
        if ($this->Education->exists($id)) {
            if ($this->request->is("GET")) {
                $data = $this->Education->find("first", ["conditions" => ["Education.id" => $id]]);
                return json_encode($data);
            } else {
                return json_encode($this->_generateStatusCode(400));
            }
        } else {
            throw new NotFoundException(__("Data Not Found"));
        }
    }

}
