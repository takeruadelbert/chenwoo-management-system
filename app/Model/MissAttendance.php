<?php

class MissAttendance extends AppModel {

    var $name = 'MissAttendance';
    var $belongsTo = array(
        "Employee",
        "Supervisor"=>[
            "className"=>"Employee",
            "foreignKey"=>"supervisor_id",
        ],
        "MissAttendanceStatus",
        "VerifyStatus",
        "VerifiedBy" => [
            "className" => "Employee",
            "foreignKey" => "verified_by_id"
        ],
        "ValidateStatus",
        "ValidateBy" => [
            "className" => "Employee",
            "foreignKey" => "validate_by_id"
        ],
        "AttendanceType",
    );
    var $hasOne = array(
        "Attendance"=>[
            "dependent"=>true,
        ],
    );
    var $hasMany = array(
    );
    var $validate = array(
        'miss_date' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus diisi'
        ),
        'miss_time' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus diisi'
        ),
        'attendance_type_id' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus dipilih'
        ),
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
