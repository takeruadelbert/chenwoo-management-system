<?php

App::uses('AppController', 'Controller');

class CooperativeLoanHoldsController extends AppController {

    var $name = "CooperativeLoanHolds";
    var $disabledAction = array(
    );
    var $contain = [
        "EmployeeDataLoan" => [
            "Employee" => [
                "Account" => [
                    "Biodata",
                ],
            ],
        ],
        "Creator" => [
            "Account" => [
                "Biodata",
            ],
        ],
    ];

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
        $this->set("employeeDataLoans", ClassRegistry::init("EmployeeDataLoan")->groupedList());
    }

    function admin_index() {
        $this->_activePrint(func_get_args(), "cooperative-loan-hold");
        parent::admin_index();
    }

}
