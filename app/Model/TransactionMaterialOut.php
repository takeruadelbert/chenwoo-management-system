<?php

class TransactionMaterialOut extends AppModel {

    var $name = 'TransactionMaterialOut';
    var $belongsTo = array(
        "Package",
        "TransactionOut"
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
