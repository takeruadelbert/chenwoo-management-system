<?php
echo $this->element(_TEMPLATE_DIR . "/{$template}/filter/laporan-kehadiran");
if (isset($result)) {
    $dateRange = createDateRangeArray($start_date, $end_date);
    $attendanceSummary = [
        "hadir" => [],
        "tidak_hadir" => []
    ];
    foreach ($dateRange as $dateEntity) {
        $attendanceSummary["hadir"][$dateEntity] = 0;
        $attendanceSummary["tidak_hadir"][$dateEntity] = 0;
    }
    ?>
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="block-inner text-danger">
                <h6 class="heading-hr"><?= __("DATA KEHADIRAN PEGAWAI") ?>
                    <div class="pull-right">
                        <button class="btn btn-xs btn-default" type="button" onclick="exp('print', '<?php echo Router::url("laporan_kehadiran/print?" . $_SERVER['QUERY_STRING'], true) ?>')">
                            <i class="icon-print2"></i> 
                            <?= __("Cetak") ?>
                        </button>&nbsp;
                        <button class="btn btn-xs btn-default" type="button" onclick="exp('excel', '<?php echo Router::url("laporan_kehadiran/excel?" . $_SERVER['QUERY_STRING'], true) ?>')">
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
                                <th width="150"><?= __("Pegawai") ?></th>
                                <?php
                                $date = $start_date;
                                while (strtotime($date) <= strtotime($end_date)) {
                                    ?>
                                    <th width="150"><?= $this->Html->cvtHariTanggal($date) ?></th>
                                    <?php
                                    $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));
                                }
                                ?>
                                <th width="150">Jumlah Telat</th>
                                <th width="150">Jumlah Hadir</th>
                                <th width="150">Jumlah Sakit</th>
                                <th width="150">Jumlah Absen</th>
                                <?php
                                foreach ($permitCategories as $name => $label) {
                                    ?>
                                    <th width="150">Jumlah <?= $label ?></th>
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
                                    <td class="text-center"><?= $employees[$employee_id] ?></td>

                                    <?php
                                    $date = $start_date;
                                    while (strtotime($date) <= strtotime($end_date)) {
                                        ?>
                                        <td class="text-center">
                                            <?php
                                            if ($item['data'][$date]['ispasseddate'] === false) {
                                                ?>
                                                <span class="label label-warning">No Data</span>
                                                <?php
                                            } else if (!$item['data'][$date]['libur']) {
                                                if ($item['data'][$date]['lupa_absen']) {
                                                    $attendanceSummary["hadir"][$date] ++;
                                                    ?>
                                                    <span class="label label-success">Hadir*</span>
                                                    <?php
                                                } else if ($item['data'][$date]['permit']) {
                                                    $attendanceSummary["tidak_hadir"][$date] ++;
                                                    ?>
                                                    <span class="label label-success"><?= $item['data'][$date]['jenis_ijin'] ?></span>
                                                    <?php
                                                } else if ($item['data'][$date]['absen']) {
                                                    $attendanceSummary["tidak_hadir"][$date] ++;
                                                    ?>
                                                    <span class="label label-danger">Absen</span>
                                                    <?php
                                                } else {
                                                    $attendanceSummary["hadir"][$date] ++;
                                                    ?>
                                                    <span class="label label-success">Hadir</span>
                                                    <?php
                                                }
                                            } else {
                                                if ($item['data'][$date]['jumlah_jam_kerja'] > 0) {
                                                    $attendanceSummary["hadir"][$date] ++;
                                                    ?>
                                                    <span class="label label-success">Hadir**</span>
                                                    <?php
                                                } else {
                                                    $attendanceSummary["tidak_hadir"][$date] ++;
                                                    ?>
                                                    <span class="label label-info">Libur</span>
                                                    <?php
                                                }
                                            }
                                            ?>

                                        </td>
                                        <?php
                                        $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));
                                    }
                                    ?>
                                    <td class="text-center"><?= @$item['summary']['permit']['detail_ijin']['SD'] + @$item['summary']['permit']['detail_ijin']['STD'] + @$item['summary']['permit']['detail_cuti']['CS'] ?></td>
                                    <td class="text-center"><?= $item['summary']['jumlah_hadir'] ?></td>
                                    <td class="text-center"><?= $item['summary']['jumlah_hadir'] ?></td>
                                    <td class="text-center"><?= $item['summary']['jumlah_absen'] ?></td>
                                    <?php
                                    foreach ($permitCategories as $name => $label) {
                                        ?>
                                        <td class="text-center"><?= $item['summary']['permit']["jumlah_{$name}"] ?></td>
                                        <?php
                                    }
                                    ?>
                                </tr>
                                <?php
                                $i++;
                            }
                            ?>
                            <tr>
                                <td colspan="2" class="text-right">Jumlah Hadir</td>
                                <?php
                                $date = $start_date;
                                while (strtotime($date) <= strtotime($end_date)) {
                                    ?>
                                    <td class="text-center"><?= $attendanceSummary["hadir"][$date] ?></td>
                                    <?php
                                    $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));
                                }
                                ?>
                                <td colspan="8"></td>
                            </tr>
                            <tr>
                                <td colspan="2" class="text-right">Jumlah Tidak Hadir</td>
                                <?php
                                $date = $start_date;
                                while (strtotime($date) <= strtotime($end_date)) {
                                    ?>
                                    <td class="text-center"><?= $attendanceSummary["tidak_hadir"][$date] ?></td>
                                    <?php
                                    $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));
                                }
                                ?>
                                <td colspan="8"></td>
                            </tr>
                        </tbody>
                    </table>
                    <br/>
                    <ul style="list-style: none">
                        <li>* Hadir berdasarkan lupa absen.</li>
                        <li>** Hadir pada hari libur.</li>
                    </ul>
                </form>
            </div>
        </div>
    </div>
    <?php
}
?>