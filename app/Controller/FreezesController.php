<?php

App::uses('AppController', 'Controller');

class FreezesController extends AppController {

    var $name = "Freezes";
    var $disabledAction = array(
    );
    var $contain = [
        "FreezeDetail",
        "Conversion" => [
            "ConversionData" => [
                "MaterialSize",
                "MaterialDetail" => [
                    "Material"
                ]
            ],
        ],
        "Employee" => [
            "Account" => [
                "Biodata",
            ],
        ],
        "MaterialEntry" => [
            "MaterialCategory",
            "Supplier"
        ],
        "BranchOffice",
        "VerifyStatus",
        "VerifiedBy" => [
            "Account" => [
                "Biodata",
            ],
        ],
        "ValidateStatus"
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
        $this->_activePrint(func_get_args(), "data_styling");
        $this->_setPeriodeLaporanDate("awal_MaterialEntry_weight_date", "akhir_MaterialEntry_weight_date");
        $conds = [];
        if(!empty($this->request->query['Freeze_start_date'])) {
            $start_date = $this->request->query['Freeze_start_date'];
            $conds[] = [
                "DATE_FORMAT(Freeze.start_date, '%Y-%m-%d')" => $start_date
            ];
        }
        if(!empty($this->request->query['Freeze_end_date'])) {
            $end_date = $this->request->query['Freeze_end_date'];
            $conds[] = [
                "DATE_FORMAT(Freeze.end_date, '%Y-%m-%d')" => $end_date
            ];
        }
        $this->conds = [
            "Freeze.branch_office_id" => $this->stnAdmin->roleBranchId(),
            $conds
        ];
        parent::admin_index();
    }

    function admin_index_validate() {
        $this->_activePrint(func_get_args(), "data_styling_validate");
        $this->conds = [
            "Freeze.verify_status_id" => 1,
            "Freeze.validate_status_id" => 2,
            "Freeze.branch_office_id" => $this->stnAdmin->roleBranchId()
        ];
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
        $this->set("materialEntries", ClassRegistry::init("MaterialEntry")->find("list", array("fields" => array("MaterialEntry.id", "MaterialEntry.material_entry_number"), "conditions" => array("MaterialEntry.stage_id" => "2"))));
        $this->set("products", $this->Freeze->FreezeDetail->Product->find("all", [
                    "fields" => [
                        "Product.id",
                        "Product.name",
                    ],
                    "contain" => [
                        "Child"
                    ],
                    "conditions" => [
                        'Product.parent_id is null'
                    ]
                ])
        );
        $this->set("branchOffices", $this->Freeze->BranchOffice->find("list", array("fields" => array("BranchOffice.id", "BranchOffice.name"))));
        $this->set("materialCategories", $this->Freeze->MaterialEntry->MaterialCategory->find("list", array("fields" => array("MaterialCategory.id", "MaterialCategory.name"))));
        $this->set("verifyStatuses", $this->Freeze->VerifyStatus->find("list", array("fields" => array("VerifyStatus.id", "VerifyStatus.name"))));
        $this->set("validateStatuses", $this->Freeze->ValidateStatus->find("list", array("fields" => array("ValidateStatus.id", "ValidateStatus.name"))));
        $this->set("rejectedGradeTypes", ClassRegistry::init("RejectedGradeType")->find("list", array("fields" => array("RejectedGradeType.id", "RejectedGradeType.name"))));
    }

    function admin_freeze_setup() {
        if ($this->request->is("post")) {
            $this->{ Inflector::classify($this->name) }->set($this->data);
            if ($this->data["MaterialCategory"]["material_category_id"] == 1) {
                $this->redirect(array('action' => 'admin_add_whole'));
            } else if ($this->data["MaterialCategory"]["material_category_id"] == 2) {
                $this->redirect(array('action' => 'admin_add_colly'));
            }
        }
    }

    function admin_add_colly($materialEntryId = null) {
        if ($this->request->is("post")) {
            $total = 0;
            $this->{ Inflector::classify($this->name) }->set($this->data);
            $this->{ Inflector::classify($this->name) }->data["Freeze"]['employee_id'] = $this->stnAdmin->getEmployeeId();
            $this->{ Inflector::classify($this->name) }->data["Freeze"]['branch_office_id'] = $this->stnAdmin->getBranchId();
            $this->{ Inflector::classify($this->name) }->data["Freeze"]['validate_status_id'] = 1;
            //$this->Freeze->data['MaterialEntryGrade']['id'] = $this->data['Freeze']['material_entry_grade_id'];
            foreach ($this->data['FreezeDetail'] as $k => $freezeDetail) {
                if (isset($freezeDetail['weight'])) {
                    if ($freezeDetail['weight'] > 0) {
                        $this->{ Inflector::classify($this->name) }->data["FreezeDetail"][$k]['remaining_weight'] = $freezeDetail['weight'];
                        //$this->{ Inflector::classify($this->name) }->data["FreezeDetail"][$k]['material_entry_grade_id'] = $this->data['Freeze']['material_entry_grade_id'];
                    }
                }
            }
            foreach ($this->data['FreezeSourceDetail'] as $k => $freezeSourceDetail) {
                $toUpdateMaterialEntryGrade = [];
                //$this->Freeze->data['MaterialEntryGrade'][$k]['id'] = $freezeSourceDetail['material_entry_grade_id'];
                if ($freezeSourceDetail['remaining_weight'] - $freezeSourceDetail['weight'] == 0) {
                    $toUpdateMaterialEntryGrade = [
                        "MaterialEntryGrade" => [
                            "id" => intval($freezeSourceDetail['material_entry_grade_id']),
                            "remaining_weight" => $freezeSourceDetail['remaining_weight'] - $freezeSourceDetail['weight'],
                            "is_used" => 1
                        ]
                    ];
                    ClassRegistry::init("MaterialEntryGrade")->saveAll($toUpdateMaterialEntryGrade);
                } else {
                    $toUpdateMaterialEntryGrade = [
                        "MaterialEntryGrade" => [
                            "id" => intval($freezeSourceDetail['material_entry_grade_id']),
                            "remaining_weight" => $freezeSourceDetail['remaining_weight'] - $freezeSourceDetail['weight']
                        ]
                    ];
                    ClassRegistry::init("MaterialEntryGrade")->saveAll($toUpdateMaterialEntryGrade);
                }
                //flag all fish to be used
                ClassRegistry::init("MaterialEntry")->updateFishStatusForColly($freezeSourceDetail['material_entry_grade_id']);
            }

            if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                //                $this->Freeze->_numberSeperatorRemover();
                $materialEntry = ClassRegistry::init("MaterialEntry")->find("first", [
                    "conditions" => [
                        "MaterialEntry.id" => intval($this->data['Freeze']['material_entry_id']),
                    ],
                    "contain" => [
                        "MaterialEntryGrade" => [
                            "MaterialEntryGradeDetail"
                        ]
                    ]
                ]);
                foreach ($materialEntry['MaterialEntryGrade'] as $k => $EntryGrade) {
                    foreach ($EntryGrade['MaterialEntryGradeDetail'] as $k => $EntryGradeDetail) {
                        //get different date
                        $differentDate = date_diff(date_create($materialEntry["MaterialEntry"]['weight_date']), date_create(substr($this->data['Freeze']['start_date'], 0, 10)));
                        $differentDate = $differentDate->format('%a');
                        $tempBatchNumber = $EntryGradeDetail['batch_number'];
                        $updatedBatchNumber = substr($tempBatchNumber, 0, count($tempBatchNumber) - 3) . "P1";
                        if ($differentDate >= 2) {
                            $updatedBatchNumber = substr($tempBatchNumber, 0, count($tempBatchNumber) - 3) . "P3";
                        } else if ($differentDate >= 1) {
                            $updatedBatchNumber = substr($tempBatchNumber, 0, count($tempBatchNumber) - 3) . "P2";
                        }
                        if ($differentDate >= 1) {
                            $toUpdateMaterialEntryGradeDetail = [
                                "MaterialEntryGradeDetail" => [
                                    "id" => intval($EntryGradeDetail['id']),
                                    "batch_number" => $updatedBatchNumber
                                ]
                            ];
                            ClassRegistry::init("MaterialEntryGradeDetail")->saveAll($toUpdateMaterialEntryGradeDetail);
                        }
                    }
                }
                if ($this->Freeze->data['Freeze']['ratio'] >= 95 && $this->Freeze->data['Freeze']['ratio'] <= 105) {
                    $this->{ Inflector::classify($this->name) }->data['Freeze']['verify_status_id'] = 3;
                    $this->Freeze->data['Freeze']['verified_by_id'] = $this->_getEmployeeId();
                    $this->Freeze->data['Freeze']['verified_datetime'] = date("Y-m-d H:i:s");
                } else {
                    $this->Freeze->data['Freeze']['verify_status_id'] = 1;
                    $this->Freeze->data['Freeze']['ratio_status_id'] = 4;
                }
                $this->Freeze->data['MaterialEntry']['stage_id'] = 3;
                $this->{ Inflector::classify($this->name) }->data['MaterialEntry']['id'] = $this->data['Freeze']['material_entry_id'];
                $this->{ Inflector::classify($this->name) }->data["Freeze"]['freeze_number'] = $this->generateFreezeNumber();
                $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
                //update freeze status on material entry
                ClassRegistry::init("MaterialEntry")->updateFreezeStatus($this->data['Freeze']['material_entry_id']);
                $this->Session->setFlash(__("Data berhasil disimpan"), 'default', array(), 'success');
                //$this->redirect(array('action' => 'admin_index'));
                $this->redirect(array('controller' => 'material_entries', 'action' => 'admin_freeze'));
            } else {
                $this->validationErrors = $this->{ Inflector::classify($this->name) }->validationErrors;
                $this->Session->setFlash(__("Harap mengecek kembali kesalahan dibawah."), 'default', array(), 'danger');
            }
        } else {
            if (!ClassRegistry::init("MaterialEntry")->exists($materialEntryId)) {
                throw new NotFoundException(__('Data tidak ditemukan'));
            } else {
                $this->data = ClassRegistry::init("MaterialEntry")->find("first", ["contain" => ["MaterialEntryGrade"], "conditions" => ["MaterialEntry.id" => $materialEntryId]]);
            }
        }
    }

    function admin_edit_colly($id = null) {
        if (!$this->{ Inflector::classify($this->name) }->exists($id)) {
            throw new NotFoundException(__('Data tidak ditemukan'));
        } else {
            if ($this->request->is("post") || $this->request->is("put")) {
                $this->{ Inflector::classify($this->name) }->set($this->data);
                $this->{ Inflector::classify($this->name) }->data[Inflector::classify($this->name)]['id'] = $id;
                if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                    if (!is_null($id)) {
                        $this->{ Inflector::classify($this->name) }->_deleteableHasmany();
                        $this->{ Inflector::classify($this->name) }->data["Freeze"]['validate_status_id'] = 1;
                        foreach ($this->data['FreezeDetail'] as $k => $freezeDetail) {
                            if (isset($freezeDetail['weight'])) {
                                if ($freezeDetail['weight'] > 0) {
                                    $this->{ Inflector::classify($this->name) }->data["FreezeDetail"][$k]['remaining_weight'] = $freezeDetail['weight'];
                                }
                            }
                        }
                        foreach ($this->data['FreezeSourceDetail'] as $k => $freezeSourceDetail) {
                            $toUpdateMaterialEntryGrade = [];
                            if ($freezeSourceDetail['order_weight'] - $freezeSourceDetail['weight'] == 0) {
                                $toUpdateMaterialEntryGrade = [
                                    "MaterialEntryGrade" => [
                                        "id" => intval($freezeSourceDetail['material_entry_grade_id']),
                                        "remaining_weight" => $freezeSourceDetail['order_weight'] - $freezeSourceDetail['weight'],
                                        "is_used" => 1
                                    ]
                                ];
                                ClassRegistry::init("MaterialEntryGrade")->saveAll($toUpdateMaterialEntryGrade);
                            } else {
                                $toUpdateMaterialEntryGrade = [
                                    "MaterialEntryGrade" => [
                                        "id" => intval($freezeSourceDetail['material_entry_grade_id']),
                                        "remaining_weight" => $freezeSourceDetail['order_weight'] - $freezeSourceDetail['weight']
                                    ]
                                ];
                                ClassRegistry::init("MaterialEntryGrade")->saveAll($toUpdateMaterialEntryGrade);
                            }
                            //flag all fish to be used
                            ClassRegistry::init("MaterialEntry")->updateFishStatusForColly($freezeSourceDetail['material_entry_grade_id']);
                        }


//                        $materialEntry = ClassRegistry::init("MaterialEntry")->find("first", [
//                            "conditions" => [
//                                "MaterialEntry.id" => intval($this->data['Freeze']['material_entry_id']),
//                            ],
//                            "contain" => [
//                                "MaterialEntryGrade" => [
//                                    "MaterialEntryGradeDetail"
//                                ]
//                            ]
//                        ]);
//                        foreach ($materialEntry['MaterialEntryGrade'] as $k => $EntryGrade) {
//                            foreach ($EntryGrade['MaterialEntryGradeDetail'] as $k => $EntryGradeDetail) {
//                                //get different date
//                                $differentDate = date_diff(date_create($materialEntry["MaterialEntry"]['weight_date']), date_create(substr($this->data['Freeze']['start_date'], 0, 10)));
//                                $differentDate = $differentDate->format('%a');
//                                $tempBatchNumber = $EntryGradeDetail['batch_number'];
//                                $updatedBatchNumber = substr($tempBatchNumber, 0, 8) . "P1";
//                                if ($differentDate >= 2) {
//                                    $updatedBatchNumber = substr($tempBatchNumber, 0, 8) . "P3";
//                                } else if ($differentDate >= 1) {
//                                    $updatedBatchNumber = substr($tempBatchNumber, 0, 8) . "P2";
//                                }
//                                if ($differentDate >= 1) {
//                                    $toUpdateMaterialEntryGradeDetail = [
//                                        "MaterialEntryGradeDetail" => [
//                                            "id" => intval($EntryGradeDetail['id']),
//                                            "batch_number" => $updatedBatchNumber
//                                        ]
//                                    ];
//                                    ClassRegistry::init("MaterialEntryGradeDetail")->saveAll($toUpdateMaterialEntryGradeDetail);
//                                }
//                            }
//                        }
                        if ($this->Freeze->data['Freeze']['ratio'] >= 95 && $this->Freeze->data['Freeze']['ratio'] <= 105) {
                            $this->{ Inflector::classify($this->name) }->data['Freeze']['verify_status_id'] = 3;
                            $this->Freeze->data['Freeze']['verified_by_id'] = $this->_getEmployeeId();
                            $this->Freeze->data['Freeze']['verified_datetime'] = date("Y-m-d H:i:s");
                            $this->Freeze->data['Freeze']['note'] = "";
                        } else {
                            $this->Freeze->data['Freeze']['verify_status_id'] = 1;
                            $this->Freeze->data['Freeze']['ratio_status_id'] = 4;
                        }
                        $this->Freeze->data['MaterialEntry']['stage_id'] = 3;
                        $this->{ Inflector::classify($this->name) }->data['MaterialEntry']['id'] = $this->data['Freeze']['material_entry_id'];
//                        $this->{ Inflector::classify($this->name) }->data["Freeze"]['freeze_number'] = $this->generateFreezeNumber();
                        $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
                        //update freeze status on material entry
                        ClassRegistry::init("MaterialEntry")->updateFreezeStatus($this->data['Freeze']['material_entry_id']);
                        $this->Session->setFlash(__("Data berhasil disimpan"), 'default', array(), 'success');
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
                    "contain" => [
                        "FreezeSourceDetail" => [
                            "MaterialEntryGrade"
                        ],
                        "FreezeDetail" => [
                            "Product" => [
                                "Parent"
                            ]
                        ],
                        "MaterialEntry" => [
                            "MaterialEntryGrade" => [
                                "MaterialDetail",
                                "MaterialSize"
                            ]
                        ],
                        "Employee" => [
                            "Account" => [
                                "Biodata",
                            ],
                            "Department",
                            "Office"
                        ],
                        "Operator" => [
                            "Account" => [
                                "Biodata",
                            ],
                            "Department",
                            "Office"
                        ],
                    ],
                    'recursive' => -1
                ));
                $this->data = $rows;
                $this->set(compact('rows'));
            }
        }
    }

    function admin_add_whole($materialEntryId = null) {
        if ($this->request->is("post")) {
            $total = 0;
            $this->{ Inflector::classify($this->name) }->set($this->data);
            $this->{ Inflector::classify($this->name) }->data["Freeze"]['employee_id'] = $this->stnAdmin->getEmployeeId();
            $this->{ Inflector::classify($this->name) }->data["Freeze"]['branch_office_id'] = $this->stnAdmin->getBranchId();
            $this->{ Inflector::classify($this->name) }->data["Freeze"]['validate_status_id'] = 1;
            foreach ($this->data['FreezeDetail'] as $k => $freezeDetail) {
                $this->{ Inflector::classify($this->name) }->data["FreezeDetail"][$k]['remaining_weight'] = $freezeDetail['weight'];
                $conversionData = ClassRegistry::init("Conversion")->find("first", array(
                    'conditions' => array(
                        "Conversion.id" => $this->data['Freeze']['conversion_id']
                    ),
                    "recursive" => -1
                        )
                );
                $this->{ Inflector::classify($this->name) }->data["FreezeDetail"][$k]['material_entry_grade_id'] = $conversionData['Conversion']['material_entry_grade_id'];
            }
            if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                if ($this->Freeze->data['Freeze']['ratio'] >= 95 && $this->Freeze->data['Freeze']['ratio'] <= 105) {
                    $this->{ Inflector::classify($this->name) }->data['Freeze']['verify_status_id'] = 3;
                    $this->Freeze->data['Freeze']['verified_by_id'] = $this->_getEmployeeId();
                    $this->Freeze->data['Freeze']['verified_datetime'] = date("Y-m-d H:i:s");
                } else {
                    $this->Freeze->data['Freeze']['verify_status_id'] = 1;
                    $this->Freeze->data['Freeze']['ratio_status_id'] = 4;
                }
                $this->Freeze->data['MaterialEntry']['stage_id'] = 3;
                $this->{ Inflector::classify($this->name) }->data['MaterialEntry']['id'] = $this->data['Freeze']['material_entry_id'];
//                $this->Freeze->data['TransactionEntry']['stage_id'] = 3;
                $this->{ Inflector::classify($this->name) }->data["Freeze"]['freeze_number'] = $this->generateFreezeNumber();
                $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
                //update freeze status on material entry
                ClassRegistry::init("MaterialEntry")->updateFreezeStatus($this->data['Freeze']['material_entry_id']);
                $this->Session->setFlash(__("Data berhasil disimpan"), 'default', array(), 'success');
                //$this->redirect(array('action' => 'admin_index'));
                $this->redirect(array('controller' => 'material_entries', 'action' => 'admin_freeze'));
            } else {
                $this->validationErrors = $this->{ Inflector::classify($this->name) }->validationErrors;
                $this->Session->setFlash(__("Harap mengecek kembali kesalahan dibawah."), 'default', array(), 'danger');
            }
        } else {
            if (!ClassRegistry::init("MaterialEntry")->exists($materialEntryId)) {
                throw new NotFoundException(__('Data tidak ditemukan'));
            } else {
                $this->data = ClassRegistry::init("MaterialEntry")->find("first", [
                    "conditions" => [
                        "MaterialEntry.id" => $materialEntryId,
                    ],
                    "contain" => [
                        "Employee" => [
                            "Account" => [
                                "Biodata",
                            ],
                        ],
                        "Conversion" => [
                            "Employee" => [
                                "Account" => [
                                    "Biodata",
                                ],
                            ],
                            "Freeze",
                        ],
                    ]
                ]);
            }
        }
    }

    function admin_edit_whole($id = null) {
        if (!$this->{ Inflector::classify($this->name) }->exists($id)) {
            throw new NotFoundException(__('Data tidak ditemukan'));
        } else {
            if ($this->request->is("post") || $this->request->is("put")) {
                $this->{ Inflector::classify($this->name) }->set($this->data);
                $this->{ Inflector::classify($this->name) }->data[Inflector::classify($this->name)]['id'] = $id;
                if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                    if (!is_null($id)) {
                        $this->{ Inflector::classify($this->name) }->_deleteableHasmany();
                        $this->{ Inflector::classify($this->name) }->data["Freeze"]['validate_status_id'] = 1;
                        foreach ($this->data['FreezeDetail'] as $k => $freezeDetail) {
                            $this->{ Inflector::classify($this->name) }->data["FreezeDetail"][$k]['remaining_weight'] = $freezeDetail['weight'];
                            $conversionData = ClassRegistry::init("Conversion")->find("first", array(
                                'conditions' => array(
                                    "Conversion.id" => $this->data['Freeze']['conversion_id']
                                ),
                                "recursive" => -1
                                    )
                            );
                            $this->{ Inflector::classify($this->name) }->data["FreezeDetail"][$k]['material_entry_grade_id'] = $conversionData['Conversion']['material_entry_grade_id'];
                        }
                        if ($this->Freeze->data['Freeze']['ratio'] >= 95 && $this->Freeze->data['Freeze']['ratio'] <= 105) {
                            $this->{ Inflector::classify($this->name) }->data['Freeze']['verify_status_id'] = 3;
                            $this->Freeze->data['Freeze']['verified_by_id'] = $this->_getEmployeeId();
                            $this->Freeze->data['Freeze']['verified_datetime'] = date("Y-m-d H:i:s");
                            $this->Freeze->data['Freeze']['note'] = "";
                        } else {
                            $this->Freeze->data['Freeze']['verify_status_id'] = 1;
                            $this->Freeze->data['Freeze']['ratio_status_id'] = 4;
                        }
                        $this->Freeze->data['MaterialEntry']['stage_id'] = 3;
                        $this->{ Inflector::classify($this->name) }->data['MaterialEntry']['id'] = $this->data['Freeze']['material_entry_id'];
                        $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
                        //update freeze status on material entry
                        ClassRegistry::init("MaterialEntry")->updateFreezeStatus($this->data['Freeze']['material_entry_id']);
                        $this->Session->setFlash(__("Data berhasil disimpan"), 'default', array(), 'success');
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
                    "contain" => [
                        "FreezeDetail" => [
                            "Product" => [
                                "Parent"
                            ]
                        ],
                        "MaterialEntry" => [
                            "MaterialEntryGrade" => [
                                "MaterialDetail",
                                "MaterialSize"
                            ]
                        ],
                        "Conversion" => [
                            "ConversionData" => [
                                "MaterialSize",
                                "MaterialDetail" => [
                                    "Material"
                                ],
                                "RejectedGradeType"
                            ],
                        ],
                        "Employee" => [
                            "Account" => [
                                "Biodata",
                            ],
                            "Department",
                            "Office"
                        ],
                        "Operator" => [
                            "Account" => [
                                "Biodata",
                            ],
                            "Department",
                            "Office"
                        ],
                    ],
                    'recursive' => -1
                ));
                $this->data = $rows;
                $this->set(compact('rows'));
            }
        }
    }

    function admin_change_status_verify() {
        $this->autoRender = false;
        if ($this->request->is("PUT")) {
            $this->Freeze->data['Freeze']['id'] = $this->request->data['id'];
            $this->Freeze->data['Freeze']['verify_status_id'] = $this->request->data['status'];
            $dataFreeze = ClassRegistry::init("Freeze")->find("first", [
                "conditons" => [
                    "Freeze.id" => $this->request->data['id'],
                ]
            ]);
            $dataMaterialEntry = ClassRegistry::init("MaterialEntry")->find("first", [
                "conditons" => [
                    "MaterialEntry.id" => $dataFreeze['Freeze']['material_entry_id'],
                ]
            ]);
            if ($this->request->data['status'] == '3') {
//                $this->Freeze->data['TransactionEntry']['id'] = $dataTransactionEntry['TransactionEntry']['id'];
//                $this->Freeze->data['TransactionEntry']['stage_id'] = 3;
                $this->Freeze->data['Freeze']['verified_by_id'] = $this->_getEmployeeId();
                $this->Freeze->data['Freeze']['verified_datetime'] = date("Y-m-d H:i:s");
            } else if ($this->request->data['status'] == '2') {
//                $this->Freeze->data['TransactionEntry']['id'] = $dataTransactionEntry['TransactionEntry']['id'];
//                $this->Freeze->data['TransactionEntry']['stage_id'] = 2;
                $this->Freeze->data['Freeze']['verified_by_id'] = $this->_getEmployeeId();
                $this->Freeze->data['Freeze']['verified_datetime'] = date("Y-m-d H:i:s");
            } else {
                $this->Freeze->data['Freeze']['verified_by_id'] = null;
                $this->Freeze->data['Freeze']['verified_datetime'] = null;
            }
            $this->Freeze->saveAll();
            $data = $this->Freeze->find("first", array("conditions" => array("Freeze.id" => $this->request->data['id']), "recursive" => 1));
            echo json_encode($this->_generateStatusCode(207, null, array("status_label" => $data['VerifyStatus']['name'])));
        } else {
            echo json_encode($this->_generateStatusCode(400));
        }
    }

    function generateFreezeNumber() {
        $inc_id = 1;
        $m = date('n');
        $mRoman = romanic_number($m);
        $Y = date('Y');
        $testCode = "[0-9]{4}/FREE-PRO/$mRoman/$Y";
        $lastRecord = $this->Freeze->find('first', array('conditions' => array('and' => array("Freeze.freeze_number regexp" => $testCode)), 'order' => array('Freeze.freeze_number' => 'DESC')));
        if (!empty($lastRecord)) {
            $current = explode("/", $lastRecord['Freeze']['freeze_number']);
            $inc_id += $current[0];
        }
        $inc_id = sprintf("%04d", $inc_id);
        $kode = "$inc_id/FREE-PRO/$mRoman/$Y";
        return $kode;
    }

    function view_data_freeze($freezeId) {
        if (!empty($freezeId) && $freezeId != null) {
            $this->autoRender = false;
            $data = ClassRegistry::init("Freeze")->find("first", [
                "conditions" => [
                    "Freeze.id" => $freezeId,
                ],
                "contain" => [
                    "MaterialEntry",
                    "Conversion",
                    "FreezeDetail" => [
                        "Product" => [
                            "Parent"
                        ],
                        "RejectedGradeType"
                    ],
                    "Employee" => [
                        "Account" => [
                            "Biodata"
                        ],
                        "Department",
                        "Office"
                    ],
                    "VerifyStatus",
                    "VerifiedBy" => [
                        "Account" => [
                            "Biodata"
                        ]
                    ],
                    "Operator" => [
                        "Account" => [
                            "Biodata"
                        ],
                        "Office",
                        "Department"
                    ]
                ],
            ]);
            return json_encode($data);
        } else {
            throw new NotFoundException(__('Data Not Found'));
        }
    }

    function admin_list() {
        $this->autoRender = false;
        $conds = [];
        if (isset($this->request->query['q'])) {
            $q = $this->request->query['q'];
            $conds[] = array(
                "or" => array(
                    "Freeze.freeze_number like" => "%$q%",
            ));
        }
        $suggestions = ClassRegistry::init("Freeze")->find("all", array(
            "conditions" => [
                $conds,
                "Freeze.freeze_number !=" => null,
            ],
            "contain" => [
                "Employee" => [
                    "Account" => [
                        "Biodata",
                    ],
                ],
                "MaterialEntry"
            ],
            "limit" => 10,
        ));
        $result = [];
        foreach ($suggestions as $item) {
            if (!empty($item)) {
                if ($item['Employee']['branch_office_id'] == $this->Session->read("credential.admin.Employee.branch_office_id")) {
                    $result[] = [
                        "id" => @$item['Freeze']['id'],
                        "freeze_number" => @$item['Freeze']['freeze_number'],
                        "total_weight" => @$item['Freeze']['total_weight'],
                        "ratio" => @$item['Freeze']['ratio'],
                        "fullname" => @$item['Employee']['Account']['Biodata']['full_name'],
                    ];
                }
            }
        }
        echo json_encode($result);
    }

    function admin_list_validate() {
        $this->autoRender = false;
        $conds = [];
        if (isset($this->request->query['q'])) {
            $q = $this->request->query['q'];
            $conds[] = array(
                "or" => array(
                    "Freeze.freeze_number like" => "%$q%",
            ));
        }
        $suggestions = ClassRegistry::init("Freeze")->find("all", array(
            "conditions" => [
                $conds,
                "Freeze.freeze_number !=" => null,
            ],
            "contain" => [
                "Employee" => [
                    "Account" => [
                        "Biodata",
                    ],
                ],
                "MaterialEntry"
            ],
            "limit" => 10,
        ));
        $result = [];
        foreach ($suggestions as $item) {
            if (!empty($item)) {
                if ($item['Employee']['branch_office_id'] == $this->Session->read("credential.admin.Employee.branch_office_id")) {
                    if ($item['Freeze']['verify_status_id'] == 1) {
                        $result[] = [
                            "id" => @$item['Freeze']['id'],
                            "freeze_number" => @$item['Freeze']['freeze_number'],
                            "total_weight" => @$item['Freeze']['total_weight'],
                            "ratio" => @$item['Freeze']['ratio'],
                            "fullname" => @$item['Employee']['Account']['Biodata']['full_name'],
                        ];
                    }
                }
            }
        }
        echo json_encode($result);
    }

    function admin_list_freeze() {
        $this->autoRender = false;
        $conds = [];
        if (isset($this->request->query['q'])) {
            $q = $this->request->query['q'];
            $conds[] = array(
                "or" => array(
                    "Freeze.freeze_number like" => "%$q%",
            ));
        }
        $suggestions = ClassRegistry::init("Freeze")->find("all", array(
            "conditions" => [
                $conds,
                "Freeze.freeze_number !=" => null,
            ],
            "contain" => [
                "Employee" => [
                    "Account" => [
                        "Biodata",
                    ],
                ],
                "MaterialEntry",
                "Treatment" => [
                    "VerifyStatus"
                ]
            ],
            "limit" => 10,
        ));
        $result = [];
        foreach ($suggestions as $item) {
            if (!empty($item)) {
                if ($item['Employee']['branch_office_id'] == $this->Session->read("credential.admin.Employee.branch_office_id")) {
                    if ($item['Freeze']['id'] != $item['Treatment']['freeze_id'] && $item['Freeze']['verify_status_id'] == 3) {
                        $result[] = [
                            "id" => @$item['Freeze']['id'],
                            "freeze_number" => @$item['Freeze']['freeze_number'],
                            "total_weight" => @$item['Freeze']['total_weight'],
                            "ratio" => @$item['Freeze']['ratio'],
                            "fullname" => @$item['Employee']['Account']['Biodata']['full_name'],
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
            $data = ClassRegistry::init("MaterialEntry")->find("all", [
                "conditions" => [
                    "MaterialEntry.id" => $id
                ],
                "contain" => [
                    "Employee" => [
                        "Account" => [
                            "Biodata"
                        ],
                        "Department",
                        "Office"
                    ],
                    "Supplier",
                    "Conversion" => [
                        "ConversionData" => [
                            "MaterialDetail" => [
                                "Material"
                            ],
                            "MaterialSize",
                            "RejectedGradeType"
                        ],
                        "Freeze" => [
                            "FreezeDetail" => [
                                "Product" => [
                                    "Parent"
                                ],
                                "RejectedGradeType"
                            ],
                            "Employee" => [
                                "Account" => [
                                    "Biodata"
                                ],
                                "Department",
                                "Office"
                            ],
                            "Operator" => [
                                "Account" => [
                                    "Biodata"
                                ],
                                "Office",
                                "Department"
                            ],
                            "MaterialEntryGrade"
                        ],
                        "Employee" => [
                            "Account" => [
                                "Biodata"
                            ],
                            "Department",
                            "Office"
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
                    ],
                    "Freeze" => [
                        "FreezeDetail" => [
                            "Product" => [
                                "Parent"
                            ],
                            "RejectedGradeType"
                        ],
                        "FreezeSourceDetail" => [
                            "MaterialEntryGrade" => [
                                "MaterialDetail" => [
                                    "Material"
                                ],
                                "MaterialEntryGradeDetail",
                                "MaterialSize"
                            ],
                        ],
                        "Employee" => [
                            "Account" => [
                                "Biodata"
                            ],
                            "Department",
                            "Office"
                        ],
                        "Operator" => [
                            "Account" => [
                                "Biodata"
                            ],
                            "Office",
                            "Department"
                        ],
                        "Treatment" => [
                            "TreatmentDetail" => [
                                "Product" => [
                                    "Parent"
                                ],
                                "RejectedGradeType"
                            ],
                            "Employee" => [
                                "Account" => [
                                    "Biodata"
                                ],
                                "Department",
                                "Office"
                            ],
                            "Operator" => [
                                "Account" => [
                                    "Biodata"
                                ],
                                "Office",
                                "Department"
                            ],
                        ]
                    ],
                ]
            ]);
            return json_encode($this->_generateStatusCode(206, null, $data));
        } else {
            return json_encode("Data Tidak Ditemukan");
        }
    }

    function admin_change_status_validate() {
        $this->autoRender = false;
        if ($this->request->is("PUT")) {
            $this->Freeze->data['Freeze']['id'] = $this->request->data['id'];
            $this->Freeze->data['Freeze']['validate_status_id'] = $this->request->data['status'];
            if ($this->request->data['status'] == '3') {
                $this->Freeze->data['Freeze']['validate_by_id'] = $this->_getEmployeeId();
                $this->Freeze->data['Freeze']['validate_datetime'] = date("Y-m-d H:i:s");
            } else if ($this->request->data['status'] == '2') {
                $this->Freeze->data['Freeze']['validate_by_id'] = $this->_getEmployeeId();
                $this->Freeze->data['Freeze']['validate_datetime'] = date("Y-m-d H:i:s");
            } else {
                $this->Freeze->data['Freeze']['validate_by_id'] = null;
                $this->Freeze->data['Freeze']['validate_datetime'] = null;
            }
            $this->Freeze->saveAll();
            $data = $this->Freeze->find("first", array("conditions" => array("Freeze.id" => $this->request->data['id']), "recursive" => 1));
            echo json_encode($this->_generateStatusCode(207, null, array("status_label" => $data['ValidateStatus']['name'])));
        } else {
            echo json_encode($this->_generateStatusCode(400));
        }
    }

}
