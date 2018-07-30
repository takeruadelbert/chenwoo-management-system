<?php

class MaterialDetail extends AppModel {

    var $name = 'MaterialDetail';
    var $belongsTo = array(
        "Unit",
        "Material"
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
