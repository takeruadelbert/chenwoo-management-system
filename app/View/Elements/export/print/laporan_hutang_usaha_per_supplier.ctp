<div style="text-align: center">
    <div style="font-size:11px;font-weight: bold; font-family:Tahoma, Geneva, sans-serif;">
        Laporan Hutang Usaha Per Supplier
    </div>
    <div style="font-size:11px;font-style: italic; font-family:Tahoma, Geneva, sans-serif;"><?= $this->Html->cvtTanggal(date("Y-m-d")) ?></div>
</div>
<br/>
<?php
$dataSuppliers = ClassRegistry::init("Supplier")->find("all", ['order' => "Supplier.name"]);
foreach ($dataSuppliers as $suppliers) {
    ?>
        <h3><?= $suppliers['Supplier']['name'] ?>
        </h3>
    <?php
    $dataDebtList = ClassRegistry::init("TransactionEntry")->find("all", [
        "conditions" => [
            "TransactionEntry.supplier_id" => $suppliers['Supplier']['id'],
            "TransactionEntry.remaining >" => 0
        ],
        "contain" => [
            "PaymentPurchase" => [
                "order" => "PaymentPurchase.id DESC",
                "conditions" => [
                ],
                "limit" => 1,
            ],
            "Employee",
            "Supplier",
            "BranchOffice",
            "MaterialEntry",
        ],
        "order" => "MaterialEntry.weight_date DESC"
    ]);
    ?>
    <table width="100%" class="table-data">
        <thead>
            <tr>
                <th width="50">No</th>
                <th><?= __("Nomor Nota Timbang") ?></th>
                <th width="200"><?= __("Tanggal Nota Timbang") ?></th>
                <th colspan = "2"><?= __("Sisa Hutang") ?></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 1;
            if (empty($dataDebtList)) {
                ?>
                <tr>
                    <td class = "text-center" colspan = "5">Tidak Ada Data</td>
                </tr>
                <?php
            } else {
                $totalDebt = 0;
                foreach ($dataDebtList as $debtList) {
                    $totalDebt += $debtList['TransactionEntry']['remaining'];
                    ?>
                    <tr>
                        <td class="text-center"><?= $i ?></td>
                        <td class="text-center"><?= $debtList["MaterialEntry"]["material_entry_number"] ?></td>
                        <td class="text-center"><?= $this->Html->cvtTanggal($debtList['MaterialEntry']['weight_date']) ?></td>
                        <td class="text-center" style = "border-right-style:none !important" width = "50">Rp. </td>
                        <td class="text-right" style = "border-left-style:none !important" width = "150"><?= ic_rupiah($debtList['TransactionEntry']['remaining']) ?></td> 
                    </tr>
                    <?php
                    $i++;
                }
                ?>
            <tfoot>
                <tr>
                    <td colspan="3" class="text-right"><strong>Total Hutang</strong></td>
                    <td class="text-center" style = "border-right-style:none !important" width = "50">Rp. </td>
                    <td class="text-right" style = "border-left-style:none !important" width = "150"><?= ic_rupiah($totalDebt) ?></td> 
                </tr>
            </tfoot>
            <?php
        }
        ?>
    </tbody>
    </table>
    <br><br>
    <?php
}
?>