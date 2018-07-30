<?php

App::uses('AppController', 'Controller');

class CooperativeItemLoanPaymentsController extends AppController {

    var $name = "CooperativeItemLoanPayments";
    var $disabledAction = array(
    );
    var $contain = [
        "Creator" => [
            "Account" => [
                "Biodata",
            ],
        ],
        "EmployeeType",
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
        $this->set("employeeTypes", ClassRegistry::init("EmployeeType")->find("list", array("fields" => array("EmployeeType.id", "EmployeeType.name"))));
        $this->set("cooperativeCashes", ClassRegistry::init("CooperativeCash")->find("list", array("fields" => array("CooperativeCash.id", "CooperativeCash.name"))));
    }

    function admin_index() {
        $this->_activePrint(func_get_args(), "cooperative-item-loan-payment");
        parent::admin_index();
    }

    function admin_add() {
        if ($this->request->is("post")) {
            $this->{ Inflector::classify($this->name) }->set($this->data);
            if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                $employeeTypeId = $this->CooperativeItemLoanPayment->data["CooperativeItemLoanPayment"]["employee_type_id"];
//                $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
//                $this->Session->setFlash(__("Data berhasil disimpan"), 'default', array(), 'success');
                $this->redirect(array('action' => 'admin_add_step2', '?' => ["employee_type_id" => $employeeTypeId]));
            } else {
                $this->validationErrors = $this->{ Inflector::classify($this->name) }->validationErrors;
                $this->Session->setFlash(__("Harap mengecek kembali kesalahan dibawah."), 'default', array(), 'danger');
            }
        }
    }

    function admin_add_step2() {
        if ($this->request->is("post")) {
            $this->{ Inflector::classify($this->name) }->set($this->data);
            if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                $this->CooperativeItemLoanPayment->_numberSeperatorRemover();
                $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
                $this->Session->setFlash(__("Data berhasil disimpan"), 'default', array(), 'success');
                $this->redirect(array('action' => 'admin_index'));
            } else {
                $this->validationErrors = $this->{ Inflector::classify($this->name) }->validationErrors;
                $this->Session->setFlash(__("Harap mengecek kembali kesalahan dibawah."), 'default', array(), 'danger');
            }
        }
        $employeeTypeId = $this->request->query["employee_type_id"];
        $cooperativeItemLoans = ClassRegistry::init("CooperativeItemLoan")->find("all", [
            "conditions" => [
                "CooperativeItemLoan.remaining > 0",
                "Employee.employee_type_id" => $employeeTypeId,
            ],
            "contain" => [
                "Employee" => [
                    "Account" => [
                        "Biodata",
                    ],
                ],
            ],
        ]);
        $this->set(compact("cooperativeItemLoans"));
    }

    function admin_edit($id = null) {
        if (!$this->{ Inflector::classify($this->name) }->exists($id)) {
            throw new NotFoundException(__('Data tidak ditemukan'));
        } else {
            if ($this->request->is("post") || $this->request->is("put")) {
                $this->{ Inflector::classify($this->name) }->set($this->data);
                $this->{ Inflector::classify($this->name) }->data[Inflector::classify($this->name)]['id'] = $id;
                if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                    $this->CooperativeItemLoanPayment->_numberSeperatorRemover();
                    if (!is_null($id)) {
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
                    "contain" => [
                        "CooperativeItemLoanPaymentDetail" => [
                            "CooperativeItemLoan" => [
                                "Employee" => [
                                    "Account" => [
                                        "Biodata",
                                    ],
                                ],
                            ],
                        ],
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
            $this->_activePrint(func_get_args(), "data-potongan-hutang-sembako");
            $rows = $this->{ Inflector::classify($this->name) }->find("first", array(
                'conditions' => array(
                    Inflector::classify($this->name) . ".id" => $id
                ),
                "contain" => [
                    "CooperativeItemLoanPaymentDetail" => [
                        "CooperativeItemLoan" => [
                            "Employee" => [
                                "Account" => [
                                    "Biodata",
                                ],
                            ],
                        ],
                    ],
                    "EmployeeType",
                ],
            ));
            $this->data = $rows;
        }
    }

    function admin_bayar_hutang_sembako() {
        if ($this->request->is("post")) {
            $this->{ Inflector::classify($this->name) }->set($this->data);
            $this->{ Inflector::classify($this->name) }->_numberSeperatorRemover();
            if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                $cooperative_item_loan_id = $this->CooperativeItemLoanPayment->data['Dummy']['cooperative_item_loan_id'];
                $paid_date = $this->CooperativeItemLoanPayment->data['CooperativeItemLoanPayment']['start_period'];
                $amount = $this->CooperativeItemLoanPayment->data['CooperativeItemLoanPaymentDetail'][0]['amount'];
                $cooperative_cash_id = $this->CooperativeItemLoanPayment->data['Dummy']['cooperative_cash_id'];
                $this->CooperativeItemLoanPayment->data['CooperativeItemLoanPayment']['end_period'] = $paid_date;
                $this->CooperativeItemLoanPayment->data['CooperativeItemLoanPayment']['employee_type_id'] = $this->CooperativeItemLoanPayment->data['Dummy']['employee_type_id'];
                $this->CooperativeItemLoanPayment->data['CooperativeItemLoanPayment']['creator_id'] = $this->stnAdmin->getEmployeeId();
                $this->CooperativeItemLoanPayment->data['CooperativeItemLoanPaymentDetail'][0]['cooperative_item_loan_id'] = $cooperative_item_loan_id;
                unset($this->CooperativeItemLoanPayment->data['Dummy']);
                try {
                    $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));

                    // update remaining loan on cooperative_item_loans Table
                    $cooperative_item_loan_payment_detail_id = ClassRegistry::init("CooperativeItemLoanPaymentDetail")->getLastInsertID();
                    ClassRegistry::init("CooperativeItemLoanPaymentDetail")->updatePayment($cooperative_item_loan_payment_detail_id, $amount);
                    
                    // posting to Transaction Mutation & Cooperative Entry
                    $cooperative_item_loan_payment_id = ClassRegistry::init("CooperativeItemLoanPayment")->getLastInsertID();
                    ClassRegistry::init("CooperativeTransactionMutation")->addMutation($cooperative_cash_id, $cooperative_item_loan_payment_id, "ANSR-SMBK", $amount, $paid_date, ClassRegistry::init("CooperativeEntryType")->getIdByCode(105));

                    $this->Session->setFlash(__("Data berhasil disimpan"), 'default', array(), 'success');
                    $this->redirect(array('action' => 'admin_bayar_hutang_sembako'));
                } catch (Exception $ex) {
                    $this->Session->setFlash(__("Error found when trying to update the remaining loan and/or saving the data."), 'default', array(), 'danger');
                }
            } else {
                $this->validationErrors = $this->{ Inflector::classify($this->name) }->validationErrors;
                $this->Session->setFlash(__("Harap mengecek kembali kesalahan dibawah."), 'default', array(), 'danger');
            }
        }
    }

}
