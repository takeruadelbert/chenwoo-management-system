<div style="text-align: center">
    <div style="font-size:11px;font-weight: bold; font-family:Tahoma, Geneva, sans-serif;">
        Data Tagihan Penjualan
    </div>
    <div style="font-size:11px;font-style: italic; font-family:Tahoma, Geneva, sans-serif;">Periode : <?= $this->Echo->laporanPeriodeBulan(@$periodeLaporanStartDate, @$periodeLaporanEndDate) ?></div>
</div>
<br>
<table width="100%" class="table-data">
    <thead>
        <tr>
            <th class="text-center" width="1%" >No</th>
            <th class="text-center" width="8%" ><?= __("Nomor Kwitansi") ?></th>
            <th class="text-center" width="10%" ><?= __("Nomor Invoice") ?></th>
            <th class="text-center" width="8%"  colspan = "2"><?= __("Total Tagihan") ?></th>
            <th class="text-center" width="8%"  colspan="2"><?= __("Sisa Tagihan") ?></th>
            <th class="text-center nowrap" width="8%"  colspan = "2"><?= __("Jumlah Pembayaran") ?></th>
            <th class="text-center" width="8%" ><?= __("Tipe Pembayaran") ?></th>
            <th class="text-center" width="8%" ><?= __("Tipe Kas") ?></th>
            <th class="text-center" width="8%" ><?= __("Tanggal Pembayaran") ?></th>
            <th><?= __("Nama Pegawai") ?></th>
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
                <td class = "text-center" colspan = 14>Tidak Ada Data</td>
            </tr>
            <?php
        } else {
            foreach ($data['rows'] as $item) {
                ?>
                <tr>
                    <td class="text-center"><?= $i ?></td>
                    <td class="text-left"><?= $this->Echo->empty_strip($item['PaymentSale']['receipt_number']) ?></td>
                    <td class="text-center"><?= $this->Echo->empty_strip($item['Sale']['sale_no']) ?></td>
                    <?php
                    if ($item ['InitialBalance']['currency_id'] == 1) {
                        ?>
                        <td class="text-center" style = "border-right-style:none !important" width = "50">Rp </td>
                        <td class="text-right" style = "border-left-style:none !important" width = "150"><?= ($item['PaymentSale']['total_invoice_amount']); ?></td>
                        <td class="text-center" style = "border-right-style:none !important" width = "50">Rp </td>
                        <td class="text-right" style = "border-left-style:none !important" width = "150"><?= ($item['PaymentSale']['remaining']); ?></td>
                        <td class="text-center" style = "border-right-style:none !important" width = "50">Rp </td>
                        <td class="text-right" style = "border-left-style:none !important" width = "150"><?= ($item['PaymentSale']['amount']); ?></td>
                        <?php
                    } else if ($item ['InitialBalance']['currency_id'] == 2) {
                        ?>
                        <td class="text-center" style = "border-right-style:none !important" width = "50">$ </td>
                        <td class="text-right" style = "border-left-style:none !important" width = "150"><?= ($item['PaymentSale']['total_invoice_amount']); ?></td>
                        <td class="text-center" style = "border-right-style:none !important" width = "50">$ </td>
                        <td class="text-right" style = "border-left-style:none !important" width = "150"><?= ($item['PaymentSale']['remaining']); ?></td>
                        <td class="text-center" style = "border-right-style:none !important" width = "50">$ </td>
                        <td class="text-right" style = "border-left-style:none !important" width = "150"><?= ($item['PaymentSale']['amount']); ?></td>
                        <?php
                    }
                    ?>
                    <td class="text-center"><?= $item['PaymentType']['name'] ?></td>
                    <td class="text-center"><?= $this->Echo->empty_strip($item['InitialBalance']['GeneralEntryType']['name']) ?></td>
                    <td class="text-center"><?= $this->Html->cvtTanggalWaktu(@$item['PaymentSale']['payment_date'], false) ?></td>
                    <td class="text-left"><?php echo!empty($item['Employee']['id']) ? $item['Employee']['Account']['Biodata']['full_name'] : "-"; ?></td>
                    <?php
                    if ($stnAdmin->branchPrivilege()) {
                        ?>
                        <td class="text-left"><?php echo $item["Sale"]["BranchOffice"]['name']; ?></td>
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