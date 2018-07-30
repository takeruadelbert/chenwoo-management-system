<?php

class MaterialAdditionalSaleDetail extends AppModel {

    var $name = 'MaterialAdditionalSaleDetail';
    var $belongsTo = array(
        "MaterialAdditional",
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
