<div class="panel panel-default">
    <div class="panel-body">
        <div class="pull-right">            
            <button class="btn btn-xs btn-default" type="button" onclick="exp('print', '<?php echo Router::url("debt_list_report/print?" . $_SERVER['QUERY_STRING'], true) ?>')">
                <i class="icon-print2"></i> 
                <?= __("Cetak") ?>
            </button>&nbsp;
            <button class="btn btn-xs btn-default" type="button" onclick="exp('excel', '<?php echo Router::url("debt_list_report/excel?" . $_SERVER['QUERY_STRING'], true) ?>')">
                <i class="icon-file-excel"></i>
                Excel
            </button>
        </div>
        <br>
        <?php
        $dataSuppliers = ClassRegistry::init("MaterialAdditionalSupplier")->find("all", ['order' => "MaterialAdditionalSupplier.name"]);
        foreach ($dataSuppliers as $suppliers) {
            ?>
            <div class="block-inner text-danger">
                <h6 class="heading-hr"><?= $suppliers['MaterialAdditionalSupplier']['name'] ?>
                </h6>
            </div>
            <?php
            $dataDebtList = ClassRegistry::init("PurchaseOrderMaterialAdditional")->find("all", [
                "conditions" => [
                    "PurchaseOrderMaterialAdditional.material_additional_supplier_id" => $suppliers['MaterialAdditionalSupplier']['id'],
                    "PurchaseOrderMaterialAdditional.remaining >" => 0,
                    "PurchaseOrderMaterialAdditional.purchase_order_material_additional_status_id" => 2,
                ],
                "contain" => [
                    "PaymentPurchaseMaterialAdditional" => [
                        "order" => "PaymentPurchaseMaterialAdditional.id DESC",
                        "conditions" => [
                        ],
                        "limit" => 1,
                    ],
                    "Employee",
                    "MaterialAdditionalSupplier",
                    "BranchOffice"
                ],
                "order" => "PurchaseOrderMaterialAdditional.po_date DESC"
            ]);
            ?>
            <div class="table-responsive pre-scrollable stn-table">
                <table width="100%" class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th width="50">No</th>
                            <th><?= __("Nomor PO") ?></th>
                            <th width="200"><?= __("Tanggal PO") ?></th>
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
                                $totalDebt += $debtList['PurchaseOrderMaterialAdditional']['remaining'];
                                ?>
                                <tr>
                                    <td class="text-center"><?= $i ?></td>
                                    <td class="text-center"><?= $debtList["PurchaseOrderMaterialAdditional"]["po_number"] ?></td>
                                    <td class="text-center"><?= $this->Html->cvtTanggal($debtList['PurchaseOrderMaterialAdditional']['po_date']) ?></td>
                                    <td class="text-center" style = "border-right-style:none !important" width = "50">Rp. </td>
                                    <td class="text-right" style = "border-left-style:none !important" width = "150"><?= ic_rupiah($debtList['PurchaseOrderMaterialAdditional']['remaining']) ?></td> 
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
            </div>
            <br><br>
            <?php
        }
        ?>
    </div>
</div>