<?php

App::uses('AppController', 'Controller');

class MaterialAdditionalOutsController extends AppController {

    var $name = "MaterialAdditionalOuts";
    var $disabledAction = array(
    );
    var $contain = [
        "Employee" => [
            "Account" => [
                "Biodata",
            ],
        ],
        "MaterialAdditional" => [
            "MaterialAdditionalUnit",
        ],
    ];

    function beforeFilter() {
        parent::beforeFilter();
        $this->_setPageInfo("admin_index", "");
        $this->_setPageInfo("admin_add", "");
        $this->_setPageInfo("admin_edit", "");
    }

    function admin_index() {
        $this->_activePrint(func_get_args(), "data_pemakaian_material_pembantu");
        $this->_setPeriodeLaporanDate("awal_MaterialAdditionalOut_use_dt", "akhir_MaterialAdditionalOut_use_dt");
        $this->conds = [
            "MaterialAdditionalOut.branch_office_id" => $this->stnAdmin->roleBranchId()
        ];
        parent::admin_index();
    }

    function admin_add() {
        if ($this->request->is("post")) {
            $this->{ Inflector::classify($this->name) }->set($this->data);
            $this->{ Inflector::classify($this->name) }->data["MaterialAdditionalOut"]['employee_id'] = $this->Session->read("credential.admin.Employee.id");
            $this->{ Inflector::classify($this->name) }->data['MaterialAdditionalOut']['branch_office_id'] = $this->Session->read("credential.admin.Employee.branch_office_id");
            if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                //Update Stock
                $this->{ Inflector::classify($this->name) }->data['MaterialAdditionalOut']['quantity'] = ac_number_reverse($this->data['MaterialAdditionalOut']['quantity']);
                $materialAdditionalTemp = ClassRegistry::init("MaterialAdditional")->find("first", [
                    "conditions" => [
                        "MaterialAdditional.id" => $this->data["MaterialAdditionalOut"]['material_additional_id'],
                    ],
                ]);
                $toUpdateMaterialAdditional = [
                    "MaterialAdditional" => [
                        "id" => $this->data["MaterialAdditionalOut"]['material_additional_id'],
                        "quantity" => floatval($materialAdditionalTemp['MaterialAdditional']['quantity'] - $this->data["MaterialAdditionalOut"]['quantity']),
                    ]
                ];
                ClassRegistry::init("MaterialAdditional")->saveAll($toUpdateMaterialAdditional);

                $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
                $this->Session->setFlash(__("Data berhasil disimpan"), 'default', array(), 'success');
                $this->redirect(array('action' => 'admin_index', 'controller' => 'materialAdditionalOuts'));
            } else {
                $this->validationErrors = $this->{ Inflector::classify($this->name) }->validationErrors;
                $this->Session->setFlash(__("Harap mengecek kembali kesalahan dibawah."), 'default', array(), 'danger');
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
                       $this->{ Inflector::classify($this->name) }->data['MaterialAdditionalOut']['quantity'] = ac_number_reverse($this->data['MaterialAdditionalOut']['quantity']);
                        $recentAdditionalOut = ClassRegistry::init("MaterialAdditionalOut")->find("first",[
                            "conditions" => [
                                "MaterialAdditionalOut.id" => $id
                            ]
                        ]);
                        
                        //Update Stock
                        $materialAdditionalTemp = ClassRegistry::init("MaterialAdditional")->find("first", [
                            "conditions" => [
                                "MaterialAdditional.id" => $this->data["MaterialAdditionalOut"]['material_additional_id'],
                            ],
                        ]);
                        $updateMaterial = $this->data["MaterialAdditionalOut"]['material_additional_id'];
                        if($recentAdditionalOut['MaterialAdditionalOut']['material_additional_id']==$updateMaterial){
                            //Jika materialnya sama
                            $toUpdateMaterialAdditional = [
                                "MaterialAdditional" => [
                                    "id" => $this->data["MaterialAdditionalOut"]['material_additional_id'],
                                    "quantity" => floatval($materialAdditionalTemp['MaterialAdditional']['quantity'] + $recentAdditionalOut['MaterialAdditionalOut']['quantity'] - $this->data["MaterialAdditionalOut"]['quantity']),
                                ]
                            ];
                            ClassRegistry::init("MaterialAdditional")->saveAll($toUpdateMaterialAdditional);
                        }else{
                            //Jika material berbeda maka ditambahkan material sebelumnya
                            //lalu kurangkan sesuai hasil update material pada material yang telah diubah
                            $materialAdditionalTempOldId = ClassRegistry::init("MaterialAdditional")->find("first", [
                                "conditions" => [
                                    "MaterialAdditional.id" => $recentAdditionalOut['MaterialAdditionalOut']['material_additional_id'],
                                ],
                            ]);
                            $toUpdateMaterialAdditionalRecent = [
                                "MaterialAdditional" => [
                                    "id" => $recentAdditionalOut['MaterialAdditionalOut']['material_additional_id'],
                                    "quantity" => floatval($materialAdditionalTempOldId['MaterialAdditional']['quantity'] + $recentAdditionalOut['MaterialAdditionalOut']['quantity']),
                                ]
                            ];
                            ClassRegistry::init("MaterialAdditional")->saveAll($toUpdateMaterialAdditionalRecent);
                            $toUpdateMaterialAdditional = [
                                "MaterialAdditional" => [
                                    "id" => $this->data["MaterialAdditionalOut"]['material_additional_id'],
                                    "quantity" => floatval($materialAdditionalTemp['MaterialAdditional']['quantity'] - $this->data["MaterialAdditionalOut"]['quantity']),
                                ]
                            ];
                            ClassRegistry::init("MaterialAdditional")->saveAll($toUpdateMaterialAdditional);
                        }
                        
                        
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

    function beforeRender() {
        $this->_options();
        parent::beforeRender();
    }

    function _options() {
    //$this->set("materialAdditionals", ClassRegistry::init("MaterialAdditional")->find("list", array("fields" => array("MaterialAdditional.id", "MaterialAdditional.name","MaterialAdditionalCategory.name"),"contain"=>"MaterialAdditionalCategory")));
    $dataMaterialAdditionalCategories = ClassRegistry::init("MaterialAdditionalCategory")->find("all", ['order' => 'MaterialAdditionalCategory.name']); 
    $result = [];
    foreach ($dataMaterialAdditionalCategories as $materialAdditionalCategory) {
        $dataMaterialAdditional = ClassRegistry::init("MaterialAdditional")->find("all",[
            "conditions" => [
                "MaterialAdditional.material_additional_category_id" => $materialAdditionalCategory['MaterialAdditionalCategory']['id']
            ]
        ]);

        if(!empty($dataMaterialAdditional)) {
            foreach ($dataMaterialAdditional as $materialAdditional) {
                $result[$materialAdditionalCategory['MaterialAdditionalCategory']['name']][$materialAdditional['MaterialAdditional']['id']] = $materialAdditional['MaterialAdditional']['name'] . " " . $materialAdditional['MaterialAdditional']['size'];
            }
        }
    }
    $this->set("materialAdditionals", $result);
    }

}
