<div style="text-align: center">
    <div style="font-size:11px;font-weight: bold; font-family:Tahoma, Geneva, sans-serif;">
        Data Pengembalian Barang Ke Gudang
    </div>
    <div style="font-size:11px;font-style: italic; font-family:Tahoma, Geneva, sans-serif;">Periode : <?= $this->Echo->laporanPeriodeBulan(@$periodeLaporanStartDate, @$periodeLaporanEndDate) ?></div>
</div>
<br>
<table width="100%" class="table-data" style="line-height:20px;">
    <thead>
        <tr>
            <th width="50">No</th>
            <th><?= __("Nomor Pengembalian") ?></th>
            <th><?= __("Nomor Nota Timbang") ?></th>
            <th><?= __("Status Pengembalian") ?></th>
            <th><?= __("Tanggal Dibuat") ?></th>
            <th><?= __("Penanggung Jawab") ?></th>
            <?php
            if ($stnAdmin->branchPrivilege()) {
                ?>
                <th><?= __("Cabang") ?></th>
                <?php
            }
            ?>
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
                    <td class="text-center"><?= $i ?></td>
                    <td class="text-center"><?php echo $item['ReturnOrder']['return_number']; ?></td>
                    <td class="text-center"><?php echo $item['MaterialEntry']['material_entry_number']; ?></td>
                    <td class="text-center"><?php echo $item['ReturnOrderStatus']['name']; ?></td>
                    <td class="text-center"><?php echo $this->Html->cvtTanggal($item['ReturnOrder']['created']); ?></td>
                    <td class="text-center"><?php echo $item['Employee']['Account']['Biodata']['full_name']; ?></td>
                    <?php
                    if ($stnAdmin->branchPrivilege()) {
                        ?>
                        <td class="text-left"><?php echo emptyToStrip($item["BranchOffice"]['name']); ?></td>
                        <?php
                    }
                    ?>     
                </tr>
                <?php
                $i++;
            }
        }
        ?>
    </tbody>
</table>