<?php

class MaterialEntryGradeDetail extends AppModel {

    var $name = 'MaterialEntryGradeDetail';
    var $belongsTo = array(
        "Conversion",
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
