<?php

class DebitInvoicePurchaserMaterialAdditional extends AppModel {

    public $validate = array(
        'purchase_order_material_additional_id' => array(
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
        "PurchaseOrderMaterialAdditional",
        "InitialBalance",
        "VerifyStatus",
        "VerifiedBy" => [
            "className" => 'Employee',
            "foreignKey" => "verified_by_id"
        ],
        "BranchOffice"
    );
    public $hasOne = array(
    );
    public $virtualFields = array(
    );

}
