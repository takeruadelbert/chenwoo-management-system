<div style="text-align: center">
    <div style="font-size:11px;font-weight: bold; font-family:Tahoma, Geneva, sans-serif;">
        Data Supplier Material
    </div>
</div>
<br>
<table width="100%" class="table-data">
    <thead>
        <tr>
            <th width="50">No</th>
            <th><?= __("ID Supplier") ?></th>
            <th><?= __("Tipe Supplier") ?></th>
            <th><?= __("Nama Supplier") ?></th>
            <th><?= __("Alamat") ?></th>
            <th><?= __("Provinsi") ?></th>
            <th><?= __("Kota") ?></th>
            <th><?= __("Negara") ?></th>
            <th><?= __("Nomor Telepon") ?></th>
            <th><?= __("Email") ?></th>
            <th><?= __("Website") ?></th>
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
                <td class = "text-center" colspan = 11>Tidak Ada Data</td>
            </tr>
            <?php
        } else {
            foreach ($data['rows'] as $item) {
                ?>
                <tr id="row-<?= $i ?>" class="removeRow<?php echo $item["Supplier"]['id']; ?>">
                    <td class="text-center"><?= $i ?></td>
                    <td class="text-center"><?php echo $item["Supplier"]['id_supplier']; ?></td>
                    <td class="text-center"><?php echo $item["SupplierType"]['name']; ?></td>
                    <td class="text-center"><?php echo $this->Echo->empty_strip($item["Supplier"]['name']); ?></td>
                    <td class="text-center"><?php echo $this->Echo->empty_strip($item["Supplier"]['address']); ?></td>
                    <td class="text-center"><?php echo $this->Echo->empty_strip($item["State"]['name']); ?></td>
                    <td class="text-center"><?php echo $this->Echo->empty_strip($item["City"]['name']); ?></td>
                    <td class="text-center"><?php echo $this->Echo->empty_strip($item["Country"]['name']); ?></td>
                    <td class="text-center"><?php echo $this->Echo->empty_strip($item["Supplier"]['phone_number']); ?></td>
                    <td class="text-center"><?php echo $this->Echo->empty_strip($item["Supplier"]['email']); ?></td>
                    <td class="text-center"><?php echo $this->Echo->empty_strip($item["Supplier"]['website']); ?></td>
                </tr>
                <?php
                $i++;
            }
        }
        ?>
    </tbody>
</table>