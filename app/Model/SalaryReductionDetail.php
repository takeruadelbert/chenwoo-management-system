<?php

class SalaryReductionDetail extends AppModel {

    public $validate = array(
    );
    public $belongsTo = array(
        "SalaryReduction",
        "Employee",
    );
    public $hasOne = array(
    );
    public $hasMany = array(
    );

}
