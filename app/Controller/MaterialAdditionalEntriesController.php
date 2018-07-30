<?php

App::uses('AppController', 'Controller');

class MaterialAdditionalEntriesController extends AppController {

    var $name = "MaterialAdditionalEntries";
    var $disabledAction = array(
    );
    var $contain = [
        "Employee" => [
            "Account" => [
                "Biodata",
            ],
        ],
        "MaterialAdditionalSupplier",
        "PurchaseOrderMaterialAdditional"=>[
            "MaterialAdditionalSupplier"
        ]
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
            $no_entry = $this->generateEntryNumber();
            $this->{ Inflector::classify($this->name) }->data["MaterialAdditionalEntry"]['no_entry'] = $no_entry;
            $this->{ Inflector::classify($this->name) }->data["MaterialAdditionalEntry"]['employee_id'] = $this->Session->read("credential.admin.Employee.id");
            if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                //Update Stock
                $price_per_pieces = 0;
                $totalPrice = 0;
                foreach ($this->data["MaterialAdditionalEntryDetail"] as $n => $MaterialAdditionalDetail) {
                    //Update remaining in PO
                    $materialAdditionalDetailPO = ClassRegistry::init("PurchaseOrderMaterialAdditionalDetail")->find("first", [
                        "conditions" => [
                            "PurchaseOrderMaterialAdditionalDetail.purchase_order_material_additional_id" => $this->data["MaterialAdditionalEntry"]['purchase_order_material_additional_id'],
                            "PurchaseOrderMaterialAdditionalDetail.material_additional_id" =>$MaterialAdditionalDetail['material_additional_id']
                        ],
                    ]);
                    ClassRegistry::init("PurchaseOrderMaterialAdditionalDetail")->updateAll(
                            array("quantity_remaining" => floatval(floatval($materialAdditionalDetailPO['PurchaseOrderMaterialAdditionalDetail']['quantity_remaining']) - floatval($MaterialAdditionalDetail['quantity_entry']))), //fields to update
                            array(
                            "PurchaseOrderMaterialAdditionalDetail.purchase_order_material_additional_id" => $this->data["MaterialAdditionalEntry"]['purchase_order_material_additional_id'],
                            "PurchaseOrderMaterialAdditionalDetail.material_additional_id" =>$MaterialAdditionalDetail['material_additional_id']
                            )  //condition
                    );
                    $materialAdditionalTemp = ClassRegistry::init("MaterialAdditional")->find("first", [
                        "conditions" => [
                            "MaterialAdditional.id" => $MaterialAdditionalDetail['material_additional_id'],
                        ],
                    ]);
                    $toUpdateMaterialAdditional = [
                        "MaterialAdditional" => [
                            "id" => $MaterialAdditionalDetail['material_additional_id'],
                            "quantity" => floatval($materialAdditionalTemp['MaterialAdditional']['quantity'] + $MaterialAdditionalDetail['quantity_entry']),
                        ]
                    ];
                    ClassRegistry::init("MaterialAdditional")->saveAll($toUpdateMaterialAdditional);
                    
                    $po_material_detail_id = $MaterialAdditionalDetail['po_material_additional_detail_id'];
                    $dataPOMaterialAdditionalDetail = ClassRegistry::init("PurchaseOrderMaterialAdditionalDetail")->find("first",[
                        "conditions" => [
                            "PurchaseOrderMaterialAdditionalDetail.id" => $po_material_detail_id
                        ]
                    ]);
                    $price_per_pieces = $dataPOMaterialAdditionalDetail['PurchaseOrderMaterialAdditionalDetail']['price'];
                    $totalPrice += $price_per_pieces * $MaterialAdditionalDetail['quantity_entry'];
                }
                
                $materialAdditionalName = "";
                foreach ($this->data['MaterialAdditionalEntryDetail'] as $index => $details) {
                    if($index != count($this->data['MaterialAdditionalEntryDetail'])) {
                        $materialAdditionalName .= $details['name'] . ", ";
                    } else {
                        $materialAdditionalName .= $details['name'];
                    }
                }
                
                $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
                $this->Session->setFlash(__("Data berhasil disimpan"), 'default', array(), 'success');
                $this->redirect(array('action' => 'admin_entry', 'controller' => 'purchaseOrderMaterialAdditionals'));
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
    
    function generateEntryNumber() {
        $inc_id = 1;
        $Y = date('Y');
        $M = romanic_number(date('n'));
        $testCode = "[0-9]{4}/MPIN-PRO/$M/$Y";
        $lastRecord = $this->MaterialAdditionalEntry->find('first', array('conditions' => array('and' => array("MaterialAdditionalEntry.no_entry regexp" => $testCode)), 'order' => array('MaterialAdditionalEntry.no_entry' => 'DESC')));
        if (!empty($lastRecord)) {
            $current = substr($lastRecord['MaterialAdditionalEntry']['no_entry'], 0, 4);
            $inc_id += $current;
        }
        $inc_id = sprintf("%04d", $inc_id);
        $kode = "$inc_id/MPIN-PRO/$M/$Y";
        return $kode;
    }
    
    function admin_view_data_material_additional_entry($materialAdditionalEntryId) {
        if (!empty($materialAdditionalEntryId) && $materialAdditionalEntryId != null) {
            $this->autoRender = false;
            $data = ClassRegistry::init("MaterialAdditionalEntry")->find("first", [
                "conditions" => [
                    "MaterialAdditionalEntry.id" => $materialAdditionalEntryId,
                ],
                "contain" => [
                    "MaterialAdditionalEntryDetail"=>[
                        "MaterialAdditional"=>[
                            "MaterialAdditionalUnit"
                        ]
                    ],
                    "Employee" => [
                        "Account" => [
                            "Biodata"
                        ],
                        "Department",
                        "Office"
                    ],
                ],
            ]);
            return json_encode($data);
        } else {
            throw new NotFoundException(__('Data Not Found'));
        }
    }
    
    function admin_get_purchase_order_data($id) {
        $this->autoRender = false;
        if(!empty($id)) {
            if($this->request->is("GET")) {
                $data = ClassRegistry::init("PurchaseOrderMaterialAdditional")->find("first",[
                    "conditions" => [
                        "PurchaseOrderMaterialAdditional.id" => $id
                    ],
                    "contain" => [
                        "PurchaseOrderMaterialAdditionalDetail" => [
                            "MaterialAdditional" => [
                                "MaterialAdditionalUnit"
                            ],
                            "PurchaseOrderMaterialAdditional"=>[
                                "MaterialAdditionalSupplier"
                            ]
                        ]
                    ]
                ]);
                return json_encode($data);
            } else {
                return json_encode($this->_generateStatusCode(400));
            }
        } else {
            return json_encode("404 Not Found");
        }
    }
}