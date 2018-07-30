<?php

class EmployeeSalaryPeriod extends AppModel {

    var $name = 'EmployeeSalaryPeriod';
    var $belongsTo = array(
        "CreateBy" => [
            "className" => "Employee",
            "foreignKey" => "create_by_id",
        ],
        "KnownBy" => [
            "className" => "Employee",
            "foreignKey" => "known_by_id",
        ],
        "KnownStatus" => [
            "className" => "EmployeeSalaryPeriodStatus",
            "foreignKey" => "known_status_id",
        ],
        "VerifyBy" => [
            "className" => "Employee",
            "foreignKey" => "verify_by_id",
        ],
        "VerifyStatus" => [
            "className" => "EmployeeSalaryPeriodStatus",
            "foreignKey" => "verify_status_id",
        ],
        "ApproveBy" => [
            "className" => "Employee",
            "foreignKey" => "approve_by_id",
        ],
        "ApproveStatus" => [
            "className" => "EmployeeSalaryPeriodStatus",
            "foreignKey" => "approve_status_id",
        ],
    );
    var $hasOne = array(
    );
    var $hasMany = array(
        "EmployeeSalary" => [
            "dependent" => true,
        ],
    );
    var $validate = array(
        'start_dt' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus diisi'
        ),
        'end_dt' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus diisi'
        ),
    );
    var $virtualFields = array();

    function beforeValidate($options = array()) {
        
    }

    function deleteData($id = null) {
        return $this->delete($id);
    }

}

?>
