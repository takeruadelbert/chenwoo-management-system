<div style="text-align: center">
    <div style="font-size:11px;font-weight: bold; font-family:Tahoma, Geneva, sans-serif;">
        Data Treatment Validasi
    </div>
    <div style="font-size:11px;font-style: italic; font-family:Tahoma, Geneva, sans-serif;">Periode : <?= $this->Echo->laporanPeriodeBulan(@$periodeLaporanStartDate, @$periodeLaporanEndDate) ?></div>
</div>
<br/> 
<table width="100%" class="table-data">
    <thead>
        <tr>
            <th width="50">No</th>
            <th><?= __("Nomor Treatment") ?></th>
            <th><?= __("Nomor Styling") ?></th>
            <th><?= __("Nomor Nota Timbang") ?></th>
            <th><?= __("Tanggla Nota Timbang") ?></th>
            <th colspan = 2><?= __("Berat Treatment") ?></th>
            <th><?= __("Ratio Treatment") ?></th>
            <th><?= __("Nama Pegawai") ?></th>
            <th><?= __("Tanggal Dibuat") ?></th>
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
                <td class = "text-center" colspan = 13>Tidak Ada Data</td>
            </tr>
            <?php
        } else {
            foreach ($data['rows'] as $item) {
                ?>
                <tr>
                    <td class="text-center"><?= $i ?></td>
                    <td class="text-center"><?= $item['Treatment']['treatment_number'] ?></td>
                    <td class="text-center"><?= $item['Freeze']['freeze_number'] ?></td>
                    <td class="text-center"><?= $item['MaterialEntry']['material_entry_number'] ?></td>
                    <td class="text-center"><?= $this->Html->cvtTanggal($item['MaterialEntry']['weight_date']) ?></td>
                    <td class="text-right"><?= $item['Treatment']['total'] ?> </td>
                    <td class="text-center">Kg</td>
                    <td class="text-center"><?= $item['Treatment']['ratio'] ?> %</td>
                    <td class="text-center"><?= $item['Employee']['Account']['Biodata']['full_name'] ?></td>
                    <td class="text-center"><?= $this->Html->cvtWaktu($item['Treatment']['created']) ?></td>
                    <?php
                    if ($stnAdmin->branchPrivilege()) {
                        ?>
                        <td class="text-left"><?php echo $item["BranchOffice"]['name']; ?></td>
                        <?php
                    }
                    ?>
                    <td class="text-center"  id = "target-change-status<?= $i ?>">
                        <?php
                        if ($item['Treatment']['verify_status_id'] == 2) {
                            echo "Ditolak";
                        } else if ($item['Treatment']['verify_status_id'] == 3) {
                            echo "Disetujui";
                        } else {
                            echo $this->Html->changeStatusSelect($item['Treatment']['id'], ClassRegistry::init("VerifyStatus")->find("list", array("fields" => array("VerifyStatus.id", "VerifyStatus.name"))), $item['Treatment']['verify_status_id'], Router::url("/admin/treatments/change_status_verify"), "#target-change-status$i");
                        }
                        ?>
                    </td>
                    <td class="text-center"><?= $this->Echo->empty_strip($item['Treatment']['note']); ?></td>
                </tr>
                <?php
                $i++;
            }
        }
        ?>
    </tbody>
</table>