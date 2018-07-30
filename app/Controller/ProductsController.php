<?php

App::uses('AppController', 'Controller');

class ProductsController extends AppController {

    var $name = "Products";
    var $disabledAction = array(
    );
    var $contain = [
        "ProductCategory",
        "ProductUnit",
        "Parent",
        "BranchOffice"
    ];

    function beforeFilter() {
        parent::beforeFilter();
        $this->_setPageInfo("admin_index", "");
        $this->_setPageInfo("admin_add", "");
        $this->_setPageInfo("admin_edit", "");
    }

    function admin_index() {
        $this->_activePrint(func_get_args(), "data_manajemen_produk");
        $this->order="Parent.name asc,Product.name asc";
        parent::admin_index();
    }

    function admin_add() {
        if ($this->request->is("post")) {
            $this->{ Inflector::classify($this->name) }->set($this->data);
            if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                $this->{ Inflector::classify($this->name) }->_numberSeperatorRemover();
                $this->{ Inflector::classify($this->name) }->data['Product']['branch_office_id'] = $this->stnAdmin->getBranchId();
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
                    $this->{ Inflector::classify($this->name) }->_numberSeperatorRemover();
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

    function view_data_product($id = null) {
        $this->autoRender = false;
        if ($this->Product->exists($id)) {
            if ($this->request->is("GET")) {
                $data = $this->Product->find("first", [
                    "conditions" => [
                        "Product.id" => $id
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

    function admin_stock() {
        $this->_activePrint(func_get_args(), "data_stok_produksi");
        $this->conds = [
            "NOT" => [
                "Product.parent_id" => null,
            ],
        ];
        $this->contain = [
            "Parent",
            "ProductUnit",
            "BranchOffice"
        ];
        $this->Product->virtualFields = [
            "stock" => sprintf($this->Product->vfRemainingStock, $this->stnAdmin->getBranchId()),
        ];
        parent::admin_index();
    }

    function beforeRender() {
        $this->_options();
        parent::beforeRender();
    }

    function _options() {
        $this->set("productUnits", ClassRegistry::init("ProductUnit")->find("list", array("fields" => array("ProductUnit.id", "ProductUnit.name"))));
        $parents = $this->Product->find("list", array("fields" => array("Product.id", "Product.name"), "conditions" => array("Product.parent_id" => null)));
        $this->set(compact("parents"));
        $this->set("materials", ClassRegistry::init("Material")->find("list", array("fields" => array("Material.id", "Material.name"))));
        $this->set("branchOffices", ClassRegistry::init("BranchOffice")->find("list", array("fields" => array("BranchOffice.id", "BranchOffice.name"))));
        $this->set("productCategories", $this->Product->ProductCategory->find("list", ["fields" => ["ProductCategory.id", "ProductCategory.name"]]));
    }

    function admin_get_product() {
        $this->autoRender = false;
        $data = $this->{ Inflector::classify($this->name) }->find('all', array("fields" => array("Product.id", "Product.name"), "contain" => array("Child"), "conditions" => ["Product.parent_id is null"]));
        echo json_encode($data);
    }

    function admin_get_detail_product($id = null) {
        $this->autoRender = false;
        $data = $this->{ Inflector::classify($this->name) }->find('first', array("fields" => array(), "conditions" => array("Product.id" => $id), "contain" => array("Child")));
        echo json_encode($data);
    }

    function admin_get_all_detail_product() {
        $this->autoRender = false;
        $data = $this->{ Inflector::classify($this->name) }->find('all', array(
            "fields" => array(
                "Product.name",
            ),
            "conditions" => array(
            ),
            "contain" => array(
                "ProductSize" => [
                    "fields" => [
                        "ProductSize.id",
                        "ProductSize.name",
                        "ProductSize.price",
                    ]
                ]
            )
        ));
        echo json_encode($data);
    }

    function admin_get_price($id = null) {
        $this->autoRender = false;
        $data = $this->{ Inflector::classify($this->name) }->ProductSize->find('first', array("fields" => array("ProductSize.id", "ProductSize.price"), "conditions" => array("ProductSize.id" => $id)), array("contain" => array()));
        echo json_encode($data);
    }

    function _generateProductSizeCode($count = 1) {
        $inc_id = 1 + $count;
        $testCode = "53849094[0-9]{3}";
        $lastRecord = $this->Product->ProductSize->find('first', array('conditions' => array('and' => array("ProductSize.code regexp" => $testCode)), 'order' => array('ProductSize.code' => 'DESC')));
        if (!empty($lastRecord)) {
            $current = substr($lastRecord["ProductSize"]["code"], -3);
            $inc_id+=$current;
        }
        $inc_id = sprintf("%03d", $inc_id);
        $kode = "53849094$inc_id";
        return $kode;
    }

    function admin_get_data_product($id) {
        $this->autoRender = false;
        if (!empty($id)) {
            $data = $this->Product->find("first", [
                "conditions" => [
                    "Product.id" => $id
                ],
                "contain" => [
                    "Parent",
                    "TreatmentDetail" => [
                        "conditions" => [
                            "TreatmentDetail.remaining_weight > 0",
                        ],
                        "Treatment" => [
                            "Freeze" => [
                                "Conversion" => [
                                    "MaterialEntryGradeDetail",
                                ],
                            ],
                        ],
                    ],
                ],
            ]);
            return json_encode($this->_generateStatusCode(206, null, $data));
        } else {
            return json_encode("Data Tidak Ditemukan");
        }
    }

    function admin_list() {
        $this->autoRender = false;
        $conds = [];
        if (isset($this->request->query['q'])) {
            $q = $this->request->query['q'];
            $conds[] = array(
                "or" => array(
                    "Product.name like" => "%$q%",
                    "Parent.name like" => "%$q%",
                ),
                "NOT" => [
                    "Product.parent_id" => NULL
                ]
            );
        }
        $suggestions = ClassRegistry::init("Product")->find("all", array(
            "conditions" => $conds,
            "contain" => array(
                "Parent",
                "ProductUnit",
                "ProductDetail"
            ),
            "limit"=>10,
        ));
        $result = [];
        foreach ($suggestions as $item) {
            $productDetails = [];
            foreach ($item["ProductDetail"] as $productDetail) {
                $productDetails[] = [
                    "label" => $productDetail["batch_number"] . " - " . date("Y/m/d", strtotime($productDetail["production_date"])),
                    "weight" => $productDetail["remaining_weight"],
                    "id" => $productDetail["id"],
                ];
            }
            if (!empty($item)) {
                $result[] = [
                    "id" => @$item['Product']['id'],
                    "name" => @$item['Product']['name'],
                    "product_code" => @$item['Product']['code'],
                    "weight" => @$item['Product']['weight'],
                    "unit" => @$item['ProductUnit']['name'],
                    "label" => $item["Parent"]["name"] . " " . $item["Product"]["name"],
                    "product_detail" => $productDetails,
                ];
            }
        }
        echo json_encode($result);
    }

}
