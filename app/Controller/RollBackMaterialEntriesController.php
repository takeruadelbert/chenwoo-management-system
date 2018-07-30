<?php

App::uses('AppController', 'Controller');

class RollBackMaterialEntriesController extends AppController {

    var $name = "RollBackMaterialEntries";
    var $disabledAction = array(
    );
    var $contain = [
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
            debug($this->data);
            $this->MaterialEntry->_numberSeperatorRemover();
            foreach ($this->MaterialEntry->data['MaterialEntryGrade'] as $k => $params) {
                $this->{ Inflector::classify($this->name) }->data['MaterialEntryGrade'][$k]['batch_number'] = $this->generateBatchNumber($this->data['MaterialEntry']['supplier_id']);
            }
            $this->{ Inflector::classify($this->name) }->data['MaterialEntry']['employee_id'] = $this->Session->read("credential.admin.Employee.id");
            if ($this->MaterialEntry->data['MaterialEntry']['material_category_id'] == 1) {
                $this->{ Inflector::classify($this->name) }->data['MaterialEntry']['stage_id'] = 1;
            } else {
                $this->{ Inflector::classify($this->name) }->data['MaterialEntry']['stage_id'] = 2;
            }
            $this->{ Inflector::classify($this->name) }->data['MaterialEntry']['material_entry_number'] = $this->generateMaterialEntryNumber();
            if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                foreach ($this->MaterialEntry->data['MaterialEntryGrade'] as $k => $params) {
                    $material = ClassRegistry::init("MaterialDetail")->find("first", [
                        "conditions" => [
                            "MaterialDetail.id" => $params['material_detail_id'],
                        ],
                    ]);
                    $toUpdate = [
                        "MaterialDetail" => [
                            "id" => intval($params['material_detail_id']),
                            "weight" => intval($params['weight']) + $material["MaterialDetail"]["weight"]
                        ]
                    ];
                    ClassRegistry::init("MaterialDetail")->saveAll($toUpdate);
                }
                $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
                $this->Session->setFlash(__("Data berhasil disimpan"), 'default', array(), 'success');
                $this->redirect(array('action' => 'admin_index'));
            } else {
                $this->validationErrors = $this->{ Inflector::classify($this->name) }->validationErrors;
                $this->Session->setFlash(__("Harap mengecek kembali kesalahan dibawah."), 'default', array(), 'danger');
            }
        }
        $this->set("dataMaterialSize", ClassRegistry::init("MaterialSize")->find("all", array("fields" => array("MaterialSize.id", "MaterialSize.name"))));
        $this->set("dataMaterialWhole", ClassRegistry::init("Material")->find("all", array("fields" => array("Material.id", "Material.name"), "contain" => array("MaterialDetail"), "conditions" => array("Material.material_category_id" => 1))));
        $this->set("dataMaterialColly", ClassRegistry::init("Material")->find("all", array("fields" => array("Material.id", "Material.name"), "contain" => array("MaterialDetail"), "conditions" => array("Material.material_category_id" => 2))));
    }

    function beforeRender() {
        $this->_options();
        parent::beforeRender();
    }

    function _options() {
        $this->set("materials", ClassRegistry::init("Material")->find("list", array("fields" => array("Material.id", "Material.name"))));
        $this->set("suppliers", ClassRegistry::init("Supplier")->find("list", array("fields" => array("Supplier.id", "Supplier.name"))));
        //$this->set("branchOffices", $this->MaterialEntry->Employee->BranchOffice->find("list", array("fields" => array("BranchOffice.id", "BranchOffice.name"))));
        $this->set("materialCategories", ClassRegistry::init("MaterialCategory")->find("list", array("fields" => array("MaterialCategory.id", "MaterialCategory.name"))));
        $this->set("materialEntries", ClassRegistry::init("MaterialEntry")->find("list", array("fields" => array("MaterialEntry.id", "MaterialEntry.material_entry_number"))));
    }
}
