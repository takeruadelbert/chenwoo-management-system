<?php

class ProductDetailTreatmentDetail extends AppModel {

    var $name = 'ProductDetailTreatmentDetail';
    var $belongsTo = array(
        "ProductDetail",
        "TreatmentDetail",
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
