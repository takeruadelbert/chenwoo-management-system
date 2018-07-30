<div style="text-align: center">
    <div style="font-size:11px;font-weight: bold; font-family:Tahoma, Geneva, sans-serif;">
        Data Angsuran Pinjaman
    </div>
    <div style="font-size:10px;font-style: italic; font-family:Tahoma, Geneva, sans-serif;">Periode : <?= $this->Echo->laporanPeriodeBulan(@$periodeLaporanStartDate, @$periodeLaporanEndDate) ?></div>
</div>
<br/>
<table width="100%" class="table-data">
    <thead>
        <tr>
            <th>No</th>
            <th><?= __("Nomor Angsuran") ?></th>
            <th><?= __("Nomor Pinjaman") ?></th>
            <th><?= __("Pegawai Peminjam") ?></th>                          
            <th><?= __("Operator Pelaksana") ?></th>                          
            <th><?= __("Angsuran ke") ?></th>                          
            <th colspan = "2"><?= __("Total Pinjaman") ?></th>
            <th colspan = "2"><?= __("Jumlah Pembayaran") ?></th>
            <th colspan = "2"><?= __("Sisa Pinjaman") ?></th>
            <th><?= __("Tanggal Jatuh Tempo") ?></th>
            <th><?= __("Tanggal Bayar") ?></th>
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
                    <td class="text-right"><?= $i ?></td>
                    <td class="text-center"><?= $item['EmployeeDataLoanDetail']['coop_receipt_number'] ?></td>
                    <td class="text-center"> <?= $item['EmployeeDataLoan']['receipt_loan_number'] ?></td>
                    <td class="text-left"><?= $item['EmployeeDataLoan']['Employee']['Account']['Biodata']['full_name'] ?></td>
                    <td class="text-left"><?= $item['Creator']['Account']['Biodata']['full_name'] ?></td>
                    <td class="text-center"><?= $item['EmployeeDataLoanDetail']['installment_of'] ?></td>
                    <td class="text-center" style = "border-right-style:none !important">Rp. </td>
                    <td class="text-right" style = "border-left-style:none !important"><?= $item['EmployeeDataLoan']['total_amount_loan__ic'] ?></td>                                   
                    <td class="text-center" style = "border-right-style:none !important">Rp. </td>
                    <td class="text-right" style = "border-left-style:none !important"><?= $item['EmployeeDataLoanDetail']['amount__ic'] ?></td>
                    <td class="text-center" style = "border-right-style:none !important">Rp. </td>
                    <td class="text-right" style = "border-left-style:none !important"><?= $item['EmployeeDataLoanDetail']['remaining_loan__ic'] ?></td>
                    <td class="text-center"><?= $item['EmployeeDataLoanDetail']['due_date__ic'] ?></td>
                    <td class="text-center"><?= $item['EmployeeDataLoanDetail']['paid_date__ic'] ?></td>
                </tr>
                <?php
                $i++;
            }
        }
        ?>
    </tbody>
</table>
