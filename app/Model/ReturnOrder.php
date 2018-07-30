<?php

class ReturnOrder extends AppModel {

    var $name = 'ReturnOrder';
    var $belongsTo = array(
        "MaterialEntry",
        "ReturnOrderStatus",
        "Employee",
        "BranchOffice"
    );
    var $hasOne = array(
        "TransactionMutation"
    );
    var $hasMany = array(   
        "ReturnOrderDetail",
        "GeneralEntry"
    );
    var $validate = array(
        "material_entry_id"=>[
            'rule' => 'notEmpty',
            'message' => 'Harus Dipilih!'
        ]
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
