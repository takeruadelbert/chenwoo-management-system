<?php

App::uses('AppController', 'Controller');

class CooperativeOpnameStocksController extends AppController {

    var $name = "CooperativeOpnameStocks";
    var $disabledAction = array(
    );
    var $contain = [
        "CooperativeGoodList" => [
            "CooperativeGoodListUnit"
        ],
        "Employee" => [
            "Account" => [
                "Biodata"
            ]
        ],
        "BranchOffice"
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
        $this->set("branchOffices", $this->CooperativeOpnameStock->BranchOffice->find("list", array("fields" => array("BranchOffice.id", "BranchOffice.name"))));
    }

    function admin_index() {
        $this->_activePrint(func_get_args(), "data_stok_opname_koperasi");
        parent::admin_index();
    }

    function admin_list() {
        $this->autoRender = false;
        $conds = [];
        if (isset($this->request->query['q'])) {
            $q = $this->request->query['q'];
            $conds[] = array(
                "or" => array(
                    "CooperativeOpnameStock.opname_stock_number like" => "%$q%"
            ));
        }
        $suggestions = ClassRegistry::init("CooperativeOpnameStock")->find("all", array(
            "conditions" => $conds,
            "contain" => array(
                "CooperativeGoodList"
            ),
            "limit"=>10,
        ));
        $result = [];
        foreach ($suggestions as $item) {
            if (!empty($item)) {
                $result[] = [
                    "id" => $item['CooperativeOpnameStock']['id'],
                    "stock_opname_number" => @$item['CooperativeOpnameStock']['opname_stock_number'],
                    "good_name" => @$item['CooperativeGoodList']['name']
                ];
            }
        }
        echo json_encode($result);
    }

    function admin_add() {
        if ($this->request->is("post")) {
            $this->{ Inflector::classify($this->name) }->set($this->data);
            if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                $cooperativeGoodList = ClassRegistry::init("CooperativeGoodList")->find("first", [
                    "conditions" => [
                        "CooperativeGoodList.id" => $this->data['CooperativeOpnameStock']['cooperative_good_list_id'],
                    ],
                ]);
                $cooperativeGoodListUpdate = [];
                $cooperativeGoodListUpdate['CooperativeGoodList']['id'] = $this->data['CooperativeOpnameStock']['cooperative_good_list_id'];
                $cooperativeGoodListUpdate['CooperativeGoodList']['stock_number'] = $this->data['CooperativeOpnameStock']['stock_number'];
                $stockDiff = abs($this->data['CooperativeOpnameStock']['stock_difference']);
                if ($this->data['CooperativeOpnameStock']['stock_difference'] > 0) {
                    $cooperativeGoodListDetail = ClassRegistry::init("CooperativeGoodListDetail")->find("first", [
                        "conditions" => [
                            "CooperativeGoodListDetail.cooperative_good_list_id" => $this->data['CooperativeOpnameStock']['cooperative_good_list_id'],
                        ],
                        "order" => [
                            "CooperativeGoodListDetail.capital_price DESC"
                        ],
                    ]);
                    ClassRegistry::init("CooperativeGoodListDetail")->save([
                        "CooperativeGoodListDetail" => [
                            "id" => $cooperativeGoodListDetail["CooperativeGoodListDetail"]["id"],
                            "stock_number" => $stockDiff + $cooperativeGoodListDetail["CooperativeGoodListDetail"]["stock_number"],
                        ]
                    ]);
                } else if ($this->data['CooperativeOpnameStock']['stock_difference'] < 0) {
                    do {
                        $cooperativeGoodListDetail = ClassRegistry::init("CooperativeGoodListDetail")->find("first", [
                            "conditions" => [
                                "CooperativeGoodListDetail.cooperative_good_list_id" => $this->data['CooperativeOpnameStock']['cooperative_good_list_id'],
                                "CooperativeGoodListDetail.stock_number > 0",
                            ],
                            "order" => [
                                "CooperativeGoodListDetail.capital_price ASC",
                            ],
                        ]);
                        if ($cooperativeGoodListDetail["CooperativeGoodListDetail"]["stock_number"] >= $stockDiff) {
                            $deduction = $stockDiff;
                            $stockDiff = 0;
                        } else {
                            $deduction = $cooperativeGoodListDetail["CooperativeGoodListDetail"]["stock_number"];
                            $stockDiff-=$deduction;
                        }
                        ClassRegistry::init("CooperativeGoodListDetail")->save([
                            "CooperativeGoodListDetail" => [
                                "id" => $cooperativeGoodListDetail["CooperativeGoodListDetail"]["id"],
                                "stock_number" => $cooperativeGoodListDetail["CooperativeGoodListDetail"]["stock_number"] - $deduction,
                            ]
                        ]);
                    } while ($stockDiff > 0);
                }
                $this->CooperativeOpnameStock->data['CooperativeOpnameStock']['employee_id'] = $this->_getEmployeeId();
                $this->{ Inflector::classify($this->name) }->data['CooperativeOpnameStock']['branch_office_id'] = $this->stnAdmin->getBranchId();
                $this->CooperativeOpnameStock->data['CooperativeOpnameStock']['opname_stock_number'] = $this->generate_stock_opname_number();
                $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
                ClassRegistry::init("CooperativeGoodList")->save($cooperativeGoodListUpdate);
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
        $lastRecord = $this->CooperativeOpnameStock->find("all");
        $inc_id = count($lastRecord) + 1;
        $inc_id = sprintf("%03d", $inc_id);
        $code = "STOP/$inc_id/$monthInRoman/$currentYear";
        return $code;
    }

    function view_data_opname_stock($id = null) {
        $this->autoRender = false;
        if ($this->CooperativeOpnameStock->exists($id)) {
            if ($this->request->is("GET")) {
                $data = $this->CooperativeOpnameStock->find("first", [
                    "conditions" => [
                        "CooperativeOpnameStock.id" => $id
                    ],
                    "contain" => [
                        "CooperativeGoodList" => [
                            "GoodType",
                            "CooperativeGoodListUnit"
                        ]
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
