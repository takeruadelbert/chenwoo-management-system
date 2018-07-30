<?php

class RevaluationAsset extends AppModel {

    public $validate = array(
        'previous_nominal' => array(
            'rule' => array('comparison', '>', 0),
            'message' => 'Input tidak boleh 0'
        ),
        'revaluation_nominal' => array(
            'rule' => array('comparison', '>', 0),
            'message' => 'Input tidak boleh 0'
        ),
        "revaluation_date" => array(
            "rule" => 'notEmpty',
            'meesage' => 'Harus Diisi'
        ),
        "asset_property_id" => array(
            "rule" => "notEmpty",
            "message" => "Harus Diisi"
        )
    );
    public $belongsTo = array(
        "AssetProperty"
    );
    public $hasMany = array(
        "GeneralEntry"
    );
    public $hasOne = array(
//        "TransactionMutation"
    );
}