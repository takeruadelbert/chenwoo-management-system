<?php

App::uses('AppController', 'Controller');

class BuyersController extends AppController {

    var $name = "Buyer";
    var $disabledAction = array(
    );
    var $contain = [
        "BuyerType",
        "City",
        "State",
        "Country",
        "Employee" => [
            "Account" => [
                "Biodata"
            ],
            "Department"
        ],
    ];
    var $countryId = false;
    var $stateId = false;
    var $cpCountryId = false;
    var $cpStateId = false;

    function beforeFilter() {
        parent::beforeFilter();
        $this->_setPageInfo("admin_index", "");
        $this->_setPageInfo("admin_add", "");
        $this->_setPageInfo("admin_edit", "");
        $this->_setPageInfo("admin_view", "");
    }

    function admin_index() {
        $this->_activePrint(func_get_args(), "data_pembeli");
        parent::admin_index();
    }

    function admin_add() {
        if ($this->request->is("post")) {
            $this->{ Inflector::classify($this->name) }->set($this->data);
            if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                $initial = $this->data['Buyer']['company_uniq_name'];
                $this->Buyer->data['Buyer']['id_buyer'] = $this->generateIDBuyer($initial);
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
                        $this->{ Inflector::classify($this->name) }->_deleteableHasmany();
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
                $this->countryId = $rows["Buyer"]["country_id"];
                $this->stateId = $rows["Buyer"]["state_id"];
                $this->cpCountryId = $rows["Buyer"]["cp_country_id"];
                $this->cpStateId = $rows["Buyer"]["cp_state_id"];
                $this->data = $rows;
            }
        }
    }

    function admin_view($id = null) {
        if (!$this->{ Inflector::classify($this->name) }->exists($id)) {
            throw new NotFoundException(__('Data Not Found'));
        } else {
            $this->{ Inflector::classify($this->name) }->id = $id;
            $this->{ Inflector::classify($this->name) }->data['Buyer']['id'] = $id;
            $rows = $this->{ Inflector::classify($this->name) }->find("first", array(
                'recursive' => 2,
                'conditions' => array(
                    Inflector::classify($this->name) . ".id" => $id
                ),
                "contain" => [
                    "Employee" => [
                        "Account" => [
                            "Biodata"
                        ],
                        "Department",
                        "Office"
                    ],
                    "BuyerBank"
                ]
            ));
            $this->countryId = $rows["Buyer"]["country_id"];
            $this->stateId = $rows["Buyer"]["state_id"];
            $this->cpCountryId = $rows["Buyer"]["cp_country_id"];
            $this->cpStateId = $rows["Buyer"]["cp_state_id"];
            $this->data = $rows;
        }
    }

    function admin_list() {
        $this->autoRender = false;
        $conds = [];
        if (isset($this->request->query['q'])) {
            $q = $this->request->query['q'];
            $conds[] = array(
                "or" => array(
                    "Buyer.company_name like" => "%$q%",
            ));
        }

        $suggestions = ClassRegistry::init("Buyer")->find("all", array(
            "conditions" => $conds,
            "limit"=>10,
        ));
        $result = [];
        foreach ($suggestions as $item) {
            if (!empty($item)) {
                $result[] = [
                    "id" => @$item['Buyer']['id'],
                    "company_name" => @$item['Buyer']['company_name'],
                    "company_cp" => @$item['Buyer']['contact_person'],
                    "address" => @$item['Buyer']['address'],
                    "location" => @$item['Buyer']['city'] . ", " . @$item['Buyer']['state'] . ", " . @$item['Buyer']['country'],
                    "phone" => @$item['Buyer']['phone'],
                    "handphone" => @$item['Buyer']['handphone'],
                    "email" => @$item['Buyer']['email']
                ];
            }
        }
        echo json_encode($result);
    }

    function beforeRender() {
        $this->_options();
        parent::beforeRender();
    }

    function _options() {
        $this->set("buyerTypes", ClassRegistry::init("BuyerType")->find("list", array("fields" => array("BuyerType.id", "BuyerType.name"))));
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
        if (empty($this->cpCountryId)) {
            $this->set("cpStates", []);
        } else {
            $this->set("cpStates", ClassRegistry::init("State")->find("list", ["fields" => ["State.id", "State.name"], "conditions" => ["State.country_id" => $this->cpCountryId]]));
        }
        if (empty($this->cpStateId)) {
            $this->set("cpCities", []);
        } else {
            $this->set("cpCities", ClassRegistry::init("City")->find("list", ["fields" => ["City.id", "City.name"], "conditions" => ["City.state_id" => $this->cpStateId]]));
        }
    }

    function generateIDBuyer($initial) {
        $code = "";
        $id = "";
        $dataBuyer = $this->Buyer->find("first", [
            "order" => "Buyer.id DESC"
        ]);
        if (!empty($dataBuyer)) {
            $id = sprintf("%03d", $dataBuyer['Buyer']['id'] + 1);
        } else {
            $id = sprintf("%03d", 1);
        }
        $code = $initial . "-" . $id;
        return $code;
    }

}
