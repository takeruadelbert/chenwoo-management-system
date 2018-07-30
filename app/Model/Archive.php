<?php

class Archive extends AppModel {

    public $validate = array(
       'name' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus diisi'
        )
    );
    
    public $belongsTo = array(
        'DocumentType',
        "AssetFile",
        "Employee",
        'ArchiveSlot',
        "Department",
//        "ArchiveShareStatus",
    );
    
    public $hasOne = array(
    );
    
    public $hasMany=array(
//        "ArchiveShare"=>[
//            "dependent"=>true
//        ],
    );
    
    public $virtualFields = array(
    );

}
