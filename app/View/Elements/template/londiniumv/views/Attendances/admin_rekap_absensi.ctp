<?php
echo $this->element(_TEMPLATE_DIR . "/{$template}/filter/rekap-absensi");
?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("REKAPITULASI ABSENSI") ?>
                <div class="pull-right">
                    <button class="btn btn-xs btn-default" type="button" onclick="exp('print', '<?php echo Router::url("rekap_absensi/print?" . $_SERVER['QUERY_STRING'], true) ?>')">
                        <i class="icon-print2"></i> 
                        <?= __("Cetak") ?>
                    </button>&nbsp;
                    <button class="btn btn-xs btn-default" type="button" onclick="exp('excel', '<?php echo Router::url("rekap_absensi/excel?" . $_SERVER['QUERY_STRING'], true) ?>')">
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
                            <th rowspan="2" width="50">No</th>
                            <th rowspan="2" width="75"><?= __("Periode") ?></th>
                            <th rowspan="2" width="250"><?= __("Nama Pegawai") ?></th>
                            <th rowspan="2" width="200"><?= __("locale0002") ?></th>
                            <th colspan="<?= 3 + count($permitTypeList) ?>">Uraian</th>
                        </tr>
                        <tr>
                            <th width="50">TD</th>
                            <th width="50">CP</th>
                            <th width="50">MGKIR</th>
                            <?php
                            foreach ($permitTypeList as $permitType) {
                                ?>
                                <th width="50"><?= $permitType["PermitType"]["uniq_name"] ?></th>
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
                        foreach ($result as $employee_id => $item) {
                            ?>
                            <tr>
                                <td class="text-center"><?= $i ?></td>
                                <td class="text-center"><?= empty($currentMY) ? $currentYear : $this->Html->cvtBulanTahun($currentMY); ?></td>
                                <td class="text-left"><?= $employees[$employee_id] ?></td>
                                <td class="text-left"><?= $empData[$employee_id]["Department"]["name"] ?></td>
                                <td class="text-center"><?= emptyToStrip($item['summary']['jumlah_telat']) ?></td>
                                <td class="text-center"><?= emptyToStrip($item['summary']['jumlah_cepat_pulang']) ?></td>
                                <td class="text-center"><?= emptyToStrip($item['summary']['jumlah_absen']) ?></td>
                                <?php
                                foreach ($permitTypeList as $permitType) {
                                    ?>
                                    <td class="text-center"><?= issetAndNotEmpty(@$item['summary']["permit"]['detail_' . $permitType["PermitCategory"]["name"]][$permitType["PermitType"]["uniq_name"]], "-") ?></td>
                                    <?php
                                }
                                ?>
                            </tr>
                            <?php
                            $i++;
                        }
                        ?>
                    </tbody>
                </table>
            </form>
        </div>
        <br/>
        <ul style="list-style: none">
            <li><strong style="color:red">Keterangan : </strong></li>
                <?php
                foreach ($permitTypeList as $permitType) {
                    ?>
                <li>- <?= $permitType["PermitType"]["uniq_name"] ?> = <?= $permitType["PermitType"]["name"] ?></li>
                <?php
            }
            ?>
        </ul>
    </div>
</div>