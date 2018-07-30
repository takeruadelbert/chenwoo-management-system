<?php

class OrderMaterialAdditional extends AppModel {

    var $name = 'OrderMaterialAdditional';
    var $belongsTo = array(
        "Employee",
        "MaterialAdditionalSupplier",
    );
    var $hasOne = array(
    );
    var $hasMany = array(   
        "OrderMaterialAdditionalDetail"
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
