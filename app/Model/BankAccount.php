<?php

class BankAccount extends AppModel {

    public $validate = array(
        'bank_account_type_id' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus dipilih'
        ),
        'on_behalf' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus diisi'
        ),
        'code' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus diisi'
        ),
    );
    public $belongsTo = array(
        "BankAccountType"
    );
    public $hasOne = array(
    );
    public $virtualFields = array(
    );

}
