<?php

App::uses('AppController', 'Controller');

class WorkingHourTypeDetailsController extends AppController {

    var $name = "WorkingHourTypeDetails";
    var $disabledAction=array(
    );
    
    function beforeFilter() {
        parent::beforeFilter();
        $this->_setPageInfo("admin_index", "");
        $this->_setPageInfo("admin_add", "");
        $this->_setPageInfo("admin_edit", "");
    }
    
    function admin_index() {
        $this->contain = [
            "Day",
        ];
        parent::admin_index();
    }
}
