<?php

App::uses('AppController', 'Controller');

class CooperativeSupplierTypesController extends AppController {

    var $name = "CooperativeSupplierTypes";
    var $disabledAction = array(
    );

    function beforeFilter() {
        parent::beforeFilter();
        $this->_setPageInfo("admin_index", "");
        $this->_setPageInfo("admin_add", "");
        $this->_setPageInfo("admin_edit", "");
    }

    function admin_index() {
        $this->_activePrint(func_get_args(), "data_tipe_supplier_koperasi");
        parent::admin_index();
    }

    function view_supplier_type($id = null) {
        if ($this->CooperativeSupplierType->exists($id)) {
            $this->autoRender = false;
            if ($this->request->is("GET")) {
                $data = $this->CooperativeSupplierType->find("first", ["conditions" => ["CooperativeSupplierType.id" => $id]]);
                return json_encode($data);
            } else {
                return json_encode($this->_generateStatusCode(400));
            }
        } else {
            throw new NotFoundException(__("Data Not Found"));
        }
    }

}
