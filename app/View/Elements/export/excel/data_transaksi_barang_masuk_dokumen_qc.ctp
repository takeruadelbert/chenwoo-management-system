<div style="text-align: center">
    <div style="font-size:11px;font-weight: bold; font-family:Tahoma, Geneva, sans-serif;">
        Data Transaksi Barang Masuk Status Dokumen QC
    </div>
    <div style="font-size:10px;font-style: italic; font-family:Tahoma, Geneva, sans-serif;">Periode : <?= $this->Echo->laporanPeriodeBulan(@$periodeLaporanStartDate, @$periodeLaporanEndDate) ?></div>
</div>
<br/> 
<table width="100%" class="table-data">
    <thead>
        <tr>
            <th width="50">No</th>
            <th><?= __("Nomor Transaksi") ?></th>
            <th><?= __("Nomor Nota Timbang") ?></th>
            <th><?= __("Nama Pegawai<br>Pembuat Nota Timbang") ?></th>
            <th><?= __("Nama Kasir") ?></th>
            <th><?= __("Tanggal Dibuat") ?></th>
            <th><?= __("Supplier") ?></th>
            <?php
            if ($stnAdmin->branchPrivilege()) {
                ?>
                <th><?= __("Cabang") ?></th>
                <?php
            }
            ?>
            <th><?= __("Status Dokumen QC") ?></th>
            <th><?= __("Status") ?></th>
        </tr>
    </thead>
    <tbody style="line-height:20px;">
        <?php
        $limit = intval(isset($this->params['named']['limit']) ? $this->params['named']['limit'] : 10);
        $page = intval(isset($this->params['named']['page']) ? $this->params['named']['page'] : 1);
        $i = ($limit * $page) - ($limit - 1);
        if (empty($data['rows'])) {
            ?>
            <tr>
                <td class = "text-center" colspan = 10>Tidak Ada Data</td>
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
                    <td class="text-center" width="150"><?php echo!empty($item['Employee']['id']) ? $item['Employee']['Account']['Biodata']['full_name'] : "-"; ?></td>
                    <td class="text-center"><?php echo!empty($item['TransactionEntry']['created_date']) ? $this->Html->cvtTanggalWaktu($item["TransactionEntry"]['created_date']) : "-"; ?></td>
                    <td class="text-center"><?php echo $item['Supplier']['name']; ?></td>
                    <?php
                    if ($stnAdmin->branchPrivilege()) {
                        ?>
                        <td class="text-left"><?php echo $item["BranchOffice"]['name']; ?></td>
                        <?php
                    }
                    ?>
                    <td class="text-center"><?= $item['TransactionEntryStatus']['name'] ?></td>  
                    <td class="text-center"><?= $item['DocumentStatus']['name'] ?></td>      
                </tr>
                <?php
                $i++;
            }
        }
        ?>
    </tbody>
</table>