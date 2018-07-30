<?php

App::uses('AppController', 'Controller');

class DepartmentAgendasController extends AppController {

    var $name = "DepartmentAgendas";
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
        $department_id = $this->_getDepartmentId();
        $events = $this->DepartmentAgenda->find('all', array('conditions' => array(Inflector::classify($this->name) . ".department_id" => $department_id)));
        $result = [];
        foreach ($events as $event) {
            $result[] = [
                "id" => $event['DepartmentAgenda']['id'],
                "allDay" => $event['DepartmentAgenda']['all_day'],
                "title" => $event['DepartmentAgenda']['title'],
                "start" => $event['DepartmentAgenda']['start'],
                "end" => $event['DepartmentAgenda']['end'],
                "description" => $event['DepartmentAgenda']['description'],
            ];
        }
        $this->set(compact('result'));
    }

    function admin_calender_add() {
        $this->autoRender = false;
        if ($this->request->is("post")) {
            $this->{ Inflector::classify($this->name) }->set($this->data);
            if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only'))) {
                $this->{ Inflector::classify($this->name) }->data['DepartmentAgenda']['department_id'] = $this->_getDepartmentId();
                $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
                echo json_encode($this->_generateStatusCode(206, null, ["department_agenda_id" => $this->{ Inflector::classify($this->name) }->getLastInsertID()]));
            } else {
                echo json_encode($this->_generateStatusCode(101, null, ['error' => $this->{ Inflector::classify($this->name) }->validationErrors]));
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
                    $this->DepartmentAgenda->data['DepartmentAgenda']['id'] = $id;
                    $this->{ Inflector::classify($this->name) }->data['DepartmentAgenda']['department_id'] = $this->_getDepartmentId();
                    $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
                    $rows = $this->{ Inflector::classify($this->name) }->find("first", array('conditions' => array(Inflector::classify($this->name) . ".id" => $id), "recursive" => 2));
                    $this->data = $rows;
                    echo json_encode($this->_generateStatusCode(206, null, ["department_agenda_id" => $id]));
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

    function admin_calender_delete($id = null) {
        $this->autoRender = false;
        if ($this->request->is("delete")) {
            $this->{ Inflector::classify($this->name) }->set($this->data);
            if (!is_null($id)) {
                $this->{ Inflector::classify($this->name) }->id = $id;
                $this->DepartmentAgenda->data['DepartmentAgenda']['id'] = $id;
                $this->DepartmentAgenda->query("DELETE FROM department_agendas WHERE id = $id");
                echo json_encode($this->_generateStatusCode(204));
            } else {
                echo json_encode($this->_generateStatusCode(401, null));
            }
        }
    }

    function beforeRender() {
        $this->_options();
        parent::beforeRender();
    }

    function admin_view($id = null) {
        if (!$this->DepartmentAgenda->exists($id)) {
            throw new NotFoundException(__('Data Not Found'));
        } else {
            $this->{ Inflector::classify($this->name) }->id = $id;
            $this->DepartmentAgenda->data['DepartmentAgenda']['id'] = $id;
            $rows = $this->{ Inflector::classify($this->name) }->find("first", array('conditions' => array(Inflector::classify($this->name) . ".id" => $id), "recursive" => 2));
            $this->data = $rows;
        }
        $this->set("departments", $this->DepartmentAgenda->Department->find("list", array("fields" => array("Department.id", "Department.name"), "recursive" => 2)));
    }

    function _options() {
        $this->set("departments", $this->DepartmentAgenda->Department->find("list", array("fields" => array("Department.id", "Department.name"), "recursive" => 2)));
    }
    
    function admin_index() {
        $this->_activePrint(func_get_args(), "department_agenda");
        parent::admin_index();
    }
}