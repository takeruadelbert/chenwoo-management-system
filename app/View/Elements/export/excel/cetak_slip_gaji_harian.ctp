<div>
    <div class = "container-print" style = "position: relative;">
        <div class="input-data">
            <?php
            foreach ($data['rows'] as $item) {
                if (!empty($item)) {
                    $count = 0;
                    foreach ($item['EmployeeSalary'] as $salary) {
                        ?>
                        <div style="page-break-inside: avoid;border-bottom:1px gray solid;padding-bottom: 5px;">
                            <table style="line-height: 15px; font-size: 11px;">
                                <tr>
                                    <td width="250px">Periode</td>
                                    <td>: </td>
                                    <td width="300px"><?php echo $this->Html->cvtTanggal($salary['start_date_period']) . " - " . $this->Html->cvtTanggal($salary['end_date_period']); ?></td>
                                    <td width="250px">Nama</td>
                                    <td>: </td>
                                    <td width="250px" ><?php echo ucwords($salary['Employee']['Account']['Biodata']['full_name']) ?></td>
                                    <td width="250px">NIP</td>
                                    <td>: </td>
                                    <td><?php echo $salary['Employee']['nip'] ?></td>
                                </tr>
                            </table>
                            <table style="line-height: 10px; font-size: 11px;">
                                <tr style="background-color:#ccc;">
                                    <td colspan="2" style="width:50%;" class="center-text"><b>Pendapatan</b></td>
                                    <td colspan="2" style="width:50%;" class="center-text"><b>Potongan</b></td>
                                </tr>
                                <?php
                                $pendapatan = array();
                                $pengeluaran = array();
                                foreach ($salary['ParameterEmployeeSalary'] as $item) {
                                    if ($item['nominal'] == 0) {
                                        ?>                                                                                                                                                  <!--<td colspan="4" class="center-text"><strong>Tidak ada Data</strong></td>-->
                                        <?php
                                    } else {
                                        if ($item["ParameterSalary"]["parameter_salary_type_id"] == 1) {
                                            $pendapatan[] = $item;
                                        } else if ($item["ParameterSalary"]["parameter_salary_type_id"] == 2) {
                                            $pengeluaran[] = $item;
                                        }
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
                                    echo "<tr>";
                                    if (!empty($pendapatan)) {
                                        $dataPendapatan = array_shift($pendapatan);
                                        $jumlahPendapatan += $dataPendapatan['nominal'];
                                        ?>
                                        <td width="300px"><?php echo $dataPendapatan['ParameterSalary']['name'] ?>
                                            <?php
                                            switch ($dataPendapatan["ParameterSalary"]["code"]) {
                                                case "GPK":
                                                    echo "({$salary["EmployeeSalaryInfo"]["hari_kerja"]} Hari Kerja)";
                                                    break;
                                                case "LPH":
                                                    echo "({$salary["EmployeeSalaryInfo"]["lembur_hari"]} Hari Lembur)";
                                                    break;
                                                case "LPJ":
                                                    echo "({$salary["EmployeeSalaryInfo"]["lembur_jam"]})";
                                                    break;
                                            }
                                            ?>
                                        </td>
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
                                    <td class="right-text">Total Pendapatan: </td>
                                    <td>Rp. <span style="float:right"><?php echo number_format($jumlahPendapatan, 0, ',', '.') ?>,-</span></td>
                                    <td class="right-text">Total Potongan: </td>
                                    <td>Rp. <span style="float:right"><?php echo number_format(abs($jumlahPotongan), 0, ',', '.') ?>,-</span></td>
                                </tr>
                                <tr>
                                    <td colspan="4">
                                        <div style="border:1px solid black"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="vertical-align: top">
                                        <?php
                                        $gajiBersih = $jumlahPendapatan + $jumlahPotongan;
                                        ?>
                                        Gaji Bersih** : Rp. <?php echo number_format($gajiBersih, 0, ',', '.') ?>,-
                                    </td>
                                    <td colspan="2">
                                        <div style="border-bottom:1px solid black;float: right;text-align: center;width:200px">
                                            Penerima, <br/><br/>
                                            <span ><?= $salary['Employee']['Account']['Biodata']['full_name'] ?></span>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <?php
                        $count++;
                    }
                }
            }
            ?>
        </div>
    </div>
</div>