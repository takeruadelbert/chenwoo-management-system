<?php

class RetainedEarning extends AppModel {

    public $validate = array(
        'profit_and_loss_id' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus diisi'
        ),
        'nominal' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus diisi'
        ),
        'datetime' => array(
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
