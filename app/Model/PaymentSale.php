<?php

class PaymentSale extends AppModel {

    var $name = 'PaymentSale';
    var $belongsTo = array(
        "PaymentType",
        "Sale",
        "InitialBalance",
        "Employee"
    );
    var $hasOne = array(
        "TransactionMutation"
    );
    var $hasMany = array(
        "GeneralEntry"
    );
    var $validate = array(
        'transaction_out_id' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus dipilih'
        ),
        'initial_balance_id' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus dipilih'
        ),
        'payment_type_id' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus dipilih'
        ),
        'amount' => array(
            'rule' => array('comparison', '>', 0),
            'message' => 'Input tidak boleh 0'
        ),
        'payment_date' => [
            "rule" => 'notEmpty',
            'message' => 'Harus Diisi'
        ],
        'note' => [
            "rule" => "notEmpty",
            "message" => "Harus Diisi"
        ]
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
