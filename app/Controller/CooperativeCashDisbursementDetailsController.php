<?php

App::uses('AppController', 'Controller');

class CooperativeCashDisbursementDetailsController extends AppController {

    var $name = "CooperativeCashDisbursementDetails";
    var $disabledAction = array(
    );
    var $contain = [
        "CooperativeCashDisbursement" => [
            "Creator" => [
                "Account" => [
                    "Biodata",
                ],
            ],
            "BranchOffice"
        ],
        "CooperativeGoodList" => [
            "CooperativeGoodListUnit"
        ],
    ];

    function beforeFilter() {
        parent::beforeFilter();
        $this->_setPageInfo("admin_index", "");
        $this->_setPageInfo("admin_add", "");
        $this->_setPageInfo("admin_edit", "");
    }

    function _options() {
        
    }

    function beforeRender() {
        $this->set("branchOffices", ClassRegistry::init("BranchOffice")->find("list", array("fields" => array("BranchOffice.id", "BranchOffice.name"))));
        parent::beforeRender();
    }
    
    function admin_index() {
        $this->_activePrint(func_get_args(), "cooperative-cash-disbursement-detail");
        $this->periodeLaporanField="CooperativeCashDisbursement_created_date";
        parent::admin_index();
    }

}
