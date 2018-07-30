<div style="text-align: center">
    <div style="font-size:18px;font-weight: bold">
        Data Produksi Tahap 4
    </div>
    <div>Periode : <?= $this->Echo->laporanPeriodeBulan(@$periodeLaporanStartDate, @$periodeLaporanEndDate) ?></div>
</div>
<br/>
<table width="100%" class="table-data">
    <thead>
        <tr>
            <th width="50">No</th>
            <th><?= __("Pembeli") ?></th>
            <th><?= __("Nomor PO") ?></th>
            <th><?= __("Nomor Penjualan") ?></th>
            <th><?= __("Berat Penjualan") ?></th>
            <th><?= __("Berat Terpenuhi") ?></th>
            <th><?= __("Tanggal") ?></th>
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
                $quantitiy = 0;
                $quantity_production = 0;
                foreach ($item['SaleDetail'] as $detail) {
                    $quantitiy = $detail['quantity'];
                    $quantity_production = $detail['quantity_production'];
                }
                ?>
                <tr>
                    <td class="text-center"><?= $i ?></td>
                    <td class="text-center"><?php echo $item['Buyer']['company_name']; ?></td>
                    <td class="text-center"><?php echo $item['Sale']['po_number']; ?></td>
                    <td class="text-center"><?php echo $item['Sale']['sale_no']; ?></td>
                    <td class="text-center"><?php echo $quantitiy . " Pcs"; ?></td>
                    <td class="text-center"><?php echo $quantity_production . " Pcs"; ?></td>
                    <td class="text-center"><?php echo $this->Html->cvtTanggalWaktu($item["Sale"]['created']); ?></td>
                </tr>
                <?php
                $i++;
            }
        }
        ?>
    </tbody>
</table>