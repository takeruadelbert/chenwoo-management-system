<?php

class PaymentPurchaseMaterialAdditional extends AppModel {

    var $name = 'PaymentPurchaseMaterialAdditional';
    var $belongsTo = array(
        "PurchaseOrderMaterialAdditional",
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
        'purchase_order_material_additional_id' => array(
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
        'note' => [
            'rule' => 'notEmpty',
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
