<div style="text-align: center">
    <div style="font-size:11px;font-weight: bold; font-family:Tahoma, Geneva, sans-serif;">
        Data Transaksi Simpanan Pegawai
        <?= isset($employee) ? $employee["Account"]["Biodata"]["full_name"] : "" ?>
    </div>
    <div style="font-size:10px;font-style: italic; font-family:Tahoma, Geneva, sans-serif;">Periode : <?= $this->Echo->laporanPeriodeBulan(@$periodeLaporanStartDate, @$periodeLaporanEndDate) ?></div>
</div>
<br/>
<table width="100%" class="table-data">
    <thead>
        <tr>
            <th width="50">No</th>
            <th><?= __("Referensi") ?></th>
            <th><?= __("Uraian") ?></th>
            <th><?= __("Tgl Transaksi") ?></th>
            <th colspan = "2"><?= __("Debit") ?></th>
            <th colspan = "2"><?= __("Credit") ?></th>
            <th colspan = "2"><?= __("Balance") ?></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 1;
        if (!isset($employeeDataDeposits) && empty($employeeDataDeposits)) {
            ?>
            <tr>
                <td class = "text-center" colspan ="8">Tidak Ada Data</td>
            </tr>
            <?php
        } else {
            $initialBalance = array_slice($employeeDataDeposits, 0)[0]["EmployeeDataDeposit"]["deposit_previous_balance"];
            ?>
            <tr>
                <td class="text-center"><?= $i++ ?></td>
                <td class="text-right" colspan="7"><?= __("Saldo Awal") ?></td>
                <td class="text-center" style = "border-right-style:none !important" width = "25">Rp. </td>
                <td class="text-right" style = "border-left-style:none !important" width = "150"><?= $initialBalance ?></td>
            </tr>
            <?php
            foreach ($employeeDataDeposits as $employeeDataDeposit) {
                $debit = 0;
                $credit = 0;
                $balance = $employeeDataDeposit["EmployeeDataDeposit"]["deposit_previous_balance"];
                if ($employeeDataDeposit["EmployeeDataDeposit"]["deposit_io_type_id"] == 2) {
                    $debit = $employeeDataDeposit["EmployeeDataDeposit"]["amount"];
                    $balance-=$debit;
                } else {
                    $credit = $employeeDataDeposit["EmployeeDataDeposit"]["amount"];
                    $balance+=$credit;
                }
                $endingBalance = $balance;
                ?>
                <tr>
                    <td class="text-center"><?= $i ?></td>
                    <td class="text-center"><?= $employeeDataDeposit['EmployeeDataDeposit']['id_number'] ?></td>
                    <td class="text-left"><?= $employeeDataDeposit['DepositIoType']['name'] ?></td>
                    <td class="text-center"><?= $employeeDataDeposit['EmployeeDataDeposit']['verified_datetime__ic'] ?></td>
                    <td class="text-center" style = "border-right-style:none !important" width = "25">Rp. </td>
                    <td class="text-right" style = "border-left-style:none !important" width = "150"><?= $debit ?></td>
                    <td class="text-center" style = "border-right-style:none !important" width = "25">Rp. </td>
                    <td class="text-right" style = "border-left-style:none !important" width = "150"><?= $credit ?></td>
                    <td class="text-center" style = "border-right-style:none !important" width = "25">Rp. </td>
                    <td class="text-right" style = "border-left-style:none !important" width = "150"><?= $balance ?></td>
                </tr>
                <?php
                $i++;
            }
            ?>
            <tr>
                <td class="text-center"><?= $i++ ?></td>
                <td class="text-right" colspan="7"><?= __("Saldo Akhir") ?></td>
                <td class="text-center" style = "border-right-style:none !important" width = "25">Rp. </td>
                <td class="text-right" style = "border-left-style:none !important" width = "150"><?= $endingBalance ?></td>
            </tr>
            <?php
        }
        ?>
    </tbody>
</table>