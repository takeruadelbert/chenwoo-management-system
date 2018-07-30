<?php

class ProductMaterialAdditional extends AppModel {

    var $name = 'ProductMaterialAdditional';
    var $belongsTo = array(
        "Product",
        "MaterialAdditional",
        "MaterialAdditionalCategory",
        "McWeight",
    );
    var $hasOne = array(
    );
    var $hasMany = array(
    );
    var $validate = array(
        'product_id' => array(
            'Harus dipilih' => 'notEmpty',
        ),
        'material_additional_id' => array(
            'Harus dipilih' => 'notEmpty',
        ),
        'mc_weight_id' => array(
            'Harus dipilih' => 'notEmpty',
        ),
        'quantity' => array(
            'Harus diisi' => 'notEmpty',
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
