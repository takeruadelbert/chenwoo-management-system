<?php
foreach ($data['rows'] as $item) {
    ?>
    <div onload = "window.print()">
        <div class = "container-print" style = "width:955px; margin:10px auto">
            <div id = "identity">
                <div class = "no-margin no-padding text-center" style = "width:100%">
                    <?php
                    $entity = ClassRegistry::init("EntityConfiguration")->find("first");
                    ?>
                    <div style="display:inline-block; margin-right: 15px;">
                        <img src="<?php echo Router::url($entity['EntityConfiguration']['logo1'], true) ?>" height="100px"/>
                    </div>
                    <div style="display:inline-block">
                        <?php
                        echo $entity['EntityConfiguration']['header'];
                        ?>
                    </div>
                </div>
                <hr/>
            </div>
            <div style="clear:both"></div>
            <div class="input-data">

                <table class="title">
                    <thead>
                        <tr>
                            <th class="center-text">
                    <div class="report-title"><?php echo $data['title'] ?></div>
                    </th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                <div class="clear"></div>
                <?php
                if (!empty($item)) {
                    $pendapatan = array();
                    $pengeluaran = array();
                    foreach ($item['ParameterEmployeeSalary'] as $value) {
                        if ($value['nominal'] > 0) {
                            $pendapatan[] = $value;
                        } else {
                            $pengeluaran[] = $value;
                        }
                    }

                    $max = null;
                    if (!empty(count($pendapatan) > count($pengeluaran))) {
                        $max = count($pendapatan);
                    } else {
                        $max = count($pengeluaran);
                    }
                    $jumlahPendapatan = 0;
                    $jumlahPotongan = 0;
                    for ($i = 0; $i < $max; $i++) {
                        if (!empty($pendapatan)) {
                            $jumlahPendapatan += $dataPendapatan['nominal'];
                        }
                        if ($pengeluaran) {
                            $jumlahPotongan += $dataPotongan['nominal'];
                        }
                    }
                    $gajiBersih = $jumlahPendapatan + $jumlahPotongan;
                    if ($gajiBersih > _AVERAGE_SALARY) {
                        ?>
                        <table>
                            <tr>
                                <td colspan="2">
                                    <table>
                                        <?php
                                        if ($item['Employee']['employee_type_id'] == 1) {
                                            ?>
                                            <tr><td>Periode</td><td>: <?php echo $this->Html->cvtTanggal($item['EmployeeSalary']['start_date_period']) . " - " . $this->Html->cvtTanggal($item['EmployeeSalary']['end_date_period']); ?></td></tr>
                                            <?php
                                        } else if ($item['Employee']['employee_type_id'] == 2) {
                                            ?>
                                            <tr><td>Periode</td><td>: <?php echo $this->Html->getNamaBulan($item['EmployeeSalary']['month_period']) . "  " . $item['EmployeeSalary']['year_period']; ?></td></tr>
                                            <?php
                                        }
                                        ?>
                                        <tr><td>Nama</td><td>: <?php echo ucwords($item['Employee']['Account']['Biodata']['full_name']) ?></td></tr>
                                        <tr><td>NIP</td><td>: <?php echo $item['Employee']['nip'] ?></td></tr>
                                        <tr><td>Jabatan</td><td>: <?php echo ucwords($item['Employee']['Office']['name']) ?></td></tr>
                                        <tr><td>Department</td><td>: <?php echo ucwords($item['Employee']['Department']['name']) ?></td></tr>
                                    </table>
                                </td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr style="background-color:#ccc;">
                                <td colspan="2" style="width:477px;" class="center-text"><strong>Pendapatan</strong></td>
                                <td colspan="2" style="width:477px;" class="center-text"><strong>Potongan</strong></td>
                            </tr>
                            <?php
                            for ($i = 0; $i < $max; $i++) {
                                echo "<tr>";
                                if (!empty($pendapatan)) {
                                    $dataPendapatan = array_shift($pendapatan);
                                    $jumlahPendapatan += $dataPendapatan['nominal'];
                                    ?>
                                    <td><?php echo $dataPendapatan['ParameterSalary']['name'] ?></td>
                                    <td><span>Rp.</span> <span style="float:right"><?php echo number_format(abs($dataPendapatan['nominal']), 0, ',', '.') ?>,-</span></td>
                                    <?php
                                } else {
                                    echo "<td></td><td></td>";
                                }
                                if (!empty($pengeluaran)) {
                                    $dataPotongan = array_shift($pengeluaran);
                                    $jumlahPotongan += $dataPotongan['nominal'];
                                    ?>
                                    <td><?php echo $dataPotongan['ParameterSalary']['name'] ?></td>
                                    <td><span>Rp.</span> <span style="float:right"><?php echo number_format(abs($dataPotongan['nominal']), 0, ',', '.') ?>,-</span></td>
                                    <?php
                                } else {
                                    echo "<td></td><td></td>";
                                }
                                echo "</tr>";
                            }
                            ?>
                            <tr>
                                <td colspan="4">
                                    <div style="border:1px solid black"></div>
                                </td>
                            </tr>
                            <tr>
                                <td class="right-text">Total : </td>
                                <td>Rp. <span style="float:right"><?php echo number_format($jumlahPendapatan, 0, ',', '.') ?>,-</span></td>
                                <td class="right-text">Total : </td>
                                <td>Rp. <span style="float:right"><?php echo number_format(abs($jumlahPotongan), 0, ',', '.') ?>,-</span></td>
                            </tr>
                            <tr>
                                <td>
                                    <?php
                                    $gajiBersih = $jumlahPendapatan + $jumlahPotongan;
                                    ?>
                                    Gaji Bersih** : Rp. <?php echo number_format($gajiBersih, 0, ',', '.') ?>,-
                                </td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </table>

                        <div class="clear"></div>
                        <br />
                        <table class="total">
                            <tbody><tr>
                                    <td colspan="4" class="left-text">Rp. <div class="total trapesium"><?php echo number_format($jumlahPendapatan + $jumlahPotongan, 0, ',', '.') ?></div></td>
                                </tr>
                            </tbody>
                        </table>

                        <div>
                            * Total dari semua kewajiban angsuran bulan<br>
                            ** Gaji bersih diperoleh dari pendapatan dikurangi potongan<br>
                        </div>
                        <div class="clear"></div>
                        <div class="signature-area">
                            <div class="signature-block-ttd">
                                <div class="signature" style="margin-top: 50px;">
                                    <div class="signature-name">
                                        DIBUAT,
                                        <br><br><br>
                                        <?= $item['MadeBy']['Account']['Biodata']['full_name'] ?> <br>
                                        <?= $item['MadeBy']['Office']['name'] ?>
                                    </div>
                                </div>
                            </div>

                            <div class="signature-block-ttd">
                                <div class="signature" style="margin-top: 50px;">
                                    <div class="signature-name">DIVALIDASI,
                                        <br><br><br>
                                        <?= $item['ValidateBy']['Account']['Biodata']['full_name'] ?> <br>
                                        <?= $item['ValidateBy']['Office']['name'] ?>
                                    </div>
                                </div>
                            </div>   
                            <br><br>
                        </div>

                        <?php
                    }
                }
            }
            ?>

        </div>
    </div>
</div>