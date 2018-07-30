<?php

App::uses('AppController', 'Controller');

class MaterialEntriesController extends AppController {

    var $name = "MaterialEntries";
    var $disabledAction = array(
    );
    var $contain = [
        "Employee" => [
            "Account" => [
                "Biodata",
            ],
        ],
        "Operator" => [
            "Account" => [
                "Biodata",
            ],
        ],
        "Supplier",
        "MaterialEntryGrade" => [
            "MaterialDetail" => [
                "Material"
            ],
            "MaterialEntryGradeDetail"
        ],
        "Conversion" => [
            "ConversionData",
            "Freeze" => [
                "FreezeDetail",
                "Treatment" => [
                    "TreatmentDetail"
                ]
            ]
        ],
        "Freeze",
        "Treatment" => [
            "TreatmentSourceDetail",
        ],
        "MaterialCategory",
        "TreatmentStatus",
        "BranchOffice",
        "VerifyStatus",
    ];

    function beforeFilter() {
        parent::beforeFilter();
        $this->_setPageInfo("admin_index", "");
        $this->_setPageInfo("admin_add", "");
        $this->_setPageInfo("admin_edit", "");
    }

    function admin_index() {
        $this->contain = [
            "Employee" => [
                "Account" => [
                    "Biodata",
                ],
            ],
            "Operator" => [
                "Account" => [
                    "Biodata",
                ],
            ],
            "Supplier",
            "MaterialEntryGrade" => [
                "MaterialDetail" => [
                ],
                "MaterialEntryGradeDetail"
            ],
            "MaterialCategory",
            "TreatmentStatus",
            "BranchOffice",
            "VerifyStatus",
        ];
        $this->_activePrint(func_get_args(), "data_nota_timbang");
        $this->_setPeriodeLaporanDate("awal_MaterialEntry_weight_date", "akhir_MaterialEntry_weight_date");
        $this->conds = [
            "MaterialEntry.branch_office_id" => $this->stnAdmin->roleBranchId()
        ];
        parent::admin_index();
    }

    function admin_status() {
        $this->_activePrint(func_get_args(), "data_nota_timbang_status");
        parent::admin_index();
    }

    function admin_stok() {
        $this->_activePrint(func_get_args(), "data_material_entries");
        $conds = $this->_filter($_GET, $this->filterCond);
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
                'contain' => ["MaterialEntryGrade" => [
                        "Material" => [
                            "Unit",
                            "MaterialCategory"
                        ]
                    ]]
            )
        );
        $rows = $this->Paginator->paginate($this->{ Inflector::classify($this->name) });
        $data = array(
            'rows' => $rows,
        );
        $this->set(compact('data'));
    }

    function admin_daily_weighting() {
        $this->_activePrint(func_get_args(), "report_weighting_daily", ["excel" => "excel", "print" => "print_tanpa_kop"]);
        if (isset($this->request->query['MaterialEntry_date']) && !empty($this->request->query['MaterialEntry_date'])) {
            $date = $this->request->query['MaterialEntry_date'];
        } else {
            $date = date("Y-m-d");
        }
        $rows = $this->{ Inflector::classify($this->name) }->find('all', array(
            'conditions' => array(
                Inflector::classify($this->name) . '.weight_date ' => $date,
            ),
            'contain' => [
                "MaterialEntryGrade" => [
                    "MaterialEntryGradeDetail",
                    "MaterialDetail" => [
                        "Material",
                        "Unit"
                    ]
                ]
            ],
        ));
        $this->data = $rows;
        $data = array(
            'title' => 'Laporan Pembobotan Ikan Harian',
            'rows' => $rows,
        );
        $this->set(compact('data'));
    }

    function admin_print_weighting_daily($date = null) {
        $this->_activePrint(["print"], "report_weighting_daily", "print_tanpa_kop");
        $rows = $this->{ Inflector::classify($this->name) }->find('all', array(
            'conditions' => array(
                Inflector::classify($this->name) . '.weight_date ' => $date,
            ),
            'contain' => [
                "MaterialEntryGrade" => [
                    "MaterialEntryGradeDetail",
                    "MaterialDetail" => [
                        "Material",
                        "Unit"
                    ]
                ]
            ],
        ));
        $this->data = $rows;
        $data = array(
            'title' => 'Laporan Pembobotan Ikan Harian',
            'rows' => $rows,
        );
        $this->set(compact('data'));
    }

    function admin_print_nota_timbang($id = null) {
        $this->_activePrint(["print"], "report_nota_timbang", "print_tanpa_kop");
        $rows = $this->{ Inflector::classify($this->name) }->find('first', array(
            'conditions' => array(
                Inflector::classify($this->name) . '.id' => $id,
            ),
            'contain' => [
                "MaterialEntryGrade" => [
                    "MaterialEntryGradeDetail",
                    "MaterialDetail" => [
                        "Material",
                        "Unit"
                    ],
                    "MaterialSize"
                ],
                "Supplier",
                "Employee" => [
                    "Account" => [
                        "Biodata"
                    ]
                ],
                "Operator" => [
                    "Account" => [
                        "Biodata"
                    ]
                ],
            ],
        ));
        $this->data = $rows;
        $data = array(
            'title' => 'Laporan Nota Timbang',
            'rows' => $rows,
        );
        $this->set(compact('data'));
    }

    function admin_print_nota_timbang_sum($id = null) {
        $this->_activePrint(["print"], "report_nota_timbang_sum", "print_tanpa_kop");
        $rows = $this->{ Inflector::classify($this->name) }->find('first', array(
            'conditions' => array(
                Inflector::classify($this->name) . '.id' => $id,
            ),
            'contain' => [
                "MaterialEntryGrade" => [
                    "MaterialEntryGradeDetail",
                    "MaterialDetail" => [
                        "Material",
                        "Unit"
                    ],
                    "MaterialSize",
                ],
                "Supplier",
                "Employee" => [
                    "Account" => [
                        "Biodata"
                    ]
                ],
                "Operator" => [
                    "Account" => [
                        "Biodata"
                    ]
                ],
            ],
        ));
        $this->data = $rows;
        $data = array(
            'title' => 'Laporan Nota Timbang',
            'rows' => $rows,
        );
        $this->set(compact('data'));
    }

    function admin_rekap_per_bulan() {
        if ($this->request->is("post")) {
            $this->admin_print_weighting_daily($this->data['MaterialEntry']['date']);
        }
    }

    function admin_print_rekap_per_bulan($date = null) {
        $this->_activePrint(["print"], "report_rekap_per_bulan", "print_plain");
        $rows = $this->{ Inflector::classify($this->name) }->find('all', array(
            'conditions' => array(
            ),
            'contain' => [
                "MaterialEntryGrade" => [
                    "MaterialEntryGradeDetail",
                    "MaterialDetail" => [
                        "Material",
                        "Unit"
                    ],
                    "MaterialSize",
                ],
                "Conversion" => [
                    "ConversionData" => [
                        "MaterialDetail" => [
                            "Material",
                            "Unit"
                        ],
                        "MaterialSize",
                    ]
                ],
                "Freeze" => [
                    "FreezeDetail" => [
                        "Product" => ["Parent"]
                    ],
                    "Treatment" => [
                        "TreatmentDetail" => [
                            "Product" => [
                                "Parent"
                            ]
                        ]
                    ]
                ],
            ],
        ));
        $this->data = $rows;
        $data = array(
            'title' => 'Rekap',
            'rows' => $rows,
        );
        $this->set(compact('data'));
    }

    function admin_add() {
        if ($this->request->is("post")) {
            $this->{ Inflector::classify($this->name) }->set($this->data);
            if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                $this->MaterialEntry->_numberSeperatorRemover();
                $this->MaterialEntry->data['MaterialEntry']['branch_office_id'] = $this->stnAdmin->getBranchId();
                $this->MaterialEntry->data['MaterialEntry']['verify_status_id'] = 1;
                foreach ($this->MaterialEntry->data['MaterialEntryGrade'] as $kGrade => $grade) {
                    foreach ($grade['MaterialEntryGradeDetail'] as $kDetail => $params) {
                        $this->{ Inflector::classify($this->name) }->data['MaterialEntryGrade'][$kGrade]['MaterialEntryGradeDetail'][$kDetail]['batch_number'] = $this->generateBatchNumber($this->data['MaterialEntry']['supplier_id'], $this->stnAdmin->getPacker(), $this->data['MaterialEntry']['material_category_id']);
                    }
                }
                $employee_id = $this->Session->read("credential.admin.Employee.id");
                $this->{ Inflector::classify($this->name) }->data['MaterialEntry']['employee_id'] = $employee_id;
                if ($this->MaterialEntry->data['MaterialEntry']['material_category_id'] == 1) {
                    $this->{ Inflector::classify($this->name) }->data['MaterialEntry']['stage_id'] = 1;
                } else {
                    $this->{ Inflector::classify($this->name) }->data['MaterialEntry']['stage_id'] = 2;
                }
                $this->{ Inflector::classify($this->name) }->data['MaterialEntry']['material_entry_number'] = $this->generateMaterialEntryNumber();

                /* adding to Transaction Entry Table */
                $this->MaterialEntry->data['TransactionEntry']['material_category_id'] = $this->data['MaterialEntry']['material_category_id'];
                $this->MaterialEntry->data['TransactionEntry']['supplier_id'] = $this->data['MaterialEntry']['supplier_id'];
                $this->MaterialEntry->data['TransactionEntry']['transaction_entry_status_id'] = 1;
                $this->MaterialEntry->data['TransactionEntry']['document_status_id'] = 1;
                foreach ($this->MaterialEntry->data['MaterialEntryGrade'] as $k => $params) {
                    $material = ClassRegistry::init("MaterialDetail")->find("first", [
                        "conditions" => [
                            "MaterialDetail.id" => $params['material_detail_id'],
                        ],
                    ]);
                    $toUpdate = [
                        "MaterialDetail" => [
                            "id" => intval($params['material_detail_id']),
                            "weight" => intval($params['weight']) + $material["MaterialDetail"]["weight"]
                        ]
                    ];
                    ClassRegistry::init("MaterialDetail")->saveAll($toUpdate);
                }
                $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
                $this->Session->setFlash(__("Data berhasil disimpan"), 'default', array(), 'success');
                $this->redirect(array('action' => 'admin_index'));
            } else {
                $this->validationErrors = $this->{ Inflector::classify($this->name) }->validationErrors;
                $this->Session->setFlash(__("Harap mengecek kembali kesalahan dibawah."), 'default', array(), 'danger');
            }
        }
        $this->set("dataMaterialSize", ClassRegistry::init("MaterialSize")->find("all", array("fields" => array("MaterialSize.id", "MaterialSize.name"))));
        $this->set("dataMaterialWhole", ClassRegistry::init("Material")->find("all", array("fields" => array("Material.id", "Material.name"), "contain" => array("MaterialDetail"), "conditions" => array("Material.material_category_id" => 1))));
        $this->set("dataMaterialColly", ClassRegistry::init("Material")->find("all", array("fields" => array("Material.id", "Material.name"), "contain" => array("MaterialDetail"), "conditions" => array("Material.material_category_id" => 2))));
        $this->set("dataMaterialDasar", ClassRegistry::init("Material")->find("all", array("fields" => array("Material.id", "Material.name"), "contain" => array("MaterialDetail"), "conditions" => array("Material.material_category_id" => 3))));
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

    function admin_get_data_material_entry($id = null) {
        $this->autoRender = false;
        if ($this->{ Inflector::classify($this->name) }->exists($id)) {
            if ($this->request->is("GET")) {
                $data = $this->{ Inflector::classify($this->name) }->find("first", [
                    "conditions" => [
                        "MaterialEntry.id" => $id
                    ],
                    "contain" => [
                        "MaterialEntryGrade" => [
                            "MaterialDetail" => [
                                "Material",
                                "Unit"
                            ],
                            "MaterialSize",
                            "MaterialEntryGradeDetail"
                        ],
                        "Supplier",
                        "Employee" => [
                            "Account" => [
                                "Biodata",
                            ],
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
        $this->set("materials", ClassRegistry::init("Material")->find("list", array("fields" => array("Material.id", "Material.name"))));
        $this->set("verifyStatuses", ClassRegistry::init("VerifyStatus")->find("list", array("fields" => array("VerifyStatus.id", "VerifyStatus.name"))));
        $this->set("suppliers", ClassRegistry::init("Supplier")->find("list", array("fields" => array("Supplier.id", "Supplier.name"))));
        $this->set("branchOffices", ClassRegistry::init("BranchOffice")->find("list", array("fields" => array("BranchOffice.id", "BranchOffice.name"))));
        $this->set("materialCategories", ClassRegistry::init("MaterialCategory")->find("list", array("fields" => array("MaterialCategory.id", "MaterialCategory.name"))));
        $this->set("materialEntryNumbers", ClassRegistry::init("MaterialEntry")->find("list", ["fields" => ["MaterialEntry.id", "MaterialEntry.material_entry_number"]]));
        $this->set("wholeMaterialEntryNumbers", ClassRegistry::init("MaterialEntry")->find("list", ["fields" => ["MaterialEntry.id", "MaterialEntry.material_entry_number"], "conditions" => ["MaterialEntry.material_category_id" => 1]]));
        $this->set("materialProcessingStatuses", ClassRegistry::init("ProductionCommonStatus")->getList("materialprocessing"));
    }

    function admin_list_lunas() {
        $this->autoRender = false;
        $conds = [];
        if (isset($this->request->query['q'])) {
            $q = $this->request->query['q'];
            $conds[] = array(
                "or" => array(
                    "MaterialEntry.material_entry_number like" => "%$q%",
            ));
        }
        $suggestions = ClassRegistry::init("MaterialEntry")->find("all", array(
            "conditions" => [
                $conds,
                "MaterialEntry.remaining =" => 0,
            ],
            "contain" => [
                "MaterialEntryGrade" => [
                    "MaterialDetail",
                    "MaterialSize"
                ],
                "Supplier",
                "Employee"
            ],
            "limit" => 10,
        ));
        $result = [];
        foreach ($suggestions as $item) {
            if (!empty($item)) {
                if ($item['Employee']['branch_office_id'] == $this->Session->read("credential.admin.Employee.branch_office_id")) {
                    $result[] = [
                        "id" => @$item['MaterialEntry']['id'],
                        "total_invoice" => @$item['MaterialEntry']['total'],
                        "material_entry_number" => @$item['MaterialEntry']['material_entry_number'],
                        "invoice_id" => @$item['PaymentPurchase'][0]['id'],
                        "supplier_name" => @$item['Supplier']['name'],
                        "email_supplier" => @$item['Supplier']['email'],
                        "city_supplier" => @$item['Supplier']['city'],
                        "state_supplier" => @$item['Supplier']['state'],
                        "address_supplier" => @$item['Supplier']['address'],
                        "postal_supplier" => @$item['Supplier']['postal_code'],
                        "phone_supplier" => @$item['Supplier']['phone'],
                        "phone_number_supplier" => @$item['Supplier']['phone_number'],
                    ];
                }
            }
        }
        echo json_encode($result);
    }

    function admin_list_status($status) {
        $this->autoRender = false;
        $conds = [];
        if (isset($this->request->query['q'])) {
            $q = $this->request->query['q'];
            $conds[] = array(
                "or" => array(
                    "MaterialEntry.material_entry_number like" => "%$q%",
            ));
        }
        $suggestions = ClassRegistry::init("MaterialEntry")->find("all", array(
            "conditions" => [
                $conds,
            ],
            "contain" => [
                "MaterialEntryGrade" => [
                    "MaterialDetail",
                    "MaterialSize"
                ],
                "Conversion",
                "Supplier",
                "Employee"
            ],
            "limit" => 10,
        ));
        $result = [];
        foreach ($suggestions as $item) {
            if (!empty($item)) {
                if ($item['Employee']['branch_office_id'] == $this->Session->read("credential.admin.Employee.branch_office_id")) {
                    if ($item['Conversion']['verify_status_id'] == $status) {
                        $result[] = [
                            "id" => @$item['MaterialEntry']['id'],
                            "material_entry_number" => @$item['MaterialEntry']['material_entry_number'],
                            "created_date" => @$item['MaterialEntry']['created'],
                            "supplier_name" => @$item['Supplier']['name'],
                        ];
                    }
                }
            }
        }
        echo json_encode($result);
    }

    function admin_list_normal() {
        $this->autoRender = false;
        $conds = [];
        if (isset($this->request->query['q'])) {
            $q = $this->request->query['q'];
            $conds[] = array(
                "or" => array(
                    "MaterialEntry.material_entry_number like" => "%$q%",
            ));
        }
        $suggestions = ClassRegistry::init("MaterialEntry")->find("all", array(
            "conditions" => [
                $conds,
            ],
            "contain" => [
                "Supplier",
                "Employee"
            ],
            "limit" => 10,
        ));
        $result = [];
        foreach ($suggestions as $item) {
            if (!empty($item)) {
                if ($item['Employee']['branch_office_id'] == $this->Session->read("credential.admin.Employee.branch_office_id")) {
                    $result[] = [
                        "id" => @$item['MaterialEntry']['id'],
                        "material_entry_number" => @$item['MaterialEntry']['material_entry_number'],
                        "created_date" => @$item['MaterialEntry']['created'],
                        "supplier_name" => @$item['Supplier']['name'],
                    ];
                }
            }
        }
        echo json_encode($result);
    }

    function admin_list() {
        $this->autoRender = false;
        $conds = [];
        if (isset($this->request->query['q'])) {
            $q = $this->request->query['q'];
            $conds[] = array(
                "or" => array(
                    "MaterialEntry.material_entry_number like" => "%$q%",
            ));
        }
        $suggestions = ClassRegistry::init("MaterialEntry")->find("all", array(
            "conditions" => [
                $conds,
                "MaterialEntry.remaining >" => 0,
            ],
            "contain" => [
                "MaterialEntryGrade" => [
                    "MaterialDetail",
                    "MaterialSize"
                ],
                "Supplier",
                "Employee"
            ],
            "limit" => 10,
        ));
        $result = [];
        foreach ($suggestions as $item) {
            if (!empty($item)) {
                if ($item['Employee']['branch_office_id'] == $this->Session->read("credential.admin.Employee.branch_office_id")) {
                    $result[] = [
                        "id" => @$item['MaterialEntry']['id'],
                        "total_invoice" => @$item['MaterialEntry']['total'],
                        "material_entry_number" => @$item['MaterialEntry']['material_entry_number'],
                        "invoice_id" => @$item['PaymentPurchase'][0]['id'],
                        "supplier_name" => @$item['Supplier']['name'],
                        "email_supplier" => @$item['Supplier']['email'],
                        "city_supplier" => @$item['Supplier']['city'],
                        "state_supplier" => @$item['Supplier']['state'],
                        "address_supplier" => @$item['Supplier']['address'],
                        "postal_supplier" => @$item['Supplier']['postal_code'],
                        "phone_supplier" => @$item['Supplier']['phone'],
                        "phone_number_supplier" => @$item['Supplier']['phone_number'],
                    ];
                }
            }
        }
        echo json_encode($result);
    }

    function admin_debt_list() {
        $this->contain = [
            "PaymentPurchase" => [
                "order" => "PaymentPurchase.id DESC",
                "conditions" => [
                ],
                "limit" => 1,
            ],
            "Employee",
            "Supplier"
        ];
        $this->conds = [
            "MaterialEntry.remaining >" => 0,
        ];
        parent::admin_index();
    }

    function admin_get_material_list($id = null) {
        $this->autoRender = false;
        $data = $this->{ Inflector::classify($this->name) }->find('first', array(
            "fields" => array(
                "MaterialEntry.material_entry_number"
            ),
            "conditions" => array(
                "MaterialEntry.id" => $id,
            ),
            "contain" => array(
                "MaterialEntryGrade" => [
                    "fields" => [
                        "MaterialEntryGrade.material_detail_id",
                        "MaterialEntryGrade.material_size_id",
                        "MaterialEntryGrade.weight",
                        "MaterialEntryGrade.remaining_weight"
                    ],
                    "MaterialSize",
                    "MaterialDetail" => ["Material", "Unit"],
                    "MaterialEntryGradeDetail"
                ]
        )));
        echo json_encode($data);
    }

    function admin_view_data_material_entry($id = null) {
        $this->autoRender = false;
        if ($this->{ Inflector::classify($this->name) }->exists($id)) {
            if ($this->request->is("GET")) {
                $data = $this->{ Inflector::classify($this->name) }->find("first", [
                    "conditions" => [
                        "MaterialEntry.id" => $id,
                    ],
                    "contain" => [
                        "TransactionEntry" => [
                            "TransactionMaterialEntry" => [
                                "MaterialDetail" => [
                                    "Material",
                                    "Unit"
                                ],
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
                        "MaterialEntryGrade" => [
                            "MaterialDetail" => [
                                "Material",
                                "Unit"
                            ],
                            "MaterialSize",
                            "MaterialEntryGradeDetail"
                        ],
                        "Supplier",
                        "MaterialCategory",
                        "Conversion" => [
                            "Employee" => [
                                "Account" => [
                                    "Biodata",
                                ],
                            ],
                        ],
                        "Operator" => [
                            "Account" => [
                                "Biodata"
                            ],
                            "Department",
                            "Office"
                        ]
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

    function generateMaterialEntryNumber() {
        $inc_id = 1;
        $month = romanic_number(date("n"));
        $Y = date('Y');
        $testCode = "[0-9]{4}/NTMB-PRO/$month/$Y";
        $lastRecord = $this->MaterialEntry->find('first', array('conditions' => array('and' => array("MaterialEntry.material_entry_number regexp" => $testCode)), 'order' => array('MaterialEntry.material_entry_number' => 'DESC')));
        if (!empty($lastRecord)) {
            $current = explode("/", $lastRecord['MaterialEntry']['material_entry_number']);
            $inc_id += $current[0];
        }
        $inc_id = sprintf("%04d", $inc_id);
        $kode = "$inc_id/NTMB-PRO/$month/$Y";
        return $kode;
    }

    function admin_list_material_entry($state) {
        $this->autoRender = false;
        $conds = [];
        if (isset($this->request->query['q'])) {
            $q = $this->request->query['q'];
            $conds[] = array(
                "or" => array(
                    "MaterialEntry.material_entry_number like" => "%$q%",
            ));
        }
        $suggestions = ClassRegistry::init("MaterialEntry")->find("all", array(
            "conditions" => [
                $conds,
                "MaterialEntry.stage_id" => $state,
                "MaterialEntry.material_category_id" => 2,
            ],
            "contain" => [
                "MaterialEntryGrade" => [
                    "MaterialDetail",
                    "MaterialSize"
                ],
                "Supplier",
                "Employee"
            ],
            "limit" => 10,
        ));
        $result = [];
        foreach ($suggestions as $item) {
            if (!empty($item)) {
                if ($item['Employee']['branch_office_id'] == $this->Session->read("credential.admin.Employee.branch_office_id")) {
                    $result[] = [
                        "id" => @$item['MaterialEntry']['id'],
                        "total_invoice" => @$item['MaterialEntry']['total'],
                        "material_entry_number" => @$item['MaterialEntry']['material_entry_number'],
                    ];
                }
            }
        }
        echo json_encode($result);
    }

    function generateBatchNumber($supplierId, $packerCode, $category) {
        $inc_id = 1;
        $supplier = "";
        $lastRecordSupplier = ClassRegistry::init("Supplier")->find('first', array('conditions' => array("Supplier.id" => $supplierId)));
        $supplier = $lastRecordSupplier['Supplier']['initial'];
        $recordInitialMonth = ClassRegistry::init("BatchMonth")->find('first', array('conditions' => array('month' => date('F'))));
        $M = $recordInitialMonth['BatchMonth']['batch_initial_month'];
        $recordInitialYear = ClassRegistry::init("BatchYear")->find('first', array('conditions' => array('year' => date('Y'))));
        $Y = $recordInitialYear['BatchYear']['batch_initial_year'];
        $D = date('d');
        $ProductionLine = "P1"; //P1 jika diproses di hari yang sama P2 jika diproses di hari kedua dan P3 ketika hari ke 3 dan seterusnya
        $kode = $supplier . $Y . $M . $D . $packerCode . $ProductionLine;
        return $kode;
    }

    function admin_conversion() {
        $this->_activePrint(func_get_args(), "data_konversi_berdasarkan_nota_timbang");
        $this->_setPeriodeLaporanDate("awal_MaterialEntry_weight_date", "akhir_MaterialEntry_weight_date");
        $this->conds = [
            "MaterialEntry.branch_office_id" => $this->stnAdmin->roleBranchId(),
            "MaterialEntry.material_category_id" => 1,
            "MaterialEntry.verify_status_id" => 3,
        ];
        $this->contain = [
            "MaterialEntryGrade" => [
                "MaterialEntryGradeDetail"
            ],
            "Supplier",
            "Employee" => [
                "Account" => [
                    "Biodata"
                ]
            ],
            "Conversion",
            "ConversionStatus",
            "BranchOffice"
        ];
        $this->order = "MaterialEntry.conversion_status_id asc,MaterialEntry.created desc";
        parent::admin_index();
    }

    function admin_freeze() {
        $this->_activePrint(func_get_args(), "data_styling_berdasarkan_nota_timbang");
        $this->_setPeriodeLaporanDate("awal_MaterialEntry_weight_date", "akhir_MaterialEntry_weight_date");
        $this->contain = [
            "MaterialCategory",
            "MaterialEntryGrade",
            "Supplier",
            "Conversion" => [
                "Freeze",
            ],
            "Freeze",
            "FreezingStatus",
            "BranchOffice"
        ];
        $this->conds = [
            "MaterialEntry.branch_office_id" => $this->stnAdmin->roleBranchId(),
            "MaterialEntry.verify_status_id" => 3,
        ];
        $this->order = "MaterialEntry.freezing_status_id asc,MaterialEntry.created desc";
        parent::admin_index();
    }

    function admin_treatment() {
        $this->_activePrint(func_get_args(), "data_treatment_berdasarkan_nota_timbang");
        $this->_setPeriodeLaporanDate("awal_MaterialEntry_weight_date", "akhir_MaterialEntry_weight_date");
        $this->contain = [
            "MaterialCategory",
            "MaterialEntryGrade",
            "Supplier",
            "Conversion" => [
                "Freeze" => [
                    "FreezeDetail",
                ]
            ],
            "TreatmentStatus",
            "Freeze" => [
                "FreezeDetail",
            ],
            "Treatment",
            "BranchOffice"
        ];
        $this->conds = [
            "MaterialEntry.branch_office_id" => $this->stnAdmin->roleBranchId(),
            "MaterialEntry.verify_status_id" => 3,
        ];
        $this->order = "MaterialEntry.treatment_status_id asc,MaterialEntry.id desc";
        parent::admin_index();
    }

    function admin_ratio() {
        $this->_activePrint(func_get_args(), "data_ratio_produksi");
        $this->_setPeriodeLaporanDate("awal_MaterialEntry_weight_date", "akhir_MaterialEntry_weight_date");
        parent::admin_index();
    }

    function admin_change_status_verify() {
        $this->autoRender = false;
        if ($this->request->is("PUT")) {
            $this->MaterialEntry->data['MaterialEntry']['id'] = $this->request->data['id'];
            $this->MaterialEntry->data['MaterialEntry']['verify_status_id'] = $this->request->data['status'];
            if ($this->request->data['status'] == '3') {
                $this->MaterialEntry->data['MaterialEntry']['verified_by_id'] = $this->_getEmployeeId();
                $this->MaterialEntry->data['MaterialEntry']['verified_datetime'] = date("Y-m-d H:i:s");
            } else if ($this->request->data['status'] == '2') {
                $this->MaterialEntry->data['MaterialEntry']['verified_by_id'] = $this->_getEmployeeId();
                $this->MaterialEntry->data['MaterialEntry']['verified_datetime'] = date("Y-m-d H:i:s");
            } else {
                $this->MaterialEntry->data['MaterialEntry']['verified_by_id'] = null;
                $this->MaterialEntry->data['MaterialEntry']['verified_datetime'] = null;
            }
            $this->MaterialEntry->saveAll();
            $data = $this->MaterialEntry->find("first", array("conditions" => array("MaterialEntry.id" => $this->request->data['id']), "recursive" => 2));
            echo json_encode($this->_generateStatusCode(207, null, array("status_label" => $data['VerifyStatus']['name'])));
        } else {
            echo json_encode($this->_generateStatusCode(400));
        }
    }

}
