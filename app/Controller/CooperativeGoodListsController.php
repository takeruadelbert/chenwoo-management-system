<?php

App::uses('AppController', 'Controller');

class CooperativeGoodListsController extends AppController {

    var $name = "CooperativeGoodLists";
    var $disabledAction = array(
    );
    var $contain = [
        "GoodType",
        "BranchOffice",
        "CooperativeGoodListUnit"
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

    function admin_index() {
        $this->_activePrint(func_get_args(), "data_barang_koperasi");
        parent::admin_index();
    }

    function _options() {
        $goodTypes = $this->{ Inflector::classify($this->name) }->GoodType->find("list", array("fields" => array("GoodType.id", "GoodType.name", "Parent.name"), "contain" => ['Parent']));
        $goodTypes['Kategori Utama'] = $goodTypes[0];
        unset($goodTypes[0]);
        $this->set(compact("goodTypes"));
        $this->set("branchOffices", $this->CooperativeGoodList->BranchOffice->find("list", array("fields" => array("BranchOffice.id", "BranchOffice.name"))));
        $this->set("cooperativeGoodListUnits", $this->CooperativeGoodList->CooperativeGoodListUnit->find("list", array("fields" => array("CooperativeGoodListUnit.id", "CooperativeGoodListUnit.name"))));
    }

    function view_data_good($id = null) {
        if ($this->CooperativeGoodList->exists($id)) {
            $this->autoRender = false;
            if ($this->request->is("GET")) {
                $data = $this->CooperativeGoodList->find("first", [
                    "conditions" => [
                        "CooperativeGoodList.id" => $id
                    ],
                    "contain" => [
                        "GoodType"
                    ]
                ]);
                return json_encode($data);
            } else {
                return json_encode($this->_generateStatusCode(400));
            }
        } else {
            throw new NotFoundException(__("Data Not Found"));
        }
    }

    function admin_stock_report() {
        $this->_activePrint(func_get_args(), "laporan_stok_barang_koperasi");
        parent::admin_index();
    }

    function admin_add() {
        if ($this->request->is("post")) {
            $this->{ Inflector::classify($this->name) }->set($this->data);
            if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                $this->CooperativeGoodList->_numberSeperatorRemover();
                $this->{ Inflector::classify($this->name) }->data["CooperativeGoodList"]['code'] = $this->generateGoodListNumber();
                $capitalPrice = $this->CooperativeGoodList->data['CooperativeGoodList']['capital_price'];
                $stockNumber = $this->CooperativeGoodList->data['CooperativeGoodList']['stock_number'];
                $this->{ Inflector::classify($this->name) }->data['CooperativeGoodList']['branch_office_id'] = $this->stnAdmin->getBranchId();

                $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));

                //update cooperative goodlist detail
                $toUpdateCooperativeGoodListDetail = [
                    "CooperativeGoodListDetail" => [
                        "cooperative_good_list_id" => $this->CooperativeGoodList->getLastInsertID(),
                        'capital_price' => $capitalPrice,
                        'stock_number' => $stockNumber,
                    ]
                ];
                ClassRegistry::init("CooperativeGoodListDetail")->saveAll($toUpdateCooperativeGoodListDetail);
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
                $this->CooperativeGoodList->_numberSeperatorRemover();
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

    function admin_list() {
        $this->autoRender = false;
        $this->response->type("json");
        $conds = [];
        if (isset($this->request->query['q'])) {
            $q = $this->request->query['q'];
            $conds[] = array(
                "or" => array(
                    "CooperativeGoodList.name like" => "%$q%",
                    "CooperativeGoodList.code like" => "%$q%",
                    "CooperativeGoodList.barcode like" => "%$q%",
            ));
        }
        $suggestions = ClassRegistry::init("CooperativeGoodList")->find("all", array(
            "conditions" => $conds,
            "contain" => array(
                "GoodType",
                "CooperativeGoodListUnit"
            ),
            "limit"=>10,
        ));
        $result = [];
        foreach ($suggestions as $item) {
            if (!empty($item)) {
                $result[] = [
                    "id" => @$item['CooperativeGoodList']['id'],
                    "name" => @$item['CooperativeGoodList']['name'],
                    "category_type" => @$item['GoodType']['name'],
                    "good_code" => @$item['CooperativeGoodList']['code'],
                    "barcode" => @$item['CooperativeGoodList']['barcode'],
                    "stock_number" => @$item['CooperativeGoodList']['stock_number'],
                    "price" => @$item['CooperativeGoodList']['sale_price'],
                    "capital_price" => @$item['CooperativeGoodList']['capital_price'],
                    "unit" => @$item['CooperativeGoodListUnit']['name']
                ];
            }
        }
        echo json_encode($result);
    }

    function generateGoodListNumber() {
        $inc_id = 1;
        $testCode = "ST-[0-9]{4}";
        $lastRecord = $this->CooperativeGoodList->find('first', array('conditions' => array('and' => array("CooperativeGoodList.code regexp" => $testCode)), 'order' => array('CooperativeGoodList.code' => 'DESC')));
        if (!empty($lastRecord)) {
            $current = substr($lastRecord['CooperativeGoodList']['code'], 3, 7);
            $inc_id += $current;
        }
        $inc_id = sprintf("%04d", $inc_id);
        $kode = "ST-$inc_id";
        return $kode;
    }

}
