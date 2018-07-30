<?php

class DepartmentNews extends AppModel {

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
        "department_id" => array(
            "rule" => 'notEmpty',
            'message' => 'Harus Dipilih'
        )
    );
    
    public $belongsTo = array(
        "Employee",
        "Department"
    );
    
    public $hasOne = array(
    );
    
    public $hasMany = array(
//        "SeenDepartmentNews" => array(
//            "dependent" => true
//        )
    );
    
    public $virtualFields = array(
    );

}
