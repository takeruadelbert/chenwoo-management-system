<?php

class AttendanceEmployeeUid extends AppModel {

    var $name = 'AttendanceEmployeeUid';
    var $belongsTo = array(
        "AttendanceMachine",
        "Employee",
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
