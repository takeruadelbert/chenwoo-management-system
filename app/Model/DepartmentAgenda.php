<?php

class DepartmentAgenda extends AppModel {

    var $name = 'DepartmentAgenda';
    var $belongsTo = array(
        "Department",
    );
    var $hasOne = array(
    );
    var $hasMany = array(
    );
    var $validate = array(
        "department_id" => [
            "rule" => "notEmpty",
            'message' => "Harus Dipilih"
        ],
        "title" => [
            "rule" => "notEmpty",
            "message" => "Harus Diisi"
        ],
        "start" => [
            "rule" => "notEmpty",
            "message" => "Harus Diisi"
        ],
        "end" => [
            "rule" => "notEmpty",
            "message" => "Harus Diisi"
        ]
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
