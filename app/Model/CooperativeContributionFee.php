<?php

class CooperativeContributionFee extends AppModel {

    var $name = 'CooperativeContributionFee';
    var $belongsTo = array(
        "EmployeeType",
        "CooperativeContributionType",
    );
    var $hasOne = array(
    );
    var $hasMany = array(
    );
    var $validate = array(
        'employee_type_id' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus dipilih'
        ),
        'cooperative_contribution_type_id' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus dipilih'
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
