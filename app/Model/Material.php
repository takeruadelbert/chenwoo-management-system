<?php

class Material extends AppModel {

    var $name = 'Material';
    var $belongsTo = array(
        "MaterialCategory",
    );
    var $hasOne = array(
    );
    var $hasMany = array(   
        "MaterialDetail"
    );
    var $validate = array(
        "material_category_id"=>[
            'rule' => 'notEmpty',
            'message' => 'Harus Dipilih!'
        ]
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
