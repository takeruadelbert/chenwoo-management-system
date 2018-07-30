<?php

class WorkingHourType extends AppModel {

    var $name = 'WorkingHourType';
    var $belongsTo = array(
        
    );
    var $hasOne = array(
    );
    var $hasMany = array(
        "WorkingHourTypeDetail" => array(
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
