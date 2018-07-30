<?php

class EmployeeSalary extends AppModel {

    var $belongsTo = array(
        "Employee",
        "InitialBalance",
//        "VerifyStatus",
//        'VerifiedBy' => array(
//            'className' => 'Employee',
//            'foreignKey' => 'verified_by_id',
//        ),
        "ValidateStatus",
        'ValidateBy' => array(
            'className' => 'Employee',
            'foreignKey' => 'validate_by_id',
        ),
        'MadeBy' => array(
            'className' => 'Employee',
            'foreignKey' => 'made_by_id',
        ),
        "EmployeeSalaryCashierStatus",
        "EmployeeSalaryPeriod",
        "CashierOperator" => array(
            'className' => 'Employee',
            'foreignKey' => 'cashier_operator_id'
        )
    );
    var $hasOne = array(
        "Notification" => array(
            "dependent" => true
        ),
        "TransactionMutation" => array(
            "dependent" => true
        ),
        "EmployeeSalaryInfo" => array(
            "dependent" => true
        ),
        "EmployeeSalaryItemLoan",
    );
    var $hasMany = array(
        "ParameterEmployeeSalary" => array(
            "dependent" => true
        ),
        "GeneralEntry",
        "EmployeeSalaryLoan",
        "EmployeeSalarySaleProductAdditional",
    );
    var $validate = array(
//        'verify_status_id' => array(
//            'rule' => 'notEmpty',
//            'message' => 'Harus diisi'
//        ),
        'validate_status_id' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus diisi'
        ),
        'made_by_id' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus diisi'
        ),
        'employee_id' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus diisi'
        ),
//        'note' => array(
//            'rule' => 'notEmpty',
//            'message' => 'Harus diisi'
//        ),
        'month_period' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus diisi'
        ),
        'year_period' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus diisi'
        ),
//        "initial_balance_id" => array(
//            'rule' => 'notEmpty',
//            'message' => "Harus Diisi"
//        )
    );
    var $virtualFields = array(
    );

    function beforeValidate($options = array()) {
        
    }

    function deleteData($id = null) {
        return $this->delete($id);
    }

    function generateSalaryNumber($employee_type_id, $employee_salary_id) {
        $employeeType = "";
        $inc_id = 1;
        $m = date('m');
        $mRoman = romanic_number($m);
        $Y = date('Y');
        if ($employee_type_id == 1) {
            $employeeType = "HARIAN";
        } else {
            $employeeType = "BULANAN";
        }
        $testCode = "$employeeType/GAJI/$mRoman/$Y/[0-9]{4}";
        $lastRecord = $this->find('first', array("recursive" => -1, 'conditions' => array("not" => ["EmployeeSalary.id" => $employee_salary_id], 'and' => array("EmployeeSalary.salary_number regexp" => $testCode)), 'order' => array('EmployeeSalary.salary_number' => 'DESC')));
        if (!empty($lastRecord)) {
            $current = explode("/", $lastRecord['EmployeeSalary']['salary_number']);
            $inc_id += $current[4];
        }
        $inc_id = sprintf("%04d", $inc_id);
        $kode = "$employeeType/GAJI/$mRoman/$Y/$inc_id";
        $this->save(["id" => $employee_salary_id, "salary_number" => $kode]);
        return $kode;
    }

}
