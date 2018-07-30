<?php

App::uses('AppController', 'Controller');

class TaxesController extends AppController {

    var $name = "Taxes";
    var $disabledAction = array(
    );

    function beforeFilter() {
        parent::beforeFilter();
        $this->_setPageInfo("admin_index", "");
        $this->_setPageInfo("admin_add", "");
        $this->_setPageInfo("admin_edit", "");
        $this->_setPageInfo("admin_view", "");
    }
    
    function view_data_tax($id = null) {
        if($this->Tax->exists($id)) {
            $this->autoRender = false;
            if($this->request->is("GET")) {
                $data = $this->Tax->find("first",["conditions" => ["Tax.id" => $id]]);
                return json_encode($data);
            } else {
                return json_encode($this->_generateStatusCode(400));
            }
        } else {
            throw new NotFoundException(__("Data Not Found"));
        }
    }
}