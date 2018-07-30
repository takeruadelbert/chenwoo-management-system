<?php

class ParameterEmployeeSalary extends AppModel {
    var $belongsTo = array(
        "ParameterSalary",
        "EmployeeSalary",
    );
    var $hasOne = array(
    );
    var $hasMany = array(
    );
    var $validate = array(
        'nominal' => array(
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
