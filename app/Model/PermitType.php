<?php

class PermitType extends AppModel {

    var $name = 'PermitType';
    var $belongsTo = array(
        "PermitCategory",
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
