<h2 style="text-align: center">
    Data Histori Transaksi Angsuran
</h2>
<table width="100%" class="table-data">
    <thead>
        <tr>
            <th width="50">No</th>
            <th><?= __("Nomor Kwitansi") ?></th>
            <th><?= __("Nama Pegawai") ?></th>                          
            <th colspan = "2"><?= __("Total Pinjaman") ?></th>
            <th colspan = "2"><?= __("Sisa Pinjaman") ?></th>
            <th><?= __("Tanggal Bayar") ?></th>
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
                <tr id="row-<?= $i ?>" class="removeRow<?php echo $item[Inflector::classify($this->params['controller'])]['id']; ?>">
                    <td class="text-center"><?= $i ?></td>
                    <td class="text-center"><?= $item['EmployeeDataLoanDetail']['coop_receipt_number'] ?></td>
                    <td class="text-center"><?= $item['EmployeeDataLoan']['Employee']['Account']['Biodata']['full_name'] ?></td>
                    <td class="text-center" style = "border-right-style:none !important" width = "50">Rp. </td>
                    <td class="text-right" style = "border-left-style:none !important" width = "150"><?= $this->Html->Rp($item['EmployeeDataLoan']['total_amount_loan']) ?></td>
                    <td class="text-center" style = "border-right-style:none !important" width = "50">Rp. </td>
                    <td class="text-right" style = "border-left-style:none !important" width = "150"><?= $this->Html->Rp($item['EmployeeDataLoanDetail']['remaining_loan']) ?></td>
                    <td class="text-center"><?= $this->Html->cvtTanggal($item['EmployeeDataLoanDetail']['paid_date']) ?></td>
                    <td class="text-center"><?= $this->Echo->empty_strip($item['EmployeeDataLoanDetail']['note']) ?></td>
                </tr>
                <?php
                $i++;
            }
        }
        ?>
    </tbody>
</table>