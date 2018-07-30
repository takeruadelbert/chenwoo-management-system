<?php

App::uses('AppController', 'Controller');

class MaterialAdditionalOpnameStocksController extends AppController {

    var $name = "MaterialAdditionalOpnameStocks";
    var $disabledAction = array(
    );
    var $contain = [
        "MaterialAdditional" => [
            "MaterialAdditionalCategory",
            "MaterialAdditionalUnit"
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
        $this->set("branchOffices", $this->MaterialAdditionalOpnameStock->BranchOffice->find("list", array("fields" => array("BranchOffice.id", "BranchOffice.name"))));
    }

    function admin_index() {
        $this->_activePrint(func_get_args(), "data_stok_opname_material_pembantu");
        $this->_setPeriodeLaporanDate("awal_MaterialAdditionalOpnameStock_opname_date", "akhir_MaterialAdditionalOpnameStock_opname_date");
        parent::admin_index();
    }

    function admin_list() {
        $this->autoRender = false;
        $conds = [];
        if (isset($this->request->query['q'])) {
            $q = $this->request->query['q'];
            $conds[] = array(
                "or" => array(
                    "MaterialAdditionalOpnameStock.opname_stock_number like" => "%$q%"
            ));
        }
        $suggestions = ClassRegistry::init("MaterialAdditionalOpnameStock")->find("all", array(
            "conditions" => $conds,
            "contain" => array(
                "MaterialAdditional" => [
                    "MaterialAdditionalCategory",
                    "MaterialAdditionalUnit"
                ]
            ),
            "limit"=>10,
        ));
        $result = [];
        foreach ($suggestions as $item) {
            if (!empty($item)) {
                $result[] = [
                    "id" => $item['MaterialAdditionalOpnameStock']['id'],
                    "stock_opname_number" => @$item['MaterialAdditionalOpnameStock']['opname_stock_number'],
                    "material_name" => @$item['MaterialAdditional']['name'],
                    "material_size" => @$item['MaterialAdditional']['size'],
                ];
            }
        }
        echo json_encode($result);
    }

    function admin_add() {
        if ($this->request->is("post")) {
            $this->{ Inflector::classify($this->name) }->set($this->data);
            if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                $materialAdditional = ClassRegistry::init("MaterialAdditional")->find("first", [
                    "conditions" => [
                        "MaterialAdditional.id" => $this->data['MaterialAdditionalOpnameStock']['material_additional_id'],
                    ],
                ]);
                $materialAdditionalUpdate = [];
                $materialAdditionalUpdate['MaterialAdditional']['id'] = $this->data['MaterialAdditionalOpnameStock']['material_additional_id'];
                $materialAdditionalUpdate['MaterialAdditional']['quantity'] = $this->data['MaterialAdditionalOpnameStock']['stock_number'];
                $stockDiff = abs($this->data['MaterialAdditionalOpnameStock']['stock_difference']);
                $this->MaterialAdditionalOpnameStock->data['MaterialAdditionalOpnameStock']['employee_id'] = $this->_getEmployeeId();
                $this->{ Inflector::classify($this->name) }->data['MaterialAdditionalOpnameStock']['branch_office_id'] = $this->stnAdmin->getBranchId();
                $this->MaterialAdditionalOpnameStock->data['MaterialAdditionalOpnameStock']['opname_stock_number'] = $this->generate_stock_opname_number();
                $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
                ClassRegistry::init("MaterialAdditional")->save($materialAdditionalUpdate);
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
        $lastRecord = $this->MaterialAdditionalOpnameStock->find("all");
        $inc_id = count($lastRecord) + 1;
        $inc_id = sprintf("%03d", $inc_id);
        $code = "SOMP/$inc_id/$monthInRoman/$currentYear";
        return $code;
    }

    function view_data_opname_stock($id = null) {
        $this->autoRender = false;
        if ($this->MaterialAdditionalOpnameStock->exists($id)) {
            if ($this->request->is("GET")) {
                $data = $this->MaterialAdditionalOpnameStock->find("first", [
                    "conditions" => [
                        "MaterialAdditionalOpnameStock.id" => $id
                    ],
                    "contain" => [
                        "MaterialAdditional" => [
                            "MaterialAdditionalCategory",
                            "MaterialAdditionalUnit"
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
