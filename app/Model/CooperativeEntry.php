<?php

class CooperativeEntry extends AppModel {

    public $validate = array(
    );
    public $belongsTo = array(
        "CooperativeEntryType",
        "CooperativeTransactionMutation"
    );
    public $hasOne = array(
    );
    public $hasMany = array(
    );
    public $virtualFields = array(
    );

    public function addManual($cooperativeEntryTypeId, $amount, $dt, $cooperativeTransactionMutationId) {
        if ($cooperativeEntryTypeId != false) {
            $this->create();
            $this->save([
                "cooperative_entry_type_id" => $cooperativeEntryTypeId,
                "cooperative_transaction_mutation_id" => $cooperativeTransactionMutationId,
                "dt" => $dt,
                "amount" => $amount,
            ]);
        }
    }

    public function addForLoanPayment($employeeDataLoanDetailId) {
        $employeeDataLoanDetail = ClassRegistry::init("EmployeeDataLoanDetail")->find("first", [
            "conditions" => [
                "EmployeeDataLoanDetail.id" => $employeeDataLoanDetailId,
            ],
            "contain" => [
                "EmployeeDataLoan" => [
                    "Employee",
                ],
                "CooperativeTransactionMutation",
            ]
        ]);
        if ($employeeDataLoanDetail["EmployeeDataLoan"]["Employee"]["employee_type_id"] == 1) {
            $factor = 4;
        } else {
            $factor = 1;
        }
        $interest = ceil(($employeeDataLoanDetail["EmployeeDataLoan"]["total_amount_loan"] - $employeeDataLoanDetail["EmployeeDataLoan"]["amount_loan"]) / $employeeDataLoanDetail["EmployeeDataLoan"]["installment_number"] / $factor);
        if ($employeeDataLoanDetail["EmployeeDataLoanDetail"]["full_payment"]) {
            $interest = $employeeDataLoanDetail["EmployeeDataLoan"]["installment_number"] * $factor * $interest;
        }
        if ($employeeDataLoanDetail["EmployeeDataLoan"]["cooperative_loan_type_id"] == 1) {
            //pinjaman barang untuk penerimaan piutang
            $montlyPayment = $employeeDataLoanDetail["EmployeeDataLoanDetail"]["amount"] - $interest;
            $this->create();
            $this->save([
                "cooperative_entry_type_id" => $this->CooperativeEntryType->getIdByCode(103),
                "dt" => $employeeDataLoanDetail["EmployeeDataLoanDetail"]["paid_date"],
                "cooperative_transaction_mutation_id" => $employeeDataLoanDetail["CooperativeTransactionMutation"]["id"],
                "amount" => $montlyPayment,
            ]);
        }
        //update bunga pinjaman
        $this->create();
        $this->save([
            "cooperative_entry_type_id" => $this->CooperativeEntryType->getIdByCode(102),
            "dt" => $employeeDataLoanDetail["EmployeeDataLoanDetail"]["paid_date"],
            "cooperative_transaction_mutation_id" => $employeeDataLoanDetail["CooperativeTransactionMutation"]["id"],
            "amount" => $interest,
        ]);
    }

}
