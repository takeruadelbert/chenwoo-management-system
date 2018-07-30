<?php

class GoodType extends AppModel {

    var $name = 'GoodType';
    var $belongsTo = array(
        "Parent" => [
            "foreignKey" => "parent_id",
            "className" => "GoodType",
        ],
    );
    var $hasOne = array(
    );
    var $hasMany = array(
    );
    var $validate = array(
        'name' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus diisi'
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
