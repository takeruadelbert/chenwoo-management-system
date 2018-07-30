<?php

class Box extends AppModel {

    var $name = 'Box';
    var $belongsTo = array(
        "Sale"
    );
    var $hasOne = array(
    );
    var $hasMany = array(
        "BoxDetail" => array(
            "dependent" => true
        ),
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
