<div style="text-align: center">
    <div style="font-size:11px;font-weight: bold; font-family:Tahoma, Geneva, sans-serif;">
        Data Penjualan Produk Validate
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
            <th width="150"><?= __("Waktu") ?></th>
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
                <td class = "text-center" colspan ="9">Tidak Ada Data</td>
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
                        <td class="text-center" style = "border-right:none !important">Rp.</td>
                        <td class="text-right" style = "border-left:none !important"><?php echo $this->Html->Rp($item['Sale']['grand_total']); ?></td>
                        <?php
                    } else if ($item['Buyer']['buyer_type_id'] == 2) {
                        ?>
                        <td class="text-center" style = "border-right:none !important" width="10">$</td>
                        <td class="text-right" style = "border-left:none !important" width="120"><?php echo $item['Sale']['grand_total']; ?></td>
                        <?php
                    }
                    ?>
                    <td class="text-center"><?php echo $this->Html->cvtTanggalWaktu($item["Sale"]['created']); ?></td>
                    <td class="text-center"  id = "target-change-status<?= $i ?>">
                        <?php
                        if ($item['Sale']['verify_status_id'] == 2) {
                            echo "Ditolak";
                        } else if ($item['Sale']['verify_status_id'] == 3) {
                            echo "Disetujui";
                        } else {
                            echo "Menunggu Persetujuan";
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