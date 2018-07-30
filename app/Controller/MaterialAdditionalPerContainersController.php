<?php

App::uses('AppController', 'Controller');

class MaterialAdditionalPerContainersController extends AppController {

    var $name = "MaterialAdditionalPerContainers";
    var $disabledAction = array(
    );
    var $contain = [
        "Employee" => [
            "Account" => [
                "Biodata",
            ],
        ],
        "VerifiedBy" => [
            "Account" => [
                "Biodata",
            ],
        ],
        "Sale" => [
            "SaleDetail",
            "Buyer" => [
                "BuyerType"
            ],
        ],
        "MaterialAdditionalPerContainerDetail"=>[
            "MaterialAdditionalMc",
            'MaterialAdditionalPlastic'
        ],
        "VerifyStatus",
        "BranchOffice",
    ];

    function beforeFilter() {
        parent::beforeFilter();
        $this->_setPageInfo("admin_index", "");
        $this->_setPageInfo("admin_add", "");
        $this->_setPageInfo("admin_edit", "");
    }

    function admin_index() {
        $this->_activePrint(func_get_args(), "data_material_pembantu_per_container");
        $this->conds = [
            "MaterialAdditionalPerContainer.verify_status_id" => 1,
        ];
        parent::admin_index();
    }

    function admin_add() {
        if ($this->request->is("post")) {
            $this->{ Inflector::classify($this->name) }->set($this->data);
            if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                $this->{ Inflector::classify($this->name) }->data["MaterialAdditionalPerContainer"]['employee_id'] = $this->Session->read("credential.admin.Employee.id");
                $this->{ Inflector::classify($this->name) }->data["MaterialAdditionalPerContainer"]['branch_office_id'] = $this->stnAdmin->getBranchId();
                $this->{ Inflector::classify($this->name) }->data['MaterialAdditionalPerContainer']['verify_status_id'] = 1;
                $this->{ Inflector::classify($this->name) }->data['MaterialAdditionalPerContainer']['gudang_status_id'] = 1;
                $this->{ Inflector::classify($this->name) }->_numberSeperatorRemover();
                $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
                $this->Session->setFlash(__("Data berhasil disimpan"), 'default', array(), 'success');
                $this->redirect(array('action' => 'admin_material_additional_per_po', "controller" => "sales"));
            } else {
                $this->validationErrors = $this->{ Inflector::classify($this->name) }->validationErrors;
                $this->Session->setFlash(__("Harap mengecek kembali kesalahan dibawah."), 'default', array(), 'danger');
            }
        }
    }

    function admin_print_material_additional_container($id = null) {
        $this->_activePrint(["print"], "report_packaging_daily", "print_plain");
        $rows = $this->{ Inflector::classify($this->name) }->find('all', array(
            'conditions' => array(
                Inflector::classify($this->name) . '.id ' => $id,
            ),
            'contain' => [
                "Sale" => [
                    "Buyer"
                ],
                "MaterialAdditionalPerContainerDetail" => [
                    "MaterialAdditional" => [
                    ]
                ]
            ],
        ));

        $this->data = $rows;
        $data = array(
            'title' => 'Laporan Pembungkusan Ikan Harian',
            'rows' => $rows,
        );
        $this->set(compact('data'));
    }

    function beforeRender() {
        $this->_options();
        parent::beforeRender();
    }

    function _options() {
        $this->set("sales", ClassRegistry::init("Sale")->find("list", array("fields" => array("Sale.id", "Sale.po_number"))));
        $this->set("materialAdditionalMC", ClassRegistry::init("MaterialAdditional")->find("all", array("fields" => array("MaterialAdditional.id", "MaterialAdditional.name", "MaterialAdditional.size", "MaterialAdditional.price"), "conditions" => array("MaterialAdditional.material_additional_category_id" => 1))));
        $this->set("branchOffices", $this->MaterialAdditionalPerContainer->BranchOffice->find("list", array("fields" => array("BranchOffice.id", "BranchOffice.name"))));
        $this->set("verifyStatuses", $this->MaterialAdditionalPerContainer->VerifyStatus->find("list", array("fields" => array("VerifyStatus.id", "VerifyStatus.name"))));
        $this->set("materialAdditionalPlastik", ClassRegistry::init("MaterialAdditional")->find("all", array("fields" => array("MaterialAdditional.id", "MaterialAdditional.name", "MaterialAdditional.size", "MaterialAdditional.price", "MaterialAdditional.size"), "conditions" => array("MaterialAdditional.material_additional_category_id" => [2,5]))));
        $this->set("products", $this->MaterialAdditionalPerContainer->MaterialAdditionalPerContainerDetail->Product->find("all", [
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
    }

    function generateNumber() {
        $inc_id = 1;
        $Y = date('Y');
        $M = romanic_number(date('n'));
        $testCode = "[0-9]{4}/MPPC-PRO/$M/$Y";
        $lastRecord = $this->MaterialAdditionalPerContainer->find('first', array('conditions' => array('and' => array("MaterialAdditionalPerContainer.no_container regexp" => $testCode)), 'order' => array('MaterialAdditionalPerContainer.no_container' => 'DESC')));
        if (!empty($lastRecord)) {
            $current = substr($lastRecord['MaterialAdditionalPerContainer']['no_container'], 0, 4);
            $inc_id += $current;
        }
        $inc_id = sprintf("%04d", $inc_id);
        $kode = "$inc_id/MPPC-PRO/$M/$Y";
        return $kode;
    }

    function admin_print_material_additional($id = null) {
        $this->_activePrint(["print"], "print_material_additional", "print_tanpa_kop");
        $rows = $this->{ Inflector::classify($this->name) }->find('first', array(
            'conditions' => array(
                Inflector::classify($this->name) . '.id' => $id,
            ),
            'contain' => [
                "Employee" => [
                    "Account" => [
                        "Biodata" => [
                        ],
                    ],
                ],
                "Sale",
                "MaterialAdditionalPerContainerDetail" => [
                    "MaterialAdditionalMc" => [
                        "MaterialAdditionalUnit"
                    ],
                    "MaterialAdditionalPlastic" => [
                        "MaterialAdditionalUnit"
                    ],
                ]
            ],
        ));
        $this->data = $rows;
        $data = array(
            'title' => 'BIAYA KEMASAN PER CONTAINER',
            'rows' => $rows,
        );
        $this->set(compact('data'));
    }

    function get_data_po_number($id = null) {
        $this->autoRender = false;
        if ($this->MaterialAdditionalPerContainer->exists($id)) {
            if ($this->request->is("GET")) {
                $data = $this->MaterialAdditionalPerContainer->find("first", [
                    "conditions" => [
                        "Sale.id" => $id
                    ],
                    "contain" => [
                        "Sale"
                    ]
                ]);
                echo json_encode($data);
            } else {
                echo json_encode($this->_generateStatusCode(400));
            }
        } else {
            echo json_encode($this->_generateStatusCode(401));
        }
    }

    function admin_view_data_per_po($id = null) {
        $this->autoRender = false;
        $data = $this->MaterialAdditionalPerContainer->find("first", [
            "conditions" => [
                "MaterialAdditionalPerContainer.sale_id" => $id
            ],
            "contain" => [
                "Sale" => [
                    "Buyer"
                ],
                "MaterialAdditionalPerContainerDetail" => [
                    "Product" => [
                        "Parent"
                    ],
                    "MaterialAdditionalMc" => [
                        "MaterialAdditionalUnit"
                    ],
                    "MaterialAdditionalPlastic" => [
                        "MaterialAdditionalUnit"
                    ],
                ]
            ]
        ]);

        if (!empty($data)) {
            echo json_encode($data);
        } else {
            echo json_encode($this->_generateStatusCode(401));
        }
    }

    function admin_change_status_verify() {
        $this->autoRender = false;
        if ($this->request->is("PUT")) {
            $this->MaterialAdditionalPerContainer->data['MaterialAdditionalPerContainer']['id'] = $this->request->data['id'];
            $this->MaterialAdditionalPerContainer->data['MaterialAdditionalPerContainer']['verify_status_id'] = $this->request->data['status'];
            if ($this->request->data['status'] == '3') {
                $this->MaterialAdditionalPerContainer->data['MaterialAdditionalPerContainer']['verified_by_id'] = $this->_getEmployeeId();
                $this->MaterialAdditionalPerContainer->data['MaterialAdditionalPerContainer']['top_verified_datetime'] = date("Y-m-d H:i:s");
            } else if ($this->request->data['status'] == '2') {
                $this->MaterialAdditionalPerContainer->data['MaterialAdditionalPerContainer']['verified_by_id'] = $this->_getEmployeeId();
                $this->MaterialAdditionalPerContainer->data['MaterialAdditionalPerContainer']['top_verified_datetime'] = date("Y-m-d H:i:s");
            } else {
                $this->MaterialAdditionalPerContainer->data['MaterialAdditionalPerContainer']['verified_by_id'] = null;
                $this->MaterialAdditionalPerContainer->data['MaterialAdditionalPerContainer']['top_verified_datetime'] = null;
            }
            $this->MaterialAdditionalPerContainer->saveAll();
            $data = $this->MaterialAdditionalPerContainer->find("first", array("conditions" => array("MaterialAdditionalPerContainer.id" => $this->request->data['id']), "recursive" => 1));
            echo json_encode($this->_generateStatusCode(207, null, array("status_label" => $data['VerifyStatus']['name'])));
        } else {
            echo json_encode($this->_generateStatusCode(400));
        }
    }

    function admin_change_status_gudang() {
        $this->autoRender = false;
        if ($this->request->is("PUT")) {
            $this->MaterialAdditionalPerContainer->data['MaterialAdditionalPerContainer']['id'] = $this->request->data['id'];
            $this->MaterialAdditionalPerContainer->data['MaterialAdditionalPerContainer']['gudang_status_id'] = $this->request->data['status'];
            $this->MaterialAdditionalPerContainer->saveAll();
            $data = $this->MaterialAdditionalPerContainer->find("first", array("conditions" => array("MaterialAdditionalPerContainer.id" => $this->request->data['id']), "recursive" => 2));
            echo json_encode($this->_generateStatusCode(207, null, array("status_label" => $data['VerifyStatus']['name'])));
        } else {
            echo json_encode($this->_generateStatusCode(400));
        }
    }

    function admin_gudang() {
        $this->_activePrint(func_get_args(), "data_permintaan_material_pembantu_per_po");
        $this->_setPeriodeLaporanDate("awal_Sale_created", "akhir_Sale_created");
        $this->contain = [
            "Sale" => [
                "SaleDetail",
                "Buyer" => [
                    "BuyerType"
                ],
            ],
            "MaterialAdditionalPerContainerDetail"=>[
                "MaterialAdditionalMc",
                'MaterialAdditionalPlastic'
            ],
            "VerifyStatus",
            "BranchOffice",
            "Employee" => [
                "Account" => [
                    "Biodata"
                ]
            ]
        ];
        $this->conds = [
            "Sale.branch_office_id" => $this->stnAdmin->roleBranchId(),
            "NOT"=>[
                "Sale.verify_status_id" => 2,
            ]
        ];
        $this->order = "Sale.created desc";
        
        parent::admin_index();
    }

    function admin_index_material_additional_return() {
        $this->_activePrint(func_get_args(), "data_pengembalian_material_pembantu");
        $this->_setPeriodeLaporanDate("awal_Sale_created", "akhir_Sale_created");
        $this->contain = [
            "Sale" => [
                "SaleDetail",
                "Buyer" => [
                    "BuyerType"
                ],
            ],
            "MaterialAdditionalPerContainerDetail" => [
                "Product" => [
                    "Parent"
                ],
                "MaterialAdditionalMc",
                'MaterialAdditionalPlastic'
            ],
            "VerifyStatus",
            "BranchOffice",
            "Employee" => [
                "Account" => [
                    "Biodata"
                ]
            ],
            "MaterialAdditionalReturn" => [
                "VerifyStatus",
                "Employee" => [
                    "Account" => [
                        "Biodata"
                    ]
                ]
            ]
        ];
        $this->conds = [
            "Sale.branch_office_id" => $this->stnAdmin->roleBranchId(),
//            "Sale.shipment_status" => 1,
            "MaterialAdditionalPerContainer.verify_status_id" => 3
        ];
        $this->order = "MaterialAdditionalReturn.created desc";
        parent::admin_index();
    }

}
