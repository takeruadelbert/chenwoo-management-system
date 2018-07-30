<div style="text-align: center">
    <div style="font-size:11px;font-weight: bold; font-family:Tahoma, Geneva, sans-serif;">
        Data Absensi Anda
    </div>
    <div style="font-size:11px;font-style: italic; font-family:Tahoma, Geneva, sans-serif;">Periode : <?= $this->Html->cvtTanggal($start_date) ?> - <?= $this->Html->cvtTanggal($end_date) ?></div>
    <div class="smallfont"><?= $stnAdmin->getEmployeeFullname() ?></div>
</div>
<br>         
<table width="100%" class="table-data">
    <thead>
        <tr>
            <th rowspan="2" width="50">No</th>
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
    <tbody class="nowrap">
        <?php
        $limit = intval(isset($this->params['named']['limit']) ? $this->params['named']['limit'] : 10);
        $page = intval(isset($this->params['named']['page']) ? $this->params['named']['page'] : 1);
        $i = ($limit * $page) - ($limit - 1);
        if (empty($result)) {
            ?>
            <tr>
                <td class = "text-center" colspan = 9>Tidak Ada Data</td>
            </tr>
            <?php
        } else {
            foreach ($result as $employee_id => $item) {
                foreach ($item['data'] as $tgl => $dataAbsensi) {
                    ?>
                    <tr>
                        <td class="text-center"><?= $i ?></td>
                        <td class="text-left"><?= $this->Html->cvtHariTanggal($tgl) ?></td>
                        <td class="text-center">
                            <?php
                            if ($dataAbsensi['ispasseddate'] === false) {
                                ?>
                                <span class="label label-warning">No Data</span>
                                <?php
                            } else if ($dataAbsensi['libur']) {
                                if ($dataAbsensi['jumlah_jam_kerja'] > 0 || $dataAbsensi['jumlah_jam_lembur'] > 0) {
                                    if ($dataAbsensi['jumlah_jam_lembur'] == 0) {
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
                                if ($dataAbsensi['cuti']) {
                                    ?>
                                    <span class="label label-success">Cuti</span>
                                    <?php
                                } else if ($dataAbsensi['dinas']) {
                                    ?>
                                    <span class="label label-success">Dinas</span>
                                    <?php
                                } else if ($dataAbsensi['lupa_absen']) {
                                    ?>
                                    <span class="label label-success"><?= emptyToStrip($dataAbsensi['masuk']) ?> *</span>
                                    <?php
                                } else if ($dataAbsensi['ijin'] && !in_array($dataAbsensi["jenis_ijin"], ["izin_td", "izin_cp"])) {
                                    ?>
                                    <span class="label label-success">Ijin</span>
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
        }
        ?>
    </tbody>
</table>
<br/>
<ul style="list-style: none" class="smallfont">
    <li><strong style="color:red">Keterangan : </strong></li>
    <li>* Hadir berdasarkan lupa absen.</li>
    <li>** Hadir pada hari libur.</li>
    <li>*** Hadir pada hari libur (belum ada form lembur).</li>
    <li>- Untuk Staff Bulanan, pada tgl merah, jumlah jam lembur sudah dikali 2</li>
</ul>