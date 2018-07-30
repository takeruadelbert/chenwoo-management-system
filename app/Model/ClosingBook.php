<?php

class ClosingBook extends AppModel {

    public $validate = array(
    );
    public $belongsTo = array(
        "ClosingBookType",
        "Employee",
        'GeneralEntryType'
    );
    public $hasOne = array(
    );
    public $hasMany = array(
    );
    public $virtualFields = array(
    );

}
