<div style="text-align: center">
    <div style="font-size:11px;font-weight: bold; font-family:Tahoma, Geneva, sans-serif;">
        Data Hasil Penjualan Produk Tambahan
    </div>
</div>
<br>
<table width="100%" class="table-data">
    <thead>
        <tr>
            <th width="50">No</th>
            <th><?= __("Nomor Penjualan") ?></th>
            <th><?= __("Penanggungjawab") ?></th>
            <th><?= __("Nama Kas Koperasi") ?></th>
            <th><?= __("Nama Pembeli") ?></th>
            <th colspan="2"><?= __("Keuntungan yang Didapat") ?></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $limit = intval(isset($this->params['named']['limit']) ? $this->params['named']['limit'] : 10);
        $page = intval(isset($this->params['named']['page']) ? $this->params['named']['page'] : 1);
        $i = ($limit * $page) - ($limit - 1);
        $grandTotal = 0;
        if (empty($data['rows'])) {
            ?>
            <tr>
                <td class = "text-center" colspan = 8>Tidak Ada Data</td>
            </tr>
            <?php
        } else {
            foreach ($data['rows'] as $item) {
                $grandTotal += $item['CooperativeTransactionMutation']['nominal'];
                ?>
                <tr>
                    <td class="text-center"><?= $i ?></td>
                    <td class="text-center">
                        <?= $item["CooperativeTransactionMutation"]['SaleProductAdditional']["reference_number"] ?>
                    </td>
                    <td class="text-center"><?= $item['CooperativeTransactionMutation']['SaleProductAdditional']['Employee']['Account']['Biodata']['full_name'] ?></td>
                    <td class="text-center"><?= $item['CooperativeTransactionMutation']['CooperativeCash']['name'] ?></td>
                    <td class="text-center"><?= $item['CooperativeTransactionMutation']['SaleProductAdditional']['Purchaser']['Account']['Biodata']['full_name'] ?></td>
                    <td class="text-center" style = "border-right-style:none !important" width = "50">Rp. </td>
                    <td class="text-right" style = "border-left-style:none !important" width = "150"><?= ic_rupiah($item['CooperativeTransactionMutation']['nominal']) ?></td>
                </tr>
                <?php
                $i++;
            }
        }
        ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="5" class="text-right"><strong>Total Keuntungan</strong></td>
            <td class="text-center" style = "border-right-style:none !important" width = "50">Rp. </td>
            <td class="text-right" style = "border-left-style:none !important" width = "150"><strong><?= ic_rupiah($grandTotal) ?></strong></td>
        </tr>
    </tfoot>
</table>