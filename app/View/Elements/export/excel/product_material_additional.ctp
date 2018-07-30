<h2 style="text-align: center">
    Parameter Pemakaian Material Pembantu
</h2>
<table width="100%" class="table-data">
    <thead>
        <tr>
            <th width="50">No</th>
            <th><?= __("Kategori") ?></th>
            <th><?= __("Produk") ?></th>
            <th><?= __("Material Pembantu") ?></th>
            <th width="150"><?= __("Rata-rata pemakaian (per Kilo untuk Plastik, per Box untuk MC)") ?></th>
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
                <td class = "text-center" colspan = "5">Tidak Ada Data</td>
            </tr>
            <?php
        } else {
            foreach ($data['rows'] as $item) {
                ?>
                <tr id="row-<?= $i ?>" class="removeRow<?php echo $item["MaterialAdditional"]['id']; ?>">
                    <td class="text-center"><?= $i ?></td>
                    <td><?= $item["MaterialAdditionalCategory"]['name']; ?></td>
                    <td><?= $item["Product"]["Parent"]['name'] . " " . $item["Product"]['name']; ?></td>
                    <td><?= $item["MaterialAdditional"]['name']; ?></td>
                    <td class="text-right"><?= emptyToStrip(@$item["ProductMaterialAdditional"]['quantity']) . " " . emptyToStrip(@$item["MaterialAdditional"]["MaterialAdditionalUnit"]['name']); ?></td>
                </tr>
                <?php
                $i++;
            }
        }
        ?>
    </tbody>
</table>
