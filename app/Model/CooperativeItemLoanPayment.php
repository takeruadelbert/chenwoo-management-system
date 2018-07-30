<?php

class CooperativeItemLoanPayment extends AppModel {

    var $name = 'CooperativeItemLoanPayment';
    var $belongsTo = array(
        "Creator" => [
            "className" => "Employee",
            "foreignKey" => "creator_id",
        ],
        "EmployeeType",
    );
    var $hasOne = array(
    );
    var $hasMany = array(
        "CooperativeItemLoanPaymentDetail" => [
            "dependent" => true,
        ],
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
