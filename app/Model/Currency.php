<?php

class Currency extends AppModel {

    var $name = 'Currency';
    var $belongsTo = array(
    );
    var $hasOne = array(
    );
    var $hasMany = array(
    );
    var $validate = array(
        "name" => [
            "rule" => "notEmpty",
            "message" => "Harus Diisi"
        ],
        "uniq_name" => [
            "rule" => "notEmpty",
            "message" => "Harus Diisi"
        ]
    );
    var $virtualFields = array(
        "currency" => 'CONCAT(Currency.uniq_name, " - ", Currency.name)'
    );

    function beforeValidate($options = array()) {
        
    }

    function deleteData($id = null) {
        return $this->delete($id);
    }

}

?>
