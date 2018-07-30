<div style="text-align: center">
    <div style="font-size:11px;font-weight: bold; font-family:Tahoma, Geneva, sans-serif;">
        Data Kas Keluar Koperasi
    </div>
    <div style="font-size:10px;font-weight: 400; font-style: italic; font-family:Tahoma, Geneva, sans-serif;">Periode : <?= $this->Echo->laporanPeriodeBulan(@$periodeLaporanStartDate, @$periodeLaporanEndDate) ?></div>
</div>
<br/>
<table width="100%" class="table-data">
    <thead>
        <tr>
            <th width="50">No</th>
            <th><?= __("Kas Asal") ?></th>
            <th><?= __("Tipe Transaksi") ?></th>
            <th><?= __("Nomor Mutasi") ?></th>
            <th><?= __("Nomor Transaksi") ?></th>
            <th><?= __("Pegawai Pelaksana") ?></th>
            <?php
            if ($stnAdmin->cooperativeBranchPrivilege()) {
                ?>
                <th width = "250"><?= __("Cabang") ?></th>
                <?php
            }
            ?>
            <th><?= __("Waktu Proses") ?></th>
            <th colspan = "2"><?= __("Nominal") ?></th>
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
                <td class = "text-center" colspan ="10">Tidak Ada Data</td>
            </tr>
            <?php
        } else {
            foreach ($data['rows'] as $item) {
                ?>
                <tr>
                    <td class="text-center"><?= $i ?></td>
                    <td class="text-LEFT"><?= $item['CooperativeCash']['name']; ?></td>
                    <td class="text-left"><?= $item['CooperativeTransactionType']['name'] ?></td>
                    <td class="text-center">
                        <a data-toggle="modal" href="<?= Router::url("/admin/popups/content?content=viewcooptransaction-trns&id={$item["CooperativeTransactionMutation"]["id"]}") ?>" data-target="#default-view-coop-transaction"><?= $item["CooperativeTransactionMutation"]["id_number"] ?></a>
                    </td>
                    <td class="text-center"><?= $this->Chenwoo->nomorTransaksiKoperasi($item) ?></td>
                    <td class="text-left"><?= $item['Employee']['Account']['Biodata']['full_name'] . " ({$item['Employee']['nip']})" ?></td>
                    <?php
                    if ($stnAdmin->cooperativeBranchPrivilege()) {
                        ?>
                        <td class="text-left"><?php echo $this->Chenwoo->cabangKoperasi($item); ?></td>
                        <?php
                    }
                    ?>
                    <td class="text-center"><?= $this->Html->cvtWaktu($item['CooperativeTransactionMutation']['transaction_date'], false) ?></td>
                    <td class="text-center" style = "border-right-style:none !important" width = "50">Rp. </td>
                    <td class="text-right" style = "border-left-style:none !important" width = "150"><?= $item['CooperativeTransactionMutation']['nominal__ic'] ?></td>
                </tr>
                <?php
                $i++;
            }
        }
        ?>
    </tbody>
    <tfoot>
        <tr>
            <td class="text-right" colspan="8">
                <b>Grand total</b>
            </td>
            <td class="text-left" style = "border-right-style:none !important" width = "20"><b>Rp. </b></td>
            <td class="text-right" style = "border-left-style:none !important" width = "60"><b><?= array_sum(array_column(array_column($data['rows'], "CooperativeTransactionMutation"), "nominal")) ?></b></td>
        </tr>
    </tfoot>
</table>