<div style="text-align: center">
    <div style="font-size:11px;font-weight: bold; font-family:Tahoma, Geneva, sans-serif;">
        Data Penjualan Produk Tambahan
    </div>
</div>
<br>
<table width="100%" class="table-data">
    <thead>
        <tr>
            <th width="10">No</th>
            <th><?= __("Nomor Penjualan") ?></th>
            <th><?= __("Tgl Penjualan") ?></th>
            <th colspan="2"><?= __("Total Harga Penjualan") ?></th>
            <th><?= __("Penanggungjawab") ?></th>
            <th><?= __("Pembeli") ?></th>
            <th><?= __("Tipe Pembayaran") ?></th>
            <th><?= __("Status Pembayaran") ?></th>
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
                <td class = "text-center" colspan = "8">Tidak Ada Data</td>
            </tr>
            <?php
        } else {
            foreach ($data['rows'] as $item) {
                ?>
                <tr id="row-<?= $i ?>" class="removeRow<?php echo $item["SaleProductAdditional"]['id']; ?>">
                    <td class="text-center"><?= $i ?></td>
                    <td class="text-center"><?php echo $item["SaleProductAdditional"]['reference_number']; ?></td>
                    <td class="text-center"><?php echo !empty($item["SaleProductAdditional"]['sale_date']) ? $this->Html->cvtTanggal($item["SaleProductAdditional"]['sale_date']) : "-"; ?></td>
                    <td class="text-center" style = "border-right-style:none !important" width = "10">Rp. </td>
                    <td class="text-right" style = "border-left-style:none !important" width = "75"><?= ic_rupiah($item['SaleProductAdditional']['grand_total']); ?></td>
                    <td class="text-left"><?= $item['Employee']['Account']['Biodata']['full_name'] ?></td>
                    <td class="text-left"><?= $item['Purchaser']["Account"]['Biodata']['full_name'] ?></td>
                    <td class="text-center"><?= emptyToStrip(@$item['PaymentType']['name']) ?></td>
                    <td class="text-center"><?= $item['PaymentStatus']["name"] ?></td>
                </tr>
                <?php
                $i++;
            }
        }
        ?>
    </tbody>
</table>