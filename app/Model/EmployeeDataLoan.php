<?php

class EmployeeDataLoan extends AppModel {

    public $validate = array(
        'cooperative_cash_id' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus dipilih'
        ),
        'employee_id' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus diisi'
        ),
        'cooperative_loan_type_id' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus diisi'
        ),
        'amount_loan' => array(
            'rule' => array('comparison', '>', 0),
            'message' => 'Input tidak boleh 0'
        ),
        'installment_number' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus dipilih'
        ),
        'acquaintance' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus diisi'
        ),
        'assurance' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus diisi'
        ),
    );
    public $belongsTo = array(
        "Employee",
        "Creator" => [
            "foreignKey" => "creator_id",
            "className" => "Employee",
        ],
        "CooperativeLoanInterest",
        "CooperativeCash",
        "CooperativeLoanType",
        "VerifyStatus",
        "VerifiedBy" => [
            "foreignKey" => "verified_by_id",
            "className" => "Employee"
        ],
        "BranchOffice"
    );
    public $hasOne = array(
        "CooperativeTransactionMutation"
    );
    public $hasMany = array(
        "EmployeeDataLoanDetail" => array(
            "dependent" => true
        ),
        "CooperativeLoanHold",
    );
    public $virtualFields = array(
    );

    function generateNomor($id) {
        $inc_id = 1;
        $m = date('n');
        $mRoman = romanic_number($m);
        $Y = date('Y');
        $currentRecord = $this->find("first", [
            "conditions" => [
                "EmployeeDataLoan.id" => $id,
            ],
            "recursive" => -1
        ]);
        if ($currentRecord["EmployeeDataLoan"]["cooperative_loan_type_id"] == 1) {
            $codeType = "PNJB";
        } else {
            $codeType = "PNJU";
        }
        $code = $testCode = "[0-9]{4}/$codeType-KOP/$mRoman/$Y";
        $lastRecord = $this->find('first', array("recursive" => -1, 'conditions' => array("not" => ["EmployeeDataLoan.id" => $id], 'and' => array("EmployeeDataLoan.receipt_loan_number regexp" => $testCode)), 'order' => array('EmployeeDataLoan.receipt_loan_number' => 'DESC')));
        if (!empty($lastRecord)) {
            $current = explode("/", $lastRecord['EmployeeDataLoan']['receipt_loan_number']);
            $inc_id += $current[0];
        }
        $inc_id = sprintf("%04d", $inc_id);
        $kode = "$inc_id/$codeType-KOP/$mRoman/$Y";
        $this->save(["id" => $id, "receipt_loan_number" => $kode]);
    }

    function groupedList() {
        $result = [];
        $raw = [];
        $employeeDataLoans = $this->find("all", [
            "conditions" => [
                "EmployeeDataLoan.remaining_loan > 0",
            ],
            "recursive" => -1,
        ]);
        foreach ($employeeDataLoans as $employeeDataLoan) {
            $raw[$employeeDataLoan["EmployeeDataLoan"]["employee_id"]][$employeeDataLoan["EmployeeDataLoan"]["id"]] = $employeeDataLoan["EmployeeDataLoan"]["receipt_loan_number"] . " (Sisa Pinjaman : " . ic_rupiah($employeeDataLoan["EmployeeDataLoan"]["remaining_loan"]) . ")";
        }
        $employeeModel = ClassRegistry::init("Employee");
        foreach ($raw as $employeeId => $meat) {
            $employee = $employeeModel->find("first", [
                "conditions" => [
                    "Employee.id" => $employeeId,
                ],
                "contain" => [
                    "Account" => [
                        "Biodata",
                    ],
                ],
            ]);
            $result[$employee["Account"]["Biodata"]["full_name"] . " | " . $employee["Employee"]["nip"]] = $meat;
        }
        return $result;
    }

}
