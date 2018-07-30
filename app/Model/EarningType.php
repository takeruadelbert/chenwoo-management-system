<?php

class EarningType extends AppModel {

    public $validate = array(
        'name' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus diisi'
        ),
    );
    public $belongsTo = array(
        "GeneralEntryType"
    );
    public $hasOne = array(
    );
    public $virtualFields = array(
    );

}
