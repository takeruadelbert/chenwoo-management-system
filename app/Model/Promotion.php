<?php

class Promotion extends AppModel {

    var $name = 'Promotion';
    var $belongsTo = array(
        "PromotionType",
        "PromotionStatus",
        "Employee",
        "CurrentOffice" => array(
            "className" => "Office",
            "foreignKey" => "current_office_id",
        ),
        "Chief" => array(
            "className" => "Employee",
            "foreignKey" => "chief_id",
        ),
    );
    var $hasOne = array(
    );
    var $hasMany = array(
    );
    var $validate = array(
        'promotion_type_id' => array(
            'rule' => 'notEmpty',
            'message' => 'Hasur dipilih'
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
