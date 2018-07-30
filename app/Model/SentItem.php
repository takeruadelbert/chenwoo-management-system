<?php

class SentItem extends AppModel {

    public $useDbConfig = 'gammu';
    public $useTable = 'sentitems';
    var $name = 'SentItem';
    var $belongsTo = array(
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
