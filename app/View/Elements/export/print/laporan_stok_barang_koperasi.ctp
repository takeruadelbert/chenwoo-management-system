<div style="text-align: center">
    <div style="font-size:11px;font-weight: bold; font-family:Tahoma, Geneva, sans-serif;">
        Laporan Stok Barang Koperasi
    </div>
</div>
<br>
<table width="100%" class="table-data">
    <thead>
        <tr>
            <th width="50">No</th>                            
            <th><?= __("Kode Barang") ?></th>
            <th><?= __("Barcode Barang") ?></th>
            <th><?= __("Nama Barang") ?></th>
            <th><?= __("Kategori Barang") ?></th>
            <th colspan = "2"><?= __("Stok") ?></th>
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
                <td class = "text-center" colspan = "7">Tidak Ada Data</td>
            </tr>
            <?php
        } else {
            foreach ($data['rows'] as $item) {
                ?>
                <tr>
                    <td class="text-center"><?= $i ?></td>                                    
                    <td class="text-left"><?= $item['CooperativeGoodList']['code'] ?></td>
                    <td class="text-left"><?= $item['CooperativeGoodList']['barcode'] ?></td>
                    <td class="text-left"><?= $item['CooperativeGoodList']['name'] ?></td>
                    <td class="text-left"><?= $item['GoodType']['name'] ?></td>
                    <td class="text-right" style = "border-right-style:none !important"><?= $item['CooperativeGoodList']['stock_number'] ?></td>
                    <td class="text-right" style = "border-left-style:none !important" width = "75"><?= $item['CooperativeGoodListUnit']['name'] ?></td>
                </tr>
                <?php
                $i++;
            }
        }
        ?>
    </tbody>
</table>