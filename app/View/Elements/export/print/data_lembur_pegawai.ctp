<div style="text-align: center">
    <div style="font-size:11px;font-weight: bold; font-family:Tahoma, Geneva, sans-serif;">
        Data Lembur Pegawai
    </div>
    <div style="font-size:10px;font-weight: 400; font-style: italic; font-family:Tahoma, Geneva, sans-serif;">Periode : <?= $this->Echo->laporanPeriodeBulan(@$periodeLaporanStartDate, @$periodeLaporanEndDate) ?></div>
</div>
<br>
<table width="100%" class="table-data">
    <thead>
        <tr>
            <th width="10">No</th>
            <th width="180"><?= __("Nama Pegawai") ?></th>
            <th width="250"><?= __("Departemen") ?></th>
            <th width="120"><?= __("Tanggal Lembur") ?></th>
            <th width="100"><?= __("Waktu Mulai Lembur") ?></th>
            <th width="100"><?= __("Waktu Selesai Lembur") ?></th>
            <th width="200"><?= __("Keterangan") ?></th>
            <th width="100"><?= __("Status Validasi HR") ?></th>
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
                <td class = "text-center" colspan = 8>Tidak Ada Data</td>
            </tr>
            <?php
        } else {
            foreach ($data['rows'] as $item) {
                ?>
                <tr>
                    <td class="text-center"><?= $i ?></td>
                    <td><?= $item['Employee']['Account']['Biodata']['full_name'] ?></td>
                    <?php
                    if (!empty($item['Employee']['department_id'])) {
                        ?>
                        <td class="text-center"><?= $this->Echo->empty_strip($item['Employee']["Department"]['name']) ?></td>
                        <?php
                    } else {
                        ?>
                        <td class="text-center"> - </td>
                        <?php
                    }
                    ?>
                    <td class="text-center"><?= $this->Html->cvtHariTanggal($item['Overtime']['overtime_date']) ?></td>
                    <td class="text-center"><?= $this->Html->cvtJam($item['Overtime']['start_time']) ?></td>
                    <td class="text-center"><?= $this->Html->cvtJam($item['Overtime']['end_time']) ?></td>
                    <td class="text-center"><?= $item['Overtime']['note'] ?></td>
                    <td class="text-center" id = "target-change-statuses<?= $i ?>">
                        <?php
                        echo $item['ValidateStatus']['name'];
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