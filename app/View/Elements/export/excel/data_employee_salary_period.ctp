<div style="text-align: center">
    <div style="font-size:11px;font-weight: bold; font-family:Tahoma, Geneva, sans-serif;">
        Data Gaji Pegawai Harian
    </div>
    <div style="font-size:11px;font-style: italic; font-family:Tahoma, Geneva, sans-serif;">Periode : <?= $this->Echo->laporanPeriodeBulan(@$periodeLaporanStartDate, @$periodeLaporanEndDate) ?></div>
</div>
<br>
<table width="100%" class="table-data">
    <thead>
        <tr>
            <th rowspan="2" width="50">No</th>
            <th rowspan="2"><?= __("Periode") ?></th>
            <th rowspan="2"><?= __("Dibuat") ?></th>
            <th colspan="2"><?= __("Diketahui") ?></th>
            <th colspan="2"><?= __("Diperiksa") ?></th>
            <th colspan="2"><?= __("Disetujui") ?></th>
        </tr>
        <tr>
            <th><?= __("Status") ?></th>
            <th><?= __("Oleh") ?></th>
            <th><?= __("Status") ?></th>
            <th><?= __("Oleh") ?></th>
            <th><?= __("Status") ?></th>
            <th><?= __("Oleh") ?></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 1;
        if (empty($data['rows'])) {
            ?>
            <tr>
                <td class = "text-center" colspan = "9">Tidak Ada Data</td>
            </tr>
            <?php
        } else {
            foreach ($data['rows'] as $item) {
                ?>
                <tr>
                    <td class="text-center"><?= $i ?></td>
                    <td><?= $this->Html->cvtTanggal($item['EmployeeSalaryPeriod']['start_dt'], false) ?> - <?= $this->Html->cvtTanggal($item['EmployeeSalaryPeriod']['end_dt'], false) ?></td>
                    <td><?= e_isset(@$item["CreateBy"]["Account"]["Biodata"]["full_name"]) ?></td>
                    <td><?= $item["KnownStatus"]["name"] ?></td>
                    <td><?= e_isset(@$item["KnownBy"]["Account"]["Biodata"]["full_name"]) ?></td>
                    <td><?= $item["VerifyStatus"]["name"] ?></td>
                    <td><?= e_isset(@$item["VerifyBy"]["Account"]["Biodata"]["full_name"]) ?></td>
                    <td><?= $item["ApproveStatus"]["name"] ?></td>
                    <td><?= e_isset(@$item["ApproveBy"]["Account"]["Biodata"]["full_name"]) ?></td>
                </tr>
                <?php
                $i++;
            }
        }
        ?>
    </tbody>
</table>