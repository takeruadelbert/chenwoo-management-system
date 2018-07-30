<?php

class MaterialAdditionalEntry extends AppModel {

    var $name = 'MaterialAdditionalEntry';
    var $belongsTo = array(
        "Employee",
        "MaterialAdditionalSupplier",
        "PurchaseOrderMaterialAdditional",
    );
    var $hasOne = array(
        //"TransactionMutation"
    );
    var $hasMany = array(
        "MaterialAdditionalEntryDetail",
//        "GeneralEntry",
//        "PaymentPurchaseMaterialAdditional"
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
