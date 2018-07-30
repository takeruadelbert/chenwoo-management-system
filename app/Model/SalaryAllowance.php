<?php

class SalaryAllowance extends AppModel {

    public $validate = array(
       'employee_id' => array(
            'Harus diisi' => array("rule" => "notEmpty"),
            'Sudah terdaftar' => array("rule" => 'isUnique'),
        )
    );
    
    public $belongsTo = array(
        "Employee",
    );
    
    public $hasOne = array(
    );
    
    public $hasMany=array(
        "SalaryAllowanceDetail",
    );
    
    public $virtualFields = array(
    );

}
