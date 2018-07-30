<?php

class EmployeeDataLoanDetail extends AppModel {

    public $validate = array(
        'employee_data_loan_id' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus diisi'
        ),
        'paid_date' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus diisi'
        ),
        'cooperative_cash_id' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus dipilih'
        ),
    );
    public $belongsTo = array(
        "EmployeeDataLoan",
        "Creator" => [
            "className" => "Employee",
            "foreignKey" => "creator_id",
        ],
        "BranchOffice"
    );
    public $hasOne = array(
        "CooperativeTransactionMutation",
    );
    public $hasMany = array(
    );
    public $virtualFields = array(
    );

    function generateNomor($id) {
        $inc_id = 1;
        $m = date('n');
        $mRoman = romanic_number($m);
        $Y = date('Y');
        $testCode = "[0-9]{4}/ANSR-KOP/$mRoman/$Y";
        $lastRecord = $this->find('first', array("recursive" => -1, 'conditions' => array("not" => ["EmployeeDataLoanDetail.id" => $id], 'and' => array("EmployeeDataLoanDetail.coop_receipt_number regexp" => $testCode)), 'order' => array('EmployeeDataLoanDetail.coop_receipt_number' => 'DESC')));
        if (!empty($lastRecord)) {
            $current = explode("/", $lastRecord['EmployeeDataLoanDetail']['coop_receipt_number']);
            $inc_id += $current[0];
        }
        $inc_id = sprintf("%04d", $inc_id);
        $kode = "$inc_id/ANSR-KOP/$mRoman/$Y";
        $this->save(["id" => $id, "coop_receipt_number" => $kode]);
    }

    function paymentFromSalary($employeeId, $employeeSalaryId, $employeeTypeId) {
        $employeeSalaryLoans = ClassRegistry::init("EmployeeSalaryLoan")->find("all", [
            "conditions" => [
                "EmployeeSalaryLoan.employee_salary_id" => $employeeSalaryId,
                "EmployeeSalaryLoan.is_processed" => 0,
            ],
            "contain" => [
                "EmployeeDataLoan",
            ],
        ]);
        $factor = $employeeTypeId == 1 ? 4 : 1;
        foreach ($employeeSalaryLoans as $employeeSalaryLoan) {
            if ($employeeSalaryLoan["EmployeeSalaryLoan"]["is_processed"] == true) {
                continue;
            }
            $employeeDataLoan = $employeeSalaryLoan;
            $bungaPinjaman = $employeeDataLoan["EmployeeDataLoan"]["total_amount_loan"] - $employeeDataLoan["EmployeeDataLoan"]["amount_loan"];
            $bungaPembayaran = floor($bungaPinjaman / $employeeDataLoan["EmployeeDataLoan"]["installment_number"] / $factor);
            $loanRemaining = $employeeDataLoan["EmployeeDataLoan"]["remaining_loan"];
            $potongan = ceil($employeeDataLoan["EmployeeDataLoan"]["total_amount_loan"] / $employeeDataLoan["EmployeeDataLoan"]["installment_number"] / $factor);
            if ($potongan > $loanRemaining) {
                $potongan = $loanRemaining;
            }
            $paidAmount = $potongan;
            $dataEmployeeDataLoanDetail = [
                "employee_data_loan_id" => $employeeDataLoan["EmployeeDataLoan"]["id"],
                "amount" => $paidAmount,
                "total_amount_loan" => $employeeDataLoan["EmployeeDataLoan"]["total_amount_loan"],
                "remaining_loan" => $loanRemaining - $paidAmount,
                "note" => "*Potongan Gaji",
                "installment_of" => $employeeDataLoan["EmployeeDataLoan"]["total_installment_paid"] + 1,
                "branch_office_id" => $this->stnAdmin->getBranchId(),
            ];
            $dataEmployeeDataLoan = [
                "id" => $employeeDataLoan["EmployeeDataLoan"]["id"],
                "total_installment_paid" => $employeeDataLoan["EmployeeDataLoan"]["total_installment_paid"] + 1,
                "remaining_loan" => $loanRemaining - $paidAmount,
            ];
            $this->EmployeeDataLoan->save($dataEmployeeDataLoan);
            $this->create();
            $this->save($dataEmployeeDataLoanDetail);
            $insertedId = $this->getLastInsertID();
            //update employee_salary_loan
            ClassRegistry::init("EmployeeSalaryLoan")->save([
                "EmployeeSalaryLoan" => [
                    "id" => $employeeSalaryLoan["EmployeeSalaryLoan"]["id"],
                    "employee_data_loan_detail_id" => $insertedId,
                    "is_processed" => 1,
                ],
            ]);
            $this->generateNomor($insertedId);
            $employeeDataLoanDetail = $this->find("first", [
                "conditions" => [
                    "EmployeeDataLoanDetail.id" => $insertedId,
                ],
                "recursive" => -1,
            ]);
            $entity = $employeeDataLoanDetail["EmployeeDataLoanDetail"];
            //update to cooperative cash
            $modelCooperativeTransactionMutation = ClassRegistry::init("CooperativeTransactionMutation");
            $modelCooperativeTransactionMutation->addMutation(_KAS_KASBON_KOPERASI, $entity["id"], "ANSR", $entity["amount"], date("Y-m-d H:i:s"));
            //update to cooperative entry
            ClassRegistry::init("CooperativeEntry")->addManual(ClassRegistry::init("CooperativeEntryType")->getIdByCode(102), $bungaPembayaran, date("Y-m-d H:i:s"), $modelCooperativeTransactionMutation->getLastInsertID());
        }
    }

}
