<?php

App::uses('AppController', 'Controller');

class CashInsController extends AppController {

    var $name = "CashIns";
    var $disabledAction = array(
    );
    var $contain = [
        "InitialBalance" => [
            "GeneralEntryType"
        ],
        "Creator" => [
            "Account" => [
                "Biodata"
            ]
        ],
        "GeneralEntryType",
        "BranchOffice"
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
        $this->set("initialBalances", ClassRegistry::init("InitialBalance")->find("list", [
                    "fields" => [
                        "InitialBalance.id",
                        "GeneralEntryType.name"
                    ],
                    "conditions" => [
                        "GeneralEntryType.parent_id" => [2, 3, 4],
//                "GeneralEntryType.currency_id" => 1
                    ],
                    "contain" => [
                        "GeneralEntryType"
                    ]
        ]));
        $this->set("branchOffices", $this->CashIn->BranchOffice->find("list", array("fields" => array("BranchOffice.id", "BranchOffice.name"))));
        $generalEntryTypes = ClassRegistry::init("GeneralEntryType")->find("list", [
            "fields" => [
                "GeneralEntryType.id",
                "GeneralEntryType.name",
                "Parent.name"
            ],
            "contain" => [
                "Parent"
            ]
        ]);
        $generalEntryTypes['Kategori Utama'] = $generalEntryTypes[0];
        unset($generalEntryTypes[0]);
        $this->set(compact("generalEntryTypes"));
        $this->set("capitals", ClassRegistry::init("GeneralEntryType")->find("list", [
                    "conditions" => [
                        "GeneralEntryType.parent_id" => 36
                    ],
                    "fields" => [
                        "GeneralEntryType.id",
                        "GeneralEntryType.name"
                    ]
        ]));
    }

    function admin_index() {
        $this->_activePrint(func_get_args(), "data_kas_masuk");
        $this->_setPeriodeLaporanDate("awal_CashIn_created_datetime", "akhir_CashIn_created_datetime");
        parent::admin_index();
    }

    function admin_add() {
        if ($this->request->is("post")) {
            $this->{ Inflector::classify($this->name) }->set($this->data);
            if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                $this->CashIn->_numberSeperatorRemover();

                /* generate cash in number */
                $this->CashIn->data['CashIn']['cash_in_number'] = $this->generateCashInNumber();
                $this->{ Inflector::classify($this->name) }->data['CashIn']['branch_office_id'] = $this->Session->read("credential.admin.Employee.branch_office_id");
                $dataInitialBalance = ClassRegistry::init("InitialBalance")->find("first", [
                    "conditions" => [
                        "InitialBalance.id" => $this->data['CashIn']['initial_balance_id']
                    ],
                    "contain" => [
                        "GeneralEntryType"
                    ]
                ]);

                $dataGeneralEntryType = ClassRegistry::init("GeneralEntryType")->find("first", [
                    "conditions" => [
                        "GeneralEntryType.id" => $this->data['CashIn']['general_entry_type_id']
                    ]
                ]);

                $mutation_balance = $dataInitialBalance['InitialBalance']['nominal'] + $this->CashIn->data['CashIn']['amount'];
//                debug($this->CashIn->data);
//                die;
                /* updating latest balance of initial balance */
                $this->CashIn->data['InitialBalance']['id'] = $this->data['CashIn']['initial_balance_id'];
                $this->CashIn->data['InitialBalance']['nominal'] = $mutation_balance;
                
                /* updating latest balance of general entry types */
                ClassRegistry::init("GeneralEntryType")->increaseLatestBalance($dataInitialBalance['GeneralEntryType']['id'], $this->CashIn->data['CashIn']['amount']);
                ClassRegistry::init("GeneralEntryType")->increaseLatestBalance($this->data['CashIn']['general_entry_type_id'], $this->CashIn->data['CashIn']['amount']);
                
                $note = strip_tags($this->CashIn->data['CashIn']['note']);
                
                /* updating to General Entries Table */
                $transaction_date = $this->CashIn->data['CashIn']['created_datetime'];
                $this->CashIn->data['GeneralEntry'][0]['reference_number'] = $this->generateCashInNumber();
                $this->CashIn->data['GeneralEntry'][0]['transaction_name'] = $dataInitialBalance['GeneralEntryType']['name'] . " - " . $note;
                $this->CashIn->data['GeneralEntry'][0]['debit'] = $this->CashIn->data['CashIn']['amount'];
                $this->CashIn->data['GeneralEntry'][0]['transaction_date'] = $transaction_date;
                $this->CashIn->data['GeneralEntry'][0]['transaction_type_id'] = 1;
                $this->CashIn->data['GeneralEntry'][0]['general_entry_type_id'] = $dataInitialBalance['GeneralEntryType']['id'];
                $this->CashIn->data['GeneralEntry'][0]['initial_balance'] = $dataInitialBalance['GeneralEntryType']['latest_balance'];
                $this->CashIn->data['GeneralEntry'][0]['mutation_balance'] = $mutation_balance;
                $this->CashIn->data['GeneralEntry'][0]['initial_balance_id'] = $dataInitialBalance['InitialBalance']['id'];
                $this->CashIn->data['GeneralEntry'][0]['general_entry_account_type_id'] = 2;
                $this->CashIn->data['GeneralEntry'][1]['reference_number'] = $this->generateCashInNumber();
                $this->CashIn->data['GeneralEntry'][1]['transaction_name'] = $dataGeneralEntryType['GeneralEntryType']['name'];
                $this->CashIn->data['GeneralEntry'][1]['credit'] = $this->CashIn->data['CashIn']['amount'];
                $this->CashIn->data['GeneralEntry'][1]['transaction_date'] = $transaction_date;
                $this->CashIn->data['GeneralEntry'][1]['transaction_type_id'] = 1;
                $this->CashIn->data['GeneralEntry'][1]['general_entry_type_id'] = $dataGeneralEntryType['GeneralEntryType']['id'];
                $this->CashIn->data['GeneralEntry'][1]['initial_balance'] = $dataInitialBalance['GeneralEntryType']['latest_balance'];
                $this->CashIn->data['GeneralEntry'][1]['mutation_balance'] = $mutation_balance;
                $this->CashIn->data['GeneralEntry'][1]['initial_balance_id'] = $dataInitialBalance['InitialBalance']['id'];
                $this->CashIn->data['GeneralEntry'][1]['general_entry_account_type_id'] = 2;

                /* updating to Transaction Mutation Table */
                $this->CashIn->data['TransactionMutation']['reference_number'] = $this->generateCashInNumber();
                $this->CashIn->data['TransactionMutation']['transaction_name'] = $note;
                $this->CashIn->data['TransactionMutation']['debit'] = $this->CashIn->data['CashIn']['amount'];
                $this->CashIn->data['TransactionMutation']['transaction_date'] = $transaction_date;
                $this->CashIn->data['TransactionMutation']['transaction_type_id'] = 1;
                $this->CashIn->data['TransactionMutation']['initial_balance'] = $dataInitialBalance['GeneralEntryType']['latest_balance'];
                $this->CashIn->data['TransactionMutation']['mutation_balance'] = $mutation_balance;
                $this->CashIn->data['TransactionMutation']['initial_balance_id'] = $dataInitialBalance['InitialBalance']['id'];

                $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
                $this->Session->setFlash(__("Data berhasil disimpan"), 'default', array(), 'success');
                $this->redirect(array('action' => 'admin_index'));
            } else {
                $this->validationErrors = $this->{ Inflector::classify($this->name) }->validationErrors;
                $this->Session->setFlash(__("Field Keterangan dan Nominal Harus Diisi."), 'default', array(), 'danger');
                $this->redirect($this->referer());                
            }
        }
    }

//    function admin_add_external() {
//        if ($this->request->is("post")) {
//            $this->{ Inflector::classify($this->name) }->set($this->data);
//            if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
//                $this->CashIn->_numberSeperatorRemover();
//                $this->CashIn->data['CashIn']['cash_in_type_id'] = 2; // External Type
//                /* generate cash in number */
//                $this->CashIn->data['CashIn']['cash_in_number'] = $this->generateCashInNumber(2);
//                $this->{ Inflector::classify($this->name) }->data['CashIn']['currency_id'] = 1;
//                $this->{ Inflector::classify($this->name) }->data['CashIn']['branch_office_id'] = $this->Session->read("credential.admin.Employee.branch_office_id");
//
//                /* update the balance of initial balance table */
//                $dataInitialBalance = ClassRegistry::init("InitialBalance")->find("first", [
//                    "conditions" => [
//                        "InitialBalance.id" => $this->data['CashIn']['initial_balance_id']
//                    ],
//                    "contain" => [
//                        "GeneralEntryType"
//                    ]
//                ]);
//                $this->CashIn->data['InitialBalance']['id'] = $dataInitialBalance['InitialBalance']['id'];
//                $this->CashIn->data['InitialBalance']['nominal'] = $dataInitialBalance['InitialBalance']['nominal'] + $this->CashIn->data['CashIn']['amount'];
//                $updatedData = [];
//                $updatedData['GeneralEntryType']['id'] = $dataInitialBalance['GeneralEntryType']['id'];
//                $updatedData['GeneralEntryType']['latest_balance'] = $this->CashIn->data['InitialBalance']['nominal'];
//                ClassRegistry::init("GeneralEntryType")->saveAll($updatedData);
//
//                /* updating to General Entries Table */
//                $this->CashIn->data['GeneralEntry'][0]['reference_number'] = $this->generateCashInNumber($this->CashIn->data['CashIn']['cash_in_type_id']);
//                $this->CashIn->data['GeneralEntry'][0]['transaction_name'] = $dataInitialBalance['GeneralEntryType']['name'];
//                $this->CashIn->data['GeneralEntry'][0]['debit'] = $this->CashIn->data['CashIn']['amount'];
//                $this->CashIn->data['GeneralEntry'][0]['transaction_date'] = date("Y-m-d");
//                $this->CashIn->data['GeneralEntry'][0]['transaction_type_id'] = 1;
//                $this->CashIn->data['GeneralEntry'][0]['general_entry_type_id'] = $dataInitialBalance['GeneralEntryType']['id'];
//                $this->CashIn->data['GeneralEntry'][0]['initial_balance'] = $dataInitialBalance['InitialBalance']['nominal'];
//                $this->CashIn->data['GeneralEntry'][0]['mutation_balance'] = $this->CashIn->data['InitialBalance']['nominal'];
//                $this->CashIn->data['GeneralEntry'][0]['initial_balance_id'] = $dataInitialBalance['InitialBalance']['id'];
//                $this->CashIn->data['GeneralEntry'][0]['general_entry_account_type_id'] = 2;
//                $this->CashIn->data['GeneralEntry'][1]['reference_number'] = $this->generateCashInNumber($this->CashIn->data['CashIn']['cash_in_type_id']);
//                $this->CashIn->data['GeneralEntry'][1]['transaction_name'] = "Hutang Bank";
//                $this->CashIn->data['GeneralEntry'][1]['credit'] = $this->CashIn->data['CashIn']['amount'];
//                $this->CashIn->data['GeneralEntry'][1]['transaction_date'] = date("Y-m-d");
//                $this->CashIn->data['GeneralEntry'][1]['transaction_type_id'] = 1;
//                $this->CashIn->data['GeneralEntry'][1]['general_entry_type_id'] = 28;
//                $this->CashIn->data['GeneralEntry'][1]['initial_balance'] = $dataInitialBalance['InitialBalance']['nominal'];
//                $this->CashIn->data['GeneralEntry'][1]['mutation_balance'] = $this->CashIn->data['InitialBalance']['nominal'];
//                $this->CashIn->data['GeneralEntry'][1]['initial_balance_id'] = $dataInitialBalance['InitialBalance']['id'];
//                $this->CashIn->data['GeneralEntry'][1]['general_entry_account_type_id'] = 2;
//
//                /* updating to Transaction Mutation Table */
//                $this->CashIn->data['TransactionMutation']['reference_number'] = $this->generateCashInNumber($this->CashIn->data['CashIn']['cash_in_type_id']);
//                $this->CashIn->data['TransactionMutation']['transaction_name'] = "Hutang Usaha";
//                $this->CashIn->data['TransactionMutation']['debit'] = $this->CashIn->data['CashIn']['amount'];
//                $this->CashIn->data['TransactionMutation']['transaction_date'] = date("Y-m-d");
//                $this->CashIn->data['TransactionMutation']['transaction_type_id'] = 1;
//                $this->CashIn->data['TransactionMutation']['initial_balance'] = $dataInitialBalance['InitialBalance']['nominal'];
//                $this->CashIn->data['TransactionMutation']['mutation_balance'] = $this->CashIn->data['InitialBalance']['nominal'];
//                $this->CashIn->data['TransactionMutation']['initial_balance_id'] = $dataInitialBalance['InitialBalance']['id'];
//
//                $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
//                $this->Session->setFlash(__("Data berhasil disimpan"), 'default', array(), 'success');
//                $this->redirect(array('action' => 'admin_index'));
//            } else {
//                $this->validationErrors = $this->{ Inflector::classify($this->name) }->validationErrors;
//                $this->Session->setFlash(__("Harap mengecek kembali kesalahan dibawah."), 'default', array(), 'danger');
//            }
//        }
//    }

    function admin_edit($id = null) {
        if (!$this->{ Inflector::classify($this->name) }->exists($id)) {
            throw new NotFoundException(__('Data tidak ditemukan'));
        } else {
            if ($this->request->is("post") || $this->request->is("put")) {
                $this->{ Inflector::classify($this->name) }->set($this->data);
                $this->{ Inflector::classify($this->name) }->data[Inflector::classify($this->name)]['id'] = $id;
                if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                    if (!is_null($id)) {
                        $this->CashIn->_numberSeperatorRemover();
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

//    function admin_edit_external($id = null) {
//        if (!$this->{ Inflector::classify($this->name) }->exists($id)) {
//            throw new NotFoundException(__('Data tidak ditemukan'));
//        } else {
//            if ($this->request->is("post") || $this->request->is("put")) {
//                $this->{ Inflector::classify($this->name) }->set($this->data);
//                $this->{ Inflector::classify($this->name) }->data[Inflector::classify($this->name)]['id'] = $id;
//                if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
//                    if (!is_null($id)) {
//                        $this->CashIn->_numberSeperatorRemover();
//                        $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
//                        $this->Session->setFlash(__("Data berhasil diubah"), 'default', array(), 'success');
//                        $this->redirect(array('action' => 'admin_index'));
//                    } else {
//                        
//                    }
//                } else {
//                    $this->validationErrors = $this->{ Inflector::classify($this->name) }->validationErrors;
//                }
//            } else {
//                $rows = $this->{ Inflector::classify($this->name) }->find("first", array(
//                    'conditions' => array(
//                        Inflector::classify($this->name) . ".id" => $id
//                    ),
//                    'recursive' => 3
//                ));
//                $this->data = $rows;
//            }
//        }
//    }

    function admin_view($id = null) {
        if (!empty($id)) {
            if ($this->CashIn->exists($id)) {
                $data = $this->CashIn->find("first", [
                    "conditions" => [
                        "CashIn.id" => $id
                    ],
                    "contain" => [
                        "InitialBalance",
                        "Creator" => [
                            "Account" => [
                                "Biodata"
                            ],
                            "Department",
                            "Office"
                        ]
                    ]
                ]);
                $this->data = $data;
            } else {
                throw new NotFoundException(__("Data Not Found"));
            }
        } else {
            throw new NotFoundException(__("ID IS NULL"));
        }
    }

//    function admin_view_external($id = null) {
//        if (!empty($id)) {
//            if ($this->CashIn->exists($id)) {
//                $data = $this->CashIn->find("first", [
//                    "conditions" => [
//                        "CashIn.id" => $id
//                    ],
//                    "contain" => [
//                        "CashInType",
//                        "InitialBalance",
//                        "Creator" => [
//                            "Account" => [
//                                "Biodata"
//                            ],
//                            "Department",
//                            "Office"
//                        ],
//                        "Partner"
//                    ]
//                ]);
//                $this->data = $data;
//            } else {
//                throw new NotFoundException(__("Data Not Found"));
//            }
//        } else {
//            throw new NotFoundException(__("ID IS NULL"));
//        }
//    }

    function generateCashInNumber() {
        $cashType = "";
        $inc_id = 1;
        $m = date('m');
        $mRoman = romanic_number($m);
        $Y = date('Y');
        $testCode = "KAS-MASUK/$mRoman/$Y/[0-9]{3}";
        $lastRecord = $this->CashIn->find('first', array('conditions' => array('and' => array("CashIn.cash_in_number regexp" => $testCode)), 'order' => array('CashIn.id' => 'DESC')));
        if (!empty($lastRecord)) {
            $current = explode("/", $lastRecord['CashIn']['cash_in_number']);
            $inc_id += $current[count($current) - 1];
        }
        $inc_id = sprintf("%03d", $inc_id);
        $kode = "KAS-MASUK/$mRoman/$Y/$inc_id";
        return $kode;
    }

    function admin_list() {
        $this->autoRender = false;
        $conds = [];
        if (isset($this->request->query['q'])) {
            $q = $this->request->query['q'];
            $conds[] = array(
                "or" => array(
                    "CashIn.cash_in_number like" => "%$q%",
            ));
        }
        $suggestions = ClassRegistry::init("CashIn")->find("all", array(
            "conditions" => $conds,
            "limit"=>10,
        ));
        $result = [];
        foreach ($suggestions as $item) {
            if (!empty($item)) {
                if ($item['Creator']['branch_office_id'] == $this->Session->read("credential.admin.Employee.branch_office_id")) {
                    $result[] = [
                        "id" => $item['CashIn']['id'],
                        "cash_in_number" => @$item['CashIn']['cash_in_number'],
                        "amount" => @$item['CashIn']['amount'],
                        "created_datetime" => @$item['CashIn']['created_datetime']
                    ];
                }
            }
        }
        echo json_encode($result);
    }

    function admin_print_cash_in_receipt($id = null) {
        $rows = $this->{ Inflector::classify($this->name) }->find('first', array(
            'conditions' => array(
                "CashIn.id" => $id,
            ),
            "contain" => [
                "GeneralEntryType"
            ]
        ));
        $kode = ClassRegistry::init("GeneralEntryType")->find("first", [
            "conditions" => [
                "GeneralEntryType.id" => $rows['CashIn']['general_entry_type_id']
            ]
        ]);
        $data = array(
            'title' => 'Bukti Kas Masuk',
            'rows' => $rows,
        );
        $this->set(compact('data', 'kode'));
        $this->_activePrint(["print"], "print_cash_in_receipt", "print_no_border");
    }

    function admin_get_parent($general_entry_type_id) {
        $this->autoRender = false;
        if (!empty($general_entry_type_id)) {
            if ($this->request->is("GET")) {
                $data = ClassRegistry::init("GeneralEntryType")->find("first", [
                    "conditions" => [
                        "GeneralEntryType.id" => $general_entry_type_id
                    ],
                ]);
                return json_encode($data);
            } else {
                return json_encode($this->_generateStatusCode(400));
            }
        }
    }

    function admin_get_nominal_cash($initial_balance_id) {
        $this->autoRender = false;
        if (!empty($initial_balance_id)) {
            if ($this->request->is("GET")) {
                $data = ClassRegistry::init("InitialBalance")->find("first", [
                    "conditions" => [
                        "InitialBalance.id" => $initial_balance_id
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
