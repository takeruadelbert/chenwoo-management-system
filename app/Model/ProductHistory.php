<?php

class ProductHistory extends AppModel {

    var $name = 'ProductHistory';
    var $belongsTo = array(
        "ProductHistoryType",
        "Treatment",
        "Shipment",
        "Product"
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
    
    function postHistoryProduct($last_insert_id, $product_id , $weight, $history_datetime, $code) {
        $dataHistory = [];
        $dataHistory['ProductHistory']['weight'] = $weight;
        $dataHistory['ProductHistory']['history_datetime'] = $history_datetime;
        $dataHistory['ProductHistory']['product_id'] = $product_id;
        if($code == "MSK") {
            $dataHistory['ProductHistory']['treatment_id'] = $last_insert_id;
            $product_history_type_id = 1;
        } else {
            $dataHistory['ProductHistory']['shipment_id'] = $last_insert_id;
            $product_history_type_id = 2;
        }
        $dataHistory['ProductHistory']['product_history_type_id'] = $product_history_type_id;
        $this->saveAll($dataHistory);
    }
}
?>
