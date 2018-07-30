<?php

App::uses('AppController', 'Controller');

class ShipmentAgentsController extends AppController {

    var $name = "ShipmentAgents";
    var $disabledAction = array();
    var $contain = [
        "City",
        "State",
        "Country",
        "ShipmentAgentBank",
        "Employee" => [
            "Account" => [
                "Biodata"
            ],
            "Department",
            "Office"
        ]
    ];
    var $countryId = false;
    var $stateId = false;

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
        $this->set("countries", $this->{ Inflector::classify($this->name) }->Country->find("list", array("fields" => array("Country.id", "Country.name"))));
        if (empty($this->countryId)) {
            $this->set("states", []);
        } else {
            $this->set("states", ClassRegistry::init("State")->find("list", ["fields" => ["State.id", "State.name"], "conditions" => ["State.country_id" => $this->countryId]]));
        }
        if (empty($this->stateId)) {
            $this->set("cities", []);
        } else {
            $this->set("cities", ClassRegistry::init("City")->find("list", ["fields" => ["City.id", "City.name"], "conditions" => ["City.state_id" => $this->stateId]]));
        }
    }

    function admin_index() {
        $this->_activePrint(func_get_args(), "data_agen_pengiriman");
        parent::admin_index();
    }

    function view_data_shipment_agent($id = null) {
        $this->autoRender = false;
        if ($this->ShipmentAgent->exists($id)) {
            if ($this->request->is("GET")) {
                $data = $this->ShipmentAgent->find("first", [
                    "conditions" => [
                        "ShipmentAgent.id" => $id
                    ],
                    "contain" => [
                        "Employee" => [
                            "Account" => [
                                "Biodata"
                            ],
                            "Office",
                            "Department"
                        ],
                        "ShipmentAgentBank",
                        "Country",
                        "City",
                        "State"
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
                    'contain' => [
                        "ShipmentAgentBank",
                        "Country",
                        "City",
                        "State",
                        "Employee" => [
                            "Account" => [
                                "Biodata"
                            ],
                            "Office",
                            "Department"
                        ]
                    ]
                ));
                $this->countryId = $rows["ShipmentAgent"]["country_id"];
                $this->stateId = $rows["ShipmentAgent"]["state_id"];
                $this->data = $rows;
            }
        }
    }

}
