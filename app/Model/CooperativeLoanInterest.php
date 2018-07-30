<?php

class CooperativeLoanInterest extends AppModel {

    public $validate = array(
        'interest' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus diisi',
        ),
        'cooperative_loan_type_id' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus dipilih',
        ),
        'upper_limit' => array(
            'rule' => array('comparison', '>', 0),
            'message' => 'Input tidak boleh 0',
        ),
    );
    public $belongsTo = array(
        "CooperativeLoanType",
    );
    public $hasOne = array(
    );
    public $virtualFields = array(
    );

}
