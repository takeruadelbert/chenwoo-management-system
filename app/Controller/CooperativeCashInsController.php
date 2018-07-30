<?php

App::uses('AppController', 'Controller');

class CooperativeCashInsController extends AppController {

    var $name = "CooperativeCashIns";
    var $disabledAction = array(
    );
    var $contain = [
        "CooperativeCash",
        "Creator" => [
            "Account" => [
                "Biodata"
            ]
        ],
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
        $this->set("cooperativeCashes", $this->CooperativeCashIn->CooperativeCash->getListWithFullLabel());
        $this->set("inCooperativeGeneralEntryTypes", ClassRegistry::init("CooperativeEntryType")->listByCategory(["income", "netral"]));
    }

    function admin_index() {
        $this->_activePrint(func_get_args(), "data_kas_masuk_koperasi");
        $conds = [];
        if (!empty($this->request->query['start_date']) && empty($this->request->query['end_date'])) {
            $startDate = $this->request->query['start_date'];
            $conds = [
                "DATE_FORMAT(CooperativeCashIn.created_datetime, '%Y-%m-%d %H:%i:%s') >=" => $startDate
            ];
            unset($_GET['start_date']);
        }
        if (empty($this->request->query['start_date']) && !empty($this->request->query['end_date'])) {
            $endDate = $this->request->query['end_date'];
            $conds = [
                "DATE_FORMAT(CooperativeCashIn.created_datetime, '%Y-%m-%d %H:%i:%s') <=" => $endDate
            ];
            unset($_GET['end_date']);
        }
        if (!empty($this->request->query['start_date']) && !empty($this->request->query['end_date'])) {
            $startDate = $this->request->query['start_date'];
            $endDate = $this->request->query['end_date'];
            $conds = [
                "DATE_FORMAT(CooperativeCashIn.created_datetime, '%Y-%m-%d %H:%i:%s') >=" => $startDate,
                "DATE_FORMAT(CooperativeCashIn.created_datetime, '%Y-%m-%d %H:%i:%s') <=" => $endDate
            ];
            unset($_GET['start_date']);
            unset($_GET['end_date']);
        }
        parent::admin_index();
    }

    function admin_add() {
        if ($this->request->is("post")) {
            $this->{ Inflector::classify($this->name) }->set($this->data);
            if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                $this->CooperativeCashIn->_numberSeperatorRemover();
                $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
                $this->CooperativeCashIn->generateNomor($this->CooperativeCashIn->getLastInsertID());

                $cooperativeCashIn = $this->CooperativeCashIn->find("first", [
                    "conditions" => [
                        "CooperativeCashIn.id" => $this->CooperativeCashIn->getLastInsertID(),
                    ],
                    "recursive" => -1,
                ]);
                $entity = $cooperativeCashIn["CooperativeCashIn"];
                //update to cooperative cash
                ClassRegistry::init("CooperativeTransactionMutation")->addMutation($entity["cooperative_cash_id"], $entity["id"], "KMSK", $entity["amount"], $entity["created_datetime"]);

                $this->Session->setFlash(__("Data berhasil disimpan"), 'default', array(), 'success');
                $this->redirect(array('action' => 'admin_index'));
            } else {
                $this->validationErrors = $this->{ Inflector::classify($this->name) }->validationErrors;
                $this->Session->setFlash(__("Harap mengecek kembali kesalahan dibawah."), 'default', array(), 'danger');
            }
        }
    }

    function admin_selfadd() {
        if ($this->request->is("post")) {
            $this->{ Inflector::classify($this->name) }->set($this->data);
            if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                $this->CooperativeCashIn->_numberSeperatorRemover();
                $this->CooperativeCashIn->data['CooperativeCashIn']['creator_id'] = $this->stnAdmin->getEmployeeId();
                $this->{ Inflector::classify($this->name) }->data['CooperativeCashIn']['branch_office_id'] = $this->stnAdmin->getBranchId();
                $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
                $this->CooperativeCashIn->generateNomor($this->CooperativeCashIn->getLastInsertID());

                $cooperativeCashIn = $this->CooperativeCashIn->find("first", [
                    "conditions" => [
                        "CooperativeCashIn.id" => $this->CooperativeCashIn->getLastInsertID(),
                    ],
                    "recursive" => -1,
                ]);
                $entity = $cooperativeCashIn["CooperativeCashIn"];
                //update to cooperative cash
                ClassRegistry::init("CooperativeTransactionMutation")->addMutation($entity["cooperative_cash_id"], $entity["id"], "KMSK", $entity["amount"], $entity["created_datetime"], $this->data["CooperativeCashIn"]["general_entry_type_id"]);

                $this->Session->setFlash(__("Data berhasil disimpan"), 'default', array(), 'success');
                $this->redirect(array('action' => 'admin_cash_in', "controller" => "CooperativeTransactionMutations"));
            } else {
                $this->validationErrors = $this->{ Inflector::classify($this->name) }->validationErrors;
                $this->Session->setFlash(__("Harap mengecek kembali kesalahan dibawah."), 'default', array(), 'danger');
            }
        }
    }

    function admin_view($id = null) {
        if ($this->CooperativeCashIn->exists($id)) {
            $data = $this->CooperativeCashIn->find("first", [
                "conditions" => [
                    "CooperativeCashIn.id" => $id
                ],
                "contain" => [
                    "CooperativeCash",
                    "Creator" => [
                        "Account" => [
                            "Biodata"
                        ]
                    ],
                ]
            ]);
            $this->data = $data;
        } else {
            throw new NotFoundException(__("Data Not Found"));
        }
    }

    function generateCashInNumber() {
        $inc_id = 1;
        $m = date('m');
        $mRoman = romanic_number($m);
        $Y = date('Y');
        $testCode = "KOP-KAS-MASUK/$mRoman/$Y/[0-9]{3}";
        $lastRecord = $this->CooperativeCashIn->find('first', array('conditions' => array('and' => array("CooperativeCashIn.cash_in_number regexp" => $testCode)), 'order' => array('CooperativeCashIn.id' => 'DESC')));
        if (!empty($lastRecord)) {
            $current = explode("/", $lastRecord['CooperativeCashIn']['cash_in_number']);
            $inc_id += $current[count($current) - 1];
        }
        $inc_id = sprintf("%03d", $inc_id);
        $kode = "KOP-KAS-MASUK/$mRoman/$Y/$inc_id";
        return $kode;
    }

    function admin_list() {
        $this->autoRender = false;
        $conds = [];
        if (isset($this->request->query['q'])) {
            $q = $this->request->query['q'];
            $conds[] = array(
                "or" => array(
                    "CooperativeCashIn.cash_in_number like" => "%$q%",
            ));
        }
        $suggestions = ClassRegistry::init("CooperativeCashIn")->find("all", array(
            "conditions" => $conds,
            "limit"=>10,
        ));
        $result = [];
        foreach ($suggestions as $item) {
            if (!empty($item)) {
                $result[] = [
                    "id" => $item['CooperativeCashIn']['id'],
                    "cash_in_number" => @$item['CooperativeCashIn']['cash_in_number'],
                    "amount" => @$item['CooperativeCashIn']['amount'],
                    "created_datetime" => @$item['CooperativeCashIn']['created_datetime']
                ];
            }
        }
        echo json_encode($result);
    }

}
