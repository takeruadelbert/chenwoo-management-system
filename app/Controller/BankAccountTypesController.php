<?php

App::uses('AppController', 'Controller');

class BankAccountTypesController extends AppController {

    var $name = "BankAccountTypes";
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
        $this->_activePrint(func_get_args(), "data_jenis_bank");
        parent::admin_index();
    }

    function view_bank_account_type($id = null) {
        if ($this->BankAccountType->exists($id)) {
            $this->autoRender = false;
            if ($this->request->is("GET")) {
                $data = $this->BankAccountType->find("first", ["conditions" => ["BankAccountType.id" => $id]]);
                return json_encode($data);
            } else {
                return json_encode($this->_generateStatusCode(400));
            }
        } else {
            throw new NotFoundException(__("Data Not Found"));
        }
    }

}
