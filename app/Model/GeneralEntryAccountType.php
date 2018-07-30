<?php

class GeneralEntryAccountType extends AppModel {

    public $validate = array(
        'name' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus diisi'
        ),
        'uniq_name' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus diisi'
        ),
    );
    public $belongsTo = array(
    );
    public $hasOne = array(
    );
    public $virtualFields = array(
        "full_name" => "concat(GeneralEntryAccountType.uniq_name, ' (', GeneralEntryAccountType.name, ') ')"
    );

}
