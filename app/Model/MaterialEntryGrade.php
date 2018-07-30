<?php

class MaterialEntryGrade extends AppModel {

    var $name = 'MaterialEntryGrade';
    var $belongsTo = array(
        "MaterialDetail",
        "MaterialSize",
        "MaterialEntry"
    );
    var $hasOne = array(
    );
    var $hasMany = array(
        "MaterialEntryGradeDetail" => array(
            "dependent" => true
        ),
        "Conversion" => array(
            "dependent" => true
        ),
        "FreezeDetail" => array(
            "dependent" => true
        ),
    );
    var $validate = array(
        "basket" => [
            'rule' => 'notEmpty',
            'message' => 'Harus Diisi!'
        ],
    );
    var $virtualFields = array(
        "basket_name" => "concat('Basket ', basket)"
    );

    function beforeValidate($options = array()) {
        
    }

    function deleteData($id = null) {
        return $this->delete($id);
    }

}

?>
