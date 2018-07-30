<?php

class MaterialAdditionalPerContainerDetail extends AppModel {

    var $name = 'MaterialAdditionalPerContainerDetail';
    var $belongsTo = array(
        "MaterialAdditionalPerContainer",
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
