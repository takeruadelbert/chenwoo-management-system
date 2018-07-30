<?php

App::uses('AppController', 'Controller');

class EmployeeBalancesController extends AppController {

    var $name = "EmployeeBalances";
    var $disabledAction = array(
        "admin_add",
        "admin_edit",
        "admin_multiple_delete",
    );
    var $contain = [
        "Employee" => [
            "Account" => [
                "Biodata",
            ],
        ],
    ];

    function beforeFilter() {
        parent::beforeFilter();
        $this->_setPageInfo("admin_index", "");
    }

    function admin_index() {
        $this->_activePrint(func_get_args(), "data_saldo_simpanan_pegawai");
        parent::admin_index();
    }

    function cron_calculate_interest() {
        $employeeBalances = $this->EmployeeBalance->find("all", [
            "recursive" => 1,
        ]);
        $interestRates = ClassRegistry::init("CooperativeDeposit")->find("all", [
            "recursive" => -1,
        ]);
        $totalDay = date('z', strtotime(date("Y") . "-12-31")) + 1;
        $modelEmployeeDataDeposit = ClassRegistry::init("EmployeeDataDeposit");
        $modelCooperativeDepositInterest = ClassRegistry::init("CooperativeDepositInterest");
        foreach ($employeeBalances as $employeeBalance) {
            $currentRate = $this->_getInterestRate($employeeBalance["EmployeeBalance"]["amount"], $interestRates);
            $interest = number_format($currentRate / 100 / $totalDay * $employeeBalance["EmployeeBalance"]["amount"], 0);
            if ($interest == 0 || $modelCooperativeDepositInterest->hasAny(["employee_balance_id" => $employeeBalance["EmployeeBalance"]["id"], "t" => date("Y-m-d")])) {
                continue;
            }
            $dataEmployeeDataDeposit = [
                "EmployeeDataDeposit" => [
                    "deposit_io_type_id" => 3,
                    "employee_id" => $employeeBalance["EmployeeBalance"]["employee_id"],
                    "amount" => $interest,
                    "deposit_previous_balance" => $employeeBalance["EmployeeBalance"]["amount"],
                    "transaction_date" => date("Y-m-d H:i:s"),
                    "verify_status_id" => 3,
                ]
            ];
            $modelEmployeeDataDeposit->create();
            $modelEmployeeDataDeposit->save($dataEmployeeDataDeposit);
            $employeeDataDepositId = $modelEmployeeDataDeposit->getLastInsertID();
            $dataCooperativeDepositInterest = [
                "CooperativeDepositInterest" => [
                    "employee_balance_id" => $employeeBalance["EmployeeBalance"]["id"],
                    "interest_rate" => $currentRate,
                    "interest" => $interest,
                    "t" => date("Y-m-d"),
                    "employee_data_deposit_id" => $employeeDataDepositId,
                    "balance" => $employeeBalance["EmployeeBalance"]["amount"],
                ],
            ];
            $modelCooperativeDepositInterest->create();
            $modelCooperativeDepositInterest->save($dataCooperativeDepositInterest);
            $cooperativeDepositInterestId = $modelEmployeeDataDeposit->getLastInsertID();
            $this->EmployeeBalance->topupBalanceByEmployeeDataDeposit($cooperativeDepositInterestId, $interest);
        }
        die;
    }

    function _getInterestRate($balance, $interestRates) {
        $rate = 0;
        foreach ($interestRates as $interestRate) {
            if ($balance >= $interestRate["CooperativeDeposit"]["bottom_limit"] && $balance <= $interestRate["CooperativeDeposit"]["upper_limit"]) {
                $rate = $interestRate["CooperativeDeposit"]["interest"];
            }
        }
        return $rate;
    }
}
