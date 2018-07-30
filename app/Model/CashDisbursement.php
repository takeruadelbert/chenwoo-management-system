<?php

class CashDisbursement extends AppModel {

    public $validate = array(
        'initial_balance_id' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus diisi'
        ),
        'note' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus diisi'
        ),
    );
    
    public $belongsTo = array(
        "Creator" => [
            "className" => 'Employee',
            "foreignKey" => "creator_id"
        ],
        "InitialBalance",
        "BranchOffice",
        "GeneralEntryType",
        "TransactionCurrencyType"
    );
    
    public $hasOne = array(
        "TransactionMutation"
    );
    
    public $virtualFields = array(
    );
    
    public $hasMany = array(
        "CashDisbursementDetail" => array(
            "dependent" => true
        ),
        "GeneralEntry"
    );
}
