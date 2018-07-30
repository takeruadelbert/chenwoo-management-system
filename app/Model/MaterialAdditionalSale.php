<?php

class MaterialAdditionalSale extends AppModel {

    var $name = 'MaterialAdditionalSale';
    var $belongsTo = array(
        "Employee",
        "BranchOffice",
        "ValidateStatus",
        "ValidateBy" => [
            "foreignKey" => "validate_by_id",
            "className" => "Employee"
        ],
        "Supplier"
    );
    var $hasOne = array(
    );
    var $hasMany = array(
        "MaterialAdditionalSaleDetail",
        "PaymentSaleMaterialAdditional"
    );
    var $validate = array(
        "sale_dt" => [
            "rule" => "notEmpty",
            "message" => "Harus Diisi"
        ],
        "supplier" => [
            "rule" => "notEmpty",
            "message" => "Harus Dipilih"
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
