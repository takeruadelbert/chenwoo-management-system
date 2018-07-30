<?php
echo $this->element(_TEMPLATE_DIR . "/{$template}/filter/rekap-jam-kerja");
if (isset($result)) {
    ?>
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="block-inner text-danger">
                <h6 class="heading-hr"><?= __("Rekapilutasi Jam Kerja") ?>
                    <div class="pull-right">
                        <button class="btn btn-xs btn-default" type="button" onclick="exp('print', '<?php echo Router::url("rekap_jam_kerja/print?" . $_SERVER['QUERY_STRING'], true) ?>')">
                            <i class="icon-print2"></i> 
                            <?= __("Cetak") ?>
                        </button>&nbsp;
                        <button class="btn btn-xs btn-default" type="button" onclick="exp('excel', '<?php echo Router::url("rekap_jam_kerja/excel?" . $_SERVER['QUERY_STRING'], true) ?>')">
                            <i class="icon-file-excel"></i>
                            Excel
                        </button>&nbsp;
                    </div>
                    <small class="display-block"><?= _APP_CORPORATE_FULL ?></small>
                </h6>
            </div>
            <div class="table-responsive pre-scrollable stn-table">
                <table width="100%" class="table table-hover table-bordered" id="table-rekapjamkerja">
                    <thead>
                        <tr style="-webkit-box-shadow: 10px 0 5px -2px #888; box-shadow: 5px 0 5px -2px #ccc;">
                            <th width="10">No</th>
                            <th width="350"><?= __("Nama Pegawai") ?></th>
                            <th>Ket</th>
                            <?php
                            $date = $start_date;
                            $total = 0;
                            while (strtotime($date) <= strtotime($end_date)) {
                                $isHoliday = in_array($date, array_keys($dataHoliday));
                                ?>
                                <th width="100" <?= $isHoliday ? "title='{$dataHoliday[$date]}'" : "" ?> style="<?= $isHoliday ? "background-color:#a50000;color:#fff;cursor:help" : "" ?>"><?= $this->Html->cvtHariTanggal($date, false) ?></th>
                                <?php
                                $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));
                                $total++;
                            }
                            ?>
                            <th width="150">Jumlah Hari Kerja</th>
                            <th width="150">Jumlah Hari Lembur</th>
                            <th width="150">Jumlah Absen</th>
                            <?php
                            $total+=count($permitCategories);
                            foreach ($permitCategories as $name => $label) {
                                ?>
                                <th width="150"><?= $label ?></th>
                                <?php
                            }
                            ?>
                            <th width="150">Total Jam Kerja</th>
                            <th width="150">Total Jam Lembur</th>
                        </tr>
                        <tr>
                            <?php
                            for ($n = 0; $n <= $total + 8; $n++) {
                                ?>
                                <td bgcolor="#cce3ff" style="padding:0px !important; max-height:2px;">&nbsp;</td>
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
                                <td rowspan="6" class="text-center"><?= $i ?></td>
                                <td rowspan="6" class="text-left"><?= $employees[$employee_id] ?></td>
                                <td style="-webkit-box-shadow: 10px 0 5px -2px #888; box-shadow: 5px 0 5px -2px #888;">Masuk</td>
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
                                <td style="-webkit-box-shadow: 10px 0 5px -2px #888; box-shadow: 5px 0 5px -2px #888;">Pulang</td>
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
                                <td style="-webkit-box-shadow: 10px 0 5px -2px #888; box-shadow: 5px 0 5px -2px #888;">Jam Kerja</td>
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
                                <td style="-webkit-box-shadow: 10px 0 5px -2px #888; box-shadow: 5px 0 5px -2px #888;">Masuk Lembur</td>
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
                                <td style="-webkit-box-shadow: 10px 0 5px -2px #888; box-shadow: 5px 0 5px -2px #888;">Pulang Lembur</td>
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
                                <td style="-webkit-box-shadow: 10px 0 5px -2px #888; box-shadow: 5px 0 5px -2px #888;">Jumlah Lembur</td>
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
            </div>
            <br/>
            <ul style="list-style: none">
                <li><strong style="color:red">Keterangan : </strong></li>
                <li>* Hadir berdasarkan lupa absen.</li>
                <li>** Hadir pada hari libur.</li>
                <li>*** Hadir pada hari libur (belum ada form lembur).</li>
                <li>- Untuk Staff Bulanan, pada tgl merah, jumlah jam lembur sudah dikali 2</li>
            </ul>
        </div>
    </div>
    <?php
}
?>
<script>
    $(document).ready(function () {
        $("#table-rekapjamkerja").tableHeadFixer({"left": 3})
    })
</script>