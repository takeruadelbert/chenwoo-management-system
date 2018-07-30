<?php

class IndividualAgenda extends AppModel {

    var $name = 'IndividualAgenda';
    var $belongsTo = array(
        "Employee",
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
