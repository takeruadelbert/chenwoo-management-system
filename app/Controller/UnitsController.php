<?php

App::uses('AppController', 'Controller');

class UnitsController extends AppController {

    var $name = "Units";
    var $disabledAction = array(
    );

    function beforeFilter() {
        parent::beforeFilter();
        $this->_setPageInfo("admin_index", "");
        $this->_setPageInfo("admin_add", "");
        $this->_setPageInfo("admin_edit", "");
    }

    function admin_index() {
        $this->_activePrint(func_get_args(), "data_satuan");
        parent::admin_index();
    }

    function view_data_unit($id = null) {
        $this->autoRender = false;
        if ($this->Unit->exists($id)) {
            if ($this->request->is("GET")) {
                $data = $this->Unit->find("first", ["conditions" => ["Unit.id" => $id]]);
                return json_encode($data);
            } else {
                return json_encode($this->_generateStatusCode(400));
            }
        } else {
            throw new NotFoundException(__("Data Not Found"));
        }
    }

    function admin_get_unit() {
        $this->autoRender = false;
        $data = $this->{ Inflector::classify($this->name) }->find('all', array("fields" => array("Unit.id", "Unit.name")), array("contain" => array()));
        echo json_encode($data);
    }

}
