<?php

class CooperativeGoodListDetail extends AppModel {

    var $name = 'CooperativeGoodListDetail';
    var $belongsTo = array(
        "CooperativeGoodList"
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
