<?php

App::uses('AppController', 'Controller');

class SalaryAllowancesController extends AppController {

    var $name = "SalaryAllowances";
    var $disabledAction = array(
    );
    var $contain = [
        "Employee" => [
            "Account" => [
                "Biodata"
            ]
        ],
        "SalaryAllowanceDetail" => [
            "ParameterSalary"
        ]
    ];

    function beforeFilter() {
        parent::beforeFilter();
        $this->_setPageInfo("admin_index", "");
        $this->_setPageInfo("admin_add", "");
        $this->_setPageInfo("admin_edit", "");
    }

    function _options() {
        $this->set("employees", ClassRegistry::init("Employee")->getListWithFullname());
        $this->set("parameterSalaries", ClassRegistry::init("ParameterSalary")->find("list", ["fields" => ["ParameterSalary.id", "ParameterSalary.name"], "conditions" => ["ParameterSalary.parameter_salary_type_id" => 1,"NOT"=>["ParameterSalary.code"=>["LPH","GPK","GPB","LPJ"]]]]));
    }

    function beforeRender() {
        $this->_options();
        parent::beforeRender();
    }
    
    function admin_add() {
        if ($this->request->is("post")) {            
            $this->{ Inflector::classify($this->name) }->set($this->data);
            $this->SalaryAllowance-> _numberSeperatorRemover();
            if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
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
                        $this->{ Inflector::classify($this->name) }-> _numberSeperatorRemover();
                        $this->{ Inflector::classify($this->name) }->_deleteableHasmany();
                        $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
                        $this->Session->setFlash(__("Data berhasil diubah"), 'default', array(), 'success');
                        $this->redirect(array('action' => 'admin_index'));
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
    
    function admin_index() {
        $this->_activePrint(func_get_args(), "data_salary_allowance");
        parent::admin_index();
    }
}