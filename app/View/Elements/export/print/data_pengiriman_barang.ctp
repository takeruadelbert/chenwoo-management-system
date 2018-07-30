<div style="text-align: center">
    <div style="font-size:11px;font-weight: bold; font-family:Tahoma, Geneva, sans-serif;">
        Data Pengiriman Barang
    </div>
    <div style="font-size:11px;font-style: italic; font-family:Tahoma, Geneva, sans-serif;">Periode : <?= $this->Echo->laporanPeriodeBulan(@$periodeLaporanStartDate, @$periodeLaporanEndDate) ?></div>
</div>
<br>
<table width="100%" class="table-data">
    <thead>
        <tr>
            <th width="50">No</th>
            <th><?= __("No. Pengiriman") ?></th>
            <th><?= __("No. Penjualan") ?></th>
            <th><?= __("No. PO") ?></th>
            <th><?= __("Nama Pembeli") ?></th>
            <th><?= __("Asal") ?></th>
            <th><?= __("Tujuan") ?></th>
            <th><?= __("Tanggal Pengiriman") ?></th>
            <th><?= __("Status Pengiriman") ?></th>
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
                <td class = "text-center" colspan = 9>Tidak Ada Data</td>
            </tr>
            <?php
        } else {
            foreach ($data['rows'] as $item) {
                ?>
                <tr>
                    <td class="text-center"><?= $i ?></td>
                    <td class="text-center"><?php echo $item['Shipment']['shipment_number']; ?></td>
                    <td class="text-center"><?php echo $item['Sale']['sale_no']; ?></td>
                    <td class="text-center"><?php echo $item['Sale']['po_number']; ?></td>
                    <td class="text-center"><?php echo $item['Sale']['Buyer']['company_name']; ?></td>
                    <td class="text-center"><?php echo $item['Shipment']['from_dock']; ?></td>
                    <td class="text-center"><?php echo $item['Shipment']['to_dock']; ?></td>
                    <td class="text-center"><?php echo $this->Html->cvtTanggal($item["Shipment"]['shipment_date']); ?></td>
                    <td class="text-center"  id = "target-change-status<?= $i ?>">
                        <?php
                        echo $item['ShipmentStatus']['name'];
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