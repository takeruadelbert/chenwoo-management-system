<?php

class SaleDetail extends AppModel {

    var $name = 'SaleDetail';
    var $belongsTo = array(
        "Product",
        "Sale",
        "McWeight"
    );
    var $hasOne = array(
    );
    var $hasMany = array(
        "PackageDetail"
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
