<?php

App::uses('AppController', 'Controller');

class ProductDetailsController extends AppController {

    var $name = "ProductDetails";
    var $disabledAction = array();
    var $contain = [
        "BranchOffice",
        "Product" => [
            "Parent",
            "ProductUnit"
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
        $this->set("branchOffices", ClassRegistry::init("BranchOffice")->find("list", array("fields" => array("BranchOffice.id", "BranchOffice.name"))));
        $this->ProductDetail->Product->virtualFields["full_label"] = "concat(Parent.name,' - ',Product.name)";
        $this->set("products", $this->ProductDetail->Product->find("list", ["fields" => ["Product.id", "Product.full_label", "Parent.name"], "order" => "Parent.name", "contain" => ["Parent"], "conditions" => ["not" => [ "Product.parent_id" => null]]]));
    }

    function admin_index() {
        $this->_activePrint(func_get_args(), "data_detail_produk");
        $this->_setPeriodeLaporanDate("awal_ProductDetail_production_date", "akhir_ProductDetail_production_date");
        $this->order = "ProductDetail.production_date desc,Product.name asc";
        parent::admin_index();
    }
    
    function admin_add() {
        if ($this->request->is("post")) {
            $this->{ Inflector::classify($this->name) }->set($this->data);
            $this->{ Inflector::classify($this->name) }->data["ProductDetail"]['branch_office_id'] = $this->stnAdmin->getBranchId();
            if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
                $this->Session->setFlash(__("Data berhasil disimpan"), 'default', array(), 'success');
                $this->redirect(array('action' => 'admin_index'));
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

    function view_data_product_detail($id = null) {
        $this->autoRender = false;
        if ($this->ProductDetail->exists($id)) {
            if ($this->request->is("GET")) {
                $data = $this->ProductDetail->find("first", [
                    "conditions" => [
                        "ProductDetail.id" => $id
                    ],
                    "contain" => [
                        "Product" => [
                            "Parent"
                        ]
                    ]
                ]);
                return json_encode($data);
            } else {
                return json_encode($this->_generateProductSizeCode(400));
            }
        } else {
            throw new NotFoundException(__("404 Data Not Found"));
        }
    }

    function admin_fix_pdc() {
        $this->autoRender = false;
        $materialEntryGradeDetails = ClassRegistry::init("MaterialEntryGradeDetail")->find("all", [
            "recursive" => -1,
            "contain" => [
                "MaterialEntryGrade" => [
                    "MaterialEntry" => [
                        "BranchOffice",
                    ],
                ]
            ],
        ]);
        foreach ($materialEntryGradeDetails as $materialEntryGradeDetail) {
            $batchNumber = $materialEntryGradeDetail["MaterialEntryGradeDetail"]["batch_number"];
            $firstB = substr($batchNumber, 0, count($batchNumber) - 3);
            $lastB = substr($batchNumber, -2);
            $lastChecker = substr($firstB, -1);
            if ($lastChecker == "0") {
                $firstB = substr($firstB, 0, count($firstB) - 2) . $materialEntryGradeDetail["MaterialEntryGrade"]["MaterialEntry"]["BranchOffice"]["packer_code"];
            }
            ClassRegistry::init("MaterialEntryGradeDetail")->save([
                "MaterialEntryGradeDetail" => [
                    "id" => $materialEntryGradeDetail["MaterialEntryGradeDetail"]["id"],
                    "batch_number" => $firstB . $lastB,
                ]
            ]);
        }
        $productDetails = $this->ProductDetail->find("all", [
            "contain" => [
                "MaterialEntry" => [
                    "MaterialEntryGrade" => [
                        "MaterialEntryGradeDetail"
                    ]
                ],
            ],
        ]);
        foreach ($productDetails as $productDetail) {
            $this->ProductDetail->saveAll([
                "ProductDetail" => [
                    "id" => $productDetail["ProductDetail"]["id"],
                    "batch_number" => $productDetail["MaterialEntry"]["MaterialEntryGrade"][0]["MaterialEntryGradeDetail"][0]["batch_number"],
                ]
            ]);
        }
    }
    
//    function admin_fix_year(){
//        $this->autoRender=false;
//        $data=$this->ProductDetail->find("all",[
//            
//            "recursive"=>-1,
//        ]);
//        foreach($data as $productDetail){
//            $batchNumber=$productDetail["ProductDetail"]["batch_number"];
//            if (substr($batchNumber,3,1)=="M"){
//                $batchNumber=substr($batchNumber,0,3)."A".substr($batchNumber,4);
//                $this->ProductDetail->id=$productDetail["ProductDetail"]["id"];
//                $this->ProductDetail->save(["batch_number"=>$batchNumber]);
//            }
//        }
//    }

}
