<div style="text-align: center">
    <div style="font-size:11px;font-weight: bold; font-family:Tahoma, Geneva, sans-serif;">
        Data Pengembalian Material Pembantu
    </div>
    <div style="font-size:11px;font-style: italic; font-family:Tahoma, Geneva, sans-serif;">Periode : <?= $this->Echo->laporanPeriodeBulan(@$periodeLaporanStartDate, @$periodeLaporanEndDate) ?></div>
</div>
<br/>
<table width="100%" class="table-data">
    <thead>
        <tr>
            <th width="50">No</th>
            <th><?= __("Nomor PO") ?></th>
            <th><?= __("Nomor Penjualan") ?></th>
            <th><?= __("Tanggal") ?></th>
            <th><?= __("Nama Pegawai") ?></th>
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
                <td class = "text-center" colspan = 7>Tidak Ada Data</td>
            </tr>
            <?php
        } else {
            foreach ($data['rows'] as $item) {
                ?>
                <tr id="row-<?= $i ?>" class="removeRow<?php echo $item[Inflector::classify($this->params['controller'])]['id']; ?>">
                    <td class="text-center"><?= $i ?></td>
                    <td class="text-center"><?php echo $item['Sale']['po_number']; ?></td>
                    <td class="text-center"> <?php echo $item['Sale']['sale_no']; ?></td>
                    <td class="text-center"><?php echo $this->Html->cvtTanggal($item["Sale"]['created'], false); ?></td>
                    <td class="text-center">
                        <?php
                        if ($item['MaterialAdditionalReturn']['material_additional_per_container_id'] == $item['MaterialAdditionalPerContainer']['id']) {
                            echo $item["MaterialAdditionalReturn"]['Employee']['Account']['Biodata']['full_name'];
                        } else {
                            echo "-";
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
                    <td class="text-center"  id = "target-change-status-top<?= $i ?>">
                        <?php
                        if (!empty($item['MaterialAdditionalReturn']['material_additional_per_container_id'])) {
                            echo $item['MaterialAdditionalReturn']['VerifyStatus']['name'];
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