<?php

class CooperativeRemainingOperationDetail extends AppModel {

    public $validate = array(
    );
    
    public $belongsTo = array(
        "Employee",
        "CooperativeRemainingOperation",
        "VerifyStatus",
        "VerifiedBy" => [
            "className" => "Employee",
            "foreignKey" => "verified_by_id"
        ],
    );
    
    public $hasOne = array(
    );
    
    public $virtualFields = array(
    );
    
    public $hasMany = array(
    );
}
