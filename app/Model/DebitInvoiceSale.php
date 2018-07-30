<?php

class DebitInvoiceSale extends AppModel {

    public $validate = array(
//        'initial_balance_id' => array(
//            'rule' => 'notEmpty',
//            'message' => 'Harus dipilih'
//        ),
        'amount' => array(
            'rule' => array('comparison', '>', 0),
            'message' => 'Input tidak boleh 0'
        ),        
    );
    public $belongsTo = array(
        "Sale",
        "InitialBalance",
        "VerifyStatus",
        "VerifiedBy" => [
            "className" => 'Employee',
            "foreignKey" => "verified_by_id"
        ],
    );
    public $hasOne = array(
        "TransactionMutation"
    );
    public $hasMany = array(
        "GeneralEntry"
    );
    public $virtualFields = array(
    );

}
