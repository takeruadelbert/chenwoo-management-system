<?php
echo $this->element(_TEMPLATE_DIR . "/{$template}/filter/rekapitulasi_per_buyer");
?>
<div class="tab-pane active fade in" id="data-utama">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="block-inner text-danger">
                <h6 class="heading-hr"><?= __("REKAPITULASI EXPORT PER BUYER") ?>
                    <div class="pull-right">
                        <button class="btn btn-xs btn-default" type="button" onclick="exp('print', '<?php echo Router::url("rekapitulasi_per_buyer/print?" . $_SERVER['QUERY_STRING'], true) ?>')">
                            <i class="icon-print2"></i> 
                            <?= __("Cetak") ?>
                        </button>&nbsp;
                        <button class="btn btn-xs btn-default" type="button" onclick="exp('excel', '<?php echo Router::url("rekapitulasi_per_buyer/excel?" . $_SERVER['QUERY_STRING'], true) ?>')">
                            <i class="icon-file-excel"></i>
                            Excel
                        </button>&nbsp;
                    </div>
                    <small class="display-block"></small>
                </h6>
            </div>
            <div>
                <div class="panel-heading" style="background:#2179cc">
                    <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Preview Rekapitulasi Export Per Buyer") ?></h6>
                </div>
                <table class="table-bordered table stn-table"> 
                    <tr style="text-align:center;">
                        <th width="30px">NO</th>
                        <th width="30px">NO INVOICE</th>
                        <th width="200px">DESCRIPTION OF GOODS</th>
                        <th width="100px">SIZE</th>
                        <th width="80px">QUANTITY</th>
                        <th width="100px">U/PRICE (Rp.)</th>
                        <th width="150px">U/PRICE (USD)</th>
                        <th width="200px">AMOUNT (Rp.)</th>
                        <th width="150px">AMOUNT (USD)</th>
                        <th width="100px">KET</th>
                    </tr>
                    <?php
                    if (empty($data['rows'])) {
                        ?>
                        <tr>
                            <td class = "text-center" colspan ="10">Tidak Ada Data</td>
                        </tr>
                        <?php
                    } else {
                        $number = 1;
                        $fishList = array();
                        foreach ($data['rows']as $invoice) {
                            $kurs = $invoice['Sale']['exchange_rate'];
                            $first = true;
                            foreach ($invoice['SaleDetail'] as $product) {
                                ?>
                                <tr>
                                    <?php
                                    if ($first == true) {
                                        ?>
                                        <td class = "text-center"><?= $number ?></td>
                                        <td class = "text-center"><?= $invoice['Sale']['po_number'] ?></td>
                                        <?php
                                    } else {
                                        ?>
                                        <td></td>
                                        <td></td>
                                        <?php
                                    }
                                    ?>
                                    <td><?= $product['Product']['Parent']['name'] ?></td>
                                    <td><?= $product['Product']['name'] ?></td>
                                    <td class = "text-right"><?= number_format(($product['nett_weight'] * 2.20462), 2) ?></td>
                                    <td class = "text-right"><?= $this->Html->berat($product['price'] * $kurs) ?></td>
                                    <td class = "text-right"><?= $product['price'] ?></td>
                                    <td class = "text-right"><?= $this->Html->berat($product['price'] * $product['quantity'] * $kurs) ?></td>
                                    <td class = "text-right"><?= $product['price'] * $product['quantity'] ?></td>
                                    <?php
                                    if ($first == true) {
                                        $first = false;
                                        ?>
                                        <td>Kurs : <?= $this->Html->IDR($kurs) ?></td>
                                        <?php
                                    } else {
                                        ?>
                                        <td></td>
                                        <?php
                                    }
                                    ?>

                                </tr> 
                                <?php
                            }
                            $number++;
                        }
                    }
                    ?>
                </table>
            </div>
        </div>    
    </div>
</div>