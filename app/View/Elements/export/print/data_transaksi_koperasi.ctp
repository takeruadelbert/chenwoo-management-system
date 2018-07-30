<div style="text-align: center">
    <div style="font-size:18px;font-weight: bold">
        Data Transaksi Koperasi
    </div>
    <div>Periode : <?= $this->Echo->laporanPeriodeBulan(@$periodeLaporanStartDate, @$periodeLaporanEndDate) ?></div>
</div>
<br/>
<table width="100%" class="table-data">
    <thead>
        <tr>
            <th width="50">No</th>
            <th width="150"><?= __("Tipe Transaksi") ?></th>
            <th width="150"><?= __("Nomor Transaksi") ?></th>
            <th width="200"><?= __("Pegawai Pelaksana") ?></th>
            <th width="150"><?= __("Waktu Proses") ?></th>
            <th width="125"><?= __("Kas Asal/Tujuan") ?></th>
            <th><?= __("Total Transaksi") ?></th>
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
                <td class = "text-center" colspan = 7>Tidak Ada Data</td>
            </tr>
            <?php
        } else {
            foreach ($data['rows'] as $item) {
                ?>
                <tr>
                <tr>
                    <td class="text-center"><?= $i ?></td>
                    <td class="text-left"><?= $item['CooperativeTransactionType']['name'] ?></td>
                    <td class="text-left"><?= $this->Chenwoo->nomorTransaksiKoperasi($item, false) ?></td>
                    <td class="text-left"><?= $item['Employee']['Account']['Biodata']['full_name'] ?></td>
                    <td class="text-left"><?= $this->Html->cvtWaktu($item['CooperativeTransactionMutation']['transaction_date']) ?></td>
                    <td class="text-left"><?= $item['CooperativeCash']['name'] ?></td>
                    <td class="text-right" style = "border-left-style:none !important" width = "75"><?= $item['CooperativeTransactionMutation']['nominal__ic'] ?></td>
                </tr>
                </tr>
                <?php
                $i++;
            }
        }
        ?>
    </tbody>
</table>