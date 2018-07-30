<?php

class ProductData extends AppModel {

    var $name = 'ProductData';
    var $belongsTo = array(
        "TransactionEntry",
        "ProductSize",
        "ProductStatus"
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
