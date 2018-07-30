<?php

App::uses('AppController', 'Controller');

class DepreciationAssetsController extends AppController {

    var $name = "DepreciationAssets";
    var $disabledAction = array(
    );
    var $contain = [
        "AssetProperty" => [
            "GeneralEntryType"
        ]
    ];

    function beforeFilter() {
        parent::beforeFilter();
        $this->_setPageInfo("admin_index", "");
        $this->_setPageInfo("admin_add", "");
        $this->_setPageInfo("admin_edit", "");
    }

    function admin_index() {
        $this->_activePrint(func_get_args(), "data_depresiasi_aset");
        parent::admin_index();
        $this->_setPageInfo("admin_view", "");
    }

    function _options() {
        $this->set("assetProperties", ClassRegistry::init("AssetProperty")->find("list", [
                    "fields" => [
                        "AssetProperty.id",
                        "AssetProperty.name"
                    ],
                    "conditions" => [
                        "AssetProperty.name NOT LIKE" => '%tanah%'
                    ]
        ]));
    }

    function beforeRender() {
        $this->_options();
        parent::beforeRender();
    }

    function admin_view_depreciation_asset($id = null) {
        if ($this->DepreciationAsset->exists($id)) {
            $this->autoRender = false;
            if ($this->request->is("GET")) {
                $data = $this->DepreciationAsset->find("first", [
                    "conditions" => [
                        "DepreciationAsset.id" => $id
                    ],
                    "contain" => [
                        "AssetProperty" => [
                            "GeneralEntryType"
                        ],
                    ]
                ]);
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
                $this->{ Inflector::classify($this->name) }->_numberSeperatorRemover();
                $this->{ Inflector::classify($this->name) }->data['DepreciationAsset']['employee_id'] = $this->Session->read("credential.admin.Employee.id");
                /* posting to general entry type table */
                $dataAsset = ClassRegistry::init("AssetProperty")->find("first", [
                    "conditions" => [
                        "AssetProperty.id" => $this->data['DepreciationAsset']['asset_property_id']
                    ],
                    "contain" => [
                        "GeneralEntryType"
                    ]
                ]);
                $dataInitialBalance = ClassRegistry::init("InitialBalance")->find("first", [
                    "conditions" => [
                        "InitialBalance.id" => $dataAsset['AssetProperty']['initial_balance_id']
                    ]
                ]);
                $addedData = [];
                $addedData['GeneralEntryType']['name'] = "Akumulasi Penyusutan " . $dataAsset['AssetProperty']['name'];
                $addedData['GeneralEntryType']['parent_id'] = 61;
                $temp = explode("-", $dataAsset['GeneralEntryType']['code']);
                $temp2 = $temp[2];
                $temp_code = substr($temp2, 1, -1);
                $inc_id = intval($temp_code) + 1;
                $inc_first_id = substr($temp2, 0, 1);
                $addedData['GeneralEntryType']['code'] = "1700-00-" . $inc_first_id . $inc_id . "0";
                $addedData['GeneralEntryType']['initial_balance'] = $this->DepreciationAsset->data['DepreciationAsset']['depreciation_amount'];
                $addedData['GeneralEntryType']['latest_balance'] = $this->DepreciationAsset->data['DepreciationAsset']['depreciation_amount'];
                $addedData['GeneralEntryType']['currency_id'] = 1;
                ClassRegistry::init("GeneralEntryType")->save($addedData);

                $last_insert_penyusutan_id = ClassRegistry::init("GeneralEntryType")->getLastInsertID();
                $dataPenyusutanAset = ClassRegistry::init("GeneralEntryType")->find("first", [
                    "conditions" => [
                        "GeneralEntryType.id" => $last_insert_penyusutan_id
                    ]
                ]);
                $this->DepreciationAsset->data['GeneralEntry'][0]['initial_balance_id'] = $dataAsset['AssetProperty']['initial_balance_id'];
                $this->DepreciationAsset->data['GeneralEntry'][0]['reference_number'] = "Penyusutan " . $dataAsset['AssetProperty']['name'];
                $this->DepreciationAsset->data['GeneralEntry'][0]['transaction_name'] = "Biaya Penyusutan";
                $this->DepreciationAsset->data['GeneralEntry'][0]['debit'] = $this->DepreciationAsset->data['DepreciationAsset']['depreciation_amount'];
                $this->DepreciationAsset->data['GeneralEntry'][0]['transaction_date'] = date("Y-m-d");
                $this->DepreciationAsset->data['GeneralEntry'][0]['general_entry_type_id'] = 69;
                $this->DepreciationAsset->data['GeneralEntry'][0]['transaction_type_id'] = 12;
                $this->DepreciationAsset->data['GeneralEntry'][0]['general_entry_account_type_id'] = 3;
                $this->DepreciationAsset->data['GeneralEntry'][1]['initial_balance_id'] = $dataAsset['AssetProperty']['initial_balance_id'];
                $this->DepreciationAsset->data['GeneralEntry'][1]['reference_number'] = "Penyusutan " . $dataAsset['AssetProperty']['name'];
                $this->DepreciationAsset->data['GeneralEntry'][1]['transaction_name'] = $dataPenyusutanAset['GeneralEntryType']['name'];

                $this->DepreciationAsset->data['GeneralEntry'][1]['credit'] = $this->DepreciationAsset->data['DepreciationAsset']['depreciation_amount'];
                $this->DepreciationAsset->data['GeneralEntry'][1]['transaction_date'] = date("Y-m-d");
                $this->DepreciationAsset->data['GeneralEntry'][1]['general_entry_type_id'] = $last_insert_penyusutan_id;
                $this->DepreciationAsset->data['GeneralEntry'][1]['transaction_type_id'] = 12;
                $this->DepreciationAsset->data['GeneralEntry'][1]['general_entry_account_type_id'] = 3;
                if (!empty($dataInitialBalance)) {
                    $this->DepreciationAsset->data['GeneralEntry'][0]['initial_balance'] = $dataInitialBalance['InitialBalance']['nominal'];
                    $this->DepreciationAsset->data['GeneralEntry'][0]['mutation_balance'] = $dataInitialBalance['InitialBalance']['nominal'];
                    $this->DepreciationAsset->data['GeneralEntry'][1]['initial_balance'] = $dataInitialBalance['InitialBalance']['nominal'];
                    $this->DepreciationAsset->data['GeneralEntry'][1]['mutation_balance'] = $dataInitialBalance['InitialBalance']['nominal'];
                }

                $this->DepreciationAsset->data['DepreciationAsset']['general_entry_type_id'] = ClassRegistry::init("GeneralEntryType")->getLastInsertID();
                $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
                $this->Session->setFlash(__("Data berhasil disimpan"), 'default', array(), 'success');
                $this->redirect(array('action' => 'admin_index'));
            } else {
                $this->validationErrors = $this->{ Inflector::classify($this->name) }->validationErrors;
                $this->Session->setFlash(__("Harap mengecek kembali kesalahan dibawah."), 'default', array(), 'danger');
                $this->redirect($this->referer());
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

    function admin_get_nominal_asset($id) {
        $this->autoRender = false;
        if (!empty($id)) {
            if ($this->request->is("GET")) {
                $data = ClassRegistry::init("AssetProperty")->find("first", [
                    "conditions" => [
                        "AssetProperty.id" => $id
                    ],
                    "contain" => [
                        "GeneralEntryType"
                    ]
                ]);
                return json_encode($data);
            } else {
                return json_encode($this->_generateStatusCode(400));
            }
        }
    }

}
