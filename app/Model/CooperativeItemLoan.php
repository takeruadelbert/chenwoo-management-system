<?php

class CooperativeItemLoan extends AppModel {

    var $name = 'CooperativeItemLoan';
    var $belongsTo = array(
        "Employee",
    );
    var $hasOne = array(
    );
    var $hasMany = array(
        "CooperativeItemLoanDetail",
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

    function addLoan($employeeId, $amount, $cooperativeCashReceiptId) {
        $cooperativeItemLoan = $this->find("first", [
            "conditions" => [
                "CooperativeItemLoan.employee_id" => $employeeId,
            ]
        ]);
        if (empty($cooperativeItemLoan)) {
            $this->save([
                "employee_id" => $employeeId,
                "total_loan" => 0,
                "paid" => 0,
                "remaining" => 0,
            ]);
            $cooperativeItemLoanId = $this->getLastInsertID();
            $totalLoan = 0;
            $remaining = 0;
        } else {
            $cooperativeItemLoanId = $cooperativeItemLoan["CooperativeItemLoan"]["id"];
            $totalLoan = $cooperativeItemLoan["CooperativeItemLoan"]["total_loan"];
            $remaining = $cooperativeItemLoan["CooperativeItemLoan"]["remaining"];
        }
        $this->saveAll([
            "CooperativeItemLoan" => [
                "id" => $cooperativeItemLoanId,
                "total_loan" => $totalLoan + $amount,
                "remaining" => $remaining + $amount,
            ],
            "CooperativeItemLoanDetail" => [
                [
                    "cooperative_cash_receipt_id" => $cooperativeCashReceiptId,
                    "amount" => $amount,
                    "cooperative_item_loan_id" => $cooperativeItemLoanId,
                ],
            ],
        ]);
    }

}

?>
