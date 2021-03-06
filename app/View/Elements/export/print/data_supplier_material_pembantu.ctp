<h2 style="text-align: center">
    Data Supplier Material Pembantu
</h2>
<table width="100%" class="table-data">
    <thead>
        <tr>
            <th width="50">No</th>
            <th width="150"><?= __("ID Supplier Material Pembantu") ?></th>
            <th width="150"><?= __("Nama Supplier Material Pembantu") ?></th>
            <th><?= __("Alamat") ?></th>
            <th><?= __("Provinsi") ?></th>
            <th><?= __("Kota") ?></th>
            <th><?= __("Negara") ?></th>
            <th><?= __("No. Telepon") ?></th>
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
                <td class = "text-center" colspan = 10>Tidak Ada Data</td>
            </tr>
            <?php
        } else {
            foreach ($data['rows'] as $item) {
                ?>
                <tr>
                    <td class="text-center"><?= $i ?></td>
                    <td class="text-center"><?= $item['MaterialAdditionalSupplier']['id_supplier'] ?></td>
                    <td class="text-center"><?= $item['MaterialAdditionalSupplier']['name'] ?></td>
                    <td class="text-center"><?= $item['MaterialAdditionalSupplier']['address'] ?></td>
                    <td class="text-center"><?= $item['City']['name'] ?></td>
                    <td class="text-center"><?= $item['State']['name'] ?></td>
                    <td class="text-center"><?= $item['Country']['name'] ?></td>
                    <td class="text-center"><?= $item['MaterialAdditionalSupplier']['phone_number'] ?></td>
                    <td class="text-center"><?= $this->Echo->empty_strip($item['MaterialAdditionalSupplier']['email']) ?></td>
                    <td class="text-center"><?= $this->Echo->empty_strip($item['MaterialAdditionalSupplier']['website']) ?></td>
                </tr>
                <?php
                $i++;
            }
        }
        ?>
    </tbody>
</table>