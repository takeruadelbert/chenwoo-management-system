<?php

class Office extends AppModel {

    var $name = 'Office';
    var $belongsTo = array(
        "Supervisor" => [
            "className" => "Office",
            "foreignKey" => "supervisor_id",
        ], 
        "Department"
    );
    var $hasOne = array(
    );
    var $hasMany = array(
    );
    var $validate = array(
        'name' => array(
            'Sudah terdaftar' => array("rule" => 'isUnique'),
        )
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
