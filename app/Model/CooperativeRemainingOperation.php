<?php

class CooperativeRemainingOperation extends AppModel {

    public $validate = array(
        'date' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus diisi'
        ),
    );
    
    public $belongsTo = array(
    );
    
    public $hasOne = array(
    );
    
    public $virtualFields = array(
    );
    
    public $hasMany = array(
        "CooperativeRemainingOperationDetail" => array(
            "dependent" => true
        ),
    );
}
