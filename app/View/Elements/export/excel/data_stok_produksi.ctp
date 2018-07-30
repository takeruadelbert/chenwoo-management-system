<div style="text-align: center">
    <div style="font-size:11px;font-weight: bold; font-family:Tahoma, Geneva, sans-serif;">
        Data Stok Produksi 
    </div>
</div>
<br>
<table width="100%" class="table-data">
    <thead>
        <tr>
            <th width="50">No</th>
            <th><?= __("Nama") ?></th>
            <th><?= __("Kode") ?></th>
            <th colspan = "2"><?= __("Berat Produk yang Tersedia") ?></th>
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
                <td class = "text-center" colspan ="6">Tidak Ada Data</td>
            </tr>
            <?php
        } else {
            $total=0;
            foreach ($data['rows'] as $item) {
                ?>
                <tr id="row-<?= $i ?>">
                    <td class="text-center"><?= $i ?></td>
                    <td><?= $item['Parent']['name'] . " - " . $item["Product"]['name']; ?><?= !empty($item["Product"]['weight']) ? " ({$item["Product"]['weight']} {$item["ProductUnit"]["name"]})" : "" ?></td>
                    <td class="text-center"><?= $item["Product"]['code']; ?></td>
                    <td class="text-right"><?= empty($item["Product"]['stock']) ? 0 : ($item["Product"]['stock']); ?></td>
                    <td class="text-right" width = "50"><?= $item['ProductUnit']['name'] ?></td>
                    <?php
                    if ($stnAdmin->branchPrivilege()) {
                        ?>
                        <td class="text-left"><?php echo $item["BranchOffice"]['name']; ?></td>
                        <?php
                    }
                    ?>
                </tr>
                <?php
                $i++;
                $total+=$item["Product"]['stock'];
            }
            ?>
                <tr id="row-<?= $i ?>" class="removeRow<?php echo $item["ProductDetail"]['id']; ?>">
                    <td colspan="2"></td>
                    <td class="text-right">Total</td>
                    <td class="text-right" style = "border-right: none !important"><?php echo $total; ?></td>
                    <td width = "50" class = "text-center" style = "border-left: none !important"><?php echo "Kg"; ?></td>
                    <td colspan="2"></td>
                </tr>
            <?php
        }
        ?>
    </tbody>
</table>