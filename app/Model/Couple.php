<?php

class Couple extends AppModel {

    public $validate = array(
    );
    public $belongsTo = array(
        "Religion",
        "MaritalStatus"
    );
    public $hasOne = array(
    );
    public $virtualFields = array(
       
    );

}
