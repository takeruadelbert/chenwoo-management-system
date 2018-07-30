<?php

App::uses('AppController', 'Controller');

class RevaluationAssetsController extends AppController {

    var $name = "RevaluationAssets";
    var $disabledAction = array(
    );
    var $contain = [
        "AssetProperty" => [
            'GeneralEntryType'
        ]
    ];

    function beforeFilter() {
        parent::beforeFilter();
        $this->_setPageInfo("admin_index", "");
        $this->_setPageInfo("admin_add", "");
        $this->_setPageInfo("admin_edit", "");
        $this->_setPageInfo("admin_view", "");
    }

    function _options() {
        $this->set("assetProperties", ClassRegistry::init("AssetProperty")->find("list", [
            "fields" => [
                "AssetProperty.id",
                "AssetProperty.name"
            ],
            "conditions" => [
                "GeneralEntryType.name like" => "%tanah%"
            ],
            "contain" => [
                "GeneralEntryType"
            ]
        ]));
    }

    function beforeRender() {
        $this->_options();
        parent::beforeRender();
    }

    function admin_view_revaluation_asset($id = null) {
        if ($this->RevaluationAsset->exists($id)) {
            $this->autoRender = false;
            if ($this->request->is("GET")) {
                $data = $this->RevaluationAsset->find("first", [
                    "conditions" => [
                        "RevaluationAsset.id" => $id
                    ],
                    "contain" => [
                        "AssetProperty" => [
                            "GeneralEntryType"
                        ]
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

    function admin_get_data_asset($id) {
        $this->autoRender = false;
        if ($this->request->is("GET")) {
            if (!empty($id)) {
                $data = ClassRegistry::init("AssetProperty")->find("first", [
                    "conditions" => [
                        "AssetProperty.id" => $id
                    ]
                ]);
                return json_encode($data);
            }
        } else {
            return json_encode($this->_generateStatusCode(400));
        }
    }

    function admin_add() {
        if ($this->request->is("post")) {
            $this->{ Inflector::classify($this->name) }->set($this->data);
            if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                $this->RevaluationAsset->_numberSeperatorRemover();
                $this->RevaluationAsset->data['RevaluationAsset']['nominal'] = $this->RevaluationAsset->data['RevaluationAsset']['revaluation_nominal'] - $this->RevaluationAsset->data['RevaluationAsset']['previous_nominal'];
                $this->RevaluationAsset->data['RevaluationAsset']['employee_id'] = $this->Session->read("credential.admin.Employee.id");
                $dataAssetProperty = ClassRegistry::init("AssetProperty")->find("first",[
                    "conditions" => [
                        "AssetProperty.id" => $this->data['RevaluationAsset']['asset_property_id']
                    ],
                    "contain" => [
                        "InitialBalance",
                        "GeneralEntryType"
                    ]
                ]);
                
                /* updating nominal of asset */
                $this->RevaluationAsset->data['AssetProperty']['id'] = $dataAssetProperty['AssetProperty']['id'];
                $this->RevaluationAsset->data['AssetProperty']['nominal'] = $this->RevaluationAsset->data['RevaluationAsset']['revaluation_nominal'];
                $this->RevaluationAsset->data['AssetProperty']['GeneralEntryType']['id'] = $dataAssetProperty['GeneralEntryType']['id'];
                $this->RevaluationAsset->data['AssetProperty']['GeneralEntryType']['initial_balance'] = $this->RevaluationAsset->data['RevaluationAsset']['revaluation_nominal'];
                $this->RevaluationAsset->data['AssetProperty']['GeneralEntryType']['latest_balance'] = $this->RevaluationAsset->data['RevaluationAsset']['revaluation_nominal'];
                
                /* posting to General Entry Table */
                $this->RevaluationAsset->data['GeneralEntry'][0]['initial_balance_id'] = $dataAssetProperty['InitialBalance']['id'];
                $this->RevaluationAsset->data['GeneralEntry'][0]['reference_number'] = "Revaluasi Asset";
                $this->RevaluationAsset->data['GeneralEntry'][0]['transaction_name'] = $dataAssetProperty['GeneralEntryType']['name'];
                $this->RevaluationAsset->data['GeneralEntry'][0]['initial_balance'] = $dataAssetProperty['InitialBalance']['nominal'];
                $this->RevaluationAsset->data['GeneralEntry'][0]['mutation_balance'] = $dataAssetProperty['InitialBalance']['nominal'];
                $this->RevaluationAsset->data['GeneralEntry'][0]['debit'] = $this->RevaluationAsset->data['RevaluationAsset']['nominal'];
                $this->RevaluationAsset->data['GeneralEntry'][0]['transaction_date'] = date("Y-m-d");
                $this->RevaluationAsset->data['GeneralEntry'][0]['general_entry_type_id'] = $dataAssetProperty['GeneralEntryType']['id'];;
                $this->RevaluationAsset->data['GeneralEntry'][0]['transaction_type_id'] = 13;
                $this->RevaluationAsset->data['GeneralEntry'][0]['general_entry_account_type_id'] = 3;
                $this->RevaluationAsset->data['GeneralEntry'][1]['initial_balance_id'] = $dataAssetProperty['InitialBalance']['id'];
                $this->RevaluationAsset->data['GeneralEntry'][1]['reference_number'] = "Revaluasi Asset";
                $this->RevaluationAsset->data['GeneralEntry'][1]['transaction_name'] = "Peningkatan Nilai Aset";
                $this->RevaluationAsset->data['GeneralEntry'][1]['initial_balance'] = $dataAssetProperty['InitialBalance']['nominal'];
                $this->RevaluationAsset->data['GeneralEntry'][1]['mutation_balance'] = $dataAssetProperty['InitialBalance']['nominal'];
                $this->RevaluationAsset->data['GeneralEntry'][1]['credit'] = $this->RevaluationAsset->data['RevaluationAsset']['nominal'];
                $this->RevaluationAsset->data['GeneralEntry'][1]['transaction_date'] = date("Y-m-d");
                $this->RevaluationAsset->data['GeneralEntry'][1]['general_entry_type_id'] = 37;
                $this->RevaluationAsset->data['GeneralEntry'][1]['transaction_type_id'] = 13;
                $this->RevaluationAsset->data['GeneralEntry'][1]['general_entry_account_type_id'] = 3;

                $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
                $this->Session->setFlash(__("Data berhasil disimpan"), 'default', array(), 'success');
                $this->redirect(array('action' => 'admin_index'));
            } else {
                $this->validationErrors = $this->{ Inflector::classify($this->name) }->validationErrors;
                $this->Session->setFlash(__("Harap mengecek kembali kesalahan dibawah."), 'default', array(), 'danger');
            }
        }
    }

}
