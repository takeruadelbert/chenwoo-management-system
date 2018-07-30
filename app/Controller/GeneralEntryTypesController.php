<?php

App::uses('AppController', 'Controller');

class GeneralEntryTypesController extends AppController {

    var $name = "GeneralEntryTypes";
    var $disabledAction = array(
    );
    var $contain = [
        "Parent",
        "Child",
        "Currency"
    ];

    function beforeFilter() {
        parent::beforeFilter();
        $this->_setPageInfo("admin_index", "");
        $this->_setPageInfo("admin_add", "");
        $this->_setPageInfo("admin_edit", "");
    }

    function beforeRender() {
        $this->_options();
        parent::beforeRender();
    }

    function _options() {
        $generalEntryTypes = ClassRegistry::init("GeneralEntryType")->listWithFullLabel();
        $this->set(compact("generalEntryTypes"));
        $this->set("currencies", $this->GeneralEntryType->Currency->find("list", ["fields" => ["Currency.id", "Currency.name"]]));
    }

    function admin_index() {
        $this->_activePrint(func_get_args(), "data_kode_akun_buku_besar");
        $this->conds = [
            "GeneralEntryType.code !=" => null
        ];
        $this->order = "GeneralEntryType.code";
        parent::admin_index();
    }

    function view_general_entry_types($id = null) {
        if ($this->GeneralEntryType->exists($id)) {
            $this->autoRender = false;
            if ($this->request->is("GET")) {
                $data = $this->GeneralEntryType->find("first", ["conditions" => ["GeneralEntryType.id" => $id]]);
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
                $this->GeneralEntryType->_numberSeperatorRemover();
                $this->GeneralEntryType->data['GeneralEntryType']['latest_balance'] = $this->GeneralEntryType->data['GeneralEntryType']['initial_balance'];
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
                        $this->GeneralEntryType->_numberSeperatorRemover();
                        $this->GeneralEntryType->data['GeneralEntryType']['latest_balance'] = $this->GeneralEntryType->data['GeneralEntryType']['initial_balance'];
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
    
    function admin_get_nominal_cash($id) {
        $this->autoRender = false;
        if(!empty($id)) {
            if($this->request->is("GET")) {
                $data = $this->GeneralEntryType->find("first",[
                    "conditions" => [
                        "GeneralEntryType.id" => $id
                    ],
                ]);
                return json_encode($data);
            } else {
                return json_encode($this->_generateStatusCode(400));
            }
        }
    }
    
    function admin_coa_report() {
        $this->_activePrint(func_get_args(), "laporan_saldo_coa");
        $this->order = "GeneralEntryType.code";
        parent::admin_index();
    }
    
    function admin_get_currency_id($coa_id) {
        $this->autoRender = false;
        if(!empty($coa_id)) {
            if($this->request->is("GET")) {
                $data = $this->GeneralEntryType->find("first",[
                    "conditions" => [
                        "GeneralEntryType.id" => $coa_id
                    ],
                    'contain' => [
                        'Currency'
                    ]
                ]);
                $currency = $data['GeneralEntryType']['currency_id'];
                return json_encode($this->_generateStatusCode(200, "OK", $currency));
            } else {
                return json_encode($this->_generateStatusCode(400, "Invalid Request"));
            }
        } else {
            return json_encode($this->_generateStatusCode(404, "ID Not Found"));
        }
    }
}