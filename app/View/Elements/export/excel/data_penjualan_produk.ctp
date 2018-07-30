<div style="text-align: center">
    <div style="font-size:11px;font-weight: bold; font-family:Tahoma, Geneva, sans-serif;">
        Data Penjualan Produk
    </div>
    <div style="font-size:11px;font-style: italic; font-family:Tahoma, Geneva, sans-serif;">Periode : <?= $this->Echo->laporanPeriodeBulan(@$periodeLaporanStartDate, @$periodeLaporanEndDate) ?></div>
</div>
<br>
<table width="100%" class="table-data" style="line-height:20px;">
    <thead>
        <tr>
            <th width="50">No</th>
            <th width="250"><?= __("Pembeli") ?></th>
            <th width="125"><?= __("Tipe Pembeli") ?></th>
            <th width="170"><?= __("Nomor PO") ?></th>
            <th width="170"><?= __("Nomor Penjualan") ?></th>
            <th colspan = "2"><?= __("Total Penjualan") ?></th>
            <th width="150"><?= __("Tanggal Penjualan") ?></th>
            <?php
            if ($stnAdmin->branchPrivilege()) {
                ?>
                <th><?= __("Cabang") ?></th>
                <?php
            }
            ?>
            <th width="150"><?= __("Status Verifikasi") ?></th>
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
                    <td class="text-left"><?php echo $item['Buyer']['company_name']; ?></td>
                    <td class="text-left"><?php echo $item['Buyer']["BuyerType"]['name']; ?></td>
                    <td class="text-left"><?php echo $item['Sale']['po_number']; ?></td>
                    <td class="text-center"><?php echo $item['Sale']['sale_no']; ?></td>
                    <?php
                    if ($item['Buyer']['buyer_type_id'] == 1) {
                        ?>
                        <td class="text-center" style = "border-right:none !important" width="30">Rp.</td>
                        <td class="text-right" style = "border-left:none !important"><?php echo ($item['Sale']['grand_total']); ?></td>
                        <?php
                    } else if ($item['Buyer']['buyer_type_id'] == 2) {
                        ?>
                        <td class="text-center" style = "border-right:none !important" width="30">$</td>
                        <td class="text-right" style = "border-left:none !important" width="120"><?php echo ($item['Sale']['grand_total']); ?></td>
                        <?php
                    }
                    ?>
                    <td class="text-center"><?php echo $this->Html->cvtTanggal($item["Sale"]['created']); ?></td>
                    <?php
                    if ($stnAdmin->branchPrivilege()) {
                        ?>
                        <td class="text-left"><?php echo $item["BranchOffice"]['name']; ?></td>
                        <?php
                    }
                    ?>            
                    <td class="text-center"><?php echo $item["VerifyStatus"]['name']; ?></td>
                </tr>
                <?php
                $i++;
            }
        }
        ?>
    </tbody>
</table>