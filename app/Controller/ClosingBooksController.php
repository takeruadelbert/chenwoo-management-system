<?php

App::uses('AppController', 'Controller');

class ClosingBooksController extends AppController {

    var $name = "ClosingBooks";
    var $disabledAction = array(
    );
    var $contain = [
        "ClosingBookType",
        "Employee" => [
            "Account" => [
                "Biodata"
            ],
            "Office",
            "Department"
        ],
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
            
    }

    function admin_tutup_buku_akhir_bulan() {
        $this->conds = [
            "ClosingBook.closing_book_type_id" => 1
        ];
        $this->_activePrint(func_get_args(), "print_tutup_buku_akhir_bulan");
        parent::admin_index();
    }

    function admin_tutup_buku_akhir_tahun() {
        $this->conds = [
            "ClosingBook.closing_book_type_id" => 2
        ];
        $this->_activePrint(func_get_args(), "print_tutup_buku_akhir_tahun");
        parent::admin_index();
    }

    function admin_add_tutup_buku_akhir_bulan() {
        if ($this->request->is("post")) {
            $this->{ Inflector::classify($this->name) }->set($this->data);
            if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                $closing_date = $this->data['ClosingBook']['closing_datetime'];
                $employee_id = $this->data['ClosingBook']['employee_id'];
                $closing_book_type_id = 1; // monthly
                unset($this->ClosingBook->data['ClosingBook']);
                if(ClassRegistry::init("GeneralEntryType")->closing_book($closing_date, $employee_id, $closing_book_type_id)) {
                    $this->Session->setFlash(__("Data berhasil disimpan"), 'default', array(), 'success');
                    $this->redirect(array('action' => 'admin_tutup_buku_akhir_bulan'));
                } else {
                    $this->validationErrors = $this->{ Inflector::classify($this->name) }->validationErrors;
                    $this->Session->setFlash(__("Harap mengecek kembali kesalahan dibawah."), 'default', array(), 'danger');
                }                
            } else {
                $this->validationErrors = $this->{ Inflector::classify($this->name) }->validationErrors;
                $this->Session->setFlash(__("Harap mengecek kembali kesalahan dibawah."), 'default', array(), 'danger');
            }
        }
    }

    function admin_add_tutup_buku_akhir_tahun() {
        if ($this->request->is("post")) {
            $this->{ Inflector::classify($this->name) }->set($this->data);
            if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                $this->ClosingBook->_numberSeperatorRemover();

                /* Update the Initial Balance table */
//                $this->ClosingBook->data['InitialBalance']['id'] = $this->data['ClosingBook']['initial_balance_id'];
//                $this->ClosingBook->data['InitialBalance']['initial_amount'] = $this->ClosingBook->data['ClosingBook']['current_balance'];
//                $this->ClosingBook->data['InitialBalance']['nominal'] = $this->ClosingBook->data['ClosingBook']['current_balance'];
                
                /* posting to 'retained earning' table if there's dividend */
//                $dataInitialBalance = ClassRegistry::init("InitialBalance")->find("first",[
//                    "conditions" => [
//                        "InitialBalance.id" => $this->data['ClosingBook']['initial_balance_id']
//                    ]
//                ]);
                $closing_date = $this->data['ClosingBook']['closing_datetime'];
                $employee_id = $this->data['ClosingBook']['employee_id'];
                $closing_book_type_id = 2; // annual
                $previous_retained_earning = 0;
                $dataRetainedEarning = ClassRegistry::init("RetainedEarning")->find("first");
                if(!empty($dataRetainedEarning)) {
                    $previous_retained_earning = $dataRetainedEarning['RetainedEarning']['nominal'];
                }
                $dataUpdated = [];
                $dataUpdated['RetainedEarning']['profit_and_loss_id'] = $this->data['ClosingBook']['profit_and_loss_id'];
                $dataUpdated['RetainedEarning']['nominal'] = $previous_retained_earning + $this->ClosingBook->data['ClosingBook']['retained_earning'];
                $dataUpdated['RetainedEarning']['datetime'] = $closing_date;
                ClassRegistry::init("RetainedEarning")->saveAll($dataUpdated);
                
                unset($this->ClosingBook->data['ClosingBook']);
                if(ClassRegistry::init("GeneralEntryType")->closing_book($closing_date, $employee_id, $closing_book_type_id)) {
                    $this->Session->setFlash(__("Data berhasil disimpan"), 'default', array(), 'success');
                    $this->redirect(array('action' => 'admin_tutup_buku_akhir_bulan'));
                } else {
                    $this->validationErrors = $this->{ Inflector::classify($this->name) }->validationErrors;
                    $this->Session->setFlash(__("Harap mengecek kembali kesalahan dibawah."), 'default', array(), 'danger');
                }
            } else {
                $this->validationErrors = $this->{ Inflector::classify($this->name) }->validationErrors;
                $this->Session->setFlash(__("Harap mengecek kembali kesalahan dibawah."), 'default', array(), 'danger');
            }
        }
    }

    function get_initial_balance_data($id = null) {
        $this->autoRender = false;
        if (!empty($id)) {
            if ($this->request->is("GET")) {
                $data = $this->ClosingBook->InitialBalance->find("first", [
                    "conditions" => [
                        "InitialBalance.id" => $id
                    ]
                ]);
                return json_encode($data);
            } else {
                return json_encode($this->_generateStatusCode(400));
            }
        } else {
            throw new NotFoundExceotion(__("Data Not Found"));
        }
    }
}