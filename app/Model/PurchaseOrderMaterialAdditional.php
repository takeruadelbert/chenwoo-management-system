<?php

class PurchaseOrderMaterialAdditional extends AppModel {

    var $name = 'PurchaseOrderMaterialAdditional';
    var $belongsTo = array(
        "PurchaseOrderMaterialAdditionalStatus",
        "Employee",
        "MaterialAdditionalSupplier",
        'VerifiedBy' => array(
            'className' => 'Employee',
            'foreignKey' => 'verified_by_id',
        ),
        "RequestOrderMaterialAdditional",
        "BranchOffice"
    );
    var $hasOne = array(
    );
    var $hasMany = array(
        "PurchaseOrderMaterialAdditionalDetail" => array(
            "dependent" => true
        ),
        "PaymentPurchaseMaterialAdditional" => array(
            "dependent" => true
        ),
        "MaterialAdditionalEntry" => array(
            "dependent" => true
        ),
    );
    var $validate = array(
        'pic_name' => array(
            'rule' => 'notEmpty',
            'message' => 'Hasur diisi'
        ),
        'pic_phone_number' => array(
            'rule' => 'notEmpty',
            'message' => 'Hasur diisi'
        ),
        'material_additional_supplier_id' => array(
            'rule' => 'notEmpty',
            'message' => 'Hasur dipilih'
        ),
        'po_number' => array(
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
