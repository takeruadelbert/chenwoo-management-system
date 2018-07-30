<?php

App::uses('AppController', 'Controller');

class SentItemsController extends AppController {

    var $name = "SentItems";
    var $disabledAction = array(
        "admin_add",
        "admin_edit",
    );

    function beforeFilter() {
        parent::beforeFilter();
        $this->_setPageInfo("admin_index", "");
    }

    function admin_index() {
        $this->order = "SentItem.SendingDateTime desc";
        parent::admin_index();
    }

}
