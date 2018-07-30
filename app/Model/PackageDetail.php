<?php

class PackageDetail extends AppModel {

    var $name = 'PackageDetail';
    var $belongsTo = array(
        "Product" => [
            "Parent"
        ],
        "Package",
        "TreatmentDetail",
        "Sale",
        "Creator" => [
            "className" => "PackageDetail",
            "foreignKey" => "creator_id"
        ],
        "BranchOffice",
        "ProductDetail",
        "SaleDetail" => [
            "counterCache" => true,
        ]
    );
    var $hasOne = array(
    );
    var $hasMany = array(
        "PackageDetailProduct"
    );
    var $validate = array(
        "nett_weight" => [
            'rule' => 'notEmpty',
            'message' => 'Harus Diisi!'
        ],
        "brut_weight" => [
            'rule' => 'notEmpty',
            'message' => 'Harus Diisi!'
        ],
        "quantity_per_pack" => [
            'rule' => 'notEmpty',
            'message' => 'Harus Diisi!'
        ]
    );
    var $virtualFields = array(
    );

    function beforeValidate($options = array()) {
        
    }

    function deleteData($id = null) {
        return $this->delete($id);
    }

    function generatePackageDetail($saleId = false) {
        $sale = $this->Sale->find("first", [
            "conditions" => [
                "Sale.id" => $saleId,
            ],
            "contain" => [
                "SaleDetail",
            ],
        ]);
        foreach ($sale["SaleDetail"] as $saleDetail) {
            for ($i = 1; $i <= $saleDetail["quantity"]; $i++) {
                $this->create();
                $packageDetail = [
                    "sale_id" => $sale["Sale"]["id"],
                    "sale_detail_id" => $saleDetail["id"],
                    "product_id" => $saleDetail["product_id"],
                    "branch_office_id" => $sale["Sale"]["branch_office_id"],
                ];
                $this->save($packageDetail);
                $this->generatePackageCode($this->getLastInsertID());
            }
        }
    }

    function generatePackageCode($packageDetailId = false) {
        $packageDetail = $this->find("first", [
            "conditions" => [
                "PackageDetail.id" => $packageDetailId,
            ],
            "contain" => [
                "BranchOffice",
            ],
        ]);
        $inc_id = 1;
        $y = date('y');
        $y = dechex($y);
        $n = date('n');
        $n = dechex($n);
        $testCode = $y . $n . "[0-9a-fA-F]{5}";
        $lastRecord = $this->find('first', array('conditions' => array("not" => ["PackageDetail.id" => $packageDetailId], 'and' => array("PackageDetail.package_no regexp" => $testCode)), 'order' => array('PackageDetail.package_no' => 'DESC')));
        if (!empty($lastRecord)) {
            $current = substr($lastRecord["PackageDetail"]["package_no"], 3, 5);
            $inc_id += hexdec($current);
        }
        $inc_id = strtoupper(dechex($inc_id));
        $inc_id = sprintf("%05s", $inc_id);
        $kode = $y . $n . $inc_id;
        $this->save(["id" => $packageDetailId, "package_no" => $kode]);
        return $kode;
    }

}

?>
