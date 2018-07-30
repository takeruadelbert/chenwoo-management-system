<?php
echo $this->element(_TEMPLATE_DIR . "/{$template}/filter/annual-permit-report");
?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("LAPORAN SISA CUTI TAHUNAN") . " ($year)" ?>
                <div class="pull-right">
                    <button class="btn btn-xs btn-default" type="button" onclick="exp('print', '<?php echo Router::url("annual_permit_report/print?" . $_SERVER['QUERY_STRING'], true) ?>')">
                        <i class="icon-print2"></i> 
                        <?= __("Cetak") ?>
                    </button>&nbsp;
                    <button class="btn btn-xs btn-default" type="button" onclick="exp('excel', '<?php echo Router::url("annual_permit_report/excel?" . $_SERVER['QUERY_STRING'], true) ?>')">
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
                            <th width="50">No</th>
                            <th><?= __("Nama Pegawai") ?></th>
                            <th><?= __("NIP") ?></th>
                            <th><?= __("Department") ?></th>
                            <th><?= __("Jabatan") ?></th>
                            <th width="100"><?= __("Jatah Tahun Ini") ?></th>
                            <th width="100"><?= __("Pengambilan Tahun Ini") ?></th>
                            <th width="100"><?= __("Sisa Jatah Cuti Tahunan") ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        if (empty($result)) {
                            ?>
                            <tr>
                                <td class = "text-center" colspan = 8>Tidak Ada Data</td>
                            </tr>
                            <?php
                        } else {
//                        if (!empty($result)) {
                            foreach ($result as $employeeId => $cutiCount) {
                                ?>
                                <tr>
                                    <td class="text-center"><?= $i ?></td>
                                    <td class="text-left"><?= $employeeList[$employeeId]["full_name"] ?></td>
                                    <td class="text-left"><?= $employeeList[$employeeId]["nip"] ?></td>
                                    <td class="text-left"><?= $employeeList[$employeeId]["department"] ?></td>
                                    <td class="text-left"><?= $employeeList[$employeeId]["office"] ?></td>
                                    <td class="text-right"><?= $quota ?></td>
                                    <td class="text-right"><?= $cutiCount ?></td>
                                    <td class="text-right"><?= $quota - $cutiCount ?></td>
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
</div>

