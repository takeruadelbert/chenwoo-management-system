<?php

class ProductOpnameStock extends AppModel {

    var $name = 'ProductOpnameStock';
    var $belongsTo = array(
        "Product",
        "Employee",
        "BranchOffice",
        "ProductDetail"
    );
    var $hasOne = array(
    );
    var $hasMany = array(
    );
    var $validate = array(
        'product_id' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus diisi'
        ),
        'stock_number' => array(
            "notEmpty" => [
                'rule' => 'notEmpty',
                'message' => 'Harus diisi'
            ],
            "checkPositif" => [
                'rule' => array('comparison', '>=', 0),
                'message' => 'Harus lebih besar dari 0'
            ]
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
