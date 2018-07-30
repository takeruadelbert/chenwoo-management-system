<?php

class CooperativeCashReceiptDetail extends AppModel {

    var $name = 'CooperativeCashReceiptDetail';
    var $belongsTo = array(
        "CooperativeGoodList",
        "CooperativeCashReceipt",
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
