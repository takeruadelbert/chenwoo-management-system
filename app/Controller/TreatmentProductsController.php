<?php

App::uses('AppController', 'Controller');

class TreatmentProductsController extends AppController {

    var $name = "TreatmentProducts";
    var $disabledAction = array(
    );
    var $contain = [
        "ProductUnit",
    ];

    function beforeFilter() {
        parent::beforeFilter();
        $this->_setPageInfo("admin_index", "");
        $this->_setPageInfo("admin_add", "");
        $this->_setPageInfo("admin_edit", "");
    }

    function admin_add() {
        if ($this->request->is("post")) {
            $this->{ Inflector::classify($this->name) }->set($this->data);
            if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                $this->TreatmentProduct->_numberSeperatorRemover();
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
                        $this->TreatmentProduct->_numberSeperatorRemover();
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

    function admin_get_all_product() {
        $this->autoRender = false;
        $data = $this->{ Inflector::classify($this->name) }->find('all', array(
            "fields" => array(
                "TreatmentProduct.id",
                "TreatmentProduct.name",
                "TreatmentProduct.price",
            ),
            "conditions" => array(
            ),
            "contain" => array(
            )
        ));
        echo json_encode($data);
    }

    function beforeRender() {
        $this->_options();
        parent::beforeRender();
    }

    function _options() {
        $this->set("productUnits", ClassRegistry::init("ProductUnit")->find("list", array("fields" => array("ProductUnit.id", "ProductUnit.name"))));
    }

    function view_treatment_product($id = null) {
        $this->autoRender = false;
        if ($this->TreatmentProduct->exists($id)) {
            $data = $this->TreatmentProduct->find("first", [
                "conditions" => [
                    "TreatmentProduct.id" => $id
                ]
            ]);
            return json_encode($data);
        } else {
            throw new NotFoundException(__("404 Data Not Found."));
        }
    }

}
