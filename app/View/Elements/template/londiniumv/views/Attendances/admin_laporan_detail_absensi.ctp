<?php
echo $this->element(_TEMPLATE_DIR . "/{$template}/filter/laporan-detail-absensi");
if (isset($result)) {
    $dateRange = createDateRangeArray($start_date, $end_date);
    $belumAbsen = [];
    foreach ($dateRange as $tglBelumAbsen) {
        $belumAbsen[$tglBelumAbsen] = 0;
    }
    ?>
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="block-inner text-danger">
                <h6 class="heading-hr"><?= __("DATA ABSENSI PEGAWAI") . " | Periode " . $this->Echo->laporanPeriodeBulan($start_date, $end_date) ?>
                    <div class="pull-right">
                        <button class="btn btn-xs btn-default" type="button" onclick="exp('print', '<?php echo Router::url("laporan_detail_absensi/print?" . $_SERVER['QUERY_STRING'], true) ?>')">
                            <i class="icon-print2"></i> 
                            <?= __("Cetak") ?>
                        </button>&nbsp;
                        <button class="btn btn-xs btn-default" type="button" onclick="exp('excel', '<?php echo Router::url("laporan_detail_absensi/excel?" . $_SERVER['QUERY_STRING'], true) ?>')">
                            <i class="icon-file-excel"></i>
                            Excel
                        </button>&nbsp;
                    </div>
                    <small class="display-block"><?= _APP_CORPORATE_FULL ?></small>
                </h6>
            </div>
            <div class="table-responsive pre-scrollable stn-table stn-table-nowrap">
                <form id="checkboxForm" method="post" name="checkboxForm" action="<?php echo Router::url('/' . $this->params['prefix'] . '/' . $this->params['controller'] . '/multiple_delete', true); ?>">
                    <table width="100%" class="table table-hover table-bordered" style="width:100%;">
                        <thead>
                            <tr>
                                <th rowspan="2" width="50">No</th>
                                <th rowspan="2" width="350"><?= __("Pegawai") ?></th>
                                <th rowspan="2" width="200"><?= __("Tanggal") ?></th>
                                <th rowspan="2" width="125"><?= __("Jam Masuk") ?></th>
                                <th rowspan="2" width="125"><?= __("Jam Pulang") ?></th>
                                <th rowspan="2" width="125"><?= __("Masuk Lembur") ?></th>
                                <th rowspan="2" width="125"><?= __("Pulang Lembur") ?></th>
                                <th colspan="2" ><?= __("Jumlah Jam Kerja") ?></th>
                                <th rowspan="2" width="100"><?= __("Status") ?></th>
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
                                foreach ($item['data'] as $tgl => $dataAbsensi) {
                                    if ($dataAbsensi['belum_absen']) {
                                        $belumAbsen[$tgl] ++;
                                    }
                                    ?>
                                    <tr>
                                        <td class="text-center"><?= $i ?></td>
                                        <td class="text-left"><?= $employees[$employee_id] ?></td>
                                        <td class="text-center"><?= $this->Html->cvtHariTanggal($tgl) ?></td>
                                        <td class="text-center">
                                            <?php
                                            if ($dataAbsensi['ispasseddate'] === false) {
                                                ?>
                                                <span class="label label-warning">No Data</span>
                                                <?php
                                            } else if ($dataAbsensi['libur']) {
                                                if ($dataAbsensi['jumlah_jam_kerja'] > 0 || $dataAbsensi['jumlah_jam_lembur'] > 0) {
                                                    if ($dataAbsensi['jumlah_jam_lembur'] == 0 && $dataAbsensi['jumlah_jam_kerja'] == 0) {
                                                        ?>
                                                        <span class="label label-warning"><?= $dataAbsensi['masuk'] ?> ***</span>
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <span class="label label-success"><?= $dataAbsensi['masuk'] ?> **</span>
                                                        <?php
                                                    }
                                                } else {
                                                    ?>
                                                    <span class="label label-info">Libur</span>
                                                    <?php
                                                }
                                            } else if (!$dataAbsensi['libur']) {
                                                if ($dataAbsensi['lupa_absen']) {
                                                    ?>
                                                    <span class="label label-success"><?= emptyToStrip($dataAbsensi['masuk']) ?> *</span>
                                                    <?php
                                                } else if ($dataAbsensi['permit']) {
                                                    ?>
                                                    <span class="label label-success"><?= $dataAbsensi['jenis_ijin'] ?></span>
                                                    <?php
                                                } else if ($dataAbsensi['masuk'] == null) {
                                                    ?>
                                                    <span class="label label-danger">Absen</span>
                                                    <?php
                                                } else if ($dataAbsensi['absen']) {
                                                    ?>
                                                    <span class="label label-danger"><?= emptyToStrip($dataAbsensi['masuk']) ?></span>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <span class="label <?= $dataAbsensi['terlambat'] > 0 ? "label-warning" : "label-success" ?>"><?= emptyToStrip($dataAbsensi['masuk']) ?></span>
                                                    <?php
                                                }
                                            } else {
                                                if ($dataAbsensi['jumlah_jam_kerja'] > 0) {
                                                    ?>
                                                    <span class="label label-success"><?= emptyToStrip($dataAbsensi['masuk']) ?></span>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <span class="label label-info">Libur</span>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </td>
                                        <td class="text-center">
                                            <?php
                                            if ($dataAbsensi['pulang'] == null) {
                                                ?>
                                                -
                                                <?php
                                            } else {
                                                ?>
                                                <span class="label <?= $dataAbsensi['pulang_lebih_awal'] > 0 ? "label-warning" : "label-success" ?>"><?= emptyToStrip($dataAbsensi['pulang']) ?>
                                                    <?php
                                                }
                                                ?>
                                        </td>
                                        <td class="text-center"><?= emptyToStrip($dataAbsensi['lembur_masuk']) ?></td>
                                        <td class="text-center"><?= emptyToStrip($dataAbsensi['lembur_pulang']) ?></td>
                                        <td class="text-center">
                                            <span class="label <?= $dataAbsensi['jumlah_jam_kerja'] >= $dataAbsensi['jumlah_jam_kerja_seharusnya'] ? "label-success" : "label-warning" ?>"><?= $this->Html->toHHMMSS($dataAbsensi['jumlah_jam_kerja']) ?></span>
                                        </td>
                                        <td class="text-center"><?= $this->Html->toHHMMSS($dataAbsensi['jumlah_jam_lembur'], true) ?></td>
                                        <td class="text-center"><?= $dataAbsensi['status'] ?></td>
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
            <br/>
            <ul style="list-style: none">
                <li><strong style="color:red">Keterangan : </strong></li>
                <li>* Hadir berdasarkan lupa absen.</li>
                <li>** Hadir pada hari libur.</li>
                <li>*** Hadir pada hari libur (belum ada form lembur).</li>
                <li>- Untuk Staff Bulanan, pada tgl merah, jumlah jam lembur sudah dikali 2</li>
            </ul>
            <br/>
            <ul style="list-style: none">
                <li><strong style="color:red">Jumlah pegawai belum absen per hari (sesuai filter pegawai) </strong></li>
                <?php
                foreach ($belumAbsen as $tglBelumAbsen => $jumlah) {
                    ?>
                    <li>
                        <?= $tglBelumAbsen ?> : <?= $jumlah ?>
                    </li>
                    <?php
                }
                ?>
            </ul>
        </div>
    </div>
    <?php
} else {
    ?>
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="block-inner text-danger text-center">
                <h6 class="heading-hr">
                    Silahkan lakukan filter data terlebih dahulu.
                </h6>
            </div>
        </div>
    </div>
    <?php
}
?>