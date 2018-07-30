<?php

class AssetProperty extends AppModel {

    public $validate = array(
        'name' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus diisi'
        ),
        'nominal' => array(
            'rule' => array('comparison', '>', 0),
            'message' => 'Input tidak boleh 0'
        ),
        "initial_balance_id" => array(
            "rule" => 'notEmpty',
            'meesage' => 'Harus Diisi'
        ),
        "asset_property_type_id" => array(
            "rule" => "notEmpty",
            "message" => "Harus Diisi"
        ),
        "date" => [
            "rule" => "notEmpty",
            "message" => "Harus Diisi"
        ],
        'capital_id' => [
            'rule' => "notEmpty",
            'message' => "Harus Dipilih"
        ],
        "general_entry_type_id" => [
            "rule" => "notEmpty",
            "message" => "Harud Dipilih"
        ]
    );
    public $belongsTo = array(
        "GeneralEntryType",
        "InitialBalance",
        "AssetPropertyType",
        "SetupAssetType"
    );
    public $hasMany = array(
        "GeneralEntry"
    );
    public $hasOne = array(
        "TransactionMutation"
    );
}