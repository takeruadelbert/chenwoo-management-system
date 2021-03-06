<div style="text-align: center">
    <div style="font-size:11px;font-weight: bold; font-family:Tahoma, Geneva, sans-serif;">
        Berita Departemen
    </div>
</div>
<br>
<table width="100%" class="table-data" style="font-size:11px;font-family:Tahoma, Geneva, sans-serif;">
    <thead>
        <tr>
            <th width="50">No</th>
            <th><?= __("Judul Berita") ?></th>
            <th><?= __("Penulis Berita") ?></th>
            <th><?= __("Tanggal Posting") ?></th>
            <th><?= __("Departemen Tujuan") ?></th>
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
                <td class = "text-center" colspan = 13>Tidak Ada Data</td>
            </tr>
            <?php
        } else {
            foreach ($data['rows'] as $item) {
                ?>
                <tr id="row-<?= $i ?>" class="removeRow<?php echo $item[Inflector::classify($this->params['controller'])]['id']; ?>">
                    <td class="text-center"><?= $i ?></td>
                    <td class="text-left"><?= $item['DepartmentNews']['title'] ?></td>
                    <td class="text-center"><?= $item['Employee']['Account']['Biodata']['full_name'] ?></td>
                    <td class="text-center"><?= $this->Html->cvtHariTanggal($item['DepartmentNews']['created']) ?></td>
                    <td class="text-center"><?= $item['Department']['name'] ?></td>
                </tr>
                <?php
                $i++;
            }
        }
        ?>
    </tbody>
</table>