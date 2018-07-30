<div style="text-align: center">
    <div style="font-size:11px;font-weight: bold; font-family:Tahoma, Geneva, sans-serif;">
        Data Rincian Transaksi Pembelian Koperasi
    </div>
    <div style="font-size:10px;font-style: italic; font-family:Tahoma, Geneva, sans-serif;">Periode : <?= $this->Echo->laporanPeriodeBulan(@$periodeLaporanStartDate, @$periodeLaporanEndDate) ?></div>
</div>
<br/>
<table width="100%" class="table-data">
    <thead>
        <tr>
            <th width="10">No</th>
            <th width="170"><?= __("Nomor Transaksi") ?></th>
            <th><?= __("Pegawai Pelaksana") ?></th>
            <?php
            if ($stnAdmin->cooperativeBranchPrivilege()) {
                ?>
                <th width = "250"><?= __("Cabang") ?></th>
                <?php
            }
            ?>
            <th width="170"><?= __("Tanggal Pembelian") ?></th>
            <th width="470"><?= __("Nama Barang") ?></th>
            <th width="100" colspan="2"><?= __("Jumlah") ?></th>
            <th colspan="2"><?= __("Harga Satuan") ?></th>
            <th width="50"><?= __("Diskon") ?></th>
            <th colspan="2"><?= __("Total Harga") ?></th>
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
                <td class = "text-center" colspan ="13">Tidak Ada Data</td>
            </tr>
            <?php
        } else {
            foreach ($data['rows'] as $item) {
                ?>
                <tr>
                    <td class="text-center"><?= $i ?></td>
                    <td class="text-center">
                        <?= $item['CooperativeCashDisbursement']['cash_disbursement_number'] ?>
                    </td>
                    <td class="text-left"><?= $item['CooperativeCashDisbursement']['Creator']['Account']['Biodata']['full_name'] ?></td>
                    <?php
                    if ($stnAdmin->cooperativeBranchPrivilege()) {
                        if (!empty($item['CooperativeCashDisbursement']['branch_office_id'])) {
                            ?>
                            <td class="text-left"><?php echo emptyToStrip($item['CooperativeCashDisbursement']["BranchOffice"]['name']); ?></td>
                            <?php
                        } else {
                            ?>
                            <td class="text-left">-</td>
                            <?php
                        }
                    }
                    ?>
                    <td class="text-left"><?= $item['CooperativeCashDisbursement']['created_date__ic'] ?></td>
                    <td class="text-left"><?= $item['CooperativeGoodList']["name"] ?></td>
                    <td class="text-right" style = "border-right-style:none !important" ><?= $item['CooperativeCashDisbursementDetail']["quantity"] ?></td>
                    <td class="text-right" style = "border-left-style:none !important" width = "50"><?= $item['CooperativeGoodList']['CooperativeGoodListUnit']['name'] ?></td>
                    <td class="text-center" style = "border-right-style:none !important" width = "30">Rp. </td>
                    <td class="text-right" style = "border-left-style:none !important" width="150"><?= $item['CooperativeCashDisbursementDetail']['amount__ic'] ?></td>
                    <td class="text-right"><?= $item['CooperativeCashDisbursementDetail']["discount"] ?> %</td>
                    <td class="text-center" style = "border-right-style:none !important" width = "30">Rp. </td>
                    <td class="text-right" style = "border-left-style:none !important" width="150"><?= $item['CooperativeCashDisbursementDetail']['total_amount__ic'] ?></td>
                </tr>
                <?php
                $i++;
            }
        }
        ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="11" class="text-right">
                <b>Grand total</b>
            </td>
            <td class="text-center" style="border-right-style:none !important" width="30"><b>Rp. </b></td>
            <td class="text-right" style ="border-left-style:none !important" width="150"><b><?= $this->Html->dotNumberSeperator(array_sum(array_column(array_column($data['rows'], "CooperativeCashDisbursementDetail"), "total_amount"))) ?></b></td>
        </tr>
    </tfoot>
</table>