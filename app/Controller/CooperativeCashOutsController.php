<?php

App::uses('AppController', 'Controller');

class CooperativeCashOutsController extends AppController {

    var $name = "CooperativeCashOuts";
    var $disabledAction = array(
    );
    var $contain = [
        "CooperativeCashOutDetail" => [
            "ExpenditureType",
            "AssetFile",
        ],
        "CooperativeCash",
        "Creator" => [
            "Account" => [
                "Biodata",
            ],
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
        $this->_activePrint(func_get_args(), "data_kas_keluar_koperasi");
        $conds = [];
        if (!empty($this->request->query['start_date'])) {
            $startDate = $this->request->query['start_date'];
            $conds[] = [
                "DATE_FORMAT(CooperativeCashOut.created_datetime, '%Y-%m-%d %H:%i:%s') >=" => $startDate
            ];
            unset($_GET['start_date']);
        }
        if (!empty($this->request->query['end_date'])) {
            $endDate = $this->request->query['end_date'];
            $conds[] = [
                "DATE_FORMAT(CooperativeCashOut.created_datetime, '%Y-%m-%d %H:%i:%s') <=" => $endDate
            ];
            unset($_GET['end_date']);
        }
        $this->conds = [
            $conds
        ];
        parent::admin_index();
    }

    function _options() {
        $this->set("expenditureTypes", $this->CooperativeCashOut->CooperativeCashOutDetail->ExpenditureType->find("list", ["fields" => ["ExpenditureType.id", "ExpenditureType.name"]]));
        $this->set("cooperativeCashes", $this->CooperativeCashOut->CooperativeCash->getListWithFullLabel());
        $this->set("outCooperativeGeneralEntryTypes", ClassRegistry::init("CooperativeEntryType")->listByCategory("outcome"));
    }

    function admin_add() {
        if ($this->request->is("post")) {
            $totalExpenses = 0;
            $this->{ Inflector::classify($this->name) }->set($this->data);
            if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                $this->CooperativeCashOut->_numberSeperatorRemover();

                foreach ($this->data['CooperativeCashOutDetail'] as $k => $details) {
                    if (!empty($details['gambar']['name'])) {
                        App::import("Vendor", "qqUploader");
                        $allowedExt = array("jpg", "jpeg", "png");
                        $size = 10 * 1024 * 1024;
                        $uploader = new qqFileUploader($allowedExt, $size, $this->CooperativeCashOut->data['CooperativeCashOutDetail'][$k]['gambar'], true);
                        $result = $uploader->handleUpload("kaskeluar" . DS . "koperasi" . DS);
                        switch ($result['status']) {
                            case 206:
                                $this->CooperativeCashOut->data['CooperativeCashOutDetail'][$k]['AssetFile'] = array(
                                    "folder" => $result['data']['folder'],
                                    "filename" => $result['data']['fileName'],
                                    "ext" => $result['data']['ext'],
                                    "is_private" => true,
                                );
                                break;
                        }
                        unset($this->CooperativeCashOut->data['CooperativeCashOutDetail'][$k]['gambar']);
                    }
                }
                foreach ($this->CooperativeCashOut->data['CooperativeCashOutDetail'] as $details) {
                    $totalExpenses += $details['amount'];
                }
                $this->CooperativeCashOut->data['CooperativeCashOut']['amount'] = $totalExpenses;

                $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
                $this->CooperativeCashOut->generateNomor($this->CooperativeCashOut->getLastInsertID());

                $cooperativeCashOut = $this->CooperativeCashOut->find("first", [
                    "conditions" => [
                        "CooperativeCashOut.id" => $this->CooperativeCashOut->getLastInsertID(),
                    ],
                    "recursive" => -1,
                ]);
                $entity = $cooperativeCashOut["CooperativeCashOut"];
                //update to cooperative cash
                ClassRegistry::init("CooperativeTransactionMutation")->addMutation($entity["cooperative_cash_id"], $entity["id"], "KKLR", $entity["amount"], $entity["created_datetime"]);

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
            $totalExpenses = 0;
            $this->{ Inflector::classify($this->name) }->set($this->data);
            if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                $this->CooperativeCashOut->_numberSeperatorRemover();
                $this->{ Inflector::classify($this->name) }->data['CooperativeCashOut']['branch_office_id'] = $this->stnAdmin->getBranchId();
                foreach ($this->data['CooperativeCashOutDetail'] as $k => $details) {
                    if (!empty($details['gambar']['name'])) {
                        App::import("Vendor", "qqUploader");
                        $allowedExt = array("jpg", "jpeg", "png");
                        $size = 10 * 1024 * 1024;
                        $uploader = new qqFileUploader($allowedExt, $size, $this->CooperativeCashOut->data['CooperativeCashOutDetail'][$k]['gambar'], true);
                        $result = $uploader->handleUpload("kaskeluar" . DS . "koperasi" . DS);
                        switch ($result['status']) {
                            case 206:
                                $this->CooperativeCashOut->data['CooperativeCashOutDetail'][$k]['AssetFile'] = array(
                                    "folder" => $result['data']['folder'],
                                    "filename" => $result['data']['fileName'],
                                    "ext" => $result['data']['ext'],
                                    "is_private" => true,
                                );
                                break;
                        }
                        unset($this->CooperativeCashOut->data['CooperativeCashOutDetail'][$k]['gambar']);
                    }
                }
                foreach ($this->CooperativeCashOut->data['CooperativeCashOutDetail'] as $details) {
                    $totalExpenses += $details['amount'];
                }
                $this->CooperativeCashOut->data['CooperativeCashOut']['amount'] = $totalExpenses;
                $this->CooperativeCashOut->data['CooperativeCashOut']['creator_id'] = $this->stnAdmin->getEmployeeId();

                $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
                $this->CooperativeCashOut->generateNomor($this->CooperativeCashOut->getLastInsertID());

                $cooperativeCashOut = $this->CooperativeCashOut->find("first", [
                    "conditions" => [
                        "CooperativeCashOut.id" => $this->CooperativeCashOut->getLastInsertID(),
                    ],
                    "recursive" => -1,
                ]);
                $entity = $cooperativeCashOut["CooperativeCashOut"];
                //update to cooperative cash
                ClassRegistry::init("CooperativeTransactionMutation")->addMutation($entity["cooperative_cash_id"], $entity["id"], "KKLR", $entity["amount"], $entity["created_datetime"],$this->data["CooperativeCashOut"]["general_entry_type_id"]);

                $this->Session->setFlash(__("Data berhasil disimpan"), 'default', array(), 'success');
                $this->redirect(array('action' => 'admin_cash_out', "controller" => "cooperative_transaction_mutations"));
            } else {
                $this->validationErrors = $this->{ Inflector::classify($this->name) }->validationErrors;
                $this->Session->setFlash(__("Harap mengecek kembali kesalahan dibawah."), 'default', array(), 'danger');
            }
        }
    }

    function generateCashDisbursementNumber() {
        $inc_id = 1;
        $m = date('m');
        $mRoman = romanic_number($m);
        $Y = date('Y');
        $testCode = "KAS-KELUAR/$mRoman/$Y/[0-9]{3}";
        $lastRecord = $this->CooperativeCashOut->find('first', array('conditions' => array('and' => array("CooperativeCashOut.cash_out_number regexp" => $testCode)), 'order' => array('CooperativeCashOut.id' => 'DESC')));
        if (!empty($lastRecord)) {
            $current = explode("/", $lastRecord['CooperativeCashOut']['cash_out_number']);
            $inc_id+=$current[count($current) - 1];
        }
        $inc_id = sprintf("%03d", $inc_id);
        $kode = "KOP-KAS-KELUAR/$mRoman/$Y/$inc_id";
        return $kode;
    }

    function admin_view($id = null) {
        $this->{ Inflector::classify($this->name) }->id = $id;
        $this->CooperativeCashOut->data['CooperativeCashOut']['id'] = $id;
        $rows = $this->{ Inflector::classify($this->name) }->find("first", array('conditions' => array(Inflector::classify($this->name) . ".id" => $id), "recursive" => 2));
        $this->data = $rows;
    }

    function admin_list() {
        $this->autoRender = false;
        $conds = [];
        if (isset($this->request->query['q'])) {
            $q = $this->request->query['q'];
            $conds[] = array(
                "or" => array(
                    "CooperativeCashOut.cash_out_number like" => "%$q%",
            ));
        }
        $suggestions = ClassRegistry::init("CooperativeCashOut")->find("all", array(
            "conditions" => [
                $conds,
            ],
            "contain" => [
                "Creator" => [
                    "Account" => [
                        "Biodata"
                    ],
                ],
            ],
            "limit"=>10,
        ));
        $result = [];
        foreach ($suggestions as $item) {
            if (!empty($item)) {
                $result[] = [
                    "id" => @$item['CooperativeCashOut']['id'],
                    "cash_out_number" => @$item['CooperativeCashOut']['cash_out_number'],
                    "datetime" => @$item['CooperativeCashOut']['created_datetime'],
                    "fullname" => @$item['Creator']['Account']['Biodata']['full_name'],
                ];
            }
        }
        echo json_encode($result);
    }

}
