<?php

class WorkingHourTypeDetail extends AppModel {

    var $name = 'WorkingHourTypeDetail';
    var $belongsTo = array(
        "Day",
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
