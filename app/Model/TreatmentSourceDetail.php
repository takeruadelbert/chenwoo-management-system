<?php

class TreatmentSourceDetail extends AppModel {

    var $name = 'TreatmentSourceDetail';
    var $belongsTo = array(
        "Product",
        "Treatment",
        "FreezeDetail"
    );
    var $hasOne = array(
    );
    var $hasMany = array(
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
