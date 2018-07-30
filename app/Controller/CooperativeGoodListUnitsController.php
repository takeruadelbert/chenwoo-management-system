<?php

App::uses('AppController', 'Controller');

class CooperativeGoodListUnitsController extends AppController {

    var $name = "CooperativeGoodListUnits";
    var $disabledAction = array(
    );

    function beforeFilter() {
        parent::beforeFilter();
        $this->_setPageInfo("admin_index", "");
        $this->_setPageInfo("admin_add", "");
        $this->_setPageInfo("admin_edit", "");
    }

    function admin_index() {
        $this->_activePrint(func_get_args(), "data_satuan_barang_koperasi");
        parent::admin_index();
    }

    function view_data_good_list_unit_type($id = null) {
        $this->autoRender = false;
        if ($this->CooperativeGoodListUnit->exists($id)) {
            if ($this->request->is("GET")) {
                $data = $this->CooperativeGoodListUnit->find("first", ["conditions" => ["CooperativeGoodListUnit.id" => $id]]);
                return json_encode($data);
            } else {
                return json_encode($this->_generateStatusCode(400));
            }
        } else {
            throw new NotFoundException(__("Data Not Found"));
        }
    }

}
