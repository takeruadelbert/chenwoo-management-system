<?php

App::uses('AppController', 'Controller');

class MaterialSizesController extends AppController {

    var $name = "MaterialSizes";
    var $disabledAction = array(
    );

    function beforeFilter() {
        parent::beforeFilter();
        $this->_setPageInfo("admin_index", "");
        $this->_setPageInfo("admin_add", "");
        $this->_setPageInfo("admin_edit", "");
    }

    function admin_index() {
        $this->_activePrint(func_get_args(), "data_material_size");
        parent::admin_index();
    }

    function view_data_material_size($id = null) {
        $this->autoRender = false;
        if ($this->MaterialSize->exists($id)) {
            if ($this->request->is("GET")) {
                $data = $this->MaterialSize->find("first", ["conditions" => ["MaterialSize.id" => $id]]);
                return json_encode($data);
            } else {
                return json_encode($this->_generateStatusCode(400));
            }
        } else {
            throw new NotFoundException(__("Data Not Found"));
        }
    }

    function admin_get_material_size() {
        $this->autoRender = false;
        $data = $this->{ Inflector::classify($this->name) }->find('all', array("fields" => array("MaterialSize.id", "MaterialSize.name")), array("contain" => array()));
        echo json_encode($data);
    }

}
