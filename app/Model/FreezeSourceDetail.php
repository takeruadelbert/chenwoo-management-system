<?php

class FreezeSourceDetail extends AppModel {

    var $name = 'FreezeSourceDetail';
    var $belongsTo = array(
        "Freeze",
        "MaterialEntryGrade",
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
