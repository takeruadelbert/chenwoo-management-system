<?php

App::uses('AppController', 'Controller');

class UserGroupsController extends AppController {

    var $name = "UserGroups";
    var $disabledAction = array(
    );

    function beforeFilter() {
        parent::beforeFilter();
        $this->_setPageInfo("admin_index", "User Group");
        $this->_setPageInfo("admin_add", "Tambah User Group");
        $this->_setPageInfo("admin_edit", "Ubah User Group");
    }

    function admin_view($id = null) {
        if (!$this->{ Inflector::classify($this->name) }->exists($id)) {
            throw new NotFoundException(__('Invalid user'));
        } else {
            $this->{ Inflector::classify($this->name) }->id = $id;
            $this->{ Inflector::classify($this->name) }->data['Employee']['id'] = $id;
            $rows = $this->{ Inflector::classify($this->name) }->find("first", array('conditions' => array(Inflector::classify($this->name) . ".id" => $id), "recursive" => 2));
            $this->data = $rows;
        }
    }

}
