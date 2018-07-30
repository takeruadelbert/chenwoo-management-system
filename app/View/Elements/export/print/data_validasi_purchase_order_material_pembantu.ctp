<div style="text-align: center">
    <div style="font-size:11px;font-weight: bold; font-family:Tahoma, Geneva, sans-serif;">
        Data Validasi Purchase Order Material Pembantu
    </div>
    <div style="font-size:11px;font-style: italic; font-family:Tahoma, Geneva, sans-serif;">Periode : <?= $this->Echo->laporanPeriodeBulan(@$periodeLaporanStartDate, @$periodeLaporanEndDate) ?></div>
</div>
<br/>
<table width="100%" class="table-data">
    <thead>
        <tr>
            <th width="50">No</th>
            <th><?= __("Nomor PO") ?></th>
            <th><?= __("Supplier") ?></th>
            <th><?= __("Tanggal PO") ?></th>
            <th><?= __("Nama Pegawai") ?></th>
            <?php
            if ($stnAdmin->branchPrivilege()) {
                ?>
                <th><?= __("Cabang") ?></th>
                <?php
            }
            ?>
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
                <td class = "text-center" colspan = 7>Tidak Ada Data</td>
            </tr>
            <?php
        } else {
            foreach ($data['rows'] as $item) {
                ?>
                <tr>
                    <td class="text-center"><?= $i ?></td>
                    <td class="text-center"><?php echo $item["PurchaseOrderMaterialAdditional"]['po_number']; ?></td>
                    <td class="text-center"><?php echo $item["MaterialAdditionalSupplier"]['name']; ?></td>
                    <td class="text-center"><?php echo $this->Html->cvtTanggal($item["PurchaseOrderMaterialAdditional"]['po_date']); ?></td>
                    <td class="text-center"><?php echo $item['Employee']['Account']['Biodata']['full_name']; ?></td>
                    <?php
                    if ($stnAdmin->branchPrivilege()) {
                        ?>
                        <td class="text-left"><?php echo $item["BranchOffice"]['name']; ?></td>
                        <?php
                    }
                    ?>
                    <td class="text-center">
                        <?php
                        echo $item['PurchaseOrderMaterialAdditionalStatus']['name'];
                        ?>
                    </td>
                </tr>
                <?php
                $i++;
            }
        }
        ?>
    </tbody>
</table>