<?php

App::uses('AppController', 'Controller');

class MaterialAdditionalSalesController extends AppController {

    var $name = "MaterialAdditionalSales";
    var $disabledAction = array(
    );
    var $contain = [
        "Employee" => [
            "Account" => [
                "Biodata",
            ],
        ],
        "MaterialAdditionalSaleDetail" => [
            "MaterialAdditional" => [
                "MaterialAdditionalUnit",
            ],
        ],
        "ValidateStatus",
        "Supplier"
    ];

    function beforeFilter() {
        parent::beforeFilter();
        $this->_setPageInfo("admin_index", "");
        $this->_setPageInfo("admin_add", "");
        $this->_setPageInfo("admin_edit", "");
    }

    function admin_index() {
        $this->_activePrint(func_get_args(), "laporan_material_additional_sale");
        $this->_setPeriodeLaporanDate("awal_MaterialAdditionalSale_sale_dt", "akhir_MaterialAdditionalSale_sale_dt");
        $this->conds = [
            "MaterialAdditionalSale.branch_office_id" => $this->stnAdmin->roleBranchId()
        ];
        parent::admin_index();
    }

    function admin_validate_index() {
        $this->_activePrint(func_get_args(), "data_validasi_penjualan_material_pembantu");
        $this->_setPeriodeLaporanDate("awal_MaterialAdditionalSale_sale_dt", "akhir_MaterialAdditionalSale_sale_dt");
        parent::admin_index();
    }

    function admin_add() {
        if ($this->request->is("post")) {
            $this->{ Inflector::classify($this->name) }->set($this->data);
            if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                $this->MaterialAdditionalSale->_numberSeperatorRemover();
                $this->MaterialAdditionalSale->data['MaterialAdditionalSale']['branch_office_id'] = $this->stnAdmin->getBranchId();
                $this->MaterialAdditionalSale->data['MaterialAdditionalSale']['total_remaining'] = $this->MaterialAdditionalSale->data['MaterialAdditionalSale']['total'];
                $this->MaterialAdditionalSale->data['MaterialAdditionalSale']['no_sale'] = $this->generateSaleNumber();
                $this->MaterialAdditionalSale->data['MaterialAdditionalSale']['employee_id'] = $this->stnAdmin->getEmployeeId();
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
                        $this->MaterialAdditionalSale->_numberSeperatorRemover();
                        $this->MaterialAdditionalSale->_deleteableHasmany();
                        $this->MaterialAdditionalSale->data['MaterialAdditionalSale']['total_remaining'] = $this->MaterialAdditionalSale->data['MaterialAdditionalSale']['total'];
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
                    'contain' => [
                        "MaterialAdditionalSaleDetail" => [
                            "MaterialAdditional" => [
                                "MaterialAdditionalUnit"
                            ]
                        ]
                    ]
                ));
                $this->data = $rows;
            }
        }
    }

    function beforeRender() {
        $this->_options();
        parent::beforeRender();
    }

    function _options() {
        $this->set("validateStatuses", ClassRegistry::init("ValidateStatus")->find("list", ['fields' => ["ValidateStatus.id", "ValidateStatus.name"]]));
        $this->set("validateStatusWithoutFirstOptions", ClassRegistry::init("ValidateStatus")->find("list", ['fields' => ["ValidateStatus.id", "ValidateStatus.name"], 'conditions' => ['ValidateStatus.id !=' => 1]]));
        $this->set("branchOffices", ClassRegistry::init("BranchOffice")->find("list", ['fields' > ['BranchOffice.id', "BranchOffice.name"]]));
        $this->set("initialBalances", ClassRegistry::init("InitialBalance")->find("list", ["fields" => ["InitialBalance.id", "GeneralEntryType.name"], "conditions" => ["InitialBalance.currency_id" => 1], "contain" => "GeneralEntryType"]));
        $dataMaterialAdditionalCategories = ClassRegistry::init("MaterialAdditionalCategory")->find("all", ['order' => 'MaterialAdditionalCategory.name']);
        $result = [];
        foreach ($dataMaterialAdditionalCategories as $materialAdditionalCategory) {
            $dataMaterialAdditional = ClassRegistry::init("MaterialAdditional")->find("all", [
                "conditions" => [
                    "MaterialAdditional.material_additional_category_id" => $materialAdditionalCategory['MaterialAdditionalCategory']['id']
                ],
                'order' => 'MaterialAdditional.name',
                'contain' => [
                    "MaterialAdditionalUnit"
                ]
            ]);
            $child = [];
            if (!empty($dataMaterialAdditional)) {
                foreach ($dataMaterialAdditional as $materialAdditional) {
                    $child[] = [
                        "id" => $materialAdditional['MaterialAdditional']['id'],
                        "label" => $materialAdditional['MaterialAdditional']['name'] . " " . $materialAdditional['MaterialAdditional']['size'],
                        "stock" => $materialAdditional['MaterialAdditional']['quantity']
                    ];
                }
                $result[] = [
                    "id" => $materialAdditionalCategory['MaterialAdditionalCategory']['id'],
                    "category" => $materialAdditionalCategory['MaterialAdditionalCategory']['name'],
                    "unit_name" => !empty($materialAdditional['MaterialAdditionalUnit']['uniq']) ? $materialAdditional['MaterialAdditionalUnit']['uniq'] : "Pcs",
                    "child" => $child
                ];
            }
        }
        $this->set("materialAdditionals", $result);
        $this->set("suppliers", ClassRegistry::init("Supplier")->find("list", ["fields" => ['Supplier.id', 'Supplier.name']]));
    }

    function generateSaleNumber() {
        $inc_id = 1;
        $Y = date('Y');
        $M = romanic_number(date('n'));
        $testCode = "[0-9]{4}/PNJL-MP-PRO/$M/$Y";
        $lastRecord = $this->MaterialAdditionalSale->find('first', array('conditions' => array('and' => array("MaterialAdditionalSale.no_sale regexp" => $testCode)), 'order' => array('MaterialAdditionalSale.no_sale' => 'DESC')));
        if (!empty($lastRecord)) {
            $current = substr($lastRecord['MaterialAdditionalSale']['no_sale'], 0, 4);
            $inc_id += $current;
        }
        $inc_id = sprintf("%04d", $inc_id);
        $kode = "$inc_id/PNJL-MP-PRO/$M/$Y";
        return $kode;
    }

    function admin_change_status_validate($validate_status_id, $material_additional_sale_id) {
        $this->autoRender = false;
        if ($this->request->is("PUT")) {
            $this->MaterialAdditionalSale->data['MaterialAdditionalSale']['id'] = $material_additional_sale_id;
            $this->MaterialAdditionalSale->data['MaterialAdditionalSale']['validate_status_id'] = $validate_status_id;
            $this->MaterialAdditionalSale->data['MaterialAdditionalSale']['validate_by_id'] = $this->stnAdmin->getEmployeeId();
            $this->MaterialAdditionalSale->data['MaterialAdditionalSale']['validate_datetime'] = date("Y-m-d H:i:s");
            if ($validate_status_id == 2) {
                //update stock material additional
                $dataMaterialAdditionalSale = ClassRegistry::init("MaterialAdditionalSale")->find("first", [
                    "conditions" => [
                        "MaterialAdditionalSale.id" => $material_additional_sale_id
                    ],
                    "contain" => [
                        "MaterialAdditionalSaleDetail"
                    ]
                ]);
                $updatedDataStock = [];
                foreach ($dataMaterialAdditionalSale['MaterialAdditionalSaleDetail'] as $detail) {
                    $is_lack_of_stock = false;
                    $dataMaterialAdditional = ClassRegistry::init("MaterialAdditional")->find("first", [
                        "conditions" => [
                            "MaterialAdditional.id" => $detail['material_additional_id']
                        ],
                        "recursive" => -1
                    ]);
                    $remaining_stock = $dataMaterialAdditional['MaterialAdditional']['quantity'] - $detail['quantity'];
                    if ($remaining_stock >= 0) {
                        $updatedDataStock[] = [
                            "MaterialAdditional" => [
                                "id" => $detail['material_additional_id'],
                                "quantity" => $remaining_stock
                            ]
                        ];
                    } else {
                        $is_lack_of_stock = true;
                        break;
                    }
                }
                if ($is_lack_of_stock) {
                    return json_encode($this->_generateStatusCode(407, "Quantity tidak cukup."));
                } else {
                    // saving the data
                    try {
                        foreach ($updatedDataStock as $data) {
                            ClassRegistry::init("MaterialAdditional")->save($data);
                        }
                    } catch (Exception $ex) {
                        return json_encode($this->_generateStatusCode(405, "Error found when saving the data."));
                    }
                }                
            } else if ($validate_status_id == 3) {
                $this->MaterialAdditionalSale->data['MaterialAdditionalSale']['validate_by_id'] = $this->_getEmployeeId();
                $this->MaterialAdditionalSale->data['MaterialAdditionalSale']['validate_datetime'] = date("Y-m-d H:i:s");
            } else {
                $this->MaterialAdditionalSale->data['MaterialAdditionalSale']['validate_by_id'] = null;
                $this->MaterialAdditionalSale->data['MaterialAdditionalSale']['validate_datetime'] = null;
            }
            $this->MaterialAdditionalSale->saveAll();
            $data = $this->MaterialAdditionalSale->find("first", array("conditions" => array("MaterialAdditionalSale.id" => $material_additional_sale_id), "contain" => ["ValidateStatus"]));
            return json_encode($this->_generateStatusCode(207, null, array("status_label" => $data['ValidateStatus']['name'])));
        } else {
            return json_encode($this->_generateStatusCode(400, "Invalid request data."));
        }
    }
    
    function admin_view($id = null) {
        if (!$this->{ Inflector::classify($this->name) }->exists($id)) {
            throw new NotFoundException(__("Id Not Found"));
        } else {
            $rows = $this->{ Inflector::classify($this->name) }->find("first", array(
                'conditions' => array(
                    Inflector::classify($this->name) . ".id" => $id
                ),
                'contain' => [
                    "MaterialAdditionalSaleDetail" => [
                        "MaterialAdditional"
                    ]
                ]
            ));
            $this->data = $rows;
        }
    }
    
    function admin_invoice_material_additional_sale() {
        $this->_setPeriodeLaporanDate("awal_MaterialAdditionalSale_sale_dt", "akhir_MaterialAdditionalSale_sale_dt");
        $this->contain = [
            "Supplier",
            "MaterialAdditionalSaleDetail" => [
                "MaterialAdditional"
            ],
            "Employee" => [
                "Account" => [
                    "Biodata"
                ]
            ]
        ];
        $this->conds = [
            "MaterialAdditionalSale.branch_office_id" => $this->stnAdmin->getBranchId(),
            "MaterialAdditionalSale.validate_status_id" => 2
        ];
        $this->order = "MaterialAdditionalSale.sale_dt DESC";
        parent::admin_index();
    }
    
    function admin_print_invoice_material_additional_sale($id = null) {
        $this->_activePrint(["print"], "print_invoice_material_additional_sale", "invoice_penjualan");
        $rows = $this->{ Inflector::classify($this->name) }->find('first', array(
            'conditions' => array(
                Inflector::classify($this->name) . '.id' => $id,
            ),
            "contain" => [
                "Supplier",
                "MaterialAdditionalSaleDetail" => [
                    "MaterialAdditional" => [
                        "MaterialAdditionalUnit"
                    ]
                ]
            ]
        ));
        $this->data = $rows;
        $data = array(
            'title' => 'Invoice',
            'rows' => $rows,
        );
        $this->set(compact('data'));
    }
    
    function admin_list_hutang() {
        $this->autoRender = false;
        $conds = [];
        if (isset($this->request->query['q'])) {
            $q = $this->request->query['q'];
            $conds[] = array(
                "or" => array(
                    "MaterialAdditionalSale.no_sale like" => "%$q%",
            ));
        }
        $suggestions = ClassRegistry::init("MaterialAdditionalSale")->find("all", array(
            "conditions" => [
                $conds,
                "MaterialAdditionalSale.total_remaining >" => 0,
                "MaterialAdditionalSale.validate_status_id" => 2
            ],
            "contain" => [
                "Supplier" => [
                    "City",
                    "State",
                    "Country",
                    "CpCity",
                    "CpState",
                    "CpCountry"
                ],
                "PaymentSaleMaterialAdditional"
            ],
            "limit"=>10,
        ));
        $result = [];
        foreach ($suggestions as $item) {
            if (!empty($item)) {
                if ($item['MaterialAdditionalSale']['branch_office_id'] == $this->Session->read("credential.admin.Employee.branch_office_id")) {
                    $result[] = [
                        "id" => @$item['MaterialAdditionalSale']['id'],
                        "no_sale" => @$item['MaterialAdditionalSale']['no_sale'],
                        "invoice_id" => @$item['PaymentSaleMaterialAdditional'][0]['id'],
                        "total_invoice" => @$item['MaterialAdditionalSale']['total'],
                        "supplier_id" => @$item['MaterialAdditionalSale']['supplier_id'],
                        "supplier_name" => @$item['Supplier']['name'],
                        "supplier_email" => @$item['Supplier']['email'],
                        "supplier_address" => @$item['Supplier']['address'],
                        "supplier_postal_code" => @$item['Supplier']['postal_code'],
                        "supplier_phone" => @$item['Supplier']['phone_number'],
                        "supplier_website" => @$item['Supplier']['website'],
                        "supplier_city" => @$item['Supplier']['City']['name'],
                        "supplier_state" => @$item['Supplier']['State']['name'],
                        "supplier_country" => @$item['Supplier']['Country']['name'],
                        "cp_name" => @$item['Supplier']['cp_name'],
                        "cp_position" => @$item['Supplier']['cp_position'],
                        "cp_address" => @$item['Supplier']['cp_address'],
                        "cp_phone_number" => @$item['Supplier']['cp_phone_number'],
                        "cp_email" => @$item['Supplier']['cp_email'],
                        "cp_city" => @$item['Supplier']['CpCity']['name'],
                        "cp_state" => @$item['Supplier']['CpState']['name'],
                        "cp_country" => @$item['Supplier']['CpCountry']['name']
                    ];
                }
            }
        }
        return json_encode($result);
    }
    
    function admin_get_data_material_additional_sale($material_additional_sale_id) {
        $this->autoRender = false;
        if($this->request->is("GET")) {
            if(!empty($material_additional_sale_id)) {
                $data = $this->MaterialAdditionalSale->find("first",[
                    "conditions" => [
                        "MaterialAdditionalSale.id" => $material_additional_sale_id
                    ],
                    "contain" => [
                        "MaterialAdditionalSaleDetail" => [
                            "MaterialAdditional" => [
                                "MaterialAdditionalUnit"
                            ]
                        ]
                    ]
                ]);
                return json_encode($this->_generateStatusCode(206, "Successfully retrieved the data.", $data));
            } else {
                return json_encode($this->_generateStatusCode(401));
            }
        } else {
            return json_encode($this->_generateStatusCode(400));
        }
    }
}
