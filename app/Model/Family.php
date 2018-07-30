<?php

class Family extends AppModel {

    public $validate = array(
    );
    public $belongsTo = array(
        "Gender",
        "Education",
        "Religion",
        "MaritalStatus",
        "LifeStatus",
        "FamilyRelation"
    );
    public $hasOne = array(
    );
    public $hasMany = array(
    );


}
