<?php

App::uses('AppController', 'Controller');

class CooperativeContributionFeesController extends AppController {

    var $name = "CooperativeContributionFees";
    var $disabledAction = array(
    );
    var $contain = [
        "EmployeeType",
        "CooperativeContributionType",
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

    function admin_index() {
        $this->_activePrint(func_get_args(), "data_biaya_iuran_anggota");
        parent::admin_index();
    }

    function _options() {
        $this->set("employeeTypes", $this->CooperativeContributionFee->EmployeeType->find("list", ["fields" => ["EmployeeType.id", "EmployeeType.name"]]));
        $this->set("cooperativeContributionTypes", $this->CooperativeContributionFee->CooperativeContributionType->find("list", ["fields" => ["CooperativeContributionType.id", "CooperativeContributionType.name"]]));
    }

}
