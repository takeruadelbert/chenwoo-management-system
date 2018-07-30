<?php

class CooperativeDeposit extends AppModel {

    public $validate = array(
        'upper_limit' => array(
            'rule' => array('comparison', '>', 0),
            'message' => 'Input tidak boleh 0'
        ),
        'interest' => array(
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
