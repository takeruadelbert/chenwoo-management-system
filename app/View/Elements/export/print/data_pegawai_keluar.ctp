<div style="text-align: center">
    <div style="font-size:11px;font-weight: bold; font-family:Tahoma, Geneva, sans-serif;">
        Data Pegawai Keluar
    </div>
    <div style="font-size:11px;font-style: italic; font-family:Tahoma, Geneva, sans-serif;">Periode : <?= $this->Echo->laporanPeriodeBulan(@$periodeLaporanStartDate, @$periodeLaporanEndDate) ?></div>
</div>
<br>
<table width="100%" class="table-data">
    <thead>
        <tr>
            <th width="10">No</th>
            <th><?= __("Nama Pegawai") ?></th>
            <th><?= __("NIP") ?></th>
            <th><?= __("Jabatan") ?></th>
            <th><?= __("Department") ?></th>
            <th><?= __("Tanggal Pengunduran Diri") ?></th>
            <th><?= __("Keterangan") ?> </th>
            <th><?= __("Status Verifikasi") ?> </th>
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
                    <td class = "text-left"><?= $item['Employee']['Account']['Biodata']['full_name'] ?></td>
                    <td class = "text-center"><?= $item['Employee']['nip'] ?></td>
                    <td class = "text-left"><?= $item['Employee']['Office']['name'] ?> </td>
                    <td class = "text-left"><?= $item['Employee']['Department']['name'] ?> </td>
                    <td class = "text-center"><?= $this->Html->cvtHariTanggal($item['Resignation']['resignation_date']) ?> </td>
                    <td class = "text-left"><?= $item['ResignationType']['name'] ?></td>
                    <td class="text-center"  id = "target-change-status<?= $i ?>">
                        <?php
                        echo $item['VerifyStatus']['name'];
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