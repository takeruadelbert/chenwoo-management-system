<h2 style="text-align: center">
    Data Kas Keluar Koperasi
</h2>
<table width="100%" class="table-data">
    <thead>
        <tr>
            <th width="50">No</th>
            <th><?= __("Nomor Kas") ?></th>
            <th><?= __("Dibuat Oleh") ?></th>
            <th><?= __("Tanggal Dibuat") ?></th>
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
                <td class = "text-center" colspan = 4>Tidak Ada Data</td>
            </tr>
            <?php
        } else {
            foreach ($data['rows'] as $item) {
                ?>
                <tr id="row-<?= $i ?>" class="removeRow<?php echo $item[Inflector::classify($this->params['controller'])]['id']; ?>">
                    <td class="text-center"><?= $i ?></td>
                    <td class="text-center"><?= $item['CooperativeCashOut']['cash_out_number'] ?></td>
                    <td class="text-center"><?= $item['Creator']['Account']['Biodata']['full_name'] ?></td>
                    <td class="text-center"><?= $this->Html->cvtWaktu($item['CooperativeCashOut']['created_datetime']) ?></td>

                </tr>
                <?php
                $i++;
            }
        }
        ?>
    </tbody>
</table>