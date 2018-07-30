<div style="text-align: center">
    <div style="font-size:11px;font-weight: bold; font-family:Tahoma, Geneva, sans-serif;">
        Data Stok Opname Material Pembantu
    </div>
    <div style="font-size:11px;font-style: italic; font-family:Tahoma, Geneva, sans-serif;">Periode : <?= $this->Echo->laporanPeriodeBulan(@$periodeLaporanStartDate, @$periodeLaporanEndDate) ?></div>
</div>
<br>
<table width="100%" class="table-data" style="line-height:20px;">
    <thead>
        <tr>
            <th width="50">No</th>
            <th width="170"><?= __("Nomor Stok Opname") ?></th>
            <th><?= __("Nama Material Pembantu") ?></th>
            <th width="150" colspan = 2><?= __("Stok") ?></th>
            <th width="150" colspan = 2><?= __("Selisih Stok") ?></th>
            <th><?= __("Tanggal Stok Opname") ?></th>
            <th><?= __("Nama Pegawai") ?></th>
            <th><?= __("NIK") ?></th>
            <?php
            if ($stnAdmin->branchPrivilege()) {
                ?>
                <th width = "250"><?= __("Cabang") ?></th>
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
        if (empty($data['rows'])) {
            ?>
            <tr>
                <td class = "text-center" colspan = 11>Tidak Ada Data</td>
            </tr>
            <?php
        } else {
            foreach ($data['rows'] as $item) {
                ?>
                <tr>
                    <td class="text-center"><?= $i ?></td>
                    <td class="text-center"><?= $item['MaterialAdditionalOpnameStock']['opname_stock_number'] ?></td>
                    <td class="text-left"><?= $item['MaterialAdditional']['name'] . " " . $item['MaterialAdditional']['size'] ?></td>
                    <td class="text-right" style ="border-right:none"><?= ($item['MaterialAdditionalOpnameStock']['stock_number']) ?></td>
                    <td class="text-center" width = "30" style ="border-left:none"><?= $item['MaterialAdditional']['MaterialAdditionalUnit']['name'] ?></td>
                    <td class="text-right" style ="border-right:none"><?= ($item['MaterialAdditionalOpnameStock']['stock_difference']) ?></td>
                    <td class="text-center" width = "30" style ="border-left:none"><?= $item['MaterialAdditional']['MaterialAdditionalUnit']['name'] ?></td>
                    <td class="text-center"><?= $this->Html->cvtWaktu($item['MaterialAdditionalOpnameStock']['opname_date']) ?></td>
                    <td class="text-center"><?= $item['Employee']['Account']['Biodata']['full_name'] ?></td>
                    <td class="text-center"><?= $item['Employee']['nip'] ?></td>
                    <?php
                    if ($stnAdmin->branchPrivilege()) {
                        ?>
                        <td class="text-left"><?php echo emptyToStrip($item["BranchOffice"]['name']); ?></td>
                        <?php
                    }
                    ?>
                </tr>
                <?php
                $i++;
            }
        }
        ?>
    </tbody>
</table>