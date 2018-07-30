<?php

class PurchaseOrderMaterialAdditionalStatus extends AppModel {

    var $name = 'PurchaseOrderMaterialAdditionalStatus';
    var $belongsTo = array(
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
