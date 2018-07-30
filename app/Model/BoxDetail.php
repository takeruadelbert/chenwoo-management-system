<?php

class BoxDetail extends AppModel {

    var $name = 'BoxDetail';
    var $belongsTo = array(
        "PackageDetail"
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
