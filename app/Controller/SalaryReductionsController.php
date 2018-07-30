<?php

App::uses('AppController', 'Controller');

class SalaryReductionsController extends AppController {

    var $name = "SalaryReductions";
    var $disabledAction = array(
    );
    var $contain = [
        "ParameterSalary",
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
        $this->set("parameterSalaries", $this->SalaryReduction->ParameterSalary->find("list", ["fields" => ["ParameterSalary.id", "ParameterSalary.name"], "conditions" => ["ParameterSalary.parameter_salary_type_id" => 2]]));
    }

    function admin_index() {
        $this->_activePrint(func_get_args(), "data_potongan_gaji");
        parent::admin_index();
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
                        $this->{ Inflector::classify($this->name) }->_numberSeperatorRemover();
                        $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
                        $this->Session->setFlash(__("Data berhasil diubah"), 'default', array(), 'success');
                        $this->redirect(array('action' => 'admin_index'));
                    } else {
                        
                    }
                } else {
                    $this->validationErrors = $this->{ Inflector::classify($this->name) }->validationErrors;
                }
            } else {
                $dataEmployeeHarian = $this->SalaryReduction->SalaryReductionDetail->Employee->find("all", array(
                    'contain' => [
                        "AttendanceEmployeeUid",
                        "Account" => [
                            "Biodata",
                        ],
                    ],
                    "conditions" => [
                        "NOT" => [
                            "Account.id" => $this->SalaryReduction->SalaryReductionDetail->Employee->excludedEmployee(),
                        ],
                        "Employee.employee_type_id" => 1,
                    ],
                ));
                $dataEmployeeBulanan = $this->SalaryReduction->SalaryReductionDetail->Employee->find("all", array(
                    'contain' => [
                        "AttendanceEmployeeUid",
                        "Account" => [
                            "Biodata",
                        ],
                    ],
                    "conditions" => [
                        "NOT" => [
                            "Account.id" => $this->SalaryReduction->SalaryReductionDetail->Employee->excludedEmployee(),
                        ],
                        "Employee.employee_type_id" => 2,
                    ],
                ));
                $this->set(compact("dataEmployeeHarian", "dataEmployeeBulanan"));
                $rows = $this->{ Inflector::classify($this->name) }->find("first", array(
                    'conditions' => array(
                        Inflector::classify($this->name) . ".id" => $id
                    ),
                    "contain" => [
                        "SalaryReductionDetail",
                    ],
                ));
                $this->data = $rows;
            }
        }
    }

    function admin_view($id = null) {
        if (!$this->{ Inflector::classify($this->name) }->exists($id)) {
            throw new NotFoundException(__("Id Not Found"));
        } else {
            $dataEmployeeHarian = $this->SalaryReduction->SalaryReductionDetail->Employee->find("all", array(
                'contain' => [
                    "AttendanceEmployeeUid",
                    "Account" => [
                        "Biodata",
                    ],
                ],
                "conditions" => [
                    "NOT" => [
                        "Account.id" => $this->SalaryReduction->SalaryReductionDetail->Employee->excludedEmployee(),
                    ],
                    "Employee.employee_type_id" => 1,
                ],
            ));
            $dataEmployeeBulanan = $this->SalaryReduction->SalaryReductionDetail->Employee->find("all", array(
                'contain' => [
                    "AttendanceEmployeeUid",
                    "Account" => [
                        "Biodata",
                    ],
                ],
                "conditions" => [
                    "NOT" => [
                        "Account.id" => $this->SalaryReduction->SalaryReductionDetail->Employee->excludedEmployee(),
                    ],
                    "Employee.employee_type_id" => 2,
                ],
            ));
            $this->set(compact("dataEmployeeHarian", "dataEmployeeBulanan"));
            $rows = $this->{ Inflector::classify($this->name) }->find("first", array(
                'conditions' => array(
                    Inflector::classify($this->name) . ".id" => $id
                ),
                "contain" => [
                    "ParameterSalary",
                    "SalaryReductionDetail",
                ],
            ));
            $this->data = $rows;
        }
    }

}
