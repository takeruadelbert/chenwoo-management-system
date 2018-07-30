<?php

class ParameterSalary extends AppModel {
    var $belongsTo = array(
        "ParameterSalaryType",
    );
    var $hasOne = array(
    );
    var $hasMany = array(
        "ParameterEmployeeSalary"=> [
            "dependent" => true,
        ],
    );
    var $validate = array(
        'name' => array(
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
    
    
    function translateCodeToId($code) {
        $parameterSalary = $this->find("first", [
            "conditions" => [
                "ParameterSalary.code" => $code,
            ],
            "recursive" => -1,
        ]);
        if (empty($parameterSalary)) {
            return null;
        } else {
            return $parameterSalary["ParameterSalary"]["id"];
        }
    }

}
