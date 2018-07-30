<div style="text-align: center">
    <div style="font-size:11px;font-weight: bold; font-family:Tahoma, Geneva, sans-serif;">
        Data Hari Libur
    </div>
</div>
<br>
<table width="100%" class="table-data">
    <thead>
        <tr>
            <th width="50">No</th>
            <th><?= __("Hari Libur") ?></th>
            <th><?= __("Tanggal Libur") ?></th>
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
                <tr id="row-<?= $i ?>" class="removeRow<?php echo $item[Inflector::classify($this->params['controller'])]['id']; ?>">
                    <td class="text-center"><?= $i ?></td>
                    <td><?= $item['Holiday']['name'] ?></td>
                    <td><?= $this->Html->cvtHariTanggal($item['Holiday']['start_date']) ?><?= $item['Holiday']['start_date'] != $item['Holiday']['end_date'] ? " - " . $this->Html->cvtHariTanggal($item['Holiday']['end_date']) : "" ?> </td>
                </tr>
                <?php
                $i++;
            }
        }
        ?>
    </tbody>
</table>