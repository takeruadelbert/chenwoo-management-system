<?php

class Shipment extends AppModel {

    var $name = 'Shipment';
    var $belongsTo = array(
        "ShipmentStatus",
        "Sale",
        "ShipmentAgent"
    );
    var $hasOne = array(
        "TransactionMutation",
        "ProductHistory"
    );
    var $hasMany = array(     
        "ShipmentMaterial" => array(
            "dependent" => true
        ),
        "GeneralEntry" => array(
            "dependent" => true
        )
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
