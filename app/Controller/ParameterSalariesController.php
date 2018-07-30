<?php

App::uses('AppController', 'Controller');

class ParameterSalariesController extends AppController {

    var $name = "ParameterSalaries";
    var $disabledAction = array(
    );
    var $contain = [
        "ParameterSalaryType",
    ];

    function beforeFilter() {
        parent::beforeFilter();
        $this->_setPageInfo("admin_index", "Parameter Gaji");
        $this->_setPageInfo("admin_add", "Tambah Parameter Gaji");
        $this->_setPageInfo("admin_edit", "Ubah Parameter Gaji");
    }

    function beforeRender() {
        $this->_options();
        parent::beforeRender();
    }

    function _options() {
        $this->set("parameterSalaryTypes", ClassRegistry::init("ParameterSalaryType")->find("list", array("fields" => array("ParameterSalaryType.id", "ParameterSalaryType.name"))));
    }

    function admin_index() {
        $this->_activePrint(func_get_args(), "parameter_salary");
        parent::admin_index();
    }

    function admin_add() {
        if ($this->request->is("post")) {
            $this->{ Inflector::classify($this->name) }->set($this->data);
            if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                $this->{ Inflector::classify($this->name) }->data['ParameterSalary']['validate_status_id'] = 1;
                $this->{ Inflector::classify($this->name) }->data['ParameterSalary']['verify_status_id'] = 1;
                $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
                $this->Session->setFlash(__("Data berhasil disimpan"), 'default', array(), 'success');
                $this->redirect(array('action' => 'admin_index'));
            } else {
                $this->validationErrors = $this->{ Inflector::classify($this->name) }->validationErrors;
                $this->Session->setFlash(__("Harap mengecek kembali kesalahan dibawah."), 'default', array(), 'danger');
            }
        }
    }

    function admin_change_status() {
        $this->autoRender = false;
        if ($this->request->is("PUT")) {
            $this->ParameterSalary->data['ParameterSalary']['id'] = $this->request->data['id'];
            $this->ParameterSalary->data['ParameterSalary']['verify_status_id'] = $this->request->data['status'];
            if ($this->request->data['status'] !== '1') {
                $this->ParameterSalary->data['ParameterSalary']['verified_by_id'] = $this->_getEmployeeId();
                $this->ParameterSalary->data['ParameterSalary']['verified_datetime'] = date("Y-m-d h:i:s");
            } else {
                $this->ParameterSalary->data['ParameterSalary']['verified_by_id'] = null;
                $this->ParameterSalary->data['ParameterSalary']['verified_datetime'] = null;
            }
            $this->ParameterSalary->saveAll();
            $data = $this->ParameterSalary->find("first", array("conditions" => array("ParameterSalary.id" => $this->request->data['id']), "recursive" => 3));
            echo json_encode($this->_generateStatusCode(207, null, array("status_label" => $data['VerifyStatus']['name'])));
        } else {
            echo json_encode($this->_generateStatusCode(400));
        }
    }

    function view_data_parameter($paramId) {
        if (!empty($paramId) && $paramId != null) {
            $this->autoRender = false;
            $data = ClassRegistry::init("ParameterSalary")->find("first", [
                "conditions" => [
                    "ParameterSalary.id" => $paramId,
                ],
                "contain" => [
                    "ParameterSalaryType",
                ],
            ]);
            return json_encode($data);
        } else {
            throw new NotFoundException(__('Data Not Found'));
        }
    }

}
