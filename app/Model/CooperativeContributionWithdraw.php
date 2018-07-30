<?php

class CooperativeContributionWithdraw extends AppModel {

    var $name = 'CooperativeContributionWithdraw';
    var $belongsTo = array(
        "Employee",
    );
    var $hasOne = array(
    );
    var $hasMany = array(
    );
    var $validate = array(
        'employee_id' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus dipilih'
        ),
        'amount' => array(
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
