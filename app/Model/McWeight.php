<?php

class McWeight extends AppModel {

    var $name = 'McWeight';
    var $belongsTo = array(
    );
    var $hasOne = array(
    );
    var $hasMany = array(
    );
    var $validate = array(
    );
    var $virtualFields = array(
        "label_lbs"=>"concat(McWeight.lbs,' lbs')",
        "label_kg"=>"concat(McWeight.kg,' kg')",
    );

    function beforeValidate($options = array()) {
        
    }

    function deleteData($id = null) {
        return $this->delete($id);
    }

}

?>
