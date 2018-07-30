<div style="text-align: center">
    <div style="font-size:11px;font-weight: bold; font-family:Tahoma, Geneva, sans-serif;">
        Data Potongan Gaji Kasbon
    </div>
    <div style="font-size:11px;font-style: italic; font-family:Tahoma, Geneva, sans-serif;">Periode : <?= $this->Echo->laporanPeriodeBulan(@$periodeLaporanStartDate, @$periodeLaporanEndDate) ?></div>
</div>
<br/>
<table width="100%" class="table-data">
    <thead>
        <tr>
            <th width="10">No</th>
            <th width="300"><?= __("Nama Pegawai") ?></th>
            <th width="200"><?= __("Nik Pegawai") ?></th>
            <th><?= __("Nomor Pinjaman") ?></th>
            <th width="200"><?= __("Jumlah Potongan (Rp)") ?></th>
            <th width="200"><?= __("Periode") ?></th>
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
                <td class = "text-center" colspan ="6">Tidak Ada Data</td>
            </tr>
            <?php
        } else {
            foreach ($data['rows'] as $item) {
                ?>
                <tr>
                    <td class="text-center"><?= $i ?></td>
                    <td class="text-left"><?= $item['EmployeeSalary']['Employee']["Account"]["Biodata"]["full_name"] ?></td>
                    <td class="text-left"><?= $item['EmployeeSalary']['Employee']["nip"] ?></td>
                    <td class="text-left"><?= $item['EmployeeDataLoan']['receipt_loan_number'] ?></td>
                    <td class="text-right"><?= ic_rupiah($item['EmployeeSalaryLoan']['amount']) ?></td>
                    <td class="text-left"><?= $this->Echo->laporanPeriodeBulan($item['EmployeeSalary']["EmployeeSalaryPeriod"]['start_dt'], $item['EmployeeSalary']["EmployeeSalaryPeriod"]['end_dt']) ?></td>
                </tr>
                <?php
                $i++;
            }
        }
        ?>
    </tbody>
</table>