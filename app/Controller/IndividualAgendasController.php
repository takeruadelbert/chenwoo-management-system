<?php

App::uses('AppController', 'Controller');

class IndividualAgendasController extends AppController {

    var $name = "IndividualAgendas";
    var $disabledAction = array(
    );

    function beforeFilter() {
        parent::beforeFilter();
        $this->_setPageInfo("admin_index", "");
        $this->_setPageInfo("admin_add", "");
        $this->_setPageInfo("admin_edit", "");
        $this->_setPageInfo("admin view", "");
    }

    function admin_calender() {
        $events = $this->IndividualAgenda->find('all');
        $result = [];
        foreach ($events as $event) {
            $result[] = [
                "id" => $event['IndividualAgenda']['id'],
                "allDay" => $event['IndividualAgenda']['all_day'],
                "title" => $event['IndividualAgenda']['title'],
                "start" => $event['IndividualAgenda']['start'],
                "end" => $event['IndividualAgenda']['end'],
                "description" => $event['IndividualAgenda']['description'],
            ];
        }
        $this->set(compact('result'));
        parent::admin_index();
    }

    function admin_index() {
        $this->_activePrint(func_get_args(), "agenda_perusahaan");

        parent::admin_index();
    }

    function admin_calender_add() {
        $this->autoRender = false;
        if ($this->request->is("post")) {
            $this->{ Inflector::classify($this->name) }->set($this->data);
            if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only'))) {
                $this->{ Inflector::classify($this->name) }->data['IndividualAgenda']['employee_id'] = $this->_getEmployeeId();
                $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
                echo json_encode($this->_generateStatusCode(206, null, ["individual_agenda_id" => $this->{ Inflector::classify($this->name) }->getLastInsertID()]));
            } else {
                echo json_encode($this->_generateStatusCode(101, null, ['error' => $this->{ Inflector::classify($this->name) }->validationErrors]));
            }
        }
    }

    function admin_add() {
        if ($this->request->is("post")) {
            $this->{ Inflector::classify($this->name) }->set($this->data);
            if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                $this->{ Inflector::classify($this->name) }->data['IndividualAgenda']['employee_id'] = $this->_getEmployeeId();
                $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
                $this->Session->setFlash(__("Data berhasil disimpan"), 'default', array(), 'success');
                $this->redirect(array('action' => 'admin_index'));
            } else {
                $this->validationErrors = $this->{ Inflector::classify($this->name) }->validationErrors;
                $this->Session->setFlash(__("Harap mengecek kembali kesalahan dibawah."), 'default', array(), 'danger');
            }
        }
    }

    function admin_calender_edit($id = null) {
        $this->autoRender = false;
        if ($this->request->is("post") || $this->request->is("put")) {
            $this->{ Inflector::classify($this->name) }->set($this->data);
            if ($this->{ Inflector::classify($this->name) }->validates()) {
                if (!is_null($id)) {
                    $this->{ Inflector::classify($this->name) }->id = $id;
                    $this->IndividualAgenda->data['IndividualAgenda']['id'] = $id;
                    $this->{ Inflector::classify($this->name) }->data['IndividualAgenda']['employee_id'] = $this->_getEmployeeId();
                    $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
                    $rows = $this->{ Inflector::classify($this->name) }->find("first", array('conditions' => array(Inflector::classify($this->name) . ".id" => $id), "recursive" => 2));
                    $this->data = $rows;
                    echo json_encode($this->_generateStatusCode(206, null, ["individual_agenda_id" => $id]));
                } else {
                    echo json_encode($this->_generateStatusCode(401, null));
                }
            } else {
                $this->validationErrors = $this->{ Inflector::classify($this->name) }->validationErrors;
            }
        } else {
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

    function admin_calender_delete($id = null) {
        $this->autoRender = false;
        if ($this->request->is("delete")) {
            $this->{ Inflector::classify($this->name) }->set($this->data);
            if (!is_null($id)) {
                $this->{ Inflector::classify($this->name) }->id = $id;
                $this->IndividualAgenda->data['IndividualAgenda']['id'] = $id;
                $employee_id = $this->_getEmployeeId();
                $this->IndividualAgenda->query("DELETE FROM individual_agendas WHERE id = $id");
                echo json_encode($this->_generateStatusCode(204));
            } else {
                echo json_encode($this->_generateStatusCode(401, null));
            }
        }
    }

    function admin_view($id = null) {
        if (!$this->IndividualAgenda->exists($id)) {
            throw new NotFoundException(__('Data Not Found'));
        } else {
            $this->{ Inflector::classify($this->name) }->id = $id;
            $this->IndividualAgenda->data['IndividualAgenda']['id'] = $id;
            $rows = $this->{ Inflector::classify($this->name) }->find("first", array('conditions' => array(Inflector::classify($this->name) . ".id" => $id), "recursive" => 2));
            $this->data = $rows;
        }
    }

    function beforeRender() {
        $this->_options();
        parent::beforeRender();
    }

    function _options() {
        $this->set("departments", $this->IndividualAgenda->Employee->Department->find("list", array("fields" => array("Department.id", "Department.name"))));
    }

}
