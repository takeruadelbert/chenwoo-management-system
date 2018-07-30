<?php

App::uses('AppController', 'Controller');

class BranchOfficesController extends AppController {

    var $name = "BranchOffices";
    var $disabledAction = array(
    );

    function beforeFilter() {
        parent::beforeFilter();
        $this->_setPageInfo("admin_index", "");
        $this->_setPageInfo("admin_add", "");
        $this->_setPageInfo("admin_edit", "");
        $this->_setPageInfo("admin_view", "");
    }
    
    function view_branch_office($id = null) {
        $this->autoRender = false;
        if($this->BranchOffice->exists($id)) {
            $data = $this->BranchOffice->find("first",[
                "conditions" => [
                    "BranchOffice.id" => $id
                ]
            ]);
            return json_encode($data);
        } else {
            throw new NotFoundException(__("404 Data Not Found."));
        }
    }
}