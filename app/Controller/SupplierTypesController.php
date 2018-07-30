<?php

App::uses('AppController', 'Controller');

class SupplierTypesController extends AppController {

    var $name = "SupplierTypes";
    var $disabledAction = array(
    );

    function beforeFilter() {
        parent::beforeFilter();
        $this->_setPageInfo("admin_index", "");
        $this->_setPageInfo("admin_add", "");
        $this->_setPageInfo("admin_edit", "");
    }

    function admin_index() {
        $this->_activePrint(func_get_args(), "data_tipe_supplier");
        parent::admin_index();
    }

    function view_data_supplier_type($id = null) {
        $this->autoRender = false;
        if ($this->SupplierType->exists($id)) {
            if ($this->request->is("GET")) {
                $data = $this->SupplierType->find("first", ["conditions" => ["SupplierType.id" => $id]]);
                return json_encode($data);
            } else {
                return json_encode($this->_generateStatusCode(400));
            }
        } else {
            throw new NotFoundException(__("Data Not Found"));
        }
    }

}
