<?php

App::uses('AppController', 'Controller');

class MaterialAdditionalCategoriesController extends AppController {

    var $name = "MaterialAdditionalCategories";
    var $disabledAction = array(
    );

    function beforeFilter() {
        parent::beforeFilter();
        $this->_setPageInfo("admin_index", "");
        $this->_setPageInfo("admin_add", "");
        $this->_setPageInfo("admin_edit", "");
    }

    function admin_index() {
        $this->_activePrint(func_get_args(), "data_jenis_material_pembantu");
        parent::admin_index();
    }

    function admin_add() {
        if ($this->request->is("post")) {
            $this->{ Inflector::classify($this->name) }->set($this->data);
            if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                $referenceNumber = $this->generateCodeAccountJournal();
                $updatedData = [];
                $updatedData['GeneralEntryType']['name'] = "Biaya " . $this->data['MaterialAdditionalCategory']['name'];
                $updatedData['GeneralEntryType']['parent_id'] = 11;
                $updatedData['GeneralEntryType']['code'] = $referenceNumber;
                $updatedData['GeneralEntryType']['currency_id'] = 1;
                ClassRegistry::init("GeneralEntryType")->save($updatedData);
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

    function generateCodeAccountJournal() {
        $temp = "5200-00-";
        $dataMaterialAddCategory = ClassRegistry::init("MaterialAdditionalCategory")->find("count");
        if ($dataMaterialAddCategory > 0) {
            $dataMaterial = ClassRegistry::init("MaterialAdditionalCategory")->find("first", [
                "order" => "MaterialAdditionalCategory.id DESC"
            ]);
            $dataGeneralEntryType = ClassRegistry::init("GeneralEntryType")->find("first", [
                "conditions" => [
                    "GeneralEntryType.name like" => "%" . $dataMaterial['MaterialAdditionalCategory']['name'] . "%"
                ]
            ]);
            $dataCode = $dataGeneralEntryType['GeneralEntryType']['code'];
            $splitCode = explode("-", $dataCode);
            $code = $splitCode[2] + 1;
            $res = sprintf("%'103d", $code);
            return $temp . $res;
        } else {
            $id = "101";
        }
        return $temp . $id;
    }

    function view_material_additional_category($id = null) {
        if ($this->MaterialAdditionalCategory->exists($id)) {
            $this->autoRender = false;
            if ($this->request->is("GET")) {
                $data = $this->MaterialAdditionalCategory->find("first", ["conditions" => ["MaterialAdditionalCategory.id" => $id]]);
                return json_encode($data);
            } else {
                return json_encode($this->_generateStatusCode(400));
            }
        } else {
            throw new NotFoundException(__("Data Not Found"));
        }
    }

}
