<?php

class ProductSize extends AppModel {

    var $name = 'ProductSize';
    var $belongsTo = array(
        "ProductUnit",
        "Product"
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
