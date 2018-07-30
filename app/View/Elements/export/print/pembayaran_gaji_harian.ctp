<div style="text-align: center">
    <div style="font-size:11px;font-weight: bold; font-family:Tahoma, Geneva, sans-serif;">
        Pembayaran Gaji Harian
    </div>
    <div style="font-size:10px;font-weight: 400; font-style: italic; font-family:Tahoma, Geneva, sans-serif;">Periode Pembayaran: <?= $this->Echo->laporanPeriodeBulan(@$periodeLaporanStartDate, @$periodeLaporanEndDate) ?></div>
</div>
<br>
<table width="100%" class="table-data">
    <thead>
        <tr>
            <th class="text-center" width="1%" bgcolor="#FFFFCC" style="color: #000;">No</th>
            <th class="text-center"  bgcolor="#FFFFCC" style="color: #000;"><?= __("Nama") ?></th>
            <th class="text-center"  bgcolor="#FFFFCC" style="color: #000;"><?= __("Tipe Gaji") ?></th>
            <th class="text-center"  bgcolor="#FFFFCC" style="color: #000;"><?= __("Periode Penggajian") ?></th>
            <th class="text-center"  bgcolor="#FFFFCC" style="color: #000;" colspan = "2"><?= __("Jumlah Pendapatan") ?></th>
            <th class="text-center"  bgcolor="#FFFFCC" style="color: #000;" colspan = "2"><?= __("Jumlah Potongan") ?></th>
            <th class="text-center"  bgcolor="#FFFFCC" style="color: #000;" colspan = "2"><?= __("Total") ?></th>
            <th class="text-center" bgcolor="#FFFFCC" style="color: #000;"><?= __("Tanggal Bayar") ?></th>
            <th class="text-center"  bgcolor="#FFFFCC" style="color: #000;"><?= __("Dibayar Oleh") ?></th>
            <th class="text-center"  bgcolor="#FFFFCC" style="color: #000;"><?= __("Status Pembayaran") ?></th>
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
                <td class = "text-center" colspan = "13">Tidak Ada Data</td>
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
                    <td class="text-right" style = "border-left-style:none !important" ><?= ic_rupiah($totalIncome); ?></td>
                    <td class="text-center" style = "border-right-style:none !important" width = "50">Rp. </td>
                    <td class="text-right" style = "border-left-style:none !important" ><?= ic_rupiah(abs($totalDebt)); ?></td>
                    <td class="text-center" style = "border-right-style:none !important" width = "50">Rp. </td>
                    <td class="text-right" style = "border-left-style:none !important" ><?= ic_rupiah($totalIncome + $totalDebt); ?></td>
                    <td class="text-center valid-date">
                        <?php
                        if ($item['EmployeeSalary']['confirmed_date_by_cashier_operator'] === null) {
                            echo "-";
                        } else {
                            echo $this->Html->cvtTanggalWaktu($item['EmployeeSalary']['confirmed_date_by_cashier_operator']);
                        }
                        ?>
                    </td>
                    <td class="text-center valid-by">
                        <?php
                        if ($item['CashierOperator']['id'] === null) {
                            echo "-";
                        } else {
                            echo $item['CashierOperator']['Account']['Biodata']['full_name'];
                        }
                        ?>
                    </td>
                    <td class="text-center"><?= $item['EmployeeSalaryCashierStatus']['name'] ?></td>
                </tr>
                <?php
                $i++;
            }
        }
        ?>
    </tbody>
</table>