<?php

class AnnualPermit extends AppModel {

    var $name = 'AnnualPermit';
    var $belongsTo = array(
    );
    var $hasOne = array(
    );
    var $hasMany = array(
    );
    var $validate = array(
        'year' => array(
            'Sudah disetup' => array("rule" => 'isUnique'),
            'Harus dipilih' => array("rule" => 'notEmpty'),
        ),
        'quota' => array(
            'Harus diisi' => array("rule" => 'notEmpty'),
        ),
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
