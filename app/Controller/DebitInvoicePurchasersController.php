<?php

App::uses('AppController', 'Controller');

class DebitInvoicePurchasersController extends AppController {

    var $name = "DebitInvoicePurchasers";
    var $disabledAction = array(
    );
    var $contain = [
        "TransactionEntry" => [
            "BranchOffice",
            "Supplier"
        ],
        "InitialBalance" => [
            "GeneralEntryType"
        ],
        "VerifyStatus",
        "VerifiedBy" => [
            "Account" => [
                "Biodata"
            ]
        ]
    ];

    function beforeFilter() {
        parent::beforeFilter();
        $this->_setPageInfo("admin_index", "");
        $this->_setPageInfo("admin_add", "");
        $this->_setPageInfo("admin_edit", "");
    }

    function beforeRender() {
        $this->_options();
        parent::beforeRender();
    }

    function _options() {
        $this->set("initialBalances", $this->DebitInvoicePurchaser->InitialBalance->find("list", ["fields" => ["InitialBalance.id", "GeneralEntryType.name"], "contain" => ["GeneralEntryType"]]));
        $this->set("verifyStatuses", $this->DebitInvoicePurchaser->VerifyStatus->find("list", ["fields" => ["VerifyStatus.id", "VerifyStatus.name"]]));
        $this->set("branchOffices", $this->DebitInvoicePurchaser->BranchOffice->find("list", array("fields" => array("BranchOffice.id", "BranchOffice.name"))));
        $this->set("suppliers", ClassRegistry::init("Supplier")->find("list", array("fields" => array("Supplier.id", "Supplier.name"))));
    }

    function admin_index() {
        $this->_activePrint(func_get_args(), "data_penerimaan_kembalian");
        parent::admin_index();
    }

    function admin_index_validate() {
        $this->_activePrint(func_get_args(), "data_penerimaan_kembalian_validasi");
        $this->conds = [
            "DebitInvoicePurchaser.verify_status_id" => 1,
            "DebitInvoicePurchaser.verified_by_id" => null
        ];
        parent::admin_index();
    }

    function admin_add() {
        if ($this->request->is("post")) {
            $this->{ Inflector::classify($this->name) }->set($this->data);
            if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                $this->{ Inflector::classify($this->name) }->data['DebitInvoicePurchaser']['verify_status_id'] = 1;
                $this->DebitInvoicePurchaser->_numberSeperatorRemover();
                $transactionEntry = ClassRegistry::init("TransactionEntry")->find("first", [
                    "conditions" => [
                        "TransactionEntry.id" => $this->data['DebitInvoicePurchaser']['transaction_entry_id'],
                    ],
                ]);
                $this->DebitInvoicePurchaser->data['DebitInvoicePurchaser']['branch_office_id'] = $transactionEntry['TransactionEntry']['branch_office_id'];
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
                        $this->DebitInvoicePurchaser->_numberSeperatorRemover();
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

    function get_data_debit($id = null) {
        $this->autoRender = false;
        if ($this->DebitInvoicePurchaser->exists($id)) {
            if ($this->request->is("GET")) {
                $data = $this->DebitInvoicePurchaser->find("first", ["conditions" => ["DebitInvoicePurchaser.id" => $id]]);
                return json_encode($data);
            } else {
                return json_encode($this->_generateStatusCode(400));
            }
        } else {
            throw new NotFoundException(__("Data Not Found"));
        }
    }

    function admin_change_status_verify() {
        $this->autoRender = false;
        if ($this->request->is("PUT")) {
            $this->DebitInvoicePurchaser->data['DebitInvoicePurchaser']['id'] = $this->request->data['id'];
            $this->DebitInvoicePurchaser->data['DebitInvoicePurchaser']['verify_status_id'] = $this->request->data['status'];
            if ($this->request->data['status'] == '3') {
                $idDebitInvoice = ClassRegistry::init("DebitInvoicePurchaser")->find("first", [
                    "conditions" => [
                        "DebitInvoicePurchaser.id" => $this->request->data['id'],
                    ]
                ]);
                $initialBalance = $this->DebitInvoicePurchaser->InitialBalance->find("first", [
                    "conditions" => [
                        "InitialBalance.id" => $idDebitInvoice['DebitInvoicePurchaser']['initial_balance_id'],
                    ]
                ]);
                $this->DebitInvoicePurchaser->data['InitialBalance']['id'] = $idDebitInvoice['DebitInvoicePurchaser']['initial_balance_id'];
                $this->DebitInvoicePurchaser->data['InitialBalance']['nominal'] = $initialBalance['InitialBalance']['nominal'] + $idDebitInvoice['DebitInvoicePurchaser']['amount'];

                $updatedData = [];
                $updatedData['GeneralEntryType']['id'] = $initialBalance['InitialBalance']['general_entry_type_id'];
                $updatedData['GeneralEntryType']['latest_balance'] = $this->DebitInvoicePurchaser->data['InitialBalance']['nominal'];
                ClassRegistry::init("GeneralEntryType")->save($updatedData);

                $this->DebitInvoicePurchaser->data['DebitInvoicePurchaser']['verified_by_id'] = $this->_getEmployeeId();
                $this->DebitInvoicePurchaser->data['DebitInvoicePurchaser']['verified_datetime'] = date("Y-m-d H:i:s");

                /* updating to transaction mutation table */
                $this->DebitInvoicePurchaser->data['TransactionMutation']['initial_balance_id'] = $initialBalance['InitialBalance']['id'];
                $this->DebitInvoicePurchaser->data['TransactionMutation']['reference_number'] = $idDebitInvoice['TransactionEntry']['transaction_number'];
                $this->DebitInvoicePurchaser->data['TransactionMutation']['transaction_name'] = "Pembelian Ikan";
                $this->DebitInvoicePurchaser->data['TransactionMutation']['debit'] = $idDebitInvoice['DebitInvoicePurchaser']['amount'];
                $this->DebitInvoicePurchaser->data['TransactionMutation']['transaction_date'] = date("Y-m-d");
                $this->DebitInvoicePurchaser->data['TransactionMutation']['initial_balance'] = $initialBalance['InitialBalance']['nominal'];
                $this->DebitInvoicePurchaser->data['TransactionMutation']['mutation_balance'] = $this->DebitInvoicePurchaser->data['InitialBalance']['nominal'];
                $this->DebitInvoicePurchaser->data['TransactionMutation']['transaction_type_id'] = 10;

                /* updating to general entry table */
                $this->DebitInvoicePurchaser->data['GeneralEntry'][0]['initial_balance_id'] = $initialBalance['InitialBalance']['id'];
                $this->DebitInvoicePurchaser->data['GeneralEntry'][0]['reference_number'] = $idDebitInvoice['TransactionEntry']['transaction_number'];
                $this->DebitInvoicePurchaser->data['GeneralEntry'][0]['transaction_name'] = $initialBalance['GeneralEntryType']['name'];
                $this->DebitInvoicePurchaser->data['GeneralEntry'][0]['initial_balance'] = $initialBalance['InitialBalance']['nominal'];
                $this->DebitInvoicePurchaser->data['GeneralEntry'][0]['mutation_balance'] = $this->DebitInvoicePurchaser->data['InitialBalance']['nominal'];
                $this->DebitInvoicePurchaser->data['GeneralEntry'][0]['debit'] = $idDebitInvoice['DebitInvoicePurchaser']['amount'];
                $this->DebitInvoicePurchaser->data['GeneralEntry'][0]['transaction_date'] = date("Y-m-d");
                $this->DebitInvoicePurchaser->data['GeneralEntry'][0]['general_entry_type_id'] = $initialBalance['GeneralEntryType']['id'];
                $this->DebitInvoicePurchaser->data['GeneralEntry'][0]['transaction_type_id'] = 10;
                $this->DebitInvoicePurchaser->data['GeneralEntry'][0]['general_entry_account_type_id'] = 2;
                $this->DebitInvoicePurchaser->data['GeneralEntry'][1]['initial_balance_id'] = $initialBalance['InitialBalance']['id'];
                $this->DebitInvoicePurchaser->data['GeneralEntry'][1]['reference_number'] = $idDebitInvoice['TransactionEntry']['transaction_number'];
                $this->DebitInvoicePurchaser->data['GeneralEntry'][1]['transaction_name'] = "Pembelian Ikan";
                $this->DebitInvoicePurchaser->data['GeneralEntry'][1]['initial_balance'] = $initialBalance['InitialBalance']['nominal'];
                $this->DebitInvoicePurchaser->data['GeneralEntry'][1]['mutation_balance'] = $this->DebitInvoicePurchaser->data['InitialBalance']['nominal'];
                $this->DebitInvoicePurchaser->data['GeneralEntry'][1]['debit'] = $idDebitInvoice['DebitInvoicePurchaser']['amount'];
                $this->DebitInvoicePurchaser->data['GeneralEntry'][1]['transaction_date'] = date("Y-m-d");
                $this->DebitInvoicePurchaser->data['GeneralEntry'][1]['general_entry_type_id'] = 50;
                $this->DebitInvoicePurchaser->data['GeneralEntry'][1]['transaction_type_id'] = 10;
                $this->DebitInvoicePurchaser->data['GeneralEntry'][1]['general_entry_account_type_id'] = 2;
            } else if ($this->request->data['status'] == '2') {
                $this->DebitInvoicePurchaser->data['DebitInvoicePurchaser']['verified_by_id'] = $this->_getEmployeeId();
                $this->DebitInvoicePurchaser->data['DebitInvoicePurchaser']['verified_datetime'] = date("Y-m-d H:i:s");
            } else if ($this->request->data['status'] == '1') {
                $this->DebitInvoicePurchaser->data['DebitInvoicePurchaser']['verified_by_id'] = null;
                $this->DebitInvoicePurchaser->data['DebitInvoicePurchaser']['verified_datetime'] = null;
            }
            $this->DebitInvoicePurchaser->saveAll();
            $data = $this->DebitInvoicePurchaser->find("first", array("conditions" => array("DebitInvoicePurchaser.id" => $this->request->data['id']), "recursive" => 3));
            echo json_encode($this->_generateStatusCode(207, null, array("status_label" => $data['VerifyStatus']['name'])));
        } else {
            echo json_encode($this->_generateStatusCode(400));
        }
    }

}
