<?php

App::uses('AppController', 'Controller');

class CooperativeLoanInterestsController extends AppController {

    var $name = "CooperativeLoanInterests";
    var $disabledAction = array(
    );
    var $contain = [
        "CooperativeLoanType",
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
        $this->set("cooperativeLoanTypes", $this->CooperativeLoanInterest->CooperativeLoanType->find("list", ["CooperativeLoanType.id", "CooperativeLoanType.name"]));
    }

    function admin_index() {
        $this->_activePrint(func_get_args(), "data_setup_bunga_pinjaman");
        parent::admin_index();
    }

    function admin_add() {
        if ($this->request->is("post")) {
            $this->{ Inflector::classify($this->name) }->set($this->data);
            if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                $this->CooperativeLoanInterest->_numberSeperatorRemover();
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
                        $this->CooperativeLoanInterest->_numberSeperatorRemover();
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

    function view_loan_interest($id = null) {
        if ($this->CooperativeLoanInterest->exists($id)) {
            $this->autoRender = false;
            if ($this->request->is("GET")) {
                $data = $this->CooperativeLoanInterest->find("first", ["conditions" => ["CooperativeLoanInterest.id" => $id], "contain" => ["CooperativeLoanType"]]);
                return json_encode($data);
            } else {
                return json_encode($this->_generateStatusCode(400));
            }
        } else {
            throw new NotFoundException(__("Data Not Found"));
        }
    }

    function admin_get_loan_interest_money($amount) {
        $this->autoRender = false;
        if ($this->request->is("GET")) {
            if (!empty($amount)) {
                $data = $this->CooperativeLoanInterest->find("first", [
                    "conditions" => [
                        "CooperativeLoanInterest.bottom_limit <=" => $amount,
                        "CooperativeLoanInterest.upper_limit >=" => $amount,
                        "CooperativeLoanInterest.cooperative_loan_type_id" => 2,
                    ]
                ]);
                return json_encode($data);
            } else {
                return json_encode("Nominal kosong!!");
            }
        } else {
            return json_encode($this->_generateStatusCode(400));
        }
    }

    function admin_get_loan_interest_item($amount) {
        $this->autoRender = false;
        if ($this->request->is("GET")) {
            if (!empty($amount)) {
                $data = $this->CooperativeLoanInterest->find("first", [
                    "conditions" => [
                        "CooperativeLoanInterest.bottom_limit <=" => $amount,
                        "CooperativeLoanInterest.upper_limit >=" => $amount,
                        "CooperativeLoanInterest.cooperative_loan_type_id" => 1,
                    ],
                ]);
                if (empty($data)) {
                    return json_encode($this->_generateStatusCode(405, "Jumlah Nominal Salah"));
                } else {
                    $interest = floatval($data["CooperativeLoanInterest"]["interest"]);
                    $result = [
                        "id" => $data["CooperativeLoanInterest"]["id"],
                        "bottom_limit" => floatval($data["CooperativeLoanInterest"]["bottom_limit"]),
                        "upper_limit" => floatval($data["CooperativeLoanInterest"]["upper_limit"]),
                        "interest" => $interest,
                    ];

                    return json_encode($this->_generateStatusCode(206, null, $result));
                }
            } else {
                return json_encode($this->_generateStatusCode(405, "Jumlah Nominal Salah"));
            }
        } else {
            return json_encode($this->_generateStatusCode(400));
        }
    }

}
