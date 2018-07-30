<?php

App::uses('AppController', 'Controller');

class CooperativeEntryTypesController extends AppController {

    var $name = "CooperativeEntryTypes";
    var $disabledAction = array(
    );

    function beforeFilter() {
        parent::beforeFilter();
        $this->_setPageInfo("admin_index", "");
        $this->_setPageInfo("admin_add", "");
        $this->_setPageInfo("admin_edit", "");
    }

    function beforeRender() {
        $this->_options();
        parent::beforeRender();
    }

    function _options() {
        $this->set("transactionCategories", $this->CooperativeEntryType->listCategory());
    }

    function admin_index() {
        $this->_activePrint(func_get_args(), "cooperative_entry_type");
        parent::admin_index();
    }

}
