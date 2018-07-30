<?php

App::uses('AppController', 'Controller');

class CustomersController extends AppController {

    var $name = "Customers";
    var $disabledAction = array(
    );
    var $contain = [
        "Gender"
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
    
    function view_data_customer($id = null) {
        if($this->Customer->exists($id)) {
            $this->autoRender = false;
            if($this->request->is("GET")) {
                $data = $this->Customer->find("first",["conditions" => ["Customer.id" => $id]]);
                return json_encode($data);
            } else {
                return json_encode($this->_generateStatusCode(400));
            }
        } else {
            throw new NotFoundException(__("Data Not Found"));
        }
    }
    
    function _options() {
        $this->set("genders", $this->Customer->Gender->find("list",["Customer.id", "Customer.name"]));
    }
    
    function admin_list() {
        $this->autoRender = false;
        $conds = [];
        if (isset($this->request->query['q'])) {
            $q = $this->request->query['q'];
            $conds[] = array(
                "or" => array(
                    "Customer.first_name like" => "%$q%",
                    "Customer.last_name like" => "%$q%",
            ));
        }

        $suggestions = ClassRegistry::init("Customer")->find("all", array(
            "conditions" => $conds,
            "limit"=>10,
        ));
        $result = [];
        foreach ($suggestions as $item) {
            if (!empty($item)) {
                $result[] = [
                    "id" => @$item['Customer']['id'],
                    "full_name" => @$item['Customer']['full_name'],
                    "address" => @$item['Customer']['address'],
                    "location" => @$item['Customer']['city'] . ", " . @$item['Customer']['state'] . ", " . @$item['Customer']['country'],
                    "phone" => @$item['Customer']['phone'],
                    "handphone" => @$item['Customer']['handphone'],
                    "email" => @$item['Customer']['email']
                ];
            }
        }
        echo json_encode($result);
    }
}