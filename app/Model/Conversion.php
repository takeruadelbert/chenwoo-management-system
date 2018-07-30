<?php

class Conversion extends AppModel {

    var $name = 'Conversion';
    var $belongsTo = array(
        "Employee",
        "MaterialEntry",
        "MaterialEntryGrade",
        "VerifyStatus",
        "VerifiedBy" => [
            "className" => "Employee",
            "foreignKey" => "verified_by_id"
        ],
        "BranchOffice",
        "RatioStatus" => [
            "className" => "ProductionCommonStatus",
            "foreignKey" => "ratio_status_id",
        ],
        "Operator" => [
            "className" => "Employee",
            "foreignKey" => "operator_id",
        ],
        "ValidateStatus",
        "ValidateBy" => [
            "className" => "Employee",
            "foreignKey" => "validate_by_id"
        ],
    );
    var $hasOne = array(
        "Freeze"
    );
    var $hasMany = array(
        "ConversionData" => array(
            "dependent" => true
        ),
        "MaterialEntryGradeDetail",
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

}

?>
