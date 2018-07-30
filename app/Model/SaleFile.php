<?php

class SaleFile extends AppModel {

    public $validate = array(
    );
    
    public $belongsTo = array(
        "Sale",
        "AssetFile",
    );
    
    public $hasOne = array(
    );
    
    public $virtualFields = array(
    );
    
    public $hasMany = array(
        
    );
}
