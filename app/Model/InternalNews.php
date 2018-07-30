<?php

class InternalNews extends AppModel {

    public $validate = array(
        'title' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus diisi'
        ),
        'synopsis' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus diisi'
        ),
        'content' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus diisi'
        ),
    );
    
    public $belongsTo = array(
        "Employee",        
    );
    
    public $hasOne = array(
    );
    
    public $hasMany = array(
        "SeenNews" => array(
            "dependent" => true
        )
    );
    
    public $virtualFields = array(
    );

}
