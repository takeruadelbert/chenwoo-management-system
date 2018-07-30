<?php

class MaterialAdditionalReturn extends AppModel {

    var $name = 'MaterialAdditionalReturn';
    var $belongsTo = array(
        "Employee",
        "BranchOffice",
        "VerifyStatus",
        "VerifiedBy" => [
            "className" => "Employee",
            "foreignKey" => "verified_by_id"
        ],
        "MaterialAdditionalPerContainer"
    );
    var $hasOne = array(
    );
    var $hasMany = array(
        "MaterialAdditionalReturnDetail"
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
