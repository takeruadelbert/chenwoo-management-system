<?php

App::uses('AppController', 'Controller');

class CooperativeCashReceiptDetailsController extends AppController {

    var $name = "CooperativeCashReceiptDetails";
    var $disabledAction = array(
    );
    var $contain = [
        "CooperativeCashReceipt" => [
            "Operator" => [
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
        $this->set("branchOffices", $this->CooperativeCashReceiptDetail->CooperativeCashReceipt->Operator->BranchOffice->find("list", array("fields" => array("BranchOffice.id", "BranchOffice.name"))));
        parent::beforeRender();
    }

    function admin_index() {
        $this->_activePrint(func_get_args(), "cooperative-cash-receipt-detail");
        $this->periodeLaporanField="CooperativeCashReceipt_date";
        parent::admin_index();
    }

}
