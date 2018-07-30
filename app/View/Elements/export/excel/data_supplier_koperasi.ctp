<div style="text-align: center">
    <div style="font-size:11px;font-weight: bold; font-family:Tahoma, Geneva, sans-serif;">
        Data Supplier Koperasi
    </div>
</div>
<br/>
<table width="100%" class="table-data">
    <thead>
        <tr>
            <th width="50">No</th>
            <th><?= __("Nama Supplier") ?></th>
            <th><?= __("Alamat Supplier") ?></th>
            <th><?= __("No. Telp") ?></th>
            <th><?= __("Email") ?></th>
            <th><?= __("Tipe Supplier") ?></th>
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
                <td class = "text-center" colspan = "6">Tidak Ada Data</td>
            </tr>
            <?php
        } else {
            foreach ($data['rows'] as $item) {
                ?>
                <tr>
                    <td class="text-center"><?= $i ?></td>
                    <td class="text-center"><?php echo $item["CooperativeSupplier"]['name']; ?></td>
                    <td class="text-center"><?php echo $this->Echo->empty_strip($item["CooperativeSupplier"]['address']); ?></td>
                    <td class="text-center"><?php echo $this->Echo->empty_strip($item["CooperativeSupplier"]['phone']); ?></td>
                    <td class="text-center"><?php echo $this->Echo->empty_strip($item["CooperativeSupplier"]['email']); ?></td>
                    <td class="text-center"><?php echo $this->Echo->empty_strip(@$item["CooperativeSupplierType"]['name']); ?></td>
                </tr>
                <?php
                $i++;
            }
        }
        ?>
    </tbody>
</table>