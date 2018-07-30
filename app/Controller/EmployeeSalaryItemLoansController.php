<?php

App::uses('AppController', 'Controller');

class EmployeeSalaryItemLoansController extends AppController {

    var $name = "EmployeeSalaryItemLoans";
    var $disabledAction = array(
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
        $this->_activePrint(func_get_args(), "data_potongan_gaji_sembako");
        $this->_setPeriodeLaporanDate("awal_EmployeeSalary_EmployeeSalaryPeriod_start_dt", "akhir_EmployeeSalary_EmployeeSalaryPeriod_end_dt");
        $this->contain = [
            "EmployeeSalary" => [
                "Employee" => [
                    "Account" => [
                        "Biodata",
                    ],
                ],
                "EmployeeSalaryPeriod",
            ],
            "CooperativeItemLoanPaymentDetail",
            "CooperativeItemLoan",
        ];
        $this->conds = [
            "EmployeeSalary.employee_salary_cashier_status_id" => 2,
        ];
        parent::admin_index();
    }

}
