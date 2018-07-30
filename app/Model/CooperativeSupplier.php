<?php

class CooperativeSupplier extends AppModel {

    var $name = 'CooperativeSupplier';
    var $belongsTo = array(
        "City",
        "State",
        "CooperativeSupplierType",
    );
    var $hasOne = array(
    );
    var $hasMany = array(
    );
    var $validate = array(
        'name' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus diisi'
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
