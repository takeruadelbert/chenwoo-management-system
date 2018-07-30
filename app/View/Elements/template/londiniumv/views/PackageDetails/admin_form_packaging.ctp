<?php
echo $this->element(_TEMPLATE_DIR . "/{$template}/filter/form_pengemasan");
?>
<div class="tab-pane active fade in" id="data-utama">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="block-inner text-danger">
                <h6 class="heading-hr"><?= __("FORM PENGEMASAN IKAN HARIAN") ?>
                    <div class="pull-right">
                        <button class="btn btn-xs btn-default" type="button" onclick="exp('print', '<?php echo Router::url("form_packaging/print?" . $_SERVER['QUERY_STRING'], true) ?>')">
                            <i class="icon-print2"></i> 
                            <?= __("Cetak") ?>
                        </button>&nbsp;
                        <button class="btn btn-xs btn-default" type="button" onclick="exp('excel', '<?php echo Router::url("form_packaging/excel?" . $_SERVER['QUERY_STRING'], true) ?>')">
                            <i class="icon-file-excel"></i>
                            Excel
                        </button>&nbsp;
                    </div>
                    <small class="display-block"><?= _APP_CORPORATE_FULL ?></small>
                </h6>
            </div>
            <div>
                <div class="panel-heading" style="background:#2179cc">
                    <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Preview Form Pengemasan Ikan Harian") ?></h6>
                </div>
                <table class="table-bordered table stn-table" width = "100%"> 
                    <tr style="text-align:center;">
                        <th width="150px" rowspan="2">Date</th>
                        <th width="50px" rowspan="2">No MC</th>
                        <th width="150px" rowspan="2">NW</th>
                        <th width="150px" rowspan="2">CODE</th>
                        <th width="80px" rowspan="2">PCS</th>
                        <th width="200px" colspan="3">PMC</th>
                    </tr>
                    <tr style="text-align:center;">
                        <th>PL</th>
                        <th>Inner</th>
                        <th>MC</th>
                    </tr>
                    <?php if (empty($data['rows'])) {
                        ?>
                        <tr>
                            <td class = "text-center" colspan = "8">Tidak Ada Data</td>
                        </tr>
                        <?php
                    } else {
                        ?>
                        <?php
                        $total = 0;
                        $quantity = 0;
                        $number = 1;
                        $fishList = array();
                        foreach ($data['rows']as $package) {
                            ?>    
                            <tr>
                                <td class = "text-center"><?= $this->Html->cvtTanggal($package['PackageDetail']['created']) ?></td>
                                <td class = "text-center"><?= $number ?></td>
                                <td class = "text-center"><?= $package['PackageDetail']['nett_weight'] ?></td>
                                <td class = "text-center"><?= $package['Product']['code'] ?></td>
                                <td class = "text-center"><?= $package['PackageDetail']['quantity_per_pack'] ?></td>
                                <td class = "text-center"></td>
                                <td class = "text-center"></td>
                                <td class = "text-center"></td>
                            </tr> 
                            <?php
                            $total += $package['PackageDetail']['nett_weight'];
                            $quantity += $package['PackageDetail']['quantity_per_pack'];
                            $number++;
                        }
                        ?>    
                        <tr>
                            <td class = "text-center"><b>Total</b></td>
                            <td class = "text-center"></td>
                            <td class = "text-center"><?= $total ?></td>
                            <td class = "text-center"></td>
                            <td class = "text-center"><?= $quantity ?></td>
                            <td class = "text-center" style = "border-right:none !important;"></td>
                            <td class = "text-center" style = "border-left:none !important;border-right:none !important;"></td>
                            <td class = "text-center" style = "border-left:none !important;border-right:none !important;"></td>
                        </tr> 
                        <?php
                    }
                    ?>
                </table>
                <div>
                    <p> Note : PMC = Packaging Material Code </p>
                </div>
            </div>
        </div>    
    </div>
</div>