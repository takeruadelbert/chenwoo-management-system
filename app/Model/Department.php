<?php

class Department extends AppModel {

    var $name = 'Department';
    var $belongsTo = array(
        "Parent" => [
            "className" => "Department",
            "foreignKey" => "parent_id"
        ],
        "DepartmentType"
    );
    var $hasOne = array(
    );
    var $hasMany = array(
        "Child" => [
            "className" => "Department",
            "foreignKey" => "parent_id",
        ]
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
