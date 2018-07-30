<?php

class EmployeeSignature extends AppModel {

    public $validate = array(
    );
    
    public $belongsTo = array(
        "AssetFile",
    );
    
    public $hasOne = array(
    );
    
    public $virtualFields = array(
    );

}
