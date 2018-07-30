<div style="text-align: center">
    <div style="font-size:11px;font-weight: bold; font-family:Tahoma, Geneva, sans-serif;">
        Data Transaksi Pembelian Koperasi
    </div>
    <div style="font-size:10px;font-style: italic; font-family:Tahoma, Geneva, sans-serif;">Periode : <?= $this->Echo->laporanPeriodeBulan(@$periodeLaporanStartDate, @$periodeLaporanEndDate) ?></div>
</div>
<br/>
<table width="100%" class="table-data">
    <thead>
        <tr>
            <th width="50">No</th>
            <th><?= __("Nomor Transaksi") ?></th>
            <th><?= __("Pegawai Pelaksana") ?></th>
            <?php
            if ($stnAdmin->cooperativeBranchPrivilege()) {
                ?>
                <th width = "250"><?= __("Cabang") ?></th>
                <?php
            }
            ?>
            <th><?= __("Tanggal Transaksi") ?></th>
            <th><?= __("Kas Asal") ?></th>
            <th colspan="2"><?= __("Total Transaksi") ?></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $limit = intval(isset($this->params['named']['limit']) ? $this->params['named']['limit'] : 10);
        $page = intval(isset($this->params['named']['page']) ? $this->params['named']['page'] : 1);
        $i = ($limit * $page) - ($limit - 1);
        $total = 0;
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
                    <td class="text-center"><?= $item['CooperativeCashDisbursement']['cash_disbursement_number'] ?></td>
                    <td class="text-left"><?= $item['Creator']['Account']['Biodata']['full_name'] ?></td>
                    <?php
                    if ($stnAdmin->cooperativeBranchPrivilege()) {
                        ?>
                        <td class="text-left"><?php echo emptyToStrip($item["BranchOffice"]['name']); ?></td>
                        <?php
                    }
                    ?>
                    <td class="text-left"><?= $item['CooperativeCashDisbursement']['created_date__ic'] ?></td>
                    <td class="text-left"><?= $item['CooperativeCash']["name"] ?></td>
                    <td class="text-left" style = "border-right-style:none !important" width = "30">Rp. </td>
                    <td class="text-right" style = "border-left-style:none !important" width="60"><?= $item['CooperativeCashDisbursement']['grand_total'] ?></td>
                </tr>
                <?php
                $total += $item['CooperativeCashDisbursement']['grand_total'];
                $i++;
            }
        }
        ?>
    </tbody>
    <tfoot>
        <tr>
            <td class="text-right" colspan="6">
                <b>Grand total</b>
            </td>
            <td class="text-left" style = "border-right-style:none !important" width = "30"><b>Rp. </b></td>
            <td class="text-right" style = "border-left-style:none !important" width = "60"><b><?= $total ?></b></td>
        </tr>
    </tfoot>
</table>