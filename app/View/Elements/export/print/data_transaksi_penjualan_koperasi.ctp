<div style="text-align: center">
    <div style="font-size:11px;font-weight: bold; font-family:Tahoma, Geneva, sans-serif;">
        Data Transaksi Penjualan Koperasi
    </div>
    <div style="font-size:10px;font-style: italic; font-family:Tahoma, Geneva, sans-serif;">Periode : <?= $this->Echo->laporanPeriodeBulan(@$periodeLaporanStartDate, @$periodeLaporanEndDate) ?></div>
</div>
<br/>
<table width="100%" class="table-data">
    <thead>
        <tr>
            <th width="50">No</th>
            <th width="175"><?= __("Nomor Transaksi") ?></th>
            <th><?= __("Pegawai Pelaksana") ?></th>
            <?php
            if ($stnAdmin->cooperativeBranchPrivilege()) {
                ?>
                <th width = "250"><?= __("Cabang") ?></th>
                <?php
            }
            ?>
            <th width="175"><?= __("Tanggal Transaksi") ?></th>
            <th width="100"><?= __("Jenis Pembayaran") ?></th>
            <th colspan = "2"><?= __("Total Transaksi") ?></th>
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
                    <td class="text-center">
                        <?= $item['CooperativeCashReceipt']['reference_number'] ?>                                     
                    </td>
                    <td class="text-left"><?= $item['Operator']['Account']['Biodata']['full_name'] ?></td>
                    <?php
                    if ($stnAdmin->cooperativeBranchPrivilege()) {
                        ?>
                        <td class="text-left"><?php echo emptyToStrip($item["BranchOffice"]['name']); ?></td>
                        <?php
                    }
                    ?>
                    <td class="text-left"><?= $this->Html->cvtWaktu($item['CooperativeCashReceipt']['date']) ?></td>
                    <td class="text-center"><?= $item['CooperativePaymentType']['name'] ?></td>
                    <td class="text-center" style = "border-right-style:none !important" width = "30">Rp. </td>
                    <td class="text-right" style = "border-left-style:none !important" width = "150"><?= $item['CooperativeCashReceipt']['grand_total__ic'] ?></td>
                </tr>
                <?php
                $i++;
            }
        }
        ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="6" class="text-right">
                <b>Grand total</b>
            </td>
            <td class="text-center" style = "border-right-style:none !important" width = "30">Rp. </td>
            <td class="text-right" style = "border-left-style:none !important" ><b><?= $this->Html->dotNumberSeperator(array_sum(array_column(array_column($data['rows'], "CooperativeCashReceipt"), "grand_total"))) ?></b></td>
        </tr>
    </tfoot>
</table>