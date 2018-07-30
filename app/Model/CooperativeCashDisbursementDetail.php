<?php

class CooperativeCashDisbursementDetail extends AppModel {

    public $validate = array(
        'amount' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus diisi'
        ),
    );
    
    public $belongsTo = array(
        "CooperativeGoodList",
        "CooperativeCashDisbursement",
    );
    
    public $hasOne = array(
    );
    
    public $virtualFields = array(
    );
    
    public $hasMany = array(
        
    );
}
