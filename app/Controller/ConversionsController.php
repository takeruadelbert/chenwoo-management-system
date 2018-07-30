<?php

App::uses('AppController', 'Controller');

class ConversionsController extends AppController {

    var $name = "Conversions";
    var $disabledAction = array(
    );
    var $contain = [
        "Employee" => [
            "Account" => [
                "Biodata",
            ],
        ],
        "VerifyStatus",
        "VerifiedBy" => [
            "Account" => [
                "Biodata"
            ]
        ],
        "MaterialEntry" => [
            "Supplier",
        ],
        "BranchOffice",
        "ValidateStatus"
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
            if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                foreach ($this->data['MaterialProcess'] as $k => $params) {
                    $MaterialEntryGrade = ClassRegistry::init("MaterialEntryGrade")->find("first", [
                        "conditions" => [
                            "MaterialEntryGrade.material_entry_id" => intval($this->data['Conversion']['material_entry_id']),
                        ],
                    ]);
                    ClassRegistry::init("MaterialEntryGrade")->updateAll(
                            array("remaining_weight" => intval(intval($MaterialEntryGrade['MaterialEntryGrade']['remaining_weight']) - intval($params['weight']))), //fields to update
                            array(
                        "material_entry_id" => intval($this->data['Conversion']['material_entry_id']),
                        "material_detail_id" => intval($params['material_detail_id']),
                        "material_size_id" => intval($params['material_size_id']),
                            //"transaction_material_entry_detail_id" => intval($params['transaction_material_entry_detail_id']),
                            )  //condition
                    );

                    $toUpdateMaterialEntryDetail = [
                        "MaterialEntryGradeDetail" => [
                            "id" => intval($params['material_entry_grade_detail_id']),
                            "is_used" => 1
                        ]
                    ];
                    ClassRegistry::init("MaterialEntryGradeDetail")->saveAll($toUpdateMaterialEntryDetail);
                }
                //Check Transaction Record and Close
                $MaterialEntryGrade = ClassRegistry::init("MaterialEntryGrade")->find("first", [
                    "conditions" => [
                        "MaterialEntryGrade.material_entry_id" => intval($this->data['Conversion']['material_entry_id']),
                    ],
                ]);
                if ($MaterialEntryGrade['MaterialEntryGrade']['remaining_weight'] == 0) {
                    $toUpdateMaterialEntry = [
                        "MaterialEntry" => [
                            "id" => intval($MaterialEntryGrade['MaterialEntryGrade']['material_entry_id']),
                            "is_used" => 1
                        ]
                    ];
                    ClassRegistry::init("MaterialEntry")->saveAll($toUpdateMaterialEntry);
                }

//            foreach ($this->data['ConversionData'] as $k => $params) {
//                for ($i = 0; $i < intval($params['product_quantity']); $i++) {
//                    $toUpdateProductData = [
//                        "ProductData" => [
//                            "serial_number" => $this->generateSerialNumber(),
//                            "transaction_entry_id" => intval($this->data['Conversion']['transaction_entry_id']),
//                            "product_size_id" => intval($params['product_size_id']),
//                            "product_status_id" => 1
//                        ]
//                    ];
//                    ClassRegistry::init("ProductData")->saveAll($toUpdateProductData);
//                }
//
//                $toUpdateTransactionEntry = [
//                    "TransactionEntry" => [
//                        "id" => intval($this->data['Conversion']['transaction_entry_id']),
//                        "used" => 1
//                    ]
//                ];
//                ClassRegistry::init("TransactionEntry")->saveAll($toUpdateTransactionEntry);
//
//                $product = ClassRegistry::init("ProductSize")->find("first", [
//                    "conditions" => [
//                        "ProductSize.id" => $params['product_size_id'],
//                    ],
//                ]);
//                $toUpdateProduct = [
//                    "ProductSize" => [
//                        "id" => intval($params['product_size_id']),
//                        "quantity" => $product["ProductSize"]["quantity"] + intval($params['product_quantity'])
//                    ]
//                ];
//                ClassRegistry::init("ProductSize")->saveAll($toUpdateProduct);
//            }
                $this->{ Inflector::classify($this->name) }->data['Conversion']['branch_office_id'] = $this->stnAdmin->getBranchId();
                $this->{ Inflector::classify($this->name) }->data["Conversion"]['no_conversion'] = $this->generateTransactionConversionNumber();
                $this->{ Inflector::classify($this->name) }->data["Conversion"]['employee_id'] = $this->Session->read("credential.admin.Employee.id");
                if ($this->Conversion->data['Conversion']['ratio'] >= 55 && $this->Conversion->data['Conversion']['ratio'] <= 100) {
                    $this->Conversion->data['Conversion']['verify_status_id'] = 3;
                    $this->Conversion->data['Conversion']['verified_by_id'] = $this->_getEmployeeId();
                    $this->Conversion->data['Conversion']['verified_datetime'] = date("Y-m-d H:i:s");
                } else {
                    $this->Conversion->data['Conversion']['verify_status_id'] = 1;
                }
                $toUpdateMaterialEntry = [
                    "MaterialEntry" => [
                        "id" => intval($this->data['Conversion']['material_entry_id']),
                        "stage_id" => 2
                    ]
                ];
                ClassRegistry::init("MaterialEntry")->saveAll($toUpdateMaterialEntry);
                $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));


                $this->Session->setFlash(__("Data berhasil disimpan"), 'default', array(), 'success');
                $this->redirect(array('action' => 'admin_index'));
            } else {
                $this->validationErrors = $this->{ Inflector::classify($this->name) }->validationErrors;
                $this->Session->setFlash(__("Harap mengecek kembali kesalahan dibawah."), 'default', array(), 'danger');
            }
        }
        $this->set("dataMaterialSize", ClassRegistry::init("MaterialSize")->find("all", array("fields" => array("MaterialSize.id", "MaterialSize.name"))));
        $this->set("dataMaterial", ClassRegistry::init("Material")->find("all", array("fields" => array("Material.id", "Material.name"), "contain" => array("MaterialDetail"), "conditions" => array("Material.material_category_id" => 2))));
        $this->set("materialEntries", ClassRegistry::init("MaterialEntry")->find("list", array("fields" => array("MaterialEntry.id", "MaterialEntry.material_entry_number"), "conditions" => array('MaterialEntry.is_used' => 0))));
    }

    function admin_edit($id = null) {
        if (!$this->{ Inflector::classify($this->name) }->exists($id)) {
            throw new NotFoundException(__('Data tidak ditemukan'));
        } else {
            if ($this->request->is("post") || $this->request->is("put")) {
                $this->{ Inflector::classify($this->name) }->set($this->data);
                $this->{ Inflector::classify($this->name) }->data[Inflector::classify($this->name)]['id'] = $id;
                $this->{ Inflector::classify($this->name) }->data[Inflector::classify($this->name)]['validate_status_id'] = 1;
                $this->{ Inflector::classify($this->name) }->data[Inflector::classify($this->name)]['validate_by_id'] = NULL;
                $this->{ Inflector::classify($this->name) }->data[Inflector::classify($this->name)]['validate_datetime'] = NULL;
                if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {

                    $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));

                    $this->Session->setFlash(__("Data berhasil disimpan"), 'default', array(), 'success');
                    $this->redirect(array('action' => 'admin_index'));
                } else {
                    $this->validationErrors = $this->{ Inflector::classify($this->name) }->validationErrors;
                }
            } else {
                $rows = $this->{ Inflector::classify($this->name) }->find("first", array(
                    'conditions' => array(
                        Inflector::classify($this->name) . ".id" => $id
                    ),
                    'contain' => [
                        "ConversionData",
                        "MaterialEntry",
                        "MaterialEntryGrade",
                        "Operator" => [
                            "Account" => [
                                "Biodata"
                            ],
                            "Department",
                            "Office"
                        ],
                        "Employee" => [
                            "Account" => [
                                "Biodata"
                            ],
                            "Department",
                            "Office"
                        ],
                        "Freeze",
                    ],
                    'recursive' => -1
                ));
                $this->data = $rows;
                $this->set(compact('rows'));
            }
        }
        $this->set("rejectedGradeTypes", ClassRegistry::init("RejectedGradeType")->find("list", array("fields" => array("RejectedGradeType.id", "RejectedGradeType.name"))));
        $this->set("dataMaterialSize", ClassRegistry::init("MaterialSize")->find("all", array("fields" => array("MaterialSize.id", "MaterialSize.name"))));
        $this->set("dataMaterial", ClassRegistry::init("Material")->find("all", array("fields" => array("Material.id", "Material.name"), "contain" => array("MaterialDetail"), "conditions" => array("Material.material_category_id" => 2))));
        $this->set("materialEntries", ClassRegistry::init("MaterialEntry")->find("list", array("fields" => array("MaterialEntry.id", "MaterialEntry.material_entry_number"), "conditions" => array('MaterialEntry.is_used' => 0))));
    }

    function admin_change_status_verify() {
        $this->autoRender = false;
        if ($this->request->is("PUT")) {
            $this->Conversion->data['Conversion']['id'] = $this->request->data['id'];
            $this->Conversion->data['Conversion']['verify_status_id'] = $this->request->data['status'];
            if ($this->request->data['status'] == '3') {
                $this->Conversion->data['Conversion']['verified_by_id'] = $this->_getEmployeeId();
                $this->Conversion->data['Conversion']['verified_datetime'] = date("Y-m-d H:i:s");
            } else if ($this->request->data['status'] == '2') {
                $this->Conversion->data['Conversion']['verified_by_id'] = $this->_getEmployeeId();
                $this->Conversion->data['Conversion']['verified_datetime'] = date("Y-m-d H:i:s");
            } else {
                $this->Conversion->data['Conversion']['verified_by_id'] = null;
                $this->Conversion->data['Conversion']['verified_datetime'] = null;
            }
            $this->Conversion->saveAll();
            $data = $this->Conversion->find("first", array("conditions" => array("Conversion.id" => $this->request->data['id']), "recursive" => 1));
            echo json_encode($this->_generateStatusCode(207, null, array("status_label" => $data['VerifyStatus']['name'])));
        } else {
            echo json_encode($this->_generateStatusCode(400));
        }
    }

    function admin_change_status_validate() {
        $this->autoRender = false;
        if ($this->request->is("PUT")) {
            $this->Conversion->data['Conversion']['id'] = $this->request->data['id'];
            $this->Conversion->data['Conversion']['validate_status_id'] = $this->request->data['status'];
            if ($this->request->data['status'] == '3') {
                $this->Conversion->data['Conversion']['validate_by_id'] = $this->_getEmployeeId();
                $this->Conversion->data['Conversion']['validate_datetime'] = date("Y-m-d H:i:s");
            } else if ($this->request->data['status'] == '2') {
                $this->Conversion->data['Conversion']['validate_by_id'] = $this->_getEmployeeId();
                $this->Conversion->data['Conversion']['validate_datetime'] = date("Y-m-d H:i:s");
            } else {
                $this->Conversion->data['Conversion']['validate_by_id'] = null;
                $this->Conversion->data['Conversion']['validate_datetime'] = null;
            }
            $this->Conversion->saveAll();
            $data = $this->Conversion->find("first", array("conditions" => array("Conversion.id" => $this->request->data['id']), "recursive" => 1));
            echo json_encode($this->_generateStatusCode(207, null, array("status_label" => $data['ValidateStatus']['name'])));
        } else {
            echo json_encode($this->_generateStatusCode(400));
        }
    }

    function admin_convert() {
        if ($this->request->is("post")) {
            $this->{ Inflector::classify($this->name) }->set($this->data);
            //$this->{ Inflector::classify($this->name) }->data['stok']=0;
            if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
                $this->Session->setFlash(__("Data berhasil disimpan"), 'default', array(), 'success');
                $this->redirect(array('action' => 'admin_convert'));
            } else {
                $this->validationErrors = $this->{ Inflector::classify($this->name) }->validationErrors;
                $this->Session->setFlash(__("Harap mengecek kembali kesalahan dibawah."), 'default', array(), 'danger');
            }
        }
    }

    function admin_conversion_process($id = null) {
        if ($this->request->is("post") || $this->request->is("put")) {
            $this->{ Inflector::classify($this->name) }->set($this->data);
            if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                $this->{ Inflector::classify($this->name) }->data["Conversion"]['no_conversion'] = $this->generateTransactionConversionNumber();
                $this->{ Inflector::classify($this->name) }->data["Conversion"]['branch_office_id'] = $this->stnAdmin->getBranchId();
                $this->{ Inflector::classify($this->name) }->data["Conversion"]['validate_status_id'] = 1;
                $this->{ Inflector::classify($this->name) }->data["Conversion"]['employee_id'] = $this->Session->read("credential.admin.Employee.id");
                if ($this->Conversion->data['Conversion']['ratio'] >= 55 && $this->Conversion->data['Conversion']['ratio'] <= 100) {
                    $this->Conversion->data['Conversion']['verify_status_id'] = 3;
                    $this->Conversion->data['Conversion']['verified_by_id'] = $this->_getEmployeeId();
                    $this->Conversion->data['Conversion']['verified_datetime'] = date("Y-m-d H:i:s");
                } else {
                    $this->Conversion->data['Conversion']['verify_status_id'] = 1;
                    $this->Conversion->data['Conversion']['ratio_status_id'] = 4;
                }
                $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
                $MaterialEntryGrade = ClassRegistry::init("MaterialEntryGrade")->find("first", [
                    "conditions" => [
                        "MaterialEntryGrade.material_entry_id" => intval($this->data['Conversion']['material_entry_id']),
                    ],
                ]);
                foreach ($this->data['MaterialProcess'] as $k => $params) {
                    ClassRegistry::init("MaterialEntryGrade")->updateAll(
                            array("remaining_weight" => intval(intval($MaterialEntryGrade['MaterialEntryGrade']['remaining_weight']) - intval($params['weight']))), //fields to update
                            array(
                        "material_entry_id" => intval($this->data['Conversion']['material_entry_id']),
                        "material_detail_id" => intval($params['material_detail_id']),
                        "material_size_id" => intval($params['material_size_id']),
                            )
                    );

                    $toUpdateMaterialEntryDetail = [
                        "MaterialEntryGradeDetail" => [
                            "id" => intval($params['material_entry_grade_detail_id']),
                            "is_used" => 1,
                            "conversion_id" => $this->Conversion->getLastInsertID()
                        ]
                    ];
                    ClassRegistry::init("MaterialEntryGradeDetail")->saveAll($toUpdateMaterialEntryDetail);

                    //Check Transaction Record and Close
                    $MaterialEntryGradeDetail = ClassRegistry::init("MaterialEntryGradeDetail")->find("first", [
                        "conditions" => [
                            "MaterialEntryGradeDetail.id" => intval($params['material_entry_grade_detail_id']),
                        ],
                    ]);

                    $MaterialEntry = ClassRegistry::init("MaterialEntry")->find("first", [
                        "conditions" => [
                            "MaterialEntry.id" => intval($this->data["Conversion"]['material_entry_id']),
                        ],
                    ]);
                    //get different date
                    $differentDate = date_diff(date_create($MaterialEntry["MaterialEntry"]['weight_date']), date_create(substr($this->data['Conversion']['start_date'], 0, 10)));
                    $differentDate = $differentDate->format('%a');
                    //Change Batch Number
                    $tempBatchNumber = $MaterialEntryGradeDetail['MaterialEntryGradeDetail']['batch_number'];
                    $updatedBatchNumber = substr($tempBatchNumber, 0, count($tempBatchNumber) - 3) . "P1";
                    if ($differentDate >= 2) {
                        $updatedBatchNumber = substr($tempBatchNumber, 0, count($tempBatchNumber) - 3) . "P3";
                    } else if ($differentDate >= 1) {
                        $updatedBatchNumber = substr($tempBatchNumber, 0, count($tempBatchNumber) - 3) . "P2";
                    }
                    if ($differentDate >= 1) {
                        $toUpdateMaterialEntryGradeDetail = [
                            "MaterialEntryGradeDetail" => [
                                "id" => intval($MaterialEntryGradeDetail['MaterialEntryGradeDetail']['id']),
                                "batch_number" => $updatedBatchNumber
                            ]
                        ];
                        ClassRegistry::init("MaterialEntryGradeDetail")->saveAll($toUpdateMaterialEntryGradeDetail);
                    }
                }
                if ($MaterialEntryGrade['MaterialEntryGrade']['remaining_weight'] == 0) {
                    $toUpdateMaterialEntry = [
                        "MaterialEntry" => [
                            "id" => intval($MaterialEntryGrade['MaterialEntryGrade']['material_entry_id']),
                            "is_used" => 1
                        ]
                    ];
                    ClassRegistry::init("MaterialEntry")->saveAll($toUpdateMaterialEntry);
                }
                $toUpdateMaterialEntry = [
                    "MaterialEntry" => [
                        "id" => intval($this->data['Conversion']['material_entry_id']),
                        "stage_id" => 2
                    ]
                ];
                ClassRegistry::init("MaterialEntry")->saveAll($toUpdateMaterialEntry);

                //update Conversion Status Of MaterialEntry
                ClassRegistry::init("MaterialEntry")->updateConversionStatus($this->data['Conversion']['material_entry_id']);
                $this->Session->setFlash(__("Data berhasil diubah"), 'default', array(), 'success');
                $this->redirect(array('controller' => 'material_entries', 'action' => 'admin_conversion'));
            } else {
                $this->validationErrors = $this->{ Inflector::classify($this->name) }->validationErrors;
            }
        } else {
            $rows = ClassRegistry::init("MaterialEntry")->find("first", array(
                'conditions' => array(
                    "MaterialEntry.id" => $id
                ),
                "contain" => [
                    "MaterialEntryGrade"=>[
                      "MaterialEntryGradeDetail"  
                    ],
                    "Employee" => [
                        "Account" => [
                            "Biodata"
                        ]
                    ],
                    "Supplier" => [
                        "City",
                        "State"
                    ]
                ],
                'recursive' =>-1
            ));
            $this->data = $rows;
        }
        $this->set("dataMaterialSize", ClassRegistry::init("MaterialSize")->find("all", array("fields" => array("MaterialSize.id", "MaterialSize.name"))));
        $this->set("rejectedGradeTypes", ClassRegistry::init("RejectedGradeType")->find("list", array("fields" => array("RejectedGradeType.id", "RejectedGradeType.name"))));
        $this->set("dataMaterial", ClassRegistry::init("Material")->find("all", array("fields" => array("Material.id", "Material.name"), "contain" => array("MaterialDetail"), "conditions" => array("Material.material_category_id" => 2))));
        $this->set("materialEntries", ClassRegistry::init("MaterialEntry")->find("list", array("fields" => array("MaterialEntry.id", "MaterialEntry.material_entry_number"), "conditions" => array('MaterialEntry.is_used' => 0))));
    }

    function admin_daily_processing() {
        $conds = [];
        if (isset($this->request->query['Conversion_date']) && !empty($this->request->query['Conversion_date'])) {
            $date = $this->request->query['Conversion_date'];
        } else {
            $date = date("Y-m-d");
        }
        if (isset($this->request->query['select_Conversion_branch_office_id']) && !empty($this->request->query['select_Conversion_branch_office_id'])) {
            $conds = [
                "Conversion.branch_office_id" => $this->request->query['select_Conversion_branch_office_id']
            ];
        }
        $rows = $this->{ Inflector::classify($this->name) }->find('all', array(
            'conditions' => array(
                Inflector::classify($this->name) . '.created > ' => $date . " 00:00:00",
                Inflector::classify($this->name) . '.created <=' => $date . " 23:59:59",
                $conds
            ),
            'contain' => [
                "MaterialEntry" => [
                    "MaterialEntryGrade" => [
                        "MaterialDetail" => [
                            "Material",
                            "Unit"
                        ],
                        "MaterialSize"
                    ],
                ],
                "ConversionData" => [
                    "MaterialDetail" => [
                        "Material",
                        "Unit"
                    ],
                    "MaterialSize"
                ],
            ],
        ));
        $data = array(
            'title' => 'Rekapitulasi Pengolahan Ikan Harian',
            'rows' => $rows,
        );
        $this->set(compact('data'));
        $this->_activePrint(func_get_args(), "report_processing_daily_rekapitulasi", ["excel" => "excel", "print" => "print_tanpa_kop"]);
    }

    function admin_print_daily_processing_rekapitulasi($date) {
        $rows = $this->{ Inflector::classify($this->name) }->find('all', array(
            'conditions' => array(
                Inflector::classify($this->name) . '.created > ' => $date . " 00:00:00",
                Inflector::classify($this->name) . '.created <=' => $date . " 23:59:59",
            ),
            'contain' => [
                "MaterialEntry" => [
                    "MaterialEntryGrade" => [
                        "MaterialDetail" => [
                            "Material",
                            "Unit"
                        ],
                        "MaterialSize"
                    ],
                ],
                "ConversionData" => [
                    "MaterialDetail" => [
                        "Material",
                        "Unit"
                    ],
                    "MaterialSize"
                ],
            ],
        ));
        $data = array(
            'title' => 'Rekapitulasi Pengolahan Ikan Harian',
            'rows' => $rows,
        );
        $this->set(compact('data'));
        $this->_activePrint(["print"], "report_processing_daily_rekapitulasi", "print_tanpa_kop");
    }

    function admin_daily_processing_report() {
        $conds = [];
        if (isset($this->request->query['Conversion_date']) && !empty($this->request->query['Conversion_date'])) {
            $date = $this->request->query['Conversion_date'];
        } else {
            $date = date("Y-m-d");
        }
        if (isset($this->request->query['select_Conversion_branch_office_id']) && !empty($this->request->query['select_Conversion_branch_office_id'])) {
            $conds = [
                "Conversion.branch_office_id" => $this->request->query['select_Conversion_branch_office_id']
            ];
        }
        $rows = $this->{ Inflector::classify($this->name) }->find('all', array(
            'conditions' => array(
                Inflector::classify($this->name) . '.created > ' => $date . " 00:00:00",
                Inflector::classify($this->name) . '.created <=' => $date . " 23:59:59",
                $conds
            ),
            'contain' => [
                "MaterialEntry" => [
                    "MaterialEntryGrade" => [
                        "MaterialDetail" => [
                            "Material",
                            "Unit"
                        ],
                        "MaterialSize"
                    ]
                ],
                "ConversionData" => [
                    "MaterialDetail" => [
                        "Material",
                        "Unit"
                    ],
                    "MaterialSize"
                ],
            ],
        ));
        $data = array(
            'title' => 'Laporan Pengolahan Ikan Harian',
            'rows' => $rows,
        );
        $this->set(compact('data'));
        $this->_activePrint(func_get_args(), "report_processing_daily", ["excel" => "excel", "print" => "print_tanpa_kop"]);
    }

    function admin_print_daily_processing($date) {
        $rows = $this->{ Inflector::classify($this->name) }->find('all', array(
            'conditions' => array(
                Inflector::classify($this->name) . '.created > ' => $date . " 00:00:00",
                Inflector::classify($this->name) . '.created <=' => $date . " 23:59:59",
            ),
            'contain' => [
                "MaterialEntry" => [
                    "MaterialEntryGrade" => [
                        "MaterialDetail" => [
                            "Material",
                            "Unit"
                        ],
                        "MaterialSize"
                    ]
                ],
                "ConversionData" => [
                    "MaterialDetail" => [
                        "Material",
                        "Unit"
                    ],
                    "MaterialSize"
                ],
            ],
        ));
        $data = array(
            'title' => 'Laporan Pengolahan Ikan Harian',
            'rows' => $rows,
        );
        $this->set(compact('data'));
        $this->_activePrint(["print"], "report_processing_daily", "print_tanpa_kop");
    }

    function view_data_conversion($id = null) {
        $this->autoRender = false;
        if ($this->Conversion->exists($id)) {
            if ($this->request->is("GET")) {
                $data = $this->Conversion->find("first", [
                    "conditions" => [
                        "Conversion.id" => $id
                    ],
                    "contain" => [
                        "MaterialEntry",
                        "ConversionData" => [
                            "MaterialDetail" => [
                                "Unit",
                                "Material" => [
                                ]
                            ],
                            "MaterialSize",
                            "RejectedGradeType"
                        ],
                        "Employee" => [
                            "Account" => [
                                "Biodata"
                            ],
                            "Office",
                            "Department"
                        ],
                        "Operator" => [
                            "Account" => [
                                "Biodata"
                            ],
                            "Office",
                            "Department"
                        ],
                        "MaterialEntryGradeDetail" => [
                            "MaterialEntryGrade" => [
                                "MaterialDetail" => [
                                    "Material"
                                ],
                                "MaterialSize",
                            ]
                        ],
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

    //Untuk Return Order
    function view_data_conversion_transaction($id = null) {
        $this->autoRender = false;
        if ($this->Conversion->exists($id)) {
            if ($this->request->is("GET")) {
                $data = $this->Conversion->find("first", [
                    "conditions" => [
                        "Conversion.id" => $id
                    ],
                    "contain" => [
                        "MaterialEntry" => [
                            "TransactionEntry" => [
                                "TransactionMaterialEntry" => [
                                    "MaterialSize",
                                    "MaterialDetail" => [
                                        "Material",
                                        "Unit"
                                    ]
                                ]
                            ],
                            "MaterialEntryGrade" => [
                                "MaterialSize",
                                "MaterialDetail" => [
                                    "Material",
                                    "Unit"
                                ]
                            ]
                        ],
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

    function beforeRender() {
        $this->_options();
        parent::beforeRender();
    }

    function _options() {
        $this->set("products", ClassRegistry::init("Product")->find("list", array("fields" => array("Product.id", "Product.name"))));
        $this->set("materials", ClassRegistry::init("Material")->find("list", array("fields" => array("Material.id", "Material.name"))));
        $this->set("transactionEntries", ClassRegistry::init("TransactionEntry")->find("list", array("fields" => array("TransactionEntry.id", "TransactionEntry.transaction_number"), "conditions" => array('TransactionEntry.is_used' => 0))));
        $this->set("materialEntries", ClassRegistry::init("MaterialEntry")->find("list", array("fields" => array("MaterialEntry.id", "MaterialEntry.material_entry_number"), "conditions" => array('MaterialEntry.is_used' => 1))));
        $this->set("branchOffices", ClassRegistry::init("BranchOffice")->find("list", ["fields" => ["BranchOffice.id", "BranchOffice.name"]]));
        $this->set("conversionNumbers", ClassRegistry::init("Conversion")->find("list", ["fields" => ["Conversion.id", "Conversion.no_conversion"]]));
        $this->set("materialEntryNumbers", ClassRegistry::init("MaterialEntry")->find("list", ["fields" => ["MaterialEntry.id", "MaterialEntry.material_entry_number"]]));
        $this->set("verifyStatuses", $this->Conversion->VerifyStatus->find("list", ["fields" => ["VerifyStatus.id", "VerifyStatus.name"]]));
        $this->set("validateStatuses", $this->Conversion->ValidateStatus->find("list", ["fields" => ["ValidateStatus.id", "ValidateStatus.name"]]));
    }

    function admin_get_product() {
        $this->autoRender = false;
        $data = $this->{ Inflector::classify($this->name) }->find('all', array("fields" => array("Product.id", "Product.name")), array("contain" => array()));
        echo json_encode($data);
    }

    function generateTransactionConversionNumber() {
        $inc_id = 1;
        $month = romanic_number(date("n"));
        $Y = date('Y');
        $testCode = "[0-9]{4}/KONV-PRO/$month/$Y";
        $lastRecord = $this->Conversion->find('first', array('conditions' => array('and' => array("Conversion.no_conversion regexp" => $testCode)), 'order' => array('Conversion.no_conversion' => 'DESC')));
        if (!empty($lastRecord)) {
            $current = substr($lastRecord['Conversion']['no_conversion'], 0, 4);
            $inc_id += $current;
        }
        $inc_id = sprintf("%04d", $inc_id);
        $kode = "$inc_id/KONV-PRO/$month/$Y";
        return $kode;
    }

    function generateSerialNumber() {
        $inc_id = 1;
        $Y = date('Y');
        $M = date('M');
        $testCode = "cvb[0-9]{6}/$M/$Y";
        $lastRecord = ClassRegistry::init("ProductData")->find('first', array('conditions' => array('and' => array("ProductData.serial_number regexp" => $testCode)), 'order' => array('ProductData.serial_number' => 'DESC')));
        if (!empty($lastRecord)) {
            $current = explode("/", $lastRecord['ProductData']['serial_number']);
            $inc_id += ltrim($current[0], 'cvb');
        }
        $inc_id = sprintf("%06d", $inc_id);
        $kode = "cvb$inc_id/$M/$Y";
        return $kode;
    }

    function admin_list() {
        $this->autoRender = false;
        $conds = [];
        if (isset($this->request->query['q'])) {
            $q = $this->request->query['q'];
            $conds[] = array(
                "or" => array(
                    "Conversion.no_conversion like" => "%$q%",
            ));
        }
        $suggestions = ClassRegistry::init("Conversion")->find("all", array(
            "conditions" => [
                $conds,
            ],
            "contain" => [
                "MaterialEntry" => [
                    "Supplier"
                ],
                "Employee",
                "Freeze"
            ],
            "limit" => 10,
        ));
        $result = [];
        foreach ($suggestions as $item) {
            if (!empty($item)) {
                if ($item['Employee']['branch_office_id'] == $this->Session->read("credential.admin.Employee.branch_office_id")) {
                    if ($item['Conversion']['verify_status_id'] == 1) {
                        $result[] = [
                            "id" => @$item['Conversion']['id'],
                            "conversion_weight" => @$item['Conversion']['total'],
                            "conversion_ratio" => @$item['Conversion']['ratio'],
                            "no_conversion" => @$item['Conversion']['no_conversion'],
                            "material_entry_id" => @$item['MaterialEntry']['id'],
                            "created_date" => @$item['Conversion']['created'],
                            "supplier_name" => @$item['MaterialEntry']['Supplier']['created'],
                        ];
                    }
                }
            }
        }
        echo json_encode($result);
    }

    function admin_list_conversion() {
        $this->autoRender = false;
        $conds = [];
        if (isset($this->request->query['q'])) {
            $q = $this->request->query['q'];
            $conds[] = array(
                "or" => array(
                    "Conversion.no_conversion like" => "%$q%",
            ));
        }
        $suggestions = ClassRegistry::init("Conversion")->find("all", array(
            "conditions" => [
                $conds,
            ],
            "contain" => [
                "MaterialEntry",
                "Employee" => [
                    "Account" => [
                        "Biodata",
                    ],
                ],
                "Freeze"
            ],
            "limit" => 10,
        ));
        $result = [];
        foreach ($suggestions as $item) {
            if (!empty($item)) {
                if ($item['Employee']['branch_office_id'] == $this->Session->read("credential.admin.Employee.branch_office_id")) {
                    if ($item['Conversion']['verify_status_id'] == 3) {
                        $result[] = [
                            "id" => @$item['Conversion']['id'],
                            "conversion_weight" => @$item['Conversion']['total'],
                            "conversion_ratio" => @$item['Conversion']['ratio'],
                            "no_conversion" => @$item['Conversion']['no_conversion'],
                            "fullname" => @$item['Employee']['Account']['Biodata']['full_name'],
                            "material_entry_id" => @$item['MaterialEntry']['id'],
                        ];
                    }
                }
            }
        }
        echo json_encode($result);
    }

    function get_data_material_entry($id) {
        $this->autoRender = false;
        if (!empty($id)) {
            $data = ClassRegistry::init("MaterialEntry")->find("first", [
                "conditions" => [
                    "MaterialEntry.id" => $id
                ],
                "contain" => [
                    "Conversion" => [
                        "ConversionData" => [
                            "MaterialDetail" => [
                                "Material"
                            ],
                            "MaterialSize",
                            "RejectedGradeType"
                        ],
                        "MaterialEntryGradeDetail" => [
                            "MaterialEntryGrade" => [
                                "MaterialDetail" => [
                                    "Material"
                                ],
                                "MaterialSize",
                            ]
                        ],
                        "Employee" => [
                            "Account" => [
                                "Biodata"
                            ],
                            "Office",
                            "Department"
                        ],
                        "Operator" => [
                            "Account" => [
                                "Biodata"
                            ],
                            "Office",
                            "Department"
                        ]
                    ],
                    "MaterialEntryGrade" => [
                        "MaterialDetail" => [
                            "Material"
                        ],
                        "MaterialEntryGradeDetail",
                        "MaterialSize"
                    ]
                ]
            ]);
            return json_encode($this->_generateStatusCode(206, null, $data));
        } else {
            return json_encode("Data Tidak Ditemukan");
        }
    }

    function admin_index() {
        $this->_activePrint(func_get_args(), "data_konversi");
        $this->conds = [
            "MaterialEntry.branch_office_id" => $this->stnAdmin->roleBranchId()
        ];
        if (isset($this->request->query['Conversion_start_date']) && !empty($this->request->query['Conversion_start_date'])) {
            $startDate = $this->request->query['Conversion_start_date'];
        } else
        if (isset($this->request->query['Conversion_end_date']) && !empty($this->request->query['Conversion_end_date'])) {
            $endDate = $this->request->query['Conversion_end_date'];
        }
        $this->set(compact('startDate', 'endDate'));
        parent::admin_index();
    }

    function admin_index_validate() {
        $this->_activePrint(func_get_args(), "data_konversi_validate");
        $this->conds = [
            "MaterialEntry.branch_office_id" => $this->stnAdmin->roleBranchId(),
            "Conversion.verify_status_id" => 1,
            "Conversion.validate_status_id" => 2,
        ];
        if (isset($this->request->query['Conversion_start_date']) && !empty($this->request->query['Conversion_start_date'])) {
            $startDate = $this->request->query['Conversion_start_date'];
        } else
        if (isset($this->request->query['Conversion_end_date']) && !empty($this->request->query['Conversion_end_date'])) {
            $endDate = $this->request->query['Conversion_end_date'];
        }
        $this->set(compact('startDate', 'endDate'));
        parent::admin_index();
    }

}
