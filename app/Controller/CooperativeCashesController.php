<?php

App::uses('AppController', 'Controller');

class CooperativeCashesController extends AppController {

    var $name = "CooperativeCashes";
    var $disabledAction = array(
    );
    var $contain = [
        "CashType",
        "CooperativeBankAccount" => [
            "BankAccountType"
        ]
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
        $this->_activePrint(func_get_args(), "data_saldo_kas_koperasi");
        parent::admin_index();
    }

    function admin_index_laporan() {
        $this->_activePrint(func_get_args(), "laporan_saldo_kas_koperasi");
        parent::admin_index();
    }

    function _options() {
        $this->set("cashTypes", $this->CooperativeCash->CashType->find("list", ["fields" => ["CashType.id", "CashType.name"]]));
        $this->set("cooperativeCashes", $this->CooperativeCash->find("list", ["fields" => ["CooperativeCash.id", "CooperativeCash.name"]]));
        $this->set("bankAccountTypes", $this->CooperativeCash->CooperativeBankAccount->BankAccountType->find("list", ["fields" => ["BankAccountType.id", "BankAccountType.name"]]));
        $this->set("cooperativeBankAccountData", $this->CooperativeCash->CooperativeBankAccount->listFullData());
        $this->set("cooperativeBankAccounts", $this->CooperativeCash->CooperativeBankAccount->listFullLabel(false));
    }

    function view_cash($id = null) {
        if ($this->CooperativeCash->exists($id)) {
            $this->autoRender = false;
            if ($this->request->is("GET")) {
                $data = $this->CooperativeCash->find("first", ["conditions" => ["CooperativeCash.id" => $id]]);
                return json_encode($data);
            } else {
                return json_encode($this->_generateStatusCode(400));
            }
        } else {
            throw new NotFoundException(__("Data Not Found"));
        }
    }

    function admin_add() {
        if ($this->request->is("post")) {
            $this->{ Inflector::classify($this->name) }->set($this->data);
            if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                $this->CooperativeCash->_numberSeperatorRemover();
                $this->CooperativeCash->data["CooperativeCash"]["branch_office_id"]=$this->stnAdmin->getBranchId();
                $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
                $this->Session->setFlash(__("Data berhasil disimpan"), 'default', array(), 'success');
                $this->redirect(array('action' => 'admin_index'));
            } else {
                $this->validationErrors = $this->{ Inflector::classify($this->name) }->validationErrors;
                $this->Session->setFlash(__("Harap mengecek kembali kesalahan dibawah."), 'default', array(), 'danger');
            }
        }
    }

    function admin_edit($id = null) {
        if (!$this->{ Inflector::classify($this->name) }->exists($id)) {
            throw new NotFoundException(__('Data tidak ditemukan'));
        } else {
            if ($this->request->is("post") || $this->request->is("put")) {
                $this->{ Inflector::classify($this->name) }->set($this->data);
                $this->{ Inflector::classify($this->name) }->data[Inflector::classify($this->name)]['id'] = $id;
                if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                    if (!is_null($id)) {
                        $this->CooperativeCash->_numberSeperatorRemover();
                        $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
                        $this->Session->setFlash(__("Data berhasil diubah"), 'default', array(), 'success');
                        $this->redirect(array('action' => 'admin_index'));
                    } else {
                        
                    }
                } else {
                    $this->validationErrors = $this->{ Inflector::classify($this->name) }->validationErrors;
                }
            } else {
                $rows = $this->{ Inflector::classify($this->name) }->find("first", array(
                    'conditions' => array(
                        Inflector::classify($this->name) . ".id" => $id
                    ),
                    'recursive' => 2
                ));
                $this->data = $rows;
            }
        }
    }

    function admin_cash_list() {
        $this->autoRender = false;
        $conds = [];
        if (isset($this->request->query['q'])) {
            $q = $this->request->query['q'];
            $conds[] = array(
                "or" => array(
                    "CooperativeCash.name like" => "%$q%",
                ),
            );
        }
        $suggestions = ClassRegistry::init("CooperativeCash")->find("all", array(
            "conditions" => [
                $conds,
            ],
            "contain" => [
                "CashType",
                "CooperativeBankAccount" => [
                    "BankAccountType"
                ]
            ]
        ));
        $result = [];
        foreach ($suggestions as $item) {
            if (!empty($item)) {
                $result[] = [
                    "id" => @$item['CooperativeCash']['id'],
                    "name" => @$item['CooperativeCash']['name'],
                    "nominal" => @$item['CooperativeCash']['nominal'],
                    "cash_type" => @$item['CashType']['name'],
                    "on_behalf" => !empty($item['CooperativeBankAccount']['on_behalf']) ? $item['CooperativeBankAccount']['on_behalf'] : "-",
                    "code" => !empty($item['CooperativeBankAccount']['code']) ? $item['CooperativeBankAccount']['code'] : "-",
                    "bank_account_type" => !empty($item['CooperativeBankAccount']['BankAccountType']['name']) ? $item['CooperativeBankAccount']['BankAccountType']['name'] : "-"
                ];
            }
        }
        echo json_encode($result);
    }

    function admin_cash_list1($id = null) {
        $this->autoRender = false;
        $conds = [];
        if (isset($this->request->query['q'])) {
            $q = $this->request->query['q'];
            $conds[] = array(
                "or" => array(
                    "CooperativeCash.name like" => "%$q%",
                ),
            );
        }
        $suggestions = ClassRegistry::init("CooperativeCash")->find("all", array(
            "conditions" => [
                $conds,
                "CooperativeCash.id !=" => $id
            ],
            "contain" => [
                "CashType",
                "CooperativeBankAccount" => [
                    "BankAccountType"
                ]
            ]
        ));
        $result = [];
        foreach ($suggestions as $item) {
            if (!empty($item)) {
                $result[] = [
                    "id" => @$item['CooperativeCash']['id'],
                    "name" => @$item['CooperativeCash']['name'],
                    "nominal" => @$item['CooperativeCash']['nominal'],
                    "cash_type" => @$item['CashType']['name'],
                    "on_behalf" => !empty($item['CooperativeBankAccount']['on_behalf']) ? $item['CooperativeBankAccount']['on_behalf'] : "-",
                    "code" => !empty($item['CooperativeBankAccount']['code']) ? $item['CooperativeBankAccount']['code'] : "-",
                    "bank_account_type" => !empty($item['CooperativeBankAccount']['BankAccountType']['name']) ? $item['CooperativeBankAccount']['BankAccountType']['name'] : "-"
                ];
            }
        }
        echo json_encode($result);
    }

}
