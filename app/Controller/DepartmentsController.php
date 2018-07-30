<?php

App::uses('AppController', 'Controller');

class DepartmentsController extends AppController {

    var $name = "Departments";
    var $disabledAction = array(
    );

    var $contain = [
        "DepartmentType"
    ];
    function beforeFilter() {
        $this->_options();
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
        $this->_activePrint(func_get_args(), "data_departemen");
        parent::admin_index();
    }

    function view_data_department($id = null) {
        $this->autoRender = false;
        if ($this->Department->exists($id)) {
            if ($this->request->is("GET")) {
                $data = $this->Department->find("first", [
                    "conditions" => [
                        "Department.id" => $id,
                    ],
                    "contain" => [
                        "Parent",
                        "Child"
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

    function admin_subdepartment() {
        $this->_activePrint(func_get_args(), "data_sub_departemen");
        $this->conds = [
            "Department.parent_id !=" => null,
        ];
        $this->contain = [
            "Parent",
            "Child"
        ];
        parent::admin_index();
    }

    function admin_add_subdepartment() {
        if ($this->request->is("post")) {
            $this->{ Inflector::classify($this->name) }->set($this->data);
            if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
                $this->Session->setFlash(__("Data berhasil disimpan"), 'default', array(), 'success');
                $this->redirect(array('action' => 'admin_subdepartment'));
            } else {
                $this->validationErrors = $this->{ Inflector::classify($this->name) }->validationErrors;
                $this->Session->setFlash(__("Harap mengecek kembali kesalahan dibawah."), 'default', array(), 'danger');
            }
        }
    }

    function admin_edit_subdepartment($id = null) {
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
                        $this->redirect(array('action' => 'admin_subdepartment'));
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
        $this->set("parents", $this->Department->find("list", ["fields" => ["Department.id", "Department.name"], "conditions" => ["Department.id !=" => $id]]));
    }

    function _options() {
        $this->set("parents", $this->Department->find("list", ["fields" => ["Department.id", "Department.name"]]));
        $this->set("children", $this->Department->find("list", ["fields" => ["Department.id", "Department.name"]]));
        $this->set("departmentTypes", $this->Department->DepartmentType->find("list", ["fields" => ["DepartmentType.id", "DepartmentType.name"]]));
    }

}
