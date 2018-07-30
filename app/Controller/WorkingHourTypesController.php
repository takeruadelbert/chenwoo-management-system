<?php

App::uses('AppController', 'Controller');

class WorkingHourTypesController extends AppController {

    var $name = "WorkingHourTypes";
    var $disabledAction = array(
    );

    function beforeFilter() {
        parent::beforeFilter();
        $this->_setPageInfo("admin_index", "");
        $this->_setPageInfo("admin_add", "");
        $this->_setPageInfo("admin_edit", "");
        $this->_setPageInfo("admin view", "");
    }

    function admin_index() {
        $this->_activePrint(func_get_args(), "data_jenis_jam_kerja");
        parent::admin_index();
    }

    function admin_add() {
        if ($this->request->is("post")) {
            $this->{ Inflector::classify($this->name) }->set($this->data);
            if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only'))) {
                $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
                $this->Session->setFlash(__("Data berhasil disimpan"), 'default', array(), 'success');
                $this->redirect(array('action' => 'admin_index'));
            } else {
                $this->validationErrors = $this->{ Inflector::classify($this->name) }->validationErrors;
                $this->Session->setFlash(__("Harap mengecek kembali kesalahan dibawah."), 'default', array(), 'danger');
            }
        }
        $this->set("days", $this->WorkingHourType->WorkingHourTypeDetail->Day->find("list", array("fields" => array("Day.id", "Day.name"))));
    }

    function admin_edit($id = null) {
        if ($this->request->is("post") || $this->request->is("put")) {
            $this->{ Inflector::classify($this->name) }->set($this->data);
            if ($this->{ Inflector::classify($this->name) }->validates()) {
                if (!is_null($id)) {
                    $this->{ Inflector::classify($this->name) }->id = $id;
                    $this->WorkingHourType->data['WorkingHourType']['id'] = $id;
                    $temp = array();
                    $hari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
                    if (!empty($this->data['WorkingHourTypeDetail'])) {
                        foreach ($this->data['WorkingHourTypeDetail'] as $k => $item) {
                            array_push($temp, $item['day_id']);
                        }
                        for ($i = 1; $i <= sizeof($hari); $i++) {
                            for ($j = 0; $j < sizeof($temp); $j++) {
                                if ($this->WorkingHourType->query("DELETE FROM working_hour_type_details WHERE working_hour_type_id = $id AND day_id = $i") !== null) {
                                    $this->WorkingHourType->query("DELETE FROM working_hour_type_details WHERE working_hour_type_id = $id AND day_id = $i");
                                }
                            }
                        }
                    }
                    $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
                    $rows = $this->{ Inflector::classify($this->name) }->find("first", array('conditions' => array(Inflector::classify($this->name) . ".id" => $id), "recursive" => 2));
                    $this->data = $rows;
                    $this->Session->setFlash(__("Data berhasil diubah"), 'default', array(), 'success');
                    $this->redirect(array('action' => 'admin_index'));
                } else {
                    
                }
            } else {
                $this->validationErrors = $this->{ Inflector::classify($this->name) }->validationErrors;
            }
        } else {
            $rows = $this->{ Inflector::classify($this->name) }->find("first", array('conditions' => array(Inflector::classify($this->name) . ".id" => $id), "recursive" => 2));
            $this->data = $rows;
        }
        $this->set("days", $this->WorkingHourType->WorkingHourTypeDetail->Day->find("list", array("fields" => array("Day.id", "Day.name"))));
    }

    function admin_view($id = null) {
        if ($this->WorkingHourType->exists($id)) {
            $rows = $this->{ Inflector::classify($this->name) }->find("first", array('conditions' => array(Inflector::classify($this->name) . ".id" => $id), "recursive" => 2));
            $this->data = $rows;
        } else {
            throw new NotFoundException(__("Data Not Found"));
        }
        $this->set("days", $this->WorkingHourType->WorkingHourTypeDetail->Day->find("list", array("fields" => array("Day.id", "Day.name"))));
    }

}
