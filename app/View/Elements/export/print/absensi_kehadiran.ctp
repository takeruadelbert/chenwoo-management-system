<h3 style="text-align: center">
    Absensi Kehadiran
</h3>
<p style="text-align: center">
    Periode : <?= $this->Html->cvtTanggal($this->request->query['Laporan_tanggal_awal']) ?> - <?= $this->Html->cvtTanggal($this->request->query['Laporan_tanggal_akhir']) ?>
</p>
<table width="100%" class="table table-bordered">
    <tbody>
        <?php
        foreach ($result as $employee_id => $item) {
            ?>
            <tr>
                <td width="2%" rowspan="2"><a href="<?= Router::url($employeeData['Account']['User']['profile_picture'],true)?>" class="lightbox" title="<?= $employeeData['Account']['Biodata']['full_name']?>"><img src="<?= Router::url($employeeData['Account']['User']['profile_picture'],true)?>" alt="" class="img-media"></a></td>
                <td width="15%">Nama Pegawai</td>
                <td width="1%" align="center" valign="middle">:</td>
                <td width="34%"><?= $employees[$employee_id] ?></td>
                <td width="15%"><?= __("locale0002") ?></td>
                <td width="1%" align="center">:</td>
                <td width="34%"><?= $employeeData['Department']['name']?></td>
            </tr>
            <tr>
                <td>Jabatan</td>
                <td align="center" valign="middle">:</td>
                <td><?= $employeeData['Office']['name']?></td>
                <td>Periode Laporan</td>
                <td align="center">:</td>
                <td><?= $this->Html->cvtTanggal($start_date)." s/d ".$this->Html->cvtTanggal($end_date) ?></td>
            </tr>
            <?php
        }
        ?>
    </tbody>
</table>
<br>
<table width="100%" class="table-data">
    <thead>
        <tr>
            <th width="50">No</th>
            <th width="150">Hari</th>
            <th width="150">Tanggal</th>
            <th width="150">Clock In I</th>
            <th width="150">Clock Out I</th>
            <th width="150">Clock In II</th>
            <th width="150">Clock Out II</th>
            <th width="150">Total Jam</th>
            <th width="150">Keterlambatan</th>
            <th width="150">Keterangan</th>
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
                    <td class="text-center"><?= date('l', strtotime($date)) ?></td>
                    <td class="text-center"><?= $date ?></td>
                    <td class="text-center"><?= emptyToStrip(@$item['data'][$date]['masuk']) ?></td>
                    <td class="text-center"><?= emptyToStrip(@$item['data'][$date]['keluar_istirahat']) ?></td>
                    <td class="text-center"><?= emptyToStrip(@$item['data'][$date]['kembali_istirahat']) ?></td>
                    <td class="text-center"><?= emptyToStrip(@$item['data'][$date]['pulang']) ?></td>
                    <td class="text-center"><?= gmdate("H:i:s",$item['data'][$date]['jumlah_jam_kerja']) ?></td>
                    <td class="text-center"><?= gmdate("H:i:s",$this->Html->cekKeterlambatan($item['data'][$date]['terlambat'])) ?></td>
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