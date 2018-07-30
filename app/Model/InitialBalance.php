<?php

class InitialBalance extends AppModel {

    public $validate = array(
        'name' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus diisi'
        ),
        'initial_date' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus diisi'
        ),
//        'bank_account_id' => array(
//            'rule' => 'notEmpty',
//            'message' => 'Harus diisi'
//        ),
        'currency_id' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus diisi'
        ),
    );
    public $belongsTo = array(
        "GeneralEntryType",
        "BankAccount",
        "BranchOffice",
        "Currency"
    );
    public $hasMany = array(
    );
    public $hasOne = array(
    );
    public $virtualFields = array(
    );

}
