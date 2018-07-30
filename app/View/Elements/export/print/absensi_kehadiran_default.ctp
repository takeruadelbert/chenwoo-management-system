<div class = "panel panel-default">
    <div class = "panel-body">
        <table width = "100%" border = "0" align = "center" class = "table-data">
            <tbody>
                <tr>
                    <td align = "center"><strong>REKAP ABSENSI PEGAWAI</strong></td>
                </tr>
                <tr>
                    <td align = "center">Periode Bulan : <?= $this->Html->getBulan($start_date) . " " . $this->Html->getTahun($start_date) ?></td>
                </tr>
            </tbody></table>
        <br>
        <table class="table-data">
            <thead>
                <tr>
                    <th width = "1%" rowspan = "3" align = "center" valign = "middle" bgcolor = "#FFFFCC" style = " text-align:center">No</th>
                    <th width = "20%" rowspan = "3" bgcolor = "#FFFFCC" style = " text-align:center">Nama / NIP Pegawai</th>
                    <th width = "15%" rowspan = "3" bgcolor = "#FFFFCC" style = " text-align:center">JABATAN</th>
                    <th width = "15%" rowspan = "3" bgcolor = "#FFFFCC" style = " text-align:center"><?= __("locale0002") ?></th>
                    <?php
                    $total_persentase_kehadiran = 0;
                    $total_persentase_absen = 0;
                    foreach ($permitCategories as $un => $permitCategory) {
                        $total_presentase_permit[$un] = 0;
                    }
                    $count_row = 0;
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
                foreach ($empData as $empId => $item) {
                    ?>
                    <tr>
                        <td width = "1%" align = "center" valign = "middle" style = " text-align:center"><?= $i ?></td>
                        <td width = "20%" style = " text-align:left"><?= $item['Account']['Biodata']['full_name'] ?><br><?= $item['Employee']['nip'] ?></td>
                        <td width = "15%" style = " text-align:center"><?= $item['Office']['name'] ?></td>
                        <td width = "15%" style = " text-align:center"><?= $item['Department']['name'] ?></td>
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
                                if ($defaultResult[$empId]['data'][$week]['ispasseddate'] === false) {
                                    
                                } else if ($defaultResult[$empId]['data'][$week]['permit_category'] != false && $defaultResult[$empId]['data'][$week]['libur'] == false) {
                                    $totalPermit[$defaultResult[$empId]['data'][$week]['permit_category']] ++;
                                } else if ($defaultResult[$empId]['data'][$week]['absen'] == false && $defaultResult[$empId]['data'][$week]['libur'] == false) {
                                    $totalHadir++;
                                } else if ($defaultResult[$empId]['data'][$week]['absen'] == true && $defaultResult[$empId]['data'][$week]['libur'] == false) {
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
                        <td width = "1%" align = "center" valign = "middle" style = " text-align:center"><strong><?= $defaultResult[$empId]['summary']['jumlah_hadir'] ?></strong></td>
                        <td width = "1%" align = "center" valign = "middle" style = " text-align:center"><strong><?= $defaultResult[$empId]['summary']['jumlah_absen'] ?></strong></td>
                        <?php
                        foreach ($permitCategories as $un => $permitCategory) {
                            ?>
                            <td width = "1%" align = "center" valign = "middle" style = " text-align:center"><strong><?= $defaultResult[$empId]['summary']["permit"]["jumlah_{$un}"] ?></strong></td>
                            <?php
                        }
                        ?>

                        <!--Header Presentase-->
                        <td width = "1%" align = "center" valign = "middle" class = "text-center"><strong><?= number_format(($defaultResult[$empId]['summary']['jumlah_hadir'] / $defaultResult[$empId]['summary']['jumlah_kerja']) * 100, 2, ",", ".") ?></strong></td>
                        <td width = "1%" align = "center" valign = "middle" class = "text-center"><strong><?= number_format(($defaultResult[$empId]['summary']['jumlah_absen'] / $defaultResult[$empId]['summary']['jumlah_kerja']) * 100, 2, ",", ".") ?></strong></td>
                        <?php
                        foreach ($permitCategories as $un => $permitCategory) {
                            ?>
                            <td width = "1%" align = "center" valign = "middle" class = "text-center"><strong><?= number_format(($defaultResult[$empId]['summary']["permit"]["jumlah_{$un}"] / $defaultResult[$empId]['summary']['jumlah_kerja']) * 100, 2, ",", ".") ?></strong></td>
                            <?php
                        }
                        ?>
                    </tr>
                    <?php
                    $total_persentase_kehadiran += $defaultResult[$empId]['summary']['jumlah_hadir'] / $defaultResult[$empId]['summary']['jumlah_kerja'];
                    $total_persentase_absen += $defaultResult[$empId]['summary']['jumlah_absen'] / $defaultResult[$empId]['summary']['jumlah_kerja'];
                    foreach ($permitCategories as $un => $permitCategory) {
                        $total_presentase_permit[$un] += $defaultResult[$empId]['summary']['permit']["jumlah_{$un}"] / $defaultResult[$empId]['summary']['jumlah_kerja'];
                    }
                    $i++;
                    $count_row++;
                }
                ?>
                <tr>
                    <?php
                    if (count($arrWeeks) == 5) {
                        $colspan = 40;
                    } else {
                        $colspan = 34;
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
                </tr>
            </tbody>
        </table>
        <!--/shipping method -->
    </div>
    <!--/page content -->
</div>