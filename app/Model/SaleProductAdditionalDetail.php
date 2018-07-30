<?php

class SaleProductAdditionalDetail extends AppModel {

    var $name = 'SaleProductAdditionalDetail';
    var $belongsTo = array(
        "ProductAdditional",
        "SaleProductAdditional"
    );
    var $hasOne = array(
    );
    var $hasMany = array(
    );
    var $validate = array(
        'nominal' => array(
            'rule' => array('comparison', '>', 0),
            'message' => 'Harus dipilih'
        ),
        'weight' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus dipilih'
        ),
        'product_additional_id' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus dipilih'
        ),
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
