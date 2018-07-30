<?php

App::uses('AppController', 'Controller');

class FamilyRelationsController extends AppController {

    var $name = "FamilyRelations";
    var $disabledAction = array(
    );

    function beforeFilter() {
        parent::beforeFilter();
        $this->_setPageInfo("admin_index", "");
        $this->_setPageInfo("admin_add", "");
        $this->_setPageInfo("admin_edit", "");
    }

    function admin_index() {
        $this->_activePrint(func_get_args(), "data_keluarga");
        parent::admin_index();
    }

    function view_data_family_relations($id = null) {
        $this->autoRender = false;
        if ($this->FamilyRelation->exists($id)) {
            if ($this->request->is("GET")) {
                $data = $this->FamilyRelation->find("first", ["conditions" => ["FamilyRelation.id" => $id]]);
                return json_encode($data);
            } else {
                return json_encode($this->_generateStatusCode(400));
            }
        } else {
            throw new NotFoundException(__("Data Not Found"));
        }
    }

}
