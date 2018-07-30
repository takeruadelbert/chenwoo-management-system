<?php

App::uses('AppController', 'Controller');

class InitialBalancesController extends AppController {

    var $name = "InitialBalances";
    var $disabledAction = array(
    );
    var $contain = [
        "BankAccount" => [
            "BankAccountType"
        ],
        "Currency",
        "GeneralEntryType"
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

    function _options() {
        $this->set("branchOffices", $this->InitialBalance->BranchOffice->find("list", array("fields" => array("BranchOffice.id", "BranchOffice.name"))));
        $this->set("bankAccountTypes", $this->InitialBalance->BankAccount->BankAccountType->find("list", ["fields" => ["BankAccountType.id", "BankAccountType.name"]]));
        $this->set("currencies", $this->InitialBalance->Currency->find("list", ["fields" => ["Currency.id", "Currency.currency"]]));
        $this->set("cashTypes", $this->InitialBalance->GeneralEntryType->find("list", [
            "fields" => [
                "GeneralEntryType.id",
                "GeneralEntryType.name"
            ],
            "conditions" => [
                "GeneralEntryType.parent_id" => [2, 3, 4],
                "GeneralEntryType.is_used" => 0
            ]
        ]));
    }

    function admin_index() {
        $this->_activePrint(func_get_args(), "data_saldo_awal_rekening");
        parent::admin_index();
    }

    function view_initial_balance($id = null) {
        if ($this->InitialBalance->exists($id)) {
            $this->autoRender = false;
            if ($this->request->is("GET")) {
                $data = $this->InitialBalance->find("first", ["conditions" => ["InitialBalance.id" => $id]]);
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
                $this->InitialBalance->_numberSeperatorRemover();
                $dataGeneralEntryTypeCash = ClassRegistry::init("GeneralEntryType")->find("first",[
                    "conditions" => [
                        "GeneralEntryType.id" => $this->data['InitialBalance']['cash']
                    ]
                ]);
                if(!empty($dataGeneralEntryTypeCash)) {
                    $initial_amount = $dataGeneralEntryTypeCash['GeneralEntryType']['initial_balance'];
                } else {
                    $initial_amount = 0;
                }
                $this->InitialBalance->data['InitialBalance']['initial_amount'] = $initial_amount;
                $this->InitialBalance->data['InitialBalance']['nominal'] = $initial_amount;
                $this->InitialBalance->data['InitialBalance']['branch_office_id'] = $this->Session->read("credential.admin.Employee.branch_office_id");
                $this->InitialBalance->data['InitialBalance']['general_entry_type_id'] = $this->data['InitialBalance']['cash'];

                $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
                
                /* Update is_used untuk di modal dan kas. */
                $dataUpdated = [];
                $dataUpdated['GeneralEntryType']['id'] = $this->data['InitialBalance']['cash'];
                $dataUpdated['GeneralEntryType']['is_used'] = 1;
                ClassRegistry::init("GeneralEntryType")->save($dataUpdated);

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
                        $this->InitialBalance->_numberSeperatorRemover();
                        $this->InitialBalance->data['InitialBalance']['remaining'] = $this->InitialBalance->data['InitialBalance']['nominal'];
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

    function admin_cash_list($currency_type) {
        $this->autoRender = false;
        $conds = [];
        if (isset($this->request->query['q'])) {
            $q = $this->request->query['q'];
            $conds[] = array(
                "or" => array(
                    "GeneralEntryType.name like" => "%$q%",
                ),
            );
        }
        $suggestions = ClassRegistry::init("InitialBalance")->find("all", array(
            "conditions" => [
                $conds,
                "InitialBalance.currency_id" => $currency_type
            ],
            "contain" => [
                "BankAccount" => [
                    "BankAccountType"
                ],
                "Currency",
                "GeneralEntryType"
            ]
        ));
        $result = [];
        foreach ($suggestions as $item) {
            if (!empty($item)) {
                if ($item['InitialBalance']['branch_office_id'] == $this->Session->read("credential.admin.Employee.branch_office_id")) {
                    $result[] = [
                        "id" => @$item['InitialBalance']['id'],
                        "name" => @$item['GeneralEntryType']['name'],
                        "nominal" => @$item['InitialBalance']['nominal'],
                        "on_behalf" => @$item['BankAccount']['on_behalf'],
                        "code" => @$item['BankAccount']['code'],
                        "bank_account_type" => @$item['BankAccount']['BankAccountType']['name'],
                        "currency_id" => @$item['Currency']['id']
                    ];
                }
            }
        }
        echo json_encode($result);
    }

}
