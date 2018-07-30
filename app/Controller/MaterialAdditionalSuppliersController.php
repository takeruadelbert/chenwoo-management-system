<?php

App::uses('AppController', 'Controller');

class MaterialAdditionalSuppliersController extends AppController {

    var $name = "MaterialAdditionalSuppliers";
    var $disabledAction = array(
    );
    var $contain = [
        "City",
        "Country",
        "State"
    ];

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

    function admin_index() {
        $this->_activePrint(func_get_args(), "data_supplier_material_pembantu");
        parent::admin_index();
    }

    function admin_add() {
        if ($this->request->is("post")) {
            $this->{ Inflector::classify($this->name) }->set($this->data);
            if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                $initial = $this->data['MaterialAdditionalSupplier']['initial'];
                $this->MaterialAdditionalSupplier->data['MaterialAdditionalSupplier']['id_supplier'] = $this->generateIDSupplier($initial);
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
                        "MaterialAdditionalSupplierBank"
                    ],
                    'recursive' => 2
                ));
                $this->countryId = $rows["MaterialAdditionalSupplier"]["country_id"];
                $this->stateId = $rows["MaterialAdditionalSupplier"]["state_id"];
                $this->cpCountryId = $rows["MaterialAdditionalSupplier"]["cp_country_id"];
                $this->cpStateId = $rows["MaterialAdditionalSupplier"]["cp_state_id"];
                $this->data = $rows;
            }
        }
    }

    function admin_view($id = null) {
        if (!$this->{ Inflector::classify($this->name) }->exists($id)) {
            throw new NotFoundException(__('Data Not Found'));
        } else {
            $this->{ Inflector::classify($this->name) }->id = $id;
            $this->{ Inflector::classify($this->name) }->data['Supplier']['id'] = $id;
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
                    "MaterialAdditionalSupplierBank"
                ],
            ));
            $this->countryId = $rows["MaterialAdditionalSupplier"]["country_id"];
            $this->stateId = $rows["MaterialAdditionalSupplier"]["state_id"];
            $this->cpCountryId = $rows["MaterialAdditionalSupplier"]["cp_country_id"];
            $this->cpStateId = $rows["MaterialAdditionalSupplier"]["cp_state_id"];
            $this->data = $rows;
        }
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

    function generateIDSupplier($initial) {
        $code = "";
        $id = "";
        $dataSupplier = $this->MaterialAdditionalSupplier->find("first", [
            "order" => "MaterialAdditionalSupplier.id DESC"
        ]);
        if (!empty($dataSupplier)) {
            $id = sprintf("%03d", $dataSupplier['MaterialAdditionalSupplier']['id'] + 1);
        } else {
            $id = sprintf("%03d", 1);
        }
        $code = $initial . "-" . $id;
        return $code;
    }

}
