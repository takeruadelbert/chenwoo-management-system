<?php

class AttendanceMachine extends AppModel {

    var $name = 'AttendanceMachine';
    var $belongsTo = array(
    );
    var $hasOne = array(
    );
    var $hasMany = array(
        "AttendanceEmployeeUid" => array(
            "dependent" => true
        ),
    );
    var $validate = array(
    );
    var $virtualFields = array(
        "label" => "concat(name,' - ',ipv4)",
    );

    function beforeValidate($options = array()) {
        
    }

    function deleteData($id = null) {
        return $this->delete($id);
    }

}

?>
