<?php

App::uses('AppController', 'Controller');

class DebitInvoiceSalesController extends AppController {

    var $name = "DebitInvoiceSales";
    var $disabledAction = array(
    );
    var $contain = [
        "Sale" => [
            "Buyer",
            "BranchOffice"
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

    function admin_index() {
        $this->_activePrint(func_get_args(), "data_penarikan_kelebihan");
        parent::admin_index();
    }

    function admin_index_validate() {
        $this->_activePrint(func_get_args(), "data_penarikan_kelebihan_validasi");
        $this->conds = [
            "DebitInvoiceSale.verify_status_id" => 1,
            "DebitInvoiceSale.verified_by_id" => null
        ];
        parent::admin_index();
    }

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
        $this->set("initialBalancesRupiah", $this->DebitInvoiceSale->InitialBalance->find("list", ["fields" => ["InitialBalance.id", "GeneralEntryType.name"], "contain" => ["GeneralEntryType"], "conditions" => ["InitialBalance.currency_id" => 1]]));
        $this->set("initialBalancesDollar", $this->DebitInvoiceSale->InitialBalance->find("list", ["fields" => ["InitialBalance.id", "GeneralEntryType.name"], "contain" => ["GeneralEntryType"], "conditions" => ["InitialBalance.currency_id" => 2]]));
        $this->set("verifyStatuses", $this->DebitInvoiceSale->VerifyStatus->find("list", ["fields" => ["VerifyStatus.id", "VerifyStatus.name"]]));
        $this->set("branchOffices", $this->DebitInvoiceSale->Sale->BranchOffice->find("list", array("fields" => array("BranchOffice.id", "BranchOffice.name"))));
    }

    function admin_add() {
        if ($this->request->is("post")) {
            $this->{ Inflector::classify($this->name) }->set($this->data);
            if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                $this->{ Inflector::classify($this->name) }->data['DebitInvoiceSale']['verify_status_id'] = 1;
                if ($this->data['DebitInvoiceSale']['buyer_type_id'] == 1) {
                    $this->DebitInvoiceSale->_numberSeperatorRemover();
                }
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
                        $this->DebitInvoiceSale->_numberSeperatorRemover();
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

    function get_data_kredit($id = null) {
        $this->autoRender = false;
        if ($this->DebitInvoiceSale->exists($id)) {
            if ($this->request->is("GET")) {
                $data = $this->DebitInvoiceSale->find("first", ["conditions" => ["DebitInvoiceSale.id" => $id]]);
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
            $this->DebitInvoiceSale->data['DebitInvoiceSale']['id'] = $this->request->data['id'];
            $this->DebitInvoiceSale->data['DebitInvoiceSale']['verify_status_id'] = $this->request->data['status'];
            if ($this->request->data['status'] == '3') {
                $dataDebitInvoiceSale = ClassRegistry::init("DebitInvoiceSale")->find("first", [
                    "conditions" => [
                        "DebitInvoiceSale.id" => $this->request->data['id']
                    ]
                ]);
                $dataSale = ClassRegistry::init("Sale")->find("first", [
                    "conditions" => [
                        "Sale.id" => $dataDebitInvoiceSale['DebitInvoiceSale']['sale_id']
                    ],
                    "contain" => [
                        "Buyer"
                    ]
                ]);

                /* updating to transaction mutation table */
                $dataInitialBalance = ClassRegistry::init("InitialBalance")->find("first", [
                    "conditions" => [
                        "InitialBalance.id" => $dataDebitInvoiceSale['DebitInvoiceSale']['initial_balance_id']
                    ],
                    "contain" => [
                        "GeneralEntryType"
                    ]
                ]);
                $mutation_balance = $dataInitialBalance['GeneralEntryType']['latest_balance'] - $dataDebitInvoiceSale['DebitInvoiceSale']['amount'];
                $transaction_name = "";
                if ($dataSale['Buyer']['buyer_type_id'] == 1) {
                    $transaction_name = "Penjualan Lokal";
                    $general_entry_type_id_sale = 31;
                } else {
                    $transaction_name = "Penjualan Export";
                    $general_entry_type_id_sale = 8;
                }
                $this->DebitInvoiceSale->data['TransactionMutation']['initial_balance_id'] = $dataDebitInvoiceSale['DebitInvoiceSale']['initial_balance_id'];
                $this->DebitInvoiceSale->data['TransactionMutation']['reference_number'] = $dataSale['Sale']['sale_no'];
                $this->DebitInvoiceSale->data['TransactionMutation']['transaction_name'] = $transaction_name;
                $this->DebitInvoiceSale->data['TransactionMutation']['debit'] = $dataDebitInvoiceSale['DebitInvoiceSale']['amount'];
                $this->DebitInvoiceSale->data['TransactionMutation']['transaction_date'] = date("Y-m-d");
                $this->DebitInvoiceSale->data['TransactionMutation']['initial_balance'] = $dataInitialBalance['GeneralEntryType']['latest_balance'];
                $this->DebitInvoiceSale->data['TransactionMutation']['mutation_balance'] = $mutation_balance;
                $this->DebitInvoiceSale->data['TransactionMutation']['transaction_type_id'] = 9;

                /* updating to general entry table */
                $this->DebitInvoiceSale->data['GeneralEntry'][0]['initial_balance_id'] = $dataDebitInvoiceSale['DebitInvoiceSale']['initial_balance_id'];
                $this->DebitInvoiceSale->data['GeneralEntry'][0]['reference_number'] = $dataSale['Sale']['sale_no'];
                $this->DebitInvoiceSale->data['GeneralEntry'][0]['transaction_name'] = $transaction_name;
                $this->DebitInvoiceSale->data['GeneralEntry'][0]['initial_balance'] = $dataInitialBalance['GeneralEntryType']['latest_balance'];
                $this->DebitInvoiceSale->data['GeneralEntry'][0]['mutation_balance'] = $mutation_balance;
                $this->DebitInvoiceSale->data['GeneralEntry'][0]['debit'] = $dataDebitInvoiceSale['DebitInvoiceSale']['amount'];
                $this->DebitInvoiceSale->data['GeneralEntry'][0]['transaction_date'] = date("Y-m-d");
                $this->DebitInvoiceSale->data['GeneralEntry'][0]['general_entry_type_id'] = $general_entry_type_id_sale;
                $this->DebitInvoiceSale->data['GeneralEntry'][0]['transaction_type_id'] = 9;
                $this->DebitInvoiceSale->data['GeneralEntry'][0]['general_entry_account_type_id'] = 1;
                $this->DebitInvoiceSale->data['GeneralEntry'][1]['initial_balance_id'] = $dataDebitInvoiceSale['DebitInvoiceSale']['initial_balance_id'];
                $this->DebitInvoiceSale->data['GeneralEntry'][1]['reference_number'] = $dataSale['Sale']['sale_no'];
                $this->DebitInvoiceSale->data['GeneralEntry'][1]['transaction_name'] = $dataInitialBalance['GeneralEntryType']['name'];
                $this->DebitInvoiceSale->data['GeneralEntry'][1]['initial_balance'] = $dataInitialBalance['GeneralEntryType']['latest_balance'];
                $this->DebitInvoiceSale->data['GeneralEntry'][1]['mutation_balance'] = $mutation_balance;
                $this->DebitInvoiceSale->data['GeneralEntry'][1]['credit'] = $dataDebitInvoiceSale['DebitInvoiceSale']['amount'];
                $this->DebitInvoiceSale->data['GeneralEntry'][1]['transaction_date'] = date("Y-m-d");
                $this->DebitInvoiceSale->data['GeneralEntry'][1]['general_entry_type_id'] = $dataInitialBalance['GeneralEntryType']['id'];
                $this->DebitInvoiceSale->data['GeneralEntry'][1]['transaction_type_id'] = 9;
                $this->DebitInvoiceSale->data['GeneralEntry'][1]['general_entry_account_type_id'] = 1;
                $this->DebitInvoiceSale->data['DebitInvoiceSale']['verified_by_id'] = $this->_getEmployeeId();
                $this->DebitInvoiceSale->data['DebitInvoiceSale']['verified_datetime'] = date("Y-m-d H:i:s");
            } else if ($this->request->data['status'] == '2') {
                $this->DebitInvoiceSale->data['DebitInvoiceSale']['verified_by_id'] = $this->_getEmployeeId();
                $this->DebitInvoiceSale->data['DebitInvoiceSale']['verified_datetime'] = date("Y-m-d H:i:s");
            } else if ($this->request->data['status'] == '1') {
                $this->DebitInvoiceSale->data['DebitInvoiceSale']['verified_by_id'] = null;
                $this->DebitInvoiceSale->data['DebitInvoiceSale']['verified_datetime'] = null;
            }
            $this->DebitInvoiceSale->saveAll();
            $data = $this->DebitInvoiceSale->find("first", array("conditions" => array("DebitInvoiceSale.id" => $this->request->data['id']), "recursive" => 3));
            echo json_encode($this->_generateStatusCode(207, null, array("status_label" => $data['VerifyStatus']['name'])));
        } else {
            echo json_encode($this->_generateStatusCode(400));
        }
    }

}
