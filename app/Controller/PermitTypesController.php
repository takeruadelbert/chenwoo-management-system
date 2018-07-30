<?php

App::uses('AppController', 'Controller');

class PermitTypesController extends AppController {

    var $name = "PermitTypes";
    var $disabledAction = array(
    );

    function beforeFilter() {
        parent::beforeFilter();
        $this->_setPageInfo("admin_index", "");
        $this->_setPageInfo("admin_add", "");
        $this->_setPageInfo("admin_edit", "");
    }

    function admin_index() {
        $this->contain = [
            "PermitCategory",
        ];
        $this->_activePrint(func_get_args(), "data_jenis_izin");
        parent::admin_index();
    }

    function view_data_permit($id = null) {
        $this->autoRender = false;
        if ($this->PermitType->exists($id)) {
            if ($this->request->is("GET")) {
                $data = $this->PermitType->find("first", ["conditions" => ["PermitType.id" => $id]]);
                return json_encode($data);
            } else {
                return json_encode($this->_generateStatusCode(400));
            }
        } else {
            throw new NotFoundException(__("Data Not Found"));
        }
    }

    function _options() {
        $this->set("permitCategories", $this->PermitType->PermitCategory->find("list", ["fields" => ["PermitCategory.id", "PermitCategory.label"]]));
    }
    
    function beforeRender() {
        $this->_options();
        parent::beforeRender();
    }

}
