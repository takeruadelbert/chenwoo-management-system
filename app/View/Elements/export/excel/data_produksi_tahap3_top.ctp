<div style="text-align: center">
    <div style="font-size:18px;font-weight: bold">
        Data Produksi Tahap 3
    </div>
    <div>Periode : <?= $this->Echo->laporanPeriodeBulan(@$startDate, @$endDate) ?></div>
</div>
<br> 
<table width="100%" class="table-data">
    <thead>
        <tr>
            <th width="50">No</th>
            <th><?= __("Nomor MC") ?></th>
            <th><?= __("Nama Produk") ?></th>
            <th><?= __("Berat") ?></th>
            <th><?= __("Status") ?></th>
            <th><?= __("Tanggal Dibuat") ?></th>
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
                <td class = "text-center" colspan = 6>Tidak Ada Data</td>
            </tr>
            <?php
        } else {
            foreach ($data['rows'] as $item) {
                foreach ($item['PackageDetail'] as $detail) {
                    ?>
                    <tr>
                        <td class="text-center"><?= $i ?></td>
                        <td class="text-center"><span class="isQRcode"><?php echo $detail['package_no']; ?></span></td>
                        <td class="text-center"><span><?php echo $detail['Product']['Parent']['name'] . " " . $detail['Product']['name']; ?></span></td>
                        <td class="text-center"><span><?php echo $detail['nett_weight']; ?> Kg</span></td>
                        <td class="text-center">
                            <span>
                                <?php
                                if ($detail['used'] == 1) {
                                    echo "Dalam Pengiriman";
                                } else {
                                    echo "Dalam Gudang";
                                }
                                ?>
                            </span>
                        </td>
                        <td class="text-center"><?php echo $this->Html->cvtTanggalWaktu($item["Package"]['created']); ?></td>
                    </tr>
                    <?php
                    $i++;
                }
            }
        }
        ?>
    </tbody>
</table>