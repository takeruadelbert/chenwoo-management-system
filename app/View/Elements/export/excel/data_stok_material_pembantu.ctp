<div style="text-align: center">
    <div style="font-size:11px;font-weight: bold; font-family:Tahoma, Geneva, sans-serif;">
        Data Stok Material Pembantu
    </div>
</div>
<br/>
<table width="100%" class="table-data">
    <thead>
        <tr>
            <th width="50">No</th>
            <th><?= __("Nama") ?></th>
            <th><?= __("Ukuran") ?></th>
            <th><?= __("Kategori") ?></th>
            <th><?= __("Unit") ?></th>
            <th><?= __("Stok Tersedia") ?></th>
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
                <td class = "text-center" colspan = 6>Tidak Ada Data</td>
            </tr>
            <?php
        } else {
            foreach ($data['rows'] as $item) {
                ?>
                <tr>
                    <td class="text-center"><?= $i ?></td>
                    <td><?php echo $item["MaterialAdditional"]['name']; ?></td>
                    <td><?php echo $item["MaterialAdditional"]['size']; ?></td>
                    <td class="text-center"><?php echo $item["MaterialAdditionalCategory"]['name']; ?></td>
                    <td class="text-center"><?php echo $item["MaterialAdditionalUnit"]['name']; ?></td>
                    <td class="text-center"><?php echo emptyToStrip($item["MaterialAdditional"]['quantity']); ?></td>
                </tr>
                <?php
                $i++;
            }
        }
        ?>
    </tbody>
</table>