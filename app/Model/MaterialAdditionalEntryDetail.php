<?php

class MaterialAdditionalEntryDetail extends AppModel {

    var $name = 'MaterialAdditionalEntryDetail';
    var $belongsTo = array(
        "MaterialAdditionalEntry",
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
