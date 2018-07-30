<div style="font-size:11px;font-weight: bold; font-family:Tahoma, Geneva, sans-serif;" class="text-center">
    Data Pinjaman Pegawai
</div>
<br>
<table width="100%" class="table table-bordered" style="font-size:11px;font-family:Tahoma, Geneva, sans-serif;">
    <tbody>
        <tr>
            <td width="15%"><?= __("Nama Pegawai") ?></td>
            <td width="1%" align="center" valign="middle">:</td>
            <td width="34%"><?= $this->Session->read("credential.admin.Biodata.full_name"); ?></td>
            <td width="15%"><?= __("NIP") ?></td>
            <td width="1%" align="center">:</td>
            <td width="34%"><?= $this->Session->read("credential.admin.Employee.nip"); ?></td>
        </tr>
        <tr>
            <td><?= __("Jabatan") ?></td>
            <td align="center" valign="middle">:</td>
            <td><?= $this->Session->read("credential.admin.Employee.Office.name"); ?></td>
            <td><?= __("Department") ?></td>
            <td align="center">:</td>
            <td>
                <?= $this->Session->read("credential.admin.Employee.Department.name"); ?>
            </td>
        </tr>
    </tbody>
</table>
<br>
<table width="100%" class="table-data">
    <thead>
        <tr height="50px">
            <th width="10px">No</th>
            <th><?= __("Nomor Pinjaman") ?></th>
            <th colspan = "2"><?= __("Jumlah Pinjaman") ?></th>
            <th><?= __("Bunga") ?></th>
            <th colspan = "2"><?= __("Total Hutang") ?></th>
            <th><?= __("Tanggal Pinjaman") ?></th>
            <th><?= __("Tenor") ?></th>
            <th><?= __("Jumlah Angsuran") ?></th>
            <th colspan = "2"><?= __("Sisa Pinjaman") ?></th>
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
                <td class = "text-center" colspan = 12>Tidak Ada Data</td>
            </tr>
            <?php
        } else {
            foreach ($data['rows'] as $item) {
                ?>
                <tr id="row-<?= $i ?>" class="removeRow<?php echo $item[Inflector::classify($this->params['controller'])]['id']; ?>">
                    <td class="text-center"><?= $i ?></td>
                    <td class="text-center"><?= $item['EmployeeDataLoan']['receipt_loan_number'] ?></td>
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
                </tr>
                <?php
                $i++;
            }
        }
        ?>
    </tbody>
</table>