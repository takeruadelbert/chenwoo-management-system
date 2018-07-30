<?php

class Treatment extends AppModel {

    public $validate = array(
    );
    public $belongsTo = array(
        "Freeze",
        "Employee",
        "VerifyStatus",
        "VerifiedBy" => [
            "className" => "Employee",
            "foreignKey" => "verified_by_id"
        ],
        "BranchOffice",
        "MaterialEntry",
        "Operator" => [
            "className" => "Employee",
            "foreignKey" => "operator_id"
        ],
        "ValidateStatus",
        "ValidateBy" => [
            "className" => "Employee",
            "foreignKey" => "validate_by_id"
        ],
    );
    public $hasOne = array(
        "ProductHistory"
    );
    public $virtualFields = array(
    );
    public $hasMany = array(
        "TreatmentDetail" => array(
            "dependent" => true
        ),
        "TreatmentSourceDetail" => array(
            "dependent" => true
        )
    );

}
