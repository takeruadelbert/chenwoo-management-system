<?php

App::uses('AppController', 'Controller');

class ExpenditureTypesController extends AppController {

    var $name = "ExpenditureTypes";
    var $disabledAction = array(
    );

    function beforeFilter() {
        parent::beforeFilter();
        $this->_setPageInfo("admin_index", "");
        $this->_setPageInfo("admin_add", "");
        $this->_setPageInfo("admin_edit", "");
        $this->_setPageInfo("admin_view", "");
    }

    function admin_index() {
        $this->_activePrint(func_get_args(), "data_jenis_pengeluaran");
        parent::admin_index();
    }

    function view_expenditure_type($id = null) {
        if ($this->ExpenditureType->exists($id)) {
            $this->autoRender = false;
            if ($this->request->is("GET")) {
                $data = $this->ExpenditureType->find("first", ["conditions" => ["ExpenditureType.id" => $id]]);
                return json_encode($data);
            } else {
                return json_encode($this->_generateStatusCode(400));
            }
        } else {
            throw new NotFoundException(__("Data Not Found"));
        }
    }

    function admin_add() {
        if ($this->request->is("post")) {
            if (!empty($this->data['Dummy']['code'])) {
                $this->{ Inflector::classify($this->name) }->set($this->data);
                if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                    $dataGeneralEntryType = ClassRegistry::init("GeneralEntryType")->find("first", [
                        "conditions" => [
                            "GeneralEntryType.name" => "Pengeluaran Luar Usaha"
                        ]
                    ]);
                    $updatedGeneralEntryType = [];
                    $updatedGeneralEntryType['GeneralEntryType']['name'] = $this->data['ExpenditureType']['name'];
                    $updatedGeneralEntryType['GeneralEntryType']['code'] = $this->data['Dummy']['code'];
                    $updatedGeneralEntryType['GeneralEntryType']['parent_id'] = $dataGeneralEntryType['GeneralEntryType']['id'];
                    ClassRegistry::init("GeneralEntryType")->save($updatedGeneralEntryType);

                    $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
                    $this->Session->setFlash(__("Data berhasil disimpan"), 'default', array(), 'success');
                    $this->redirect(array('action' => 'admin_index'));
                } else {
                    $this->validationErrors = $this->{ Inflector::classify($this->name) }->validationErrors;
                    $this->Session->setFlash(__("Harap mengecek kembali kesalahan dibawah."), 'default', array(), 'danger');
                }
            } else {
                $this->Session->setFlash(__("Kode Wajib Diisi."), 'default', array(), 'danger');
            }
        }
    }

    function admin_edit($id = null) {
        if (!$this->{ Inflector::classify($this->name) }->exists($id)) {
            throw new NotFoundException(__('Data tidak ditemukan'));
        } else {
            if ($this->request->is("post") || $this->request->is("put")) {
                if (!empty($this->data['Dummy']['code'])) {
                    $this->{ Inflector::classify($this->name) }->set($this->data);
                    $this->{ Inflector::classify($this->name) }->data[Inflector::classify($this->name)]['id'] = $id;
                    if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                        if (!is_null($id)) {
                            $dataGeneralEntryType = ClassRegistry::init("GeneralEntryType")->find("first", [
                                "conditions" => [
                                    "GeneralEntryType.name" => "Pengeluaran Luar Usaha"
                                ]
                            ]);
                            $updatedData = [];
                            $updatedData['GeneralEntryType']['id'] = $this->data['Dummy']['id'];
                            $updatedData['GeneralEntryType']['name'] = $this->data['ExpenditureType']['name'];
                            $updatedData['GeneralEntryType']['code'] = $this->data['Dummy']['code'];
                            $updatedData['GeneralEntryType']['parent_id'] = $dataGeneralEntryType['GeneralEntryType']['id'];
                            ClassRegistry::init("GeneralEntryType")->save($updatedData);
                            $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
                            $this->Session->setFlash(__("Data berhasil diubah"), 'default', array(), 'success');
                            $this->redirect(array('action' => 'admin_index'));
                        } else {
                            
                        }
                    } else {
                        $this->validationErrors = $this->{ Inflector::classify($this->name) }->validationErrors;
                    }
                } else {
                    $this->Session->setFlash(__("Kode Wajib Diisi."), 'default', array(), 'danger');
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
