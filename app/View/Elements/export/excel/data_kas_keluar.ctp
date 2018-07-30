<div style="text-align: center">
    <div style="font-size:11px;font-weight: bold; font-family:Tahoma, Geneva, sans-serif;">
        Data Kas Keluar
    </div>
    <div style="font-size:11px;font-style: italic; font-family:Tahoma, Geneva, sans-serif;">Periode : <?= $this->Echo->laporanPeriodeBulan(@$periodeLaporanStartDate, @$periodeLaporanEndDate) ?></div>
</div>
<br>
<table width="100%" class="table-data">
    <thead>
        <tr>
            <th width="50">No</th>
            <th><?= __("Nomor Kas") ?></th>
            <th><?= __("Nama Pegawai") ?></th>
            <?php
            if ($stnAdmin->branchPrivilege()) {
                ?>
                <th><?= __("Cabang") ?></th>
                <?php
            }
            ?>
            <th colspan="2"><?= __("Nominal") ?></th>
            <th><?= __("Tanggal Dibuat") ?></th>
            <th><?= __("Tipe Kas") ?></th>
            <th><?= __("Tipe Transaksi") ?></th>
            <th><?= __("Keterangan") ?></th>
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
                <td class = "text-center" colspan = 9>Tidak Ada Data</td>
            </tr>
            <?php
        } else {
            foreach ($data['rows'] as $item) {
                $totalDisbursement = 0;
                ?>
                <tr>
                    <td class="text-center"><?= $i ?></td>
                    <td class="text-center"><?= $item['CashDisbursement']['cash_disbursement_number'] ?></td>
                    <td class="text-center"><?= $item['Creator']['Account']['Biodata']['full_name'] ?></td>
                    <?php
                    if ($stnAdmin->branchPrivilege()) {
                        ?>
                        <td class="text-left"><?php echo $item["BranchOffice"]['name']; ?></td>
                        <?php
                    }
                    ?>
                    <td class="text-center" style = "border-right-style:none !important" width = "50"><?= $item['CashDisbursement']['transaction_currency_type_id'] == 1 ? "Rp." : "$" ?> </td>
                    <td class="text-right" style = "border-left-style:none !important" width = "150">
                        <?php
                        foreach ($item['CashDisbursementDetail'] as $details) {
                            $totalDisbursement += $details['amount'];
                        }
                        echo $item['CashDisbursement']['transaction_currency_type_id'] == 1 ? ic_rupiah($totalDisbursement) : ac_dollar($totalDisbursement);
                        ?>
                    </td>
                    <td class="text-center"><?= $this->Html->cvtWaktu($item['CashDisbursement']['created_datetime']) ?></td>
                    <td class="text-center"><?= $item['InitialBalance']['GeneralEntryType']['name'] ?></td>
                    <td class="text-center"><?= $item['TransactionCurrencyType']['name'] ?></td>
                    <td class="text-center"><?= $item['CashDisbursement']['note'] ?></td>
                </tr>
                <?php
                $i++;
            }
        }
        ?>
    </tbody>
</table>