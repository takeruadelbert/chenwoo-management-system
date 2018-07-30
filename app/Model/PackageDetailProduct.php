<?php

class PackageDetailProduct extends AppModel {

    var $name = 'PackageDetailProduct';
    var $belongsTo = array(
        "PackageDetail",
        "ProductDetail"
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
                $this->generateTrackCode($this->getLastInsertID());
            }
        }
    }

    function generateTrackCode($packageDetailId = false) {
        $packageDetail = $this->find("first", [
            "conditions" => [
                "PackageDetail.id" => $packageDetailId,
            ],
            "contain" => [
                "BranchOffice",
            ],
        ]);
        $inc_id = 1;
        $packerCode = $packageDetail["BranchOffice"]["packer_code"];
        $y = date('y');
        $m = date('m');
        $d = date('d');
        $testCode = "[0-9]{5}" . $packerCode . $d . $m . $y;
        $lastRecord = $this->find('first', array('conditions' => array("not" => ["PackageDetail.id" => $packageDetailId], 'and' => array("PackageDetail.package_no regexp" => $testCode)), 'order' => array('PackageDetail.package_no' => 'DESC')));
        if (!empty($lastRecord)) {
            $current = substr($lastRecord["PackageDetail"]["package_no"], 0, 5);
            $inc_id += $current;
        }
        $inc_id = sprintf("%05d", $inc_id);
        $kode = $inc_id . $packerCode . $d . $m . $y;
        $this->save(["id" => $packageDetailId, "package_no" => $kode]);
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
        $testCode = "[0-9]{8}" . $y;
        $lastRecord = $this->find('first', array('conditions' => array("not" => ["PackageDetail.id" => $packageDetailId], 'and' => array("PackageDetail.package_no regexp" => $testCode)), 'order' => array('PackageDetail.package_no' => 'DESC')));
        if (!empty($lastRecord)) {
            $current = substr($lastRecord["PackageDetail"]["package_no"], 0, 8);
            $inc_id += $current;
        }
        $inc_id = sprintf("%08d", $inc_id);
        $kode = $inc_id . $y;
        $this->save(["id" => $packageDetailId, "package_no" => $kode]);
    }
}

?>
