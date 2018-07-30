<?php

class ReturnOrderDetail extends AppModel {

    var $name = 'ReturnOrderDetail';
    var $belongsTo = array(
        "Conversion",
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
