<div style="text-align: center">
    <div style="font-size:11px;font-weight: bold; font-family:Tahoma, Geneva, sans-serif;">
        Data Penjualan Material Pembantu
    </div>
</div>
<br>
<table width="100%" class="table-data">
    <thead>
        <tr>
            <th width="50">No</th>
            <th><?= __("Nomor Penjualan Material Pembantu") ?></th>
            <th><?= __("Nama Pembeli") ?></th>
            <th colspan = "2"><?= __("total") ?></th>
            <th><?= __("Penanggung Jawab") ?></th>
            <th><?= __("Tanggal Penjualan") ?></th>
            <th><?= __("Status") ?></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 1;
        if (empty($data['rows'])) {
            ?>
            <tr>
                <td class = "text-center" colspan = 7>Tidak Ada Data</td>
            </tr>
            <?php
        } else {
            foreach ($data['rows'] as $item) {
                ?>
                <tr>
                    <td class="text-center"><?= $i ?></td>
                    <td class="text-left"><?php echo $item["MaterialAdditionalSale"]['no_sale']; ?></td>
                    <td class='text-center'><?= $item['Supplier']['name'] ?></td>
                    <td class="text-left" style = "border-left-style: none !important;" width = "50">Rp. </td>
                    <td class="text-right" style = "border-right-style: none !important;"><?php echo ic_rupiah($item["MaterialAdditionalSale"]['total']); ?></td>
                    <td class="text-center"><?php echo $item['Employee']['Account']['Biodata']['full_name']; ?></td>
                    <td class="text-center"><?php echo!empty($item['MaterialAdditionalSale']['sale_dt']) ? $this->Html->cvtTanggal($item['MaterialAdditionalSale']['sale_dt']) : "-"; ?></td>
                    <td class="text-center"><?= $item['ValidateStatus']['name'] ?></td>
                </tr>
                <?php
                $i++;
            }
        }
        ?>
    </tbody>
</table>