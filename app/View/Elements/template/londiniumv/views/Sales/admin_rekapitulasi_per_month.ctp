<?php
echo $this->element(_TEMPLATE_DIR . "/{$template}/filter/rekapitulasi_per_month");
?>
<div class="tab-pane active fade in" id="data-utama">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="block-inner text-danger">
                <h6 class="heading-hr"><?= __("REKAPITULASI EXPORT PER BULAN") ?>
                    <div class="pull-right">
                        <button class="btn btn-xs btn-default" type="button" onclick="exp('print', '<?php echo Router::url("rekapitulasi_per_month/print?" . $_SERVER['QUERY_STRING'], true) ?>')">
                            <i class="icon-print2"></i> 
                            <?= __("Cetak") ?>
                        </button>&nbsp;
                        <button class="btn btn-xs btn-default" type="button" onclick="exp('excel', '<?php echo Router::url("rekapitulasi_per_month/excel?" . $_SERVER['QUERY_STRING'], true) ?>')">
                            <i class="icon-file-excel"></i>
                            Excel
                        </button>&nbsp;
                    </div>
                    <small class="display-block"></small>
                </h6>
            </div>
            <div>
                <div class="panel-heading" style="background:#2179cc">
                    <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Preview Rekapitulasi Export Per Bulan") ?></h6>
                </div>
                <table class="table-bordered table stn-table"> 
                    <tr style="text-align:center;">
                        <th width="10%">DATE</th>
                        <th width="20%">CONSIGNEE</th>
                        <th width="10%">SHIPMENT DESTINATION</th>
                        <th width="15%">ORDER REFERENCE / INVOICE</th>
                        <th width="15%">QUANTITY (Tons/Kg)</th>
                        <th width="15%">SALES AMOUNT (USD)</th>
                        <th width="15%">TOTAL AMOUNT (Rp.)</th>
                    </tr>
                    <?php
                    if (empty($data['rows'])) {
                        ?>
                        <tr>
                            <td class = "text-center" colspan ="7">Tidak Ada Data</td>
                        </tr>
                        <?php
                    } else {
                        $number = 1;
                        $quantityGrandTotal = 0;
                        $salesAmountGrandTotal = 0;
                        $total = 0;
                        foreach ($data['rows']as $data) {
                            ?>
                            <tr>
                                <td class = "text-center"><?= $this->Html->cvtTanggal($data['Sale']['created']) ?></td>
                                <td><?= $data['Buyer']['company_name'] ?></td>
                                <td><?= $data['Shipment']['to_dock'] ?></td>
                                <?php
                                $invoice = "-";
                                $weightTotal = 0;
                                $kurs = $data['Sale']['exchange_rate'];
                                $salesAmountGrandTotal+=$data['Sale']['grand_total'];
                                foreach ($data['SaleDetail']as $detail) {
                                    $weightTotal+=$detail['nett_weight'];
                                    $quantityGrandTotal+=$detail['nett_weight'];
                                }
                                ?>
                                <td><?= $data['Sale']['po_number'] . " / " . $invoice ?></td>
                                <td class="text-right"><?= $weightTotal ?></td>
                                <td class="text-right"><?= $data['Sale']['grand_total'] ?></td>
                                <td class="text-right"><?= $this->Html->Rp($data['Sale']['grand_total'] * $kurs) ?></td>
                                <?php
                                $total += $data['Sale']['grand_total'] * $kurs;
                                ?>
                            </tr>
                            <?php
                        }
                        ?>
                        <tr>
                            <td  colspan="4">Total Export / Penjualan :</td>
                            <td class="text-right"><?= $quantityGrandTotal ?></td>
                            <td class="text-right"><?= $salesAmountGrandTotal ?></td>
                            <td class="text-right"><?= $this->Html->Rp($total) ?></td>
                        </tr>   
                        <?php
                    }
                    ?>
                </table>
            </div>
        </div>    
    </div>
</div>