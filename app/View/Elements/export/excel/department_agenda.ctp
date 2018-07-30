<h2 style="text-align: center">
    Agenda Departemen
</h2>
<table width="100%" class="table-data">
    <thead>
        <tr>
            <th width="50" rowspan="2">No</th>
            <th rowspan="2"><?= __("Nama Departemen") ?></th>
            <th rowspan="2"><?= __("Judul Agenda") ?></th>
            <th rowspan="2"><?= __("Deskripsi Agenda") ?></th>
            <th colspan="2"><?= __("Waktu Mulai") ?> </th>
            <th colspan="2"><?= __("Waktu Selesai") ?></th>
        </tr>
        <tr>
            <th>Tanggal</th>
            <th>Jam</th>
            <th>Tanggal</th>
            <th>Jam</th>
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
                <td class = "text-center" colspan ="10">Tidak Ada Data</td>
            </tr>
            <?php
        } else {
            foreach ($data['rows'] as $data) {
                foreach ($data as $item) {
                    ?>
                    <tr>
                        <td class="text-center"><?= $i ?></td>
                        <td class="text-center"><?= $this->Echo->department($item['department_id']) ?> </td>
                        <td class="text-center"><?= $item['title'] ?></td>
                        <td class="text-center"><?= $item['description'] ?></td>
                        <?php
                        if ($item['all_day'] == false) {
                            ?>
                            <td class="text-center"><?= $this->Html->cvtTanggal($item['start']) ?></td>
                            <td class="text-center"><?= $this->Html->cvtJam($item['start']) ?></td>
                            <td class="text-center"><?= $this->Html->cvtTanggal($item['end']) ?></td>
                            <td class="text-center"><?= $this->Html->cvtJam($item['end']) ?></td>
                            <?php
                        } else {
                            ?>
                            <td class="text-center"><?= $this->Html->cvtTanggal($item['start']) ?></td>
                            <td class="text-center"><?= __("00:00") ?></td>
                            <td class="text-center"><?= $this->Html->cvtTanggal($item['end']) ?></td>
                            <td class="text-center"><?= __("23:59") ?></td>
                            <?php
                        }
                        ?>
                    </tr>
                    <?php
                    $i++;
                }
            }
        }
        ?>
    </tbody>
</table>