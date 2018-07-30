<div style="text-align: center">
    <div style="font-size:11px;font-weight: bold; font-family:Tahoma, Geneva, sans-serif;">
        Data Styling
    </div>
    <div style="font-size:10px;font-style: italic; font-family:Tahoma, Geneva, sans-serif;">Periode : <?= $this->Echo->laporanPeriodeBulan(@$periodeLaporanStartDate, @$periodeLaporanEndDate) ?></div>
</div>
<br/>
<table width="100%" class="table-data">
    <thead>
        <tr>
            <th width="50">No</th>
            <th><?= __("Nomor Styling") ?></th>
            <th><?= __("Nomor Konversi / Nota Timbang") ?></th>
            <th><?= __("Tanggal Nota Timbang") ?></th>
            <th colspan = 2><?= __("Berat Styling") ?></th>
            <th><?= __("Ratio Styling") ?></th>
            <th><?= __("Tanggal Dibuat") ?></th>
            <th><?= __("Tipe Material") ?></th>
            <th><?= __("Diinput Oleh") ?></th>
            <?php
            if ($stnAdmin->branchPrivilege()) {
                ?>
                <th><?= __("Cabang") ?></th>
                <?php
            }
            ?>
            <th><?= __("Status Verifikasi") ?></th>
            <th><?= __("Keterangan") ?></th>
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
                <td class = "text-center" colspan = "17">Tidak Ada Data</td>
            </tr>
            <?php
        } else {
            foreach ($data['rows'] as $item) {
                $totalDisbursement = 0;
                ?>
                <tr>
                    <td class="text-center"><?= $i ?></td>
                    <td class="text-center"><?= $item['Freeze']['freeze_number'] ?></td>
                    <?php
                    if (empty($item['Freeze']['conversion_id'])) {
                        ?>
                        <td class="text-center"><?= $item['MaterialEntry']['material_entry_number'] ?></td>
                        <?php
                    } else {
                        ?>
                        <td class="text-center"><?= $item['Conversion']['no_conversion'] ?></td>
                        <?php
                    }
                    ?>
                    <td class="text-center"><?= $this->Html->cvtTanggal($item['MaterialEntry']['weight_date']) ?></td>
                    <td class="text-right"><?= $item['Freeze']['total_weight'] ?> </td>
                    <td class="text-center"> Kg</td>
                    <td class="text-center"><?= $item['Freeze']['ratio'] ?> %</td>
                    <td class="text-center"><?= $this->Html->cvtWaktu($item['Freeze']['created']) ?> </td>
                    <td class="text-center"><?= $item['MaterialEntry']['MaterialCategory']['name'] ?></td>
                    <td class="text-center"><?= $item['Employee']['Account']['Biodata']['full_name']; ?></td>
                    <?php
                    if ($stnAdmin->branchPrivilege()) {
                        ?>
                        <td class="text-left"><?php echo $item["BranchOffice"]['name']; ?></td>
                        <?php
                    }
                    ?>
                    <td class="text-center"  id = "target-change-status<?= $i ?>">
                        <?php
                        if ($item['Freeze']['verify_status_id'] == 2) {
                            echo "Ditolak";
                        } else if ($item['Freeze']['verify_status_id'] == 3) {
                            echo "Disetujui";
                        } else {
                            echo "Menunggu Persetujuan";
                        }
                        ?>
                    </td>
                    <td class="text-center"><?= $this->Echo->empty_strip($item['Freeze']['note']); ?></td>
                </tr>
                <?php
                $i++;
            }
        }
        ?>
    </tbody>
</table>