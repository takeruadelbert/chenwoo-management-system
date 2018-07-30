<?php

App::uses('AppController', 'Controller');

class OrderMaterialAdditionalsController extends AppController {

    var $name = "OrderMaterialAdditionals";
    var $disabledAction = array(
    );
    var $contain = [
        "Employee" => [
            "Account" => [
                "Biodata",
            ],
        ],
    ];

    function beforeFilter() {
        parent::beforeFilter();
        $this->_setPageInfo("admin_index", "");
        $this->_setPageInfo("admin_add", "");
        $this->_setPageInfo("admin_edit", "");
    }

    function admin_add() {
        if ($this->request->is("post")) {
            $this->{ Inflector::classify($this->name) }->set($this->data);
            $this->{ Inflector::classify($this->name) }->data["OrderMaterialAdditional"]['employee_id'] = $this->Session->read("credential.admin.Employee.id");
            $this->{ Inflector::classify($this->name) }->data["OrderMaterialAdditional"]['remaining'] = $this->data['OrderMaterialAdditional']['total'];
            if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                /* adding to General Entry Table */
//                $dataMaterialAdd = [];
                $receiptNumber = $this->generateOrderNumber();
                $this->OrderMaterialAdditional->data['OrderMaterialAdditional']['order_number'] = $receiptNumber;
//                $initialBalance = ClassRegistry::init("InitialBalance")->find("first",[
//                    "conditions" => [
//                        "InitialBalance.id" => 1
//                    ]
//                ]);
//                $dataMaterialAdd['GeneralEntry'][0]['reference_number'] = $receiptNumber;
//                $dataMaterialAdd['GeneralEntry'][0]['transaction_name'] = "Biaya Material Pembantu";
//                $dataMaterialAdd['GeneralEntry'][0]['transaction_date'] = date("Y-m-d");
//                $dataMaterialAdd['GeneralEntry'][0]['transaction_type_id'] = 4;
//                $dataMaterialAdd['GeneralEntry'][0]['general_entry_type_id'] = 40;
//                $dataMaterialAdd['GeneralEntry'][0]['debit'] = $this->OrderMaterialAdditional->data['OrderMaterialAdditional']['total'];
//                $dataMaterialAdd['GeneralEntry'][0]['initial_balance'] = $initialBalance['InitialBalance']['nominal'];
//                $dataMaterialAdd['GeneralEntry'][0]['mutation_balance'] = $initialBalance['InitialBalance']['nominal'];
//                $dataMaterialAdd['GeneralEntry'][0]['initial_balance_id'] = $initialBalance['InitialBalance']['id'];
//                $dataMaterialAdd['GeneralEntry'][0]['general_entry_account_type_id'] = 1;
//                $dataMaterialAdd['GeneralEntry'][1]['reference_number'] = $receiptNumber;
//                $dataMaterialAdd['GeneralEntry'][1]['transaction_name'] = "Kas Besar";
//                $dataMaterialAdd['GeneralEntry'][1]['transaction_date'] = date("Y-m-d");
//                $dataMaterialAdd['GeneralEntry'][1]['transaction_type_id'] = 4;
//                $dataMaterialAdd['GeneralEntry'][1]['general_entry_type_id'] = 3;
//                $dataMaterialAdd['GeneralEntry'][1]['credit'] = $this->OrderMaterialAdditional->data['OrderMaterialAdditional']['total'];
//                $dataMaterialAdd['GeneralEntry'][1]['initial_balance'] = $initialBalance['InitialBalance']['nominal'];
//                $dataMaterialAdd['GeneralEntry'][1]['mutation_balance'] = $initialBalance['InitialBalance']['nominal'];
//                $dataMaterialAdd['GeneralEntry'][1]['initial_balance_id'] = $initialBalance['InitialBalance']['id'];
//                $dataMaterialAdd['GeneralEntry'][1]['general_entry_account_type_id'] = 1;
//                foreach ($dataMaterialAdd as $materialAdd) {
//                    ClassRegistry::init("GeneralEntry")->saveAll($materialAdd);
//                }
                $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
                $this->Session->setFlash(__("Data berhasil disimpan"), 'default', array(), 'success');
                $this->redirect(array('action' => 'admin_index'));
            } else {
                $this->validationErrors = $this->{ Inflector::classify($this->name) }->validationErrors;
                $this->Session->setFlash(__("Harap mengecek kembali kesalahan dibawah."), 'default', array(), 'danger');
            }
        }
    }

    function beforeRender() {
        $this->_options();
        parent::beforeRender();
    }

    function _options() {
        $this->set("materialAdditional", ClassRegistry::init("MaterialAdditional")->find("all", array("fields" => array("MaterialAdditional.id", "MaterialAdditional.name"))));
        $this->set("materialAdditionalSuppliers", ClassRegistry::init("MaterialAdditionalSupplier")->find("list", array("fields" => array("MaterialAdditionalSupplier.id", "MaterialAdditionalSupplier.name"))));
        $this->set("purchaseOrderMaterialAdditionals", ClassRegistry::init("PurchaseOrderMaterialAdditional")->find("list", array("fields" => array("PurchaseOrderMaterialAdditional.id", "PurchaseOrderMaterialAdditional.po_number"))));
    }
    
    function generateOrderNumber() {
        $inc_id = 1;
        $currentMonth = romanic_number(date("n"));
        $currentYear = date("Y");
        $template = "/MPOR-PRO/$currentMonth/$currentYear";
        $lastRecord = $this->OrderMaterialAdditional->find("first",[
            "order" => "OrderMaterialAdditional.order_number DESC"
        ]);
        if (!empty($lastRecord)) {
            $current = substr($lastRecord['OrderMaterialAdditional']['order_number'], 0, 4);
            $inc_id += $current;
        }
        $id = sprintf("%04d", $inc_id);
        $code = $id . $template;
        return $code;
    }
}