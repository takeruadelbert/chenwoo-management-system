<?php

App::uses('AppController', 'Controller');

class ManualWorkingCountsController extends AppController {

    var $name = "ManualWorkingCounts";
    var $disabledAction = array(
    );
    var $contain = [
        "ManualWorkingCountStatus",
        "ManualWorkingCountType",
        "Employee" => [
            "Account" => [
                "Biodata",
            ],
            "Office",
            "Department",
        ],
    ];

    function beforeFilter() {
        parent::beforeFilter();
        $this->_setPageInfo("admin_index", "");
        $this->_setPageInfo("admin_add", "");
        $this->_setPageInfo("admin_edit", "");
    }

    function _options() {
        $this->set("manualWorkingCountStatuses", $this->ManualWorkingCount->ManualWorkingCountStatus->find("list", ["fields" => ["ManualWorkingCountStatus.id", "ManualWorkingCountStatus.name"]]));
        $this->set("manualWorkingCountTypes", $this->ManualWorkingCount->ManualWorkingCountType->find("list", ["fields" => ["ManualWorkingCountType.id", "ManualWorkingCountType.label"]]));
    }

    function beforeRender() {
        $this->_options();
        parent::beforeRender();
    }

    function admin_index() {
        $this->_activePrint(func_get_args(), "data_hari_kerja");
        $this->_setPeriodeLaporanDate("awal_ManualWorkingCount_working_dt", "akhir_ManualWorkingCount_working_dt");
        parent::admin_index();
    }

    function admin_change_status() {
        $this->autoRender = false;
        if ($this->request->is("PUT")) {
            $this->ManualWorkingCount->id = $this->request->data['id'];
            $this->ManualWorkingCount->save(array("ManualWorkingCount" => array("manual_working_count_status_id" => $this->request->data['status'])));
            $data = $this->ManualWorkingCount->find("first", array("conditions" => array("ManualWorkingCount.id" => $this->request->data['id']), "recursive" => 1));
            echo json_encode($this->_generateStatusCode(207, null, array("status_label" => $data['ManualWorkingCountStatus']['name'])));
        } else {
            echo json_encode($this->_generateStatusCode(400));
        }
    }

    function admin_view($id = null) {
        if (!$this->{ Inflector::classify($this->name) }->exists($id)) {
            throw new NotFoundException(__("Id Not Found"));
        } else {
            $rows = $this->{ Inflector::classify($this->name) }->find("first", array(
                'conditions' => array(
                    Inflector::classify($this->name) . ".id" => $id
                ),
                "contain" => [
                    "Employee" => [
                        "Account" => [
                            "Biodata",
                        ],
                        "Department",
                        "Office",
                    ],
                    "ManualWorkingCountStatus",
                    "ManualWorkingCountType",
                ]
            ));
            $this->data = $rows;
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
                        "Employee" => [
                            "Account" => [
                                "Biodata",
                            ],
                            "Department",
                            "Office",
                        ],
                        "ManualWorkingCountStatus",
                        "ManualWorkingCountType",
                    ]
                ));
                $this->data = $rows;
            }
        }
    }

}
