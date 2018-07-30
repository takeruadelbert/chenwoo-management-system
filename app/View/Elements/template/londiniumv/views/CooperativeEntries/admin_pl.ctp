<?php
echo $this->element(_TEMPLATE_DIR . "/{$template}/filter/cooperative-entry_pl");
?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("LAPORAN LABA/RUGI KOPERASI") ?> | Periode : <?= $this->Echo->laporanPeriodeBulan($start_date, $end_date) ?>
                <div class="pull-right">
                    <button class="btn btn-xs btn-default" type="button" onclick="exp('print', '<?php echo Router::url("pl/print?" . $_SERVER['QUERY_STRING'], true) ?>')">
                        <i class="icon-print2"></i> 
                        <?= __("Cetak") ?>
                    </button>&nbsp;
                    <button class="btn btn-xs btn-default" type="button" onclick="exp('excel', '<?php echo Router::url("pl/excel?" . $_SERVER['QUERY_STRING'], true) ?>')">
                        <i class="icon-file-excel"></i>
                        Excel
                    </button>&nbsp;
                </div>
                <small class="display-block"><?= _APP_CORPORATE_FULL ?></small>
            </h6>
        </div>
        <div class="table-responsive pre-scrollable stn-table stn-table-nowrap">
            <form id="checkboxForm" method="post" name="checkboxForm" action="<?php echo Router::url('/' . $this->params['prefix'] . '/' . $this->params['controller'] . '/multiple_delete', true); ?>">
                <table width="100%" class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th width="50">No</th>
                            <th><?= __("Uraian") ?></th>
                            <th><?= __("Nominal") ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $total = [
                            "income" => 0,
                            "outcome" => 0,
                        ];
                        $totaloutcome = 0;
                        foreach ($result as $typeName => $dataPL) {
                            $i = 1;
                            if ($typeName == "netral") {
                                continue;
                            }
                            ?>
                            <tr>
                                <td class="text-left" colspan="3">
                                    <b>
                                        <?= mapNamePL($typeName) ?>
                                    </b>
                                </td>
                            </tr>
                            <?php
                            foreach ($dataPL as $code => $pl) {
                                ?>
                                <tr >
                                    <td class="text-center"><?= $i ?></td>
                                    <td class="text-left"><?= $mapNameCooperativeEntryType[$code] ?></td>
                                    <td class="text-right"><?= ic_rupiah($pl["amount"]) ?></td>
                                </tr>
                                <?php
                                $total[$typeName]+=$pl["amount"];
                                $i++;
                            }
                            ?>
                            <tr>
                                <td colspan="2" class="text-left">
                                    <b>Total <?= mapNamePL($typeName) ?></b>
                                </td>
                                <td class="text-right">
                                    <b>
                                        <?= ic_rupiah($total[$typeName]) ?>
                                    </b>
                                </td>
                            </tr>
                            <?php
                        }
                        $grandTotal = $total["income"] - $total["outcome"];
                        ?>
                        <tr>
                            <td colspan="2" class="text-left">
                                <b>Total <?= determineNamePL($grandTotal) ?></b>
                            </td>
                            <td class="text-right">
                                <b>
                                    <?= ic_rupiah($grandTotal) ?>
                                </b>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </form>
        </div>
    </div>
</div>