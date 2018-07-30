<?php

class CooperativeLoanHold extends AppModel {

    var $name = 'CooperativeLoanHold';
    var $belongsTo = array(
        "EmployeeDataLoan",
        "Creator" => [
            "className" => "Employee",
            "foreignKey" => "creator_id",
        ]
    );
    var $hasOne = array(
    );
    var $hasMany = array(
    );
    var $validate = array(
        'start_period' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus diisi'
        ),
        'end_period' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus diisi'
        ),
        'employee_data_loan_id' => array(
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
