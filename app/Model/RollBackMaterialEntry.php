<?php

class RollBackMaterialEntry extends AppModel {

    var $name = 'RollBackMaterialEntry';
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
