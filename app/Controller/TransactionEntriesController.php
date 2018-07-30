<?php

App::uses('AppController', 'Controller');

class TransactionEntriesController extends AppController {

    var $name = "TransactionEntries";
    var $disabledAction = array(
    );
    var $contain = [
        "Employee" => [
            "Account" => [
                "Biodata",
            ],
            "City"
        ],
        "Supplier",
        "TransactionEntryFile" => [
            "AssetFile",
        ],
        "MaterialEntry"=>[
            "VerifyStatus"
        ],
        "TransactionEntryStatus",
        "BranchOffice"
    ];

    function beforeFilter() {
        parent::beforeFilter();
        $this->_setPageInfo("admin_index", "");
        $this->_setPageInfo("admin_add", "");
        $this->_setPageInfo("admin_edit", "");
    }

    function admin_index() {
        $this->_activePrint(func_get_args(), "data_transaksi_barang_masuk");
        $this->_setPeriodeLaporanDate("awal_MaterialEntry_weight_date", "akhir_MaterialEntry_weight_date");
        $this->conds = [
            "MaterialEntry.branch_office_id" => $this->stnAdmin->roleBranchId(),
                //"TransactionEntry.transaction_entry_status_id" => 1
        ];
        $this->contain = [
            "TransactionEntryStatus",
            "MaterialEntry" => [
                "VerifyStatus",
                "Employee" => [
                    "Account" => [
                        "Biodata"
                    ]
                ]
            ],
            "Supplier",
            "Employee" => [
                "Account" => [
                    "Biodata"
                ]
            ],
            "BranchOffice"
        ];
        parent::admin_index();
    }

    function admin_index_history() {
        $this->_activePrint(func_get_args(), "data_histori_transaksi_barang_masuk");
        $this->_setPeriodeLaporanDate("awal_TransactionEntry_created_date", "akhir_TransactionEntry_created_date");
        $this->conds = [
            "MaterialEntry.branch_office_id" => $this->stnAdmin->roleBranchId(),
                //"TransactionEntry.transaction_entry_status_id" => 1
        ];
        $this->contain = [
            "TransactionEntryStatus",
            "MaterialEntry" => [
                "Employee" => [
                    "Account" => [
                        "Biodata"
                    ]
                ]
            ],
            "Supplier",
            "Employee" => [
                "Account" => [
                    "Biodata"
                ]
            ],
            "BranchOffice"
        ];
        parent::admin_index();
    }

    function admin_index_upload_document() {
        $this->_activePrint(func_get_args(), "data_transaksi_barang_masuk_dokumen_qc");
        $this->_setPeriodeLaporanDate("awal_TransactionEntry_created_date", "akhir_TransactionEntry_created_date");
        $this->conds = [
            "MaterialEntry.branch_office_id" => $this->stnAdmin->roleBranchId(),
            "TransactionEntry.transaction_entry_status_id" => [1, 2, 3, 4]
        ];
        $this->contain = [
            "TransactionEntryStatus",
            "MaterialEntry" => [
                "Employee" => [
                    "Account" => [
                        "Biodata"
                    ]
                ]
            ],
            "Supplier",
            "Employee" => [
                "Account" => [
                    "Biodata"
                ]
            ],
            "BranchOffice",
            "DocumentStatus"
        ];
        parent::admin_index();
    }

    function admin_stok() {
        $this->_activePrint(func_get_args(), "data_transaction_entries");
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
                'contain' => ["TransactionMaterialEntry" => [
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
//            'rows' => [],
        );
        $this->set(compact('data'));
//        if ($this->args === false) {
//            $args = func_get_args();
//        } else {
//            $args = $this->args;
//        }
//        if (isset($args[0])) {
//            $jenis = $args[0];
//            $this->cetak = $jenis;
//                $this->render($this->cetak_template);
//        }
    }

    function admin_report() {
        $this->_activePrint(func_get_args(), "report_entry", ["excel" => "excel", "print" => "print_tanpa_kop"]);
        if (isset($this->request->query['Laporan_bulan']) && !empty($this->request->query['Laporan_bulan']) && isset($this->request->query['Laporan_tahun']) && !empty($this->request->query['Laporan_tahun'])) {
            $month = $this->request->query['Laporan_bulan'];
            $year = $this->request->query['Laporan_tahun'];
        } else {
            $month = date('m');
            $year = date('Y');
        }
        $rows = $this->{ Inflector::classify($this->name) }->find('all', array(
            'conditions' => array(
                //"DATE_FORMAT(TransactionEntry.created, '%m')" => $month,
                "DATE_FORMAT(TransactionEntry.created, '%Y')" => $year,
            ),
            'contain' => [
                "MaterialEntry",
                "TransactionMaterialEntry" => [
                    "MaterialDetail" => [
                        "Material" => [
                            "MaterialCategory",
                        ]
                    ],
                    "MaterialSize"
                ]
            ],
        ));
        $material_category = ClassRegistry::init("MaterialCategory")->find("all");
        $this->data = $rows;
        $data = array(
            'title' => 'Laporan Pembelian Ikan',
            'rows' => $rows,
            'material_categories' => $material_category,
            'month' => $month,
            'year' => $year,
        );
        $this->set(compact('data'));
    }

    function admin_print_report($month = null, $year = null) {
        $this->_activePrint(["print"], "report_entry", "print_tanpa_kop");
        $rows = $this->{ Inflector::classify($this->name) }->find('all', array(
            'conditions' => array(
                //"DATE_FORMAT(TransactionEntry.created, '%c')" => $month,
                "DATE_FORMAT(TransactionEntry.created, '%Y')" => $year,
            ),
            'contain' => [
                "MaterialEntry",
                "TransactionMaterialEntry" => [
                    "MaterialDetail" => [
                        "Material" => [
                            "MaterialCategory",
                        ]
                    ],
                    "MaterialSize"
                ]
            ],
        ));
        $material_category = ClassRegistry::init("MaterialCategory")->find("all");
        $this->data = $rows;
        $data = array(
            'title' => 'Laporan Pembelian Ikan',
            'rows' => $rows,
            'material_categories' => $material_category,
            'month' => $month,
            'year' => $year,
        );
        $this->set(compact('data'));
    }

    function admin_print_nota($id = null) {
        $this->_activePrint(["print"], "note_entry", "print_tanpa_kop");
        $rows = $this->{ Inflector::classify($this->name) }->find('all', array(
            'conditions' => array(
                Inflector::classify($this->name) . '.id' => $id,
            ),
            'contain' => [
                "Supplier",
                "TransactionMaterialEntry" => [
                    "MaterialDetail" => [
                        "Unit"
                    ],
                    "MaterialSize"
                ],
                "MaterialEntry",
                "Employee" => [
                    "Account" => [
                        "Biodata"
                    ]
                ],
                "PaymentPurchase"
            ],
        ));

        $this->data = $rows;
        $data = array(
            'title' => 'Nota Pembelian',
            'rows' => $rows,
        );
        $this->set(compact('data'));
    }

    function admin_rekap_per_bulan() {
        $this->_activePrint(func_get_args(), "report_rekap_per_bulan", ["excel" => "excel", "print" => "print_tanpa_kop"]);
        if (isset($this->request->query['start_date']) && !empty($this->request->query['start_date']) && isset($this->request->query['end_date']) && !empty($this->request->query['end_date'])) {
            $dateFrom = $this->request->query['start_date'];
            $dateTo = $this->request->query['end_date'];
        } else {
            $dateFrom = date("Y-m-d");
            $dateTo = date("Y-m-d");
        }
        if (isset($this->request->query['Laporan_kurs']) && !empty($this->request->query['Laporan_kurs'])) {
            $kurs = $this->request->query['Laporan_kurs'];
        } else {
            $kurs = 0;
        }
        $rows = $this->{ Inflector::classify($this->name) }->find('all', array(
            'conditions' => array(
                Inflector::classify($this->name) . '.created_date > ' => $dateFrom . " 00:00:00",
                Inflector::classify($this->name) . '.created_date <=' => $dateTo . " 23:59:59",
                Inflector::classify($this->name) . ".transaction_number NOT" => NULL,
                "MaterialEntry.stage_id >" => 2
            ),
            'contain' => [
                "MaterialEntry" => [
                    "Supplier",
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
                            "Product" => [
                                "Parent"
                            ],
                            "TreatmentSourceDetail"
                        ],
                        "Treatment" => [
                            "TreatmentDetail" => [
                                "Product" => [
                                    "Parent"
                                ]
                            ]
                        ]
                    ],
                    "MaterialEntryGrade" => [
                        "MaterialDetail" => [
                            "Material",
                            "Unit"
                        ],
                        "MaterialSize"
                    ]
                ],
                "TransactionMaterialEntry" => [
                    "MaterialDetail" => [
                        "Material",
                        "Unit"
                    ],
                    "MaterialSize",
                ],
            ],
        ));
        $this->data = $rows;
        $data = array(
            'title' => 'Rekap',
            'rows' => $rows,
            'kurs' => $kurs,
        );
        $this->set(compact('data'));
    }

    function admin_print_rekap_per_bulan($dateFrom = null, $dateTo = null, $type = null) {
        if ($type == "Cetak Laporan Pembobotan") { //Dokumen
            $this->_activePrint(["print"], "report_rekap_per_bulan", "print_tanpa_kop");
        } else { //excel
            $this->_activePrint(["excel"], "report_rekap_per_bulan");
        }
        $rows = $this->{ Inflector::classify($this->name) }->find('all', array(
            'conditions' => array(
                Inflector::classify($this->name) . '.created > ' => $dateFrom . " 00:00:00",
                Inflector::classify($this->name) . '.created <=' => $dateTo . " 23:59:59",
                "MaterialEntry.stage_id >" => 2
            ),
            'contain' => [
                "MaterialEntry" => [
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
                    "MaterialEntryGrade" => [
                        "MaterialDetail" => [
                            "Material",
                            "Unit"
                        ],
                        "MaterialSize"
                    ]
                ],
                "TransactionMaterialEntry" => [
                    "MaterialDetail" => [
                        "Material",
                        "Unit"
                    ],
                    "MaterialSize",
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

    function admin_rincian($id = null) {
        if ($this->request->is("post") || $this->request->is("put")) {
            $this->{ Inflector::classify($this->name) }->set($this->data);
            if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
//                $receiptNumber = $this->generateTransactionEntryNumber();
                $this->{ Inflector::classify($this->name) }->data['TransactionEntry']['branch_office_id'] = $this->stnAdmin->getBranchId();
                $this->{ Inflector::classify($this->name) }->data['TransactionEntry']['id'] = $id;
                $this->{ Inflector::classify($this->name) }->data['TransactionEntry']['employee_id'] = $this->Session->read("credential.admin.Employee.id");
                $this->{ Inflector::classify($this->name) }->data['TransactionEntry']['remaining'] = $this->TransactionEntry->data['TransactionEntry']['total'];
                $this->{ Inflector::classify($this->name) }->data['TransactionEntry']['created_date'] = $this->data['TransactionEntry']['created_date'];
                $this->{ Inflector::classify($this->name) }->data['TransactionEntry']['transaction_entry_status_id'] = 2;
                $this->TransactionEntry->data['TransactionEntry']['is_used'] = 1;
                if ($this->TransactionEntry->data['TransactionEntry']['material_category_id'] == 1) {
                    $this->{ Inflector::classify($this->name) }->data['TransactionEntry']['stage_id'] = 1;
                } else {
                    $this->{ Inflector::classify($this->name) }->data['TransactionEntry']['stage_id'] = 2;
                }
                $receiptNumber = $this->TransactionEntry->generateTransactionEntryNumber();
                $this->{ Inflector::classify($this->name) }->data['TransactionEntry']['transaction_number'] = $receiptNumber;
                $this->TransactionEntry->_numberSeperatorRemover();
                
                $dataTransactionEntry = $this->TransactionEntry->find("first",[
                    "conditions" => [
                        "TransactionEntry.id" => $id
                    ],
                    "contain" => [
                        "MaterialEntry" => [
                            "Supplier"
                        ]
                    ]
                ]);
                $supplier_name = $dataTransactionEntry['MaterialEntry']['Supplier']['name'];
                $view = new View($this);
                $html = $view->loadHelper('Html');
                $weight_date = $html->cvtTanggal($dataTransactionEntry['MaterialEntry']['weight_date']);

                /* updating to the Transaction Mutation Table */
                $this->{ Inflector::classify($this->name) }->data['TransactionMutation']['reference_number'] = $receiptNumber;
                $this->{ Inflector::classify($this->name) }->data['TransactionMutation']['transaction_name'] = "Transaksi Pembelian - " . $supplier_name . " - " . $weight_date;
                $this->{ Inflector::classify($this->name) }->data['TransactionMutation']['transaction_date'] = date("Y-m-d");
                $this->{ Inflector::classify($this->name) }->data['TransactionMutation']['transaction_type_id'] = 4;
                $this->{ Inflector::classify($this->name) }->data['TransactionMutation']['credit'] = $this->{ Inflector::classify($this->name) }->data['TransactionEntry']['total'];
                $this->{ Inflector::classify($this->name) }->data['TransactionMutation']['initial_balance_id'] = 1;

                /* update to the general entries table */
                $this->{ Inflector::classify($this->name) }->data['GeneralEntry'][0]['reference_number'] = $receiptNumber;
                $this->{ Inflector::classify($this->name) }->data['GeneralEntry'][0]['transaction_name'] = "Pembelian Ikan - " . $supplier_name . " - " . $weight_date;
                $this->{ Inflector::classify($this->name) }->data['GeneralEntry'][0]['transaction_date'] = date("Y-m-d");
                $this->{ Inflector::classify($this->name) }->data['GeneralEntry'][0]['transaction_type_id'] = 4;
                $this->{ Inflector::classify($this->name) }->data['GeneralEntry'][0]['general_entry_type_id'] = 50;
                $this->{ Inflector::classify($this->name) }->data['GeneralEntry'][0]['debit'] = $this->TransactionEntry->data['TransactionEntry']['total'];
                $this->{ Inflector::classify($this->name) }->data['GeneralEntry'][0]['general_entry_account_type_id'] = 1;
                $this->{ Inflector::classify($this->name) }->data['GeneralEntry'][0]['initial_balance_id'] = 1;
                $this->{ Inflector::classify($this->name) }->data['GeneralEntry'][1]['reference_number'] = $receiptNumber;
                $this->{ Inflector::classify($this->name) }->data['GeneralEntry'][1]['transaction_name'] = "Hutang Dagang - " . $supplier_name . " - " . $weight_date;
                $this->{ Inflector::classify($this->name) }->data['GeneralEntry'][1]['transaction_date'] = date("Y-m-d");
                $this->{ Inflector::classify($this->name) }->data['GeneralEntry'][1]['transaction_type_id'] = 4;
                $this->{ Inflector::classify($this->name) }->data['GeneralEntry'][1]['general_entry_type_id'] = 35;
                $this->{ Inflector::classify($this->name) }->data['GeneralEntry'][1]['credit'] = $this->TransactionEntry->data['TransactionEntry']['total'];
                $this->{ Inflector::classify($this->name) }->data['GeneralEntry'][1]['general_entry_account_type_id'] = 1;
                $this->{ Inflector::classify($this->name) }->data['GeneralEntry'][1]['initial_balance_id'] = 1;

                foreach ($this->TransactionEntry->data['TransactionMaterialEntry'] as $k => $params) {
                    $this->TransactionEntry->data['TransactionMaterialEntry'][$k]['remaining_weight'] = $params['weight'];
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
                $toUpdateMaterialEntryUsed = [
                    "MaterialEntry" => [
                        "id" => intval($this->data['TransactionEntry']['material_entry_id']),
                        "is_used" => 1
                    ]
                ];
                ClassRegistry::init("MaterialEntry")->saveAll($toUpdateMaterialEntryUsed);
                $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
                $this->Session->setFlash(__("Data berhasil diubah"), 'default', array(), 'success');
                $this->redirect(array('action' => 'admin_index'));
            } else {
                $this->validationErrors = $this->{ Inflector::classify($this->name) }->validationErrors;
            }
        } else {
            $rows = $this->TransactionEntry->find("first", array(
                'conditions' => array(
                    "TransactionEntry.id" => $id,
                ),
                "contain" => [

                    "MaterialEntry" => [
                        "Employee" => [
                            "Account" => [
                                "Biodata"
                            ]
                        ],
                        "MaterialEntryGrade" => [
                            "MaterialDetail" => [
                                "Material",
                                "Unit"
                            ],
                            "MaterialSize",
                            "MaterialEntryGradeDetail"
                        ],
                    ],
                    "MaterialCategory",
                    "Supplier" => [
                        "City",
                        "State"
                    ]
                ],
                'recursive' => 4
            ));
            $this->data = $rows;
        }
    }

    function beforeRender() {
        $this->_options();
        parent::beforeRender();
    }

    function _options() {
        $this->set("materials", ClassRegistry::init("Material")->find("list", array("fields" => array("Material.id", "Material.name"))));
        $this->set("branchOffices", $this->TransactionEntry->BranchOffice->find("list", array("fields" => array("BranchOffice.id", "BranchOffice.name"))));
        $this->set("documentStatuses", $this->TransactionEntry->DocumentStatus->find("list", array("fields" => array("DocumentStatus.id", "DocumentStatus.name"))));
        $this->set("dataMaterialSize", ClassRegistry::init("MaterialSize")->find("all", array("fields" => array("MaterialSize.id", "MaterialSize.name"))));
        $this->set("dataMaterialWhole", ClassRegistry::init("Material")->find("all", array("fields" => array("Material.id", "Material.name"), "contain" => array("MaterialDetail"), "conditions" => array("Material.material_category_id" => 1))));
        $this->set("dataMaterialColly", ClassRegistry::init("Material")->find("all", array("fields" => array("Material.id", "Material.name"), "contain" => array("MaterialDetail"), "conditions" => array("Material.material_category_id" => 2))));
        $this->set("countries", ClassRegistry::init("Country")->find("list", ["fields" => ["Country.id", "Country.name"]]));
        $this->set("states", ClassRegistry::init("State")->find("list", ["fields" => ["State.id", "State.name"]]));
        $this->set("cities", ClassRegistry::init("City")->find("list", ["fields" => ["City.id", "City.name"]]));
        $this->set("supplierTypes", ClassRegistry::init("SupplierType")->find("list", ["fields" => ["SupplierType.id", "SupplierType.name"]]));
        $this->set("suppliers", ClassRegistry::init("Supplier")->find("list", array("fields" => array("Supplier.id", "Supplier.name"))));
        $this->set("statuses", ClassRegistry::init("TransactionEntryStatus")->find("list", array("fields" => array("TransactionEntryStatus.id", "TransactionEntryStatus.name"))));
    }

    function admin_list_lunas() {
        $this->autoRender = false;
        $conds = [];
        if (isset($this->request->query['q'])) {
            $q = $this->request->query['q'];
            $conds[] = array(
                "or" => array(
                    "TransactionEntry.transaction_number like" => "%$q%",
            ));
        }
        $suggestions = ClassRegistry::init("TransactionEntry")->find("all", array(
            "conditions" => [
                $conds,
                "TransactionEntry.remaining <=" => 0,
            ],
            "contain" => [
                "TransactionMaterialEntry" => [
                    "MaterialDetail",
                    "MaterialSize"
                ],
                "Supplier" => [
                    "SupplierType",
                    "City",
                    "State",
                    "Country",
                    "CpCity",
                    "CpState",
                    "CpCountry"
                ],
                "Employee"
            ],
            "limit"=>10,
        ));
        $result = [];
        foreach ($suggestions as $item) {
            if (!empty($item)) {
                if ($item['Employee']['branch_office_id'] == $this->Session->read("credential.admin.Employee.branch_office_id")) {
                    $result[] = [
                        "id" => @$item['TransactionEntry']['id'],
                        "total_invoice" => @$item['TransactionEntry']['total'],
                        "remaining" => @$item['TransactionEntry']['remaining'],
                        "transaction_number" => @$item['TransactionEntry']['transaction_number'],
                        "invoice_id" => @$item['PaymentPurchase'][0]['id'],
                        "supplier_name" => @$item['Supplier']['name'],
                        "supplier_type" => @$item['Supplier']['SupplierType']['name'],
                        "email_supplier" => @$item['Supplier']['email'],
                        "address_supplier" => @$item['Supplier']['address'],
                        "postal_supplier" => @$item['Supplier']['postal_code'],
                        "city_supplier" => @$item['Supplier']['City']['name'],
                        "state_supplier" => @$item['Supplier']['State']['name'],
                        "country_supplier" => @$item['Supplier']['Country']['name'],
                        "phone_number_supplier" => @$item['Supplier']['phone_number'],
                        "website" => @$item['Supplier']['website'],
                        "cp_name" => @$item['Supplier']['cp_name'],
                        "cp_position" => @$item['Supplier']['cp_position'],
                        "cp_address" => @$item['Supplier']['cp_address'],
                        "cp_phone_number" => @$item['Supplier']['cp_phone_number'],
                        "cp_email" => @$item['Supplier']['cp_email'],
                        "cp_city" => @$item['Supplier']['CpCity']['name'],
                        "cp_state" => @$item['Supplier']['CpState']['name'],
                        "cp_country" => @$item['Supplier']['CpCountry']['name'],
                    ];
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
                    "TransactionEntry.transaction_number like" => "%$q%",
            ));
        }
        $suggestions = ClassRegistry::init("TransactionEntry")->find("all", array(
            "conditions" => [
                $conds,
            ],
            "contain" => [
                "TransactionMaterialEntry" => [
                    "MaterialDetail",
                    "MaterialSize"
                ],
                "Supplier",
                "Employee"
            ],
            "limit"=>10,
        ));
        $result = [];
        foreach ($suggestions as $item) {
            if (!empty($item)) {
                if ($item['Employee']['branch_office_id'] == $this->Session->read("credential.admin.Employee.branch_office_id")) {
                    $result[] = [
                        "id" => @$item['TransactionEntry']['id'],
                        "total_invoice" => @$item['TransactionEntry']['total'],
                        "transaction_number" => @$item['TransactionEntry']['transaction_number'],
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

    function admin_list() {
        $this->autoRender = false;
        $conds = [];
        if (isset($this->request->query['q'])) {
            $q = $this->request->query['q'];
            $conds[] = array(
                "or" => array(
                    "TransactionEntry.transaction_number like" => "%$q%",
                    "MaterialEntry.material_entry_number like" => "%$q%",
            ));
        }
        $suggestions = ClassRegistry::init("TransactionEntry")->find("all", array(
            "conditions" => [
                $conds,
                "TransactionEntry.remaining >" => 0,
            ],
            "contain" => [
                "MaterialEntry",
                "TransactionMaterialEntry" => [
                    "MaterialDetail",
                    "MaterialSize"
                ],
                "Supplier" => [
                    "SupplierType",
                    "City",
                    "State",
                    "Country",
                    "CpCity",
                    "CpState",
                    "CpCountry"
                ],
                "Employee",
                "PaymentPurchase"
            ],
            "limit"=>10,
        ));
        $result = [];
        foreach ($suggestions as $item) {
            if (!empty($item)) {
                if ($item['Employee']['branch_office_id'] == $this->Session->read("credential.admin.Employee.branch_office_id")) {
                    $dataInvoice = array_reverse(@$item['PaymentPurchase']);
                    $result[] = [
                        "id" => @$item['TransactionEntry']['id'],
                        "total_invoice" => @$item['TransactionEntry']['total'],
                        "transaction_number" => @$item['TransactionEntry']['transaction_number'],
                        "material_entry_id" => @$item['TransactionEntry']['material_entry_id'],
                        "material_entry_number" => @$item['MaterialEntry']['material_entry_number'],
                        "invoice_id" => @$dataInvoice[0]['id'],
                        "supplier_name" => @$item['Supplier']['name'],
                        "email_supplier" => @$item['Supplier']['email'],
                        "city_supplier" => @$item['Supplier']['City']['name'],
                        "state_supplier" => @$item['Supplier']['State']['name'],
                        "country_supplier" => @$item['Supplier']['Country']['name'],
                        "website" => @$item['Supplier']['website'],
                        "address_supplier" => @$item['Supplier']['address'],
                        "postal_supplier" => @$item['Supplier']['postal_code'],
                        "phone_supplier" => @$item['Supplier']['phone'],
                        "phone_number_supplier" => @$item['Supplier']['phone_number'],
                        "supplier_type" => @$item['Supplier']['SupplierType']['name'],
                        "cp_name" => @$item['Supplier']['cp_name'],
                        "cp_position" => @$item['Supplier']['cp_position'],
                        "cp_address" => @$item['Supplier']['cp_address'],
                        "cp_phone_number" => @$item['Supplier']['cp_phone_number'],
                        "cp_email" => @$item['Supplier']['cp_email'],
                        "cp_city" => @$item['Supplier']['CpCity']['name'],
                        "cp_state" => @$item['Supplier']['CpState']['name'],
                        "cp_country" => @$item['Supplier']['CpCountry']['name'],
                    ];
                }
            }
        }
        echo json_encode($result);
    }

    function admin_debt_list() {
        $this->_activePrint(func_get_args(), "data_hutang_usaha");
        $this->_setPeriodeLaporanDate("awal_TransactionEntry_due_date", "akhir_TransactionEntry_due_date");
        $conds = [];
        $this->contain = [
            "PaymentPurchase" => [
                "order" => "PaymentPurchase.id DESC",
                "conditions" => [
                ],
                "limit" => 1,
            ],
            "Employee",
            "Supplier",
            "BranchOffice",
            "MaterialEntry",
        ];
        $this->conds = [
            "TransactionEntry.remaining >" => 0,
            $conds
        ];
        $this->order="MaterialEntry.weight_date desc";
        parent::admin_index();
    }
    
    function admin_debt_list_report() {
        $this->_activePrint(func_get_args(), "laporan_hutang_usaha_per_supplier");
    }

    function admin_get_material_list($id = null) {
        $this->autoRender = false;
        $data = $this->{ Inflector::classify($this->name) }->find('first', array(
            "fields" => array(
                "TransactionEntry.transaction_number"
            ),
            "conditions" => array(
                "TransactionEntry.id" => $id,
            ),
            "contain" => array(
                "TransactionMaterialEntry" => [
                    "fields" => [
                        "TransactionMaterialEntry.material_detail_id",
                        "TransactionMaterialEntry.material_size_id",
                        "TransactionMaterialEntry.weight",
                        "TransactionMaterialEntry.remaining_weight"
                    ],
                    "MaterialSize",
                    "MaterialDetail" => ["Material", "Unit"],
                    "TransactionMaterialEntryDetail"
                ]
        )));
        echo json_encode($data);
    }

    function admin_view_data_transaction_entry($id = null) {
        $this->autoRender = false;
        if ($this->{ Inflector::classify($this->name) }->exists($id)) {
            if ($this->request->is("GET")) {
                $data = $this->{ Inflector::classify($this->name) }->find("first", [
                    "conditions" => [
                        "TransactionEntry.id" => $id
                    ],
                    "contain" => [
                        "TransactionMaterialEntry" => [
                            "MaterialDetail" => [
                                "Material",
                                "Unit"
                            ],
                            "MaterialSize"
                        ],
                        "MaterialEntry" => [
                            "Supplier",
                            "Employee" => [
                                "Account" => [
                                    "Biodata"
                                ]
                            ],
                            "MaterialEntryGrade" => [
                                "MaterialDetail" => [
                                    "Material"
                                ],
                                "MaterialSize"
                            ]
                        ],
                        "TransactionEntryFile" => [
                            "AssetFile"
                        ],
                        "Employee" => [
                            "Account" => [
                                "Biodata"
                            ]
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

    function admin_list_transaction_entry($state) {
        $this->autoRender = false;
        $conds = [];
        if (isset($this->request->query['q'])) {
            $q = $this->request->query['q'];
            $conds[] = array(
                "or" => array(
                    "TransactionEntry.transaction_number like" => "%$q%",
            ));
        }
        $suggestions = ClassRegistry::init("TransactionEntry")->find("all", array(
            "conditions" => [
                $conds,
                "TransactionEntry.stage_id" => $state,
                "TransactionEntry.material_category_id" => 2,
            ],
            "contain" => [
                "TransactionMaterialEntry" => [
                    "MaterialDetail",
                    "MaterialSize"
                ],
                "Supplier",
                "Employee"
            ],
            "limit"=>10,
        ));
        $result = [];
        foreach ($suggestions as $item) {
            if (!empty($item)) {
                if ($item['Employee']['branch_office_id'] == $this->Session->read("credential.admin.Employee.branch_office_id")) {
                    $result[] = [
                        "id" => @$item['TransactionEntry']['id'],
                        "total_invoice" => @$item['TransactionEntry']['total'],
                        "transaction_number" => @$item['TransactionEntry']['transaction_number'],
                    ];
                }
            }
        }
        echo json_encode($result);
    }

    function ajax_transaction_entries() {
        $this->autoRender = false;
        $this->response->type("json");
        if (isset($this->request->query["limit"]) && !empty($this->request->query["limit"])) {
            $limit = $this->request->query["limit"];
        } else {
            $limit = 3;
        }
        if (isset($this->request->query["order"]) && !empty($this->request->query["order"])) {
            $order = $this->request->query["order"];
        } else {
            $order = "TransactionEntry.due_date desc";
        }
        if (isset($this->request->query["page"]) && !empty($this->request->query["page"])) {
            $page = $this->request->query["page"];
        } else {
            $page = 1;
        }
        $conds = [
            "TransactionEntry.remaining >" => 0,
            "Employee.branch_office_id" => $this->Session->read("credential.admin.Employee.branch_office_id"),
        ];
        $filter = [
            "page" => $page,
            "order" => $order,
            "limit" => $limit,
            "conditions" => [
                $conds,
            ],
            "contain" => [
                "Employee",
                "Supplier"
            ],
        ];
        $transaction = ClassRegistry::init("TransactionEntry")->find("all", $filter);
        $count = ClassRegistry::init("TransactionEntry")->find("count", [
            "conditions" => [
                $conds,
            ],
            "contain" => [
                "Employee"
            ]
        ]);
        $info = [];
        $info['totalItem'] = $count;
        $info['totalPage'] = ceil($count / $limit);
        $info['currentPage'] = $page;
        $info['limit'] = $limit;
        $info['startItem'] = ($page - 1) * $limit + 1;
        $info['endItem'] = $info['startItem'] + $limit - 1;
        if ($info['endItem'] > $info['totalItem']) {
            $info['endItem'] = $info['totalItem'];
        }
        if ($info['totalItem'] == 0 && $info['endItem'] == 0) {
            $info['totalPage'] = 1;
        }
        echo json_encode($this->_generateStatusCode(206, null, ["items" => $transaction, "pagination_info" => $info, "filter" => $filter]));
    }

    function admin_upload_document($id = null) {
        if ($this->request->is("post") || $this->request->is("put")) {
            $this->{ Inflector::classify($this->name) }->set($this->data);
            if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                foreach ($this->data['TransactionEntryFile'] as $k => $details) {
                    if (!empty($details['file']['name'])) {
                        App::import("Vendor", "qqUploader");
                        $allowedExt = array("jpg", "jpeg", "png", "pdf", "doc", "docx", "xls", "xlsx");
                        $size = 10 * 1024 * 1024;
                        $uploader = new qqFileUploader($allowedExt, $size, $this->TransactionEntry->data['TransactionEntryFile'][$k]['file'], true);
                        $result = $uploader->handleUpload("transaksibarangmasuk" . DS);
                        switch ($result['status']) {
                            case 206:
                                $this->TransactionEntry->data['TransactionEntryFile'][$k]['AssetFile'] = array(
                                    "folder" => $result['data']['folder'],
                                    "filename" => $result['data']['fileName'],
                                    "ext" => $result['data']['ext'],
                                    "is_private" => true,
                                );
                                break;
                            case 443:
                                $var = "";
                                foreach ($allowedExt as $index => $ext) {
                                    $var .= $ext . ", ";
                                }
                                $this->Session->setFlash(__("Ekstensi file salah, yang diperbolehkan hanya " . $var), 'default', array(), 'warning');
                                $this->redirect(array('action' => 'admin_upload_document'));
                                break;
                        }
                        unset($this->TransactionEntry->data['TransactionEntryFile'][$k]['file']);
                    }
                }
                $this->TransactionEntry->data['TransactionEntry']['id'] = $id;
                $this->TransactionEntry->data['TransactionEntry']['transaction_entry_status_id'] = 3;
                $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
                $this->Session->setFlash(__("Data berhasil diubah"), 'default', array(), 'success');
                $this->redirect(array('action' => 'admin_index_upload_document'));
            } else {
                $this->validationErrors = $this->{ Inflector::classify($this->name) }->validationErrors;
            }
        } else {
            $rows = $this->TransactionEntry->find("first", array(
                'conditions' => array(
                    "TransactionEntry.id" => $id
                ),
                'contain' => [
                    "Employee" => [
                        "Account" => [
                            "Biodata"
                        ]
                    ],
                    "MaterialEntry" => [
                        "Employee" => [
                            "Account" => [
                                "Biodata"
                            ]
                        ],
                    ],
                    "MaterialCategory",
                    "TransactionMaterialEntry" => [
                        "MaterialDetail" => [
                            "Material"
                        ],
                        "MaterialSize",
                    ],
                    "Supplier"
                ]
            ));
            $this->data = $rows;
        }
    }

    function admin_payment_debt_index() {
        $this->contain = [
            "Supplier" => [
                "Country",
                "State",
                "City",
                "SupplierType"
            ],
            "PaymentPurchase"
        ];
        $this->conds = [
            "TransactionEntry.employee_id !=" => null
        ];
        $this->order = "Supplier.name";
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

    function admin_setup_payment_debt($supplier_id) {
        if ($this->request->is("post")) {
            if (!empty($supplier_id)) {
                $this->{ Inflector::classify($this->name) }->set($this->data);
                if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                    $dataTransactionEntry = "?transaction_entry_ids=";
                    foreach ($this->TransactionEntry->data['TransactionEntry'] as $index => $transactionEntries) {
                        if ($index != (count($transactionEntries) - 1)) {
                            $dataTransactionEntry .= $transactionEntries['transaction_entry_id'] . ",";
                        } else {
                            $dataTransactionEntry .= $transactionEntries['transaction_entry_id'];
                        }
                    }
                    $this->redirect(array('action' => 'admin_payment_debt' . $dataTransactionEntry, 'controller' => 'payment_purchases'));
                } else {
                    $this->validationErrors = $this->{ Inflector::classify($this->name) }->validationErrors;
                    $this->Session->setFlash(__("Harap mengecek kembali kesalahan dibawah."), 'default', array(), 'danger');
                }
            } else {
                $this->Session->setFlash(__("ID Transaksi Barang Masuk Kosong."), 'default', array(), 'danger');
                $this->redirect(array('action' => 'admin_payment_debt_index'));
            }
        } else {
            $data = $this->TransactionEntry->find("all", [
                "conditions" => [
                    "Supplier.id" => $supplier_id
                ],
                "contain" => [
                    "Supplier"
                ]
            ]);
            $this->set("supplier_id", $supplier_id);
            $this->set(compact("data"));
        }
    }

}
