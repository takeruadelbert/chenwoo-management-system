<?php

class Tax extends AppModel {

    public $validate = array(
        'percentage' => array(
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

}
