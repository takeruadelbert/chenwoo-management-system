<?php

class VerifyStatus extends AppModel {
    var $belongsTo = array(
    );
    var $hasOne = array(
    );
    var $hasMany = array(
//        "EmployeeSalary"=> [
//            "dependent" => true,
//        ],
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

}
