<div style="text-align: center">
    <div style="font-size:11px;font-weight: bold; font-family:Tahoma, Geneva, sans-serif;">
        Laporan Pinjaman Pegawai
    </div>
    <div style="font-size:10px;font-style: italic; font-family:Tahoma, Geneva, sans-serif;">Periode : <?= $this->Echo->laporanPeriodeBulan(@$periodeLaporanStartDate, @$periodeLaporanEndDate) ?></div>
</div>
<br/>
<table width="100%" class="table-data">
    <thead>
        <tr>
            <th>No</th>
            <th><?= __("Tipe Pinjaman") ?></th>
            <th><?= __("Nomor Pinjaman") ?></th>
            <th><?= __("Pegawai Peminjam") ?></th>                            
            <th><?= __("NIP Pegawai Peminjam") ?></th>                            
            <th><?= __("Departement Pegawai Peminjam") ?></th>                            
            <th><?= __("Operator Pelaksana") ?></th>                            
            <th colspan = "2"><?= __("Jumlah Pinjaman") ?></th>
            <th><?= __("Bunga Per Tahun") ?></th>
            <th colspan = "2"><?= __("Jumlah Tanggungan") ?></th>
            <th><?= __("Tanggal Pinjaman") ?></th>
            <th><?= __("Tenor") ?></th>
            <th><?= __("Jumlah Angsuran") ?></th>
            <th colspan = "2"><?= __("Sisa Pinjaman") ?></th>
            <th><?= __("Status") ?></th>
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
                <td class = "text-center" colspan = "18">Tidak Ada Data</td>
            </tr>
            <?php
        } else {
            foreach ($data['rows'] as $item) {
                ?>
                <tr>                                    
                    <td class="text-center"><?= $i ?></td>
                    <td class="text-left"><?= $item['CooperativeLoanType']['name'] ?></td>
                    <td class="text-center"><?= $item['EmployeeDataLoan']['receipt_loan_number'] ?></td>
                    <td class="text-left"><?= $item['Employee']['Account']['Biodata']['full_name'] ?></td>
                    <td class="text-left"><?= $item['Employee']['nip'] ?></td>
                    <td class="text-left"><?= $item['Employee']['Department']['name'] ?></td>
                    <td class="text-left"><?= $item['Creator']['Account']['Biodata']['full_name'] ?></td>
                    <td class="text-center" style = "border-right-style:none !important">Rp. </td>
                    <td class="text-right" style = "border-left-style:none !important"><?= $item['EmployeeDataLoan']['amount_loan__ic'] ?></td>
                    <td class="text-right" ><?= $item['EmployeeDataLoan']['interest_rate'] ?> %</td>
                    <td class="text-center" style = "border-right-style:none !important">Rp. </td>
                    <td class="text-right" style = "border-left-style:none !important"><?= $item['EmployeeDataLoan']['total_amount_loan__ic'] ?></td>
                    <td class="text-center"><?= $this->Html->cvtTanggal($item['EmployeeDataLoan']['date']) ?></td>
                    <td class="text-right"><?= $item['EmployeeDataLoan']['installment_number'] ?> bulan</td>
                    <td class="text-left"><?= $this->Chenwoo->jumlahAngsuran($item) ?></td>
                    <td class="text-center" style = "border-right-style:none !important">Rp. </td>
                    <td class="text-right" style = "border-left-style:none !important"><?= $item['EmployeeDataLoan']['remaining_loan__ic'] ?></td>
                    <td class="text-center"  id = "target-change-status<?= $i ?>">
                        <?php
                        echo $item['VerifyStatus']['name'];
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