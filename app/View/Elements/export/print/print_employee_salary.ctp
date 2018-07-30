<?php
if (!empty($data['rows'])) {
    ?>
    <table style="line-height: 15px;">
        <tr>
            <td>
                Periode : <?php echo $this->Html->cvtTanggal($data['rows']['EmployeeSalary']['start_date_period']) . " - " . $this->Html->cvtTanggal($data['rows']['EmployeeSalary']['end_date_period']); ?>
            </td>
            <td>Tipe Pegawai : <?php echo ucwords($data['rows']['Employee']['EmployeeType']['name']) ?></td>
            <td></td>
        </tr>
        <tr>
            <td>Nama : <?php echo ucwords($data['rows']['Employee']['Account']['Biodata']['full_name']) ?></td>
            <td>NIP : <?php echo $data['rows']['Employee']['nip'] ?></td>
            <td>Jabatan : <?php echo ucwords($data['rows']['Employee']['Department']['name']) ?></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr style="background-color:#ccc;">
            <td colspan="2" style="width:477px;" class="center-text"><strong>Pendapatan</strong></td>
            <td colspan="2" style="width:477px;" class="center-text"><strong>Potongan</strong></td>
        </tr>
        <?php
        $pendapatan = array();
        $pengeluaran = array();
        foreach ($data['rows']['ParameterEmployeeSalary'] as $item) {
            if ($item['nominal'] == 0) {
                
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
            <td class="right-text">Total Pendapatan: </td>
            <td>Rp. <span style="float:right"><?php echo number_format($jumlahPendapatan, 0, ',', '.') ?>,-</span></td>
            <td class="right-text">Total Potongan: </td>
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
    <br/>
    <table class="total">
        <tbody><tr>
                <td colspan="4" class="left-text"><div class="total trapesium">Rp. <?php echo number_format($jumlahPendapatan + $jumlahPotongan, 0, ',', '.') ?></div></td>
            </tr>
        </tbody>
    </table>
    <br/>
    <div>
        * Total dari semua kewajiban angsuran bulan<br>
        ** Gaji bersih diperoleh dari pendapatan dikurangi potongan<br>
    </div>
    <?php
//    $dataCreated = ClassRegistry::init('User')->find('first', array('conditions' => array(
//            'User.username' => $data['rows']['EmployeeSalary']['created_by']
//    )));
//    $dataVerified = ClassRegistry::init('User')->find('first', array('conditions' => array(
//            'User.username' => $data['rows']['EmployeeSalary']['verified_by']
//    )));
//    $dataValidate = ClassRegistry::init('User')->find('first', array('conditions' => array(
//            'User.username' => $data['rows']['EmployeeSalary']['validate_by']
//    )));
    ?>
    <div class="clear"></div>
    <div class="signature-area">
        <div class="signature-block-ttd">
            <div class="signature" style="margin-top: 50px;">
                <div class="signature-name">
                    DIBUAT,
                    <br><br><br>
                    <?= $data['rows']['MadeBy']['Account']['Biodata']['full_name'] ?><br>
                    <?= @$data['rows']['MadeBy']['Office']['name'] ?>
                    <?php // echo $dataCreated['User']['full_name']; ?> <br>
                    <?php // echo $dataCreated['UserGroup']['name'];  ?>
                </div>
            </div>
        </div>

        <div class="signature-block-ttd">
            <div class="signature" style="margin-top: 50px;">
                <div class="signature-name">DIVALIDASI,
                    <br><br><br>
                    <?= $data['rows']['ValidateBy']['Account']['Biodata']['full_name'] ?><br>
                    <?= @$data['rows']['ValidateBy']['Office']['name'] ?>

                    <?php // echo $dataValidate['User']['full_name'];  ?> <br>
                    <?php // echo $dataValidate['UserGroup']['name'];  ?>
                </div>
            </div>
        </div>   
        <div class="signature-block-ttd">
            <div class="signature" style="margin-top: 50px;">
                <div class="signature-name">PENERIMA,
                    <br><br><br>
                    <?= $data['rows']['Employee']['Account']['Biodata']['full_name'] ?><br>
                    <?= @$data['rows']['Employee']['Office']['name'] ?>

                    <?php // echo $dataValidate['User']['full_name'];  ?> <br>
                    <?php // echo $dataValidate['UserGroup']['name'];  ?>
                </div>
            </div>
        </div>   
        <br><br>
    </div>

<?php } ?>