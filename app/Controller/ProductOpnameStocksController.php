<?php

App::uses('AppController', 'Controller');

class ProductOpnameStocksController extends AppController {

    var $name = "ProductOpnameStocks";
    var $disabledAction = array(
    );
    var $contain = [
        "Product" => [
            "Parent",
            "ProductUnit",
        ],
        "Employee" => [
            "Account" => [
                "Biodata"
            ]
        ],
        "BranchOffice",
        "ProductDetail"
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
        $this->set("branchOffices", $this->ProductOpnameStock->BranchOffice->find("list", array("fields" => array("BranchOffice.id", "BranchOffice.name"))));
    }

    function admin_index() {
        $this->_activePrint(func_get_args(), "data_stok_opname_produk");
        $this->_setPeriodeLaporanDate("awal_ProductOpnameStock_opname_date", "akhir_ProductOpnameStock_opname_date");
        parent::admin_index();
    }

    function admin_list() {
        $this->autoRender = false;
        $conds = [];
        if (isset($this->request->query['q'])) {
            $q = $this->request->query['q'];
            $conds[] = array(
                "or" => array(
                    "ProductOpnameStock.opname_stock_number like" => "%$q%"
            ));
        }
        $suggestions = ClassRegistry::init("ProductOpnameStock")->find("all", array(
            "conditions" => $conds,
            "contain" => array(
                "Product" => [
                    "Parent"
                ]
            ),
            "limit"=>10,
        ));
        $result = [];
        foreach ($suggestions as $item) {
            if (!empty($item)) {
                $result[] = [
                    "id" => $item['ProductOpnameStock']['id'],
                    "stock_opname_number" => @$item['ProductOpnameStock']['opname_stock_number'],
                    "product_name" => @$item['Product']['name'],
                    "parent_name" => @$item['Product']['Parent']['name']
                ];
            }
        }
        echo json_encode($result);
    }

    function admin_add() {
        if ($this->request->is("post")) {
            $this->{ Inflector::classify($this->name) }->set($this->data);
            if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                $productDetail = ClassRegistry::init("ProductDetail")->find("first", [
                    "conditions" => [
                        "ProductDetail.id" => $this->data['ProductOpnameStock']['product_detail_id'],
                    ],
                ]);
                $productDetailUpdate = [];
                $productDetailUpdate['ProductDetail']['id'] = $this->data['ProductOpnameStock']['product_detail_id'];
                $productDetailUpdate['ProductDetail']['remaining_weight'] = $this->data['ProductOpnameStock']['stock_number'];
                $stockDiff = abs($this->data['ProductOpnameStock']['stock_difference']);
                $this->ProductOpnameStock->data['ProductOpnameStock']['employee_id'] = $this->_getEmployeeId();
                $this->{ Inflector::classify($this->name) }->data['ProductOpnameStock']['branch_office_id'] = $this->stnAdmin->getBranchId();
                $this->ProductOpnameStock->data['ProductOpnameStock']['opname_stock_number'] = $this->generate_stock_opname_number();
                $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
                ClassRegistry::init("ProductDetail")->save($productDetailUpdate);
                $this->Session->setFlash(__("Data berhasil disimpan"), 'default', array(), 'success');
                $this->redirect(array('action' => 'admin_index'));
            } else {
                $this->validationErrors = $this->{ Inflector::classify($this->name) }->validationErrors;
                $this->Session->setFlash(__("Harap mengecek kembali kesalahan dibawah."), 'default', array(), 'danger');
            }
        }
    }

    function generate_stock_opname_number() {
        $inc_id = 1;
        $currentYear = date("Y");
        $currentMonth = date("n");
        $monthInRoman = romanic_number($currentMonth);
        $lastRecord = $this->ProductOpnameStock->find("all");
        $inc_id = count($lastRecord) + 1;
        $inc_id = sprintf("%03d", $inc_id);
        $code = "SO-Produk/$inc_id/$monthInRoman/$currentYear";
        return $code;
    }

    function view_data_opname_stock($id = null) {
        $this->autoRender = false;
        if ($this->ProductOpnameStock->exists($id)) {
            if ($this->request->is("GET")) {
                $data = $this->ProductOpnameStock->find("first", [
                    "conditions" => [
                        "ProductOpnameStock.id" => $id
                    ],
                    "contain" => [
                        "Product" => [
                            "Parent",
                            "ProductUnit"
                        ],
                        "ProductDetail"
                    ]
                ]);
                return json_encode($data);
            } else {
                return json_encode($this->_generateStatusCode(400));
            }
        } else {
            throw new NotFoundException(__("404 Data Not Found"));
        }
    }

}
