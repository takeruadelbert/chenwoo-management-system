<div style="text-align: center">
    <div style="font-size:11px;font-weight: bold; font-family:Tahoma, Geneva, sans-serif;">
        Data Treatment Berdasarkan Nota Timbang
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
            <th><?= __("Supplier") ?></th>
            <th><?= __("Total Styling") ?></th>
            <th><?= __("Sisa Styling") ?></th>
            <?php
            if ($stnAdmin->branchPrivilege()) {
                ?>
                <th><?= __("Cabang") ?></th>
                <?php
            }
            ?>
            <th><?= __("Status") ?></th>
            <th>Jumlah Treatment<br/>Tidak Sesuai Rasio</th>
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
                <td class = "text-center" colspan = 9>Tidak Ada Data</td>
            </tr>
            <?php
        } else {
//                            debug($data['rows']);
            foreach ($data['rows'] as $item) {
                ?>
                <tr>
                    <td class="text-center"><?= $i ?></td>
                    <td class="text-center"><?php echo $item['MaterialEntry']['material_entry_number']; ?></td>
                    <td class="text-center"><?php echo!empty($item['MaterialEntry']['id']) ? $this->Html->cvtTanggalWaktu($item['MaterialEntry']['created']) : "-" ?></td>
                    <td class="text-center"><?php echo $this->Echo->empty_strip($item['Supplier']['name']); ?></td>
                    <td class="text-center">
                        <?php
                        $total = 0;
                        $remaining = 0;
                        if ($item["MaterialEntry"]['material_category_id'] == 1) { //whole
                            foreach ($item['Conversion'] as $grade) {
                                if (isset($grade['Freeze']['id'])) {
                                    $total +=1;
                                    if (!isset($grade['Freeze']['Treatment']['id'])) {
                                        $remaining+=1;
                                    }
                                }
                            }
                            echo $total . " Styling";
                        } else {//loin
                            foreach ($item['Freeze'] as $freeze) {
                                if (isset($freeze['id'])) {
                                    $total +=1;
                                    if (!isset($freeze['Treatment']['id'])) {
                                        $remaining+=1;
                                    }
                                }
                            }
                            echo $total . " Styling";
                        }
                        ?>
                    </td>
                    <td class="text-center">
                        <?php
                        if (count($item["Freeze"]) == 0) {
                            ?>
                            <span class="label label-info">Belum ada Styling</span>
                            <?php
                        } else {
                            ?>
                            <span class="label label-<?= $remaining > 0 ? "warning" : "success" ?>"><?= $remaining . " Styling"; ?></span>
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
                    <td class="text-center">
                        <span class="label label-<?= $item["MaterialEntry"]["treatment_status_id"] == 1 ? "danger" : "success" ?>"><?= $item["TreatmentStatus"]["name"] ?></span>
                    </td>
                    <td class="text-center">
                        <?php
                        $countUnderRatio = 0;
                        foreach ($item["Treatment"] as $treatment) {
                            $countUnderRatio+=$treatment["ratio_status_id"] == 4 ? 1 : 0;
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