<?php

class State extends AppModel {

    var $name = 'State';
    var $belongsTo = array(
//        "Country", //gunanya apa ya?
    );
    var $hasOne = array(
    );
    var $hasMany = array(
        "City"
    );
    var $validate = array(
    );
    var $virtualFields = array();

    function beforeValidate($options = array()) {
        
    }

    function deleteData($id = null) {
        return $this->delete($id);
    }

}

?>
