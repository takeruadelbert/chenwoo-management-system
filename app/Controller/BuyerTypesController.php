<?php

App::uses('AppController', 'Controller');

class BuyerTypesController extends AppController {

    var $name = "BuyerTypes";
    var $disabledAction = array(
    );

    function beforeFilter() {
        parent::beforeFilter();
        $this->_setPageInfo("admin_index", "");
        $this->_setPageInfo("admin_add", "");
        $this->_setPageInfo("admin_edit", "");
    }

    function admin_index() {
        $this->_activePrint(func_get_args(), "data_tipe_buyer");
        parent::admin_index();
    }

    function view_data_buyer_type($id = null) {
        $this->autoRender = false;
        if ($this->BuyerType->exists($id)) {
            if ($this->request->is("GET")) {
                $data = $this->BuyerType->find("first", ["conditions" => ["BuyerType.id" => $id]]);
                return json_encode($data);
            } else {
                return json_encode($this->_generateStatusCode(400));
            }
        } else {
            throw new NotFoundException(__("Data Not Found"));
        }
    }

}
