<div style="text-align: center">
    <div style="font-size:11px;font-weight: bold; font-family:Tahoma, Geneva, sans-serif;">
        Data Styling Berdasarkan Nota Timbang
    </div>
    <div style="font-size:10px;font-style: italic; font-family:Tahoma, Geneva, sans-serif;">Periode : <?= $this->Echo->laporanPeriodeBulan(@$periodeLaporanStartDate, @$periodeLaporanEndDate) ?></div>
</div>
<br/>
<table width="100%" class="table-data">
    <thead>
        <tr>
            <th width="50">No</th>
            <th><?= __("Nomor Nota Timbang") ?></th>
            <th><?= __("Jenis Material") ?></th>
            <th><?= __("Tanggal Nota Timbang") ?></th>
            <th><?= __("Supplier") ?></th>
            <th><?= __("Total Konversi") ?></th>
            <th><?= __("Sisa Konversi") ?></th>
            <?php
            if ($stnAdmin->branchPrivilege()) {
                ?>
                <th><?= __("Cabang") ?></th>
                <?php
            }
            ?>
            <th><?= __("Status") ?></th>
            <th width="125">Jumlah Styling<br/>Tidak Sesuai Rasio</th>
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
                <td class = "text-center" colspan = "10">Tidak Ada Data</td>
            </tr>
            <?php
        } else {
            foreach ($data['rows'] as $item) {
                ?>
                <tr>
                    <td class="text-center"><?= $i ?></td>
                    <td class="text-center"><?php echo $item['MaterialEntry']['material_entry_number']; ?></td>
                    <td class="text-center"><?= $item['MaterialCategory']['name'] ?></td>
                    <td class="text-center"><?php echo!empty($item['MaterialEntry']['id']) ? $this->Html->cvtTanggal($item['MaterialEntry']['weight_date'], false) : "-" ?></td>
                    <td class="text-left"><?php echo $this->Echo->empty_strip($item['Supplier']['name']); ?></td>
                    <td class="text-center">
                        <?php
                        if ($item["MaterialEntry"]["material_category_id"] == 2) {
                            $total = 0;
                            $remaining = 0;
                            foreach ($item['MaterialEntryGrade'] as $grade) {
                                $total += 1;
                                if (!$grade['is_used']) {
                                    $remaining++;
                                }
                            }
                            echo $total . " Basket";
                        } else {
                            $total = 0;
                            $remaining = 0;
                            foreach ($item['Conversion'] as $grade) {
                                $total += 1;
                                if (!isset($grade['Freeze']['id'])) {
                                    $remaining++;
                                }
                            }
                            echo $total . " Konversi";
                        }
                        ?>
                    </td>
                    <td class="text-center">
                        <?php
                        if ($item["MaterialEntry"]["material_category_id"] == 2) {
                            ?>
                        <span class="label label-<?= $remaining > 0 ? "warning" : "success" ?>"><?= $remaining . " Basket"; ?></span>
                            <?php
                        } else if (count($item["Conversion"]) == 0) {
                            ?>
                            <span class="label label-info">Belum ada konversi</span>
                            <?php
                        } else {
                            ?>
                            <span class="label label-<?= $remaining > 0 ? "warning" : "success" ?>"><?= $remaining . " Konversi"; ?></span>
                            <?php
                        }
                        ?>
                    </td>
                    <?php
                    if ($stnAdmin->branchPrivilege()) {
                        ?>
                        <td class="text-left"><?php echo $item["BranchOffice"]['name']; ?></td>
                        <?php
                    }
                    ?>
                    <td class="text-center"  id = "target-change-status<?= $i ?>">
                        <?php
                        if ($item["MaterialEntry"]["material_category_id"] == 1 && count($item["Conversion"]) == 0) {
                            ?>
                            <span class="label label-info">Belum ada konversi</span>
                            <?php
                        } else {
                            ?>
                            <span class="label label-<?= $item["MaterialEntry"]["freezing_status_id"] == 1 ? "danger" : "success" ?>"><?= $item["FreezingStatus"]["name"] ?></span>
                            <?php
                        }
                        ?>
                    </td>
                    <td class="text-center">
                        <?php
                        $countUnderRatio = 0;
                        foreach ($item["Freeze"] as $freeze) {
                            $countUnderRatio+=$freeze["ratio_status_id"] == 4 ? 1 : 0;
                        }
                        if ($countUnderRatio > 0) {
                            ?>
                            <span class="label label-warning"><?= $countUnderRatio ?> Styling</span>
                            <?php
                        } else {
                            echo "-";
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