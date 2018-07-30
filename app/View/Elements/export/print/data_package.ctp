<div style="text-align: center">
    <div style="font-size:11px;font-weight: bold; font-family:Tahoma, Geneva, sans-serif;">
        Data Packaging
    </div>
    <div style="font-size:10px;font-style: italic; font-family:Tahoma, Geneva, sans-serif;">Periode : <?= $this->Echo->laporanPeriodeBulan(@$startDate, @$endDate) ?></div>
</div>
<br>
<table width="100%" class="table-data">
    <thead>
        <tr>
            <th width="50">No</th>
            <th width="125"><?= __("Barcode") ?></th>
            <th><?= __("Nama Produk") ?></th>
            <th width="150"><?= __("Batch Number") ?></th>
            <th width="100"><?= __("Nomor Penjualan") ?></th>
            <th width="100"><?= __("Nomor PO") ?></th>
            <th width="125"><?= __("Tangal Input") ?></th>
            <th width="125"><?= __("Netto") ?></th>
            <th width="125"><?= __("Brutto") ?></th>
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
                <td class = "text-center" colspan = "10">Tidak Ada Data</td>
            </tr>
            <?php
        } else {
            foreach ($data['rows'] as $item) {
                ?>
                <tr>
                    <td class="text-center"><?= $i ?></td>
                    <td class="text-center"><?php echo $item["PackageDetail"]['package_no']; ?></td>
                    <td class="text-left"><?php echo $item['Product']['Parent']['name'] . " " . $item['Product']['name']; ?></td>
                    <td class="text-left"><?= $item["TreatmentDetail"]["Treatment"]["Freeze"]["Conversion"]['MaterialEntryGradeDetail'][0]['batch_number'] . " | " . date("d/m/Y", strtotime($item["TreatmentDetail"]['Treatment']['end_date'])) ?></td>
                    <td class="text-left"><?= $item["Sale"]['sale_no'] ?></td>
                    <td class="text-left"><?= $item["Sale"]['po_number'] ?></td>
                    <td class="text-right"><?= $this->Html->cvtTanggal($item['PackageDetail']["modified"], false); ?></td>
                    <td class="text-right"><?php echo $item['PackageDetail']['nett_weight'] . " " . $item['Product']["ProductUnit"]["name"]; ?></td>
                    <td class="text-right"><?php echo $item['PackageDetail']['brut_weight'] . " " . $item['Product']["ProductUnit"]["name"]; ?></td>
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
            }
        }
        ?>
    </tbody>
</table>