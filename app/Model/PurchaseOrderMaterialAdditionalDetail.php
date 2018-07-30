<?php

class PurchaseOrderMaterialAdditionalDetail extends AppModel {

    var $name = 'PurchaseOrderMaterialAdditionalDetail';
    var $belongsTo = array(
        "PurchaseOrderMaterialAdditional",
        "MaterialAdditional"
    );
    var $hasOne = array(
    );
    var $hasMany = array(   
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
