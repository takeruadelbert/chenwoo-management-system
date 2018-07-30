<div style="text-align: center">
    <div style="font-size:11px;font-weight: bold; font-family:Tahoma, Geneva, sans-serif;">
        Data Kenaikan Jabatan Validasi
    </div>
    <div style="font-size:11px;font-style: italic; font-family:Tahoma, Geneva, sans-serif;">Periode : <?= $this->Echo->laporanPeriodeBulan(@$periodeLaporanStartDate, @$periodeLaporanEndDate) ?></div>
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
            <th><?= __("Jenis Kenaikan Jabatan") ?></th>
            <th><?= __("Jabatan Baru") ?></th>
            <th><?= __("No. SK Kenaikan Jabatan") ?></th>
            <th><?= __("Tanggal Kenaikan Jabatan") ?></th>
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
                <td class = "text-center" colspan = 10>Tidak Ada Data</td>
            </tr>
            <?php
        } else {
            foreach ($data['rows'] as $item) {
                ?>
                <tr >
                    <td class="text-center"><?= $i ?></td>
                    <td><?= $item['Employee']['Account']['Biodata']['full_name'] ?></td>
                    <td class="text-center"><?= $item['Employee']['nip'] ?></td>
                    <td class="text-center"><?= $item['Employee']['Office']['name'] ?></td>
                    <td class="text-center"><?= $item['Employee']['Department']['name'] ?></td>
                    <td class="text-center"><?= $item['PromotionType']['name'] ?></td>
                    <td class="text-center"><?= $item['CurrentOffice']['name'] ?></td>
                    <td class="text-center"><?= $item['Promotion']['no_sk_promotion'] ?></td>
                    <td class="text-center"><?= $this->Html->cvtTanggal($item['Promotion']['promotion_date']) ?></td>
                    <td class="text-center" id="target-change-status<?= $i ?>">
                        <?php
                        echo $item['PromotionStatus']['name'];
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