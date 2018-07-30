<?php

class MaterialAdditionalOut extends AppModel {

    var $name = 'MaterialAdditionalOut';
    var $belongsTo = array(
        "Employee",
        "MaterialAdditional",
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
