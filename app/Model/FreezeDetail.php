<?php

class FreezeDetail extends AppModel {

    public $validate = array(
    );
    
    public $belongsTo = array(
        "Product",
        "RejectedGradeType",
        "MaterialEntryGrade",
        "Freeze"
    );
    
    public $hasOne = array(
    );
    
    public $virtualFields = array(
    );
    
    public $hasMany = array(
        "TreatmentSourceDetail"
    );
}
