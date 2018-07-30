<?php

class PaymentSaleMaterialAdditional extends AppModel {

    var $name = 'PaymentSaleMaterialAdditional';
    var $belongsTo = array(
        "PaymentType",
        "MaterialAdditionalSale",
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
        'material_additional_sale_id' => array(
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
