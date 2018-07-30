<?php

App::uses('AppController', 'Controller');

class RequestOrderMaterialAdditionalsController extends AppController {

    var $name = "RequestOrderMaterialAdditionals";
    var $disabledAction = array(
    );
    var $contain = [
        "Employee" => [
            "Account" => [
                "Biodata",
            ],
        ],
        "RequestOrderMaterialAdditionalDetail" => [
            "MaterialAdditional" => [
                "MaterialAdditionalUnit",
            ]
        ],
        "RequestOrderMaterialAdditionalStatus",
        "BranchOffice",
    ];

    function beforeFilter() {
        parent::beforeFilter();
        $this->_setPageInfo("admin_index", "");
        $this->_setPageInfo("admin_add", "");
        $this->_setPageInfo("admin_edit", "");
    }

    function admin_index() {
        $this->_activePrint(func_get_args(), "data_request_order_material_pembantu");
        $this->_setPeriodeLaporanDate("awal_RequestOrderMaterialAdditional_ro_date", "akhir_RequestOrderMaterialAdditional_ro_date");
        parent::admin_index();
    }

    function admin_purchase_order_material_additional() {
        $this->_activePrint(func_get_args(), "data_purchase_order_material_pembantu_ro");
        $this->_setPeriodeLaporanDate("awal_RequestOrderMaterialAdditional_ro_date", "akhir_RequestOrderMaterialAdditional_ro_date");
        $this->contain = [
            "Employee" => [
                "Account" => [
                    "Biodata",
                ],
            ],
            "RequestOrderMaterialAdditionalDetail" => [
                "MaterialAdditional"
            ],
            "RequestOrderMaterialAdditionalStatus",
            "PurchaseOrderMaterialAdditional" => [
                "PurchaseOrderMaterialAdditionalDetail" => [
                    "MaterialAdditional"
                ],
                "PurchaseOrderMaterialAdditionalStatus",
            ],
            "BranchOffice"
        ];
        $this->conds = [
            "RequestOrderMaterialAdditional.branch_office_id" => $this->stnAdmin->roleBranchId(),
            "RequestOrderMaterialAdditional.request_order_material_additional_status_id" => 2,
        ];
        $this->order = "RequestOrderMaterialAdditional.po_status asc,RequestOrderMaterialAdditional.created desc";
        parent::admin_index();
    }

    function admin_validate() {
        $this->_activePrint(func_get_args(), "data_request_order_material_pembantu_validate");
        $this->_setPeriodeLaporanDate("awal_RequestOrderMaterialAdditional_ro_date", "akhir_RequestOrderMaterialAdditional_ro_date");
        $this->conds = [
            "RequestOrderMaterialAdditional.request_order_material_additional_status_id" => 1,
        ];
        parent::admin_index();
    }

    function admin_add() {
        if ($this->request->is("post")) {
            $this->{ Inflector::classify($this->name) }->set($this->data);
            if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
//                $this->{ Inflector::classify($this->name) }->_numberSeperatorRemover();
                $this->{ Inflector::classify($this->name) }->data["RequestOrderMaterialAdditional"]['ro_number'] = $this->generateRONumber();
                $this->{ Inflector::classify($this->name) }->data["RequestOrderMaterialAdditional"]['request_order_material_additional_status_id'] = 1;
                $this->{ Inflector::classify($this->name) }->data["RequestOrderMaterialAdditional"]['employee_id'] = $this->Session->read("credential.admin.Employee.id");
                $this->{ Inflector::classify($this->name) }->data['RequestOrderMaterialAdditional']['branch_office_id'] = $this->stnAdmin->getBranchId();
                foreach ($this->data["RequestOrderMaterialAdditionalDetail"] as $n => $RequestOrderMaterialAdditionalDetail) {
//                    $remaining = (int) str_replace('.', '', $RequestOrderMaterialAdditionalDetail['quantity']);
                    $this->{ Inflector::classify($this->name) }->data["RequestOrderMaterialAdditionalDetail"][$n]["quantity_remaining"] = $RequestOrderMaterialAdditionalDetail['quantity'];
                }
                $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
                $this->Session->setFlash(__("Data berhasil disimpan"), 'default', array(), 'success');
                $this->redirect(array('action' => 'admin_index'));
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
        $this->set("materialAdditional", ClassRegistry::init("MaterialAdditional")->find("all", array("fields" => array("MaterialAdditional.id", "MaterialAdditional.name", "MaterialAdditional.size", "MaterialAdditionalUnit.uniq"), "contain" => ["MaterialAdditionalUnit"])));
        $this->set("branchOffices", $this->RequestOrderMaterialAdditional->BranchOffice->find("list", array("fields" => array("BranchOffice.id", "BranchOffice.name"))));
        $this->set("requestOrderMaterialAdditionalStatuses", $this->RequestOrderMaterialAdditional->RequestOrderMaterialAdditionalStatus->find("list", array("fields" => array("RequestOrderMaterialAdditionalStatus.id", "RequestOrderMaterialAdditionalStatus.name"))));
    }

    function generateRONumber() {
        $inc_id = 1;
        $Y = date('Y');
        $month = romanic_number(date("n"));
        $testCode = "[0-9]{4}/MPRO-GDG/$month/$Y";
        $lastRecord = $this->RequestOrderMaterialAdditional->find('first', array('conditions' => array('and' => array("RequestOrderMaterialAdditional.ro_number regexp" => $testCode)), 'order' => array('RequestOrderMaterialAdditional.ro_number' => 'DESC')));
        if (!empty($lastRecord)) {
            $current = substr($lastRecord['RequestOrderMaterialAdditional']['ro_number'], 0, 4);
            $inc_id += $current;
        }
        $inc_id = sprintf("%04d", $inc_id);
        $kode = "$inc_id/MPRO-GDG/$month/$Y";
        return $kode;
    }

    function admin_print_request_order($id = null) {
        $this->_activePrint(["print"], "print_request_order", "form_izin");
        if ($this->{ Inflector::classify($this->name) }->exists($id)) {
            $rows = $this->{ Inflector::classify($this->name) }->find('first', array(
                'conditions' => array(
                    Inflector::classify($this->name) . '.id' => $id,
                    Inflector::classify($this->name) . '.request_order_material_additional_status_id' => 2,
                ),
                'contain' => [
                    "RequestOrderMaterialAdditionalStatus",
                    "RequestOrderMaterialAdditionalDetail" => [
                        "MaterialAdditional"
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

    function admin_get_data_ro_material_additional($id = null) {
        $this->autoRender = false;
        if ($this->RequestOrderMaterialAdditional->exists($id)) {
            if ($this->request->is("GET")) {
                $data = $this->RequestOrderMaterialAdditional->find("first", [
                    "conditions" => [
                        "RequestOrderMaterialAdditional.id" => $id
                    ],
                    "contain" => [
                        "RequestOrderMaterialAdditionalDetail" => [
                            "MaterialAdditional"
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

    function admin_change_status_verify() {
        $this->autoRender = false;
        if ($this->request->is("PUT")) {
            $this->RequestOrderMaterialAdditional->data['RequestOrderMaterialAdditional']['id'] = $this->request->data['id'];
            $this->RequestOrderMaterialAdditional->data['RequestOrderMaterialAdditional']['request_order_material_additional_status_id'] = $this->request->data['status'];
            if ($this->request->data['status'] !== '1') {
                $this->RequestOrderMaterialAdditional->data['RequestOrderMaterialAdditional']['verified_by_id'] = $this->_getEmployeeId();
                $this->RequestOrderMaterialAdditional->data['RequestOrderMaterialAdditional']['verified_datetime'] = date("Y-m-d H:i:s");
            } else {
                $this->RequestOrderMaterialAdditional->data['RequestOrderMaterialAdditional']['verified_by_id'] = null;
                $this->RequestOrderMaterialAdditional->data['RequestOrderMaterialAdditional']['verified_datetime'] = null;
            }
            $this->RequestOrderMaterialAdditional->saveAll();
            $data = $this->RequestOrderMaterialAdditional->find("first", array("conditions" => array("RequestOrderMaterialAdditional.id" => $this->request->data['id'])));
            echo json_encode($this->_generateStatusCode(207, null, array("status_label" => $data['RequestOrderMaterialAdditionalStatus']['name'])));
        } else {
            echo json_encode($this->_generateStatusCode(400));
        }
    }

}
