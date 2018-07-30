<?php
echo $this->element(_TEMPLATE_DIR . "/{$template}/filter/employee-data-deposit-transaction");
?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("TRANSAKSI SIMPANAN PEGAWAI") ?><?= isset($employee)?" - ".$employee["Account"]["Biodata"]["full_name"]:""?>
                <div class="pull-right">
                    <button class="btn btn-xs btn-default" type="button" onclick="exp('print', '<?php echo Router::url("transaction/print?" . $_SERVER['QUERY_STRING'], true) ?>')">
                        <i class="icon-print2"></i> 
                        <?= __("Cetak") ?>
                    </button>&nbsp;
                    <button class="btn btn-xs btn-default" type="button" onclick="exp('excel', '<?php echo Router::url("transaction/excel?" . $_SERVER['QUERY_STRING'], true) ?>')">
                        <i class="icon-file-excel"></i>
                        Excel
                    </button>&nbsp;
                </div>
                <small class="display-block"><?= _APP_CORPORATE_FULL ?></small>
            </h6>
        </div>
        <div class="table-responsive stn-table stn-table-nowrap">
            <form id="checkboxForm" method="post" name="checkboxForm" action="<?php echo Router::url('/' . $this->params['prefix'] . '/' . $this->params['controller'] . '/multiple_delete', true); ?>">
                <table width="100%" class="table table-hover table-bordered">
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
                        if (!isset($employeeDataDeposits) || empty($employeeDataDeposits)) {
                            ?>
                            <tr>
                                <td class = "text-center" colspan ="10">Tidak Ada Data</td>
                            </tr>
                            <?php
                        } else {
                            $initialBalance = array_slice($employeeDataDeposits, 0)[0]["EmployeeDataDeposit"]["deposit_previous_balance"];
                            ?>
                            <tr>
                                <td class="text-center"><?= $i++ ?></td>
                                <td class="text-right" colspan="7"><?= __("Saldo Awal") ?></td>
                                <td class="text-center" style = "border-right-style:none !important" width = "25">Rp. </td>
                                <td class="text-right" style = "border-left-style:none !important" width = "150"><?= ic_rupiah($initialBalance) ?></td>
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
                                    <td class="text-right" style = "border-left-style:none !important" width = "150"><?= ic_rupiah($debit) ?></td>
                                    <td class="text-center" style = "border-right-style:none !important" width = "25">Rp. </td>
                                    <td class="text-right" style = "border-left-style:none !important" width = "150"><?= ic_rupiah($credit) ?></td>
                                    <td class="text-center" style = "border-right-style:none !important" width = "25">Rp. </td>
                                    <td class="text-right" style = "border-left-style:none !important" width = "150"><?= ic_rupiah($balance) ?></td>
                                </tr>
                                <?php
                                $i++;
                            }
                            ?>
                            <tr>
                                <td class="text-center"><?= $i++ ?></td>
                                <td class="text-right" colspan="7"><?= __("Saldo Akhir") ?></td>
                                <td class="text-center" style = "border-right-style:none !important" width = "25">Rp. </td>
                                <td class="text-right" style = "border-left-style:none !important" width = "150"><?= ic_rupiah($endingBalance) ?></td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </form>
        </div>
    </div>
</div>