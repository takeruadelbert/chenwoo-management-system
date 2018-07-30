<?php

App::uses('AppController', 'Controller');

class AssetPropertiesController extends AppController {

    var $name = "AssetProperties";
    var $disabledAction = array(
    );
    var $contain = [
        "InitialBalance" => [
            "GeneralEntryType"
        ],
        "GeneralEntryType",
        "AssetPropertyType",
        "SetupAssetType"
    ];

    function beforeFilter() {
        parent::beforeFilter();
        $this->_setPageInfo("admin_index", "");
        $this->_setPageInfo("admin_add", "");
        $this->_setPageInfo("admin_edit", "");
        $this->_setPageInfo("admin_view", "");
    }

    function _options() {
        $this->set("initialBalances", ClassRegistry::init("InitialBalance")->find("list", [
                    "conditions" => [
                        "InitialBalance.currency_id" => 1
                    ],
                    "fields" => [
                        "InitialBalance.id",
                        "GeneralEntryType.name"
                    ],
                    "contain" => [
                        "GeneralEntryType"
                    ]
        ]));
        $this->set("assetPropertyTypes", ClassRegistry::init("AssetPropertyType")->find("list", [
                    "fields" => [
                        "AssetPropertyType.id",
                        "AssetPropertyType.name"
                    ]
        ]));
        $conds = [
            "GeneralEntryType.parent_id" => [36, 41], 
            "GeneralEntryType.currency_id" => 1
        ];
        $this->set("capitals", ClassRegistry::init("GeneralEntryType")->listWithFullLabel($conds));
        $conds_for_assets = [
            "GeneralEntryType.parent_id" => [58, 59]
        ];
        $this->set("generalEntryTypes", ClassRegistry::init("GeneralEntryType")->listWithFullLabel($conds_for_assets));
        $this->set("setupAssetTypes", ClassRegistry::init("SetupAssetType")->find("list", ["fields" => ["SetupAssetType.id", "SetupAssetType.name"]]));
    }

    function beforeRender() {
        $this->_options();
        parent::beforeRender();
    }

    function admin_index() {
        $this->_activePrint(func_get_args(), "data_aset");
        parent::admin_index();
    }

    function admin_view_asset($id = null) {
        if ($this->AssetProperty->exists($id)) {
            $this->autoRender = false;
            if ($this->request->is("GET")) {
                $data = $this->AssetProperty->find("first", [
                    "conditions" => [
                        "AssetProperty.id" => $id
                    ],
                    "contain" => [
                        "InitialBalance" => [
                            "GeneralEntryType"
                        ],
                        "GeneralEntryType",
                        "AssetPropertyType"
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

    function admin_buy_new_asset() {
        if ($this->request->is("post")) {
            $this->{ Inflector::classify($this->name) }->set($this->data);
            if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                $this->AssetProperty->_numberSeperatorRemover();
                $asset_date = $this->data['AssetProperty']['date'];
                $this->AssetProperty->data['AssetProperty']['setup_asset_type_id'] = 1;

                /* updating initial balance of Asset COA */
                $coa_asset_id = $this->data['AssetProperty']['general_entry_type_id'];
                $amount = $this->AssetProperty->data['AssetProperty']['nominal'];
                ClassRegistry::init("GeneralEntryType")->increaseLatestBalance($coa_asset_id, $amount);

                /* posting to Transaction Mutation Table */
                $dataInitialBalance = ClassRegistry::init("InitialBalance")->find("first", [
                    "conditions" => [
                        "InitialBalance.id" => $this->data['AssetProperty']['initial_balance_id']
                    ]
                ]);
                $mutation_balance = $dataInitialBalance['InitialBalance']['nominal'] - $this->AssetProperty->data['AssetProperty']['nominal'];

                $this->AssetProperty->data['InitialBalance']['id'] = $dataInitialBalance['InitialBalance']['id'];
                $this->AssetProperty->data['InitialBalance']['nominal'] = $mutation_balance;

                $this->AssetProperty->data['TransactionMutation']['initial_balance_id'] = $this->data['AssetProperty']['initial_balance_id'];
                $this->AssetProperty->data['TransactionMutation']['reference_number'] = "Setup Asset";
                $this->AssetProperty->data['TransactionMutation']['transaction_name'] = $this->data['AssetProperty']['name'];
                $this->AssetProperty->data['TransactionMutation']['debit'] = $this->AssetProperty->data['AssetProperty']['nominal'];
                $this->AssetProperty->data['TransactionMutation']['transaction_date'] = $asset_date;
                $this->AssetProperty->data['TransactionMutation']['initial_balance'] = $dataInitialBalance['InitialBalance']['nominal'];
                $this->AssetProperty->data['TransactionMutation']['mutation_balance'] = $mutation_balance;
                $this->AssetProperty->data['TransactionMutation']['transaction_type_id'] = 11;

                /* posting to General Entry Table */
                $this->AssetProperty->data['GeneralEntry'][0]['initial_balance_id'] = $dataInitialBalance['InitialBalance']['id'];
                $this->AssetProperty->data['GeneralEntry'][0]['reference_number'] = "Setup Asset - Pembelian Asset";
                $this->AssetProperty->data['GeneralEntry'][0]['transaction_name'] = $this->data['AssetProperty']['name'];
                $this->AssetProperty->data['GeneralEntry'][0]['initial_balance'] = $dataInitialBalance['InitialBalance']['nominal'];
                $this->AssetProperty->data['GeneralEntry'][0]['mutation_balance'] = $mutation_balance;
                $this->AssetProperty->data['GeneralEntry'][0]['debit'] = $this->AssetProperty->data['AssetProperty']['nominal'];
                $this->AssetProperty->data['GeneralEntry'][0]['transaction_date'] = $asset_date;
                $this->AssetProperty->data['GeneralEntry'][0]['general_entry_type_id'] = $coa_asset_id;
                $this->AssetProperty->data['GeneralEntry'][0]['transaction_type_id'] = 11;
                $this->AssetProperty->data['GeneralEntry'][0]['general_entry_account_type_id'] = 3;
                $this->AssetProperty->data['GeneralEntry'][1]['initial_balance_id'] = $dataInitialBalance['InitialBalance']['id'];
                $this->AssetProperty->data['GeneralEntry'][1]['reference_number'] = "Setup Asset - Pembelian Asset";
                $this->AssetProperty->data['GeneralEntry'][1]['transaction_name'] = $dataInitialBalance['GeneralEntryType']['name'];
                $this->AssetProperty->data['GeneralEntry'][1]['initial_balance'] = $dataInitialBalance['InitialBalance']['nominal'];
                $this->AssetProperty->data['GeneralEntry'][1]['mutation_balance'] = $mutation_balance;
                $this->AssetProperty->data['GeneralEntry'][1]['credit'] = $this->AssetProperty->data['AssetProperty']['nominal'];
                $this->AssetProperty->data['GeneralEntry'][1]['transaction_date'] = $asset_date;
                $this->AssetProperty->data['GeneralEntry'][1]['general_entry_type_id'] = $dataInitialBalance['GeneralEntryType']['id'];
                $this->AssetProperty->data['GeneralEntry'][1]['transaction_type_id'] = 11;
                $this->AssetProperty->data['GeneralEntry'][1]['general_entry_account_type_id'] = 3;

                $this->AssetProperty->data['AssetProperty']['employee_id'] = $this->Session->read("credential.admin.Employee.id");
                $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
                $this->Session->setFlash(__("Data berhasil disimpan"), 'default', array(), 'success');
                $this->redirect(array('action' => 'admin_index'));
            } else {
                $this->validationErrors = $this->{ Inflector::classify($this->name) }->validationErrors;
                $this->Session->setFlash(__("Harap mengecek kembali kesalahan dibawah."), 'default', array(), 'danger');
            }
        }
    }

    function admin_add() {
        if ($this->request->is("post")) {
            if ($this->data['AssetProperty']['setup_asset_type_id'] == 1) {
                $this->redirect(array('action' => 'admin_buy_new_asset'));
            } else {
                $this->redirect(array('action' => 'admin_input_existing_asset'));
            }
        }
    }

    function admin_input_existing_asset() {
        if ($this->request->is("post")) {
            $this->{ Inflector::classify($this->name) }->set($this->data);
            if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                $this->AssetProperty->data['AssetProperty']['setup_asset_type_id'] = 2;
                $asset_date = $this->data['AssetProperty']['date'];
                $capital_id = $this->data['AssetProperty']['capital_id'];
                $this->AssetProperty->_numberSeperatorRemover();
                $nominal = $this->AssetProperty->data['AssetProperty']['nominal'];
                $coa_asset_id = $this->AssetProperty->data['AssetProperty']['general_entry_type_id'];
                $asset_property_name = $this->data['AssetProperty']['name'];
                
                /* Update Initial Balance of Asset COA */ 
                ClassRegistry::init("GeneralEntryType")->increaseLatestBalance($coa_asset_id, $nominal);

                $this->AssetProperty->data['AssetProperty']['employee_id'] = $this->Session->read("credential.admin.Employee.id");

                $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));

                /* posting to General Entry Table */
                $reference_number = "Setup Asset - Input Asset";
                $dataGeneralEntryTypeCapital = ClassRegistry::init("GeneralEntryType")->find("first", [
                    "conditions" => [
                        "GeneralEntryType.id" => $capital_id
                    ],
                    'recursive' => -1
                ]);
                $transaction_names = [$asset_property_name, $dataGeneralEntryTypeCapital['GeneralEntryType']['name']];
                $transaction_date = $asset_date;
                $transaction_type_id = 11;
                $debits_or_credits = ["debit", 'credit'];
                $general_entry_type_last_insert_id = $coa_asset_id;
                $general_entry_type_ids = [$general_entry_type_last_insert_id, $capital_id];
                $amounts = [$nominal, $nominal];
                $relation_table_name = "asset_property_id";
                $relation_table_id = ClassRegistry::init("AssetProperty")->getLastInsertID();
                $general_entry_account_type_id = 3;
                ClassRegistry::init("GeneralEntry")->post_to_journal($reference_number, $transaction_names, $debits_or_credits, $transaction_date, $transaction_type_id, $general_entry_type_ids, $amounts, $general_entry_account_type_id, $relation_table_name, $relation_table_id);

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

}
