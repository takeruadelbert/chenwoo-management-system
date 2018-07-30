<?php

class TransferEmployee extends AppModel {

    var $name = 'TransferEmployee';
    var $belongsTo = array(
        "TransferEmployeeType",
        "Employee",
        "Department",
        "BranchOffice",
        "OriginBranchOffice" => [
            "className" => "BranchOffice",
            "foreignKey" => "origin_branch_office_id",
        ],
        "OriginOffice" => [
            "className" => "Office",
            "foreignKey" => "origin_office_id",
        ],
        "OriginDepartment" => [
            "className" => "Department",
            "foreignKey" => "origin_department_id",
        ],
        "Office",
        "VerifyStatus",
        'VerifiedBy' => array(
            'className' => 'Employee',
            'foreignKey' => 'verified_by_id',
        ),
    );
    var $hasOne = array(
    );
    var $hasMany = array(
    );
    var $validate = array(
        'employee_id' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus diisi'
        ),
        'transfer_employee_type_id' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus dipilih'
        ),
    );
    var $virtualFields = array(
    );

    function beforeValidate($options = array()) {
        
    }

    function deleteData($id = null) {
        return $this->delete($id);
    }

}

?>
