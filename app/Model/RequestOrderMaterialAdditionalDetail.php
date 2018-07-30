<?php

class RequestOrderMaterialAdditionalDetail extends AppModel {

    var $name = 'RequestOrderMaterialAdditionalDetail';
    var $belongsTo = array(
        "RequestOrderMaterialAdditional",
        "MaterialAdditional"
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
