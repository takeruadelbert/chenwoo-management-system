<div style="text-align: center">
    <div style="font-size:11px;font-weight: bold; font-family:Tahoma, Geneva, sans-serif;">
        Data Jenis Jam Kerja
    </div>
</div>
<br>
<table width="100%" class="table-data">
    <thead>
        <tr>
            <th width="50">No</th>
            <th><?= __("Jenis Jam Kerja") ?></th>
            <th><?= __("Abaikan Hari Libur?") ?></th>
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
                    <td class="text-center"> <?= $item['WorkingHourType']['name'] ?></td>
                    <td class="text-center">
                        <?php
                        if ($item['WorkingHourType']['ignore_holiday'] == '1') {
                            echo "Ya";
                        } else {
                            echo "Tidak";
                        }
                        ?>
                    </td>
                </tr>
                <?php
                $i++;
            }
        }
        ?>
    </tbody>
</table>