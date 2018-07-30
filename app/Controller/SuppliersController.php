<?php

App::uses('AppController', 'Controller');

class SuppliersController extends AppController {

    var $name = "Suppliers";
    var $disabledAction = array(
    );
    var $contain = [
        "SupplierFile" => [
            "AssetFile",
        ],
        "City",
        "State",
        "Country",
        "SupplierType",
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
    }

    function admin_index() {
        $this->_activePrint(func_get_args(), "data_supplier_material");
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
        $this->set("supplierTypes", $this->{ Inflector::classify($this->name) }->SupplierType->find("list", array("fields" => array("SupplierType.id", "SupplierType.name"))));
    }

    function admin_add() {
        if ($this->request->is("post")) {
            $totalExpenses = 0;
            $this->{ Inflector::classify($this->name) }->set($this->data);
            if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                foreach ($this->data['SupplierFile'] as $k => $details) {
                    if (!empty($details['file']['name'])) {
                        App::import("Vendor", "qqUploader");
                        $allowedExt = array("jpg", "jpeg", "png", "pdf", "xls", "xlsx", "doc", "docs");
                        $size = 10 * 1024 * 1024;
                        $uploader = new qqFileUploader($allowedExt, $size, $this->Supplier->data['SupplierFile'][$k]['file'], true);
                        $result = $uploader->handleUpload("supplier" . DS);
                        switch ($result['status']) {
                            case 206:
                                $this->Supplier->data['SupplierFile'][$k]['AssetFile'] = array(
                                    "folder" => $result['data']['folder'],
                                    "filename" => $result['data']['fileName'],
                                    "ext" => $result['data']['ext'],
                                    "is_private" => true,
                                );
                                break;
                            case 443:
                                $var = "";
                                foreach ($allowedExt as $index => $ext) {
                                    $var .= $ext . ", ";
                                }
                                $this->Session->setFlash(__("Ekstensi file salah, yang diperbolehkan hanya " . $var), 'default', array(), 'warning');
                                $this->redirect(array('action' => 'admin_add'));
                                break;
                        }
                        unset($this->Supplier->data['SupplierFile'][$k]['file']);
                    }
                }
                $initial = $this->data['Supplier']['initial'];
                $this->Supplier->data['Supplier']['id_supplier'] = $this->generateIDSupplier($initial);

                /* adding account name with name of supplier */
                $this->Supplier->data['GeneralEntryType']['name'] = $this->generateSupplierAccount($this->Supplier->data['Supplier']['name']);
                $this->Supplier->data['GeneralEntryType']['parent_id'] = 51;
                $this->Supplier->data['GeneralEntryType']['code'] = $this->getSupplierAccountCode();
                $this->Supplier->data['GeneralEntryType']['currency_id'] = 1;

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
                        foreach ($this->data['SupplierFile'] as $k => $details) {
                            if (!empty($details['file']['name'])) {
                                App::import("Vendor", "qqUploader");
                                $allowedExt = array("jpg", "jpeg", "png", "pdf");
                                $size = 10 * 1024 * 1024;
                                $uploader = new qqFileUploader($allowedExt, $size, $this->Supplier->data['SupplierFile'][$k]['file'], true);
                                $result = $uploader->handleUpload("supplier" . DS);
                                switch ($result['status']) {
                                    case 206:
                                        $this->Supplier->data['SupplierFile'][$k]['AssetFile'] = array(
                                            "folder" => $result['data']['folder'],
                                            "filename" => $result['data']['fileName'],
                                            "ext" => $result['data']['ext'],
                                            "is_private" => true,
                                        );
                                        break;
                                }
                                unset($this->Supplier->data['SupplierFile'][$k]['gambar']);
                            }
                        }
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
                        "SupplierBank",
                        "SupplierFile" => [
                            "AssetFile"
                        ]
                    ],
                    'recursive' => 2
                ));
                $this->countryId = $rows["Supplier"]["country_id"];
                $this->stateId = $rows["Supplier"]["state_id"];
                $this->cpCountryId = $rows["Supplier"]["cp_country_id"];
                $this->cpStateId = $rows["Supplier"]["cp_state_id"];
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
                    "SupplierBank",
                    "SupplierFile" => [
                        "AssetFile"
                    ]
                ],
            ));
            $this->countryId = $rows["Supplier"]["country_id"];
            $this->stateId = $rows["Supplier"]["state_id"];
            $this->cpCountryId = $rows["Supplier"]["cp_country_id"];
            $this->cpStateId = $rows["Supplier"]["cp_state_id"];
            $this->data = $rows;
        }
    }

    function view_data_supplier($id = null) {
        $this->autoRender = false;
        if ($this->Supplier->exists($id)) {
            if ($this->request->is("GET")) {
                $data = $this->Supplier->find("first", [
                    "conditions" => [
                        "Supplier.id" => $id
                    ],
                    "contain" => [
                        "SupplierFile" => [
                            "AssetFile"
                        ]
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

    function admin_list() {
        $this->autoRender = false;
        $conds = [];
        if (isset($this->request->query['q'])) {
            $q = $this->request->query['q'];
            $conds[] = array(
                "or" => array(
                    "Supplier.name like" => "%$q%",
            ));
        }

        $suggestions = ClassRegistry::init("Supplier")->find("all", array(
            "conditions" => $conds,
            "limit"=>10,
        ));
        $result = [];
        foreach ($suggestions as $item) {
            if (!empty($item)) {
                $result[] = [
                    "id" => @$item['Supplier']['id'],
                    "name" => @$item['Supplier']['name'],
                    "address" => emptyToStrip(@$item['Supplier']['address']),
                    "location" => emptyToStrip(@$item['City']['name']) . ", " . emptyToStrip(@$item['State']['name']) . ", " . emptyToStrip(@$item['Country']['name']),
                    "phone" => emptyToStrip(@$item['Supplier']['phone']),
                    "handphone" => emptyToStrip(@$item['Supplier']['phone_number']),
                    "email" => emptyToStrip(@$item['Supplier']['email'])
                ];
            }
        }
        echo json_encode($result);
    }

    function generateIDSupplier($initial) {
        $code = "";
        $id = "";
        $dataSupplier = $this->Supplier->find("first", [
            "order" => "Supplier.id DESC"
        ]);
        if (!empty($dataSupplier)) {
            $id = sprintf("%03d", $dataSupplier['Supplier']['id'] + 1);
        } else {
            $id = sprintf("%03d", 1);
        }
        $code = $initial . "-" . $id;
        return $code;
    }

    function generateSupplierAccount($supplier_name) {
        if (!empty($supplier_name)) {
            $result = "PS - " . $supplier_name;
            return $result;
        }
        return null;
    }

    function getSupplierAccountCode() {
        $template = "1301-00-";
        $dataSupplierName = ClassRegistry::init("GeneralEntryType")->find("first", [
            "conditions" => [
                "GeneralEntryType.parent_id" => 51
            ],
            "order" => "GeneralEntryType.id DESC"
        ]);
        if (!empty($dataSupplierName)) {
            $code = $dataSupplierName['GeneralEntryType']['code'];
            $temp = explode("-", $code);
            $numberToInteger = intval($temp[2]) + 1;
            $inc_id = sprintf("%03d", $numberToInteger);
        } else {
            $inc_id = sprintf("%03d", 1);
        }
        $result = $template . $inc_id;
        return $result;
    }
}