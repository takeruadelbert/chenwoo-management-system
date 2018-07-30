<?php

class OutgoingMailFile extends AppModel {

    var $name = 'OutgoingMailFile';
    var $belongsTo = array(
        "AssetFile",
        "OutgoingMail",
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
