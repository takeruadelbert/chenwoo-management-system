<?php

class DebitInvoicePurchaser extends AppModel {

    public $validate = array(
        'transaction_entry_id' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus diisi'
        ),
        'initial_balance_id' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus diisi'
        ),
        'amount' => array(
            'rule' => array('comparison', '>', 0),
            'message' => 'Input tidak boleh 0'
        ),
    );
    public $belongsTo = array(
        "TransactionEntry",
        "InitialBalance",
        "VerifyStatus",
        "VerifiedBy" => [
            "className" => 'Employee',
            "foreignKey" => "verified_by_id"
        ],
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
