<?php

App::uses('AppController', 'Controller');

class BankAccountsController extends AppController {

    var $name = "BankAccounts";
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
        $this->_activePrint(func_get_args(), "data_nomor_rekening_bank");
        $this->contain = [
            "BankAccountType",
        ];
        parent::admin_index();
    }

    function view_bank_account($id = null) {
        if ($this->BankAccount->exists($id)) {
            $this->autoRender = false;
            if ($this->request->is("GET")) {
                $data = $this->BankAccount->find("first", ["conditions" => ["BankAccount.id" => $id]]);
                return json_encode($data);
            } else {
                return json_encode($this->_generateStatusCode(400));
            }
        } else {
            throw new NotFoundException(__("Data Not Found"));
        }
    }

    function _options() {
        $this->set("bankAccountTypes", $this->BankAccount->BankAccountType->find("list", ["fields" => ["BankAccountType.id", "BankAccountType.name"]]));
    }

    function admin_list() {
        $this->autoRender = false;
        $conds = [];
        if (isset($this->request->query['q'])) {
            $q = $this->request->query['q'];
            $conds[] = array(
                "or" => array(
                    "BankAccount.code like" => "%$q%",
            ));
        }
        $suggestions = ClassRegistry::init("BankAccount")->find("all", array(
            "conditions" => [
                $conds,
                "BankAccount.is_used" => 0,
            ],
            "contain" => array(
                "BankAccountType"
            ),
            "limit"=>10,
        ));
        $result = [];
        foreach ($suggestions as $item) {
            if (!empty($item)) {
                $result[] = [
                    "id" => @$item['BankAccount']['id'],
                    "code" => @$item['BankAccount']['code'],
                    "on_behalf" => @$item['BankAccount']['on_behalf'],
                    "bank_account_type" => @$item['BankAccountType']['name']
                ];
            }
        }
        echo json_encode($result);
    }

    function admin_print_laporan_data_rekening() {
        $this->_activePrint(["print"], "print_laporan_kode_rekening", "kwitansi");
        $rows = $this->{ Inflector::classify($this->name) }->find('all', array(
            'conditions' => array(
            ),
            'contain' => [
                "BankAccountType",
            ],
        ));
        $this->data = $rows;

        $data = array(
            'title' => 'Laporan Kode Rekening',
            'rows' => $rows,
        );
        $this->set(compact('data'));
    }

}
