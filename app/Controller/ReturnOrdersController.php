<?php

App::uses('AppController', 'Controller');

class ReturnOrdersController extends AppController {

    var $name = "ReturnOrders";
    var $disabledAction = array(
    );
    var $contain = [
        "MaterialEntry",
        "ReturnOrderDetail",
        "ReturnOrderStatus",
        "BranchOffice"
    ];

    function beforeFilter() {
        parent::beforeFilter();
        $this->_setPageInfo("admin_index", "");
        $this->_setPageInfo("admin_add", "");
        $this->_setPageInfo("admin_edit", "");
    }

    function admin_index() {
        $this->_activePrint(func_get_args(), "data_pengembalian_barang_ke_pemasok");
        $this->contain = [
            "MaterialEntry",
            "ReturnOrderDetail" => [
                "Conversion"
            ],
            "ReturnOrderStatus",
            "Employee" => [
                "Account" => [
                    "Biodata",
                ],
            ],
            "BranchOffice"
        ];
        $this->conds = [
            "MaterialEntry.branch_office_id" => $this->stnAdmin->roleBranchId()
        ];
        parent::admin_index();
    }

    function admin_add() {
        if ($this->request->is("post")) {
            $this->{ Inflector::classify($this->name) }->set($this->data);
            if(!empty($this->data['Dummy']['piutang_supplier_id'])) {
                if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                    $this->{ Inflector::classify($this->name) }->_numberSeperatorRemover();
                    $return_order_number = $this->generateReturnNumber();
                    $this->{ Inflector::classify($this->name) }->data["ReturnOrder"]['return_number'] = $return_order_number;
                    $this->{ Inflector::classify($this->name) }->data["ReturnOrder"]['return_order_status_id'] = 1;
                    $this->{ Inflector::classify($this->name) }->data["ReturnOrder"]['employee_id'] = $this->Session->read("credential.admin.Employee.id");
                    $this->{ Inflector::classify($this->name) }->data['ReturnOrder']['branch_office_id'] = $this->Session->read("credential.admin.Employee.branch_office_id");
                    foreach ($this->data["ReturnOrderDetail"] as $n => $detail) {
                        $conversionId = $detail['conversion_id'];
                        //Update Conversion
                        if ($conversionId != 0) { //check if whole or not (0 = loin)
                            $toUpdateConversion = [
                                "Conversion" => [
                                    "id" => $detail['conversion_id'],
                                    "return_order_status" => 1,
                                ]
                            ];
                            ClassRegistry::init("Conversion")->saveAll($toUpdateConversion);

                            //update material entry grade detail
                            ClassRegistry::init("MaterialEntryGradeDetail")->updateAll(
                                    [
                                "MaterialEntryGradeDetail.return_order_status" => 1,
                                    ], [
                                "MaterialEntryGradeDetail.conversion_id" => $conversionId
                                    ]
                            );
                        }

                        $dataMaterialEntry = ClassRegistry::init("MaterialEntry")->find("first", [
                            "conditions" => [
                                "MaterialEntry.id" => $this->data['ReturnOrder']['material_entry_id'],
                            ],
                        ]);

                        //Update Freeze
                        //Check Whole or Loin
                        if ($dataMaterialEntry['MaterialEntry']['material_category_id'] == 1) { //whole
                            //Get Freeze Id
                            $dataFreeze = ClassRegistry::init("Freeze")->find("first", [
                                "conditions" => [
                                    "Freeze.material_entry_id" => $this->data['ReturnOrder']['material_entry_id'],
                                    "Freeze.conversion_id" => $conversionId,
                                ],
                            ]);
                            if ($dataFreeze != null) {
                                ClassRegistry::init("Freeze")->updateAll([
                                    "Freeze.return_order_status" => 1,
                                        ], [
                                    "Freeze.material_entry_id" => $this->data['ReturnOrder']['material_entry_id'],
                                    "Freeze.conversion_id" => $conversionId,
                                        ]
                                );
                            }
                            //Get data Treatment
                            $dataTreatment = ClassRegistry::init("Treatment")->find("first", [
                                "conditions" => [
                                    "Treatment.material_entry_id" => $this->data['ReturnOrder']['material_entry_id'],
                                    "Treatment.freeze_id" => $dataFreeze['Freeze']['id'],
                                ],
                            ]);
                            if ($dataTreatment != null) {
                                ClassRegistry::init("Treatment")->updateAll([
                                    "Treatment.return_order_status" => 1,
                                        ], [
                                    "Treatment.material_entry_id" => $this->data['ReturnOrder']['material_entry_id'],
                                    "Treatment.freeze_id" => $dataFreeze['Freeze']['id'],
                                        ]
                                );
                            }
                        } else { //Loin
                            $dataFreeze = ClassRegistry::init("Freeze")->find("first", [
                                "conditions" => [
                                    "Freeze.material_entry_id" => $this->data['ReturnOrder']['material_entry_id'],
                                    "Freeze.conversion_id" => NULL,
                                ],
                            ]);
                            if ($dataFreeze != null) {
                                ClassRegistry::init("Freeze")->updateAll([
                                    "Freeze.return_order_status" => 1,
                                        ], [
                                    "Freeze.material_entry_id" => $this->data['ReturnOrder']['material_entry_id'],
                                        ]
                                );
                            }
                            //Get data Treatment
                            $dataTreatment = ClassRegistry::init("Treatment")->find("first", [
                                "conditions" => [
                                    "Treatment.material_entry_id" => $this->data['ReturnOrder']['material_entry_id'],
                                    "Treatment.freeze_id" => $dataFreeze['Freeze']['id'],
                                ],
                            ]);
                            if ($dataTreatment != null) {
                                ClassRegistry::init("Treatment")->updateAll([
                                    "Treatment.return_order_status" => 1,
                                        ], [
                                    "Treatment.material_entry_id" => $this->data['ReturnOrder']['material_entry_id'],
                                    "Treatment.freeze_id" => $dataFreeze['Freeze']['id'],
                                        ]
                                );
                            }
                        }
                    }

                    if ($this->ReturnOrder->data['ReturnOrder']['total'] > 0) {
                        /* posting to transaction mutation */
                        $dataPiutangSupplier = ClassRegistry::init("GeneralEntryType")->find("first", [
                            "conditions" => [
                                "GeneralEntryType.id" => $this->data['Dummy']['piutang_supplier_id']
                            ]
                        ]);
                        $this->ReturnOrder->data['TrnasactionMutation']['initial_balance_id'] = 1;
                        $this->ReturnOrder->data['TransactionMutation']['reference_number'] = $return_order_number;
                        $this->ReturnOrder->data['TransactionMutation']['transaction_name'] = $dataPiutangSupplier['GeneralEntryType']['name'];
                        $this->ReturnOrder->data['TransactionMutation']['debit'] = $this->ReturnOrder->data['ReturnOrder']['total'];
                        $this->ReturnOrder->data['TransactionMutation']['transaction_date'] = date("Y-m-d");
                        $this->ReturnOrder->data['TransactionMutation']['transaction_type_id'] = 8;

                        /* posting to general entry table */
                        $this->ReturnOrder->data['GeneralEntry'][0]['initial_balance_id'] = 1;
                        $this->ReturnOrder->data['GeneralEntry'][0]['reference_number'] = $return_order_number;
                        $this->ReturnOrder->data['GeneralEntry'][0]['transaction_name'] = $dataPiutangSupplier['GeneralEntryType']['name'];
                        $this->ReturnOrder->data['GeneralEntry'][0]['debit'] = $this->ReturnOrder->data['ReturnOrder']['total'];
                        $this->ReturnOrder->data['GeneralEntry'][0]['transaction_date'] = date("Y-m-d");
                        $this->ReturnOrder->data['GeneralEntry'][0]['general_entry_type_id'] = $dataPiutangSupplier['GeneralEntryType']['id'];
                        $this->ReturnOrder->data['GeneralEntry'][0]['transaction_type_id'] = 8;
                        $this->ReturnOrder->data['GeneralEntry'][0]['general_entry_account_type_id'] = 2;
                        $this->ReturnOrder->data['GeneralEntry'][1]['initial_balance_id'] = 1;
                        $this->ReturnOrder->data['GeneralEntry'][1]['reference_number'] = $return_order_number;
                        $this->ReturnOrder->data['GeneralEntry'][1]['transaction_name'] = "Pembelian Ikan";
                        $this->ReturnOrder->data['GeneralEntry'][1]['credit'] = $this->ReturnOrder->data['ReturnOrder']['total'];
                        $this->ReturnOrder->data['GeneralEntry'][1]['transaction_date'] = date("Y-m-d");
                        $this->ReturnOrder->data['GeneralEntry'][1]['general_entry_type_id'] = 50;
                        $this->ReturnOrder->data['GeneralEntry'][1]['transaction_type_id'] = 8;
                        $this->ReturnOrder->data['GeneralEntry'][1]['general_entry_account_type_id'] = 2;
                    }

                    $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
                    $this->Session->setFlash(__("Data berhasil disimpan"), 'default', array(), 'success');
                    $this->redirect(array('action' => 'admin_index'));
                } else {
                    $this->validationErrors = $this->{ Inflector::classify($this->name) }->validationErrors;
                    $this->Session->setFlash(__("Harap mengecek kembali kesalahan dibawah."), 'default', array(), 'danger');
                }
            } else {
                $this->Session->setFlash(__("Akun Piutang Supplier Harus Dipilih."), 'default', array(), 'danger');
            }
        }
    }

    function admin_view_data_return_order($id = null) {
        $this->autoRender = false;
        if ($this->ReturnOrder->exists($id)) {
            if ($this->request->is("GET")) {
                $data = $this->ReturnOrder->find("first", [
                    "conditions" => [
                        "ReturnOrder.id" => $id,
                    ],
                    "contain" => [
                        "Employee" => [
                            "Account" => [
                                "Biodata",
                            ],
                        ],
                        "MaterialEntry" => [
                            "TransactionEntry" => [
                                "TransactionMaterialEntry" => [
                                    "MaterialSize",
                                    "MaterialDetail" => [
                                        "Material",
                                        "Unit"
                                    ]
                                ]
                            ]
                        ],
                        "ReturnOrderDetail" => [
                            "Conversion" => [
                                "MaterialEntry" => [
                                    "TransactionEntry" => [
                                        "TransactionMaterialEntry" => [
                                            "MaterialSize",
                                            "MaterialDetail" => [
                                                "Material",
                                                "Unit"
                                            ]
                                        ]
                                    ]
                                ],
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

    function beforeRender() {
        $this->_options();
        parent::beforeRender();
    }

    function _options() {
        $this->set("piutangSuppliers", ClassRegistry::init("GeneralEntryType")->find("list", ["fields" => ["GeneralEntryType.id", "GeneralEntryType.name"], "conditions" => ["GeneralEntryType.parent_id" => 51]]));
        $this->set("materialEntries", ClassRegistry::init("MaterialEntry")->find("list", array("fields" => array("MaterialEntry.id", "MaterialEntry.material_entry_number"))));
        $this->set("returnOrderNumbers", ClassRegistry::init("ReturnOrder")->find("list", ["fields" => ["ReturnOrder.id", "ReturnOrder.return_number"]]));
        $this->set("returnOrderStatuses", ClassRegistry::init("ReturnOrderStatus")->find("list", ["fields" => ["ReturnOrderStatus.id", "ReturnOrderStatus.name"]]));
        $this->set("branchOffices", $this->ReturnOrder->BranchOffice->find("list", ["fields" => ["BranchOffice.id", "BranchOffice.name"]]));
    }

    function generateReturnNumber() {
        $inc_id = 1;
        $Y = date('Y');
        $M = romanic_number(date('n'));
        $testCode = "[0-9]{4}/NTRO-PRO/$M/$Y";
        $lastRecord = $this->ReturnOrder->find('first', array('conditions' => array('and' => array("ReturnOrder.return_number regexp" => $testCode)), 'order' => array('ReturnOrder.return_number' => 'DESC')));
        if (!empty($lastRecord)) {
            $current = substr($lastRecord['ReturnOrder']['return_number'], 0, 4);
            $inc_id += $current;
        }
        $inc_id = sprintf("%04d", $inc_id);
        $kode = "$inc_id/NTRO-PRO/$M/$Y";
        return $kode;
    }

}
