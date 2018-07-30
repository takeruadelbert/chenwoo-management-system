<?php

class TransactionMaterialEntry extends AppModel {

    var $name = 'TransactionMaterialEntry';
    var $belongsTo = array(
        "MaterialDetail",
        "MaterialSize",
        "TransactionEntry"
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
