<?php
echo $this->element(_TEMPLATE_DIR . "/{$template}/filter/report_entry");
?>
<div class="tab-pane active fade in" id="data-utama">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="block-inner text-danger">
                <h6 class="heading-hr"><?= __("LAPORAN BARANG MASUK") ?>
                    <div class="pull-right">
                        <button class="btn btn-xs btn-default" type="button" onclick="exp('print', '<?php echo Router::url("report/print?" . $_SERVER['QUERY_STRING'], true) ?>')">
                            <i class="icon-print2"></i> 
                            <?= __("Cetak") ?>
                        </button>&nbsp;
                        <button class="btn btn-xs btn-default" type="button" onclick="exp('excel', '<?php echo Router::url("report/excel?" . $_SERVER['QUERY_STRING'], true) ?>')">
                            <i class="icon-file-excel"></i>
                            Excel
                        </button>&nbsp;
                    </div>
                    <small class="display-block"><?= _APP_CORPORATE_FULL ?></small>
                </h6>
            </div>
            <div>
                <div class="panel-heading" style="background:#2179cc">
                    <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Preview Laporan Barang Masuk Bulan Berjalan") ?></h6>
                </div>
                <table class="table-bordered stn-table table" width = "100%" style = "font-size:12px; "> 
                    <tr style="text-align:center;">
                        <th rowspan="2" width="30px">NO</th>
                        <th rowspan="2" width="200px">NAMA IKAN</th>
                        <th colspan="2" width="180px">
                            BULAN LALU </br> Januari
                            <?php
                            if ($data['month'] != 1) {
                                echo "s/d " . $this->Html->getNamaBulan($data['month'] - 1) . " " . $data['year'];
                            }
                            ?>
                        </th>
                        <th rowspan="2" width="80px">HARGA </br> RATA-RATA</th>
                        <th colspan="2" width="160px" style="color:blue">BULAN INI </br> <?= $this->Html->getNamaBulan($data['month']) . " " . $data['year'] ?></th>
                        <th rowspan="2" width="80px" style="color:blue">HARGA </br> RATA-RATA</th>
                        <th colspan="2" width="160px">S/D BULAN INI </br> Januari
                            <?php
                            if ($data['month'] != 1) {
                                echo "s/d " . $this->Html->getNamaBulan($data['month']) . " " . $data['year'];
                            }
                            ?>
                        </th>
                        <th rowspan="2" width="80px">HARGA </br> RATA-RATA</th>
                    </tr>
                    <tr style="text-align:center;">
                        <th>Kg</th>
                        <th>Rp.</th>
                        <th style="color:blue">Kg</th>
                        <th style="color:blue">Rp.</th>
                        <th>Kg</th>
                        <th>Rp.</th>
                    </tr>
                    <?php if (empty($data['rows'])) {
                        ?>
                        <tr>
                            <td class = "text-center" colspan ="13">Tidak Ada Data</td>
                        </tr>
                        <?php
                    } else {
                        ?>
                        <?php
                        $number = 1;
                        $month = $data['month'];
                        $total_price_month_before = 0;
                        $total_price_month_now = 0;
                        $total_price_month_all = 0;
                        $total_weight_month_before = 0;
                        $total_weight_month_now = 0;
                        $total_weight_month_all = 0;
                        $total_before = 0;
                        $total_now = 0;
                        $total_all = 0;
                        //foreach ($data['material_categories'] as $material_categories) {
                            //foreach($items['TransactionMaterialEntry'] as $materials){
                            ?>
                            <?php
                            //Set for 12 months
                            $material = array();
                            $price_month_before = array();
                            $price_month_now = array();
                            $price_month_all = array();
                            $weight_month_before = array();
                            $weight_month_now = array();
                            $weight_month_all = array();
                            $compact_data_by_month = array([], [], [], [], [], [], [], [], [], [], [], []);
                            $count=0;
                            foreach ($data['rows'] as $items) {
                                $d = date_parse_from_format("Y-m-d", $items['MaterialEntry']['weight_date']);
                                foreach ($items['TransactionMaterialEntry'] as $materials) {
                                    //debug($material_categories['MaterialCategory']['id'] ." ". $materials['MaterialDetail']['Material']['material_category_id']);
                                    //if ($material_categories['MaterialCategory']['id'] == $materials['MaterialDetail']['Material']['material_category_id']) {
                                        //$materials['Material']['material_category_id']
                                        //Push Material if not exist
                                        if (count($material) != 0) {
                                            for ($i = 0; $i < count($material); $i++) {
                                                //debug($d);
                                                if ($material[$i] == $materials['MaterialDetail']['Material']['name'] . " " . $materials['MaterialDetail']['name'] . " " . $materials['MaterialSize']['name']) {
                                                    if ($d['month'] < $month) {
                                                        //price
                                                        $price_month_before[$i] += $materials['price'] * $materials['weight'];
                                                        $price_month_all[$i] += $materials['price'] * $materials['weight'];
                                                        //if ($price_month_before[$i] == 0) {
                                                            //$price_month_all[$i] = $materials['price'];
                                                        //}
                                                        //$price_month_before[$i]
                                                        //weight
                                                        $weight_month_before[$i]+=$materials['weight'];
                                                        $weight_month_all[$i]+=$materials['weight'];
                                                    } else if ($d['month'] = $month) {
                                                        //price
                                                        $price_month_now[$i] += $materials['price'] * $materials['weight'];
                                                        $price_month_all[$i] += $materials['price'] * $materials['weight'];
                                                        //if ($price_month_now[$i] == 0) {
                                                            
                                                            //$price_month_all[$i] = $materials['price'];
                                                        //}
                                                        //weight
                                                        $weight_month_now[$i]+=$materials['weight'];
                                                        $weight_month_all[$i]+=$materials['weight'];
                                                    }
                                                    $i = count($material) - 1;
                                                } else if ($i == (count($material) - 1)) {
                                                    array_push($material, $materials['MaterialDetail']['Material']['name'] . " " . $materials['MaterialDetail']['name'] . " " . $materials['MaterialSize']['name']);
                                                    if ($d['month'] < $month) {
                                                        //price
                                                        array_push($price_month_before, $materials['price'] * $materials['weight']);
                                                        array_push($price_month_now, 0);
                                                        array_push($price_month_all, $materials['price'] * $materials['weight']);
                                                        //weight
                                                        array_push($weight_month_before, $materials['weight']);
                                                        array_push($weight_month_now, 0);
                                                        array_push($weight_month_all, $materials['weight']);
                                                    } else if ($d['month'] = $month) {
                                                        //price
                                                        array_push($price_month_before, 0);
                                                        array_push($price_month_now, $materials['price'] * $materials['weight']);
                                                        array_push($price_month_all, $materials['price'] * $materials['weight']);
                                                        //weight
                                                        array_push($weight_month_before, 0);
                                                        array_push($weight_month_now, $materials['weight']);
                                                        array_push($weight_month_all, $materials['weight']);
                                                    }
                                                    $i = count($material) - 1;
                                                    //array_push($material, $materials['Material']['name']);
                                                }
                                            }
                                        } else {
                                            //For first time
                                            array_push($material, $materials['MaterialDetail']['Material']['name'] . " " . $materials['MaterialDetail']['name'] . " " . $materials['MaterialSize']['name']);
                                            $d = date_parse_from_format("Y-m-d", $materials['created']);
                                            if ($d['month'] < $month) {
                                                //price
                                                array_push($price_month_before, $materials['price'] * $materials['weight']);
                                                array_push($price_month_now, 0);
                                                array_push($price_month_all, $materials['price'] * $materials['weight']);
                                                //weight
                                                array_push($weight_month_before, $materials['weight']);
                                                array_push($weight_month_now, 0);
                                                array_push($weight_month_all, $materials['weight']);
                                            } else if ($d['month'] = $month) {
                                                //price
                                                array_push($price_month_before, 0);
                                                array_push($price_month_now, $materials['price'] * $materials['weight']);
                                                array_push($price_month_all, $materials['price'] * $materials['weight']);
                                                //weight
                                                array_push($weight_month_before, 0);
                                                array_push($weight_month_now, $materials['weight']);
                                                array_push($weight_month_all, $materials['weight']);
                                            }
                                        }
                                    //}
                                }
                            }
                            for ($i = 0; $i < count($material); $i++) {
                                ?>
                                <tr>
                                    <td class = "text-center"><?= ($i + 1) ?></td>
                                    <td style="text-align:left;"><?= $material[$i] ?></td>
                                    <td style="text-align:right;"><?= $this->Html->RpWithMinusEmpty($weight_month_before[$i]) ?></td>
                                    <td style="text-align:right;"><?= $this->Html->RpWithMinusEmpty($price_month_before[$i]); ?></td>
                                    <?php
                                    if ($weight_month_before[$i] != null && $weight_month_before[$i] != "") {
                                        ?>
                                        <td style="text-align:right;"><?= $this->Html->RpWithMinusEmpty($price_month_before[$i] / $weight_month_before[$i]) ?></td>
                                        <?php
                                    } else {
                                        ?>
                                        <td style="text-align:right;"><?= $this->Html->RpWithMinusEmpty(0) ?></td>
                                        <?php
                                    }
                                    ?>
                                    <td style="text-align:right;color:blue"><?= $this->Html->RpWithMinusEmpty($weight_month_now[$i]) ?></td>
                                    <td style="text-align:right;color:blue"><?= $this->Html->RpWithMinusEmpty($price_month_now[$i]) ?></td>
                                    <?php
                                    if ($weight_month_now[$i] != null && $weight_month_now[$i] != "") {
                                        ?>
                                        <td style="text-align:right;color:blue"><?= $this->Html->RpWithMinusEmpty($price_month_now[$i] / $weight_month_now[$i]) ?></td>
                                        <?php
                                    } else {
                                        ?>
                                        <td style="text-align:right;"><?= $this->Html->RpWithMinusEmpty(0) ?></td>
                                        <?php
                                    }
                                    ?>
                                    <td style="text-align:right;"><?= $this->Html->RpWithMinusEmpty($weight_month_all[$i]) ?></td>
                                    <td style="text-align:right;"><?= $this->Html->RpWithMinusEmpty($price_month_all[$i]) ?></td>
                                    <?php
                                    if ($weight_month_all[$i] != null && $weight_month_all[$i] != "") {
                                        ?>
                                        <td style="text-align:right;"><?= $this->Html->RpWithMinusEmpty($price_month_all[$i] / $weight_month_all[$i]) ?></td>
                                        <?php
                                    } else {
                                        ?>
                                        <td style="text-align:right;"><?= $this->Html->RpWithMinusEmpty(0) ?></td>
                                        <?php
                                    }
                                    ?>
                                </tr> 
                                <?php
                                $total_price_month_before += $price_month_before[$i];
                                $total_price_month_now += $price_month_now[$i];
                                $total_price_month_all += $price_month_all[$i];
                                $total_weight_month_before += $weight_month_before[$i];
                                $total_weight_month_now += $weight_month_now[$i];
                                $total_weight_month_all += $weight_month_all[$i];
                            }
                            ?>
                            <?php
                            $number++;
                        //}
                        ?>
                        <tr style = "font-weight: bold">
                            <td class = "text-center"></td>
                            <td style="text-align:left;">Jumlah Ikan : </td>
                            <td style="text-align:right;"><?= $this->Html->RpWithMinusEmpty($total_weight_month_before) ?></td>
                            <td style="text-align:right;"><?= $this->Html->RpWithMinusEmpty($total_price_month_before); ?></td>
                            <?php
                            if ($total_weight_month_before != null && $total_weight_month_before != "") {
                                ?>
                                <td style="text-align:right;"><?= $this->Html->RpWithMinusEmpty($total_price_month_before / $total_weight_month_before) ?></td>
                                <?php
                            } else {
                                ?>
                                <td style="text-align:right;"><?= $this->Html->RpWithMinusEmpty(0) ?></td>
                                <?php
                            }
                            ?>
                            <td style="text-align:right;color:blue"><?= $this->Html->RpWithMinusEmpty($total_weight_month_now) ?></td>
                            <td style="text-align:right;color:blue"><?= $this->Html->RpWithMinusEmpty($total_price_month_now) ?></td>
                            <?php
                            if ($total_weight_month_now != null && $total_weight_month_now != "") {
                                ?>
                                <td style="text-align:right;color:blue"><?= $this->Html->RpWithMinusEmpty($total_price_month_now / $total_weight_month_now) ?></td>
                                <?php
                            } else {
                                ?>
                                <td style="text-align:right;"><?= $this->Html->RpWithMinusEmpty(0) ?></td>
                                <?php
                            }
                            ?>
                            <td style="text-align:right;"><?= $this->Html->RpWithMinusEmpty($total_weight_month_all) ?></td>
                            <td style="text-align:right;"><?= $this->Html->RpWithMinusEmpty($total_price_month_all) ?></td>
                            <?php
                            if ($total_weight_month_all != null && $total_weight_month_all != "") {
                                ?>
                                <td style="text-align:right;"><?= $this->Html->RpWithMinusEmpty($total_price_month_all / $total_weight_month_all) ?></td>
                                <?php
                            } else {
                                ?>
                                <td style="text-align:right;"><?= $this->Html->RpWithMinusEmpty(0) ?></td>
                                <?php
                            }
                            ?>
                        </tr> 
                        <?php
                    }
                    ?>
                </table>
            </div>
        </div>    
    </div>
</div>