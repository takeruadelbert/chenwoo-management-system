<?php
echo $this->element(_TEMPLATE_DIR . "/{$template}/filter/laporan-daftar-hadir");

$total_persentase_kehadiran = 0;
$total_persentase_absen = 0;
$total_persentase_izin = 0;
$total_persentase_cuti = 0;
$count_row = 0;
?>
<div class = "panel panel-default">
    <div class = "panel-body">
        <div class = "block-inner text-danger">
            <h6 class = "heading-hr">DAFTAR HADIR PEGAWAI <div class = "pull-right">
                    <button class = "btn btn-xs btn-default" type = "button" onclick="exp('print', '<?php echo Router::url("laporan_daftar_hadir/print?" . $_SERVER['QUERY_STRING'], true) ?>')"><i class = "icon-print2"></i> Cetak</button>&nbsp;
                    <button class = "btn btn-xs btn-default" type = "button" onclick="exp('excel', '<?php echo Router::url("laporan_daftar_hadir/excel?" . $_SERVER['QUERY_STRING'], true) ?>')"><i class = "icon-file-excel"></i> Excel</button>&nbsp;
                </div>
                <small class = "display-block"><?= _APP_CORPORATE_FULL ?>t</small>
            </h6>
        </div>
        <div class = "table-responsive">
            <table width = "100%" border = "0" align = "center" class = "table table-bordered">
                <tbody>
                    <tr>
                        <td align = "center"><strong>DAFTAR HADIR PEGAWAI <br><?= _APP_CORPORATE_FULL ?></strong></td>
                    </tr>
                    <tr>
                        <td align = "center">Periode : <?= $this->Echo->laporanPeriodeBulan($start_date, $end_date) ?></td>
                    </tr>
                </tbody></table>
            <br>
            <div class = "table-responsive pre-scrollable">
                <table width = "100%" class = "table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th width = "1%" rowspan = "2" align = "center" valign = "middle" bgcolor = "#FFFFCC" style = " text-align:center">#</th>
                            <th width = "1%" rowspan = "2" align = "center" valign = "middle" bgcolor = "#FFFFCC" style = " text-align:center">No</th>
                            <th width = "3%" rowspan = "2" align = "center" valign = "middle" bgcolor = "#FFFFCC">Nama</th>
                            <th width = "12%" rowspan = "2" bgcolor = "#FFFFCC" style = " text-align:center">NIP</th>
                            <th width = "10%" rowspan = "2" bgcolor = "#FFFFCC" style = " text-align:center">Jabatan</th>
                            <th width = "2%" rowspan = "2" bgcolor = "#FFFFCC" style = " text-align:center">Hari Kerja</th>
                            <th width = "2%" rowspan = "2" bgcolor = "#FFFFCC" style = " text-align:center">Hadir</th>
                            <th width = "2%" rowspan = "2" bgcolor = "#FFFFCC" style = " text-align:center">Tidak Hadir</th>
                            <th width = "2%" rowspan = "2" bgcolor = "#FFFFCC" style = " text-align:center">DL</th>
                            <th width = "2%" colspan="7" bgcolor = "#FFFFCC" style = " text-align:center">Keterangan Tidak Hadir</th>
                            <th width = "2%" rowspan = "2" bgcolor = "#FFFFCC" style = " text-align:center">SAKIT<=2 HR</th>
                            <th width = "2%" rowspan = "2" bgcolor = "#FFFFCC" style = " text-align:center">SAKIT SKD</th>
                            <th width = "2%" rowspan = "2" bgcolor = "#FFFFCC" style = " text-align:center">CUTI SAKIT</th>
                            <th width = "2%" rowspan = "2" bgcolor = "#FFFFCC" style = " text-align:center">CUTI</th>
                            <th width = "2%" rowspan = "2" bgcolor = "#FFFFCC" style = " text-align:center">TUBEL</th>
                            <th width = "2%" rowspan = "2" bgcolor = "#FFFFCC" style = " text-align:center">KET</th>
                        </tr>
                        <tr>
                            <th bgcolor = "#FFFFCC" style = " text-align:center">TK</th>
                            <th bgcolor = "#FFFFCC" style = " text-align:center">TD</th>
                            <th bgcolor = "#FFFFCC" style = " text-align:center">IZIN TD</th>
                            <th bgcolor = "#FFFFCC" style = " text-align:center">CP</th>
                            <th bgcolor = "#FFFFCC" style = " text-align:center">IZIN CP</th>
                            <th bgcolor = "#FFFFCC" style = " text-align:center">IZIN TMK</th>
                            <th bgcolor = "#FFFFCC" style = " text-align:center">IZIN RESMI</th>
                        </tr>
                        <tr>
                            <td></td>
                            <?php
                            for ($i = 1; $i <= 21; $i++) {
                                ?>
                                <td style = " text-align:center;height:20px;font-size:9px"><?= $i ?></td>
                                <?php
                            }
                            ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($empData as $empId => $item) {
                            ?>
                            <tr>
                                <td width = "1%" align = "center" valign = "middle" style = " text-align:center"><div class = "checker"><span><input type = "checkbox" name = "checkRow" class = "styled"></span></div></td>
                                <td width = "1%" align = "center" valign = "middle" style = " text-align:center"><?= $i ?></td>
                                <td width = "12%" style = " text-align:left">
                                    <?= $item['Account']['Biodata']['full_name'] ?><br/>
                                    <?= $item['EmployeeClass']['info'] ?><br/>
                                    <?= $item['EmployeeClass']['name'] ?>
                                </td>
                                <td width = "12%" style = " text-align:left"><?= $item['Employee']['nip_baru'] ?></td>
                                <td width = "10%" style = " text-align:left"><?= $item['Office']['name'] ?></td>

                                <td width = "1%" align = "center" valign = "middle" style = " text-align:center"><strong><?= $defaultResult[$empId]['summary']['jumlah_kerja'] ?></strong></td>
                                <td width = "1%" align = "center" valign = "middle" style = " text-align:center"><strong><?= $defaultResult[$empId]['summary']['jumlah_hadir'] ?></strong></td>
                                <td width = "1%" align = "center" valign = "middle" style = " text-align:center"><strong><?= $defaultResult[$empId]['summary']['jumlah_tidak_hadir'] ?></strong></td>
                                <td width = "1%" align = "center" valign = "middle" style = " text-align:center"><strong><?= $defaultResult[$empId]['summary']['detail_ijin']['dl'] ?></strong></td>
                                <td width = "1%" align = "center" valign = "middle" style = " text-align:center"><strong><?= $defaultResult[$empId]['summary']['jumlah_absen'] ?></strong></td>
                                <td width = "1%" align = "center" valign = "middle" style = " text-align:center"><strong><?= $defaultResult[$empId]['summary']['jumlah_telat'] ?></strong></td>
                                <td width = "1%" align = "center" valign = "middle" style = " text-align:center"><strong><?= $defaultResult[$empId]['summary']['detail_ijin']['izin_td'] ?></strong></td>
                                <td width = "1%" align = "center" valign = "middle" style = " text-align:center"><strong><?= $defaultResult[$empId]['summary']['jumlah_cepat_pulang'] ?></strong></td>
                                <td width = "1%" align = "center" valign = "middle" style = " text-align:center"><strong><?= $defaultResult[$empId]['summary']['detail_ijin']['izin_cp'] ?></strong></td>
                                <td width = "1%" align = "center" valign = "middle" style = " text-align:center"><strong><?= $defaultResult[$empId]['summary']['detail_ijin']['izin_tmk'] ?></strong></td>
                                <td width = "1%" align = "center" valign = "middle" style = " text-align:center"><strong><?= $defaultResult[$empId]['summary']['detail_ijin']['izin_resmi'] ?></strong></td>
                                <td width = "1%" align = "center" valign = "middle" style = " text-align:center"><strong><?= $defaultResult[$empId]['summary']['detail_ijin']["izin_sakit_l2hari"] ?></strong></td>
                                <td width = "1%" align = "center" valign = "middle" style = " text-align:center"><strong><?= $defaultResult[$empId]['summary']['detail_ijin']["izin_skd"] ?></strong></td>
                                <td width = "1%" align = "center" valign = "middle" style = " text-align:center"><strong><?= $defaultResult[$empId]['summary']['detail_cuti']["cuti_sakit"] ?></strong></td>
                                <td width = "1%" align = "center" valign = "middle" style = " text-align:center"><strong><?= $defaultResult[$empId]['summary']['detail_cuti']["cuti_umum"] ?></strong></td>
                                <td width = "1%" align = "center" valign = "middle" style = " text-align:center"><strong><?= $defaultResult[$empId]['summary']['detail_ijin']["tubel"] ?></strong></td>
                                <td width = "1%" align = "center" valign = "middle" style = " text-align:center"><strong></strong></td>
                             </tr>
                            <?php
                            $i++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <!--/shipping method -->
        </div>
    </div>
    <!--/page content -->
</div>