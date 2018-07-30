<?php

class ManualWorkingCount extends AppModel {

    var $name = 'ManualWorkingCount';
    var $belongsTo = array(
        "ManualWorkingCountType",
        "ManualWorkingCountStatus",
        "Employee",
    );
    var $hasOne = array(
    );
    var $hasMany = array(
    );
    var $validate = array(
        'manual_working_count_type_id' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus dipilih'
        ),
        'working_dt' => array(
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
