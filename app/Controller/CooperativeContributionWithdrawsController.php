<?php

App::uses('AppController', 'Controller');

class CooperativeContributionWithdrawsController extends AppController {

    var $name = "CooperativeContributionWithdraws";
    var $disabledAction = array(
    );
    var $contain = [
        "Employee" => [
            "Account" => [
                "Biodata"
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

    function admin_index() {
        $this->_activePrint(func_get_args(), "data_pengambilan_iuran");
        $this->_setPeriodeLaporanDate("awal_CooperativeContributionWithdraw_dt", "akhir_CooperativeContributionWithdraw_dt");
        parent::admin_index();
    }

    function _options() {
        
    }

    function admin_add($employeeId = null) {
        $this->loadModel("CooperativeContribution");
        $this->CooperativeContribution->virtualFields = [
            "total" => "sum(CooperativeContribution.amount)",
            "paid" => "select COALESCE(sum(CooperativeContributionWithdraw.amount),0) from cooperative_contribution_withdraws CooperativeContributionWithdraw where CooperativeContributionWithdraw.employee_id=CooperativeContribution.employee_id",
        ];
        if ($this->request->is("POST")) {
            $this->{ Inflector::classify($this->name) }->set($this->data);
            $this->CooperativeContributionWithdraw->data["CooperativeContributionWithdraw"]["dt"] = date("Y-m-d H:i:s");
            $this->CooperativeContributionWithdraw->_numberSeperatorRemover();
            $this->CooperativeContributionWithdraw->save($this->CooperativeContributionWithdraw->data);
            $this->Session->setFlash(__("Data berhasil disimpan"), 'default', array(), 'success');
            $this->redirect(array('action' => 'admin_rekap', "controller" => "CooperativeContributions"));
        }
        $this->data = $this->CooperativeContribution->find('first', array(
            "conditions" => [
                "CooperativeContribution.employee_id" => $employeeId,
            ],
            'contain' => [
                "Employee" => [
                    "Account" => [
                        "Biodata"
                    ],
                ],
            ],
            'group' => [
                "CooperativeContribution.employee_id"
            ]
        ));
    }

}
