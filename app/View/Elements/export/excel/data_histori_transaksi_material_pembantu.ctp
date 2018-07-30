<div style="text-align: center">
    <div style="font-size:11px;font-weight: bold; font-family:Tahoma, Geneva, sans-serif;">
        Data Histori Transaksi Material Pembantu
    </div>
    <div style="font-size:11px;font-style: italic; font-family:Tahoma, Geneva, sans-serif;">Periode : <?= $this->Echo->laporanPeriodeBulan(@$periodeLaporanStartDate, @$periodeLaporanEndDate) ?></div>
</div>
<br/>
<table width="100%" class="table-data">
    <thead>
        <tr>
            <th width="50">No</th>
            <th><?= __("Nomor PO") ?></th>
            <th><?= __("Nomor RO") ?></th>
            <th><?= __("Nama Pegawai Pembuat RO") ?></th>
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
            <th><?= __("Tanggal PO") ?></th>
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
                <td class = "text-center" colspan = 15>Tidak Ada Data</td>
            </tr>
            <?php
        } else {
            foreach ($data['rows'] as $item) {
                ?>
                <tr >
                    <td class="text-center"><?= $i ?></td>
                    <td class="text-center"><?php echo emptyToStrip($item["PurchaseOrderMaterialAdditional"]['po_number']); ?></td>
                    <td class="text-center"><?php echo $item["RequestOrderMaterialAdditional"]['ro_number']; ?></td>
                    <td class="text-center"><?= $item['RequestOrderMaterialAdditional']['Employee']['Account']['Biodata']['full_name'] ?></td>
                    <?php
                    if ($stnAdmin->branchPrivilege()) {
                        ?>
                        <td class="text-left"><?php echo $item["BranchOffice"]['name']; ?></td>
                        <?php
                    }
                    ?>
                    <td class="text-center" style = "border-right-style:none !important" width = "50">Rp. </td>
                    <td class="text-right" style = "border-left-style:none !important" width = "100"><?php echo emptyToStrip(($item["PurchaseOrderMaterialAdditional"]['total'])); ?></td>
                    <td class="text-center" style = "border-right-style:none !important" width = "50">Rp. </td>
                    <td class="text-right" style = "border-left-style:none !important" width = "100"><?php echo emptyToStrip(($item["PurchaseOrderMaterialAdditional"]['remaining'])); ?></td>
                    <td class="text-center"><?php echo!empty($item['Employee']['id']) ? $item['Employee']['Account']['Biodata']['full_name'] : "-"; ?></td>
                    <td class="text-center"><?php echo!empty($item['PurchaseOrderMaterialAdditional']['po_date']) ? $this->Html->cvtWaktu($item["PurchaseOrderMaterialAdditional"]['po_date']) : "-"; ?></td>
                    <td class="text-center"><?php echo $item['MaterialAdditionalSupplier']['name']; ?></td>
                    <td class="text-center"><?= $item['PurchaseOrderMaterialAdditionalStatus']['name'] ?></td>      
                </tr>
                <?php
                $i++;
            }
        }
        ?>
    </tbody>
</table>