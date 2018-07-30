<?php
echo $this->element(_TEMPLATE_DIR . "/{$template}/filter/material_entry_ratio");
?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("RATIO PRODUKSI") ?>
                <div class="pull-right">
                    <button class="btn btn-xs btn-default" type="button" onclick="exp('print', '<?php echo Router::url("ratio/print?" . $_SERVER['QUERY_STRING'], true) ?>')">
                        <i class="icon-print2"></i> 
                        <?= __("Cetak") ?>
                    </button>&nbsp;
                    <button class="btn btn-xs btn-default" type="button" onclick="exp('excel', '<?php echo Router::url("ratio/excel?" . $_SERVER['QUERY_STRING'], true) ?>')">
                        <i class="icon-file-excel"></i>
                        Excel
                    </button>&nbsp;
                </div>
                <small class="display-block"><?= _APP_CORPORATE_FULL ?></small>
            </h6>
        </div>
        <div class="table-responsive pre-scrollable stn-table">
            <form id="checkboxForm" method="post" name="checkboxForm" action="<?php echo Router::url('/' . $this->params['prefix'] . '/' . $this->params['controller'] . '/multiple_delete', true); ?>">
                <table width="100%" class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th width="50"><input type="checkbox" class="styled checkall"/></th>
                            <th width="50">No</th>
                            <th><?= __("Nomor Nota Timbang") ?></th>
                            <th width="150"><?= __("Tgl Timbang") ?></th>
                            <th width="150"><?= __("Status") ?></th>
                            <th width="175" colspan = "2"><?= __("Bahan Baku") ?></th>
                            <th width="175"><?= __("Persentase Proses") ?></th>
                            <th width="175" colspan = "2"><?= __("Hasil Produksi") ?></th>
                            <th width="175"><?= __("Ratio") ?></th>
                            <?php
                            if ($stnAdmin->branchPrivilege()) {
                                ?>
                                <th><?= __("Cabang") ?></th>
                                <?php
                            }
                            ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $limit = intval(isset($this->params['named']['limit']) ? $this->params['named']['limit'] : 10);
                        $page = intval(isset($this->params['named']['page']) ? $this->params['named']['page'] : 1);
                        $i = ($limit * $page) - ($limit - 1);
                        if (empty($data['rows'])) {
                            ?>
                            <tr>
                                <td class = "text-center" colspan = "12">Tidak Ada Data</td>
                            </tr>
                            <?php
                        } else {
                            //debug($data['rows']);
                            foreach ($data['rows'] as $item) {
                                $rawFishTotal = 0;
                                $countFish = 0;
                                $countProccesedFish = 0;
                                $total = 0;
                                $satuan = "";
                                $category = "";
                                $statusConversion = 100;
                                $statusLabelConversion = "-";
                                $weightProccesedEntry = 0;
                                $weightProccesedFreeze = 0;
                                $percentageEntry = 0;
                                $percentageFreeze = 0;
                                $percentageTreatment = 0;
                                $percentageProccess = 0;
                                $weightProcessedTreatment = 0;
                                foreach ($item['MaterialEntryGrade'] as $entryGrade) {
                                    foreach ($entryGrade['MaterialEntryGradeDetail'] as $entrydetail) {
                                        if ($entrydetail['is_used'] == 1) {
                                            $countProccesedFish++;
                                        }
                                        $countFish++;
                                    }
                                }
                                foreach (array_column($item["MaterialEntryGrade"], "MaterialEntryGradeDetail") as $materialEntryGradeDetail) {
                                    $rawFishTotal+=array_sum(array_column($materialEntryGradeDetail, "weight"));
                                }
                                if ($item['MaterialEntry']['material_category_id'] == 1) {
                                    $satuan = "Ekor";
                                    $category = "Whole";
                                } else {
                                    $satuan = "Pcs";
                                    $category = "Loin";
                                }
                                foreach ($item['MaterialEntryGrade'] as $entryGrade) {
                                    $weightProccesedEntry+=$entryGrade["weight"] - $entryGrade["remaining_weight"];
                                }
                                if ($item['MaterialEntry']['material_category_id'] == 1) {
                                    $statusLabelConversion = $statusConversion = number_format(($countProccesedFish / $countFish) * 100, 2);
                                    $statusLabelConversion.=" %";
                                }
                                foreach ($item["Treatment"] as $treatment) {
                                    if ($treatment["verify_status_id"] == 3) {
                                        $weightProcessedTreatment+=$treatment["total"];
                                        $weightProccesedFreeze+=$treatment["TreatmentSourceDetail"][0]["weight"];
                                    }
                                }
                                $percentageEntry = $weightProccesedEntry / $rawFishTotal;

                                if ($weightProccesedEntry != 0) {
                                    if ($item['MaterialEntry']['material_category_id'] == 1) {
                                        //harus diganti dengan membagi proccesed conversion
                                        $percentageFreeze = $weightProccesedFreeze / $weightProccesedEntry;
                                    } else {
                                        $percentageFreeze = $weightProccesedFreeze / $weightProccesedEntry;
                                    }
                                }
                                if ($weightProcessedTreatment != 0) {
                                    $percentageTreatment = $weightProcessedTreatment / $weightProccesedFreeze;
                                }
                                $percentageProccess = $percentageTreatment * $percentageFreeze * $percentageEntry;
                                ?>
                                <tr id="row-<?= $i ?>" class="removeRow<?php echo $item["MaterialEntry"]['id']; ?>">
                                    <td class="text-center"><input type="checkbox" name="data[<?php echo Inflector::classify($this->params['controller']) ?>][checkbox][]" value="<?php echo $item["MaterialEntry"]['id']; ?>"  id="checkBoxRow" class="styled checkboxDeleteRow" /></td>
                                    <td class="text-center"><?= $i ?></td>
                                    <td class="text-left"><?php echo $item["MaterialEntry"]['material_entry_number']; ?></td>
                                    <td class="text-center"><?php echo $item["MaterialEntry"]['weight_date__ic']; ?></td>
                                    <td class="text-center">
                                        <span class="label label-<?= $item["MaterialEntry"]["treatment_status_id"] == 1 ? "danger" : "success" ?>"><?= $item["TreatmentStatus"]["name"] ?></span>
                                    </td>
                                    <td class="text-right"><?= ic_kg($rawFishTotal) ?> </td>
                                    <td class="text-right" width = "30">Kg</td>
                                    <td class="text-right"><?= ic_decimalseperator($percentageProccess * 100, 2) ?> %</td>
                                    <td class="text-right"><?= ic_kg($weightProcessedTreatment) ?> </td>
                                    <td class="text-right" width = "30">Kg</td>
                                    <td class="text-right"><?= ic_decimalseperator($weightProcessedTreatment / $rawFishTotal * 100, 2) ?> %</td>
                                    <?php
                                    if ($stnAdmin->branchPrivilege()) {
                                        ?>
                                        <td class="text-left"><?php echo $item["BranchOffice"]['name']; ?></td>
                                        <?php
                                    }
                                    ?>
                                </tr>
                                <?php
                                $i++;
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </form>
        </div>
    </div>
    <?php echo $this->element(_TEMPLATE_DIR . "/{$template}/pagination") ?>
</div>