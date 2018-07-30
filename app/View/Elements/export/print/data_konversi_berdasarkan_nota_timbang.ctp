<div style="text-align: center">
    <div style="font-size:11px;font-weight: bold; font-family:Tahoma, Geneva, sans-serif;">
        Data Konversi Berdasarkan Nota Timbang
    </div>
    <div style="font-size:10px;font-style: italic; font-family:Tahoma, Geneva, sans-serif;">Periode : <?= $this->Echo->laporanPeriodeBulan(@$periodeLaporanStartDate, @$periodeLaporanEndDate) ?></div>
</div>
<br/>  
<table width="100%" class="table-data">
    <thead>
        <tr>
            <th width="50">No</th>
            <th><?= __("Nomor Nota Timbang") ?></th>
            <th><?= __("Tanggal Nota Timbang") ?></th>
            <th><?= __("Pembuat Nota Timbang") ?></th>
            <th><?= __("Supplier") ?></th>
            <th><?= __("Total Material") ?></th>
            <th><?= __("Sisa Material") ?></th>
            <?php
            if ($stnAdmin->branchPrivilege()) {
                ?>
                <th><?= __("Cabang") ?></th>
                <?php
            }
            ?>
            <th><?= __("Status") ?></th>
            <th>Jumlah Konversi<br/>Tidak Sesuai Rasio</th>
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
                <td class = "text-center" colspan ="10">Tidak Ada Data</td>
            </tr>
            <?php
        } else {
            foreach ($data['rows'] as $item) {
                ?>
                <tr>
                    <td class="text-center"><?= $i ?></td>
                    <td class="text-center"><?php echo $item['MaterialEntry']['material_entry_number']; ?></td>
                    <td class="text-left"><?php echo!empty($item['MaterialEntry']['id']) ? $this->Html->cvtTanggal($item['MaterialEntry']['weight_date']) : "-" ?></td>
                    <td class="text-left"><?php echo $item['Employee']['Account']["Biodata"]["first_name"]; ?></td>
                    <td class="text-left"><?php echo $this->Echo->empty_strip($item['Supplier']['name']); ?></td>
                    <td class="text-center">
                        <?php
                        $total = 0;
                        $remaining = 0;
                        $btn = "";
                        foreach ($item['MaterialEntryGrade'] as $grade) {
                            $total += $grade['quantity'];
                            foreach ($grade['MaterialEntryGradeDetail'] as $details) {
                                if (!$details['is_used']) {
                                    $remaining++;
                                }
                            }
                        }
                        if ($remaining > 0) {
                            $btn = "warning";
                        } else {
                            $btn = "success";
                        }
                        echo $total . " ikan";
                        ?>
                    </td>
                    <td class="text-center">
                        <span class="label label-<?= $btn ?>"><?= $remaining ?> ikan</span>
                    </td>
                    <?php
                    if ($stnAdmin->branchPrivilege()) {
                        ?>
                        <td class="text-left"><?php echo $item["BranchOffice"]['name']; ?></td>
                        <?php
                    }
                    ?>
                    <td class="text-center"  id = "target-change-status<?= $i ?>">
                        <span class="label label-<?= $item["MaterialEntry"]["conversion_status_id"] == 1 ? "danger" : "success" ?>"><?= $item["ConversionStatus"]["name"] ?></span>
                    </td>
                    <td class="text-center">
                        <?php
                        $countUnderRatio = 0;
                        foreach ($item["Conversion"] as $conversion) {
                            $countUnderRatio+=$conversion["ratio_status_id"] == 4 ? 1 : 0;
                        }
                        if ($countUnderRatio > 0) {
                            ?>
                            <span class="label label-warning"><?= $countUnderRatio ?> Konversi</span>
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