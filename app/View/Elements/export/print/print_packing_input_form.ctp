<?php
//$groupedProduct = [];
//foreach ($dataProduct as $product) {
//    $groupedProduct[$product["Product"]["id"]] = [
//        "label" => $product["Parent"]["name"] . " " . $product["Product"]["name"],
//        "data" => [],
//        "list" => [],
//    ];
//}
//foreach ($dataTreatment as $treatment) {
//    $groupedProduct[$treatment["TreatmentDetail"]["product_id"]]["data"] = [
//        "id" => $treatment["TreatmentDetail"]["id"],
//        "label" => $this->Chenwoo->labelBatchNumber($treatment),
//        "weight" => $treatment["TreatmentDetail"]["remaining_weight"],
//    ];
//    $groupedProduct[$treatment["TreatmentDetail"]["product_id"]]["list"][$treatment["TreatmentDetail"]["id"]] = $this->Chenwoo->labelBatchNumber($treatment);
//}
$productSale = [];
foreach ($this->data["SaleDetail"] as $saleDetail) {
    $productSale[$saleDetail["product_id"]] = [
        "label" => $saleDetail["Product"]["Parent"]["name"] . " " . $saleDetail["Product"]["name"],
        "data" => [],
    ];
}
foreach ($this->data["PackageDetail"] as $packageDetail) {
    $productSale[$packageDetail["product_id"]]["data"][] = $packageDetail;
}
?>
<table class="no-border" style="font-family:Tahoma, Geneva, sans-serif; font-size:12px;">
    <tbody>
        <tr>
            <td>Nomor Penjualan</td>
            <td>&nbsp;:&nbsp;</td>
            <td><?= $this->data["Sale"]["sale_no"] ?></td>
        </tr>
        <tr>
            <td>Nomor PO</td>
            <td>&nbsp;:&nbsp;</td>
            <td><?= $this->data["Sale"]["po_number"] ?></td>
        </tr>
    </tbody>
</table>
<br>
<table width="100%" class="table-data table-data-input table-data-nowrap" style="font-family:Tahoma, Geneva, sans-serif;">
    <thead>
        <tr>
            <th width="50" style="text-align: center;">No</th>
            <th width="75" style="text-align: center;">Barcode MC</th>
            <th style="text-align: center;">Batch Number</th>
            <th width="75" style="text-align: center;">Berat Bersih (Kg)</th>
            <th width="75" style="text-align: center;">Berat Kotor (Kg)</th>
            <th width="75" style="text-align: center;">Jumlah Kemasan (Pcs)</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 0;
        foreach ($productSale as $k => $groupedSaleDetail) {
            ?>
            <tr>
                <td colspan="6"><b><?= $groupedSaleDetail["label"] ?></b></td>
            </tr>
            <?php
            $j = 1;
            foreach ($groupedSaleDetail["data"] as $n => $packageDetail) {
//                $labelBatchNumber=!empty($packageDetail["product_detail_id"])?$this->Chenwoo->labelBatchNumber($packageDetail["ProductDetail"]):"";
                ?>
                <tr>
                    <td class="text-center"><?= $j++ ?></td>
                    <td class="text-left">
                        <?= $packageDetail["package_no"] ?>
                    </td>
                    <td class="text-left">
                        <?php
                        foreach ($packageDetail['PackageDetailProduct'] as $itemss) {
                            ?>
                            <?php echo $itemss['ProductDetail']['batch_number'] . "<br> "; ?></span>
                            <?php
                        }
                        ?>
                    </td>
                    <td class="text-right">
                        <?= $packageDetail["nett_weight"] ?>
                    </td>
                    <td class="text-right">
                        <?= $packageDetail["brut_weight"] ?>
                    </td>
                    <td class="text-right">
                        <?= empty($packageDetail["quantity_per_pack"]) ? "" : $packageDetail["quantity_per_pack"] ?>
                    </td>
                </tr>
                <?php
                $i++;
            }
        }
        ?>
    </tbody>
</table>