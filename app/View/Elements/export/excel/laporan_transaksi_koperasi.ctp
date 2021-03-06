<div style="text-align: center">
    <div style="font-size:11px;font-weight: bold; font-family:Tahoma, Geneva, sans-serif;">
        Laporan Transaksi Koperasi
    </div>
    <div style="font-size:10px;font-style: italic; font-family:Tahoma, Geneva, sans-serif;">Periode : <?= $this->Echo->laporanPeriodeBulan(@$periodeLaporanStartDate, @$periodeLaporanEndDate) ?></div>
</div>
<br/>
<table width="100%" class="table-data">
    <thead>
        <tr>
            <th width="50">No</th>
            <th><?= __("Kas Koperasi") ?></th>
            <th><?= __("Tipe Transaksi") ?></th>
            <th><?= __("Nomor Mutasi") ?></th>
            <th><?= __("Nomor Transaksi") ?></th>
            <th><?= __("Operator Pelaksana") ?></th>
            <?php
            if ($stnAdmin->cooperativeBranchPrivilege()) {
                ?>
                <th><?= __("Cabang") ?></th>
                <?php
            }
            ?>
            <th><?= __("Waktu Proses") ?></th>
            <th colspan = "2"><?= __("Debit") ?></th>
            <th colspan = "2"><?= __("Kredit") ?></th>
            <th colspan = "2"><?= __("Saldo") ?></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $limit = intval(isset($this->params['named']['limit']) ? $this->params['named']['limit'] : 10);
        $page = intval(isset($this->params['named']['page']) ? $this->params['named']['page'] : 1);
        $i = ($limit * $page) - ($limit - 1);
        if (empty($data['rows'][0]['EmployeeDataDeposit']) && empty($data['rows'][0]['EmployeeDataLoan'])) {
            ?>
            <tr>
                <td class = "text-center" colspan = 12>Tidak Ada Data</td>
            </tr>
            <?php
        } else {
            foreach ($data['rows'] as $item) {
                if($item['CooperativeTransactionType']['operation'] == "reduction") {
                    $debit = 0;
                    $kredit = $item['CooperativeTransactionMutation']['nominal'];
                } else {
                    $debit = $item['CooperativeTransactionMutation']['nominal'];
                    $kredit = 0;
                }
                ?>
                <tr>
                    <td class="text-center"><?= $i ?></td>
                    <td class="text-left"><?= $item['CooperativeCash']['name']; ?></td>
                    <td class="text-left"><?= $item['CooperativeTransactionType']['name'] ?></td>
                    <td class="text-center">
                        <?= $item["CooperativeTransactionMutation"]["id_number"] ?>
                    </td>
                    <td class="text-center"><?= $this->Chenwoo->nomorTransaksiKoperasi($item, false) ?></td>
                    <td class="text-left"><?= $item['Employee']['Account']['Biodata']['full_name'] . " ({$item['Employee']['nip']})" ?></td>
                    <?php
                    if ($stnAdmin->cooperativeBranchPrivilege()) {
                        ?>
                        <td class="text-left"><?php echo $this->Chenwoo->cabangKoperasi($item); ?></td>
                        <?php
                    }
                    ?>
                    <td class="text-center"><?= $this->Html->cvtWaktu($item['CooperativeTransactionMutation']['transaction_date'], false) ?></td>
                    <td class="text-center" style = "border-right-style:none !important" width = "10">Rp. </td>
                    <td class="text-right" style = "border-left-style:none !important" width = "50"><?= ic_rupiah($debit) ?></td>
                    <td class="text-center" style = "border-right-style:none !important" width = "10">Rp. </td>
                    <td class="text-right" style = "border-left-style:none !important" width = "50"><?= ic_rupiah($kredit) ?></td>
                    <td class="text-center" style = "border-right-style:none !important" width = "10">Rp. </td>
                    <td class="text-right" style = "border-left-style:none !important" width = "50"><?= ic_rupiah($item['CooperativeTransactionMutation']['balance_after_transaction']) ?></td>
                </tr>
                <?php
                $i++;
            }
        }
        ?>
    </tbody>
</table>