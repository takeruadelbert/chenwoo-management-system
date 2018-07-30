<div style="text-align: center">
    <div style="font-size:11px;font-weight: bold; font-family:Tahoma, Geneva, sans-serif;">
        Data Iuran Koperasi
    </div>
</div>
<br>
<table width="100%" class="table-data smallfont">
    <thead>
        <tr>
            <th width="50">No</th>
            <th><?= __("Nama Pegawai") ?></th>
            <th><?= __("Periode Iuran") ?></th>
            <th><?= __("Jumlah Iuran") ?></th>
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
                <td class = "text-center" colspan = "4">Tidak Ada Data</td>
            </tr>
            <?php
        } else {
            foreach ($data['rows'] as $item) {
                ?>
                <tr id="row-<?= $i ?>" class="removeRow<?php echo $item[Inflector::classify($this->params['controller'])]['id']; ?>">
                    <td class="text-center"><?= $i ?></td>
                    <td><?= $item['Employee']["Account"]["Biodata"]['full_name'] ?></td>
                    <td><?= $this->Echo->laporanPeriodeBulan($item["CooperativeContribution"]["start_dt"], $item["CooperativeContribution"]["end_dt"]) ?></td>
                    <td class="text-right"><?= ic_rupiah($item["CooperativeContribution"]["amount"]) ?></td>
                </tr>
                <?php
                $i++;
            }
        }
        ?>
    </tbody>
</table>