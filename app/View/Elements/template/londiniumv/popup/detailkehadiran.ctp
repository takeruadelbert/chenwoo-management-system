<?php
$emp_id = $query['employee_id'];
$start_date = $query['start'];
$end_date = $query['end'];

$employeeData = ClassRegistry::init("Employee")->find("first", [
    "contain" => [
        "Account" => [
            "Biodata",
            "User",
        ],
        "Department",
        "Office",
    ],
    "conditions" => [
        "Employee.id" => $emp_id,
    ]
        ]);
$result = ClassRegistry::init("Attendance")->buildReport($start_date, $end_date, $emp_id);
//debug($result);
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">Laporan Absen Pegawai</h4>
</div>
<!-- New invoice template -->
<div class="panel">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr">LAPORAN ABSEN PEGAWAI <div class="pull-right" >
                    <button class="btn btn-xs btn-default" type="button" onclick="exp('print', '<?php echo Router::url("/admin/attendances/absensi_kehadiran/print?" . "Laporan.pegawai=" . $emp_id . "&" . "Laporan.tanggal_awal=" . $start_date . "&" . "Laporan.tanggal_akhir=" . $end_date . "&show=1", true) ?>')">
                        <i class="icon-print2"></i> Print</button>&nbsp;
                    <button class="btn btn-xs btn-default" type="button" onclick="exp('excel', '<?php echo Router::url("/admin/attendances/absensi_kehadiran/excel?" . "Laporan.pegawai=" . $emp_id . "&" . "Laporan.tanggal_awal=" . $start_date . "&" . "Laporan.tanggal_akhir=" . $end_date . "&show=1", true) ?>')">
                        <i class="icon-file-excel"></i> Excel</button>&nbsp;
                </div><small class="display-block"><?= _APP_CORPORATE_FULL ?></small></h6>
        </div>
        <!-- Page tabs -->
        <div class="tabbable page-tabs">
            <div class="table-responsive pre-scrollable stn-table">
                <form id="checkboxForm" method="post" name="checkboxForm" action="<?php echo Router::url('/' . $this->params['prefix'] . '/' . $this->params['controller'] . '/multiple_delete', true); ?>">
                    <table width="100%" class="table table-bordered">
                        <tbody>
                            <?php
                            foreach ($result as $employee_id => $item) {
                                ?>
                                <tr>
                                    <td width="2%" rowspan="2"><a href="<?= Router::url($employeeData['Account']['User']['profile_picture'], true) ?>" class="lightbox" title="<?= $employeeData['Account']['Biodata']['full_name'] ?>"><img src="<?= Router::url($employeeData['Account']['User']['profile_picture'], true) ?>" alt="" class="img-media"></a></td>
                                    <td width="15%">Nama Pegawai</td>
                                    <td width="1%" align="center" valign="middle">:</td>
                                    <td width="34%"><?= $employeeData['Account']['Biodata']['full_name'] ?></td>
                                    <td width="15%">Bidang</td>
                                    <td width="1%" align="center">:</td>
                                    <td width="34%"><?= $employeeData['Department']['name'] ?></td>
                                </tr>
                                <tr>
                                    <td>Jabatan</td>
                                    <td align="center" valign="middle">:</td>
                                    <td><?= $employeeData['Office']['name'] ?></td>
                                    <td>Periode Laporan</td>
                                    <td align="center">:</td>
                                    <td><?= $this->Html->cvtTanggal($start_date) . " s/d " . $this->Html->cvtTanggal($end_date) ?></td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                    <br>
                    <table width="100%" class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th rowspan="2" width="50">No</th>
                                <th rowspan="2" width="150">Hari</th>
                                <th rowspan="2" width="150">Tanggal</th>
                                <th rowspan="2" width="150">Masuk</th>
                                <th rowspan="2" width="150">Pulang</th>
                                <th rowspan="2" width="150">Masuk Lembur</th>
                                <th rowspan="2" width="150">Pulang Lembur</th>
                                <th colspan="2" width="150">Jumlah Jam Kerja</th>
                                <th rowspan="2" width="150">Keterangan</th>
                            </tr>
                            <tr>
                                <th width="125"><?= __("Normal") ?></th>
                                <th width="125"><?= __("Lembur") ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $limit = intval(isset($this->params['named']['limit']) ? $this->params['named']['limit'] : 10);
                            $page = intval(isset($this->params['named']['page']) ? $this->params['named']['page'] : 1);
                            $i = ($limit * $page) - ($limit - 1);
                            foreach ($result as $employee_id => $item) {
                                $date = $start_date;
                                while (strtotime($date) <= strtotime($end_date)) {
                                    ?>
                                    <tr>
                                        <td class="text-center"><?= $i ?></td>
                                        <td class="text-center"><?= $this->Echo->hari[date('w', strtotime($date))] ?></td>
                                        <td class="text-center"><?= $date ?></td>
                                        <td class="text-center"><?= emptyToStrip(@$item['data'][$date]['masuk']) ?></td>
                                        <td class="text-center"><?= emptyToStrip(@$item['data'][$date]['pulang']) ?></td>
                                        <td class="text-center"><?= emptyToStrip($item['data'][$date]['lembur_masuk']) ?></td>
                                        <td class="text-center"><?= emptyToStrip($item['data'][$date]['lembur_pulang']) ?></td>
                                        <td class="text-center"><?= $this->Html->toHHMMSS($item['data'][$date]['jumlah_jam_kerja']) ?></td>
                                        <td class="text-center"><?= $this->Html->toHHMMSS($item['data'][$date]['jumlah_jam_lembur'], true) ?></td>
                                        <td class="text-center"><?= $item['data'][$date]['status'] ?></td>
                                    </tr>
                                    <?php
                                    $i++;
                                    $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));
                                }
                            }
                            ?>
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

    <p>&nbsp;</p>

</div>
<!-- /new invoice template -->
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
</div>