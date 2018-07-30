<?php

class PermitCategory extends AppModel {

    var $name = 'PermitCategory';
    var $belongsTo = array(
    );
    var $hasOne = array(
    );
    var $hasMany = array(
        "PermitType",
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
