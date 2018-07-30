<?php

class ProductDetail extends AppModel {

    var $name = 'ProductDetail';
    var $belongsTo = array(
        "Product",
        "BranchOffice",
        "MaterialEntry"
    );
    var $hasOne = array(
    );
    var $hasMany = array(
        "ProductDetailTreatmentDetail",
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
