<?php

class ProductAdditional extends AppModel {

    var $name = 'ProductAdditional';
    var $belongsTo = array(
    );
    var $hasOne = array(
    );
    var $hasMany = array(
    );
    var $validate = array(
//        'price' => array(
//            'rule' => array('comparison', '>', 0),
//            'message' => 'Harus diisi lebih dari 0'
//        ),
//        'default_price' => array(
//            'rule' => array('comparison', '>', 0),
//            'message' => 'Harus diisi lebih dari 0'
//        ),
        'name' => array(
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
