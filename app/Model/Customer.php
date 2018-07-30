<?php

class Customer extends AppModel {

    public $validate = array(
        'first_name' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus diisi'
        ),
    );
    public $belongsTo = array(
        "Gender"
    );
    public $hasOne = array(
    );
    public $virtualFields = array(
        "full_name" => "trim(Trailing ',' from concat(gelar_depan,' ',first_name,' ',last_name,',',gelar_belakang))",
    );

}
