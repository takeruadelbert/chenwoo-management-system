<?php

class CashMutation extends AppModel {

    public $validate = array(
        'nominal' => array(
            'rule' => array('comparison', '>', 0),
            'message' => 'Input tidak boleh 0'
        ),
        'cash_transfered_id' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus diisi'
        ),
        'cash_received_id' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus diisi'
        ),
    );
    public $belongsTo = array(
        "CashTransfered" => [
            "className" => "InitialBalance",
            "foreignKey" => "cash_transfered_id"
        ],
        "CashReceived" => [
            "className" => "InitialBalance",
            "foreignKey" => "cash_received_id"
        ],
        "Creator" => [
            "className" => "Employee",
            "foreignKey" => "creator_id"
        ],
    );
    public $hasOne = array(        
    );
    public $hasMany = array(
        "GeneralEntry",
        "TransactionMutation"
    );
    public $virtualFields = array(
    );

}
