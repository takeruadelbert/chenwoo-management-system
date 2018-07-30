<div style="text-align: center">
    <div style="font-size:11px;font-weight: bold; font-family:Tahoma, Geneva, sans-serif;">
        Data Rekapitulasi Absensi Pegawai
    </div>
    <div style="font-size:10px;font-weight: 400; font-style: italic; font-family:Tahoma, Geneva, sans-serif;">
        <?= $this->Echo->laporanPeriodeBulan($start_date, $end_date) ?>
    </div>
</div>
<br>
<table width="100%" class="table-data smallfont">
    <thead>
        <tr>
            <th rowspan="2" width="50">No</th>
            <th rowspan="2" width="75"><?= __("Periode") ?></th>
            <th rowspan="2" width="250"><?= __("Nama Pegawai") ?></th>
            <th rowspan="2" width="200"><?= __("locale0002") ?></th>
            <th colspan="<?= 3 + count($permitTypeList) ?>">Uraian</th>
        </tr>
        <tr>
            <th width="50">TD</th>
            <th width="50">CP</th>
            <th width="50">MGKIR</th>
            <?php
            foreach ($permitTypeList as $permitType) {
                ?>
                <th width="50"><?= $permitType["PermitType"]["uniq_name"] ?></th>
                <?php
            }
            ?>
        </tr>
    </thead>
    <tbody>
        <?php
        $limit = intval(isset($this->params['named']['limit']) ? $this->params['named']['limit'] : 10);
        $page = intval(isset($this->params['named']['page']) ? $this->params['named']['page'] : 1);
        $i = ($limit * $page) - ($limit - 1);
        foreach ($result as $employee_id => $item) {
            ?>
            <tr>
                <td class="text-center"><?= $i ?></td>
                <td class="text-center"><?= empty($currentMY) ? $currentYear : $this->Html->cvtBulanTahun($currentMY); ?></td>
                <td class="text-left"><?= $employees[$employee_id] ?></td>
                <td class="text-left"><?= $empData[$employee_id]["Department"]["name"] ?></td>
                <td class="text-center"><?= emptyToStrip($item['summary']['jumlah_telat']) ?></td>
                <td class="text-center"><?= emptyToStrip($item['summary']['jumlah_cepat_pulang']) ?></td>
                <td class="text-center"><?= emptyToStrip($item['summary']['jumlah_absen']) ?></td>
                <?php
                foreach ($permitTypeList as $permitType) {
                    ?>
                    <td class="text-center"><?= issetAndNotEmpty(@$item['summary']["permit"]['detail_' . $permitType["PermitCategory"]["name"]][$permitType["PermitType"]["uniq_name"]], "-") ?></td>
                    <?php
                }
                ?>
            </tr>
            <?php
            $i++;
        }
        ?>
    </tbody>
</table>
<ul style="list-style: none;font-size:11px;font-family:Tahoma, Geneva, sans-serif;">
    <li><strong style="color:red">Keterangan : </strong></li>
        <?php
        foreach ($permitTypeList as $permitType) {
            ?>
        <li>- <?= $permitType["PermitType"]["uniq_name"] ?> = <?= $permitType["PermitType"]["name"] ?></li>
        <?php
    }
    ?>
</ul>