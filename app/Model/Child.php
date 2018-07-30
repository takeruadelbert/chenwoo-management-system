<?php

class Family extends AppModel {

    public $validate = array(
    );
    public $belongsTo = array(
        "Religion",
        "MaritalStatus",
        "LifeStatus",
        "Gender",
        "Education",
        "FamilyRelation"
    );
    public $hasOne = array(
    );
    public $virtualFields = array(
       
    );

}
