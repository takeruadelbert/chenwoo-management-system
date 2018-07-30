<?php

App::uses('AppController', 'Controller');

class InboxesController extends AppController {

    var $name = "Inboxes";
    var $disabledAction = array(
        "admin_add",
        "admin_edit",
    );

    function beforeFilter() {
        parent::beforeFilter();
        $this->_setPageInfo("admin_index", "");
    }

    function admin_index() {
        $this->order = "Inbox.ReceivingDateTime desc";
        parent::admin_index();
    }

}
