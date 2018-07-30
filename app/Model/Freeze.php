<?php

class Freeze extends AppModel {

    public $validate = array(
//        'initial_balance_id' => array(
//            'rule' => 'notEmpty',
//            'message' => 'Harus diisi'
//        ),
    );
    public $belongsTo = array(
        "Employee",
        "MaterialEntry",
        "VerifyStatus",
        "VerifiedBy" => [
            "className" => "Employee",
            "foreignKey" => "verified_by_id"
        ],
        "Conversion",
        "BranchOffice",
        "Operator" => [
            "className" => "Employee",
            "foreignKey" => "operator_id",
        ],
        "MaterialEntryGrade",
        "ValidateStatus",
        "ValidateBy" => [
            "className" => "Employee",
            "foreignKey" => "validate_by_id"
        ],
    );
    public $hasOne = array(
        "Treatment"
    );
    public $virtualFields = array(
    );
    public $hasMany = array(
        "FreezeDetail" => array(
            "dependent" => true
        ),
        "FreezeSourceDetail" => array(
            "dependent" => true
        ),
        "Treatment"
    );

}
