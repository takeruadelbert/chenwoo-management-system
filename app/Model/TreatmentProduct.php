<?php

class TreatmentProduct extends AppModel {

    var $name = 'TreatmentProduct';
    var $belongsTo = array(
        "ProductUnit",
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
