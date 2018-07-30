<?php

App::uses('AppController', 'Controller');

class PartnersController extends AppController {

    var $name = "Partners";
    var $disabledAction = array(
    );
    var $contain = [
        "City",
        "State",
        "Country",
        "Employee" => [
            "Account" => [
                "Biodata"
            ],
            "Department",
            "Office"
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
        $this->_activePrint(func_get_args(), "data_partner");
        parent::admin_index();
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

    function admin_add() {
        if ($this->request->is("post")) {
            $this->{ Inflector::classify($this->name) }->set($this->data);
            if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                $initial = $this->data['Partner']['initial'];
                $this->Partner->data['Partner']['id_partner'] = $this->generateIDPartner($initial);
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
                    "contain" => [
                        "Employee" => [
                            "Account" => [
                                "Biodata"
                            ],
                            "Department",
                            "Office"
                        ],
                        "PartnerBank"
                    ],
                    'recursive' => 2
                ));
                $this->countryId = $rows["Partner"]["country_id"];
                $this->stateId = $rows["Partner"]["state_id"];
                $this->cpCountryId = $rows["Partner"]["cp_country_id"];
                $this->cpStateId = $rows["Partner"]["cp_state_id"];
                $this->data = $rows;
            }
        }
    }

    function admin_view($id = null) {
        if (!$this->{ Inflector::classify($this->name) }->exists($id)) {
            throw new NotFoundException(__('Data Not Found'));
        } else {
            $this->{ Inflector::classify($this->name) }->id = $id;
            $this->{ Inflector::classify($this->name) }->data['Partner']['id'] = $id;
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
                    "PartnerBank"
                ]
            ));
            $this->countryId = $rows["Partner"]["country_id"];
            $this->stateId = $rows["Partner"]["state_id"];
            $this->cpCountryId = $rows["Partner"]["cp_country_id"];
            $this->cpStateId = $rows["Partner"]["cp_state_id"];
            $this->data = $rows;
        }
    }

    function generateIDPartner($initial) {
        $code = "";
        $id = "";
        $dataPartner = $this->Partner->find("first", [
            "order" => "Partner.id DESC"
        ]);
        if (!empty($dataPartner)) {
            $id = sprintf("%03d", $dataPartner['Partner']['id'] + 1);
        } else {
            $id = sprintf("%03d", 1);
        }
        $code = "Partner" . "-" . $initial . "-" . $id;
        return $code;
    }

    function view_data_partner($id = null) {
        if ($this->Partner->exists($id)) {
            $this->autoRender = false;
            if ($this->request->is("GET")) {
                $data = $this->Partner->find("first", ["conditions" => ["Partner.id" => $id]]);
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
                    "Partner.name like" => "%$q%",
            ));
        }

        $suggestions = ClassRegistry::init("Partner")->find("all", array(
            "conditions" => $conds,
            "contain" => [
                "City",
                "State",
                "Country",
                "CpCity",
                "CpState",
                "CpCountry"
            ],
            "limit"=>10,
        ));
        $result = [];
        foreach ($suggestions as $item) {
            if (!empty($item)) {
                $result[] = [
                    "id" => @$item['Partner']['id'],
                    "name" => @$item['Partner']['name'],
                    "address" => @$item['Partner']['address'],
                    "phone" => @$item['Partner']['phone_number'],
                    "email" => @$item['Partner']['email'],
                    "city" => @$item['City']['name'],
                    "state" => @$item['State']['name'],
                    "country" => @$item['Country']['name'],
                    "postal_code" => @$item['Partner']['postal_code'],
                    "website" => @$item['Partner']['website'],
                    
                    "cp_name" => @$item['Partner']['cp_name'],
                    "cp_address" => @$item['Partner']['cp_address'],
                    "cp_phone" => @$item['Partner']['cp_phone_number'],
                    "cp_email" => @$item['Partner']['cp_email'],
                    "cp_city" => @$item['CpCity']['name'],
                    "cp_state" => @$item['CpState']['name'],
                    "cp_country" => @$item['CpCountry']['name'],
                    "cp_position" => @$item['Partner']['cp_position'],
                ];
            }
        }
        echo json_encode($result);
    }

}
