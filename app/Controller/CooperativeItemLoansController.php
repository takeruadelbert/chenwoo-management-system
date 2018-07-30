<?php

App::uses('AppController', 'Controller');

class CooperativeItemLoansController extends AppController {

    var $name = "CooperativeItemLoans";
    var $disabledAction=array(
        "admin_add",
        "admin_edit",
        "admin_multiple_delete",
    );
    
    function beforeFilter() {
        parent::beforeFilter();
        $this->_setPageInfo("admin_index", "");
        $this->_setPageInfo("admin_add", "");
        $this->_setPageInfo("admin_edit", "");
    }
    
    function admin_index() {
        $this->_activePrint(func_get_args(), "cooperative-item-loan");
        $this->contain=[
            "Employee"=>[
                "Account"=>[
                    "Biodata"
                ],
            ],
        ];
        parent::admin_index();
    }
}
