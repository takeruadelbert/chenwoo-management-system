<?php

App::uses('AppController', 'Controller');

class DebitInvoicePurchaserMaterialAdditionalsController extends AppController {

    var $name = "DebitInvoicePurchaserMaterialAdditionals";
    var $disabledAction = array(
    );
    var $contain = [
        "PurchaseOrderMaterialAdditional" => [
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
        $this->set("initialBalances", $this->DebitInvoicePurchaserMaterialAdditional->InitialBalance->find("list", ["fields" => ["InitialBalance.id", "GeneralEntryType.name"], "contain" => ["GeneralEntryType"]]));
        $this->set("verifyStatuses", $this->DebitInvoicePurchaserMaterialAdditional->VerifyStatus->find("list", ["fields" => ["VerifyStatus.id", "VerifyStatus.name"]]));
        $this->set("branchOffices", $this->DebitInvoicePurchaserMaterialAdditional->BranchOffice->find("list", array("fields" => array("BranchOffice.id", "BranchOffice.name"))));
        $this->set("materialAdditionalSuppliers", ClassRegistry::init("MaterialAdditionalSupplier")->find("list", ['fields' => ["MaterialAdditionalSupplier.id", "MaterialAdditionalSupplier.name"]]));
    }

    function admin_index() {
        $this->_activePrint(func_get_args(), "data_penerimaan_kembalian_material_pembantu");
        parent::admin_index();
    }

    function admin_index_validate() {
        $this->_activePrint(func_get_args(), "data_penerimaan_kembalian_material_pembantu_validasi");
        $this->conds = [
            "DebitInvoicePurchaserMaterialAdditional.verify_status_id" => 1,
            "DebitInvoicePurchaserMaterialAdditional.verified_by_id" => null
        ];
        parent::admin_index();
    }

    function admin_add() {
        if ($this->request->is("post")) {
            $this->{ Inflector::classify($this->name) }->set($this->data);
            if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                $this->{ Inflector::classify($this->name) }->data['DebitInvoicePurchaserMaterialAdditional']['verify_status_id'] = 1;
                $this->DebitInvoicePurchaserMaterialAdditional->_numberSeperatorRemover();
                $poMaterialAdditional = ClassRegistry::init("PurchaseOrderMaterialAdditional")->find("first", [
                    "conditions" => [
                        "PurchaseOrderMaterialAdditional.id" => $this->data['DebitInvoicePurchaserMaterialAdditional']['purchase_order_material_additional_id'],
                    ],
                ]);
                $this->DebitInvoicePurchaserMaterialAdditional->data['DebitInvoicePurchaserMaterialAdditional']['branch_office_id'] = $poMaterialAdditional['PurchaseOrderMaterialAdditional']['branch_office_id'];
                $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
                $this->Session->setFlash(__("Data berhasil disimpan"), 'default', array(), 'success');
                $this->redirect(array('action' => 'admin_index'));
            } else {
                $this->validationErrors = $this->{ Inflector::classify($this->name) }->validationErrors;
                $this->Session->setFlash(__("Harap mengecek kembali kesalahan dibawah."), 'default', array(), 'danger');
            }
        }
    }

    function get_data_debit($id = null) {
        $this->autoRender = false;
        if ($this->DebitInvoicePurchaserMaterialAdditional->exists($id)) {
            if ($this->request->is("GET")) {
                $data = $this->DebitInvoicePurchaserMaterialAdditional->find("first", ["conditions" => ["DebitInvoicePurchaserMaterialAdditional.id" => $id]]);
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
            $this->DebitInvoicePurchaserMaterialAdditional->data['DebitInvoicePurchaserMaterialAdditional']['id'] = $this->request->data['id'];
            $this->DebitInvoicePurchaserMaterialAdditional->data['DebitInvoicePurchaserMaterialAdditional']['verify_status_id'] = $this->request->data['status'];
            if ($this->request->data['status'] == '3') {
                $idDebitInvoice = ClassRegistry::init("DebitInvoicePurchaserMaterialAdditional")->find("first", [
                    "conditions" => [
                        "DebitInvoicePurchaserMaterialAdditional.id" => $this->request->data['id'],
                    ]
                ]);
                $initialBalance = $this->DebitInvoicePurchaserMaterialAdditional->InitialBalance->find("first", [
                    "conditions" => [
                        "InitialBalance.id" => $idDebitInvoice['DebitInvoicePurchaserMaterialAdditional']['initial_balance_id'],
                    ]
                ]);
                $this->DebitInvoicePurchaserMaterialAdditional->data['InitialBalance']['id'] = $idDebitInvoice['DebitInvoicePurchaserMaterialAdditional']['initial_balance_id'];
                $this->DebitInvoicePurchaserMaterialAdditional->data['InitialBalance']['nominal'] = $initialBalance['InitialBalance']['nominal'] + $idDebitInvoice['DebitInvoicePurchaserMaterialAdditional']['amount'];
                $this->DebitInvoicePurchaserMaterialAdditional->data['DebitInvoicePurchaserMaterialAdditional']['verified_by_id'] = $this->_getEmployeeId();
                $this->DebitInvoicePurchaserMaterialAdditional->data['DebitInvoicePurchaserMaterialAdditional']['verified_datetime'] = date("Y-m-d H:i:s");
                
                $mutation_balance = $this->DebitInvoicePurchaserMaterialAdditional->data['InitialBalance']['nominal'];
                $updatedData = [];
                $updatedData['GeneralEntryType']['id'] = $initialBalance['InitialBalance']['general_entry_type_id'];
                $updatedData['GeneralEntryType']['latest_balance'] = $mutation_balance;
                ClassRegistry::init("GeneralEntryType")->save($updatedData);

                /* updating to transaction mutation table */
                $this->DebitInvoicePurchaserMaterialAdditional->data['TransactionMutation']['initial_balance_id'] = $initialBalance['InitialBalance']['id'];
                $this->DebitInvoicePurchaserMaterialAdditional->data['TransactionMutation']['reference_number'] = $idDebitInvoice['PurchaseOrderMaterialAdditional']['po_number'];
                $this->DebitInvoicePurchaserMaterialAdditional->data['TransactionMutation']['initial_balance'] = $initialBalance['InitialBalance']['nominal'];
                $this->DebitInvoicePurchaserMaterialAdditional->data['TransactionMutation']['mutation_balance'] = $mutation_balance;
                $this->DebitInvoicePurchaserMaterialAdditional->data['TransactionMutation']['transaction_type_id'] = 10;
                
                /* updating to General Entry Table */
                $this->DebitInvoicePurchaserMaterialAdditional->data['GeneralEntry'][0]['initial_balance_id'] = $initialBalance['InitialBalance']['id'];
                $this->DebitInvoicePurchaserMaterialAdditional->data['GeneralEntry'][0]['reference_number'] = $idDebitInvoice['PurchaseOrderMaterialAdditional']['po_number'];
                $this->DebitInvoicePurchaserMaterialAdditional->data['GeneralEntry'][0]['transaction_name'] = $initialBalance['GeneralEntryType']['name'];
                $this->DebitInvoicePurchaserMaterialAdditional->data['GeneralEntry'][0]['initial_balance'] = $initialBalance['InitialBalance']['nominal'];
                $this->DebitInvoicePurchaserMaterialAdditional->data['GeneralEntry'][0]['mutation_balance'] = $mutation_balance;
                $this->DebitInvoicePurchaserMaterialAdditional->data['GeneralEntry'][0]['debit'] = $idDebitInvoice['DebitInvoicePurchaserMaterialAdditional']['amount'];
                $this->DebitInvoicePurchaserMaterialAdditional->data['GeneralEntry'][0]['transaction_date'] = date("Y-m-d");
                $this->DebitInvoicePurchaserMaterialAdditional->data['GeneralEntry'][0]['general_entry_type_id'] = $initialBalance['GeneralEntryType']['id'];
                $this->DebitInvoicePurchaserMaterialAdditional->data['GeneralEntry'][0]['general_entry_account_type_id'] = 2;
                $this->DebitInvoicePurchaserMaterialAdditional->data['GeneralEntry'][1]['initial_balance_id'] = $initialBalance['InitialBalance']['id'];
                $this->DebitInvoicePurchaserMaterialAdditional->data['GeneralEntry'][1]['reference_number'] = $idDebitInvoice['PurchaseOrderMaterialAdditional']['po_number'];
                $this->DebitInvoicePurchaserMaterialAdditional->data['GeneralEntry'][1]['transaction_name'] = "Pembelian Bahan Pembantu";
                $this->DebitInvoicePurchaserMaterialAdditional->data['GeneralEntry'][1]['initial_balance'] = $initialBalance['InitialBalance']['nominal'];
                $this->DebitInvoicePurchaserMaterialAdditional->data['GeneralEntry'][1]['mutation_balance'] = $mutation_balance;
                $this->DebitInvoicePurchaserMaterialAdditional->data['GeneralEntry'][1]['credit'] = $idDebitInvoice['DebitInvoicePurchaserMaterialAdditional']['amount'];
                $this->DebitInvoicePurchaserMaterialAdditional->data['GeneralEntry'][1]['transaction_date'] = date("Y-m-d");
                $this->DebitInvoicePurchaserMaterialAdditional->data['GeneralEntry'][1]['general_entry_type_id'] = 45;
                $this->DebitInvoicePurchaserMaterialAdditional->data['GeneralEntry'][1]['general_entry_account_type_id'] = 2;
            } else if ($this->request->data['status'] == '2') {
                $this->DebitInvoicePurchaserMaterialAdditional->data['DebitInvoicePurchaserMaterialAdditional']['verified_by_id'] = $this->_getEmployeeId();
                $this->DebitInvoicePurchaserMaterialAdditional->data['DebitInvoicePurchaserMaterialAdditional']['verified_datetime'] = date("Y-m-d H:i:s");
            } else if ($this->request->data['status'] == '1') {
                $this->DebitInvoicePurchaserMaterialAdditional->data['DebitInvoicePurchaserMaterialAdditional']['verified_by_id'] = null;
                $this->DebitInvoicePurchaserMaterialAdditional->data['DebitInvoicePurchaserMaterialAdditional']['verified_datetime'] = null;
            }
            $this->DebitInvoicePurchaserMaterialAdditional->saveAll();
            $data = $this->DebitInvoicePurchaserMaterialAdditional->find("first", array("conditions" => array("DebitInvoicePurchaserMaterialAdditional.id" => $this->request->data['id']), "recursive" => 3));
            echo json_encode($this->_generateStatusCode(207, null, array("status_label" => $data['VerifyStatus']['name'])));
        } else {
            echo json_encode($this->_generateStatusCode(400));
        }
    }

}
