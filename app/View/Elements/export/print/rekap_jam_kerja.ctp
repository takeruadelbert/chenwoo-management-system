<div style="text-align: center">
    <div style="font-size:11px;font-weight: bold; font-family:Tahoma, Geneva, sans-serif;">
        Data Rekapitulasi Jam Kerja
    </div>
    <div style="font-size:10px;font-weight: 400; font-style: italic; font-family:Tahoma, Geneva, sans-serif;">
        <?= $this->Echo->laporanPeriodeBulan($start_date, $end_date) ?>
    </div>
</div>
<br>
<table width="100%" class="table-data smallfont">
    <thead>
        <tr>
            <th width="50">No</th>
            <th width="250"><?= __("Nama Pegawai") ?></th>
            <th>Ket</th>
            <?php
            $date = $start_date;
            while (strtotime($date) <= strtotime($end_date)) {
                $isHoliday = in_array($date, array_keys($dataHoliday));
                ?>
                <th width="100" <?= $isHoliday ? "title='{$dataHoliday[$date]}'" : "" ?> style="<?= $isHoliday ? "color:#a50000" : "" ?>"><?= $this->Html->cvtHariTanggal($date, false) ?></th>
                <?php
                $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));
            }
            ?>
            <th width="150">Jumlah Hari Kerja</th>
            <th width="150">Jumlah Hari Lembur</th>
            <th width="150">Jumlah Absen</th>
            <?php
            foreach ($permitCategories as $name => $label) {
                ?>
                <th width="150"><?= $label ?></th>
                <?php
            }
            ?>
            <th width="150">Total Jam Kerja</th>
            <th width="150">Total Jam Lembur</th>
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
                <td rowspan="6" class="text-center"><?= $i ?></td>
                <td rowspan="6" class="text-left"><?= $employees[$employee_id] ?></td>
                <td>Masuk</td>
                <?php
                $date = $start_date;
                while (strtotime($date) <= strtotime($end_date)) {
                    if ($item['data'][$date]['ispasseddate'] === false) {
                        ?>
                        <td class="text-center"><span class="label label-warning">No Data</span></td>
                        <?php
                    } else if ($item['data'][$date]['libur']) {
                        if ($item['data'][$date]['jumlah_jam_kerja'] > 0 || $item['data'][$date]['jumlah_jam_lembur'] > 0) {
                            if ($item['data'][$date]['jumlah_jam_lembur'] == 0 && $item['data'][$date]['jumlah_jam_kerja'] == 0) {
                                ?>
                                <td class="text-center"><span class="label label-warning"><?= $item['data'][$date]['masuk'] ?> ***</span></td>
                                <?php
                            } else {
                                ?>
                                <td class="text-center"><span class="label label-success"><?= $item['data'][$date]['masuk'] ?> **</span></td>
                                <?php
                            }
                        } else {
                            ?>
                            <td class="text-center"><span class="label label-info">Libur</span></td>
                            <?php
                        }
                    } else {
                        ?>
                        <td class="text-center">
                            <?php
                            if ($item['data'][$date]['ispasseddate'] === false) {
                                ?>
                                <span class="label label-warning">No Data</span>
                                <?php
                            } else if (!$item['data'][$date]['libur']) {
                                if ($item['data'][$date]['lupa_absen']) {
                                    ?>
                                    <span class="label label-success"><?= emptyToStrip($item['data'][$date]['masuk']) ?> *</span>
                                    <?php
                                } else if ($item['data'][$date]['permit']) {
                                    ?>
                                    <span class="label label-success"><?= $item['data'][$date]['jenis_ijin'] ?></span>
                                    <?php
                                } else if ($item['data'][$date]['masuk'] == null) {
                                    ?>
                                    <span class="label label-danger">Absen</span>
                                    <?php
                                } else if ($item['data'][$date]['absen']) {
                                    ?>
                                    <span class="label label-danger"><?= emptyToStrip($item['data'][$date]['masuk']) ?></span>
                                    <?php
                                } else {
                                    ?>
                                    <span class="label <?= $item['data'][$date]['terlambat'] > 0 ? "label-warning" : "label-success" ?>"><?= emptyToStrip($item['data'][$date]['masuk']) ?></span>
                                    <?php
                                }
                            } else {
                                if ($item['data'][$date]['jumlah_jam_kerja'] > 0) {
                                    ?>
                                    <span class="label label-success"><?= emptyToStrip($item['data'][$date]['masuk']) ?></span>
                                    <?php
                                } else {
                                    ?>
                                    <span class="label label-info">Libur</span>
                                    <?php
                                }
                            }
                            ?>
                        </td>
                        <?php
                    }
                    $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));
                }
                ?>
                <td rowspan="6" class="text-center"><?= $item['summary']['jumlah_hadir'] ?></td>
                <td rowspan="6" class="text-center"><?= $item['summary']['jumlah_hadir_libur'] ?></td>
                <td rowspan="6" class="text-center"><?= $item['summary']['jumlah_absen'] ?></td>
                <?php
                foreach ($permitCategories as $name => $label) {
                    ?>
                    <td rowspan="6" class="text-center"><?= $item['summary']["permit"]['jumlah_' . $name] ?></td>
                    <?php
                }
                ?>
                <td rowspan="6" class="text-center"><?= $this->Html->toHHMMSS(array_sum(array_column($item["data"], "jumlah_jam_kerja"))) ?></td>
                <td rowspan="6" class="text-center"><?= $this->Html->toHHMMSS(array_sum(array_column($item["data"], "jumlah_jam_lembur"))) ?></td>
            </tr>
            <tr>
                <td>Pulang</td>
                <?php
                $date = $start_date;
                while (strtotime($date) <= strtotime($end_date)) {
                    ?>
                    <td class="text-center">
                        <?php
                        if ($item['data'][$date]['pulang'] == null) {
                            ?>
                            -
                            <?php
                        } else {
                            ?>
                            <span class="label <?= $item['data'][$date]['pulang_lebih_awal'] > 0 ? "label-warning" : "label-success" ?>">
                                <?= emptyToStrip($item['data'][$date]['pulang']) ?>
                            </span>
                            <?php
                        }
                        ?>
                    </td>
                    <?php
                    $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));
                }
                ?>
            </tr>
            <tr style="background-color: #D9D9D9">
                <td>Jumlah</td>
                <?php
                $date = $start_date;
                while (strtotime($date) <= strtotime($end_date)) {
                    ?>
                    <td class="text-center"><?= $this->Html->toHHMMSS($item['data'][$date]['jumlah_jam_kerja']) ?></td>
                    <?php
                    $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));
                }
                ?>
            </tr>
            <tr>
                <td>Masuk Lembur</td>
                <?php
                $date = $start_date;
                while (strtotime($date) <= strtotime($end_date)) {
                    ?>
                    <td class="text-center">
                        <?= emptyToStrip($item['data'][$date]['lembur_masuk']) ?>
                    </td>
                    <?php
                    $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));
                }
                ?>
            </tr>
            <tr>
                <td>Pulang Lembur</td>
                <?php
                $date = $start_date;
                while (strtotime($date) <= strtotime($end_date)) {
                    ?>
                    <td class="text-center">
                        <?= emptyToStrip($item['data'][$date]['lembur_pulang']) ?>
                    </td>
                    <?php
                    $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));
                }
                ?>
            </tr>
            <tr style="background-color: #D9D9D9">
                <td>Jumlah</td>
                <?php
                $date = $start_date;
                while (strtotime($date) <= strtotime($end_date)) {
                    ?>
                    <td class="text-center"><?= $this->Html->toHHMMSS($item['data'][$date]['jumlah_jam_lembur']) ?></td>
                    <?php
                    $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));
                }
                ?>
            </tr>
            <?php
            $i++;
        }
        ?>
    </tbody>
</table>
<br/>
<ul style="list-style: none">
    <li><strong style="color:red">Keterangan : </strong></li>
    <li>* Hadir berdasarkan lupa absen.</li>
    <li>** Hadir pada hari libur.</li>
    <li>*** Hadir pada hari libur (belum ada form lembur).</li>
    <li>- Untuk Staff Bulanan, pada tgl merah, jumlah jam lembur sudah dikali 2</li>
</ul>