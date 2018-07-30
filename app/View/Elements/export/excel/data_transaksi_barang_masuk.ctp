<div style="text-align: center">
    <div style="font-size:11px;font-weight: bold; font-family:Tahoma, Geneva, sans-serif;">
        Data Transaksi Barang Masuk
    </div>
    <div style="font-size:11px;font-style: italic; font-family:Tahoma, Geneva, sans-serif;">Periode : <?= $this->Echo->laporanPeriodeBulan(@$periodeLaporanStartDate, @$periodeLaporanEndDate) ?></div>
</div>
<br/>
<table width="100%" class="table-data">
    <thead>
        <tr>
            <th width="50">No</th>
            <th><?= __("Nomor Transaksi") ?></th>
            <th><?= __("Nomor Nota Timbang") ?></th>
            <th><?= __("Nama Pegawai Pembuat Nota Timbang") ?></th>
            <?php
            if ($stnAdmin->branchPrivilege()) {
                ?>
                <th><?= __("Cabang") ?></th>
                <?php
            }
            ?>
            <th colspan = "2"><?= __("Total Transaksi") ?></th>
            <th colspan = "2"><?= __("Sisa Pembayaran") ?></th>
            <th><?= __("Nama Kasir") ?></th>
            <th><?= __("Tanggal Timbang") ?></th>
            <th><?= __("Tanggal Perincian") ?></th>
            <th><?= __("Supplier") ?></th>
            <th><?= __("Status") ?></th>
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
                <td class = "text-center" colspan = 13>Tidak Ada Data</td>
            </tr>
            <?php
        } else {
            foreach ($data['rows'] as $item) {
                ?>
                <tr>
                    <td class="text-center"><?= $i ?></td>
                    <td class="text-center"><?php echo emptyToStrip($item["TransactionEntry"]['transaction_number']); ?></td>
                    <td class="text-center"><?php echo $item["MaterialEntry"]['material_entry_number']; ?></td>
                    <td class="text-center"><?= $item['MaterialEntry']['Employee']['Account']['Biodata']['full_name'] ?></td>
                    <?php
                    if ($stnAdmin->branchPrivilege()) {
                        ?>
                        <td class="text-left"><?php echo $item["BranchOffice"]['name']; ?></td>
                        <?php
                    }
                    ?>
                    <td class="text-center" style = "border-right-style:none !important" width = "50">Rp. </td>
                    <td class="text-right" style = "border-left-style:none !important" width = "100"><?php echo emptyToStrip(($item["TransactionEntry"]['total'])); ?></td>
                    <td class="text-center" style = "border-right-style:none !important" width = "50">Rp. </td>
                    <td class="text-right" style = "border-left-style:none !important" width = "100"><?php echo emptyToStrip(($item["TransactionEntry"]['remaining'])); ?></td>
                    <td class="text-center"><?php echo!empty($item['Employee']['id']) ? $item['Employee']['Account']['Biodata']['full_name'] : "-"; ?></td>
                    <td class="text-center"><?php echo!empty($item['MaterialEntry']['weight_date']) ? $this->Html->cvtTanggal($item["MaterialEntry"]['weight_date']) : "-"; ?></td>
                    <td class="text-center"><?php echo!empty($item['TransactionEntry']['created_date']) ? $this->Html->cvtWaktu($item["TransactionEntry"]['created_date']) : "-"; ?></td>
                    <td class="text-center"><?php echo $item['Supplier']['name']; ?></td>
                    <td class="text-center"><?= $item['TransactionEntryStatus']['name'] ?></td>      
                </tr>
                <?php
                $i++;
            }
        }
        ?>
    </tbody>
</table>