<div style="text-align: center">
    <div style="font-size:11px;font-weight: bold; font-family:Tahoma, Geneva, sans-serif;">
        Data Konversi
    </div>
    <div style="font-size:11px;font-style: italic; font-family:Tahoma, Geneva, sans-serif;">
        <?php
        if (!empty($startDate)) {
            ?>
            Tanggal Mulai Konversi : <?= $this->Html->cvtTanggal($startDate) ?>
            <?php
        } else if (!empty($endDate)) {
            ?>
            Tanggal Selesai Konversi : <?= $this->Html->cvtTanggal($endDate) ?>
            <?php
        } else if (!empty($startDate) && !empty($endDate)) {
            ?>
            Tanggal Mulai Konversi : <?= $this->Html->cvtTanggal($startDate) ?>  dan Tanggal Selesai Konversi : <?= $this->Html->cvtTanggal($endDate) ?>
            <?php
        }
        ?>
    </div>
</div>
<br>         
<table width="100%" class="table-data">
    <thead>
        <tr>
            <th width="50">No</th>
            <th><?= __("Nomor Nota Timbang") ?></th>
            <th><?= __("Nomor Konversi") ?></th>
            <th><?= __("Ratio Konversi") ?></th>
            <th><?= __("Tanggal Mulai Konversi") ?></th>
            <th><?= __("Tanggal Selesai Konversi") ?></th>
            <th><?= __("Nama Pegawai") ?></th>
            <th><?= __("Supplier") ?></th>
            <?php
            if ($stnAdmin->branchPrivilege()) {
                ?>
                <th><?= __("Cabang") ?></th>
                <?php
            }
            ?>
            <th><?= __("Status") ?></th>
            <th><?= __("Status Validasi") ?></th>
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
                <td class = "text-center" colspan ="12">Tidak Ada Data</td>
            </tr>
            <?php
        } else {
            foreach ($data['rows'] as $item) {
                ?>
                <tr>
                    <td class="text-center"><?= $i ?></td>
                    <td class="text-center"><?php echo $item['MaterialEntry']['material_entry_number']; ?></td>
                    <td class="text-center"><?= $item['Conversion']['no_conversion'] ?></td>
                    <td class="text-center"><?php echo emptyToStrip($item['Conversion']['ratio'] . " %"); ?></td>
                    <td class="text-center"><?php echo emptyToStrip($this->Html->cvtTanggal($item['Conversion']['start_date'])) ?></td>
                    <td class="text-center"><?php echo emptyToStrip($this->Html->cvtTanggal($item['Conversion']['end_date'])) ?></td>
                    <td class="text-center"><?php echo!empty($item['Employee']['id']) ? $item['Employee']['Account']['Biodata']['full_name'] : "-"; ?></td>
                    <td class="text-center"><?php echo $this->Echo->empty_strip($item['MaterialEntry']['Supplier']['name']); ?></td>
                    <?php
                    if ($stnAdmin->branchPrivilege()) {
                        ?>
                        <td class="text-left"><?php echo $item["BranchOffice"]['name']; ?></td>
                        <?php
                    }
                    ?>
                    <td class="text-center"  id = "target-change-status<?= $i ?>">
                        <?php
                        echo $item['VerifyStatus']['name'];
                        ?>
                    </td>
                    <td class="text-center"><?= $this->Echo->empty_strip($item['Conversion']['note']); ?></td>
                    <td class="text-center"  id = "target-change-statuses<?= $i ?>">
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