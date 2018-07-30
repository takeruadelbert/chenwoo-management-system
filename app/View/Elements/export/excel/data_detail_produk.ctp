<div style="text-align: center">
    <div style="font-size:11px;font-weight: bold; font-family:Tahoma, Geneva, sans-serif;">
        Data Detail Produk
    </div>
    <div style="font-size:10px;font-style: italic; font-family:Tahoma, Geneva, sans-serif;">Periode : <?= $this->Echo->laporanPeriodeBulan(@$periodeLaporanStartDate, @$periodeLaporanEndDate) ?></div>
</div>
<br/>
<table width="100%" class="table-data">
    <thead>
        <tr>
            <th width="50">No</th>
            <th><?= __("Nama") ?></th>
            <th><?= __("Nomor Batch") ?></th>
            <th><?= __("Tanggal Produksi") ?></th>
            <th colspan = "2"><?= __("Sisa Berat") ?></th>
            <?php
            if ($stnAdmin->branchPrivilege()) {
                ?>
                <th><?= __("Cabang") ?></th>
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
                <td class = "text-center" colspan = 7>Tidak Ada Data</td>
            </tr>
            <?php
        } else {
            $total = 0;
            foreach ($data['rows'] as $item) {
                ?>
                <tr>
                    <td class="text-center"><?= $i ?></td>
                    <td><?php echo $item['Product']['Parent']['name'] . " " . $item["Product"]['name']; ?></td>
                    <td class="text-center"><?php echo $item["ProductDetail"]['batch_number']; ?></td>
                    <td class="text-center"><?php echo $this->Html->cvtTanggal($item["ProductDetail"]['production_date']); ?></td>
                    <td class="text-right" style = "border-right: none !important"><?php echo $item["ProductDetail"]['remaining_weight']; ?></td>
                    <td width = "50" class = "text-center" style = "border-left: none !important"><?php echo $item["Product"]["ProductUnit"]['name']; ?></td>
                    <?php
                    if ($stnAdmin->branchPrivilege()) {
                        ?>
                        <td class="text-left"><?php echo $item["BranchOffice"]['name']; ?></td>
                        <?php
                    }
                    ?>
                </tr>
                <?php
                $i++;
                $total+=$item["ProductDetail"]['remaining_weight'];
            }
            ?>
                <tr>
                    <td colspan="3"></td>
                    <td>Total</td>
                    <td class="text-right" style = "border-right: none !important"><?php echo $total; ?></td>
                    <td width = "50" class = "text-center" style = "border-left: none !important"><?php echo "Kg"; ?></td>
                    <td></td>
                </tr>
            <?php
        }
        ?>
    </tbody>
</table>