<div style="text-align: center">
    <div style="font-size:11px;font-weight: bold; font-family:Tahoma, Geneva, sans-serif;">
        Data Izin Pegawai
    </div>
    <div style="font-size:10px;font-weight: 400; font-style: italic; font-family:Tahoma, Geneva, sans-serif;">Periode : <?= $this->Echo->laporanPeriodeBulan(@$periodeLaporanStartDate, @$periodeLaporanEndDate) ?></div>
</div>
<br>
<table width="100%" class="table-data">
    <thead>
        <tr>
            <th width="50">No</th>
            <th><?= __("Nama Pegawai") ?></th>
            <th><?= __("NIP") ?></th>
            <th><?= __("Jabatan") ?></th>
            <th><?= __("Department") ?></th>
            <th><?= __("Jenis Ijin") ?></th>
            <th><?= __("Tanggal Awal") ?></th>
            <th><?= __("Tanggal Akhir") ?></th>
            <th><?= __("Status") ?></th>
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
                <td class = "text-center" colspan = 9>Tidak Ada Data</td>
            </tr>
            <?php
        } else {
            foreach ($data['rows'] as $item) {
                ?>
                <tr>
                    <td class="text-center"><?= $i ?></td>
                    <td><?= $item['Employee']['Account']['Biodata']['full_name'] ?></td>
                    <td class="text-center"><?= $item['Employee']['nip'] ?></td>
                    <td class="text-left"><?= $item['Employee']['Office']['name'] ?></td>
                    <td class="text-center"><?= $item['Employee']['Department']['name'] ?></td>
                    <td class="text-center"><?= $item['PermitType']['name'] ?></td>
                    <td class="text-center"><?= $this->Html->cvtHariTanggal($item['Permit']['start_date']) ?></td>
                    <td class="text-center"><?= $this->Html->cvtHariTanggal($item['Permit']['end_date']) ?></td>
                    <td id="target-change-status<?= $i ?>">
                        <?php
                        echo $item['PermitStatus']['name'];
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