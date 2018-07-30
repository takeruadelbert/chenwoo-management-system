<?php

class CooperativeCashOutDetail extends AppModel {

    public $validate = array(
    );
    
    public $belongsTo = array(
        "ExpenditureType",
        "AssetFile",
    );
    
    public $hasOne = array(
    );
    
    public $virtualFields = array(
    );
    
    public $hasMany = array(
        
    );
}
