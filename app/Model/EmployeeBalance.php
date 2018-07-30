<?php

class EmployeeBalance extends AppModel {

    var $name = 'EmployeeBalance';
    var $belongsTo = array(
        "Employee",
    );
    var $hasOne = array(
    );
    var $hasMany = array(
        "EmployeeDataDeposit" => [
            "dependent" => true,
        ],
    );
    var $validate = array(
    );
    var $virtualFields = array(
    );

    function beforeValidate($options = array()) {
        
    }

    function deleteData($id = null) {
        return $this->delete($id);
    }

    function createAccountNumber($employeeId = false) {
        $employeeBalance = $this->find("first", [
            "conditions" => [
                "EmployeeBalance.employee_id" => $employeeId,
            ],
            "recursive" => -1
        ]);
        if (empty($employeeBalance)) {
            $this->create();
            $this->save([
                "employee_id" => $employeeId,
                "amount" => 0,
                "account_number" => $this->generateAccountNumber(),
            ]);
        } else {
            
        }
    }

    function topupBalanceByEmployeeDataDeposit($employeeDataDepositId = false, $amount = 0) {
        $employeeDataDeposit = $this->EmployeeDataDeposit->find("first", [
            "conditions" => [
                "EmployeeDataDeposit.id" => $employeeDataDepositId,
            ]
        ]);
        $employeeId = $employeeDataDeposit["EmployeeDataDeposit"]["employee_id"];
        $employeeBalance = $this->find("first", [
            "conditions" => [
                "EmployeeBalance.employee_id" => $employeeId,
            ],
            "recursive" => -1
        ]);
        if (empty($employeeBalance)) {
            $this->create();
            $this->save([
                "employee_id" => $employeeId,
                "amount" => $amount,
                "account_number" => $this->generateAccountNumber(),
            ]);
            $previousBalance = 0;
            $employeeBalanceId = $this->getLastInsertID();
        } else {
            $this->save([
                "id" => $employeeBalance["EmployeeBalance"]["id"],
                "amount" => $amount + $employeeBalance["EmployeeBalance"]["amount"],
            ]);
            $previousBalance = $employeeBalance["EmployeeBalance"]["amount"];
            $employeeBalanceId = $employeeBalance["EmployeeBalance"]["id"];
        }
        $this->EmployeeDataDeposit->save([
            "id" => $employeeDataDeposit["EmployeeDataDeposit"]["id"],
            "deposit_previous_balance" => $previousBalance,
            "employee_balance_id" => $employeeBalanceId,
        ]);
    }

    function reduceBalanceByEmployeeDataDeposit($employeeDataDepositId = false, $amount = 0) {
        $employeeDataDeposit = $this->EmployeeDataDeposit->find("first", [
            "conditions" => [
                "EmployeeDataDeposit.id" => $employeeDataDepositId,
            ]
        ]);
        $employeeId = $employeeDataDeposit["EmployeeDataDeposit"]["employee_id"];
        $employeeBalance = $this->find("first", [
            "conditions" => [
                "EmployeeBalance.employee_id" => $employeeId,
            ],
            "recursive" => -1
        ]);
        $this->save([
            "id" => $employeeBalance["EmployeeBalance"]["id"],
            "amount" => $employeeBalance["EmployeeBalance"]["amount"] - $amount,
        ]);
        $previousBalance = $employeeBalance["EmployeeBalance"]["amount"];
        $employeeBalanceId = $employeeBalance["EmployeeBalance"]["id"];
        $this->EmployeeDataDeposit->save([
            "id" => $employeeDataDeposit["EmployeeDataDeposit"]["id"],
            "deposit_previous_balance" => $previousBalance,
        ]);
    }

    function generateAccountNumber() {
        $found = false;
        do {
            $number = mt_rand(10000000, 99999999);
            $found = !$this->hasAny(["account_number" => $number]);
        } while (!$found);
        return $number;
    }

}

?>
