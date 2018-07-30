<?php

class SaleProductAdditional extends AppModel {

    var $name = 'SaleProductAdditional';
    var $belongsTo = array(
        "CooperativeCash",
        "InitialBalance",
        "Employee",
        "Purchaser" => [
            "foreignKey" => "purchaser_id",
            "className" => "Employee",
        ],
        "BranchOffice",
        "PaymentStatus",
        "PaymentType"
    );
    var $hasOne = array(
        "CooperativeTransactionMutation",
        "TransactionMutation"
    );
    var $hasMany = array(
        "SaleProductAdditionalDetail" => array(
            "dependent" => true
        ),
        "GeneralEntry" => array(
            "dependent" => true
        )
    );
    var $validate = array(
        'initial_balance_id' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus dipilih'
        ),
//        'coopeartive_cash_id' => array(
//            'rule' => 'notEmpty',
//            'message' => 'Harus dipilih'
//        ),
        'purchaser_id' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus diisi'
        ),
        'payment_type_id' => array(
            'rule' => 'notEmpty',
            'message' => 'Harud Dipilih'
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