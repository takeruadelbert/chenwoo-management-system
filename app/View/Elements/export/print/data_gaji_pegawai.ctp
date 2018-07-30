<div style="text-align: center">
    <div style="font-size:11px;font-weight: bold; font-family:Tahoma, Geneva, sans-serif;">
        Data Gaji Pegawai Harian
    </div>
</div>
<br>
<table width="100%" class="table-data">
    <thead>
        <tr>
            <th class="text-center" width="1%" >No</th>
            <th class="text-center" width="8%" ><?= __("Nama") ?></th>
            <th class="text-center" width="8%" ><?= __("Keterangan") ?></th>
            <th class="text-center" width="8%" ><?= __("Tipe Pegawai") ?></th>
            <th class="text-center" width="8%"  colspan = "2"><?= __("Jumlah Pendapatan") ?></th>
            <th class="text-center" width="8%"  colspan = "2"><?= __("Jumlah Potongan") ?></th>
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
                <td class = "text-center" colspan = 11>Tidak Ada Data</td>
            </tr>
            <?php
        } else {
            foreach ($data['rows'] as $item) {
                ?>
                <tr>
                    <td class="text-center"><?= $i ?></td>
                    <td class="text-left"><?= $item['Employee']['Account']['Biodata']['full_name'] ?></td>
                    <td class="text-center"><?= $item['EmployeeSalary']['note'] ?></td>
                    <td class="text-center"><?= $item['Employee']['EmployeeType']['name'] ?></td>
                    <?php
                    $totalIncome = 0;
                    $totalDebt = 0;
                    foreach ($item['ParameterEmployeeSalary'] as $value) {
                        if ($value['ParameterSalary']['parameter_salary_type_id'] === '1') {
                            $totalIncome += $value['nominal'];
                        }
                        if ($value['ParameterSalary']['parameter_salary_type_id'] === '2') {
                            $totalDebt += $value['nominal'];
                        }
                    }
                    ?>
                    <td class="text-center" style = "border-right-style:none !important" width = "50">Rp. </td>
                    <td class="text-right" style = "border-left-style:none !important" width = "150"><?= ic_rupiah($totalIncome); ?></td>
                    <td class="text-center" style = "border-right-style:none !important" width = "50">Rp. </td>
                    <td class="text-right" style = "border-left-style:none !important" width = "150"><?= ic_rupiah(abs($totalDebt)); ?></td>
                    <td class="text-center">
                        <?php
                        if ($item['EmployeeSalary']['validate_datetime'] === null) {
                            echo "-";
                        } else {
                            echo $this->Html->cvtTanggalWaktu($item['EmployeeSalary']['validate_datetime']);
                        }
                        ?>
                    </td>
                    <td class="text-center">
                        <?php
                        if ($item['ValidateBy']['id'] === null) {
                            echo "-";
                        } else {
                            echo $item['ValidateBy']['Account']['Biodata']['full_name'];
                        }
                        ?>
                    </td>
                    <td class="text-center"><?= $item['ValidateStatus']['name'] ?></td>
                </tr>
                <?php
                $i++;
            }
        }
        ?>
    </tbody>
</table>