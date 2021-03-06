<?php

App::uses('AppController', 'Controller');

class MaterialAdditionalUnitsController extends AppController {

    var $name = "MaterialAdditionalUnits";
    var $disabledAction = array(
    );

    function beforeFilter() {
        parent::beforeFilter();
        $this->_setPageInfo("admin_index", "");
        $this->_setPageInfo("admin_add", "");
        $this->_setPageInfo("admin_edit", "");
    }

    function admin_index() {
        $this->_activePrint(func_get_args(), "data_satuan_material_pembantu");
        parent::admin_index();
    }

    function view_data_material_additional_unit($id = null) {
        $this->autoRender = false;
        if ($this->MaterialAdditionalUnit->exists($id)) {
            if ($this->request->is("GET")) {
                $data = $this->MaterialAdditionalUnit->find("first", ["conditions" => ["MaterialAdditionalUnit.id" => $id]]);
                return json_encode($data);
            } else {
                return json_encode($this->_generateStatusCode(400));
            }
        } else {
            throw new NotFoundException(__("Data Not Found"));
        }
    }

}
