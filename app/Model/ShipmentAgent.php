<?php

class ShipmentAgent extends AppModel {

    public $validate = array(
    );
    public $belongsTo = array(
        "City",
        "State",
        "Country",
        "Employee"
    );
    public $hasOne = array(
    );
    public $hasMany = [
        "ShipmentAgentBank"
    ];
    public $virtualFields = array(
        
    );

}
