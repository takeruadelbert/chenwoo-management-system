<?php

class SalaryReduction extends AppModel {

    public $validate = array(
    );
    public $belongsTo = array(
        "ParameterSalary",
    );
    public $hasOne = array(
    );
    public $hasMany = array(
        "SalaryReductionDetail",
    );

}
