<?php

App::uses('AppController', 'Controller');

class MaterialAdditionalReturnsController extends AppController {

    var $name = "MaterialAdditionalReturns";
    var $disabledAction = array(
    );
    var $contain = [
        "Employee" => [
            "Account" => [
                "Biodata",
            ],
        ],
        "MaterialAdditionalReturn" => [
            "Sale"
        ],
        "BranchOffice",
        "VerifyStatus",
        "VerifiedBy" => [
            "Account" => [
                "Biodata",
            ],
        ],
    ];

    function beforeFilter() {
        parent::beforeFilter();
        $this->_setPageInfo("admin_index", "");
        $this->_setPageInfo("admin_add", "");
        $this->_setPageInfo("admin_edit", "");
    }

    function beforeRender() {
        $this->_options();
        parent::beforeRender();
    }

    function _options() {
        $this->set("materialAdditionalMC", ClassRegistry::init("MaterialAdditional")->find("all", array("fields" => array("MaterialAdditional.id", "MaterialAdditional.name", "MaterialAdditional.price"), "conditions" => array("MaterialAdditional.material_additional_category_id" => 1))));
        $this->set("branchOffices", $this->MaterialAdditionalReturn->BranchOffice->find("list", array("fields" => array("BranchOffice.id", "BranchOffice.name"))));
        $this->set("verifyStatuses", $this->MaterialAdditionalReturn->VerifyStatus->find("list", array("fields" => array("VerifyStatus.id", "VerifyStatus.name"))));
        $this->set("materialAdditionalPlastik", ClassRegistry::init("MaterialAdditional")->find("all", array("fields" => array("MaterialAdditional.id", "MaterialAdditional.name", "MaterialAdditional.price", "MaterialAdditional.size"), "conditions" => array("MaterialAdditional.material_additional_category_id" => 2))));
    }

    function admin_edit($id = null) {
        if (!$this->{ Inflector::classify($this->name) }->exists($id)) {
            throw new NotFoundException(__('Data tidak ditemukan'));
        } else {
            if ($this->request->is("post") || $this->request->is("put")) {
//                debug($this->data);
//                die;
                $this->{ Inflector::classify($this->name) }->set($this->data);
                $this->{ Inflector::classify($this->name) }->data[Inflector::classify($this->name)]['id'] = $id;
                if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                    if (!is_null($id)) {
                        $this->{ Inflector::classify($this->name) }->_numberSeperatorRemover();
                        $this->{ Inflector::classify($this->name) }->data['MaterialAdditionalReturn']['verify_status_id'] = 1;
                        $this->{ Inflector::classify($this->name) }->data['MaterialAdditionalReturn']['verified_by_id'] = null;
                        $this->{ Inflector::classify($this->name) }->data['MaterialAdditionalReturn']['verified_datetime'] = null;
                        $this->{ Inflector::classify($this->name) }->data["MaterialAdditionalReturn"]['branch_office_id'] = $this->Session->read("credential.admin.Employee.branch_office_id");
                        $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
                        $this->Session->setFlash(__("Data berhasil diubah"), 'default', array(), 'success');
                        $this->redirect(array('controller' => 'material_additional_per_containers', 'action' => 'admin_index_material_additional_return'));
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
                        "MaterialAdditionalPerContainer" => [
                            "Sale" => [
                                "SaleDetail",
                                "Buyer" => [
                                    "BuyerType"
                                ],
                            ],
                        ],
                        "MaterialAdditionalReturnDetail" => [
                            "MaterialAdditionalMc",
                            'MaterialAdditionalPlastic',
                            "Product" => [
                                "Parent"
                            ]
                        ],
                        "Employee" => [
                            "Account" => [
                                "Biodata"
                            ]
                        ]
                    ],
                    'recursive' => 2
                ));
                $this->data = $rows;
            }
        }
    }

    function admin_return($id = null) {
        if ($this->request->is("post")) {
            $this->{ Inflector::classify($this->name) }->set($this->data);
            if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                $this->{ Inflector::classify($this->name) }->_numberSeperatorRemover();
                $this->{ Inflector::classify($this->name) }->data['MaterialAdditionalReturn']['verify_status_id'] = 1;
                $this->{ Inflector::classify($this->name) }->data["MaterialAdditionalReturn"]['branch_office_id'] = $this->Session->read("credential.admin.Employee.branch_office_id");
                $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
                $this->Session->setFlash(__("Data berhasil disimpan"), 'default', array(), 'success');
                $this->redirect(array('controller' => 'material_additional_per_containers', 'action' => 'admin_index_material_additional_return'));
            } else {
                $this->validationErrors = $this->{ Inflector::classify($this->name) }->validationErrors;
                $this->Session->setFlash(__("Harap mengecek kembali kesalahan dibawah."), 'default', array(), 'danger');
            }
        } else {
            if (!ClassRegistry::init("MaterialAdditionalPerContainer")->exists($id)) {
                throw new NotFoundException(__('Data tidak ditemukan'));
            } else {
                $this->data = ClassRegistry::init("MaterialAdditionalPerContainer")->find("first", [
                    "conditions" => [
                        "MaterialAdditionalPerContainer.id" => $id,
                    ],
                    "contain" => [
                        "Sale" => [
                            "SaleDetail",
                            "Buyer" => [
                                "BuyerType"
                            ],
                        ],
                        "MaterialAdditionalReturn" => [
                            "MaterialAdditionalReturnDetail" => [
                                "MaterialAdditionalMc",
                                'MaterialAdditionalPlastic',
                                "Product" => [
                                    "Parent"
                                ]
                            ]
                        ],
                        "Employee" => [
                            "Account" => [
                                "Biodata"
                            ]
                        ]
                    ]
                ]);
            }
        }
    }

    function admin_change_status_verify() {
        $this->autoRender = false;
        if ($this->request->is("PUT")) {
            $this->MaterialAdditionalReturn->data['MaterialAdditionalReturn']['id'] = $this->request->data['id'];
            $this->MaterialAdditionalReturn->data['MaterialAdditionalReturn']['verify_status_id'] = $this->request->data['status'];
            if ($this->request->data['status'] == '3') {
                $return = ClassRegistry::init("MaterialAdditionalReturn")->find("first", [
                    "conditions" => [
                        "MaterialAdditionalReturn.id" => $this->request->data['id'],
                    ]
                ]);
                $returnDetail = ClassRegistry::init("MaterialAdditionalReturnDetail")->find("all", [
                    "conditions" => [
                        "MaterialAdditionalReturnDetail.material_additional_return_id" => $return['MaterialAdditionalReturn']['id'],
                    ],
                    "contain" => [
                        "MaterialAdditionalMc",
                        "MaterialAdditionalPlastic"
                    ]
                ]);
                foreach ($returnDetail as $k => $details) {
                    $mcUpdate = ClassRegistry::init("MaterialAdditional")->find("first", [
                        "conditions" => [
                            "MaterialAdditional.id" => $details['MaterialAdditionalMc']['id'],
                        ]
                    ]);
                    $updatedMcData = [];
                    $updatedMcData['MaterialAdditional']['id'] = $mcUpdate['MaterialAdditional']['id'];
                    $updatedMcData['MaterialAdditional']['quantity'] = $mcUpdate['MaterialAdditional']['quantity'] + $details['MaterialAdditionalReturnDetail']['quantity_mc'];
                    ClassRegistry::init("MaterialAdditional")->save($updatedMcData);
                    $plasticUpdate = ClassRegistry::init("MaterialAdditional")->find("first", [
                        "conditions" => [
                            "MaterialAdditional.id" => $details['MaterialAdditionalPlastic']['id'],
                        ]
                    ]);
                    $updatePlasticData = [];
                    $updatePlasticData['MaterialAdditional']['id'] = $plasticUpdate['MaterialAdditional']['id'];
                    $updatePlasticData['MaterialAdditional']['quantity'] = $plasticUpdate['MaterialAdditional']['quantity'] + $details['MaterialAdditionalReturnDetail']['quantity_plastic'];
                    ClassRegistry::init("MaterialAdditional")->save($updatePlasticData);
//                    $this->MaterialAdditionalReturn->data['MaterialAdditional']['id'] = $plasticUpdate['MaterialAdditional']['id'];
//                    $this->MaterialAdditionalReturn->data['MaterialAdditional']['quantity'] = $plasticUpdate['MaterialAdditional']['quantity'] + $details['MaterialAdditionalReturnDetail']['quantity_plastic'];
                }
                $this->MaterialAdditionalReturn->data['MaterialAdditionalReturn']['verified_by_id'] = $this->_getEmployeeId();
                $this->MaterialAdditionalReturn->data['MaterialAdditionalReturn']['verified_datetime'] = date("Y-m-d H:i:s");
            } else if ($this->request->data['status'] == '2') {
                $this->MaterialAdditionalReturn->data['MaterialAdditionalReturn']['verified_by_id'] = $this->_getEmployeeId();
                $this->MaterialAdditionalReturn->data['MaterialAdditionalReturn']['verified_datetime'] = date("Y-m-d H:i:s");
            } else {
                $this->MaterialAdditionalReturn->data['MaterialAdditionalReturn']['verified_by_id'] = null;
                $this->MaterialAdditionalReturn->data['MaterialAdditionalReturn']['verified_datetime'] = null;
            }
            $this->MaterialAdditionalReturn->saveAll();
            $data = $this->MaterialAdditionalReturn->find("first", array("conditions" => array("MaterialAdditionalReturn.id" => $this->request->data['id']), "recursive" => 1));
            echo json_encode($this->_generateStatusCode(207, null, array("status_label" => $data['VerifyStatus']['name'])));
        } else {
            echo json_encode($this->_generateStatusCode(400));
        }
    }

}
