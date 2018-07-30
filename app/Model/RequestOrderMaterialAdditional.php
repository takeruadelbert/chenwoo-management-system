<?php

class RequestOrderMaterialAdditional extends AppModel {

    var $name = 'RequestOrderMaterialAdditional';
    var $belongsTo = array(
        "RequestOrderMaterialAdditionalStatus",
        "Employee",
        'VerifiedBy' => array(
            'className' => 'Employee',
            'foreignKey' => 'verified_by_id',
        ),
        "BranchOffice"
    );
    var $hasOne = array(
    );
    var $hasMany = array(
        "RequestOrderMaterialAdditionalDetail",
        "PurchaseOrderMaterialAdditional"
    );
    var $validate = array(
        'ro_number' => array(
            'rule' => 'notEmpty',
            'message' => 'Hasur diisi'
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
