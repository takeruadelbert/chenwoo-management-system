<?php

App::uses('AppController', 'Controller');

class CooperativeBankAccountsController extends AppController {

    var $name = "CooperativeBankAccounts";
    var $disabledAction = array(
    );
    var $contain = [
        "BankAccountType"
    ];

    function beforeFilter() {
        parent::beforeFilter();
        $this->_setPageInfo("admin_index", "");
        $this->_setPageInfo("admin_add", "");
        $this->_setPageInfo("admin_edit", "");
        $this->_setPageInfo("admin_view", "");
    }

    function beforeRender() {
        $this->_options();
        parent::beforeRender();
    }

    function admin_index() {
        $this->_activePrint(func_get_args(), "data_kode_rekening_koperasi");
        parent::admin_index();
    }

    function view_bank_account($id = null) {
        if ($this->CooperativeBankAccount->exists($id)) {
            $this->autoRender = false;
            if ($this->request->is("GET")) {
                $data = $this->CooperativeBankAccount->find("first", ["conditions" => ["CooperativeBankAccount.id" => $id]]);
                return json_encode($data);
            } else {
                return json_encode($this->_generateStatusCode(400));
            }
        } else {
            throw new NotFoundException(__("Data Not Found"));
        }
    }

    function _options() {
        $this->set("bankAccountTypes", $this->CooperativeBankAccount->BankAccountType->find("list", ["fields" => ["BankAccountType.id", "BankAccountType.name"]]));
    }

    function admin_list() {
        $this->autoRender = false;
        $conds = [];
        if (isset($this->request->query['q'])) {
            $q = $this->request->query['q'];
            $conds[] = array(
                "or" => array(
                    "CooperativeBankAccount.code like" => "%$q%",
            ));
        }
        $suggestions = ClassRegistry::init("CooperativeBankAccount")->find("all", array(
            "conditions" => $conds,
            "contain" => array(
                "BankAccountType"
            ),
            "limit"=>10,
        ));
        $result = [];
        foreach ($suggestions as $item) {
            if (!empty($item)) {
                $result[] = [
                    "id" => @$item['CooperativeBankAccount']['id'],
                    "code" => @$item['CooperativeBankAccount']['code'],
                    "on_behalf" => @$item['CooperativeBankAccount']['on_behalf'],
                    "bank_account_type" => @$item['BankAccountType']['name']
                ];
            }
        }
        echo json_encode($result);
    }

}
