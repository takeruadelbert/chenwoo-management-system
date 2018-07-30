<?php

App::uses('AppController', 'Controller');

class CashMutationsController extends AppController {

    var $name = "CashMutations";
    var $disabledAction = array(
    );
    var $contain = [
        "CashTransfered" => [
            "BankAccount" => [
                "BankAccountType"
            ],
            "GeneralEntryType"
        ],
        "CashReceived" => [
            "BankAccount" => [
                "BankAccountType"
            ],
            "GeneralEntryType"
        ],
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
        $this->set("branchOffices", $this->CashMutation->CashTransfered->BranchOffice->find("list", array("fields" => array("BranchOffice.id", "BranchOffice.name"))));
    }

    function admin_index() {
        $this->_activePrint(func_get_args(), "data_mutasi_kas");
        $this->_setPeriodeLaporanDate("awal_CashMutation_transfer_date", "akhir_CashMutation_transfer_date");
        parent::admin_index();
    }

    function view_cash_mutation($id = null) {
        if ($this->CashMutation->exists($id)) {
            $this->autoRender = false;
            if ($this->request->is("GET")) {
                $data = $this->CashMutation->find("first", [
                    "conditions" => [
                        "CashMutation.id" => $id
                    ],
                    "contain" => [
                        "CashTransfered" => [
                            "BankAccount" => [
                                "BankAccountType"
                            ],
                            "GeneralEntryType"
                        ],
                        "CashReceived" => [
                            "BankAccount" => [
                                "BankAccountType"
                            ],
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

    function admin_add() {
        if ($this->request->is("post")) {
            $this->{ Inflector::classify($this->name) }->set($this->data);
            switch ($this->data['CashMutation']['option']) {
                case 1 :
                    $this->redirect(array('action' => 'admin_add_USD_to_IDR'));
                    break;
                case 2 :
                    $this->redirect(array('action' => 'admin_add_IDR_to_USD'));
                    break;
                case 3 :
                    $this->redirect(array("action" => "admin_add_IDR_to_IDR"));
                    break;
                case 4 :
                    $this->redirect(array('action' => "admin_add_USD_to_USD"));
                    break;
                default :
                    $this->Session->setFlash(__("Silhakan Pilih Mutasi Yang Diinginkan."), 'default', array(), 'danger');
                    $this->redirect(array('action' => 'admin_add'));
            }
        }
    }

    function admin_add_USD_to_IDR() {
        if ($this->request->is("post")) {
            $this->{ Inflector::classify($this->name) }->set($this->data);
            if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                $this->CashMutation->_numberSeperatorRemover();
                $this->CashMutation->data['CashMutation']['creator_id'] = $this->Session->read("credential.admin.Employee.id");
                $this->CashMutation->data['CashMutation']['currency_id'] = 1;
                
                /* Update transfered cash balance */
                $dataCash = ClassRegistry::init("InitialBalance")->find("first", [
                    "conditions" => [
                        "InitialBalance.id" => $this->data['CashMutation']['cash_transfered_id'],
                    ],
                    "contain" => [
                        "GeneralEntryType"
                    ]
                ]);
                $dataInitialBalance = [];
                $dataInitialBalance['InitialBalance']['id'] = $this->data['CashMutation']['cash_transfered_id'];
                $dataInitialBalance['InitialBalance']['nominal'] = $dataCash['InitialBalance']['nominal'] - $this->CashMutation->data['CashMutation']['nominal_dollar'];
                ClassRegistry::init("InitialBalance")->save($dataInitialBalance);
                
                $updatedDataInitialBalance = [];
                $updatedDataInitialBalance['GeneralEntryType']['id'] = $dataCash['GeneralEntryType']['id'];
                $updatedDataInitialBalance['GeneralEntryType']['latest_balance'] = $dataCash['InitialBalance']['nominal'] - $this->CashMutation->data['CashMutation']['nominal_dollar'];
                ClassRegistry::init("GeneralEntryType")->save($updatedDataInitialBalance);
                
                /* update received cash balance */
                $dataReceivedCash = ClassRegistry::init("InitialBalance")->find("first", [
                    "conditions" => [
                        "InitialBalance.id" => $this->data['CashMutation']['cash_received_id']
                    ],
                    "contain" => [
                        "GeneralEntryType"
                    ]
                ]);
                $dataReceivedCashUpdated = [];
                $dataReceivedCashUpdated['InitialBalance']['id'] = $this->data['CashMutation']['cash_received_id'];
                $dataReceivedCashUpdated['InitialBalance']['nominal'] = $dataReceivedCash['InitialBalance']['nominal'] + $this->CashMutation->data['CashMutation']['nominal'];
                ClassRegistry::init("InitialBalance")->save($dataReceivedCashUpdated);
                
                $dataUpdatedReceivedCash = [];
                $dataUpdatedReceivedCash['GeneralEntryType']['id'] = $dataReceivedCash['GeneralEntryType']['id'];
                $dataUpdatedReceivedCash['GeneralEntryType']['latest_balance'] = $dataReceivedCash['InitialBalance']['nominal'] + $this->CashMutation->data['CashMutation']['nominal'];
                ClassRegistry::init("GeneralEntryType")->save($dataUpdatedReceivedCash);
                
                /* updating to the General Entries Table */
                $this->CashMutation->data['GeneralEntry'][0]['reference_number'] = "TRANSFER-KAS";
                $this->CashMutation->data['GeneralEntry'][0]['transaction_name'] = $dataReceivedCash['GeneralEntryType']['name'];
                $this->CashMutation->data['GeneralEntry'][0]['transaction_date'] = $this->CashMutation->data['CashMutation']['transfer_date'];
                $this->CashMutation->data['GeneralEntry'][0]['transaction_type_id'] = 5;
                $this->CashMutation->data['GeneralEntry'][0]['general_entry_type_id'] = $dataReceivedCash['GeneralEntryType']['id'];
                $this->CashMutation->data['GeneralEntry'][0]['debit'] = $this->CashMutation->data['CashMutation']['nominal'];
                $this->CashMutation->data['GeneralEntry'][0]['initial_balance'] = $dataReceivedCash['InitialBalance']['nominal'];
                $this->CashMutation->data['GeneralEntry'][0]['mutation_balance'] = $dataReceivedCashUpdated['InitialBalance']['nominal'];
                $this->CashMutation->data['GeneralEntry'][0]['initial_balance_id'] = $dataReceivedCash['InitialBalance']['id'];
                $this->CashMutation->data['GeneralEntry'][0]['general_entry_account_type_id'] = 3;
                $this->CashMutation->data['GeneralEntry'][1]['reference_number'] = "TRANSFER-KAS";
                $this->CashMutation->data['GeneralEntry'][1]['transaction_name'] = $dataCash['GeneralEntryType']['name'];
                $this->CashMutation->data['GeneralEntry'][1]['transaction_date'] = $this->CashMutation->data['CashMutation']['transfer_date'];
                $this->CashMutation->data['GeneralEntry'][1]['transaction_type_id'] = 5;
                $this->CashMutation->data['GeneralEntry'][1]['general_entry_type_id'] = $dataCash['GeneralEntryType']['id'];
                $this->CashMutation->data['GeneralEntry'][1]['credit'] = $this->CashMutation->data['CashMutation']['nominal_dollar'];
                $this->CashMutation->data['GeneralEntry'][1]['initial_balance'] = $dataCash['InitialBalance']['nominal'];
                $this->CashMutation->data['GeneralEntry'][1]['mutation_balance'] = $dataInitialBalance['InitialBalance']['nominal'];
                $this->CashMutation->data['GeneralEntry'][1]['initial_balance_id'] = $this->data['CashMutation']['cash_transfered_id'];
                $this->CashMutation->data['GeneralEntry'][1]['general_entry_account_type_id'] = 3;

                /* updating to the Transaction Mutation Table */
                $this->CashMutation->data['TransactionMutation'][0]['reference_number'] = "TRANSFER-KAS";
                $this->CashMutation->data['TransactionMutation'][0]['transaction_name'] = $dataReceivedCash['GeneralEntryType']['name'];
                $this->CashMutation->data['TransactionMutation'][0]['transaction_date'] = $this->CashMutation->data['CashMutation']['transfer_date'];
                $this->CashMutation->data['TransactionMutation'][0]['transaction_type_id'] = 5;
                $this->CashMutation->data['TransactionMutation'][0]['debit'] = $this->CashMutation->data['CashMutation']['nominal'];
                $this->CashMutation->data['TransactionMutation'][0]['initial_balance'] = $dataReceivedCash['InitialBalance']['nominal'];
                $this->CashMutation->data['TransactionMutation'][0]['mutation_balance'] = $dataReceivedCashUpdated['InitialBalance']['nominal'];
                $this->CashMutation->data['TransactionMutation'][0]['initial_balance_id'] = $this->data['CashMutation']['cash_received_id'];
                $this->CashMutation->data['TransactionMutation'][1]['reference_number'] = "TRANSFER-KAS";
                $this->CashMutation->data['TransactionMutation'][1]['transaction_name'] = $dataCash['GeneralEntryType']['name'];
                $this->CashMutation->data['TransactionMutation'][1]['transaction_date'] = $this->CashMutation->data['CashMutation']['transfer_date'];
                $this->CashMutation->data['TransactionMutation'][1]['transaction_type_id'] = 5;
                $this->CashMutation->data['TransactionMutation'][1]['credit'] = $this->CashMutation->data['CashMutation']['nominal_dollar'];
                $this->CashMutation->data['TransactionMutation'][1]['initial_balance'] = $dataCash['InitialBalance']['nominal'];
                $this->CashMutation->data['TransactionMutation'][1]['mutation_balance'] = $dataInitialBalance['InitialBalance']['nominal'];
                $this->CashMutation->data['TransactionMutation'][1]['initial_balance_id'] = $this->data['CashMutation']['cash_transfered_id'];
                
                $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
                $this->Session->setFlash(__("Data berhasil disimpan"), 'default', array(), 'success');
                $this->redirect(array('action' => 'admin_index'));
            } else {
                $this->validationErrors = $this->{ Inflector::classify($this->name) }->validationErrors;
                $this->Session->setFlash(__("Harap mengecek kembali kesalahan dibawah."), 'default', array(), 'danger');
            }
        }
    }

    function admin_add_IDR_to_USD() {
        if ($this->request->is("post")) {
            $this->{ Inflector::classify($this->name) }->set($this->data);
            if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                $this->CashMutation->_numberSeperatorRemover();
                $this->CashMutation->data['CashMutation']['creator_id'] = $this->Session->read("credential.admin.Employee.id");
                $this->CashMutation->data['CashMutation']['currency_id'] = 2;
                /* Update transfered cash balance */
                $dataCash = ClassRegistry::init("InitialBalance")->find("first", [
                    "conditions" => [
                        "InitialBalance.id" => $this->data['CashMutation']['cash_transfered_id'],
                    ],
                    "contain" => [
                        "GeneralEntryType"
                    ]
                ]);
                $dataInitialBalance = [];
                $dataInitialBalance['InitialBalance']['id'] = $this->data['CashMutation']['cash_transfered_id'];
                $dataInitialBalance['InitialBalance']['nominal'] = $dataCash['InitialBalance']['nominal'] - ($this->CashMutation->data['CashMutation']['nominal'] * $this->CashMutation->data['CashMutation']['exchange_rate']);
                ClassRegistry::init("InitialBalance")->save($dataInitialBalance);
                
                $dataUpdatedInitialBalance = [];
                $dataUpdatedInitialBalance['GeneralEntryType']['id'] = $dataCash['GeneralEntryType']['id'];
                $dataUpdatedInitialBalance['GeneralEntryType']['latest_balance'] = $dataCash['InitialBalance']['nominal'] - ($this->CashMutation->data['CashMutation']['nominal'] * $this->CashMutation->data['CashMutation']['exchange_rate']);
                ClassRegistry::init("GeneralEntryType")->save($dataUpdatedInitialBalance);
                
                /* update received cash balance */
                $dataReceivedCash = ClassRegistry::init("InitialBalance")->find("first", [
                    "conditions" => [
                        "InitialBalance.id" => $this->data['CashMutation']['cash_received_id']
                    ],
                    "contain" => [
                        "GeneralEntryType"
                    ]
                ]);
                $dataReceivedCashUpdated = [];
                $dataReceivedCashUpdated['InitialBalance']['id'] = $this->data['CashMutation']['cash_received_id'];
                $dataReceivedCashUpdated['InitialBalance']['nominal'] = $dataReceivedCash['InitialBalance']['nominal'] + $this->CashMutation->data['CashMutation']['nominal'];
                ClassRegistry::init("InitialBalance")->save($dataReceivedCashUpdated);
                
                $dataUpdatedReceivedCash = [];
                $dataUpdatedReceivedCash['GeneralEntryType']['id'] = $dataReceivedCash['GeneralEntryType']['id'];
                $dataUpdatedReceivedCash['GeneralEntryType']['latest_balance'] = $dataReceivedCash['InitialBalance']['nominal'] + $this->CashMutation->data['CashMutation']['nominal'];
                ClassRegistry::init("GeneralEntryType")->save($dataUpdatedReceivedCash);
                
                /* updating to the General Entries Table */
                $this->CashMutation->data['GeneralEntry'][0]['reference_number'] = "TRANSFER-KAS";
                $this->CashMutation->data['GeneralEntry'][0]['transaction_name'] = "Transfer Dana dari " . $dataCash['GeneralEntryType']['name'] . " ke " . $dataReceivedCash['GeneralEntryType']['name'];
                $this->CashMutation->data['GeneralEntry'][0]['transaction_date'] = $this->CashMutation->data['CashMutation']['transfer_date'];
                $this->CashMutation->data['GeneralEntry'][0]['transaction_type_id'] = 5;
                $this->CashMutation->data['GeneralEntry'][0]['general_entry_type_id'] = $dataReceivedCash['GeneralEntryType']['id'];
                $this->CashMutation->data['GeneralEntry'][0]['debit'] = $this->CashMutation->data['CashMutation']['nominal'];
                $this->CashMutation->data['GeneralEntry'][0]['initial_balance'] = $dataReceivedCash['InitialBalance']['nominal'];
                $this->CashMutation->data['GeneralEntry'][0]['mutation_balance'] = $dataReceivedCashUpdated['InitialBalance']['nominal'];
                $this->CashMutation->data['GeneralEntry'][0]['initial_balance_id'] = $dataReceivedCash['InitialBalance']['id'];
                $this->CashMutation->data['GeneralEntry'][0]['general_entry_account_type_id'] = 3;
                $this->CashMutation->data['GeneralEntry'][1]['reference_number'] = "TRANSFER-KAS";
                $this->CashMutation->data['GeneralEntry'][1]['transaction_name'] = "Transfer Dana dari " . $dataCash['GeneralEntryType']['name'] . " ke " . $dataReceivedCash['GeneralEntryType']['name'];
                $this->CashMutation->data['GeneralEntry'][1]['transaction_date'] = $this->CashMutation->data['CashMutation']['transfer_date'];
                $this->CashMutation->data['GeneralEntry'][1]['transaction_type_id'] = 5;
                $this->CashMutation->data['GeneralEntry'][1]['general_entry_type_id'] = $dataCash['GeneralEntryType']['id'];
                $this->CashMutation->data['GeneralEntry'][1]['credit'] = $this->CashMutation->data['CashMutation']['nominal'] * $this->CashMutation->data['CashMutation']['exchange_rate'];
                $this->CashMutation->data['GeneralEntry'][1]['initial_balance'] = $dataCash['InitialBalance']['nominal'];
                $this->CashMutation->data['GeneralEntry'][1]['mutation_balance'] = $dataInitialBalance['InitialBalance']['nominal'];
                $this->CashMutation->data['GeneralEntry'][1]['initial_balance_id'] = $dataCash['InitialBalance']['id'];
                $this->CashMutation->data['GeneralEntry'][1]['general_entry_account_type_id'] = 3;

                /* updating to the Transaction Mutation Table */
                $this->CashMutation->data['TransactionMutation'][0]['reference_number'] = "TRANSFER-KAS";
                $this->CashMutation->data['TransactionMutation'][0]['transaction_name'] = "Transfer Dana dari " . $dataCash['GeneralEntryType']['name'] . " ke " . $dataReceivedCash['GeneralEntryType']['name'];
                $this->CashMutation->data['TransactionMutation'][0]['transaction_date'] = $this->CashMutation->data['CashMutation']['transfer_date'];
                $this->CashMutation->data['TransactionMutation'][0]['transaction_type_id'] = 5;
                $this->CashMutation->data['TransactionMutation'][0]['debit'] = $this->CashMutation->data['CashMutation']['nominal'];
                $this->CashMutation->data['TransactionMutation'][0]['initial_balance'] = $dataReceivedCash['InitialBalance']['nominal'];
                $this->CashMutation->data['TransactionMutation'][0]['mutation_balance'] = $dataReceivedCashUpdated['InitialBalance']['nominal'];
                $this->CashMutation->data['TransactionMutation'][0]['initial_balance_id'] = $this->data['CashMutation']['cash_received_id'];
                $this->CashMutation->data['TransactionMutation'][1]['reference_number'] = "TRANSFER-KAS";
                $this->CashMutation->data['TransactionMutation'][1]['transaction_name'] = "Transfer Dana dari " . $dataCash['GeneralEntryType']['name'] . " ke " . $dataReceivedCash['GeneralEntryType']['name'];
                $this->CashMutation->data['TransactionMutation'][1]['transaction_date'] = $this->CashMutation->data['CashMutation']['transfer_date'];
                $this->CashMutation->data['TransactionMutation'][1]['transaction_type_id'] = 5;
                $this->CashMutation->data['TransactionMutation'][1]['credit'] = $this->CashMutation->data['CashMutation']['nominal'] * $this->CashMutation->data['CashMutation']['exchange_rate'];
                $this->CashMutation->data['TransactionMutation'][1]['initial_balance'] = $dataCash['InitialBalance']['nominal'];
                $this->CashMutation->data['TransactionMutation'][1]['mutation_balance'] = $dataInitialBalance['InitialBalance']['nominal'];
                $this->CashMutation->data['TransactionMutation'][1]['initial_balance_id'] = $this->data['CashMutation']['cash_transfered_id'];
                
                $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
                $this->Session->setFlash(__("Data berhasil disimpan"), 'default', array(), 'success');
                $this->redirect(array('action' => 'admin_index'));
            } else {
                $this->validationErrors = $this->{ Inflector::classify($this->name) }->validationErrors;
                $this->Session->setFlash(__("Harap mengecek kembali kesalahan dibawah."), 'default', array(), 'danger');
            }
        }
    }
    
    function admin_add_IDR_to_IDR() {
        if ($this->request->is("post")) {
            $this->{ Inflector::classify($this->name) }->set($this->data);
            if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                $this->CashMutation->_numberSeperatorRemover();
                $this->CashMutation->data['CashMutation']['creator_id'] = $this->Session->read("credential.admin.Employee.id");
                $this->CashMutation->data['CashMutation']['currency_id'] = 1;
                /* Update transfered cash balance */
                $dataCash = ClassRegistry::init("InitialBalance")->find("first", [
                    "conditions" => [
                        "InitialBalance.id" => $this->data['CashMutation']['cash_transfered_id'],
                    ],
                    "contain" => [
                        "GeneralEntryType"
                    ]
                ]);
                $dataInitialBalance = [];
                $dataInitialBalance['InitialBalance']['id'] = $this->data['CashMutation']['cash_transfered_id'];
                $dataInitialBalance['InitialBalance']['nominal'] = $dataCash['InitialBalance']['nominal'] - $this->CashMutation->data['CashMutation']['nominal'];
                ClassRegistry::init("InitialBalance")->save($dataInitialBalance);
                
                $dataUpdatedInitialBalance = [];
                $dataUpdatedInitialBalance['GeneralEntryType']['id'] = $dataCash['GeneralEntryType']['id'];
                $dataUpdatedInitialBalance['GeneralEntryType']['latest_balance'] = $dataCash['InitialBalance']['nominal'] - $this->CashMutation->data['CashMutation']['nominal'];
                ClassRegistry::init("GeneralEntryType")->save($dataUpdatedInitialBalance);
                
                /* update received cash balance */
                $dataReceivedCash = ClassRegistry::init("InitialBalance")->find("first", [
                    "conditions" => [
                        "InitialBalance.id" => $this->data['CashMutation']['cash_received_id']
                    ],
                    "contain" => [
                        "GeneralEntryType"
                    ]
                ]);
                $dataReceivedCashUpdated = [];
                $dataReceivedCashUpdated['InitialBalance']['id'] = $this->data['CashMutation']['cash_received_id'];
                $dataReceivedCashUpdated['InitialBalance']['nominal'] = $dataReceivedCash['InitialBalance']['nominal'] + $this->CashMutation->data['CashMutation']['nominal'];
                ClassRegistry::init("InitialBalance")->save($dataReceivedCashUpdated);
                
                $dataUpdatedReceivedCash = [];
                $dataUpdatedReceivedCash['GeneralEntryType']['id'] = $dataReceivedCash['GeneralEntryType']['id'];
                $dataUpdatedReceivedCash['GeneralEntryType']['latest_balance'] = $dataReceivedCash['InitialBalance']['nominal'] + $this->CashMutation->data['CashMutation']['nominal'];
                ClassRegistry::init("GeneralEntryType")->save($dataUpdatedReceivedCash);
                
                /* updating to the General Entries Table */
                $this->CashMutation->data['GeneralEntry'][0]['reference_number'] = "TRANSFER-KAS";
                $this->CashMutation->data['GeneralEntry'][0]['transaction_name'] = "Transfer Dana dari " . $dataCash['GeneralEntryType']['name'] . " ke " . $dataReceivedCash['GeneralEntryType']['name'];
                $this->CashMutation->data['GeneralEntry'][0]['transaction_date'] = $this->CashMutation->data['CashMutation']['transfer_date'];
                $this->CashMutation->data['GeneralEntry'][0]['transaction_type_id'] = 5;
                $this->CashMutation->data['GeneralEntry'][0]['general_entry_type_id'] = $dataReceivedCash['GeneralEntryType']['id'];
                $this->CashMutation->data['GeneralEntry'][0]['debit'] = $this->CashMutation->data['CashMutation']['nominal'];
                $this->CashMutation->data['GeneralEntry'][0]['initial_balance'] = $dataReceivedCash['InitialBalance']['nominal'];
                $this->CashMutation->data['GeneralEntry'][0]['mutation_balance'] = $dataReceivedCashUpdated['InitialBalance']['nominal'];
                $this->CashMutation->data['GeneralEntry'][0]['initial_balance_id'] = $dataReceivedCash['InitialBalance']['id'];
                $this->CashMutation->data['GeneralEntry'][0]['general_entry_account_type_id'] = 3;
                $this->CashMutation->data['GeneralEntry'][1]['reference_number'] = "TRANSFER-KAS";
                $this->CashMutation->data['GeneralEntry'][1]['transaction_name'] = "Transfer Dana dari " . $dataCash['GeneralEntryType']['name'] . " ke " . $dataReceivedCash['GeneralEntryType']['name'];
                $this->CashMutation->data['GeneralEntry'][1]['transaction_date'] = $this->CashMutation->data['CashMutation']['transfer_date'];
                $this->CashMutation->data['GeneralEntry'][1]['transaction_type_id'] = 5;
                $this->CashMutation->data['GeneralEntry'][1]['general_entry_type_id'] = $dataCash['GeneralEntryType']['id'];
                $this->CashMutation->data['GeneralEntry'][1]['credit'] = $this->CashMutation->data['CashMutation']['nominal'];
                $this->CashMutation->data['GeneralEntry'][1]['initial_balance'] = $dataCash['InitialBalance']['nominal'];
                $this->CashMutation->data['GeneralEntry'][1]['mutation_balance'] = $dataInitialBalance['InitialBalance']['nominal'];
                $this->CashMutation->data['GeneralEntry'][1]['initial_balance_id'] = $this->data['CashMutation']['cash_transfered_id'];
                $this->CashMutation->data['GeneralEntry'][1]['general_entry_account_type_id'] = 3;

                /* updating to the Transaction Mutation Table */
                $this->CashMutation->data['TransactionMutation'][0]['reference_number'] = "TRANSFER-KAS";
                $this->CashMutation->data['TransactionMutation'][0]['transaction_name'] = "Transfer Dana dari " . $dataCash['GeneralEntryType']['name'] . " ke " . $dataReceivedCash['GeneralEntryType']['name'];
                $this->CashMutation->data['TransactionMutation'][0]['transaction_date'] = $this->CashMutation->data['CashMutation']['transfer_date'];
                $this->CashMutation->data['TransactionMutation'][0]['transaction_type_id'] = 5;
                $this->CashMutation->data['TransactionMutation'][0]['debit'] = $this->CashMutation->data['CashMutation']['nominal'];
                $this->CashMutation->data['TransactionMutation'][0]['initial_balance'] = $dataReceivedCash['InitialBalance']['nominal'];
                $this->CashMutation->data['TransactionMutation'][0]['mutation_balance'] = $dataReceivedCashUpdated['InitialBalance']['nominal'];
                $this->CashMutation->data['TransactionMutation'][0]['initial_balance_id'] = $this->data['CashMutation']['cash_received_id'];
                $this->CashMutation->data['TransactionMutation'][1]['reference_number'] = "TRANSFER-KAS";
                $this->CashMutation->data['TransactionMutation'][1]['transaction_name'] = "Transfer Dana dari " . $dataCash['GeneralEntryType']['name'] . " ke " . $dataReceivedCash['GeneralEntryType']['name'];
                $this->CashMutation->data['TransactionMutation'][1]['transaction_date'] = $this->CashMutation->data['CashMutation']['transfer_date'];
                $this->CashMutation->data['TransactionMutation'][1]['transaction_type_id'] = 5;
                $this->CashMutation->data['TransactionMutation'][1]['credit'] = $this->CashMutation->data['CashMutation']['nominal'];
                $this->CashMutation->data['TransactionMutation'][1]['initial_balance'] = $dataCash['InitialBalance']['nominal'];
                $this->CashMutation->data['TransactionMutation'][1]['mutation_balance'] = $dataInitialBalance['InitialBalance']['nominal'];
                $this->CashMutation->data['TransactionMutation'][1]['initial_balance_id'] = $this->data['CashMutation']['cash_transfered_id'];

                $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
                $this->Session->setFlash(__("Data berhasil disimpan"), 'default', array(), 'success');
                $this->redirect(array('action' => 'admin_index'));
            } else {
                $this->validationErrors = $this->{ Inflector::classify($this->name) }->validationErrors;
                $this->Session->setFlash(__("Harap mengecek kembali kesalahan dibawah."), 'default', array(), 'danger');
            }
        }
    }
    
    function admin_add_USD_to_USD() {
        if ($this->request->is("post")) {
            $this->{ Inflector::classify($this->name) }->set($this->data);
            if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                $this->CashMutation->_numberSeperatorRemover();
                $this->CashMutation->data['CashMutation']['creator_id'] = $this->Session->read("credential.admin.Employee.id");
                $this->CashMutation->data['CashMutation']['currency_id'] = 2;
                /* Update transfered cash balance */
                $dataCash = ClassRegistry::init("InitialBalance")->find("first", [
                    "conditions" => [
                        "InitialBalance.id" => $this->data['CashMutation']['cash_transfered_id'],
                    ],
                    "contain" => [
                        "GeneralEntryType"
                    ]
                ]);
                $dataInitialBalance = [];
                $dataInitialBalance['InitialBalance']['id'] = $this->data['CashMutation']['cash_transfered_id'];
                $dataInitialBalance['InitialBalance']['nominal'] = $dataCash['InitialBalance']['nominal'] - $this->CashMutation->data['CashMutation']['nominal'];
                ClassRegistry::init("InitialBalance")->save($dataInitialBalance);
                
                $dataUpdatedInitialBalance = [];
                $dataUpdatedInitialBalance['GeneralEntryType']['id'] = $dataCash['GeneralEntryType']['id'];
                $dataUpdatedInitialBalance['GeneralEntryType']['latest_balance'] = $dataCash['InitialBalance']['nominal'] - $this->CashMutation->data['CashMutation']['nominal'];
                ClassRegistry::init("GeneralEntryType")->save($dataUpdatedInitialBalance);
                
                /* update received cash balance */
                $dataReceivedCash = ClassRegistry::init("InitialBalance")->find("first", [
                    "conditions" => [
                        "InitialBalance.id" => $this->data['CashMutation']['cash_received_id']
                    ],
                    "contain" => [
                        "GeneralEntryType"
                    ]
                ]);
                $dataReceivedCashUpdated = [];
                $dataReceivedCashUpdated['InitialBalance']['id'] = $this->data['CashMutation']['cash_received_id'];
                $dataReceivedCashUpdated['InitialBalance']['nominal'] = $dataReceivedCash['InitialBalance']['nominal'] + $this->CashMutation->data['CashMutation']['nominal'];
                ClassRegistry::init("InitialBalance")->save($dataReceivedCashUpdated);
                
                $dataUpdatedReceivedCash = [];
                $dataUpdatedReceivedCash['GeneralEntryType']['id'] = $dataReceivedCash['GeneralEntryType']['id'];
                $dataUpdatedReceivedCash['GeneralEntryType']['latest_balance'] = $dataReceivedCash['InitialBalance']['nominal'] + $this->CashMutation->data['CashMutation']['nominal'];
                ClassRegistry::init("GeneralEntryType")->save($dataUpdatedReceivedCash);
                
                /* updating to the General Entries Table */
                $this->CashMutation->data['GeneralEntry'][0]['reference_number'] = "TRANSFER-KAS";
                $this->CashMutation->data['GeneralEntry'][0]['transaction_name'] = "Transfer Dana dari " . $dataCash['GeneralEntryType']['name'] . " ke " . $dataReceivedCash['GeneralEntryType']['name'];
                $this->CashMutation->data['GeneralEntry'][0]['transaction_date'] = $this->CashMutation->data['CashMutation']['transfer_date'];
                $this->CashMutation->data['GeneralEntry'][0]['transaction_type_id'] = 5;
                $this->CashMutation->data['GeneralEntry'][0]['general_entry_type_id'] = $dataReceivedCash['GeneralEntryType']['id'];
                $this->CashMutation->data['GeneralEntry'][0]['debit'] = $this->CashMutation->data['CashMutation']['nominal'];
                $this->CashMutation->data['GeneralEntry'][0]['initial_balance'] = $dataReceivedCash['InitialBalance']['nominal'];
                $this->CashMutation->data['GeneralEntry'][0]['mutation_balance'] = $dataReceivedCashUpdated['InitialBalance']['nominal'];
                $this->CashMutation->data['GeneralEntry'][0]['initial_balance_id'] = $dataReceivedCash['InitialBalance']['id'];
                $this->CashMutation->data['GeneralEntry'][0]['general_entry_account_type_id'] = 3;
                $this->CashMutation->data['GeneralEntry'][1]['reference_number'] = "TRANSFER-KAS";
                $this->CashMutation->data['GeneralEntry'][1]['transaction_name'] = "Transfer Dana dari " . $dataCash['GeneralEntryType']['name'] . " ke " . $dataReceivedCash['GeneralEntryType']['name'];
                $this->CashMutation->data['GeneralEntry'][1]['transaction_date'] = $this->CashMutation->data['CashMutation']['transfer_date'];
                $this->CashMutation->data['GeneralEntry'][1]['transaction_type_id'] = 5;
                $this->CashMutation->data['GeneralEntry'][1]['general_entry_type_id'] = $dataCash['GeneralEntryType']['id'];
                $this->CashMutation->data['GeneralEntry'][1]['credit'] = $this->CashMutation->data['CashMutation']['nominal'];
                $this->CashMutation->data['GeneralEntry'][1]['initial_balance'] = $dataCash['InitialBalance']['nominal'];
                $this->CashMutation->data['GeneralEntry'][1]['mutation_balance'] = $dataInitialBalance['InitialBalance']['nominal'];
                $this->CashMutation->data['GeneralEntry'][1]['initial_balance_id'] = $this->data['CashMutation']['cash_transfered_id'];
                $this->CashMutation->data['GeneralEntry'][1]['general_entry_account_type_id'] = 3;

                /* updating to the Transaction Mutation Table */
                $this->CashMutation->data['TransactionMutation'][0]['reference_number'] = "TRANSFER-KAS";
                $this->CashMutation->data['TransactionMutation'][0]['transaction_name'] = "Transfer Dana dari " . $dataCash['GeneralEntryType']['name'] . " ke " . $dataReceivedCash['GeneralEntryType']['name'];
                $this->CashMutation->data['TransactionMutation'][0]['transaction_date'] = $this->CashMutation->data['CashMutation']['transfer_date'];
                $this->CashMutation->data['TransactionMutation'][0]['transaction_type_id'] = 5;
                $this->CashMutation->data['TransactionMutation'][0]['debit'] = $this->CashMutation->data['CashMutation']['nominal'];
                $this->CashMutation->data['TransactionMutation'][0]['initial_balance'] = $dataReceivedCash['InitialBalance']['nominal'];
                $this->CashMutation->data['TransactionMutation'][0]['mutation_balance'] = $dataReceivedCashUpdated['InitialBalance']['nominal'];
                $this->CashMutation->data['TransactionMutation'][0]['initial_balance_id'] = $this->data['CashMutation']['cash_received_id'];
                $this->CashMutation->data['TransactionMutation'][1]['reference_number'] = "TRANSFER-KAS";
                $this->CashMutation->data['TransactionMutation'][1]['transaction_name'] = "Transfer Dana dari " . $dataCash['GeneralEntryType']['name'] . " ke " . $dataReceivedCash['GeneralEntryType']['name'];
                $this->CashMutation->data['TransactionMutation'][1]['transaction_date'] = $this->CashMutation->data['CashMutation']['transfer_date'];
                $this->CashMutation->data['TransactionMutation'][1]['transaction_type_id'] = 5;
                $this->CashMutation->data['TransactionMutation'][1]['credit'] = $this->CashMutation->data['CashMutation']['nominal'];
                $this->CashMutation->data['TransactionMutation'][1]['initial_balance'] = $dataCash['InitialBalance']['nominal'];
                $this->CashMutation->data['TransactionMutation'][1]['mutation_balance'] = $dataInitialBalance['InitialBalance']['nominal'];
                $this->CashMutation->data['TransactionMutation'][1]['initial_balance_id'] = $this->data['CashMutation']['cash_transfered_id'];
                
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
                    'recursive' => 3
                ));
                $this->data = $rows;
            }
        }
    }

}
