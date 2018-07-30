<?php
echo $this->element(_TEMPLATE_DIR . "/{$template}/filter/laporan_pengemasan");
?>
<div class="tab-pane active fade in" id="data-utama">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="block-inner text-danger">
                <h6 class="heading-hr"><?= __("LAPORAN PENGEMASAN IKAN HARIAN") ?>
                    <div class="pull-right">
                        <button class="btn btn-xs btn-default" type="button" onclick="exp('print', '<?php echo Router::url("daily_packaging/print?" . $_SERVER['QUERY_STRING'], true) ?>')">
                            <i class="icon-print2"></i> 
                            <?= __("Cetak") ?>
                        </button>&nbsp;
                        <button class="btn btn-xs btn-default" type="button" onclick="exp('excel', '<?php echo Router::url("daily_packaging/excel?" . $_SERVER['QUERY_STRING'], true) ?>')">
                            <i class="icon-file-excel"></i>
                            Excel
                        </button>&nbsp;
                    </div>
                    <small class="display-block"><?= _APP_CORPORATE_FULL ?></small>
                </h6>
            </div>
            <div>
                <div class="panel-heading" style="background:#2179cc">
                    <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Preview Laporan Pengemasan Ikan Harian") ?></h6>
                </div>
                <table class="table-bordered table stn-table"width = "100%"> 
                    <tr style="text-align:center;">
                        <th width="30px" rowspan="2">NO</th>
                        <th width="200px" rowspan="2">KIND OF FISH</th>
                        <th width="100px" rowspan="2">GRADE</th>
                        <th width="100px">MC</th>
                        <th width="150px" rowspan="2">PEMBELI</th>
                        <th width="150px" colspan="2">PACKING UNIT</th>
                        <th width="80px" rowspan="2">TOTAL KGS</th>
                        <th width="80px" rowspan="2">REAL KGS</th>
                    </tr>
                    <tr style="text-align:center;">
                        <th>TOTAL</th>
                        <th>LBS</th>
                        <th>KGS</th>
                    </tr>
                    <?php if (empty($data['rows'])) {
                        ?>
                        <tr>
                            <td class = "text-center" colspan ="9">Tidak Ada Data</td>
                        </tr>
                        <?php
                    } else {
                        ?>
                        <?php
                        $number = 1;
                        $fishList = array();
                        foreach ($data['rows']as $package) {
                            //foreach ($package['PackageDetail'] as $product) {
                            if (count($fishList) == 0) {
                                array_push($fishList, ['name' => $package['Product']['Parent']['name'], 'size' => $package['Product']['name'], 'weight' => $package['PackageDetail']['nett_weight'], 'total' => $package['PackageDetail']['nett_weight'], 'buyer' => $package['Sale']['Buyer']['company_name'], 'count' => 1]);
                            } else {
                                for ($i = 0; $i < count($fishList); $i++) {
                                    if ($package['Product']['Parent']['name'] == $fishList[$i]['name'] && $package['Product']['name'] == $fishList[$i]['size']) {
                                        $total = $fishList[$i]['total'] + $package['PackageDetail']['nett_weight'];
                                        $fishList[$i]['total'] = $total;
                                        $fishList[$i]['count'] = $fishList[$i]['count'] + 1;
                                    } else if ($i == count($fishList) - 1) {
                                        array_push($fishList, ['name' => $package['Product']['Parent']['name'], 'size' => $package['Product']['name'], 'weight' => $package['PackageDetail']['nett_weight'], 'total' => $package['PackageDetail']['nett_weight'], 'buyer' => $package['Sale']['Buyer']['company_name'], 'count' => 1]);
                                    }
                                }
                            }
                            //}
                        }
                        foreach ($fishList as $item) {
                            ?>    
                            <!--Set List-->
                            <tr>
                                <td class="text-center"><?= $number ?></td>
                                <td><?= $item['name'] ?></td>
                                <td class="text-center"><?= $item['size'] ?></td>
                                <td style="text-align:center"><?= $item['count'] ?></td>
                                <td style="text-align:center"><?= $item['buyer'] ?></td>
                                <td style="text-align:center"><?= number_format($item['weight'] * 2.20462, 2, '.', '') ?></td> <!-- LBS -->
                                <td style="text-align:center"><?= $item['weight'] ?></td> <!-- KGS -->
                                <td style="text-align:center"><?= $item['weight'] * $item['count'] ?></td>
                                <td style="text-align:center"></td>
                            </tr> 
                            <?php
                            $number++;
                        }
                    }
                    ?>
                </table>
            </div>
        </div>    
    </div>
</div>
