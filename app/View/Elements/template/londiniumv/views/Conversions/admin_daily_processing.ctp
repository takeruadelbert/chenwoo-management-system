<?php
echo $this->element(_TEMPLATE_DIR . "/{$template}/filter/daily_processing");
?>
<div class="tab-pane active fade in" id="data-utama">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="block-inner text-danger">
                <h6 class="heading-hr"><?= __("REKAPITULASI LAPORAN PENGOLAHAN IKAN HARIAN") ?>
                    <div class="pull-right">
                        <button class="btn btn-xs btn-default" type="button" onclick="exp('print', '<?php echo Router::url("daily_processing/print?" . $_SERVER['QUERY_STRING'], true) ?>')">
                            <i class="icon-print2"></i> 
                            <?= __("Cetak") ?>
                        </button>&nbsp;
                        <button class="btn btn-xs btn-default" type="button" onclick="exp('excel', '<?php echo Router::url("daily_processing/excel?" . $_SERVER['QUERY_STRING'], true) ?>')">
                            <i class="icon-file-excel"></i>
                            Excel
                        </button>&nbsp;
                    </div>
                    <small class="display-block"><?= _APP_CORPORATE_FULL ?></small>
                </h6>
            </div>
            <div>
                <div class="panel-heading" style="background:#2179cc">
                    <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Preview Rekapitulasi Laporan Pengolahan Ikan Harian") ?></h6>
                </div>
                <table class="table-bordered table stn-table" style="margin-top:1px;width:100%"> 
                    <tr style="text-align:center;">
                        <th width="30px"></th>
                        <th width="350px" colspan="2">Material Source</th>
                        <th width="420px" colspan="3">Material Result</th>
                        <th width="150px" colspan="3">Percent</th>
                        <th width="80px"></th>
                    </tr>
                    <tr style="text-align:center;">
                        <th width="30px">No</th>
                        <th width="200px">Name Of Fish</th>
                        <th width="150px">Measurement /KG</th>
                        <th width="200px">Name Of Fish</th>
                        <th width="150px">Measurement /KG</th>
                        <th width="80px">Broken</th>
                        <th width="80px">Result</th>
                        <th width="80px">Range</th>
                        <th width="80px">Variance</th>
                        <th width="150px">Description</th>
                    </tr>
                    <?php if (empty($data['rows'])) {
                        ?>
                        <tr>
                            <td class = "text-center" colspan ="10">Tidak Ada Data</td>
                        </tr>
                        <?php
                    } else {
                        ?>
                        <?php
                        $number = 1;
                        foreach ($data['rows']as $conversion) {
                            $sourceList = array();
                            $resultList = array();
                            foreach ($conversion['MaterialEntry']['MaterialEntryGrade'] as $source) {
                                array_push($sourceList, ['label' => $source['MaterialDetail']['Material']['name'] . " - " . $source['MaterialDetail']['name'], 'weight' => $source['weight']]);
                            }
                            foreach ($conversion['ConversionData'] as $result) {
                                array_push($resultList, ['label' => $result['MaterialDetail']['Material']['name'] . " - " . $result['MaterialDetail']['name'], 'weight' => $result['material_size_quantity']]);
                            }
                            ?>

                            <?php
                            $count = 0;
                            $countSource = count($sourceList);
                            $countResult = count($resultList);
                            if ($countSource > $countResult) {
                                $count = $countSource;
                            } else {
                                $count = $countResult;
                            }
                            for ($i = 0; $i < $count; $i++) {
                                ?>    
                                <tr>
                                    <?php
                                    if ($i == 0) {
                                        ?>
                                        <td><?= $number ?></td>
                                        <?php
                                    } else {
                                        ?>
                                        <td></td>
                                        <?php
                                    }
                                    ?>
                                    <!--Set List Surce-->
                                    <?php
                                    if ($i < $countSource) {
                                        ?>
                                        <td><?= $sourceList[$i]['label'] ?></td>
                                        <td><?= $sourceList[$i]['weight'] ?></td>
                                        <?php
                                    } else {
                                        ?>
                                        <td></td>
                                        <td></td>
                                        <?php
                                    }
                                    ?>
                                    <!--Set List Result-->
                                    <?php
                                    if ($i < $countResult) {
                                        ?>
                                        <td><?= $resultList[$i]['label'] ?></td>
                                        <td><?= $resultList[$i]['weight'] ?></td>
                                        <?php
                                    } else {
                                        ?>
                                        <td></td>
                                        <td></td>
                                        <?php
                                    }
                                    ?>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr> 
                                <?php
                            }
                            ?>
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