<?php

App::uses('AppController', 'Controller');

class CashDisbursementsController extends AppController {

    var $name = "CashDisbursements";
    var $disabledAction = array(
    );
    var $contain = [
        "CashDisbursementDetail" => [
            "AssetFile",
        ],
        "InitialBalance" => [
            "GeneralEntryType"
        ],
        "Creator" => [
            "Account" => [
                "Biodata",
            ],
        ],
        "BranchOffice",
        "GeneralEntryType",
        "TransactionCurrencyType"
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
        $this->_activePrint(func_get_args(), "data_kas_keluar");
        $this->_setPeriodeLaporanDate("awal_CashDisbursement_created_datetime", "akhir_CashDisbursement_created_datetime");
        parent::admin_index();
    }

    function admin_index_multiple_coa() {
        $this->_activePrint(func_get_args(), "data_kas_keluar");
        $this->_setPeriodeLaporanDate("awal_CashDisbursement_created_datetime", "akhir_CashDisbursement_created_datetime");
        parent::admin_index();
    }

    function view_cash_disbursement($id = null) {
        if ($this->CashDisbursement->exists($id)) {
            $this->autoRender = false;
            if ($this->request->is("GET")) {
                $data = $this->CashDisbursement->find("first", ["conditions" => ["CashDisbursement.id" => $id]]);
                return json_encode($data);
            } else {
                return json_encode($this->_generateStatusCode(400));
            }
        } else {
            throw new NotFoundException(__("Data Not Found"));
        }
    }

    function _options() {
        $generalEntryTypes = ClassRegistry::init("GeneralEntryType")->find("list", [
            "fields" => [
                "GeneralEntryType.id",
                "GeneralEntryType.name",
                "Parent.name"
            ],
            "contain" => [
                "Parent"
            ],
            "order" => "GeneralEntryType.name"
        ]);
        $generalEntryTypes['Kategori Utama'] = $generalEntryTypes[0];
        unset($generalEntryTypes[0]);
        $this->set(compact("generalEntryTypes"));

        $generalEntryTypesMulitpleCOA = ClassRegistry::init("GeneralEntryType")->find("all", [
            "contain" => [
                "Parent",
                "Child"
            ],
            "order" => "GeneralEntryType.name"
        ]);
        $multipleCOA = [];
        foreach ($generalEntryTypesMulitpleCOA as $coa) {
            $child = [];
            if (!empty($coa['Child'])) {
                foreach ($coa['Child'] as $temp) {
                    $child[] = [
                        "id" => $temp['id'],
                        'label' => $temp['name']
                    ];
                }
            }
            $multipleCOA[] = [
                "parent" => $coa['GeneralEntryType']['name'],
                'child' => $child
            ];
        }
        $this->set(compact('multipleCOA'));
        
        $this->set("initialBalances", ClassRegistry::init("InitialBalance")->find("list", [
                    "fields" => [
                        "InitialBalance.id",
                        "GeneralEntryType.name"
                    ],
                    "conditions" => [
                        "GeneralEntryType.parent_id" => [2, 3, 4],
                        "GeneralEntryType.currency_id" => 1
                    ],
                    "contain" => [
                        "GeneralEntryType"
                    ]
        ]));
        $this->set("initialBalanceDollars", ClassRegistry::init("InitialBalance")->find("list", [
                    "fields" => [
                        "InitialBalance.id",
                        "GeneralEntryType.name"
                    ],
                    "conditions" => [
                        "GeneralEntryType.parent_id" => [2, 3, 4],
                        "GeneralEntryType.currency_id" => 2
                    ],
                    "contain" => [
                        "GeneralEntryType"
                    ]
        ]));
        $this->set("branchOffices", $this->CashDisbursement->Creator->BranchOffice->find("list", array("fields" => array("BranchOffice.id", "BranchOffice.name"))));
        $this->set("transactionCurrencyTypes", $this->CashDisbursement->TransactionCurrencyType->find('list', ['fields' => ['TransactionCurrencyType.id', 'TransactionCurrencyType.name']]));
    }

    function admin_add() {
        if ($this->request->is("post")) {
            $this->{ Inflector::classify($this->name) }->set($this->data);
            if ($this->data['CashDisbursement']['transaction_currency_type_id'] == 1) {
                $this->redirect(array('action' => 'admin_add_internal'));
            } else {
                $this->redirect(array('action' => 'admin_add_external'));
            }
        }
    }

    function admin_add_multiple_coa() {
        if ($this->request->is("post")) {
            $this->{ Inflector::classify($this->name) }->set($this->data);
            if ($this->data['CashDisbursement']['transaction_currency_type_id'] == 1) {
                $this->redirect(array('action' => 'admin_add_internal_multiple_coa'));
            } else {
                $this->redirect(array('action' => 'admin_add_external_multiple_coa'));
            }
        }
    }

    function admin_add_internal() {
        if ($this->request->is("post")) {
            $total = 0;
            $this->{ Inflector::classify($this->name) }->set($this->data);
            if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                $this->CashDisbursement->_numberSeperatorRemover();
                $this->{ Inflector::classify($this->name) }->data['CashDisbursement']['branch_office_id'] = $this->Session->read("credential.admin.Employee.branch_office_id");

                foreach ($this->data['CashDisbursementDetail'] as $k => $details) {
                    if (!empty($details['gambar']['name'])) {
                        App::import("Vendor", "qqUploader");
                        $allowedExt = array("jpg", "jpeg", "png");
                        $size = 10 * 1024 * 1024;
                        $uploader = new qqFileUploader($allowedExt, $size, $this->CashDisbursement->data['CashDisbursementDetail'][$k]['gambar'], true);
                        $result = $uploader->handleUpload("kaskeluar" . DS);
                        switch ($result['status']) {
                            case 206:
                                $this->CashDisbursement->data['CashDisbursementDetail'][$k]['AssetFile'] = array(
                                    "folder" => $result['data']['folder'],
                                    "filename" => $result['data']['fileName'],
                                    "ext" => $result['data']['ext'],
                                    "is_private" => true,
                                );
                                break;
                        }
                    }
                    unset($this->CashDisbursement->data['CashDisbursementDetail'][$k]['gambar']);
                }
                $this->CashDisbursement->data['CashDisbursement']['cash_disbursement_number'] = $this->generateCashDisbursementNumber();

                /* update the balance */
                $dataInitialBalance = ClassRegistry::init("InitialBalance")->find("first", [
                    "conditions" => [
                        "InitialBalance.id" => $this->data['CashDisbursement']['initial_balance_id']
                    ]
                ]);

                /* updating to the General Entries Table */
                $referenceNumber = $this->generateCashDisbursementNumber();
                $totalExpenses = 0;
                foreach ($this->CashDisbursement->data['CashDisbursementDetail'] as $details) {
                    $totalExpenses += $details['amount'];
                }
                $this->CashDisbursement->data['InitialBalance']['id'] = $this->data['CashDisbursement']['initial_balance_id'];
                $this->CashDisbursement->data['InitialBalance']['nominal'] = $dataInitialBalance['InitialBalance']['nominal'] - $totalExpenses;
                ClassRegistry::init("GeneralEntryType")->decreaseLatestBalance($dataInitialBalance['GeneralEntryType']['id'], $totalExpenses);
                ClassRegistry::init("GeneralEntryType")->increaseLatestBalance($this->data['CashDisbursement']['general_entry_type_id'], $totalExpenses);

                $dataGeneralEntryType = ClassRegistry::init("GeneralEntryType")->find("first", [
                    "conditions" => [
                        "GeneralEntryType.id" => $this->data['CashDisbursement']['general_entry_type_id']
                    ]
                ]);
                $this->CashDisbursement->data['GeneralEntry'][0]['reference_number'] = $referenceNumber;
                $this->CashDisbursement->data['GeneralEntry'][0]['transaction_name'] = $dataGeneralEntryType['GeneralEntryType']['name'];
                $this->CashDisbursement->data['GeneralEntry'][0]['debit'] = $totalExpenses;
                $this->CashDisbursement->data['GeneralEntry'][0]['transaction_date'] = date("Y-m-d");
                $this->CashDisbursement->data['GeneralEntry'][0]['transaction_type_id'] = 2;
                $this->CashDisbursement->data['GeneralEntry'][0]['general_entry_type_id'] = $dataGeneralEntryType['GeneralEntryType']['id'];
                $this->CashDisbursement->data['GeneralEntry'][0]['initial_balance'] = $dataInitialBalance['InitialBalance']['nominal'];
                $this->CashDisbursement->data['GeneralEntry'][0]['mutation_balance'] = $this->CashDisbursement->data['InitialBalance']['nominal'];
                $this->CashDisbursement->data['GeneralEntry'][0]['initial_balance_id'] = $dataInitialBalance['InitialBalance']['id'];
                $this->CashDisbursement->data['GeneralEntry'][0]['general_entry_account_type_id'] = 1;
                $this->CashDisbursement->data['GeneralEntry'][1]['reference_number'] = $referenceNumber;
                $this->CashDisbursement->data['GeneralEntry'][1]['transaction_name'] = $dataInitialBalance['GeneralEntryType']['name'];
                $this->CashDisbursement->data['GeneralEntry'][1]['credit'] = $totalExpenses;
                $this->CashDisbursement->data['GeneralEntry'][1]['transaction_date'] = date("Y-m-d");
                $this->CashDisbursement->data['GeneralEntry'][1]['transaction_type_id'] = 2;
                $this->CashDisbursement->data['GeneralEntry'][1]['general_entry_type_id'] = $dataInitialBalance['GeneralEntryType']['id'];
                $this->CashDisbursement->data['GeneralEntry'][1]['initial_balance'] = $dataInitialBalance['InitialBalance']['nominal'];
                $this->CashDisbursement->data['GeneralEntry'][1]['mutation_balance'] = $this->CashDisbursement->data['InitialBalance']['nominal'];
                $this->CashDisbursement->data['GeneralEntry'][1]['initial_balance_id'] = $dataInitialBalance['InitialBalance']['id'];
                $this->CashDisbursement->data['GeneralEntry'][1]['general_entry_account_type_id'] = 1;

                /* updating to the Transaction Mutation Table */
                $this->CashDisbursement->data['TransactionMutation']['reference_number'] = $referenceNumber;
                $this->CashDisbursement->data['TransactionMutation']['transaction_name'] = $this->data['CashDisbursement']['note'];
                $this->CashDisbursement->data['TransactionMutation']['credit'] = $totalExpenses;
                $this->CashDisbursement->data['TransactionMutation']['transaction_date'] = date("Y-m-d");
                $this->CashDisbursement->data['TransactionMutation']['transaction_type_id'] = 2;
                $this->CashDisbursement->data['TransactionMutation']['initial_balance'] = $dataInitialBalance['InitialBalance']['nominal'];
                $this->CashDisbursement->data['TransactionMutation']['mutation_balance'] = $this->CashDisbursement->data['InitialBalance']['nominal'];
                $this->CashDisbursement->data['TransactionMutation']['initial_balance_id'] = $dataInitialBalance['InitialBalance']['id'];

                $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
                $this->Session->setFlash(__("Data berhasil disimpan"), 'default', array(), 'success');
                $this->redirect(array('action' => 'admin_index'));
            } else {
                $this->validationErrors = $this->{ Inflector::classify($this->name) }->validationErrors;
                $this->Session->setFlash(__("Harap mengecek kembali kesalahan dibawah."), 'default', array(), 'danger');
            }
        }
    }

    function admin_add_internal_multiple_coa() {
        if ($this->request->is("post")) {
            $total = 0;
            $this->{ Inflector::classify($this->name) }->set($this->data);
            if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                $this->CashDisbursement->_numberSeperatorRemover();
                $this->{ Inflector::classify($this->name) }->data['CashDisbursement']['branch_office_id'] = $this->Session->read("credential.admin.Employee.branch_office_id");

                foreach ($this->data['CashDisbursementDetail'] as $k => $details) {
                    if (!empty($details['gambar']['name'])) {
                        App::import("Vendor", "qqUploader");
                        $allowedExt = array("jpg", "jpeg", "png");
                        $size = 10 * 1024 * 1024;
                        $uploader = new qqFileUploader($allowedExt, $size, $this->CashDisbursement->data['CashDisbursementDetail'][$k]['gambar'], true);
                        $result = $uploader->handleUpload("kaskeluar" . DS);
                        switch ($result['status']) {
                            case 206:
                                $this->CashDisbursement->data['CashDisbursementDetail'][$k]['AssetFile'] = array(
                                    "folder" => $result['data']['folder'],
                                    "filename" => $result['data']['fileName'],
                                    "ext" => $result['data']['ext'],
                                    "is_private" => true,
                                );
                                break;
                        }
                    }
                    unset($this->CashDisbursement->data['CashDisbursementDetail'][$k]['gambar']);
                }
                $this->CashDisbursement->data['CashDisbursement']['cash_disbursement_number'] = $this->generateCashDisbursementNumber();

                /* update the balance */
                $dataInitialBalance = ClassRegistry::init("InitialBalance")->find("first", [
                    "conditions" => [
                        "InitialBalance.id" => $this->data['CashDisbursement']['initial_balance_id']
                    ]
                ]);
                
                $note = strip_tags($this->CashDisbursement->data['CashDisbursement']['note']);
                
                /* updating to the General Entries Table */
                $referenceNumber = $this->generateCashDisbursementNumber();
                $totalExpenses = 0;
                $index = 0;
                $temp = $dataInitialBalance['InitialBalance']['nominal'];
                foreach ($this->CashDisbursement->data['CashDisbursementDetail'] as $details) {
                    $totalExpenses += $details['amount'];
                    ClassRegistry::init("GeneralEntryType")->increaseLatestBalance($details['general_entry_type_id'], $details['amount']);

                    $dataGeneralEntryType = ClassRegistry::init("GeneralEntryType")->find("first", [
                        "conditions" => [
                            "GeneralEntryType.id" => $details['general_entry_type_id']
                        ]
                    ]);
                    $this->CashDisbursement->data['GeneralEntry'][$index]['reference_number'] = $referenceNumber;
                    $this->CashDisbursement->data['GeneralEntry'][$index]['transaction_name'] = $dataGeneralEntryType['GeneralEntryType']['name'];
                    $this->CashDisbursement->data['GeneralEntry'][$index]['debit'] = $details['amount'];
                    $this->CashDisbursement->data['GeneralEntry'][$index]['transaction_date'] = $this->CashDisbursement->data['CashDisbursement']['created_datetime'];
                    $this->CashDisbursement->data['GeneralEntry'][$index]['transaction_type_id'] = 2;
                    $this->CashDisbursement->data['GeneralEntry'][$index]['general_entry_type_id'] = $dataGeneralEntryType['GeneralEntryType']['id'];
                    $this->CashDisbursement->data['GeneralEntry'][$index]['initial_balance'] = $temp;
                    $temp -= $details['amount'];
                    $this->CashDisbursement->data['GeneralEntry'][$index]['mutation_balance'] = $temp;
                    $this->CashDisbursement->data['GeneralEntry'][$index]['initial_balance_id'] = $dataInitialBalance['InitialBalance']['id'];
                    $this->CashDisbursement->data['GeneralEntry'][$index]['general_entry_account_type_id'] = 1;
                    $index++;
                }
                $this->CashDisbursement->data['InitialBalance']['id'] = $this->data['CashDisbursement']['initial_balance_id'];
                $this->CashDisbursement->data['InitialBalance']['nominal'] = $dataInitialBalance['InitialBalance']['nominal'] - $totalExpenses;

                ClassRegistry::init("GeneralEntryType")->decreaseLatestBalance($dataInitialBalance['GeneralEntryType']['id'], $totalExpenses);

                $this->CashDisbursement->data['GeneralEntry'][$index]['reference_number'] = $referenceNumber;
                $this->CashDisbursement->data['GeneralEntry'][$index]['transaction_name'] = $dataInitialBalance['GeneralEntryType']['name'] . " - " . $note;
                $this->CashDisbursement->data['GeneralEntry'][$index]['credit'] = $totalExpenses;
                $this->CashDisbursement->data['GeneralEntry'][$index]['transaction_date'] = $this->CashDisbursement->data['CashDisbursement']['created_datetime'];
                $this->CashDisbursement->data['GeneralEntry'][$index]['transaction_type_id'] = 2;
                $this->CashDisbursement->data['GeneralEntry'][$index]['general_entry_type_id'] = $dataInitialBalance['GeneralEntryType']['id'];
                $this->CashDisbursement->data['GeneralEntry'][$index]['initial_balance'] = $dataInitialBalance['InitialBalance']['nominal'];
                $this->CashDisbursement->data['GeneralEntry'][$index]['mutation_balance'] = $this->CashDisbursement->data['InitialBalance']['nominal'];
                $this->CashDisbursement->data['GeneralEntry'][$index]['initial_balance_id'] = $dataInitialBalance['InitialBalance']['id'];
                $this->CashDisbursement->data['GeneralEntry'][$index]['general_entry_account_type_id'] = 1;

                /* updating to the Transaction Mutation Table */
                $this->CashDisbursement->data['TransactionMutation']['reference_number'] = $referenceNumber;
                $this->CashDisbursement->data['TransactionMutation']['transaction_name'] = $note;
                $this->CashDisbursement->data['TransactionMutation']['credit'] = $totalExpenses;
                $this->CashDisbursement->data['TransactionMutation']['transaction_date'] = $this->CashDisbursement->data['CashDisbursement']['created_datetime'];
                $this->CashDisbursement->data['TransactionMutation']['transaction_type_id'] = 2;
                $this->CashDisbursement->data['TransactionMutation']['initial_balance'] = $dataInitialBalance['InitialBalance']['nominal'];
                $this->CashDisbursement->data['TransactionMutation']['mutation_balance'] = $this->CashDisbursement->data['InitialBalance']['nominal'];
                $this->CashDisbursement->data['TransactionMutation']['initial_balance_id'] = $dataInitialBalance['InitialBalance']['id'];

                $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
                $this->Session->setFlash(__("Data berhasil disimpan"), 'default', array(), 'success');
                $this->redirect(array('action' => 'admin_index_multiple_coa'));
            } else {
                $this->validationErrors = $this->{ Inflector::classify($this->name) }->validationErrors;
                $this->Session->setFlash(__("Harap mengecek kembali kesalahan dibawah."), 'default', array(), 'danger');
            }
        }
    }

    function admin_edit_internal($id = null) {
        if (!$this->{ Inflector::classify($this->name) }->exists($id)) {
            throw new NotFoundException(__('Data tidak ditemukan'));
        } else {
            if ($this->request->is("post") || $this->request->is("put")) {
                $this->{ Inflector::classify($this->name) }->set($this->data);
                $this->{ Inflector::classify($this->name) }->data[Inflector::classify($this->name)]['id'] = $id;
                if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                    if (!is_null($id)) {
                        $this->CashDisbursement->_numberSeperatorRemover();
                        foreach ($this->data['CashDisbursementDetail'] as $k => $details) {
                            if (isset($details['id']) && !empty($details['id'])) {
                                $this->CashDisbursement->CashDisbursementDetail->data['CashDisbursementDetail']['id'] = $details['id'];
                            }
                            if (!empty($details)) {
                                App::import("Vendor", "qqUploader");
                                $allowedExt = array("jpg", "jpeg", "png");
                                $size = 10 * 1024 * 1024;
                                $uploader = new qqFileUploader($allowedExt, $size, $this->CashDisbursement->data['CashDisbursementDetail'][$k]['gambar'], true);
                                $result = $uploader->handleUpload("kaskeluar" . DS);
                                switch ($result['status']) {
                                    case 206:
                                        $this->CashDisbursement->data['CashDisbursementDetail'][$k]['AssetFile'] = array(
                                            "folder" => $result['data']['folder'],
                                            "filename" => $result['data']['fileName'],
                                            "ext" => $result['data']['ext'],
                                            "is_private" => true,
                                        );
                                        break;
                                }
                                unset($this->CashDisbursement->data['CashDisbursementDetail'][$k]['gambar']);
                            }
                        }
                        $this->CashDisbursement->_deleteableHasmany();
                        $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
                        $this->Session->setFlash(__("Data berhasil diubah"), 'default', array(), 'success');
                        $this->redirect(array('action' => 'admin_index'));
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

    function admin_add_external() {
        if ($this->request->is("post")) {
            $total = 0;
            $this->{ Inflector::classify($this->name) }->set($this->data);
            if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                $this->CashDisbursement->_numberSeperatorRemover();
                $this->{ Inflector::classify($this->name) }->data['CashDisbursement']['branch_office_id'] = $this->Session->read("credential.admin.Employee.branch_office_id");

                foreach ($this->data['CashDisbursementDetail'] as $k => $details) {
                    if (!empty($details['gambar']['name'])) {
                        App::import("Vendor", "qqUploader");
                        $allowedExt = array("jpg", "jpeg", "png");
                        $size = 10 * 1024 * 1024;
                        $uploader = new qqFileUploader($allowedExt, $size, $this->CashDisbursement->data['CashDisbursementDetail'][$k]['gambar'], true);
                        $result = $uploader->handleUpload("kaskeluar" . DS);
                        switch ($result['status']) {
                            case 206:
                                $this->CashDisbursement->data['CashDisbursementDetail'][$k]['AssetFile'] = array(
                                    "folder" => $result['data']['folder'],
                                    "filename" => $result['data']['fileName'],
                                    "ext" => $result['data']['ext'],
                                    "is_private" => true,
                                );
                                break;
                        }
                    }
                    unset($this->CashDisbursement->data['CashDisbursementDetail'][$k]['gambar']);
                }
                $this->CashDisbursement->data['CashDisbursement']['cash_disbursement_number'] = $this->generateCashDisbursementNumber();

                /* update the balance */
                $dataInitialBalance = ClassRegistry::init("InitialBalance")->find("first", [
                    "conditions" => [
                        "InitialBalance.id" => $this->data['CashDisbursement']['initial_balance_id']
                    ]
                ]);

                /* updating to the General Entries Table */
                $referenceNumber = $this->generateCashDisbursementNumber();
                $totalExpenses = 0;
                foreach ($this->CashDisbursement->data['CashDisbursementDetail'] as $details) {
                    $totalExpenses += $details['amount'];
                }
                $this->CashDisbursement->data['InitialBalance']['id'] = $this->data['CashDisbursement']['initial_balance_id'];
                $this->CashDisbursement->data['InitialBalance']['nominal'] = $dataInitialBalance['InitialBalance']['nominal'] - $totalExpenses;

                ClassRegistry::init("GeneralEntryType")->decreaseLatestBalance($dataInitialBalance['GeneralEntryType']['id'], $totalExpenses);
                ClassRegistry::init("GeneralEntryType")->increaseLatestBalance($this->data['CashDisbursement']['general_entry_type_id'], $totalExpenses);

                $dataGeneralEntryType = ClassRegistry::init("GeneralEntryType")->find("first", [
                    "conditions" => [
                        "GeneralEntryType.id" => $this->data['CashDisbursement']['general_entry_type_id']
                    ]
                ]);
                $this->CashDisbursement->data['GeneralEntry'][0]['reference_number'] = $referenceNumber;
                $this->CashDisbursement->data['GeneralEntry'][0]['transaction_name'] = $dataGeneralEntryType['GeneralEntryType']['name'];
                $this->CashDisbursement->data['GeneralEntry'][0]['debit'] = $totalExpenses;
                $this->CashDisbursement->data['GeneralEntry'][0]['transaction_date'] = date("Y-m-d");
                $this->CashDisbursement->data['GeneralEntry'][0]['transaction_type_id'] = 2;
                $this->CashDisbursement->data['GeneralEntry'][0]['general_entry_type_id'] = $dataGeneralEntryType['GeneralEntryType']['id'];
                $this->CashDisbursement->data['GeneralEntry'][0]['initial_balance'] = $dataInitialBalance['InitialBalance']['nominal'];
                $this->CashDisbursement->data['GeneralEntry'][0]['mutation_balance'] = $this->CashDisbursement->data['InitialBalance']['nominal'];
                $this->CashDisbursement->data['GeneralEntry'][0]['initial_balance_id'] = $dataInitialBalance['InitialBalance']['id'];
                $this->CashDisbursement->data['GeneralEntry'][0]['general_entry_account_type_id'] = 1;
                $this->CashDisbursement->data['GeneralEntry'][1]['reference_number'] = $referenceNumber;
                $this->CashDisbursement->data['GeneralEntry'][1]['transaction_name'] = $dataInitialBalance['GeneralEntryType']['name'];
                $this->CashDisbursement->data['GeneralEntry'][1]['credit'] = $totalExpenses;
                $this->CashDisbursement->data['GeneralEntry'][1]['transaction_date'] = date("Y-m-d");
                $this->CashDisbursement->data['GeneralEntry'][1]['transaction_type_id'] = 2;
                $this->CashDisbursement->data['GeneralEntry'][1]['general_entry_type_id'] = $dataInitialBalance['GeneralEntryType']['id'];
                $this->CashDisbursement->data['GeneralEntry'][1]['initial_balance'] = $dataInitialBalance['InitialBalance']['nominal'];
                $this->CashDisbursement->data['GeneralEntry'][1]['mutation_balance'] = $this->CashDisbursement->data['InitialBalance']['nominal'];
                $this->CashDisbursement->data['GeneralEntry'][1]['initial_balance_id'] = $dataInitialBalance['InitialBalance']['id'];
                $this->CashDisbursement->data['GeneralEntry'][1]['general_entry_account_type_id'] = 1;

                /* updating to the Transaction Mutation Table */
                $this->CashDisbursement->data['TransactionMutation']['reference_number'] = $referenceNumber;
                $this->CashDisbursement->data['TransactionMutation']['transaction_name'] = $this->data['CashDisbursement']['note'];
                $this->CashDisbursement->data['TransactionMutation']['credit'] = $totalExpenses;
                $this->CashDisbursement->data['TransactionMutation']['transaction_date'] = date("Y-m-d");
                $this->CashDisbursement->data['TransactionMutation']['transaction_type_id'] = 2;
                $this->CashDisbursement->data['TransactionMutation']['initial_balance'] = $dataInitialBalance['InitialBalance']['nominal'];
                $this->CashDisbursement->data['TransactionMutation']['mutation_balance'] = $this->CashDisbursement->data['InitialBalance']['nominal'];
                $this->CashDisbursement->data['TransactionMutation']['initial_balance_id'] = $dataInitialBalance['InitialBalance']['id'];

                $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
                $this->Session->setFlash(__("Data berhasil disimpan"), 'default', array(), 'success');
                $this->redirect(array('action' => 'admin_index'));
            } else {
                $this->validationErrors = $this->{ Inflector::classify($this->name) }->validationErrors;
                $this->Session->setFlash(__("Harap mengecek kembali kesalahan dibawah."), 'default', array(), 'danger');
            }
        }
    }
    
    function admin_add_external_multiple_coa() {
        if ($this->request->is("post")) {
            $total = 0;
            $this->{ Inflector::classify($this->name) }->set($this->data);
            if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                $this->CashDisbursement->_numberSeperatorRemover();
                $this->{ Inflector::classify($this->name) }->data['CashDisbursement']['branch_office_id'] = $this->Session->read("credential.admin.Employee.branch_office_id");

                foreach ($this->data['CashDisbursementDetail'] as $k => $details) {
                    if (!empty($details['gambar']['name'])) {
                        App::import("Vendor", "qqUploader");
                        $allowedExt = array("jpg", "jpeg", "png");
                        $size = 10 * 1024 * 1024;
                        $uploader = new qqFileUploader($allowedExt, $size, $this->CashDisbursement->data['CashDisbursementDetail'][$k]['gambar'], true);
                        $result = $uploader->handleUpload("kaskeluar" . DS);
                        switch ($result['status']) {
                            case 206:
                                $this->CashDisbursement->data['CashDisbursementDetail'][$k]['AssetFile'] = array(
                                    "folder" => $result['data']['folder'],
                                    "filename" => $result['data']['fileName'],
                                    "ext" => $result['data']['ext'],
                                    "is_private" => true,
                                );
                                break;
                        }
                    }
                    unset($this->CashDisbursement->data['CashDisbursementDetail'][$k]['gambar']);
                }
                $this->CashDisbursement->data['CashDisbursement']['cash_disbursement_number'] = $this->generateCashDisbursementNumber();
                
                $note = strip_tags($this->CashDisbursement->data['CashDisbursement']['note']);

                /* update the balance */
                $dataInitialBalance = ClassRegistry::init("InitialBalance")->find("first", [
                    "conditions" => [
                        "InitialBalance.id" => $this->data['CashDisbursement']['initial_balance_id']
                    ]
                ]);

                /* updating to the General Entries Table */
                $referenceNumber = $this->generateCashDisbursementNumber();
                $totalExpenses = 0;
                $index = 0;
                $temp = $dataInitialBalance['InitialBalance']['nominal'];
                foreach ($this->CashDisbursement->data['CashDisbursementDetail'] as $details) {
                    $totalExpenses += $details['amount'];
                    ClassRegistry::init("GeneralEntryType")->increaseLatestBalance($details['general_entry_type_id'], $details['amount']);

                    $dataGeneralEntryType = ClassRegistry::init("GeneralEntryType")->find("first", [
                        "conditions" => [
                            "GeneralEntryType.id" => $details['general_entry_type_id']
                        ]
                    ]);
                    $this->CashDisbursement->data['GeneralEntry'][$index]['reference_number'] = $referenceNumber;
                    $this->CashDisbursement->data['GeneralEntry'][$index]['transaction_name'] = $dataGeneralEntryType['GeneralEntryType']['name'];
                    $this->CashDisbursement->data['GeneralEntry'][$index]['debit'] = $details['amount'];
                    $this->CashDisbursement->data['GeneralEntry'][$index]['transaction_date'] = $this->CashDisbursement->data['CashDisbursement']['created_datetime'];
                    $this->CashDisbursement->data['GeneralEntry'][$index]['transaction_type_id'] = 2;
                    $this->CashDisbursement->data['GeneralEntry'][$index]['general_entry_type_id'] = $dataGeneralEntryType['GeneralEntryType']['id'];
                    $this->CashDisbursement->data['GeneralEntry'][$index]['initial_balance'] = $temp;
                    $temp -= $details['amount'];
                    $this->CashDisbursement->data['GeneralEntry'][$index]['mutation_balance'] = $temp;
                    $this->CashDisbursement->data['GeneralEntry'][$index]['initial_balance_id'] = $dataInitialBalance['InitialBalance']['id'];
                    $this->CashDisbursement->data['GeneralEntry'][$index]['general_entry_account_type_id'] = 1;
                    $this->CashDisbursement->data['GeneralEntry'][$index]['exchange_rate'] = $this->CashDisbursement->data['CashDisbursement']['exchange_rate'];
                    $index++;
                }
                $this->CashDisbursement->data['InitialBalance']['id'] = $this->data['CashDisbursement']['initial_balance_id'];
                $this->CashDisbursement->data['InitialBalance']['nominal'] = $dataInitialBalance['InitialBalance']['nominal'] - $totalExpenses;

                ClassRegistry::init("GeneralEntryType")->decreaseLatestBalance($dataInitialBalance['GeneralEntryType']['id'], $totalExpenses);

                $this->CashDisbursement->data['GeneralEntry'][$index]['reference_number'] = $referenceNumber;
                $this->CashDisbursement->data['GeneralEntry'][$index]['transaction_name'] = $dataInitialBalance['GeneralEntryType']['name'] . " - " . $note;
                $this->CashDisbursement->data['GeneralEntry'][$index]['credit'] = $totalExpenses;
                $this->CashDisbursement->data['GeneralEntry'][$index]['transaction_date'] = $this->CashDisbursement->data['CashDisbursement']['created_datetime'];
                $this->CashDisbursement->data['GeneralEntry'][$index]['transaction_type_id'] = 2;
                $this->CashDisbursement->data['GeneralEntry'][$index]['general_entry_type_id'] = $dataInitialBalance['GeneralEntryType']['id'];
                $this->CashDisbursement->data['GeneralEntry'][$index]['initial_balance'] = $dataInitialBalance['InitialBalance']['nominal'];
                $this->CashDisbursement->data['GeneralEntry'][$index]['mutation_balance'] = $this->CashDisbursement->data['InitialBalance']['nominal'];
                $this->CashDisbursement->data['GeneralEntry'][$index]['initial_balance_id'] = $dataInitialBalance['InitialBalance']['id'];
                $this->CashDisbursement->data['GeneralEntry'][$index]['general_entry_account_type_id'] = 1;
                $this->CashDisbursement->data['GeneralEntry'][$index]['exchange_rate'] = $this->CashDisbursement->data['CashDisbursement']['exchange_rate'];

                /* updating to the Transaction Mutation Table */
                $this->CashDisbursement->data['TransactionMutation']['reference_number'] = $referenceNumber;
                $this->CashDisbursement->data['TransactionMutation']['transaction_name'] = $note;
                $this->CashDisbursement->data['TransactionMutation']['credit'] = $totalExpenses;
                $this->CashDisbursement->data['TransactionMutation']['transaction_date'] = $this->CashDisbursement->data['CashDisbursement']['created_datetime'];
                $this->CashDisbursement->data['TransactionMutation']['transaction_type_id'] = 2;
                $this->CashDisbursement->data['TransactionMutation']['initial_balance'] = $dataInitialBalance['InitialBalance']['nominal'];
                $this->CashDisbursement->data['TransactionMutation']['mutation_balance'] = $this->CashDisbursement->data['InitialBalance']['nominal'];
                $this->CashDisbursement->data['TransactionMutation']['initial_balance_id'] = $dataInitialBalance['InitialBalance']['id'];

                $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
                $this->Session->setFlash(__("Data berhasil disimpan"), 'default', array(), 'success');
                $this->redirect(array('action' => 'admin_index_multiple_coa'));
            } else {
                $this->validationErrors = $this->{ Inflector::classify($this->name) }->validationErrors;
                $this->Session->setFlash(__("Harap mengecek kembali kesalahan dibawah."), 'default', array(), 'danger');
            }
        }
    }

    function admin_edit_external($id = null) {
        if (!$this->{ Inflector::classify($this->name) }->exists($id)) {
            throw new NotFoundException(__('Data tidak ditemukan'));
        } else {
            if ($this->request->is("post") || $this->request->is("put")) {
                $this->{ Inflector::classify($this->name) }->set($this->data);
                $this->{ Inflector::classify($this->name) }->data[Inflector::classify($this->name)]['id'] = $id;
                if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                    if (!is_null($id)) {
                        $this->CashDisbursement->_numberSeperatorRemover();
                        foreach ($this->data['CashDisbursementDetail'] as $k => $details) {
                            if (isset($details['id']) && !empty($details['id'])) {
                                $this->CashDisbursement->CashDisbursementDetail->data['CashDisbursementDetail']['id'] = $details['id'];
                            }
                            if (!empty($details)) {
                                App::import("Vendor", "qqUploader");
                                $allowedExt = array("jpg", "jpeg", "png");
                                $size = 10 * 1024 * 1024;
                                $uploader = new qqFileUploader($allowedExt, $size, $this->CashDisbursement->data['CashDisbursementDetail'][$k]['gambar'], true);
                                $result = $uploader->handleUpload("kaskeluar" . DS);
                                switch ($result['status']) {
                                    case 206:
                                        $this->CashDisbursement->data['CashDisbursementDetail'][$k]['AssetFile'] = array(
                                            "folder" => $result['data']['folder'],
                                            "filename" => $result['data']['fileName'],
                                            "ext" => $result['data']['ext'],
                                            "is_private" => true,
                                        );
                                        break;
                                }
                                unset($this->CashDisbursement->data['CashDisbursementDetail'][$k]['gambar']);
                            }
                        }
                        $this->CashDisbursement->_deleteableHasmany();
                        $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
                        $this->Session->setFlash(__("Data berhasil diubah"), 'default', array(), 'success');
                        $this->redirect(array('action' => 'admin_index'));
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

    function generateCashDisbursementNumber() {
        $inc_id = 1;
        $m = date('m');
        $mRoman = romanic_number($m);
        $Y = date('Y');
        $testCode = "KAS-KELUAR/$mRoman/$Y/[0-9]{3}";
        $lastRecord = $this->CashDisbursement->find('first', array('conditions' => array('and' => array("CashDisbursement.cash_disbursement_number regexp" => $testCode)), 'order' => array('CashDisbursement.id' => 'DESC')));
        if (!empty($lastRecord)) {
            $current = explode("/", $lastRecord['CashDisbursement']['cash_disbursement_number']);
            $inc_id += $current[count($current) - 1];
        }
        $inc_id = sprintf("%03d", $inc_id);
        $kode = "KAS-KELUAR/$mRoman/$Y/$inc_id";
        return $kode;
    }

    function admin_view($id = null) {
        $this->{ Inflector::classify($this->name) }->id = $id;
        $this->CashDisbursement->data['CashDisbursement']['id'] = $id;
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
                    "CashDisbursement.cash_disbursement_number like" => "%$q%",
            ));
        }
        $suggestions = ClassRegistry::init("CashDisbursement")->find("all", array(
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
            "limit" => 10,
        ));
        $result = [];
        foreach ($suggestions as $item) {
            if (!empty($item)) {
                if ($item['Creator']['branch_office_id'] == $this->Session->read("credential.admin.Employee.branch_office_id")) {
                    $result[] = [
                        "id" => @$item['CashDisbursement']['id'],
                        "cash_disbursement_number" => @$item['CashDisbursement']['cash_disbursement_number'],
                        "datetime" => @$item['CashDisbursement']['created_datetime'],
                        "fullname" => @$item['Creator']['Account']['Biodata']['full_name'],
                    ];
                }
            }
        }
        echo json_encode($result);
    }

    function view_data_kas_keluar($id) {
        if (!empty($id) && $id != null) {
            $this->autoRender = false;
            $data = ClassRegistry::init("CashDisbursement")->find("first", [
                "conditions" => [
                    "CashDisbursement.id" => $id,
                ],
                "contain" => [
                    "Creator" => [
                        "Account" => [
                            "Biodata",
                        ],
                        "Office",
                    ],
                    "CashDisbursementDetail" => [
                        "AssetFile",
                    ],
                    "InitialBalance" => [
                        "GeneralEntryType"
                    ],
                    "GeneralEntryType"
                ],
            ]);
            return json_encode($data);
        } else {
            throw new NotFoundException(__('Data Not Found'));
        }
    }

    function admin_print_cash_disbursement_receipt($id = null) {
        $rows = $this->{ Inflector::classify($this->name) }->find('first', array(
            'conditions' => array(
                "CashDisbursement.id" => $id,
            ),
            "contain" => [
                "CashDisbursementDetail" => [
                    "GeneralEntryType"
                ],
                "GeneralEntryType"
            ]
        ));
        $data = array(
            'title' => 'Bukti Kas Keluar',
            'rows' => $rows,
        );
        $this->set(compact('data'));
        $this->_activePrint(["print"], "print_cash_disbursement_receipt", "print_no_border");
    }

}
