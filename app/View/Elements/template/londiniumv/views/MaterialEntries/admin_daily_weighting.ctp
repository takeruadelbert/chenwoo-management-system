<?php
echo $this->element(_TEMPLATE_DIR . "/{$template}/filter/material_entry_daily_weighting");
?>
<div class="tab-pane active fade in" id="data-utama">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="block-inner text-danger">
                <h6 class="heading-hr"><?= __("LAPORAN PEMBOBOTAN IKAN HARIAN") ?>
                    <div class="pull-right">
                        <button class="btn btn-xs btn-default" type="button" onclick="exp('print', '<?php echo Router::url("daily_weighting/print?" . $_SERVER['QUERY_STRING'], true) ?>')">
                            <i class="icon-print2"></i> 
                            <?= __("Cetak") ?>
                        </button>&nbsp;
                        <button class="btn btn-xs btn-default" type="button" onclick="exp('excel', '<?php echo Router::url("daily_weighting/excel?" . $_SERVER['QUERY_STRING'], true) ?>')">
                            <i class="icon-file-excel"></i>
                            Excel
                        </button>&nbsp;
                    </div>
                    <small class="display-block"><?= _APP_CORPORATE_FULL ?></small>
                </h6>
            </div>
            <div>
                <div class="panel-heading" style="background:#2179cc">
                    <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Preview Laporan Pembobotan Ikan Harian") ?></h6>
                </div>
                <table class="table-bordered stn-table table" width = "100%"> 
                    <tr style="text-align:center;">
                        <th width="20">No.</th>
                        <th width="200">Nama </th>
                        <th colspan="10">Pembobotan (Kg)</th>
                        <th width="100">Total (Kg)</th>
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
                        $fishList = array();
                        $i = 0;
                        foreach ($data['rows']as $transaction) {
                            foreach ($transaction['MaterialEntryGrade'] as $materials) {
                                foreach ($materials['MaterialEntryGradeDetail'] as $k => $details) {
                                    if ($k == 0) {
                                        array_push($fishList, ['label' => $materials['MaterialDetail']['Material']['name'] . " " . $materials['MaterialDetail']['name'], 'weighting' => $details['weight'], 'total' => $details['weight'], "id" => $transaction['MaterialEntry']['id']]);
                                    } else {
                                        $total = (float) $fishList[$i]['total'] + (float) $details['weight'];
                                        $temp = $fishList[$i]['weighting'];
                                        $fishList[$i]['weighting'] = $temp . ", " . $details['weight'];
                                        $fishList[$i]['total'] = $total;
                                    }
                                }
                                $i++;
                            }
                        }
                        foreach ($fishList as $item) {
                            $arrayWeightPrint = explode(',', $item['weighting']);
                            $statusMerge = false;
                            for ($i = 0; $i < count($arrayWeightPrint); $i = $i + 10) {
                                ?>    
                                <!--Set List-->
                                <tr>
                                    <?php
                                    if ($statusMerge == false) {
                                        ?>
                                        <td class = "text-center"><?= $number ?></td>
                                        <td><?= $item['label'] ?></td>
                                        <?php
                                    } else {
                                        ?>
                                        <td></td>
                                        <td></td>
                                        <?php
                                    }
                                    ?>
                                    <td width="5%"><?php
                                        if ((($i + 0) % 10) < count($arrayWeightPrint)) {
                                            $weight = $arrayWeightPrint[(($i + 0) % 10)];
                                            echo $weight;
                                        };
                                        ?></td>
                                    <td width="5%"><?php
                                        if ((($i + 1) % 10) < count($arrayWeightPrint)) {
                                            $weight = $arrayWeightPrint[(($i + 1) % 10)];
                                            echo $weight;
                                        };
                                        ?></td>
                                    <td width="5%"><?php
                                        if ((($i + 2) % 10) < count($arrayWeightPrint)) {
                                            $weight = $arrayWeightPrint[(($i + 2) % 10)];
                                            echo $weight;
                                        };
                                        ?></td>
                                    <td width="5%"><?php
                                        if ((($i + 3) % 10) < count($arrayWeightPrint)) {
                                            $weight = $arrayWeightPrint[(($i + 3) % 10)];
                                            echo $weight;
                                        };
                                        ?></td>
                                    <td width="5%"><?php
                                        if ((($i + 4) % 10) < count($arrayWeightPrint)) {
                                            $weight = $arrayWeightPrint[(($i + 4) % 10)];
                                            echo $weight;
                                        };
                                        ?></td>
                                    <td width="5%"><?php
                                        if ((($i + 5) % 10) < count($arrayWeightPrint)) {
                                            $weight = $arrayWeightPrint[(($i + 5) % 10)];
                                            echo $weight;
                                        };
                                        ?></td>
                                    <td width="5%"><?php
                                        if ((($i + 6) % 10) < count($arrayWeightPrint)) {
                                            $weight = $arrayWeightPrint[(($i + 6) % 10)];
                                            echo $weight;
                                        };
                                        ?></td>
                                    <td width="5%"><?php
                                        if ((($i + 7) % 10) < count($arrayWeightPrint)) {
                                            $weight = $arrayWeightPrint[(($i + 7) % 10)];
                                            echo $weight;
                                        };
                                        ?></td>
                                    <td width="5%"><?php
                                        if ((($i + 8) % 10) < count($arrayWeightPrint)) {
                                            $weight = $arrayWeightPrint[(($i + 8) % 10)];
                                            echo $weight;
                                        };
                                        ?></td>
                                    <td width="5%"><?php
                                        if ((($i + 9) % 10) < count($arrayWeightPrint)) {
                                            $weight = $arrayWeightPrint[(($i + 9) % 10)];
                                            echo $weight;
                                        };
                                        ?></td>
                                    <?php
                                    if ($statusMerge == false) {
                                        ?>
                                        <td class="text-center"><?= $item['total'] ?></td>
                                        <?php
                                    } else {
                                        ?>
                                        <td></td>
                                        <?php
                                    }
                                    ?>                   
                                </tr>
                                <?php
                                $statusMerge = True;
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