<div style="text-align: center">
    <div style="font-size:11px;font-weight: bold; font-family:Tahoma, Geneva, sans-serif;">
        Data Potongan Hutang Sembako
    </div>
</div>
<br>
<table width="100%" class="table-data">
    <thead>
        <tr>
            <th width="10">No</th>
            <th width="200"><?= __("Jenis Karyawan") ?></th>
            <th><?= __("Staff Pembuat") ?></th>
            <th width="200"><?= __("Waktu Pembuatan") ?></th>
            <th width="200"><?= __("Periode") ?></th>
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
                <td class = "text-center" colspan ="5">Tidak Ada Data</td>
            </tr>
            <?php
        } else {
            foreach ($data['rows'] as $item) {
                ?>
                <tr>
                    <td class="text-center"><?= $i ?></td>
                    <td class="text-left"><?= $item['EmployeeType']["name"] ?></td>
                    <td class="text-left"><?= $item['Creator']["Account"]["Biodata"]["full_name"] ?></td>
                    <td class="text-left"><?= $this->Html->cvtWaktu($item['CooperativeItemLoanPayment']["created"], false) ?></td>
                    <td class="text-left"><?= $this->Echo->laporanPeriodeBulan($item['CooperativeItemLoanPayment']['start_period'], $item['CooperativeItemLoanPayment']['end_period']) ?></td>
                </tr>
                <?php
                $i++;
            }
        }
        ?>
    </tbody>
</table>