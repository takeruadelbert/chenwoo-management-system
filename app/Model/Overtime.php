<?php

class Overtime extends AppModel {

    var $name = 'Overtime';
    var $belongsTo = array(
        "Employee",
        "ValidateStatus",
        "ValidateBy" => [
            "className" => "Employee",
            "foreignKey" => "validate_by_id"
        ],
    );
    var $hasOne = array(
    );
    var $hasMany = array(
    );
    var $validate = array(
        'overtime_date' => array(
            'rule' => 'notEmpty',
            'message' => 'Hasur diisi'
        ),
        'start_time' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus diisi'
        ),
        'end_time' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus diisi'
        ),
        "employee_id" => array(
            'rule' => 'notEmpty',
            'message' => 'Harus diisi'
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
