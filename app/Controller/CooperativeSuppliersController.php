<?php

App::uses('AppController', 'Controller');

class CooperativeSuppliersController extends AppController {

    var $name = "CooperativeSuppliers";
    var $disabledAction = array(
    );
    var $contain = [
        "City",
        "State",
        "CooperativeSupplierType",
    ];

    function beforeFilter() {
        parent::beforeFilter();
        $this->_setPageInfo("admin_index", "");
        $this->_setPageInfo("admin_add", "");
        $this->_setPageInfo("admin_edit", "");
    }

    function _options() {
        $this->set("cities", ClassRegistry::init("City")->find("list", ["fields" => ["City.id", "City.name"]]));
        $this->set("states", ClassRegistry::init("State")->find("list", ["fields" => ["State.id", "State.name"],"conditions"=>["State.country_id"=>102]]));
        $this->set("cooperativeSupplierTypes", ClassRegistry::init("CooperativeSupplierType")->find("list", ["fields" => ["CooperativeSupplierType.id", "CooperativeSupplierType.name"]]));
    }

    function beforeRender() {
        $this->_options();
        parent::beforeRender();
    }

    function admin_index() {
        $this->_activePrint(func_get_args(), "data_supplier_koperasi");
        parent::admin_index();
    }

    function view_data_coop_supplier($id = null) {
        $this->autoRender = false;
        if ($this->CooperativeSupplier->exists($id)) {
            if ($this->request->is("GET")) {
                $data = $this->CooperativeSupplier->find("first", ["conditions" => ["CooperativeSupplier.id" => $id]]);
                return json_encode($data);
            } else {
                return json_encode($this->_generateStatusCode(400));
            }
        } else {
            throw new NotFoundException(__("Data Not Found"));
        }
    }

    function admin_list() {
        $this->autoRender = false;
        $conds = [];
        if (isset($this->request->query['q'])) {
            $q = $this->request->query['q'];
            $conds[] = array(
                "or" => array(
                    "CooperativeSupplier.name like" => "%$q%",
                    "CooperativeSupplier.cp_name like" => "%$q%",
            ));
        }

        $suggestions = ClassRegistry::init("CooperativeSupplier")->find("all", array(
            "conditions" => $conds,
            "limit"=>10,
        ));
        $result = [];
        foreach ($suggestions as $item) {
            if (!empty($item)) {
                $result[] = [
                    "id" => @$item['CooperativeSupplier']['id'],
                    "name" => @$item['CooperativeSupplier']['name'],
                    "address" => @$item['CooperativeSupplier']['address'],
                    "location" => @$item['City']['name'] . ", " . @$item['State']['name'],
                    "phone" => @$item['CooperativeSupplier']['phone'],
                    "handphone" => @$item['CooperativeSupplier']['phone_number'],
                    "email" => @$item['CooperativeSupplier']['email'],
                    "cp_name" => @$item['CooperativeSupplier']['cp_name'],
                    "cp_hp" => @$item['CooperativeSupplier']['cp_hp'],
                ];
            }
        }
        echo json_encode($this->_generateStatusCode(206, null, $result));
    }

}
