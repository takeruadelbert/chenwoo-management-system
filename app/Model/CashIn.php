<?php

class CashIn extends AppModel {

    public $validate = array(
        'amount' => array(
            'rule' => array('comparison', '>', 0),
            'message' => 'Input tidak boleh 0'
        ),
        'initial_balance_id' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus dipilih'
        ),
//        'earning_type_id' => array(
//            'rule' => 'notEmpty',
//            'message' => 'Harus Dipilih'
//        ),
        'note' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus Diisi'
        )
    );
    public $belongsTo = array(
        "InitialBalance",
        "Creator" => [
            "className" => "Employee",
            "foreignKey" => "creator_id"
        ],
        "GeneralEntryType",
        "BranchOffice"
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
