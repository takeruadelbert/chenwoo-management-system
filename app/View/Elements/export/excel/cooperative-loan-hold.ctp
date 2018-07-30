<div style="text-align: center">
    <div style="font-size:11px;font-weight: bold; font-family:Tahoma, Geneva, sans-serif;">
        DATA KERINGANAN PENUNDAAN PEMBAYARAN KASBON
    </div>
</div>
<br/>
<table width="100%" class="table-data small-font">
    <thead>
        <tr>
            <th width="50">No</th>
            <th><?= __("Nama Pegawai") ?></th>
            <th><?= __("NIK Pegawai") ?></th>
            <th><?= __("Nomor Pinjaman") ?></th>
            <th><?= __("Staff Pembuat") ?></th>
            <th><?= __("Periode") ?></th>
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
                <td class = "text-center" colspan ="6">Tidak Ada Data</td>
            </tr>
            <?php
        } else {
            foreach ($data['rows'] as $item) {
                ?>
                <tr>
                    <td class="text-center"><?= $i ?></td>
                    <td class="text-left"><?= $item['EmployeeDataLoan']['Employee']["Account"]["Biodata"]["full_name"] ?></td>
                    <td class="text-left"><?= $item['EmployeeDataLoan']['Employee']["nip"] ?></td>
                    <td class="text-left"><?= $item['EmployeeDataLoan']['receipt_loan_number'] ?></td>
                    <td class="text-left"><?= $item['Creator']["Account"]["Biodata"]["full_name"] ?></td>
                    <td class="text-left"><?= $this->Echo->laporanPeriodeBulan($item['CooperativeLoanHold']['start_period'], $item['CooperativeLoanHold']['end_period']) ?></td>
                </tr>
                <?php
                $i++;
            }
        }
        ?>
    </tbody>
</table>