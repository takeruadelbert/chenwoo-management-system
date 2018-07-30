<div style="text-align: center">
    <div style="font-size:11px;font-weight: bold; font-family:Tahoma, Geneva, sans-serif;">
        Data Manajemen Produk
    </div>
</div>
<br/> 
<table width="100%" class="table-data">
    <thead>
        <tr>
            <th width="50">No</th>
            <th><?= __("Kategori Produk") ?></th>
            <th><?= __("Nama Produk") ?></th>
            <th><?= __("Satuan") ?></th>
            <th colspan = "2"><?= __("Harga (USD)") ?></th>
            <th colspan = "2"><?= __("Harga (Rupiah)") ?></th>
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
                <td class = "text-center" colspan = "9">Tidak Ada Data</td>
            </tr>
            <?php
        } else {
            foreach ($data['rows'] as $item) {
                ?>
                <tr>
                    <td class="text-center"><?= $i ?></td>
                    <td class="text-center"><?= !empty($item['Product']['parent_id']) ? $item['Parent']['name'] : "-" ?></td>
                    <td class="text-center"><?php echo $item['Product']['name']; ?></td>
                    <td class="text-center"><?= emptyToStrip($item['ProductUnit']['name']); ?></td>
                    <td class="text-center" style = "border-right-style: none !important" width = "50"><?= !empty($item['Product']['parent_id']) ? "$" : "" ?></td>
                    <td class="text-right" style = "border-left-style: none !important" width = "80"><?= !empty($item['Product']['parent_id']) ? ($item['Product']['price_usd']) : "-" ?></td>
                    <td class="text-center" style = "border-right-style: none !important" width = "50"><?= !empty($item['Product']['parent_id']) ? "Rp" : "" ?></td>
                    <td class="text-right" style = "border-left-style: none !important" width = "80"><?= !empty($item['Product']['parent_id']) ? ($item['Product']['price_rupiah']) : "-" ?></td>
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
            }
        }
        ?>
    </tbody>
</table>