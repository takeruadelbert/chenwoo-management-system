<?php

App::uses('AppController', 'Controller');

class StatesController extends AppController {

    var $disabledAction = array(
    );

    function beforeFilter() {
        parent::beforeFilter();
        $this->_setPageInfo("admin_index", "State");
        $this->_setPageInfo("admin_add", "Tambah State");
        $this->_setPageInfo("admin_edit", "Ubah State");
    }

    function admin_index() {
        parent::admin_index();
    }

    function admin_list($country_id = false) {
        if ($country_id === false) {
            $data = $this->State->find("list", [
                "fields" => [
                    "State.id",
                    "State.name",
                ]
            ]);
        } else {
            $data = $this->State->find("list", [
                "fields" => [
                    "State.id",
                    "State.name",
                ],
                "conditions" => [
                    "State.country_id" => $country_id
                ]
            ]);
        }
        echo json_encode($this->_generateStatusCode(200, null, $data));
        die;
    }
    
    function admin_list_by_country($country_id = null) {
        $this->autoRender = false;
        $data = $this->State->find("list", [
            "fields" => [
                "State.id",
                "State.name",
            ],
            "conditions" => [
                "State.country_id" => $country_id
            ]
        ]);
        echo json_encode($this->_generateStatusCode(205, null, $data));
    }

    function beforeRender() {
        $this->_options();
        parent::beforeRender();
    }

    function _options() {
        $this->set("countries", ClassRegistry::init("Country")->find("list", array("fields" => array("Country.id", "Country.name"))));
    }

    function admin_view($id = null) {
        if (!$this->State->exists($id)) {
            throw new NotFoundException(__('Invalid user'));
        } else {
            $this->{ Inflector::classify($this->name) }->id = $id;
            $this->State->data['State']['id'] = $id;
            $rows = $this->{ Inflector::classify($this->name) }->find("first", array('conditions' => array(Inflector::classify($this->name) . ".id" => $id), "recursive" => 2));
            $this->data = $rows;
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
                $this->data = $rows;
            }
        }
    }

}
