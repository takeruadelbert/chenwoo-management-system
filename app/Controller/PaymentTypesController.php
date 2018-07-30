<?php

App::uses('AppController', 'Controller');

class PaymentTypesController extends AppController {

    var $name = "PaymentTypes";
    var $disabledAction = array(
    );

    function beforeFilter() {
        parent::beforeFilter();
        $this->_setPageInfo("admin_index", "");
        $this->_setPageInfo("admin_add", "");
        $this->_setPageInfo("admin_edit", "");
        $this->_setPageInfo("admin_view", "");
    }

    function admin_index() {
        $this->_activePrint(func_get_args(), "data_tipe_pembayaran");
        parent::admin_index();
    }

    function view_payment_type($id = null) {
        $this->autoRender = false;
        if ($this->PaymentType->exists($id)) {
            if ($this->request->is("GET")) {
                $data = $this->PaymentType->find("first", ["conditions" => ["PaymentType.id" => $id]]);
                return json_encode($data);
            } else {
                return json_encode($this->_generateStatusCode(400));
            }
        } else {
            throw new NotFoundException(__("Data Not Found"));
        }
    }

}
