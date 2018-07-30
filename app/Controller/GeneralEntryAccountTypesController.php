<?php

App::uses('AppController', 'Controller');

class GeneralEntryAccountTypesController extends AppController {

    var $name = "GeneralEntryAccountTypes";
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
        $this->_activePrint(func_get_args(), "data_tipe_akun_buku_besar");
        parent::admin_index();
    }

    function view_general_entry_account_type($id = null) {
        if ($this->GeneralEntryAccountType->exists($id)) {
            $this->autoRender = false;
            if ($this->request->is("GET")) {
                $data = $this->GeneralEntryAccountType->find("first", ["conditions" => ["GeneralEntryAccountType.id" => $id]]);
                return json_encode($data);
            } else {
                return json_encode($this->_generateStatusCode(400));
            }
        } else {
            throw new NotFoundException(__("Data Not Found"));
        }
    }

}
