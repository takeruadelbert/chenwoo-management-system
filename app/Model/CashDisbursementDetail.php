<?php

class CashDisbursementDetail extends AppModel {

    public $validate = array(
    );
    
    public $belongsTo = array(
        "AssetFile",
        "GeneralEntryType"
    );
    
    public $hasOne = array(
    );
    
    public $virtualFields = array(
    );
    
    public $hasMany = array(
        
    );
}
