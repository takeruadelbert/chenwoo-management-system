<?php

class Sale extends AppModel {

    var $name = 'Sale';
    var $belongsTo = array(
        "Buyer",
        "BranchOffice",
        "ShipmentPaymentType",
        "PackagingStatus" => [
            "className" => "ProductionCommonStatus",
            "foreignKey" => "packaging_status_id",
        ],
        "VerifyStatus",
        "VerifiedBy" => [
            "className" => "Employee",
            "foreignKey" => "verified_by_id",
        ],
    );
    var $hasOne = array(
        "Shipment" => array(
            "dependent" => true
        ),
    );
    var $hasMany = array(
        "SaleDetail" => array(
            "dependent" => true
        ),
        "PaymentSale" => array(
            "dependent" => true
        ),
        "Box" => array(
            "dependent" => true
        ),
        "SaleFile" => array(
            "dependent" => true
        ),
        "GeneralEntry" => array(
            "dependent" => true
        ),
        "Package" => array(
            "dependent" => true
        ),
        "PackageDetail" => [
            "dependent" => true,
        ],
        "MaterialAdditionalPerContainer"
    );
    var $validate = array(
        'buyer_id' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus dipilih'
        ),
    );
    var $virtualFields = array(
    );

    function beforeValidate($options = array()) {
        
    }

    function deleteData($id = null) {
        return $this->delete($id);
    }

    function checkPackagingStatus($saleId = null) {
        $countUnfinished = $this->PackageDetail->find("count", [
            "conditions" => [
                "PackageDetail.sale_id" => $saleId,
                "PackageDetail.is_filled" => 0,
            ],
        ]);
        if ($countUnfinished <= 0) {
            $this->save([
                "Sale" => [
                    "id" => $saleId,
                    "packaging_status_id" => 2,
                ]
            ]);
        }
    }

}

?>
