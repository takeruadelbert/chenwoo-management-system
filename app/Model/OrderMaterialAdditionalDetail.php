<?php

class OrderMaterialAdditionalDetail extends AppModel {

    var $name = 'OrderMaterialAdditionalDetail';
    var $belongsTo = array(
        "OrderMaterialAdditional",
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
