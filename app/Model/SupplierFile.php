<?php

class SupplierFile extends AppModel {

    public $validate = array(
    );
    
    public $belongsTo = array(
        "Supplier",
        "AssetFile",
    );
    
    public $hasOne = array(
    );
    
    public $virtualFields = array(
    );
    
    public $hasMany = array(
        
    );
}
