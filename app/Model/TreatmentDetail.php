<?php

class TreatmentDetail extends AppModel {

    public $validate = array(
        'product' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus dipilih'
        ),
    );
    public $belongsTo = array(
        "Product",
        "Treatment",
        "RejectedGradeType"
    );
    public $hasOne = array(
    );
    public $virtualFields = array(
       
    );
    public $hasMany = array(
    );
}
