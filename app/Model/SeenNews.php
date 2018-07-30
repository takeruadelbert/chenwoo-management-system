<?php

class SeenNews extends AppModel {

    public $validate = array(
    );
    
    public $belongsTo = array(
        "InternalNews",
        "Employee"
    );
    
    public $hasOne = array(
    );
    
    public $virtualFields = array(
    );

}
