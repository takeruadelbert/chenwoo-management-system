<?php

class Package extends AppModel {

    var $name = 'Package';
    var $belongsTo = array(
        "Sale",
        "Employee",
        "BranchOffice"
    );
    var $hasOne = array(
    );
    var $hasMany = array(    
        "PackageDetail" => array(
            "dependent" => true
        ),
    );
    var $validate = array(
    );
    var $virtualFields = array(
    );

    function beforeValidate($options = array()) {
        
    }

    function deleteData($id = null) {
        return $this->delete($id);
    }

}

?>
