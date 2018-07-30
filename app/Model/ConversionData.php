<?php

class ConversionData extends AppModel {

    var $name = 'ConversionData';
    var $belongsTo = array(
        "Material",
        "ProductSize",
        "MaterialSize",
        "MaterialDetail",
        "RejectedGradeType"
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
