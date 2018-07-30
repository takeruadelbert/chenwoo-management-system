<div style="text-align: center">
    <div style="font-size:11px;font-weight: bold; font-family:Tahoma, Geneva, sans-serif;">
        Data Kas Masuk
    </div>
    <div style="font-size:11px;font-style: italic; font-family:Tahoma, Geneva, sans-serif;">Periode : <?= $this->Echo->laporanPeriodeBulan(@$periodeLaporanStartDate, @$periodeLaporanEndDate) ?></div>
</div>
<br>
<table width="100%" class="table-data" style="line-height:15px">
    <thead>
        <tr>
            <th width="20">No</th>
            <th><?= __("Nomor Kas Masuk") ?></th>
            <th><?= __("Nama Pegawai") ?></th>
            <?php
            if ($stnAdmin->branchPrivilege()) {
                ?>
                <th><?= __("Cabang") ?></th>
                <?php
            }
            ?>
            <th colspan = "2"><?= __("Nominal") ?></th>
            <th><?= __("Tanggal") ?></th>
            <th><?= __("Tipe Kas Koperasi") ?></th>
            <th><?= __("Keterangan") ?></th>
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
                    <td class="text-center"><?= $item['CashIn']['cash_in_number'] ?></td>
                    <td class="text-left"><?= $item['Creator']['Account']['Biodata']['full_name'] ?></td>
                    <?php
                    if ($stnAdmin->branchPrivilege()) {
                        ?>
                        <td class="text-left"><?php echo $item["BranchOffice"]['name']; ?></td>
                        <?php
                    }
                    ?>
                    <?php
                    if ($item['CashIn']['currency_id'] == 1) {
                        ?>
                        <td class="text-center" style = "border-right-style:none !important" width = "50">Rp. </td>
                        <td class="text-right" style = "border-left-style:none !important" width = "150"><?= ic_rupiah($item['CashIn']['amount']) ?></td>
                        <?php
                    } else {
                        ?>
                        <td class="text-center" style = "border-right-style:none !important" width = "50">$</td>
                        <td class="text-right" style = "border-left-style:none !important" width = "150"><?= ac_dollar($item['CashIn']['amount']) ?></td>
                        <?php
                    }
                    ?>                                
                    <td class="text-left"><?= $this->Html->cvtWaktu($item['CashIn']['created_datetime']) ?></td>
                    <td class="text-left"><?= $item['InitialBalance']['GeneralEntryType']['name'] ?></td>
                    <td class="text-center"><?= emptyToStrip(@$item['CashIn']['note']) ?></td>
                </tr>
                <?php
                $i++;
            }
        }
        ?>
    </tbody>
</table>