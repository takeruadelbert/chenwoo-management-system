<?php

class PaymentPurchase extends AppModel {

    var $name = 'PaymentPurchase';
    var $belongsTo = array(
        "TransactionEntry",
        "PaymentType",
        "InitialBalance",
        "BranchOffice",
        "VerifyStatus",
        'VerifiedBy' => array(
            'className' => 'Employee',
            'foreignKey' => 'verified_by_id',
        ),
        "Employee"
    );
    var $hasOne = array(
        "TransactionMutation"
    );
    var $hasMany = array(
        "GeneralEntry"
    );
    var $validate = array(
        'transaction_entry_id' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus diisi'
        ),
        'payment_type_id' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus dipilih'
        ),
        'amount' => array(
            'rule' => array('comparison', '>', 0),
            'message' => 'Harus diisi'
        ),
        'initial_balance_id' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus diisi'
        ),
        'payment_date' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus diisi'
        ),
        'note' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus Diisi'
        )
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
