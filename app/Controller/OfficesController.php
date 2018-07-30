<?php

App::uses('AppController', 'Controller');

class OfficesController extends AppController {

    var $name = "Offices";
    var $disabledAction = array(
    );
    var $contain = [
        "Department"
    ];

    function beforeFilter() {
        parent::beforeFilter();
        $this->_setPageInfo("admin_index", "");
        $this->_setPageInfo("admin_add", "");
        $this->_setPageInfo("admin_edit", "");
    }

    function admin_index() {
        $this->_activePrint(func_get_args(), "data_jabatan");
        $this->contain = [
            "Supervisor",
            "Department"
        ];
        parent::admin_index();
    }

    function beforeRender() {
        $this->_options();
        parent::beforeRender();
    }

    function view_data_office($id = null) {
        $this->autoRender = false;
        if ($this->Office->exists($id)) {
            if ($this->request->is("GET")) {
                $data = $this->Office->find("first", ["conditions" => ["Office.id" => $id]]);
                return json_encode($data);
            } else {
                return json_encode($this->_generateStatusCode(400));
            }
        } else {
            throw new NotFoundException(__("Data Not Found"));
        }
    }

    function _options() {
        $this->set("supervisors", $this->Office->find("list", ["fields" => ["Office.id", "Office.name"]]));
        $this->set("departments", $this->Office->Department->find("list", ["fields" => ["Department.id", "Department.name"]]));
    }

}
