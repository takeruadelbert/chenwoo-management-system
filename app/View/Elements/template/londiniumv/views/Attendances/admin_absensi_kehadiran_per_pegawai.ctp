<?php
echo $this->element(_TEMPLATE_DIR . "/{$template}/filter/absensi-kehadiran-pegawai-keluar");
if (false) {
    ?>
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="block-inner text-danger">
                <h6 class="heading-hr"><?= __("HASIL PENCARIAN ABSEN PEGAWAI") ?>
                    <div class="pull-right">
                        <button class="btn btn-xs btn-default" type="button" onclick="exp('print', '<?php echo Router::url("absensi_kehadiran/print?" . $_SERVER['QUERY_STRING'], true) ?>')">
                            <i class="icon-print2"></i> 
                            <?= __("Cetak") ?>
                        </button>&nbsp;
                        <button class="btn btn-xs btn-default" type="button" onclick="exp('excel', '<?php echo Router::url("absensi_kehadiran/excel?" . $_SERVER['QUERY_STRING'], true) ?>')">
                            <i class="icon-file-excel"></i>
                            Excel
                        </button>&nbsp;
                    </div>
                    <small class="display-block"><?= _APP_CORPORATE_FULL ?></small>
                </h6>
            </div>
            <div class="table-responsive pre-scrollable stn-table">
                <form id="checkboxForm" method="post" name="checkboxForm" action="<?php echo Router::url('/' . $this->params['prefix'] . '/' . $this->params['controller'] . '/multiple_delete', true); ?>">
                    <table width="100%" class="table table-bordered">
                        <tbody>
                            <?php
                            foreach ($result as $employee_id => $item) {
                                ?>
                                <tr>
                                    <td width="2%" rowspan="2"><a href="<?= Router::url($employeeData['Account']['User']['profile_picture'], true) ?>" class="lightbox" title="<?= $employeeData['Account']['Biodata']['full_name'] ?>"><img src="<?= Router::url($employeeData['Account']['User']['profile_picture'], true) ?>" alt="" class="img-media"></a></td>
                                    <td width="20%">Nama Pegawai</td>
                                    <td width="1%" align="center" valign="middle">:</td>
                                    <td width="34%"><?= $employees[$employee_id] ?></td>
                                    <td width="15%"><?= __("locale0002") ?></td>
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
                                <th width="50">No</th>
                                <th width="150">Hari</th>
                                <th width="150">Tanggal</th>
                                <th width="150">Masuk</th>
                                <th width="150">Keluar Istirahat</th>
                                <th width="150">Balik Istirahat</th>
                                <th width="150">Pulang</th>
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
                                        <td class="text-center"><?= $this->Echo->hari[date('w', strtotime($date))] ?></td>
                                        <td class="text-center"><?= $date ?></td>
                                        <td class="text-center"><?= emptyToStrip(@$item['data'][$date]['masuk']) ?></td>
                                        <td class="text-center"><?= emptyToStrip(@$item['data'][$date]['keluar_istirahat']) ?></td>
                                        <td class="text-center"><?= emptyToStrip(@$item['data'][$date]['kembali_istirahat']) ?></td>
                                        <td class="text-center"><?= emptyToStrip(@$item['data'][$date]['pulang']) ?></td>
                                        <td class="text-center"><?= gmdate("H:i:s", $item['data'][$date]['jumlah_jam_kerja']) ?></td>
                                        <td class="text-center"><?= gmdate("H:i:s", $this->Html->cekKeterlambatan($item['data'][$date]['terlambat'])) ?></td>
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
    <?php
} else {
    $total_persentase_kehadiran = 0;
    $total_persentase_absen = 0;
    foreach ($permitCategories as $un => $permitCategory) {
        $total_presentase_permit[$un] = 0;
    }
    $count_row = 0;
    ?>
    <div class = "panel panel-default">
        <div class = "panel-body">
            <div class = "block-inner text-danger">
                <h6 class = "heading-hr">DATA ABSENSI PEGAWAI <div class = "pull-right">
                        <button class = "btn btn-xs btn-default" type = "button" onclick="exp('print', '<?php echo Router::url("absensi_kehadiran_per_pegawai/print?" . $_SERVER['QUERY_STRING'], true) ?>')"><i class = "icon-print2"></i> Cetak</button>&nbsp;
                        <button class = "btn btn-xs btn-default" type = "button" onclick="exp('excel', '<?php echo Router::url("absensi_kehadiran_per_pegawai/excel?" . $_SERVER['QUERY_STRING'], true) ?>')"><i class = "icon-file-excel"></i> Excel</button>&nbsp;
                    </div>
                    <small class = "display-block"><?= _APP_CORPORATE_FULL ?></small>
                </h6>
            </div>
            <div class = "table-responsive">
                <table width = "100%" border = "0" align = "center" class = "table table-bordered">
                    <tbody>
                        <tr>
                            <td align = "center"><strong>REKAP ABSENSI PEGAWAI</strong></td>
                        </tr>
                        <tr>
                            <td align = "center">Periode Bulan : <?= $this->Html->getBulan($start_date) . " " . $this->Html->getTahun($start_date) ?></td>
                        </tr>
                    </tbody></table>
                <br>
                <div class = "table-responsive pre-scrollable">
                    <table width = "100%" class = "table table-hover table-bordered">
                        <thead>
                            <tr>
                                <!--<th width = "1%" rowspan = "3" align = "center" valign = "middle" bgcolor = "#FFFFCC" style = " text-align:center">#</th>-->
                                <th width = "1%" rowspan = "3" align = "center" valign = "middle" bgcolor = "#FFFFCC" style = " text-align:center">No</th>
                                <th width = "3%" rowspan = "3" align = "center" valign = "middle" bgcolor = "#FFFFCC" style = " text-align:center">Foto</th>
                                <th width = "20%" rowspan = "3" bgcolor = "#FFFFCC" style = " text-align:center">Nama / NIP Pegawai</th>
                                <th width = "15%" rowspan = "3" bgcolor = "#FFFFCC" style = " text-align:center">JABATAN</th>
                                <th width = "15%" rowspan = "3" bgcolor = "#FFFFCC" style = " text-align:center"><?= __("locale0002") ?></th>
                                <?php
                                $arrWeeks = splitWeeks($start_date, $end_date);
                                $i = 1;
                                foreach ($arrWeeks as $week) {
                                    ?>
                                    <th colspan = "6" bgcolor = "#FFFFCC" style = " text-align:center"><?= "Minggu " . $i ?></th>
                                    <?php
                                    $i++;
                                }
                                ?>
                                <th colspan = "6" rowspan = "2" bgcolor = "#FFFFCC" style = " text-align:center">Jumlah</th>
                                <th colspan = "6" rowspan = "2" bgcolor = "#FFFFCC" style = " text-align:center">Persentase (%)</th>
                                <!--<th width = "2%" rowspan = "3" bgcolor = "#FFFFCC" style = " text-align:center">Lihat</th>-->
                            </tr>
                            <tr>
                                <?php
                                $minggu = 0;
                                $count = 0;
                                foreach ($arrWeeks as $week) {
                                    ?>
                                    <th colspan = "6" bgcolor = "#FFFFCC" style = " text-align:center"><?= $this->Html->getTanggal($arrWeeks[$minggu][0]) . " - " . $this->Html->cvtTanggal(end($week)) ?></th>
                                    <?php
                                    $minggu++;
                                }
                                ?>
                            </tr>
                            <tr>
                                <?php
                                foreach ($arrWeeks as $week) {
                                    ?>
                                    <th style = " text-align:center" width = "1%" bgcolor = "#FFFFCC">H</th>
                                    <th style = " text-align:center" width = "1%" bgcolor = "#FFFFCC">A</th>
                                    <?php
                                    foreach ($permitCategories as $permitCategory) {
                                        ?>
                                        <th style = " text-align:center" width = "1%" bgcolor = "#FFFFCC"><?= substr($permitCategory, 0, 1) ?></th>
                                        <?php
                                    }
                                    ?>
                                    <?php
                                }
                                ?>
                                <th width = "1%" bgcolor = "#FFFFCC" style = " text-align:center">H</th>
                                <th width = "1%" bgcolor = "#FFFFCC" style = " text-align:center">A</th>
                                <?php
                                foreach ($permitCategories as $permitCategory) {
                                    ?>
                                    <th style = " text-align:center" width = "1%" bgcolor = "#FFFFCC"><?= substr($permitCategory, 0, 1) ?></th>
                                    <?php
                                }
                                ?>
                                <th style = " text-align:center" width = "1%" bgcolor = "#FFFFCC">H</th>
                                <th style = " text-align:center" width = "1%" bgcolor = "#FFFFCC">A</th>
                                <?php
                                foreach ($permitCategories as $permitCategory) {
                                    ?>
                                    <th style = " text-align:center" width = "1%" bgcolor = "#FFFFCC"><?= substr($permitCategory, 0, 1) ?></th>
                                    <?php
                                }
                                ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            ?>
                            <tr>
                                <!--<td width = "1%" align = "center" valign = "middle" style = " text-align:center"><div class = "checker"><span><input type = "checkbox" name = "checkRow" class = "styled"></span></div></td>-->
                                <td width = "1%" align = "center" valign = "middle" style = " text-align:center"><?= $i ?></td>
                                <td width = "3%" align = "center" valign = "middle" class = "text-center"><a href = "<?= Router::url($empData['Account']['User']['profile_picture'], true) ?>" class = "lightbox" title = "<?= $empData['Account']['Biodata']['full_name'] ?>"><img src = "<?= Router::url($empData['Account']['User']['profile_picture'], true) ?>" alt = "" class = "img-media"></a></td>
                                <td width = "20%" style = " text-align:left"><?= $empData['Account']['Biodata']['full_name'] ?><br><?= $empData['Employee']['nip'] ?></td>
                                <td width = "15%" style = " text-align:center"><?= $empData['Office']['name'] ?></td>
                                <td width = "15%" style = " text-align:center"><?= $empData['Department']['name'] ?></td>
                                <?php
                                foreach ($arrWeeks as $weeks) {
                                    $idx = 0;
                                    $totalHadir = 0;
                                    $totalAbsen = 0;
                                    $totalPermit = [];
                                    foreach ($permitCategories as $un => $permitCategory) {
                                        $totalPermit[$un] = 0;
                                    }
                                    foreach ($weeks as $week) {
                                        if ($defaultResult[$emp_id]['data'][$week]['ispasseddate'] === false) {
                                            
                                        } else if ($defaultResult[$emp_id]['data'][$week]['permit_category'] != false && $defaultResult[$emp_id]['data'][$week]['libur'] == false) {
                                            $totalPermit[$defaultResult[$emp_id]['data'][$week]['permit_category']] ++;
                                        } else if ($defaultResult[$emp_id]['data'][$week]['absen'] == false && $defaultResult[$emp_id]['data'][$week]['libur'] == false) {
                                            $totalHadir++;
                                        } else if ($defaultResult[$emp_id]['data'][$week]['absen'] == true && $defaultResult[$emp_id]['data'][$week]['libur'] == false) {
                                            $totalAbsen++;
                                        }
                                    }
                                    ?>
                                    <td width = "1%" align = "center" valign = "middle" style = " text-align:center"><?= $totalHadir ?></td>
                                    <td width = "1%" align = "center" valign = "middle" style = " text-align:center"><?= $totalAbsen ?></td>
                                    <?php
                                    foreach ($permitCategories as $un => $permitCategory) {
                                        ?>
                                        <td width = "1%" align = "center" valign = "middle" style = " text-align:center"><?= $totalPermit[$un] ?></td>
                                        <?php
                                    }
                                    ?>
                                    <?php
                                }
                                ?>

                                <!--Header Jumlah-->
                                <td width = "1%" align = "center" valign = "middle" style = " text-align:center"><strong><?= $defaultResult[$emp_id]['summary']['jumlah_hadir'] ?></strong></td>
                                <td width = "1%" align = "center" valign = "middle" style = " text-align:center"><strong><?= $defaultResult[$emp_id]['summary']['jumlah_absen'] ?></strong></td>
                                <?php
                                foreach ($permitCategories as $un => $permitCategory) {
                                    ?>
                                    <td width = "1%" align = "center" valign = "middle" style = " text-align:center"><strong><?= $defaultResult[$emp_id]['summary']["permit"]["jumlah_{$un}"] ?></strong></td>
                                    <?php
                                }
                                ?>

                                <!--Header Presentase-->
                                <td width = "1%" align = "center" valign = "middle" class = "text-center"><strong><?= number_format(($defaultResult[$emp_id]['summary']['jumlah_hadir'] / $defaultResult[$emp_id]['summary']['jumlah_kerja']) * 100, 2, ",", ".") ?></strong></td>
                                <td width = "1%" align = "center" valign = "middle" class = "text-center"><strong><?= number_format(($defaultResult[$emp_id]['summary']['jumlah_absen'] / $defaultResult[$emp_id]['summary']['jumlah_kerja']) * 100, 2, ",", ".") ?></strong></td>
                                <?php
                                foreach ($permitCategories as $un => $permitCategory) {
                                    ?>
                                    <td width = "1%" align = "center" valign = "middle" class = "text-center"><strong><?= number_format(($defaultResult[$emp_id]['summary']["permit"]["jumlah_{$un}"] / $defaultResult[$emp_id]['summary']['jumlah_kerja']) * 100, 2, ",", ".") ?></strong></td>
                                    <?php
                                }
                                ?>
<!--                                <td width = "2%" class = "text-center">
                                    <a data-toggle="modal" data-remote="false" role="button" href="<?= Router::url("/admin/popups/content?content=detailkehadiran&employee_id=$emp_id&start=" . $start_date . "&end=" . $end_date) ?>" data-target="#default-modalkehadiran" class="btn btn-default btn-xs btn-icon tip" title="Lihat Data"><i class="icon-file6"></i></a>
                                </td>-->
                            </tr>
                            <?php
                            $total_persentase_kehadiran += $defaultResult[$emp_id]['summary']['jumlah_hadir'] / $defaultResult[$emp_id]['summary']['jumlah_kerja'];
                            $total_persentase_absen += $defaultResult[$emp_id]['summary']['jumlah_absen'] / $defaultResult[$emp_id]['summary']['jumlah_kerja'];
                            foreach ($permitCategories as $un => $permitCategory) {
                                $total_presentase_permit[$un] += $defaultResult[$emp_id]['summary']['permit']["jumlah_{$un}"] / $defaultResult[$emp_id]['summary']['jumlah_kerja'];
                            }
                            $i++;
                            $count_row++;
                            ?>
                            <tr>
                                <?php
                                if (count($arrWeeks) == 5) {
                                    $colspan = 41;
                                } else {
                                    $colspan = 35;
                                }
                                ?>
                                <td colspan = "<?= $colspan ?>" align = "center" valign = "middle" bgcolor = "#FFFFCC" style = " text-align:center"><strong>PERSENTASE HASIL KESELURUHAN</strong></td>
                                <td align = "center" valign = "middle" bgcolor = "#FFFFCC" class = "text-center"><strong><?= number_format($total_persentase_kehadiran * 100 / $count_row, 2, ",", ".") ?></strong></td>
                                <td align = "center" valign = "middle" bgcolor = "#FFFFCC" class = "text-center"><strong><?= number_format($total_persentase_absen * 100 / $count_row, 2, ",", ".") ?></strong></td>
                                <?php
                                foreach ($permitCategories as $un => $permitCategory) {
                                    ?>
                                    <td align = "center" valign = "middle" bgcolor = "#FFFFCC" class = "text-center"><strong><?= number_format($total_presentase_permit[$un] * 100 / $count_row, 2, ",", ".") ?></strong></td>
                                    <?php
                                }
                                ?>
<!--                                <td bgcolor = "#FFFFCC" class = "text-center">&nbsp;
                                </td>-->
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!--/shipping method -->
            </div>
        </div>
        <!--/page content -->
    </div>
    <?php
}
?>
<script>
    $(document).ready(function () {
        $("#default-modalkehadiran").on("show.bs.modal", function (e) {
            var link = $(e.relatedTarget);
            $(this).find(".modal-content").load(link.attr("href"));
        });
    });
</script>