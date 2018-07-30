<div style="text-align: center">
    <div style="font-size:18px;font-weight: bold">
        Data Barang Masuk Material Pembantu
    </div>
    <div>Periode : <?= $this->Echo->laporanPeriodeBulan(@$periodeLaporanStartDate, @$periodeLaporanEndDate) ?></div>
</div>
<br/>
<table width="100%" class="table-data">
    <thead>
        <tr>
            <th width = "50">No</th>
            <th width="200"><?= __("Nomor PO") ?></th>
            <th><?= __("Supplier") ?></th>
            <th width="150"><?= __("Tanggal PO") ?></th>
            <th><?= __("Nama Pegawai") ?></th>
            <?php
            if ($stnAdmin->branchPrivilege()) {
                ?>
                <th><?= __("Cabang") ?></th>
                <?php
            }
            ?>
            <th width="170"><?= __("Jumlah Material Diorder") ?></th>
            <th width="150"><?= __("Kekurangan Material") ?></th>
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
                <td class = "text-center" colspan = 8>Tidak Ada Data</td>
            </tr>
            <?php
        } else {
            foreach ($data['rows'] as $item) {
                ?>
                <tr>
                    <td class="text-center"><?= $i ?></td>
                    <td class="text-center">
                        <?= $item["PurchaseOrderMaterialAdditional"]['po_number']; ?>                                
                    </td>
                    <td class="text-left"><?php echo $item["MaterialAdditionalSupplier"]['name']; ?></td>
                    <td class="text-center"><?php echo $this->Html->cvtTanggal($item["PurchaseOrderMaterialAdditional"]['po_date']); ?></td>
                    <td class="text-left"><?php echo $item['Employee']['Account']['Biodata']['full_name']; ?></td>
                    <?php
                    if ($stnAdmin->branchPrivilege()) {
                        ?>
                        <td class="text-left"><?php echo $item["BranchOffice"]['name']; ?></td>
                        <?php
                    }
                    ?>
                    <td class="text-center"  id = "target-change-status<?= $i ?>">
                        <?php
                        $total = 0;
                        $remaining = 0;
                        foreach ($item["PurchaseOrderMaterialAdditionalDetail"] as $detail) {
                            $total = $detail['quantity'];
                            $remaining = $detail['quantity_remaining'];
                        }
                        if ($remaining > 0) {
                            $btn = "warning";
                        } else {
                            $btn = "success";
                        }
                        echo $total;
                        ?>
                    </td>
                    <td class="text-center"  id = "target-change-status<?= $i ?>">
                        <span class="label label-<?= $btn ?>">
                            <?php
                            echo $remaining;
                            ?>
                        </span>
                    </td>
                </tr>
                <?php
                $i++;
            }
        }
        ?>
    </tbody>
</table>