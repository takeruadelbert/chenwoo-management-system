<?php

class MaterialAdditionalPerContainer extends AppModel {

    var $name = 'MaterialAdditionalPerContainer';
    var $belongsTo = array(
        "Employee",
        "Sale",
        "VerifyStatus",
        "GudangStatus",
        "BranchOffice",
        "VerifiedBy" => [
            "className" => "Employee",
            "foreignKey" => "verified_by_id"
        ],
    );
    var $hasOne = array(
        "MaterialAdditionalReturn"
    );
    var $hasMany = array(
        "MaterialAdditionalPerContainerDetail"
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
