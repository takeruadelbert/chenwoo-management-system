<div style="text-align: center">
    <div style="font-size:11px;font-weight: bold; font-family:Tahoma, Geneva, sans-serif;">
        Data Treatment (Retouching)
    </div>
    <div style="font-size:11px;font-style: italic; font-family:Tahoma, Geneva, sans-serif;">Periode : <?= $this->Echo->laporanPeriodeBulan(@$periodeLaporanStartDate, @$periodeLaporanEndDate) ?></div>
</div>
<br>
<table width="100%" class="table-data">
    <thead>
        <tr>
            <th width="50">No</th>
            <th><?= __("Pembeli") ?></th>
            <th><?= __("Nomor PO") ?></th>
            <th><?= __("Nomor Penjualan") ?></th>
            <th><?= __("Waktu Penginputan Penjualan ") ?></th>
            <th colspan = 2><?= __("Jumlah Permintaan MC") ?></th>
            <th colspan = 2><?= __("Jumlah Permintaan Berat") ?></th>
            <th><?= __("MC Terpenuhi") ?></th>
            <th><?= __("Berat Terpenuhi") ?></th>
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
                <td class = "text-center" colspan = "13">Tidak Ada Data</td>
            </tr>
            <?php
        } else {
            foreach ($data['rows'] as $item) {
                $requestedMC = array_sum(array_column($item["SaleDetail"], "quantity"));
                $requestedWeight = array_sum(array_column($item["SaleDetail"], "nett_weight"));
                $fulFilledMC = array_sum(array_column($item["SaleDetail"], "quantity_production"));
                $fulFilledWeight = array_sum(array_column($item["SaleDetail"], "fulfill_weight"));
                ?>
                <tr>
                    <td class="text-center"><?= $i ?></td>
                    <td class="text-center"><?php echo $item['Buyer']['company_name']; ?></td>
                    <td class="text-center"><?php echo $item['Sale']['po_number']; ?></td>
                    <td class="text-center"><?php echo $item['Sale']['sale_no']; ?></td>
                    <td class="text-center"><?php echo $this->Html->cvtWaktu($item["Sale"]['created'], false); ?></td>
                    <td class="text-right"><?php echo ic_decimalseperator($requestedMC); ?></td>
                    <td class="text-right" width = "30"> MC</td>
                    <td class="text-right"><?php echo ic_kg($requestedWeight); ?> </td>
                    <td class="text-right" width = "30"> Kg</td>
                    <td class="text-right"><span class="label label-<?= $fulFilledMC < $requestedMC ? "danger" : "success" ?>"><?= ic_decimalseperator($fulFilledMC); ?> </span></td>
                    <td class="text-right" width = "30"> MC</td>
                    <td class="text-right"><span class="label label-<?= $fulFilledWeight < $requestedWeight ? "danger" : "success" ?>"><?= ic_kg($fulFilledWeight); ?></span></td>
                    <td class="text-right" width = "30"> Kg</td>
                    <?php
                    if ($stnAdmin->branchPrivilege()) {
                        ?>
                        <td class="text-left"><?php echo $item["BranchOffice"]['name']; ?></td>
                        <?php
                    }
                    ?>
                    <td class="text-center"><span class="label label-<?= $item["Sale"]["packaging_status_id"] == 1 ? "danger" : "success" ?>"><?= $item["PackagingStatus"]["name"]; ?></span></td>
                </tr>
                <?php
                $i++;
            }
        }
        ?>
    </tbody>
</table>