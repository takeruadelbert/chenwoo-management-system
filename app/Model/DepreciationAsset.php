<?php

class DepreciationAsset extends AppModel {

    var $name = 'DepreciationAsset';
    public $validate = array(
        'duration' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus diisi'
        ),
        'depreciation_amount' => array(
            'rule' => array('comparison', '>', 0),
            'message' => 'Input tidak boleh 0'
        ),
        "asset_property_id" => array(
            "rule" => 'notEmpty',
            'meesage' => 'Harus Diisi'
        )
    );
    public $belongsTo = array(
        "AssetProperty",
        "GeneralEntryType"
    );
    public $hasMany = array(
        "GeneralEntry"
    );
    public $hasOne = array(
//        "TransactionMutation"
    );
}
