<?php

App::uses('AppController', 'Controller');

class PurchaseOrderMaterialAdditionalsController extends AppController {

    var $name = "PurchaseOrderMaterialAdditionals";
    var $disabledAction = array(
    );
    var $contain = [
        "Employee" => [
            "Account" => [
                "Biodata",
            ],
        ],
        "PurchaseOrderMaterialAdditionalStatus",
        "MaterialAdditionalSupplier",
        "BranchOffice"
    ];

    function beforeFilter() {
        parent::beforeFilter();
        $this->_setPageInfo("admin_index", "");
        $this->_setPageInfo("admin_add", "");
        $this->_setPageInfo("admin_edit", "");
    }

    function admin_index() {
        $this->_activePrint(func_get_args(), "data_purchase_order_material_pembantu");
        $this->_setPeriodeLaporanDate("awal_PurchaseOrderMaterialAdditional_po_date", "akhir_PurchaseOrderMaterialAdditional_po_date");
        $this->conds = [
            "PurchaseOrderMaterialAdditional.branch_office_id" => $this->stnAdmin->roleBranchId(),
        ];
        $this->order = "PurchaseOrderMaterialAdditional.po_date desc";
        parent::admin_index();
    }

    function admin_index_history() {
        $this->_activePrint(func_get_args(), "data_histori_transaksi_material_pembantu");
        $this->_setPeriodeLaporanDate("awal_PurchaseOrderMaterialAdditional_po_date", "akhir_PurchaseOrderMaterialAdditional_po_date");
        $this->conds = [
            "PurchaseOrderMaterialAdditional.branch_office_id" => $this->stnAdmin->roleBranchId(),
        ];
        $this->contain = [
            "PurchaseOrderMaterialAdditionalStatus",
            "RequestOrderMaterialAdditional" => [
                "Employee" => [
                    "Account" => [
                        "Biodata"
                    ]
                ]
            ],
            "MaterialAdditionalSupplier",
            "Employee" => [
                "Account" => [
                    "Biodata"
                ]
            ],
            "BranchOffice"
        ];
        parent::admin_index();
    }

    function admin_process_order($request_order_id) {
        if ($this->request->is("post") || $this->request->is("put")) {
            $this->{ Inflector::classify($this->name) }->set($this->data);
            //$this->PurchaseOrderMaterialAdditional->_numberSeperatorRemover();
            if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                $this->PurchaseOrderMaterialAdditional->data['PurchaseOrderMaterialAdditional']['po_number'] = $this->generatePONumber();
                $this->PurchaseOrderMaterialAdditional->data['PurchaseOrderMaterialAdditional']['purchase_order_material_additional_status_id'] = 1;
                $this->{ Inflector::classify($this->name) }->data['PurchaseOrderMaterialAdditional']['employee_id'] = $this->Session->read("credential.admin.Employee.id");
                $this->{ Inflector::classify($this->name) }->data['PurchaseOrderMaterialAdditional']['branch_office_id'] = $this->stnAdmin->getBranchId();
                $updated = [];
                $grandTotal = 0;
                $this->{ Inflector::classify($this->name) }->data['PurchaseOrderMaterialAdditional']['shipment_cost'] = ic_number_reverse($this->{ Inflector::classify($this->name) }->data['PurchaseOrderMaterialAdditional']['shipment_cost']);
                foreach ($this->PurchaseOrderMaterialAdditional->data['PurchaseOrderMaterialAdditionalDetail'] as $index => $value) {
                    if (isset($value['is_used'])) {
                        $grandTotal += $value['price'] * $value['quantity'];
                        $updated['RequestOrderMaterialAdditionalDetail']['id'] = $value['request_order_material_additional_detail_id'];
                        $updated['RequestOrderMaterialAdditionalDetail']['is_used'] = 1;
                        ClassRegistry::init("RequestOrderMaterialAdditionalDetail")->saveAll($updated);
                        $this->{ Inflector::classify($this->name) }->data['PurchaseOrderMaterialAdditionalDetail'][$index]['price'] = ic_number_reverse($value['price']);
                    } else {
                        unset($this->PurchaseOrderMaterialAdditional->data['PurchaseOrderMaterialAdditionalDetail'][$index]);
                    }
                }
                $grandTotal += $this->PurchaseOrderMaterialAdditional->data['PurchaseOrderMaterialAdditional']['shipment_cost'];
                $this->PurchaseOrderMaterialAdditional->data['PurchaseOrderMaterialAdditional']['total'] = $grandTotal;
                $this->PurchaseOrderMaterialAdditional->data['PurchaseOrderMaterialAdditional']['remaining'] = $grandTotal;
                $dataRequestOrder = ClassRegistry::init("RequestOrderMaterialAdditional")->find("first", [
                    "conditions" => [
                        "RequestOrderMaterialAdditional.id" => $this->PurchaseOrderMaterialAdditional->data['PurchaseOrderMaterialAdditional']['request_order_material_additional_id']
                    ],
                    'contain' => [
                        "RequestOrderMaterialAdditionalDetail"
                    ]
                ]);
                $status = false;
                foreach ($dataRequestOrder['RequestOrderMaterialAdditionalDetail'] as $val) {
                    if ($val['is_used']) {
                        $status = true;
                    } else {
                        $status = false;
                    }
                }
                if ($status) {
                    $updatedData = [];
                    $updatedData['RequestOrderMaterialAdditional']['id'] = $this->PurchaseOrderMaterialAdditional->data['PurchaseOrderMaterialAdditional']['request_order_material_additional_id'];
                    $updatedData['RequestOrderMaterialAdditional']['po_status'] = 1;
                    ClassRegistry::init("RequestOrderMaterialAdditional")->saveAll($updatedData);
                }

                $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
                $this->Session->setFlash(__("Data berhasil disimpan"), 'default', array(), 'success');
                $this->redirect(array('action' => 'admin_purchase_order_material_additional', 'controller' => 'requestOrderMaterialAdditionals'));
            } else {
                $this->validationErrors = $this->{ Inflector::classify($this->name) }->validationErrors;
                $this->Session->setFlash(__("Harap mengecek kembali kesalahan dibawah."), 'default', array(), 'danger');
            }
        } else {
            $rows = $this->{ Inflector::classify($this->name) }->find("first", array(
                'conditions' => array(
                    "RequestOrderMaterialAdditional.id" => $request_order_id
                ),
                'contain' => [
                    "Employee" => [
                        "Account" => [
                            "Biodata"
                        ],
                        "Office",
                        "Department"
                    ],
                    "PurchaseOrderMaterialAdditionalDetail" => [
                        "MaterialAdditional" => [
                            "MaterialAdditionalUnit"
                        ]
                    ],
                    "MaterialAdditionalSupplier",
                    "RequestOrderMaterialAdditional"
                ]
            ));
            $this->data = $rows;
            $dataRequestOrderMaterials = ClassRegistry::init("RequestOrderMaterialAdditional")->find("first", [
                "conditions" => [
                    "RequestOrderMaterialAdditional.id" => $request_order_id
                ],
                "contain" => [
                    "RequestOrderMaterialAdditionalDetail" => [
                        "MaterialAdditional" => [
                            "MaterialAdditionalUnit"
                        ]
                    ]
                ]
            ]);
            $this->set(compact('dataRequestOrderMaterials'));
        }
    }

    function admin_edit($id = null) {
        if (!$this->{ Inflector::classify($this->name) }->exists($id)) {
            throw new NotFoundException(__('Data tidak ditemukan'));
        } else {
            if ($this->request->is("post") || $this->request->is("put")) {
                $this->{ Inflector::classify($this->name) }->set($this->data);
                $this->PurchaseOrderMaterialAdditional->_numberSeperatorRemover();
                $this->{ Inflector::classify($this->name) }->data[Inflector::classify($this->name)]['id'] = $id;
                if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                    if (!is_null($id)) {
                        $tempData = $this->{ Inflector::classify($this->name) }->find("first", array(
                            'conditions' => array(
                                Inflector::classify($this->name) . ".id" => $id
                            )
                        ));
                        if ($tempData['PurchaseOrderMaterialAdditional']['total'] == $this->PurchaseOrderMaterialAdditional->data['PurchaseOrderMaterialAdditional']['remaining']) {
                            $this->PurchaseOrderMaterialAdditional->data['PurchaseOrderMaterialAdditional']['remaining'] = $this->PurchaseOrderMaterialAdditional->data['PurchaseOrderMaterialAdditional']['total'];
                        } else {
                            $sudahBayar = $tempData['PurchaseOrderMaterialAdditional']['total'] - $this->PurchaseOrderMaterialAdditional->data['PurchaseOrderMaterialAdditional']['remaining'];
                            $this->PurchaseOrderMaterialAdditional->data['PurchaseOrderMaterialAdditional']['remaining'] = $this->PurchaseOrderMaterialAdditional->data['PurchaseOrderMaterialAdditional']['total'] - $sudahBayar;
                        }
                        foreach ($this->PurchaseOrderMaterialAdditional->data['PurchaseOrderMaterialAdditionalDetail'] as $k => $detail) {
                            $tempDetail = $this->{ Inflector::classify($this->name) }->PurchaseOrderMaterialAdditionalDetail->find("first", array(
                                'conditions' => array(
                                    "PurchaseOrderMaterialAdditionalDetail.id" => $detail['id']
                                )
                            ));
                            $qtyTemp = $tempDetail['PurchaseOrderMaterialAdditionalDetail']['quantity'];
                            $qtyRemaining = ic_number_reverse($detail['quantity_remaining']);
                            if ($qtyTemp == $qtyRemaining) { //floatval($tempDetail['PurchaseOrderMaterialAdditionalDetail']['quantity'])==floatval($detail['quantity_remaining'])
                                $this->PurchaseOrderMaterialAdditional->data['PurchaseOrderMaterialAdditionalDetail'][$k]['quantity_remaining'] = $detail['quantity'];
                            } else {
                                $selisih_quantity = $detail['quantity'] - $tempDetail['PurchaseOrderMaterialAdditionalDetail']['quantity'];
                                $this->PurchaseOrderMaterialAdditional->data['PurchaseOrderMaterialAdditionalDetail'][$k]['quantity'] = $detail['quantity'];
                                $this->PurchaseOrderMaterialAdditional->data['PurchaseOrderMaterialAdditionalDetail'][$k]['quantity_remaining'] = $tempDetail['PurchaseOrderMaterialAdditionalDetail']['quantity_remaining'] + $selisih_quantity;
                            }
                        }
                        
                        $this->PurchaseOrderMaterialAdditional->data['PurchaseOrderMaterialAdditional']['purchase_order_material_additional_status_id'] = 1;
                        $this->PurchaseOrderMaterialAdditional->data['PurchaseOrderMaterialAdditional']['verify_by_id'] = NULL;
                        
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
                        "Employee" => [
                            "Account" => [
                                "Biodata"
                            ],
                            "Office",
                            "Department"
                        ],
                        "PurchaseOrderMaterialAdditionalDetail" => [
                            "MaterialAdditional" => [
                                "MaterialAdditionalUnit"
                            ]
                        ],
                        "MaterialAdditionalSupplier",
                        "RequestOrderMaterialAdditional"
                    ]
                ));
                $this->data = $rows;
            }
        }
    }
    
    function admin_entry_edit($id = null) {
        if (!$this->{ Inflector::classify($this->name) }->exists($id)) {
            throw new NotFoundException(__('Data tidak ditemukan'));
        } else {
            if ($this->request->is("post") || $this->request->is("put")) {
                foreach ($this->data['MaterialAdditionalEntry'] as $k => $detail) {
                    $toUpdate = [
                        "MaterialAdditionalEntryDetail" => [
                            "id" => intval($detail['id']),
                            "entry_date" => $detail['entry_date']
                        ]
                    ];
                    ClassRegistry::init("MaterialAdditionalEntryDetail")->saveAll($toUpdate);
                }
                $this->redirect(array('action' => 'admin_entry', 'controller' => 'purchaseOrderMaterialAdditionals'));
            } else {
                $rows = $this->{ Inflector::classify($this->name) }->find("first", array(
                    'conditions' => array(
                        Inflector::classify($this->name) . ".id" => $id
                    ),
                    'contain' => [
                        "Employee" => [
                            "Account" => [
                                "Biodata"
                            ],
                            "Office",
                            "Department"
                        ],
                        "PurchaseOrderMaterialAdditionalDetail" => [
                                "MaterialAdditional"
                        ],
                        "MaterialAdditionalEntry" => [
                            "MaterialAdditionalEntryDetail" => [
                                "MaterialAdditional" => [
                                    "MaterialAdditionalUnit"
                                ]
                            ]
                        ],
                        "MaterialAdditionalSupplier",
                        "RequestOrderMaterialAdditional"
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
        $this->set("materialAdditional", ClassRegistry::init("MaterialAdditional")->find("all", array("fields" => array("MaterialAdditional.id", "MaterialAdditional.name"))));
        $this->set("materialAdditionalSuppliers", ClassRegistry::init("MaterialAdditionalSupplier")->find("list", array("fields" => array("MaterialAdditionalSupplier.id", "MaterialAdditionalSupplier.name"))));
        $this->set("branchOffices", $this->PurchaseOrderMaterialAdditional->BranchOffice->find("list", array("fields" => array("BranchOffice.id", "BranchOffice.name"))));
        $this->set("countries", ClassRegistry::init("Country")->find("list", ["fields" => ["Country.id", "Country.name"]]));
        $this->set("states", ClassRegistry::init("State")->find("list", ["fields" => ["State.id", "State.name"]]));
        $this->set("cities", ClassRegistry::init("City")->find("list", ["fields" => ["City.id", "City.name"]]));
        $this->set("purchaseOrderMaterialAdditionalStatuses", ClassRegistry::init("PurchaseOrderMaterialAdditionalStatus")->find("list", ["fields" => ["PurchaseOrderMaterialAdditionalStatus.id", "PurchaseOrderMaterialAdditionalStatus.name"]]));
    }

    function generatePONumber() {
        $inc_id = 1;
        $Y = date('Y');
        $month = romanic_number(date("n"));
        $testCode = "[0-9]{4}/MPPO-PRO/$month/$Y";
        $lastRecord = $this->PurchaseOrderMaterialAdditional->find('first', array('conditions' => array('and' => array("PurchaseOrderMaterialAdditional.po_number regexp" => $testCode)), 'order' => array('PurchaseOrderMaterialAdditional.po_number' => 'DESC')));
        if (!empty($lastRecord)) {
            $current = substr($lastRecord['PurchaseOrderMaterialAdditional']['po_number'], 0, 4);
            $inc_id += $current;
        }
        $inc_id = sprintf("%04d", $inc_id);
        $kode = "$inc_id/MPPO-PRO/$month/$Y";
        return $kode;
    }

    function admin_print_purchase_order($id = null) {
        $this->_activePrint(["print"], "print_purchase_order", "form_izin");
        if ($this->{ Inflector::classify($this->name) }->exists($id)) {
            $rows = $this->{ Inflector::classify($this->name) }->find('first', array(
                'conditions' => array(
                    Inflector::classify($this->name) . '.id' => $id,
                    Inflector::classify($this->name) . '.purchase_order_material_additional_status_id' => 2,
                ),
                'contain' => [
                    "PurchaseOrderMaterialAdditionalStatus",
                    "PurchaseOrderMaterialAdditionalDetail" => [
                        "MaterialAdditional" => [
                            "MaterialAdditionalUnit"
                        ]
                    ],
                    "MaterialAdditionalSupplier" => [
                        "City",
                        "State"
                    ],
                    "Employee" => [
                        "Account" => [
                            "Biodata" => [
                                "Religion"
                            ]
                        ],
                        "Office",
                        "Department"
                    ],
                    "VerifiedBy" => [
                        "Account" => [
                            "Biodata" => [
                            ]
                        ],
                    ],
                ],
            ));
            $this->data = $rows;
            $data = array(
                'title' => 'PT. CHEN WOO FISHERY <br>Jl. Kima 4 Block K9/B2, Kawasan Industri Makassar <br> Telp : 0411 - 515263 <br> Fax : 0411 - 515484 ',
                'rows' => $rows,
            );
            $this->set(compact('data'));
        } else {
            throw new NotFoundException(__("404 Data Not Found."));
        }
    }

    function admin_get_data_po_material_additional($id = null) {
        $this->autoRender = false;
        if ($this->PurchaseOrderMaterialAdditional->exists($id)) {
            if ($this->request->is("GET")) {
                $data = $this->PurchaseOrderMaterialAdditional->find("first", [
                    "conditions" => [
                        "PurchaseOrderMaterialAdditional.id" => $id
                    ],
                    "contain" => [
                        "PurchaseOrderMaterialAdditionalDetail" => [
                            "MaterialAdditional" => [
                                "MaterialAdditionalUnit"
                            ]
                        ],
                        "MaterialAdditionalSupplier"
                    ]
                ]);
                echo json_encode($this->_generateStatusCode(206, null, $data));
            } else {
                echo json_encode($this->_generateStatusCode(400));
            }
        } else {
            echo json_encode($this->_generateStatusCode(401));
        }
    }

    function admin_change_status_verify() {
        $this->autoRender = false;
        if ($this->request->is("PUT")) {
            $this->PurchaseOrderMaterialAdditional->data['PurchaseOrderMaterialAdditional']['id'] = $this->request->data['id'];
            $this->PurchaseOrderMaterialAdditional->data['PurchaseOrderMaterialAdditional']['purchase_order_material_additional_status_id'] = $this->request->data['status'];
            if ($this->request->data['status'] == '2') {
                $this->PurchaseOrderMaterialAdditional->data['PurchaseOrderMaterialAdditional']['verified_by_id'] = $this->_getEmployeeId();
                $this->PurchaseOrderMaterialAdditional->data['PurchaseOrderMaterialAdditional']['verified_datetime'] = date("Y-m-d H:i:s");

                $dataPOMaterialAdditional = ClassRegistry::init("PurchaseOrderMaterialAdditional")->find("first", [
                    "conditions" => [
                        "PurchaseOrderMaterialAdditional.id" => $this->request->data['id']
                    ]
                ]);
                $purchaseOrderMaterialAdditionalDetail = ClassRegistry::init("PurchaseOrderMaterialAdditionalDetail")->find("all", [
                    "conditions" => [
                        "PurchaseOrderMaterialAdditionalDetail.purchase_order_material_additional_id" => $dataPOMaterialAdditional["PurchaseOrderMaterialAdditional"]["id"]
                    ],
                    "contain" => [
                        "MaterialAdditional" => [
                            "MaterialAdditionalCategory"
                        ]
                    ]
                ]);
                $updated = [];
                $grandTotal = 0;
                $materialAdditionalNames = "Pembelian ";
                $transaction_names = [];
                $amounts = [];
                $general_entry_types_id = [];
                $debits_or_credits = [];
                foreach ($purchaseOrderMaterialAdditionalDetail as $index => $value) {
                    if ($value['PurchaseOrderMaterialAdditionalDetail']['is_used'] == true) {
                        $grandTotal += $value['PurchaseOrderMaterialAdditionalDetail']['price'] * $value['PurchaseOrderMaterialAdditionalDetail']['quantity'];
                        $amounts[$index] = $value['PurchaseOrderMaterialAdditionalDetail']['price'] * $value['PurchaseOrderMaterialAdditionalDetail']['quantity'];
                        $updated['RequestOrderMaterialAdditionalDetail']['id'] = $value['PurchaseOrderMaterialAdditionalDetail']['request_order_material_additional_detail_id'];
                        $updated['RequestOrderMaterialAdditionalDetail']['is_used'] = 1;
                        ClassRegistry::init("RequestOrderMaterialAdditionalDetail")->saveAll($updated);
                        if ($index != count($purchaseOrderMaterialAdditionalDetail) - 1) {
                            $materialAdditionalNames .= $value['MaterialAdditional']['MaterialAdditionalCategory']['name'] . ", ";
                        } else {
                            $materialAdditionalNames .= $value['MaterialAdditional']['MaterialAdditionalCategory']['name'];
                        }
                        $transaction_names[$index] = "Biaya " . $value['MaterialAdditional']['MaterialAdditionalCategory']['name'];
                        $dataGeneralEntryType = ClassRegistry::init("GeneralEntryType")->find("first", [
                            "conditions" => [
                                "GeneralEntryType.name like" => "%$transaction_names[$index]%"
                            ],
                            "recursive" => -1
                        ]);
                        $general_entry_types_id[$index] = $dataGeneralEntryType['GeneralEntryType']['id'];
                        $debits_or_credits[$index] = "debit";
                    } else {
                        unset($purchaseOrderMaterialAdditionalDetail[$index]);
                    }
                }
                $amounts[] = $dataPOMaterialAdditional['PurchaseOrderMaterialAdditional']['shipment_cost'];
                $grandTotal += $dataPOMaterialAdditional['PurchaseOrderMaterialAdditional']['shipment_cost'];
                $amount = $grandTotal;
                $amounts[] = $grandTotal;
                $this->PurchaseOrderMaterialAdditional->data['PurchaseOrderMaterialAdditional']['total'] = $grandTotal;
                $this->PurchaseOrderMaterialAdditional->data['PurchaseOrderMaterialAdditional']['remaining'] = $grandTotal;
                $dataRequestOrder = ClassRegistry::init("RequestOrderMaterialAdditional")->find("first", [
                    "conditions" => [
                        "RequestOrderMaterialAdditional.id" => $dataPOMaterialAdditional['PurchaseOrderMaterialAdditional']['request_order_material_additional_id']
                    ],
                    'contain' => [
                        "RequestOrderMaterialAdditionalDetail"
                    ]
                ]);
                $status = false;
                foreach ($dataRequestOrder['RequestOrderMaterialAdditionalDetail'] as $val) {
                    if ($val['is_used']) {
                        $status = true;
                    } else {
                        $status = false;
                    }
                }
                if ($status) {
                    $updatedData = [];
                    $updatedData['RequestOrderMaterialAdditional']['id'] = $dataPOMaterialAdditional['PurchaseOrderMaterialAdditional']['request_order_material_additional_id'];
                    $updatedData['RequestOrderMaterialAdditional']['po_status'] = 1;
                    ClassRegistry::init("RequestOrderMaterialAdditional")->saveAll($updatedData);
                }

                /* declared the requirement variables for posting to Transaction Mutation & General Entry purposes */
                $reference_number = $dataPOMaterialAdditional['PurchaseOrderMaterialAdditional']['po_number'];
                $transaction_date = date("Y-m-d");
                $transaction_type_id = 4;
                $relation_table_name = "purchase_order_material_additional_id";
                $relation_table_id = $this->request->data['id'];

                // for Transaction Mutation                
                $transaction_name = $materialAdditionalNames;
                $debit_or_credit_type = "credit";

                // for General Entry
                $general_entry_account_type_id = 1;
                array_push($debits_or_credits, "debit", "credit");
                array_push($transaction_names, "Biaya Pengiriman Material Pembantu", "Hutang Dagang");
                $dataMaterialAdditionalDelivery = ClassRegistry::init("GeneralEntryType")->find("first", [
                    "conditions" => [
                        "GeneralEntryType.name" => "Biaya Pengiriman Material Pembantu"
                    ],
                    "recursive" => -1
                ]);
                array_push($general_entry_types_id, $dataMaterialAdditionalDelivery['GeneralEntryType']['id'], 35);

                /* posting to Transaction Mutation Table */
                ClassRegistry::init("TransactionMutation")->post_transaction($reference_number, $transaction_name, $transaction_date, $transaction_type_id, $debit_or_credit_type, $amount, $relation_table_name, $relation_table_id);

                /* posting to General Entry Table */
                ClassRegistry::init("GeneralEntry")->post_to_journal($reference_number, $transaction_names, $debits_or_credits, $transaction_date, $transaction_type_id, $general_entry_types_id, $amounts, $general_entry_account_type_id, $relation_table_name, $relation_table_id);
            } else if ($this->request->data['status'] == '3') {
                $this->PurchaseOrderMaterialAdditional->data['PurchaseOrderMaterialAdditional']['verified_by_id'] = $this->_getEmployeeId();
                ;
                $this->PurchaseOrderMaterialAdditional->data['PurchaseOrderMaterialAdditional']['verified_datetime'] = date('Y-m-d H:i:s');
            } else {
                $this->PurchaseOrderMaterialAdditional->data['PurchaseOrderMaterialAdditional']['verified_by_id'] = null;
                $this->PurchaseOrderMaterialAdditional->data['PurchaseOrderMaterialAdditional']['verified_datetime'] = null;
            }
            $this->PurchaseOrderMaterialAdditional->saveAll();
            $data = $this->PurchaseOrderMaterialAdditional->find("first", array("conditions" => array("PurchaseOrderMaterialAdditional.id" => $this->request->data['id'])));
            echo json_encode($this->_generateStatusCode(207, null, array("status_label" => $data['PurchaseOrderMaterialAdditionalStatus']['name'])));
        } else {
            echo json_encode($this->_generateStatusCode(400));
        }
    }

    function admin_entry() {
        $this->_activePrint(func_get_args(), "data_barang_masuk_material_pembantu");
        $this->_setPeriodeLaporanDate("awal_PurchaseOrderMaterialAdditional_po_date", "akhir_PurchaseOrderMaterialAdditional_po_date");
        $this->contain = [
            "Employee" => [
                "Account" => [
                    "Biodata",
                ],
            ],
            "PurchaseOrderMaterialAdditionalDetail" => [
                "MaterialAdditional"
            ],
            "PurchaseOrderMaterialAdditionalStatus",
            "MaterialAdditionalSupplier",
            "BranchOffice"
        ];
        $this->conds = [
            "PurchaseOrderMaterialAdditional.branch_office_id" => $this->stnAdmin->roleBranchId(),
            "PurchaseOrderMaterialAdditional.purchase_order_material_additional_status_id" => 2
        ];
        parent::admin_index();
    }

    function admin_validate() {
        $this->_activePrint(func_get_args(), "data_validasi_purchase_order_material_pembantu");
        $this->_setPeriodeLaporanDate("awal_PurchaseOrderMaterialAdditional_po_date", "akhir_PurchaseOrderMaterialAdditional_po_date");
        $this->conds = [
            "PurchaseOrderMaterialAdditional.purchase_order_material_additional_status_id" => 1
        ];
        parent::admin_index();
    }

    function admin_list() {
        $this->autoRender = false;
        $conds = [];
        if (isset($this->request->query['q'])) {
            $q = $this->request->query['q'];
            $conds[] = array(
                "or" => array(
                    "PurchaseOrderMaterialAdditional.po_number like" => "%$q%",
            ));
        }
        $suggestions = ClassRegistry::init("PurchaseOrderMaterialAdditional")->find("all", array(
            "conditions" => [
                $conds,
                "PurchaseOrderMaterialAdditional.remaining >" => 0,
                "PurchaseOrderMaterialAdditional.purchase_order_material_additional_status_id" => 2,
            ],
            "contain" => [
                "PurchaseOrderMaterialAdditionalDetail" => [
                    "MaterialAdditional"
                ],
                "MaterialAdditionalSupplier" => [
                    "City",
                    "State",
                    "Country",
                    "CpCity",
                    "CpState",
                    "CpCountry"
                ],
                "Employee",
                "PaymentPurchaseMaterialAdditional"
            ],
            "limit" => 10,
        ));
        $result = [];
        foreach ($suggestions as $item) {
            if (!empty($item)) {
                if ($item['Employee']['branch_office_id'] == $this->Session->read("credential.admin.Employee.branch_office_id")) {
                    $dataInvoice = array_reverse(@$item['PaymentPurchaseMaterialAdditional']);
                    $result[] = [
                        "id" => @$item['PurchaseOrderMaterialAdditional']['id'],
                        "total" => @$item['PurchaseOrderMaterialAdditional']['total'],
                        "remaining" => @$item['PurchaseOrderMaterialAdditional']['remaining'],
                        "po_number" => @$item['PurchaseOrderMaterialAdditional']['po_number'],
                        "invoice_id" => @$dataInvoice[0]['id'],
                        "supplier_name" => @$item['MaterialAdditionalSupplier']['name'],
                        "email_supplier" => @$item['MaterialAdditionalSupplier']['email'],
                        "city_supplier" => @$item['MaterialAdditionalSupplier']['City']['name'],
                        "state_supplier" => @$item['MaterialAdditionalSupplier']['State']['name'],
                        "country_supplier" => @$item['MaterialAdditionalSupplier']['Country']['name'],
                        "address_supplier" => @$item['MaterialAdditionalSupplier']['address'],
                        "postal_supplier" => @$item['MaterialAdditionalSupplier']['postal_code'],
                        "phone_supplier" => @$item['MaterialAdditionalSupplier']['phone'],
                        "phone_number_supplier" => @$item['MaterialAdditionalSupplier']['phone_number'],
                        "cp_name" => @$item['MaterialAdditionalSupplier']['cp_name'],
                        "cp_position" => @$item['MaterialAdditionalSupplier']['cp_position'],
                        "cp_address" => @$item['MaterialAdditionalSupplier']['cp_address'],
                        "cp_phone_number" => @$item['MaterialAdditionalSupplier']['cp_phone_number'],
                        "cp_email" => @$item['MaterialAdditionalSupplier']['cp_email'],
                        "cp_city" => @$item['MaterialAdditionalSupplier']['CpCity']['name'],
                        "cp_state" => @$item['MaterialAdditionalSupplier']['CpState']['name'],
                        "cp_country" => @$item['MaterialAdditionalSupplier']['CpCountry']['name'],
                    ];
                }
            }
        }
        echo json_encode($result);
    }

    function admin_list_lunas() {
        $this->autoRender = false;
        $conds = [];
        if (isset($this->request->query['q'])) {
            $q = $this->request->query['q'];
            $conds[] = array(
                "or" => array(
                    "PurchaseOrderMaterialAdditional.po_number like" => "%$q%",
            ));
        }
        $suggestions = ClassRegistry::init("PurchaseOrderMaterialAdditional")->find("all", array(
            "conditions" => [
                $conds,
                "PurchaseOrderMaterialAdditional.remaining <=" => 0,
            ],
            "contain" => [
                "PurchaseOrderMaterialAdditionalDetail" => [
                    "MaterialAdditional"
                ],
                "MaterialAdditionalSupplier" => [
                    "City",
                    "State",
                    "Country",
                    "CpCity",
                    "CpState",
                    "CpCountry",
                ],
                "BranchOffice",
                "PaymentPurchaseMaterialAdditional",
                "Employee"
            ],
            "limit" => 10,
        ));
        $result = [];
        foreach ($suggestions as $item) {
            if (!empty($item)) {
                if ($item['Employee']['branch_office_id'] == $this->Session->read("credential.admin.Employee.branch_office_id")) {
                    $dataInvoice = array_reverse(@$item['PaymentPurchaseMaterialAdditional']);
                    $result[] = [
                        "id" => @$item['PurchaseOrderMaterialAdditional']['id'],
                        "total" => @$item['PurchaseOrderMaterialAdditional']['total'],
                        "remaining" => @$item['PurchaseOrderMaterialAdditional']['remaining'],
                        "po_number" => @$item['PurchaseOrderMaterialAdditional']['po_number'],
                        "invoice_id" => @$dataInvoice[0]['id'],
                        "supplier_name" => @$item['MaterialAdditionalSupplier']['name'],
                        "email" => @$item['MaterialAdditionalSupplier']['email'],
                        "address" => @$item['MaterialAdditionalSupplier']['address'],
                        "postal_code" => @$item['MaterialAdditionalSupplier']['postal_code'],
                        "phone" => @$item['MaterialAdditionalSupplier']['phone_number'],
                        "website" => @$item['MaterialAdditionalSupplier']['website'],
                        "city" => @$item['MaterialAdditionalSupplier']['City']['name'],
                        "state" => @$item['MaterialAdditionalSupplier']['State']['name'],
                        "country" => @$item['MaterialAdditionalSupplier']['Country']['name'],
                        "cp_name" => @$item['MaterialAdditionalSupplier']['cp_name'],
                        "cp_position" => @$item['MaterialAdditionalSupplier']['cp_position'],
                        "cp_address" => @$item['MaterialAdditionalSupplier']['cp_address'],
                        "cp_phone_number" => @$item['MaterialAdditionalSupplier']['cp_phone_number'],
                        "cp_email" => @$item['MaterialAdditionalSupplier']['cp_email'],
                        "cp_city" => @$item['MaterialAdditionalSupplier']['CpCity']['name'],
                        "cp_state" => @$item['MaterialAdditionalSupplier']['CpState']['name'],
                        "cp_country" => @$item['MaterialAdditionalSupplier']['CpCountry']['name'],
                        "branch_office_id" => @$item['PurchaseOrderMaterialAdditional']['branch_office_id'],
                    ];
                }
            }
        }
        echo json_encode($result);
    }

    function admin_debt_list() {
        $this->_activePrint(func_get_args(), "data_hutang_usaha_material_pembantu");
        $this->_setPeriodeLaporanDate("awal_PurchaseOrderMaterialAdditional_po_date", "akhir_PurchaseOrderMaterialAdditional_po_date");
        $conds = [];
        $this->contain = [
            "PaymentPurchaseMaterialAdditional" => [
                "order" => "PaymentPurchaseMaterialAdditional.id DESC",
                "conditions" => [
                ],
                "limit" => 1,
            ],
            "Employee",
            "MaterialAdditionalSupplier",
            "BranchOffice"
        ];
        $this->conds = [
            "PurchaseOrderMaterialAdditional.remaining >" => 0,
            "PurchaseOrderMaterialAdditional.purchase_order_material_additional_status_id" => 2,
            $conds
        ];
        parent::admin_index();
    }

    function admin_payment_debt_material_additional_index() {
        $this->contain = [
            "MaterialAdditionalSupplier" => [
                "Country",
                "City",
                "State"
            ]
        ];
        $this->conds = [
            "PurchaseOrderMaterialAdditional.purchase_order_material_additional_status_id" => 2
        ];
        $this->order = "MaterialAdditionalSupplier.name";
        $conds = $this->_filter($this->request->query, $this->filterCond);
        if (empty($conds)) {
            $conds = $this->defaultConds;
        }
        $conds['AND'] = am($conds, array(
                ), $this->conds);
        if ($this->order === false) {
            $this->order = Inflector::classify($this->name) . '.created desc';
        }

        $this->Paginator->settings = array(
            Inflector::classify($this->name) => array(
                'conditions' => $conds,
                'limit' => $this->paginate['limit'],
                'maxLimit' => $this->paginate['maxLimit'],
                'order' => $this->order,
                'recursive' => -1,
                'contain' => $this->contain,
            )
        );

        $rows = $this->Paginator->paginate($this->{ Inflector::classify($this->name) });
        $data = array(
            'rows' => $rows,
        );
        $this->set(compact('data'));
    }

    function admin_setup_payment_debt_material_additional($material_additional_supplier_id) {
        if ($this->request->is("post")) {
            if (!empty($material_additional_supplier_id)) {
                $this->{ Inflector::classify($this->name) }->set($this->data);
                if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                    $dataPOMaterialAdditional = "?po_material_additional_ids=";
                    foreach ($this->PurchaseOrderMaterialAdditional->data['PurchaseOrderMaterialAdditional'] as $index => $poMaterialAdditional) {
                        if ($index != (count($poMaterialAdditional) - 1)) {
                            $dataPOMaterialAdditional .= $poMaterialAdditional['purchase_order_material_additional_id'] . ",";
                        } else {
                            $dataPOMaterialAdditional .= $poMaterialAdditional['purchase_order_material_additional_id'];
                        }
                    }
                    $this->redirect(array('action' => 'admin_payment_debt_material_additional' . $dataPOMaterialAdditional, 'controller' => 'payment_purchase_material_additionals'));
                } else {
                    $this->validationErrors = $this->{ Inflector::classify($this->name) }->validationErrors;
                    $this->Session->setFlash(__("Harap mengecek kembali kesalahan dibawah."), 'default', array(), 'danger');
                }
            } else {
                $this->Session->setFlash(__("ID Purchase Order Material Pembantu Kosong."), 'default', array(), 'danger');
                $this->redirect(array('action' => 'admin_payment_debt_material_additional_index'));
            }
        } else {
            $data = $this->PurchaseOrderMaterialAdditional->find("all", [
                "conditions" => [
                    "MaterialAdditionalSupplier.id" => $material_additional_supplier_id
                ],
                "contain" => [
                    "MaterialAdditionalSupplier"
                ]
            ]);
            $this->set("material_additional_supplier_id", $material_additional_supplier_id);
            $this->set(compact("data"));
        }
    }

    function admin_debt_list_report() {
        $this->_activePrint(func_get_args(), "laporan_hutang_usaha_material_pembantu_per_supplier");
    }

}
