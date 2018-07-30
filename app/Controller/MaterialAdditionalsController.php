<?php

App::uses('AppController', 'Controller');

class MaterialAdditionalsController extends AppController {

    var $name = "MaterialAdditionals";
    var $disabledAction = array(
    );
    var $contain = [
        "MaterialAdditionalCategory",
        "MaterialAdditionalUnit"
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
        $this->set("materialAdditionalCategories", ClassRegistry::init("MaterialAdditionalCategory")->find("list", array("fields" => array("MaterialAdditionalCategory.id", "MaterialAdditionalCategory.name"))));
        $this->set("materialAdditionalUnits", $this->MaterialAdditional->MaterialAdditionalUnit->find("list", array("fields" => array("MaterialAdditionalUnit.id", "MaterialAdditionalUnit.name"))));
        $dataProduct = ClassRegistry::init("Product")->find("list", [
            "fields" => [
                "Product.id",
                "Product.name",
                "Parent.name"
            ],
            "contain" => [
                "Parent"
            ],
        ]);
        $this->set("products", $dataProduct);
    }

    function admin_index() {
        $this->_activePrint(func_get_args(), "data_material_pembantu");
        parent::admin_index();
    }

    function admin_stock() {
        $this->_activePrint(func_get_args(), "data_stok_material_pembantu");
        parent::admin_index();
    }

    function admin_add() {
        if ($this->request->is("post")) {
            $this->{ Inflector::classify($this->name) }->set($this->data);
            $this->{ Inflector::classify($this->name) }->data['MaterialAdditional']['branch_office_id'] = $this->stnAdmin->getBranchId();
            if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                $this->MaterialAdditional->_numberSeperatorRemover();
                /* adding to General Entry Table */
                $dataMaterial = ClassRegistry::init("MaterialAdditionalCategory")->find("first", [
                    "conditions" => [
                        "MaterialAdditionalCategory.id" => $this->data['MaterialAdditional']['material_additional_category_id']
                    ]
                ]);
                $dataGeneralEntryType = ClassRegistry::init("GeneralEntryType")->find("first", [
                    "conditions" => [
                        "GeneralEntryType.name like" => "%" . $dataMaterial['MaterialAdditionalCategory']['name'] . "%"
                    ]
                ]);
//                $this->{ Inflector::classify($this->name) }->data['GeneralEntry'][0]['reference_number'] = "Biaya Material Pembantu";
//                $this->{ Inflector::classify($this->name) }->data['GeneralEntry'][0]['transaction_name'] = $dataGeneralEntryType['GeneralEntryType']['name'];
//                $this->{ Inflector::classify($this->name) }->data['GeneralEntry'][0]['debit'] = $this->data['MaterialAdditional']['price'];
//                $this->{ Inflector::classify($this->name) }->data['GeneralEntry'][0]['transaction_date'] = date("Y-m-d");
//                $this->{ Inflector::classify($this->name) }->data['GeneralEntry'][0]['transaction_type_id'] = 6;
//                $this->{ Inflector::classify($this->name) }->data['GeneralEntry'][0]['general_entry_type_id'] = $dataGeneralEntryType['GeneralEntryType']['id'];
//                $this->{ Inflector::classify($this->name) }->data['GeneralEntry'][0]['initial_balance'] = $employeeSalary['InitialBalance']['nominal'];
//                $this->{ Inflector::classify($this->name) }->data['GeneralEntry'][0]['mutation_balance'] = $this->EmployeeSalary->data['InitialBalance']['nominal'];
//                $this->{ Inflector::classify($this->name) }->data['GeneralEntry'][0]['initial_balance_id'] = $employeeSalary['InitialBalance']['id'];
//                $this->{ Inflector::classify($this->name) }->data['GeneralEntry'][1]['reference_number'] = "Biaya Material Pembantu";
//                $this->{ Inflector::classify($this->name) }->data['GeneralEntry'][1]['transaction_name'] = "Kas Besar";
//                $this->{ Inflector::classify($this->name) }->data['GeneralEntry'][1]['credit'] = $salary;
//                $this->{ Inflector::classify($this->name) }->data['GeneralEntry'][1]['transaction_date'] = date("Y-m-d");
//                $this->{ Inflector::classify($this->name) }->data['GeneralEntry'][1]['transaction_type_id'] = 6;
//                $this->{ Inflector::classify($this->name) }->data['GeneralEntry'][1]['general_entry_type_id'] = 3;
//                $this->{ Inflector::classify($this->name) }->data['GeneralEntry'][1]['initial_balance'] = $employeeSalary['InitialBalance']['nominal'];
//                $this->{ Inflector::classify($this->name) }->data['GeneralEntry'][1]['mutation_balance'] = $this->EmployeeSalary->data['InitialBalance']['nominal'];
//                $this->{ Inflector::classify($this->name) }->data['GeneralEntry'][1]['initial_balance_id'] = $employeeSalary['InitialBalance']['id'];
                $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
                $this->Session->setFlash(__("Data berhasil disimpan"), 'default', array(), 'success');
                $this->redirect(array('action' => 'admin_stock'));
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
                        $this->MaterialAdditional->_numberSeperatorRemover();
                        $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
                        $this->Session->setFlash(__("Data berhasil diubah"), 'default', array(), 'success');
                        $this->redirect(array('action' => 'admin_stock'));
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

    function view_data_material_additional($id = null) {
        $this->autoRender = false;
        if ($this->{ Inflector::classify($this->name) }->exists($id)) {
            if ($this->request->is("GET")) {
                $data = $this->{ Inflector::classify($this->name) }->find("first", ["conditions" => ["MaterialAdditional.id" => $id]]);
                return json_encode($data);
            } else {
                return json_encode($this->_generateStatusCode(400));
            }
        } else {
            throw new NotFoundException(__("Data Not Found"));
        }
    }

    function admin_list() {
        $this->autoRender = false;
        $conds = [];
        if (isset($this->request->query['q'])) {
            $q = $this->request->query['q'];
            $conds[] = array(
                "or" => array(
                    "MaterialAdditional.name like" => "%$q%",
            ));
        }
        $suggestions = ClassRegistry::init("MaterialAdditional")->find("all", array(
            "conditions" => $conds,
            "contain" => array(
                "MaterialAdditionalCategory",
                "MaterialAdditionalUnit"
            ),
            "limit"=>10,
        ));
        $result = [];
        foreach ($suggestions as $item) {
            if (!empty($item)) {
                $result[] = [
                    "id" => @$item['MaterialAdditional']['id'],
                    "name" => @$item['MaterialAdditional']['name'],
                    "category_type" => @$item['MaterialAdditionalCategory']['name'],
                    "unit" => @$item['MaterialAdditionalUnit']['name'],
                    "quantity" => @$item['MaterialAdditional']['quantity'],
                    "label" => $item["MaterialAdditional"]["name"] . " " . $item["MaterialAdditional"]["size"],
                ];
            }
        }
        echo json_encode($result);
    }

}
