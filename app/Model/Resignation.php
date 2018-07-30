<?php

class Resignation extends AppModel {

    var $name = 'Resignation';
    var $belongsTo = array(
        "ResignationType",
        "Employee",
        "VerifyStatus",
        "VerifiedBy" => [
            "className" => "Employee",
            "foreignKey" => "verified_by_id"
        ],
    );
    var $hasOne = array(
    );
    var $hasMany = array(
    );
    var $validate = array(
        'employee_id' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus diisi'
        ),
        'resignation_type_id' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus dipilih'
        ),
        'resignation_note' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus diisi'
        ),
        'resignation_date' => array(
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
