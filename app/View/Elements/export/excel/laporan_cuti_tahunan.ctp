<div style="text-align: center">
    <div style="font-size:11px;font-weight: bold; font-family:Tahoma, Geneva, sans-serif;">
        Laporan Sisa Cuti Tahunan
    </div>
    <div style="font-size:10px;font-weight: 400; font-style: italic; font-family:Tahoma, Geneva, sans-serif;">Periode : <?= $year ?> | Per tanggal : <?= $this->Html->cvtTanggal($today, false) ?></div>
</div>
<br>
<table width="100%" class="table-data">
    <thead>
        <tr>
            <th width="50">No</th>
            <th><?= __("Nama Pegawai") ?></th>
            <th><?= __("NIP") ?></th>
            <th><?= __("Department") ?></th>
            <th><?= __("Jabatan") ?></th>
            <th width="50"><?= __("Jatah Tahun Ini") ?></th>
            <th width="50"><?= __("Pengambilan Tahun Ini") ?></th>
            <th width="50"><?= __("Sisa Jatah Cuti Tahunan") ?></th>
        </tr>
    </thead>
    <tbody style="white-space: nowrap">
        <?php
        $i = 1;
        if (!empty($result)) {
            foreach ($result as $employeeId => $cutiCount) {
                ?>
                <tr>
                    <td class="text-center"><?= $i ?></td>
                    <td class="text-left"><?= $employeeList[$employeeId]["full_name"] ?></td>
                    <td class="text-left"><?= $employeeList[$employeeId]["nip"] ?></td>
                    <td class="text-left"><?= $employeeList[$employeeId]["department"] ?></td>
                    <td class="text-left"><?= $employeeList[$employeeId]["office"] ?></td>
                    <td class="text-right"><?= $quota ?></td>
                    <td class="text-right"><?= $cutiCount ?></td>
                    <td class="text-right"><?= $quota - $cutiCount ?></td>
                </tr>
                <?php
                $i++;
            }
        } else {
            ?>
            <tr class="text-center" colspan="8">
                No data.
            </tr>
            <?php
        }
        ?>
    </tbody>
</table>