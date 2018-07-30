<h2 style="text-align: center">
    Data Satuan
</h2>
<table width="100%" class="table-data">
    <thead>
        <tr>
            <th width="50">No</th>
            <th><?= __("Nama") ?></th>
            <th><?= __("Satuan") ?></th>
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
                <td class = "text-center" colspan = 3>Tidak Ada Data</td>
            </tr>
            <?php
        } else {
            foreach ($data['rows'] as $item) {
                ?>
                <tr id="row-<?= $i ?>" class="removeRow<?php echo $item["Unit"]['id']; ?>">
                    <td class="text-center"><?= $i ?></td>
                    <td class="text-center"><?php echo $item["Unit"]['name']; ?></td>
                    <td class="text-center"><?php echo $item["Unit"]['uniq']; ?></td>
                </tr>
                <?php
                $i++;
            }
        }
        ?>
    </tbody>
</table>