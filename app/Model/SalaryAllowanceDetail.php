<?php

class SalaryAllowanceDetail extends AppModel {

    public $validate = array(
    );
    
    public $belongsTo = array(
        "ParameterSalary",
    );
    
    public $hasOne = array(
    );
    
    public $hasMany=array(
    );
    
    public $virtualFields = array(
    );

}
