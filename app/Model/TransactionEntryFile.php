<?php

class TransactionEntryFile extends AppModel {


    var $name = 'TransactionEntryFile';
    var $belongsTo = array(
        "TransactionEntry",
        "AssetFile",
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
