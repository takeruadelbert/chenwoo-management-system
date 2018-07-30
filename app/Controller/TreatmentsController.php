<?php

App::uses('AppController', 'Controller');

class TreatmentsController extends AppController {

    var $name = "Treatments";
    var $disabledAction = array();
    var $contain = [
        "Employee" => [
            "Account" => [
                "Biodata"
            ],
            "Department"
        ],
        "VerifyStatus",
        "VerifiedBy" => [
            "Account" => [
                "Biodata",
            ],
        ],
        "Freeze",
        "BranchOffice",
        "ValidateStatus",
        "MaterialEntry" => [
            "Supplier"
        ]
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

    function _options() {
        $this->set("branchOffices", $this->Treatment->BranchOffice->find("list", array("fields" => array("BranchOffice.id", "BranchOffice.name"))));
        //$this->set("products", $this->Treatment->TreatmentDetail->Product->find("list", ["fields" => ["Product.id", "Product.name"]]));
        $this->set("verifyStatuses", $this->Treatment->VerifyStatus->find("list", ['fields' => ["VerifyStatus.id", "VerifyStatus.name"]]));
        $this->set("validateStatuses", $this->Treatment->ValidateStatus->find("list", ['fields' => ["ValidateStatus.id", "ValidateStatus.name"]]));
        $this->set("products", $this->Treatment->TreatmentDetail->Product->find("all", [
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
        $this->set("rejectedGradeTypes", ClassRegistry::init("RejectedGradeType")->find("list", array("fields" => array("RejectedGradeType.id", "RejectedGradeType.name"))));
    }

    function admin_index() {
        $this->_activePrint(func_get_args(), "data_treatment");
        $this->conds = [
            "Treatment.branch_office_id" => $this->stnAdmin->roleBranchId()
        ];
        parent::admin_index();
    }

    function admin_index_validate() {
        $this->_activePrint(func_get_args(), "data_treatment_validate");
        $this->conds = [
            "Treatment.verify_status_id" => 1,
            "Treatment.validate_status_id" => 2,
            "Treatment.branch_office_id" => $this->stnAdmin->roleBranchId()
        ];
        parent::admin_index();
    }

    function admin_add($materialEntryId = null) {
        if ($this->request->is("post")) {
            $this->{ Inflector::classify($this->name) }->set($this->data);
            $this->{ Inflector::classify($this->name) }->data["Treatment"]['employee_id'] = $this->Session->read("credential.admin.Employee.id");
            $this->{ Inflector::classify($this->name) }->data["Treatment"]['branch_office_id'] = $this->Session->read("credential.admin.Employee.branch_office_id");
            $this->{ Inflector::classify($this->name) }->data["Treatment"]['validate_status_id'] = 1;
            if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                $this->Treatment->data['Treatment']['treatment_number'] = $this->generateTreatmentNumber();
                $this->Treatment->data['Treatment']['employee_id'] = $this->stnAdmin->getEmployeeId();
                $this->Treatment->data['Treatment']['branch_office_id'] = $this->stnAdmin->getBranchId();
                $ratio = $this->Treatment->data['Treatment']['ratio'];
                $dt = date("Y-m-d H:i:s");
                if ($this->Treatment->data['Treatment']['ratio'] >= 95 && $this->Treatment->data['Treatment']['ratio'] <= 105) {
                    $this->{ Inflector::classify($this->name) }->data['Treatment']['verify_status_id'] = 3;
                    $this->Treatment->data['Treatment']['verified_by_id'] = $this->_getEmployeeId();
                    $this->Treatment->data['Treatment']['verified_datetime'] = date("Y-m-d H:i:s");
                } else {
                    $this->{ Inflector::classify($this->name) }->data['Treatment']['verify_status_id'] = 1;
                    $this->{ Inflector::classify($this->name) }->data['Treatment']['ratio_status_id'] = 4;
                }
                $materialEntryId = 0;

                foreach ($this->data["TreatmentDetail"] as $n => $treatmentDetail) {
                    $this->Treatment->data['TreatmentDetail'][$n]['remaining_weight'] = $treatmentDetail['weight'];
                    $this->Treatment->data['TreatmentDetail'][$n]['branch_office_id'] = $this->stnAdmin->getBranchId();
                }

                /*
                  foreach ($this->data['TreatmentSourceDetail'] as $dataSource) {
                  if (isset($dataSource['weight'])) {
                  $dataFreeze = ClassRegistry::init("FreezeDetail")->find("first", [
                  "conditions" => [
                  "FreezeDetail.freeze_id" => $dataSource['freeze_id'], //$this->data['Treatment']['freeze_id']
                  "FreezeDetail.id" => $dataSource['freeze_detail_id']
                  ],
                  "contain" => [
                  "Freeze" => [
                  "MaterialEntry",
                  "FreezeSourceDetail"
                  ]
                  ],
                  "recursive" => -1
                  ]);
                  $dataMaterial = ClassRegistry::init("MaterialEntryGrade")->find("first", [
                  "conditions" => [
                  "MaterialEntryGrade.id" => $dataFreeze['FreezeDetail']['material_entry_grade_id'], //$this->data['Treatment']['freeze_id']
                  ],
                  "contain" => [
                  "MaterialEntryGradeDetail"
                  ]
                  ]);
                  //Get Batch Number
                  $batchnumber = 0;
                  if ($dataFreeze['Freeze']["MaterialEntry"]["material_category_id"] == 1) {
                  $dataMaterial = ClassRegistry::init("MaterialEntryGrade")->find("first", [
                  "conditions" => [
                  "MaterialEntryGrade.id" => $dataFreeze['FreezeDetail']['material_entry_grade_id'], //$this->data['Treatment']['freeze_id']
                  ],
                  "contain" => [
                  "MaterialEntryGradeDetail"
                  ]
                  ]);
                  //whole
                  $batchnumber = $dataMaterial["MaterialEntryGradeDetail"][0]["batch_number"];
                  } else {
                  $dataMaterial = ClassRegistry::init("MaterialEntryGrade")->find("first", [
                  "conditions" => [
                  "MaterialEntryGrade.id" => $dataFreeze['Freeze']['FreezeSourceDetail'][0]['material_entry_grade_id'], //$this->data['Treatment']['freeze_id']
                  ],
                  "contain" => [
                  "MaterialEntryGradeDetail"
                  ]
                  ]);
                  //colly
                  $batchnumber = $dataMaterial["MaterialEntryGradeDetail"][0]["batch_number"];
                  }
                  $this->Treatment->data['Treatment']['material_entry_id'] = $dataFreeze['Freeze']['material_entry_id'];
                  $dataFreezeSave = [];
                  $dataFreezeSave['MaterialEntry']['id'] = $dataFreeze['Freeze']['material_entry_id'];
                  $dataFreezeSave['MaterialEntry']['stage_id'] = 4;
                  ClassRegistry::init("TransactionEntry")->save($dataFreezeSave);

                  //Get Freeze Detail
                  $dataFreezeDetail = ClassRegistry::init("FreezeDetail")->find("first", [
                  "conditions" => [
                  "FreezeDetail.id" => $dataSource['freeze_detail_id']
                  ],
                  ]);
                  $dataFreezeDetailSave = [];
                  $dataFreezeDetailSave['FreezeDetail']['id'] = $dataSource['freeze_detail_id'];
                  $dataFreezeDetailSave['FreezeDetail']['remaining_weight'] = floatval($dataFreezeDetail['FreezeDetail']['remaining_weight']) - floatval($dataSource['weight']);
                  ClassRegistry::init("FreezeDetail")->save($dataFreezeDetailSave);
                  }
                  }
                  foreach ($this->data["TreatmentDetail"] as $n => $treatmentDetail) {
                  $this->Treatment->data['TreatmentDetail'][$n]['remaining_weight'] = $treatmentDetail['weight'];
                  $this->Treatment->data['TreatmentDetail'][$n]['branch_office_id'] = $this->stnAdmin->getBranchId();

                  //Update ProductDetail
                  //check Product Detail is Exist
                  $productDetailTemp = ClassRegistry::init("ProductDetail")->find("first", [
                  "conditions" => [
                  "ProductDetail.product_id" => $treatmentDetail['product_id'],
                  "DATE_FORMAT(ProductDetail.production_date,'%Y-%m-%d')" => date("Y-m-d", strtotime($this->data['Treatment']["end_date"])),
                  "ProductDetail.batch_number" => $batchnumber,
                  "ProductDetail.branch_office_id" => $this->stnAdmin->getBranchId(),
                  "material_entry_id" => $dataFreeze['Freeze']['material_entry_id'],
                  ],
                  ]);
                  $materialEntryId = $dataFreeze['Freeze']['material_entry_id'];
                  if (empty($productDetailTemp)) { //if not exist
                  $toUpdateProductDetail = [
                  "ProductDetail" => [
                  "product_id" => $treatmentDetail['product_id'],
                  "production_date" => date("Y-m-d", strtotime($this->data['Treatment']["end_date"])),
                  "batch_number" => $batchnumber,
                  "remaining_weight" => floatval($treatmentDetail['weight']),
                  "branch_office_id" => $this->stnAdmin->getBranchId(),
                  "material_entry_id" => $dataFreeze['Freeze']['material_entry_id'],
                  ]
                  ];
                  } else {
                  $toUpdateProductDetail = [
                  "ProductDetail" => [
                  "id" => $productDetailTemp["ProductDetail"]["id"],
                  "remaining_weight" => floatval($treatmentDetail['weight']) + $productDetailTemp["ProductDetail"]["remaining_weight"],
                  ]
                  ];
                  }
                  ClassRegistry::init("ProductDetail")->saveAll($toUpdateProductDetail);
                  }
                 */

                $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));

                //update treament status on material entry
                //ClassRegistry::init("MaterialEntry")->updateTreatmentStatus($dataFreeze['Freeze']['material_entry_id']);

                /* posting to Product History Tables */
                if ($ratio >= 95 && $ratio <= 105) {
                    $treatment_last_insert_id = $this->Treatment->getLastInsertID();
                    $dataTreatment = $this->Treatment->find("first", [
                        "conditions" => [
                            "Treatment.id" => $treatment_last_insert_id
                        ]
                    ]);
                    foreach ($dataTreatment['TreatmentDetail'] as $details) {
                        $product_id = $details['product_id'];
                        $weight = $details['weight'];
                        ClassRegistry::init("ProductHistory")->postHistoryProduct($treatment_last_insert_id, $product_id, $weight, $dt, "MSK");
                    }
                }

                //Check treatment status and update if all done
                /*
                  $materialEntryDatas = ClassRegistry::init("MaterialEntry")->find("first", array(
                  'contains' => ['MaterialEntryGrade'],
                  "conditions" => array(
                  "MaterialEntry.id" => $materialEntryId,
                  ),
                  ));
                  $FreezeDatas = ClassRegistry::init("Freeze")->find("all", array(
                  'contains' => ['FreezeDetail'],
                  "conditions" => array(
                  "Freeze.material_entry_id" => $materialEntryId,
                  ),
                  ));
                  $status = false;
                  foreach ($materialEntryDatas['MaterialEntryGrade'] as $materialEntryData) { //error disini
                  if ($materialEntryData['remaining_weight'] > 0) {
                  $status = true;
                  }
                  }

                  $status = false;
                  foreach ($FreezeDatas as $FreezeData) {
                  foreach ($FreezeData['FreezeDetail'] as $FreezeDetailData) {
                  if ($FreezeDetailData['remaining_weight'] > 0) {
                  $status = true;
                  }
                  }
                  }
                  if ($status == false) {
                  $toUpdateMaterialEntry = [
                  "MaterialEntry" => [
                  "id" => $materialEntryId,
                  "treatment_status_id" => 2,
                  ]
                  ];
                  ClassRegistry::init("MaterialEntry")->saveAll($toUpdateMaterialEntry);
                  }
                 */

                $this->Session->setFlash(__("Data berhasil disimpan"), 'default', array(), 'success');
                //$this->redirect(array('action' => 'admin_index'));
                $this->redirect(array('controller' => 'material_entries', 'action' => 'admin_treatment'));
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
                            "Freeze" => [
                                "Employee" => [
                                    "Account" => [
                                        "Biodata",
                                    ],
                                ]
                            ],
                        ],
                        "Freeze" => [
                            "Employee" => [
                                "Account" => [
                                    "Biodata",
                                ],
                            ],
                            "FreezeDetail" => [
                                "Product" => [
                                    "Parent"
                                ]
                            ],
                            "Treatment",
                        ],
                    ]
                ]);
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
                        $this->Treatment->data['Treatment']['verified_by_id'] = $this->Session->read("credential.admin.Employee.id");
                        foreach ($this->Treatment->data['TreatmentDetail'] as $k => $treatment) {
                            $this->Treatment->TreatmentDetail->data['TreatmentDetail']['remaining_weight'] = $this->data['TreatmentDetail'][$k]['weight'];
                        }
//                        $dataFreeze = ClassRegistry::init("Freeze")->find("first", [
//                            "conditions" => [
//                                "Freeze.id" => $this->data['Treatment']['freeze_id']
//                            ]
//                        ]);
//                        $dataFreezeSave = [];
//                        $dataFreezeSave['TransactionEntry']['id'] = $dataFreeze['Freeze']['transaction_entry_id'];
                        $dataFreezeSave['TransactionEntry']['stage_id'] = 4;
                        ClassRegistry::init("TransactionEntry")->save($dataFreezeSave);

                        $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
                        $toUpdateTreatment = [
                            "Treatment" => [
                                "id" => $id,
                                "validate_status_id" => 1,
                            ]
                        ];
                        ClassRegistry::init("Treatment")->saveAll($toUpdateTreatment);
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
                    "contain" => [
                        "TreatmentDetail" => [
                            "Product" => [
                                "Parent"
                            ],
                            "RejectedGradeType"
                        ],
                        "Freeze" => [
                            "FreezeDetail"
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
                            "Department",
                            "Office"
                        ],
                        "VerifyStatus",
                        "TreatmentSourceDetail" => [
                            "Product",
                            "FreezeDetail" => [
                                "Freeze"
                            ]
                        ],
                    ]
                ));
                $this->data = $rows;
                $this->set(compact('rows'));
            }
        }
    }

    function generateTreatmentNumber() {
        $inc_id = 1;
        $m = date('n');
        $mRoman = romanic_number($m);
        $Y = date('Y');
        $testCode = "[0-9]{4}/TRMT-PRO/$mRoman/$Y";
        $lastRecord = $this->Treatment->find('first', array('conditions' => array('and' => array("Treatment.treatment_number regexp" => $testCode)), 'order' => array('Treatment.treatment_number' => 'DESC')));
        if (!empty($lastRecord)) {
            $current = explode("/", $lastRecord['Treatment']['treatment_number']);
            $inc_id += $current[0];
        }
        $inc_id = sprintf("%04d", $inc_id);
        $kode = "$inc_id/TRMT-PRO/$mRoman/$Y";
        return $kode;
    }

    function view_data_treatment($id = null) {
        $this->autoRender = false;
        if ($this->Treatment->exists($id)) {
            $data = $this->Treatment->find("first", [
                "conditions" => [
                    "Treatment.id" => $id
                ],
                "contain" => [
                    "Employee" => [
                        "Account" => [
                            "Biodata"
                        ],
                        "Department",
                        "Office"
                    ],
                    "Freeze" => [
                        "FreezeDetail"
                    ],
                    "TreatmentDetail" => [
                        "Product" => [
                            "Parent"
                        ],
                        "RejectedGradeType"
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
                ]
            ]);
            return json_encode($data);
        } else {
            throw new NotFoundException(__("404 Data Not Found"));
        }
    }

    function admin_list_treatment_validate() {
        $this->autoRender = false;
        $conds = [];
        if (isset($this->request->query['q'])) {
            $q = $this->request->query['q'];
            $conds[] = array(
                "or" => array(
                    "Treatment.treatment_number like" => "%$q%",
            ));
        }
        $suggestions = ClassRegistry::init("Treatment")->find("all", array(
            "conditions" => [
                $conds,
                "Treatment.treatment_number !=" => null
            ],
            "contain" => [
                "Employee" => [
                    "Account" => [
                        "Biodata"
                    ]
                ]
            ]
        ));
        $result = [];
        foreach ($suggestions as $item) {
            if (!empty($item)) {
                if ($item['Employee']['branch_office_id'] == $this->Session->read("credential.admin.Employee.branch_office_id")) {
                    if ($item['Treatment']['verify_status_id'] == 1) {
                        $result[] = [
                            "id" => @$item['Treatment']['id'],
                            "treatment_number" => @$item['Treatment']['treatment_number'],
                            "total" => @$item['Treatment']['total'],
                            "ratio" => @$item['Treatment']['ratio'],
                            "full_name" => @$item['Employee']['Account']['Biodata']['full_name']
                        ];
                    }
                }
            }
        }
        echo json_encode($result);
    }

    function admin_list_treatment() {
        $this->autoRender = false;
        $conds = [];
        if (isset($this->request->query['q'])) {
            $q = $this->request->query['q'];
            $conds[] = array(
                "or" => array(
                    "Treatment.treatment_number like" => "%$q%",
            ));
        }
        $suggestions = ClassRegistry::init("Treatment")->find("all", array(
            "conditions" => [
                $conds,
                "Treatment.treatment_number !=" => null
            ],
            "contain" => [
                "Employee" => [
                    "Account" => [
                        "Biodata"
                    ]
                ]
            ]
        ));
        $result = [];
        foreach ($suggestions as $item) {
            if (!empty($item)) {
                if ($item['Employee']['branch_office_id'] == $this->Session->read("credential.admin.Employee.branch_office_id")) {
                    $result[] = [
                        "id" => @$item['Treatment']['id'],
                        "treatment_number" => @$item['Treatment']['treatment_number'],
                        "total" => @$item['Treatment']['total'],
                        "ratio" => @$item['Treatment']['ratio'],
                        "full_name" => @$item['Employee']['Account']['Biodata']['full_name']
                    ];
                }
            }
        }
        echo json_encode($result);
    }

    function admin_get_detail_treatment_product($id = null) {
        $this->autoRender = false;
        $data = $this->{ Inflector::classify($this->name) }->TreatmentDetail->find('first', array("fields" => array(), "conditions" => array("TreatmentDetail.id" => $id), "contain" => array("Product" => ['Child'])));
        echo json_encode($data);
    }

    function admin_change_status_verify() {
        $this->autoRender = false;
        if ($this->request->is("PUT")) {
            $this->Treatment->data['Treatment']['id'] = $this->request->data['id'];
            $this->Treatment->data['Treatment']['verify_status_id'] = $this->request->data['status'];
            if ($this->request->data['status'] == '3') {
                $this->Treatment->data['Treatment']['verified_by_id'] = $this->_getEmployeeId();
                $this->Treatment->data['Treatment']['verified_datetime'] = date("Y-m-d H:i:s");
            } else if ($this->request->data['status'] == '2') {
                $this->Treatment->data['Treatment']['verified_by_id'] = $this->_getEmployeeId();
                $this->Treatment->data['Treatment']['verified_datetime'] = date("Y-m-d H:i:s");
            } else {
                $this->Treatment->data['Treatment']['verified_by_id'] = null;
                $this->Treatment->data['Treatment']['verified_datetime'] = null;
            }
            $this->Treatment->saveAll();

            /* posting to Product History Table */
            if ($this->request->data['status'] == '3') {
                $dataTreatment = $this->Treatment->find("first", [
                    "conditions" => [
                        "Treatment.id" => $this->request->data['id']
                    ]
                ]);
                $treatment_id = $dataTreatment['Treatment']['id'];
                $dt = date("Y-m-d H:i:s");
                foreach ($dataTreatment['TreatmentDetail'] as $details) {
                    $product_id = $details['product_id'];
                    $weight = $details['weight'];
                    ClassRegistry::init("ProductHistory")->postHistoryProduct($treatment_id, $product_id, $weight, $dt, "MSK");
                }
            }
            $data = $this->Treatment->find("first", array("conditions" => array("Treatment.id" => $this->request->data['id']), "recursive" => 1));
            echo json_encode($this->_generateStatusCode(207, null, array("status_label" => $data['VerifyStatus']['name'])));
        } else {
            echo json_encode($this->_generateStatusCode(400));
        }
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
                        ],
                        "MaterialEntryGradeDetail"
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

    function admin_change_status_validate() {
        $this->autoRender = false;
        $validate = false;
        if ($this->request->is("PUT")) {
            $this->Treatment->data['Treatment']['id'] = $this->request->data['id'];
            $this->Treatment->data['Treatment']['validate_status_id'] = $this->request->data['status'];
            if ($this->request->data['status'] == '3') {
                $this->Treatment->data['Treatment']['validate_by_id'] = $this->_getEmployeeId();
                $this->Treatment->data['Treatment']['validate_datetime'] = date("Y-m-d H:i:s");
            } else if ($this->request->data['status'] == '2') {
                //check if validation is duplicate or not
                $dataTreatmentSourceDetail = ClassRegistry::init("TreatmentSourceDetail")->find("first", [
                    "conditions" => [
                        "TreatmentSourceDetail.treatment_id" => $this->request->data['id'],
                    ],
                    "contain" => [
                        "FreezeDetail" => [
                            "Freeze",
                        ],
                        "Product"
                    ],
                    "recursive" => -1
                ]);
                if ($dataTreatmentSourceDetail['FreezeDetail']['remaining_weight'] >= $dataTreatmentSourceDetail['TreatmentSourceDetail']['weight']) {
                    $this->Treatment->data['Treatment']['validate_by_id'] = $this->_getEmployeeId();
                    $this->Treatment->data['Treatment']['validate_datetime'] = date("Y-m-d H:i:s");
                    $validate = true;
                } else {
                    $this->Treatment->data['Treatment']['validate_status_id'] = 3;
                    $data = $this->Treatment->find("first", array("conditions" => array("Treatment.id" => $this->request->data['id']), "recursive" => 1));
                    echo json_encode($this->_generateStatusCode(405, "Terjadi Kesalahan! Material tidak cukup!", array("status_label" => "Tidak Valid")));
                }
            } else {
                $this->Treatment->data['Treatment']['validate_by_id'] = null;
                $this->Treatment->data['Treatment']['validate_datetime'] = null;
            }
            //debug($dataTreatmentSourceDetail['FreezeDetail']['id']);
            //debug($dataTreatmentSourceDetail['FreezeDetail']['remaining_weight']);
            //die;

            $this->Treatment->saveAll();

            if ($this->request->data['status'] == '2' && $validate == true) {
                $materialEntryId = 0;
                $dataTreatmentSourceDetail = ClassRegistry::init("TreatmentSourceDetail")->find("first", [
                    "conditions" => [
                        "TreatmentSourceDetail.treatment_id" => $this->request->data['id'],
                    ],
                    "contain" => [
                        "FreezeDetail" => [
                            "Freeze",
                        ],
                        "Product"
                    ],
                    "recursive" => -1
                ]);
                $dataSource = $dataTreatmentSourceDetail;
                //foreach ($dataTreatmentSourceDetail as $dataSource) {
                //if (isset($dataSource['TreatmentSourceDetail']['weight'])) {
                $dataFreeze = ClassRegistry::init("FreezeDetail")->find("first", [
                    "conditions" => [
                        "FreezeDetail.freeze_id" => $dataSource['FreezeDetail']['freeze_id'], //$this->data['Treatment']['freeze_id']
                        "FreezeDetail.id" => $dataSource['FreezeDetail']['id']
                    ],
                    "contain" => [
                        "Freeze" => [
                            "MaterialEntry",
                            "FreezeSourceDetail"
                        ]
                    ],
                    "recursive" => -1
                ]);
                $dataTreatment = ClassRegistry::init("Treatment")->find("first", [
                    "conditions" => [
                        "Treatment.id" => $this->request->data['id'], 
                    ],
                    "contain" => [
                    ],
                    "recursive" => -1
                ]);
                $dataMaterial = ClassRegistry::init("MaterialEntryGrade")->find("first", [
                    "conditions" => [
                        "MaterialEntryGrade.id" => $dataFreeze['FreezeDetail']['material_entry_grade_id'], //$this->data['Treatment']['freeze_id']
                    ],
                    "contain" => [
                        "MaterialEntryGradeDetail"
                    ]
                ]);
                //Get Batch Number
                $batchnumber = 0;
                $categoryMaterial = $dataFreeze['Freeze']["MaterialEntry"]["material_category_id"];
                $supplierId = $dataFreeze['Freeze']['MaterialEntry']['supplier_id'];
                $weightDate = $dataFreeze['Freeze']['MaterialEntry']['weight_date'];
                if ($categoryMaterial == 1) {
//                        $dataMaterial = ClassRegistry::init("MaterialEntryGrade")->find("first", [
//                            "conditions" => [
//                                "MaterialEntryGrade.id" => $dataFreeze['FreezeDetail']['material_entry_grade_id'], //$this->data['Treatment']['freeze_id']
//                            ],
//                            "contain" => [
//                                "MaterialEntryGradeDetail"
//                            ]
//                        ]);
                    $dataConversion = ClassRegistry::init("Conversion")->find("first", [
                        "conditions" => [
                            "Conversion.id" => $dataFreeze['Freeze']['conversion_id'], //$this->data['Treatment']['freeze_id']
                        ],
                        "recursive" => -1
                    ]);
                    //whole
                    //$batchnumber = $dataMaterial["MaterialEntryGradeDetail"][0]["batch_number"];
                    $batchnumber = $this->generateBatchNumber($supplierId, $this->stnAdmin->getPacker(), $categoryMaterial, $weightDate, $dataTreatment['Treatment']['start_date']);
                } else {
//                        $dataMaterial = ClassRegistry::init("MaterialEntryGrade")->find("first", [
//                            "conditions" => [
//                                "MaterialEntryGrade.id" => $dataFreeze['Freeze']['FreezeSourceDetail'][0]['material_entry_grade_id'], //$this->data['Treatment']['freeze_id']
//                            ],
//                            "contain" => [
//                                "MaterialEntryGradeDetail"
//                            ]
//                        ]);
                    //colly
                    //$batchnumber = $dataMaterial["MaterialEntryGradeDetail"][0]["batch_number"];
                    $batchnumber = $this->generateBatchNumber($supplierId, $this->stnAdmin->getPacker(), $categoryMaterial, $weightDate, $dataTreatment['Treatment']['start_date']);
                }
                $this->Treatment->data['Treatment']['material_entry_id'] = $dataFreeze['Freeze']['material_entry_id'];
                $dataFreezeSave = [];
                $dataFreezeSave['MaterialEntry']['id'] = $dataFreeze['Freeze']['material_entry_id'];
                $dataFreezeSave['MaterialEntry']['stage_id'] = 4;
                ClassRegistry::init("MaterialEntry")->save($dataFreezeSave);

                //Get Freeze Detail
                $dataFreezeDetail = ClassRegistry::init("FreezeDetail")->find("first", [
                    "conditions" => [
                        "FreezeDetail.id" => $dataSource['FreezeDetail']['id']
                    ],
                ]);
                $dataFreezeDetailSave = [];
                $dataFreezeDetailSave['FreezeDetail']['id'] = $dataSource['FreezeDetail']['id'];
                $dataFreezeDetailSave['FreezeDetail']['remaining_weight'] = floatval($dataFreezeDetail['FreezeDetail']['remaining_weight']) - floatval($dataSource['TreatmentSourceDetail']['weight']);
                ClassRegistry::init("FreezeDetail")->save($dataFreezeDetailSave);
                //}
                //}
                //bug
                $dataTreatmentDetail = ClassRegistry::init("TreatmentDetail")->find("all", [
                    "conditions" => [
                        "TreatmentDetail.treatment_id" => $this->request->data['id'],
                    ],
                    "contain" => [
                        "Treatment"
                    ],
                    "recursive" => -1
                ]);
                foreach ($dataTreatmentDetail as $treatmentDetail) {
                    $productDetailTemp = ClassRegistry::init("ProductDetail")->find("first", [
                        "conditions" => [
                            "ProductDetail.product_id" => $treatmentDetail['TreatmentDetail']['product_id'],
                            "DATE_FORMAT(ProductDetail.production_date,'%Y-%m-%d')" => date("Y-m-d", strtotime($treatmentDetail['Treatment']["end_date"])),
                            "ProductDetail.batch_number" => $batchnumber,
                            "ProductDetail.branch_office_id" => $this->stnAdmin->getBranchId(),
                            "material_entry_id" => $dataFreeze['Freeze']['material_entry_id'],
                        ],
                    ]);
                    $materialEntryId = $dataFreeze['Freeze']['material_entry_id'];
                    $productDetailId = null;
                    if (empty($productDetailTemp)) { //if not exist
                        $toUpdateProductDetail = [
                            "ProductDetail" => [
                                "product_id" => $treatmentDetail['TreatmentDetail']['product_id'],
                                "production_date" => date("Y-m-d", strtotime($treatmentDetail['Treatment']["end_date"])),
                                "batch_number" => $batchnumber,
                                "remaining_weight" => floatval($treatmentDetail['TreatmentDetail']['weight']),
                                "branch_office_id" => $this->stnAdmin->getBranchId(),
                                "material_entry_id" => $dataFreeze['Freeze']['material_entry_id'],
                            ]
                        ];
                        ClassRegistry::init("ProductDetail")->saveAll($toUpdateProductDetail);
                        $productDetailId = ClassRegistry::init("ProductDetail")->getLastInsertID();
                    } else {
                        $toUpdateProductDetail = [
                            "ProductDetail" => [
                                "id" => $productDetailTemp["ProductDetail"]["id"],
                                "remaining_weight" => floatval($treatmentDetail['TreatmentDetail']['weight']) + $productDetailTemp["ProductDetail"]["remaining_weight"],
                            ]
                        ];
                        ClassRegistry::init("ProductDetail")->saveAll($toUpdateProductDetail);
                        $productDetailId = $productDetailTemp["ProductDetail"]["id"];
                    }
                    ClassRegistry::init("ProductDetailTreatmentDetail")->saveAll([
                        "ProductDetailTreatmentDetail" => [
                            "product_detail_id" => $productDetailId,
                            "treatment_detail_id" => $treatmentDetail['TreatmentDetail']["id"],
                        ],
                    ]);
                }

                //foreach ($dataTreatmentDetail as $n => $treatmentDetail) {
                //$this->Treatment->data['TreatmentDetail'][$n]['remaining_weight'] = $treatmentDetail['weight'];
                //$this->Treatment->data['TreatmentDetail'][$n]['branch_office_id'] = $this->stnAdmin->getBranchId();
                //Update ProductDetail
                //check Product Detail is Exist
                //}
                //Check treatment status and update if all done

                $materialEntryDatas = ClassRegistry::init("MaterialEntry")->find("first", array(
                    'contains' => ['MaterialEntryGrade'],
                    "conditions" => array(
                        "MaterialEntry.id" => $materialEntryId,
                    ),
                ));
                $FreezeDatas = ClassRegistry::init("Freeze")->find("all", array(
                    'contains' => ['FreezeDetail'],
                    "conditions" => array(
                        "Freeze.material_entry_id" => $materialEntryId,
                    ),
                ));
                $status = false;
                foreach ($materialEntryDatas['MaterialEntryGrade'] as $materialEntryData) { //error disini
                    if ($materialEntryData['remaining_weight'] > 0) {
                        $status = true;
                    }
                }

                $status = false;
                foreach ($FreezeDatas as $FreezeData) {
                    foreach ($FreezeData['FreezeDetail'] as $FreezeDetailData) {
                        if ($FreezeDetailData['remaining_weight'] > 0) {
                            $status = true;
                        }
                    }
                }
                if ($status == false) {
                    $toUpdateMaterialEntry = [
                        "MaterialEntry" => [
                            "id" => $materialEntryId,
                            "treatment_status_id" => 2,
                        ]
                    ];
                    ClassRegistry::init("MaterialEntry")->saveAll($toUpdateMaterialEntry);
                }

                $data = $this->Treatment->find("first", array("conditions" => array("Treatment.id" => $this->request->data['id']), "recursive" => 1));
                echo json_encode($this->_generateStatusCode(207, null, array("status_label" => $data['ValidateStatus']['name'])));
            }
        } else {
            echo json_encode($this->_generateStatusCode(400));
        }
    }

    function admin_fix_material_id() {
        $this->autoRender = false;
        $treatments = $this->Treatment->find("all", [
            "conditions" => [
                "Treatment.material_entry_id" => null,
            ],
            "contain" => [
                "TreatmentSourceDetail" => [
                    "FreezeDetail" => [
                        "Freeze",
                    ],
                ],
            ],
        ]);
        foreach ($treatments as $treatment) {
            $this->Treatment->saveAll([
                "Treatment" => [
                    "id" => $treatment["Treatment"]["id"],
                    "material_entry_id" => $treatment["TreatmentSourceDetail"][0]["FreezeDetail"]["Freeze"]["material_entry_id"],
                ],
            ]);
        }
    }

    function admin_fix_freeze_id() {
        $this->autoRender = false;
        $treatments = $this->Treatment->find("all", [
            "conditions" => [
                "Treatment.freeze_id" => null,
            ],
            "contain" => [
                "TreatmentSourceDetail" => [
                    "FreezeDetail",
                ],
            ],
        ]);
        foreach ($treatments as $treatment) {
            $this->Treatment->saveAll([
                "Treatment" => [
                    "id" => $treatment["Treatment"]["id"],
                    "freeze_id" => $treatment["TreatmentSourceDetail"][0]["FreezeDetail"]["freeze_id"],
                ],
            ]);
        }
    }

    function generateBatchNumber($supplierId, $packerCode, $category, $weightDate, $processDate) { //processdate whole in conversion, loin in styling
        $differentDate = date_diff(date_create($weightDate), date_create($processDate));
        $differentDate = $differentDate->format('%a');
        $inc_id = 1;
        $supplier = "";
        $lastRecordSupplier = ClassRegistry::init("Supplier")->find('first', array('conditions' => array("Supplier.id" => $supplierId)));
        $supplier = $lastRecordSupplier['Supplier']['initial'];
        $recordInitialMonth = ClassRegistry::init("BatchMonth")->find('first', array('conditions' => array('month' => date('F',strtotime($processDate)))));
        $M = $recordInitialMonth['BatchMonth']['batch_initial_month'];
        $recordInitialYear = ClassRegistry::init("BatchYear")->find('first', array('conditions' => array('year' => date('Y',strtotime($processDate)))));
        $Y = $recordInitialYear['BatchYear']['batch_initial_year'];
        $D = date('d',strtotime($processDate));
        $ProductionLine = "";
        if ($differentDate < 1) {
            $ProductionLine = "P1";
        } else if ($differentDate >= 2) {
            $ProductionLine = "P3";
        } else if ($differentDate >= 1) {
            $ProductionLine = "P2";
        }
        //$ProductionLine = "P1"; //P1 jika diproses di hari yang sama P2 jika diproses di hari kedua dan P3 ketika hari ke 3 dan seterusnya
        $kode = $supplier . $Y . $M . $D . $packerCode . $ProductionLine;
        return $kode;
    }

//    function admin_generatePDC() {
//        $this->autoRender=false;
//        $treatments = $this->Treatment->find("all", [
//            "recursive" => -1,
//            "contain" => [
//                "TreatmentDetail"
//            ],
//            "conditions" => [
//                "Treatment.validate_status_id" => 2,
//            ],
//        ]);
//        foreach ($treatments as $treatment) {
//            $dataTreatmentSourceDetail = ClassRegistry::init("TreatmentSourceDetail")->find("first", [
//                "conditions" => [
//                    "TreatmentSourceDetail.treatment_id" => $treatment["Treatment"]['id'],
//                ],
//                "contain" => [
//                    "FreezeDetail" => [
//                        "Freeze",
//                    ],
//                    "Product"
//                ],
//                "recursive" => -1
//            ]);
//            $dataSource = $dataTreatmentSourceDetail;
//            $dataFreeze = ClassRegistry::init("FreezeDetail")->find("first", [
//                "conditions" => [
//                    "FreezeDetail.freeze_id" => $dataSource['FreezeDetail']['freeze_id'], //$this->data['Treatment']['freeze_id']
//                    "FreezeDetail.id" => $dataSource['FreezeDetail']['id']
//                ],
//                "contain" => [
//                    "Freeze" => [
//                        "MaterialEntry",
//                        "FreezeSourceDetail"
//                    ]
//                ],
//                "recursive" => -1
//            ]);
//            $dataTreatment = ClassRegistry::init("Treatment")->find("first", [
//                "conditions" => [
//                    "Treatment.id" => $treatment["Treatment"]['id'], 
//                ],
//                "contain" => [
//                ],
//                "recursive" => -1
//            ]);
//            $dataMaterial = ClassRegistry::init("MaterialEntryGrade")->find("first", [
//                "conditions" => [
//                    "MaterialEntryGrade.id" => $dataFreeze['FreezeDetail']['material_entry_grade_id'], //$this->data['Treatment']['freeze_id']
//                ],
//                "contain" => [
//                    "MaterialEntryGradeDetail"
//                ]
//            ]);
//            //Get Batch Number
//            $batchnumber = 0;
//            $categoryMaterial = $dataFreeze['Freeze']["MaterialEntry"]["material_category_id"];
//            $supplierId = $dataFreeze['Freeze']['MaterialEntry']['supplier_id'];
//            $weightDate = $dataFreeze['Freeze']['MaterialEntry']['weight_date'];
//
//            if ($categoryMaterial == 1) {
//                $dataConversion = ClassRegistry::init("Conversion")->find("first", [
//                    "conditions" => [
//                        "Conversion.id" => $dataFreeze['Freeze']['conversion_id'], //$this->data['Treatment']['freeze_id']
//                    ],
//                    "recursive" => -1
//                ]);
//                $batchnumber = $this->generateBatchNumber($supplierId, $this->stnAdmin->getPacker(), $categoryMaterial, $weightDate, $dataTreatment['Treatment']['start_date']);
//            } else {
//                $batchnumber = $this->generateBatchNumber($supplierId, $this->stnAdmin->getPacker(), $categoryMaterial, $weightDate, $dataTreatment['Treatment']['start_date']);
//            }
//            $dataTreatmentDetail = ClassRegistry::init("TreatmentDetail")->find("all", [
//                "conditions" => [
//                    "TreatmentDetail.treatment_id" => $treatment["Treatment"]['id'],
//                ],
//                "contain" => [
//                    "Treatment"
//                ],
//                "recursive" => -1
//            ]);
//            foreach ($dataTreatmentDetail as $treatmentDetail) {
//                $productDetailTemp = ClassRegistry::init("ProductDetail")->find("first", [
//                    "conditions" => [
//                        "ProductDetail.product_id" => $treatmentDetail['TreatmentDetail']['product_id'],
//                        "DATE_FORMAT(ProductDetail.production_date,'%Y-%m-%d')" => date("Y-m-d", strtotime($treatmentDetail['Treatment']["end_date"])),
//                        "ProductDetail.batch_number" => $batchnumber,
//                        "ProductDetail.branch_office_id" => $this->stnAdmin->getBranchId(),
//                        "material_entry_id" => $dataFreeze['Freeze']['material_entry_id'],
//                    ],
//                    "recursive"=>-1,
//                ]);
//                $materialEntryId = $dataFreeze['Freeze']['material_entry_id'];
//                $productDetailId = null;
//                if (empty($productDetailTemp)) { //if not exist
//                    $toUpdateProductDetail = [
//                        "ProductDetail" => [
//                            "product_id" => $treatmentDetail['TreatmentDetail']['product_id'],
//                            "production_date" => date("Y-m-d", strtotime($treatmentDetail['Treatment']["end_date"])),
//                            "batch_number" => $batchnumber,
//                            "remaining_weight" => floatval($treatmentDetail['TreatmentDetail']['weight']),
//                            "branch_office_id" => $this->stnAdmin->getBranchId(),
//                            "material_entry_id" => $dataFreeze['Freeze']['material_entry_id'],
//                        ]
//                    ];
//                    ClassRegistry::init("ProductDetail")->saveAll($toUpdateProductDetail);
//                    $productDetailId = ClassRegistry::init("ProductDetail")->getLastInsertID();
//                } else {
//                    $toUpdateProductDetail = [
//                        "ProductDetail" => [
//                            "id" => $productDetailTemp["ProductDetail"]["id"],
//                            "remaining_weight" => floatval($treatmentDetail['TreatmentDetail']['weight']) + $productDetailTemp["ProductDetail"]["remaining_weight"],
//                        ]
//                    ];
//                    ClassRegistry::init("ProductDetail")->saveAll($toUpdateProductDetail);
//                    $productDetailId = $productDetailTemp["ProductDetail"]["id"];
//                }
//                ClassRegistry::init("ProductDetailTreatmentDetail")->saveAll([
//                    "ProductDetailTreatmentDetail" => [
//                        "product_detail_id" => $productDetailId,
//                        "treatment_detail_id" => $treatmentDetail['TreatmentDetail']["id"],
//                    ],
//                ]);
//            }
//        }
//    }

}
