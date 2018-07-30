<?php

class ShipmentAgentBank extends AppModel {

    var $belongsTo = array(
        "ShipmentAgent"
    );
    var $hasOne = array(
    );
    var $hasMany = array(
    );
    var $validate = array(
        'bank_name' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus diisi'
        ),
        'bank_code' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus diisi'
        ),
        'bank_branch' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus diisi'
        ),
        'on_behalf' => array(
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
