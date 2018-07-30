<?php

class IncomingMailFile extends AppModel {

    var $name = 'IncomingMailFile';
    var $belongsTo = array(
        "AssetFile",
        "IncomingMail",
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
