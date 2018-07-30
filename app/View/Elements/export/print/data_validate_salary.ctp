<div style="text-align: center">
    <div style="font-size:11px;font-weight: bold; font-family:Tahoma, Geneva, sans-serif;">
        Data Gaji Pegawai Bulanan
    </div>
    <div style="font-size:11px;font-style: italic; font-family:Tahoma, Geneva, sans-serif;">Periode : <?= $this->Echo->laporanPeriodeBulan(@$periodeLaporanStartDate, @$periodeLaporanEndDate) ?></div>
</div>
<br>
<table width="100%" class="table-data">
    <thead>
        <tr>
            <th class="text-center" width="1%" >No</th>
            <th class="text-center" width="8%" ><?= __("Nama") ?></th>
            <th class="text-center" width="10%" ><?= __("Tipe Gaji") ?></th>
            <th class="text-center" width="10%" ><?= __("Periode Penggajian") ?></th>
            <th class="text-center" width="8%"  colspan = "2"><?= __("Jumlah Pendapatan") ?></th>
            <th class="text-center" width="8%"  colspan = "2"><?= __("Jumlah Potongan") ?></th>
            <th class="text-center" width="8%" colspan="2"><?= __("Total") ?></th>
            <th class="text-center" width="8%" ><?= __("Tanggal Validasi") ?></th>
            <th class="text-center" width="8%" ><?= __("Divalidasi Oleh") ?></th>
            <th class="text-center" width="8%" ><?= __("Status Validasi") ?></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $limit = intval(isset($this->params['named']['limit']) ? $this->params['named']['limit'] : 10);
        $page = intval(isset($this->params['named']['page']) ? $this->params['named']['page'] : 1);
        $i = ($limit * $page) - ($limit - 1);
        if (empty($data['rows'])) {
            ?>
            <tr>
                <td class = "text-center" colspan = 12>Tidak Ada Data</td>
            </tr>
            <?php
        } else {
            foreach ($data['rows'] as $item) {
                ?>
                <tr>
                    <td class="text-center"><?= $i ?></td>
                    <td class="text-left"><?= $item['Employee']['Account']['Biodata']['full_name'] ?></td>
                    <td class="text-center"><?= $item['Employee']['EmployeeType']['name'] ?></td>
                    <td class="text-center"><?= $this->Html->cvtTanggal($item['EmployeeSalary']['start_date_period'], false) ?> - <?= $this->Html->cvtTanggal($item['EmployeeSalary']['end_date_period'], false) ?></td>
                    <?php
                    $totalIncome = 0;
                    $totalDebt = 0;
                    if (!empty($item['ParameterEmployeeSalary'])) {
                        foreach ($item['ParameterEmployeeSalary'] as $value) {
                            if ($value['ParameterSalary']['parameter_salary_type_id'] === '1') {
                                $totalIncome += $value['nominal'];
                            }
                            if ($value['ParameterSalary']['parameter_salary_type_id'] === '2') {
                                $totalDebt += $value['nominal'];
                            }
                        }
                    }
                    ?>
                    <td class="text-center" style = "border-right-style:none !important" width = "50">Rp. </td>
                    <td class="text-right" style = "border-left-style:none !important" width = "150"><?= ic_rupiah($totalIncome); ?></td>
                    <td class="text-center" style = "border-right-style:none !important" width = "50">Rp. </td>
                    <td class="text-right" style = "border-left-style:none !important" width = "150"><?= ic_rupiah(abs($totalDebt)); ?></td>
                    <td class="text-center" style = "border-right-style:none !important" width = "50">Rp. </td>
                    <td class="text-right" style = "border-left-style:none !important" ><?= ic_rupiah($totalIncome + $totalDebt); ?></td>
                    <td class="text-center valid-date">
                        <?php
                        if ($item['EmployeeSalary']['validate_datetime'] === null) {
                            echo "-";
                        } else {
                            echo $this->Html->cvtTanggalWaktu($item['EmployeeSalary']['validate_datetime']);
                        }
                        ?>
                    </td>
                    <td class="text-center valid-by">
                        <?php
                        if ($item['ValidateBy']['id'] === null) {
                            echo "-";
                        } else {
                            echo $item['ValidateBy']['Account']['Biodata']['full_name'];
                        }
                        ?>
                    </td>
                    <td class="text-center" id = "target-change-status<?= $i ?>">
                        <?php
                        if ($item['EmployeeSalary']['validate_status_id'] == 2) {
                            echo "Valid";
                        } else if ($item['EmployeeSalary']['validate_status_id'] == 3) {
                            echo "Tidak Valid";
                        } else {
                            echo "Menunggu Persetujuan";
                        }
                        ?>
                    </td>
                </tr>
                <?php
                $i++;
            }
        }
        ?>
    </tbody>
</table>
