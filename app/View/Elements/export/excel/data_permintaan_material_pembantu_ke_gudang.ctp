<div style="text-align: center">
    <div style="font-size:11px;font-weight: bold; font-family:Tahoma, Geneva, sans-serif;">
        Data Permintaan Material Pembantu Ke Gudang
    </div>
    <div style="font-size:11px;font-style: italic; font-family:Tahoma, Geneva, sans-serif;">Periode : <?= $this->Echo->laporanPeriodeBulan(@$periodeLaporanStartDate, @$periodeLaporanEndDate) ?></div>
</div>
<br/>
<table width="100%" class="table-data">
    <thead>
        <tr>
            <th width="50">No</th>
            <th><?= __("Pembeli") ?></th>
            <th><?= __("Nomor PO") ?></th>
            <th><?= __("Nomor Penjualan") ?></th>
            <th><?= __("Tanggal Dibuat") ?></th>
            <?php
            if ($stnAdmin->branchPrivilege()) {
                ?>
                <th><?= __("Cabang") ?></th>
                <?php
            }
            ?>
            <th><?= __("Status Request Barang") ?></th>
            <th><?= __("Status Gudang") ?></th>
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
                    <td class="text-center"><?php echo $item['Buyer']['company_name']; ?></td>
                    <td class="text-center"><?php echo $item['Sale']['po_number']; ?></td>
                    <td class="text-center"><?php echo $item['Sale']['sale_no']; ?></td>
                    <td class="text-center"><?php echo $this->Html->cvtTanggal($item["Sale"]['created'], false); ?></td>
                    <?php
                    if ($stnAdmin->branchPrivilege()) {
                        ?>
                        <td class="text-left"><?php echo $item["BranchOffice"]['name']; ?></td>
                        <?php
                    }
                    ?>
                    <td class="text-center">
                        <?php
                        if (count($item['MaterialAdditionalPerContainer']) == 0) {
                            echo "Harap Input Data Material Pembantu!";
                        } else {
                            echo $item['MaterialAdditionalPerContainer'][0]['VerifyStatus']['name'];
                        }
                        ?>
                    </td>
                    <td class="text-center" id = "target-change-gudang<?= $i ?>">
                        <?php
                        echo emptyToStrip(@$item['MaterialAdditionalPerContainer'][0]['GudangStatus']['name']);
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