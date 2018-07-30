<?php

App::uses('AppController', 'Controller');

class CurrenciesController extends AppController {

    var $name = "Currency";
    var $disabledAction = array(
    );

    function beforeFilter() {
        parent::beforeFilter();
        $this->_setPageInfo("admin_index", "");
        $this->_setPageInfo("admin_add", "");
        $this->_setPageInfo("admin_edit", "");
        $this->_setPageInfo("admin_view", "");
    }

    function admin_index() {
        $this->_activePrint(func_get_args(), "data_mata_uang");
        parent::admin_index();
    }

    function view_currency($id = null) {
        $this->autoRender = false;
        if ($this->Currency->exists($id)) {
            if ($this->request->is("GET")) {
                $data = $this->Currency->find("first", ["conditions" => ["Currency.id" => $id]]);
                return json_encode($data);
            } else {
                return json_encode($this->_generateStatusCode(400));
            }
        } else {
            throw new NotFoundException(__("Data Not Found"));
        }
    }

}
