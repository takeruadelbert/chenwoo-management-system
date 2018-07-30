<?php

class MaterialAdditionalReturnDetail extends AppModel {

    var $name = 'MaterialAdditionalReturnDetail';
    var $belongsTo = array(
        "MaterialAdditionalReturn",
        "MaterialAdditionalMc" => array (
            'className' => 'MaterialAdditional',
            'foreignKey' => 'material_additional_mc_id',
        ),
        'MaterialAdditionalPlastic' => array(
            'className' => 'MaterialAdditional',
            'foreignKey' => 'material_additional_plastic_id',
        ),
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
