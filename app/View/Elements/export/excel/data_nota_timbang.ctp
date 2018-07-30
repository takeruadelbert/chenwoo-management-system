<div style="text-align: center">
    <div style="font-size:11px;font-weight: bold; font-family:Tahoma, Geneva, sans-serif;">
        Data Nota Timbang
    </div>
    <div style="font-size:11px;font-style: italic; font-family:Tahoma, Geneva, sans-serif;">Periode : <?= $this->Echo->laporanPeriodeBulan(@$periodeLaporanStartDate, @$periodeLaporanEndDate) ?></div>
</div>
<br/>
<table width="100%" class="table-data">
    <thead>
        <tr style="text-transform:uppercase">
            <th width="50">No</th>
            <th><?= __("Nomor Nota Timbang") ?></th>
            <th><?= __("Tipe Material") ?></th>
            <th><?= __("Diinput Oleh") ?></th>
            <th><?= __("Pelaksana") ?></th>
            <th><?= __("Tanggal Timbang") ?></th>
            <th><?= __("Nama Supplier") ?></th>
            <th colspan="2"><?= __("Jumlah Material") ?></th>
            <th colspan="2"><?= __("Berat Total") ?></th>
            <?php
            if ($stnAdmin->branchPrivilege()) {
                ?>
                <th><?= __("Cabang") ?></th>
                <?php
            }
            ?>
            <th><?= __("Status") ?></th>
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
                    <td class="text-left"><?php echo $item["MaterialEntry"]['material_entry_number']; ?></td>
                    <td class="text-center"><?php echo $item['MaterialCategory']['name']; ?></td>
                    <td class="text-left"><?php echo $item['Employee']['Account']['Biodata']['full_name']; ?></td>
                    <td class="text-left><?= isset($item['Operator']['Account']['Biodata']['full_name']) ? "left" : "center" ?>"><?= emptyToStrip(@$item['Operator']['Account']['Biodata']['full_name']); ?></td>
                    <td class="text-left"><?php echo $this->Html->cvtTanggal($item["MaterialEntry"]['weight_date']); ?></td>
                    <td class="text-left"><?php echo $item['Supplier']['name']; ?></td>
                    <?php
                    $count = 0;
                    $total = 0;
                    $satuan = "";
                    if ($item['MaterialEntry']['material_category_id'] == 1) {
                        $satuan = "Ekor";
                    } else {
                        $satuan = "Pcs";
                    }
                    foreach ($item['MaterialEntryGrade'] as $entryGrade) {
                        foreach ($entryGrade['MaterialEntryGradeDetail'] as $entrydetail) {
                            $count++;
                            $total += $entrydetail['weight'];
                        }
                    }
                    ?>
                    <td class="text-right" style = "border-right-style : none !important" width="50"><?php echo $count; ?></td>
                    <td class="text-left" style = "border-left-style : none !important" width="60"><?php echo $satuan; ?></td>
                    <td class="text-right" style = "border-right-style : none !important" width="100"><?php echo ic_kg($total); ?></td>
                    <td class="text-left" style = "border-left-style : none !important" width="30"><?php echo " Kg"; ?></td>
                    <?php
                    if ($stnAdmin->branchPrivilege()) {
                        ?>
                        <td class="text-left"><?php echo $item["BranchOffice"]['name']; ?></td>
                        <?php
                    }
                    ?>  
                    <td class="text-center">
                        <?php
                        echo $item['VerifyStatus']['name'];
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