<div style="text-align: center">
    <div style="font-size:11px;font-weight: bold; font-family:Tahoma, Geneva, sans-serif;">
        Laporan Simpanan Pegawai
    </div>
    <div style="font-size:10px;font-style: italic; font-family:Tahoma, Geneva, sans-serif;">Periode : <?= $this->Echo->laporanPeriodeBulan(@$periodeLaporanStartDate, @$periodeLaporanEndDate) ?></div>
</div>
<br/>
<table width="100%" class="table-data">
    <thead>
        <tr>
            <th width="50">No</th>
            <th><?= __("Nomor Transaksi") ?></th>
            <th><?= __("Jenis Transaksi") ?></th>
            <th><?= __("Nama Pegawai") ?></th>
            <th><?= __("No Rekening") ?></th>
            <th><?= __("Operator") ?></th>
            <th colspan = "2"><?= __("Jumlah Transaksi") ?></th>
            <th><?= __("Tgl Transaksi") ?></th>
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
                    <td class="text-left"><?= $item['EmployeeDataDeposit']['id_number'] ?></td>
                    <td class="text-left"><?= $item['DepositIoType']['name'] ?></td>
                    <td class="text-left"><?= $item['Employee']['Account']['Biodata']['full_name'] ?></td>
                    <td class="text-center"><?= $item['EmployeeBalance']['account_number'] ?></td>
                    <td class="text-left"><?= $item['Creator']['Account']['Biodata']['full_name'] ?></td>
                    <td class="text-center" style = "border-right-style:none !important" width = "25">Rp. </td>
                    <td class="text-right" style = "border-left-style:none !important" width = "150"><?= $item['EmployeeDataDeposit']['amount__ic'] ?></td>
                    <td class="text-left"><?= $item['EmployeeDataDeposit']['transaction_date__ic'] ?></td>
                </tr>
                <?php
                $i++;
            }
        }
        ?>
    </tbody>
</table>