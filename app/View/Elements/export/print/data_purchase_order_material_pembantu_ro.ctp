<div style="text-align: center">
    <div style="font-size:18px;font-weight: bold">
        Data Purchase Order Material Pembantu
    </div>
    <div>Periode : <?= $this->Echo->laporanPeriodeBulan(@$periodeLaporanStartDate, @$periodeLaporanEndDate) ?></div>
</div>
<br/>
<table width="100%" class="table-data">
    <thead>
        <tr>
            <th width="50">No</th>
            <th width = "200"><?= __("Nomor RO") ?></th>
            <th width = "150"><?= __("Tanggal RO") ?></th>
            <th width = "250"><?= __("Nama Pegawai") ?></th>
            <?php
            if ($stnAdmin->branchPrivilege()) {
                ?>
                <th><?= __("Cabang") ?></th>
                <?php
            }
            ?>
            <th width = "150"><?= __("Total Material RO") ?></th>
            <th width = "150"><?= __("Sisa Material RO") ?></th>
            <th width = "150"><?= __("Status") ?></th>
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
                    <td class="text-center">
                        <?= $item["RequestOrderMaterialAdditional"]['ro_number']; ?>                                   
                    </td>
                    <td class="text-center"><?php echo $this->Html->cvtTanggal($item["RequestOrderMaterialAdditional"]['ro_date']); ?></td>
                    <td class="text-left"><?php echo $item['Employee']['Account']['Biodata']['full_name']; ?></td>
                    <?php
                    if ($stnAdmin->branchPrivilege()) {
                        ?>
                        <td class="text-left"><?php echo $item["BranchOffice"]['name']; ?></td>
                        <?php
                    }
                    ?>
                    <td class="text-center">
                        <?php
                        $remaining = 0;
                        $total = 0;
                        $finished = 0;
                        foreach ($item['RequestOrderMaterialAdditionalDetail'] as $material) {
                            if ($material['is_used']) {
                                $finished++;
                            }
                            $total++;
                        }
                        $remaining = $total - $finished;
                        echo $total . " Material";
                        ?>
                    </td>
                    <td class="text-center">
                        <?php
                        if ($item['RequestOrderMaterialAdditional']['po_status'] == 0) {
                            ?>
                            <span class = "label label-warning"><?= $remaining ?> Material</span>
                            <?php
                        } else {
                            ?>
                            <span class = "label label-success"><?= $remaining ?> Material</span>
                            <?php
                        }
                        ?>
                    </td>
                    <td class="text-center">
                        <?php
                        if ($item['RequestOrderMaterialAdditional']['po_status'] == 0) {
                            ?>
                            <span class = "label label-danger">Belum Selesai</span>
                            <?php
                        } else {
                            ?>
                            <span class = "label label-success">Sudah Selesai</span>
                            <?php
                        }
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