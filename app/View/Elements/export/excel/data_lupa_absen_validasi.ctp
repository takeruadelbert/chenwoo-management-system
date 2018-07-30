<div style="text-align: center">
    <div style="font-size:11px;font-weight: bold; font-family:Tahoma, Geneva, sans-serif;">
        Data Lupa Absen Validasi
    </div>
    <div style="font-size:10px;font-weight: 400; font-style: italic; font-family:Tahoma, Geneva, sans-serif;">Periode : <?= $this->Echo->laporanPeriodeBulan(@$periodeLaporanStartDate, @$periodeLaporanEndDate) ?></div>
</div>
<br>
<table width="100%" class="table-data">
    <thead>
        <tr>
            <th width="50">No</th>
            <th><?= __("Nama Pegawai") ?></th>
            <th><?= __("Jabatan") ?></th>
            <th><?= __("Department") ?></th>
            <th><?= __("Tanggal Lupa Absen") ?></th>
            <th><?= __("Atasan Langsung") ?></th>
            <th><?= __("Keterangan") ?></th>
            <th><?= __("Status") ?></th>
            <th><?= __("Status Verifikasi Atasan") ?></th>
            <th><?= __("Status Validasi HR") ?></th>
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
                    <td><?= $item['Employee']['Account']['Biodata']['full_name'] ?></td>
                    <td class="text-center"><?= $item['Employee']['Office']['name'] ?></td>
                    <td class="text-center"><?= $item['Employee']['Department']['name'] ?></td>
                    <td class="text-center"><?= $this->Html->cvtHariTanggal($item['MissAttendance']['miss_date']) ?></td>
                    <td class="text-center"><?= $item['Supervisor']['Account']['Biodata']['full_name'] ?></td>
                    <td class="text-center"><?= $item['MissAttendance']['note'] ?></td>
                    <td class="text-center">
                        <?php
                        echo $item['MissAttendanceStatus']['name'];
                        ?>
                    </td>
                    <td class="text-center">
                        <?php
                        echo $item['VerifyStatus']['name'];
                        ?>
                    </td>
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