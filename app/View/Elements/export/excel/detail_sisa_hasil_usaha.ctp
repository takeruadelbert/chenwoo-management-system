<div style="text-align: center">
    <div style="font-size:11px;font-weight: bold; font-family:Tahoma, Geneva, sans-serif;">
        Detail SHU Koperasi
    </div>
</div>
<br>
<table width="100%" class="table-data">
    <tr>
        <th colspan="5"> <?= __("Data Laba") ?></th>
    </tr>
    <tr>
        <th class="text-left" width="200"><?= __("Tahun SHU") ?></th>
        <th class="text-right" width="150"><?= $cooperativeRemainingOperation['CooperativeRemainingOperation']['year'] ?></th>
        <th class="text-left" width="200"><?= __("Laba") ?></th>
        <th class = "text-center" style = "border-right-style:none !important" width = "50">Rp. </th>
        <th class = "text-right" style = "border-left-style:none !important" width = "150"><?= ic_rupiah($cooperativeRemainingOperation['CooperativeRemainingOperation']['profit']) ?></th>
    </tr>
    <tr>
        <th class="text-left"><?= __("Total Pegawai") ?></th>
        <th class="text-right"><?= $cooperativeRemainingOperation['CooperativeRemainingOperation']['total_employee'] ?></th>
    </tr>
</table>
<br/>
<table width="100%" class="table-data">
    <thead>
        <tr>
            <th colspan="10"> <?= _("Detail Pembagian SHU") ?></th>
        </tr>
        <tr>
            <th width="50" rowspan="2">No</th>
            <th rowspan="2"><?= __("Nama Pegawai") ?></th>
            <th rowspan="2" colspan="2"><?= __("Mulai Masuk Anggota") ?></th>
            <th colspan="4"><?= __("SHU yang diberikan") ?></th>
            <th rowspan="2" width="250"><?= __("Tanggal Pembayaran") ?></th>
            <th rowspan="2" width="250"><?= __("Status Pengambilan") ?></th>
        </tr>
        <tr>
            <th colspan="2"><?= __("Jumlah") ?></th>
            <th colspan="2"><?= __("Dibulatkan") ?></th>
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
                <td class = "text-center" colspan = "10">Tidak Ada Data</td>
            </tr>
            <?php
        } else {
            foreach ($data['rows'] as $item) {
                ?>
                <tr>
                    <td class="text-center"><?= $i ?></td>
                    <td class="text-left"><?php echo $item['Employee']['Account']['Biodata']["full_name"]; ?></span></td>
                    <td class="text-right" style = "border-left-style:none !important" width = "150"><?= $item['CooperativeRemainingOperationDetail']['duration'] ?></td>
                    <td class="text-center" style = "border-right-style:none !important" width = "50">Bln </td>
                    <td class="text-center" style = "border-right-style:none !important" width = "50">Rp. </td>
                    <td class="text-right" style = "border-left-style:none !important" width = "150"><?= ic_rupiah($item['CooperativeRemainingOperationDetail']['amount']) ?></td>
                    <td class="text-center" style = "border-right-style:none !important" width = "50">Rp. </td>
                    <td class="text-right" style = "border-left-style:none !important" width = "150"><?= ic_rupiah($item['CooperativeRemainingOperationDetail']['abs_amount']) ?></td>
                    <td class="text-center">
                        <?php
                        if (!empty($item['CooperativeRemainingOperationDetail']['payment_date'])) {
                            echo $this->Html->cvtTanggal($item['CooperativeRemainingOperationDetail']['payment_date']);
                        } else {
                            echo "-";
                        }
                        ?>
                    </td>
                    <td class="text-center"  id = "target-change-status<?= $i ?>">
                        <?php
                        if ($item['CooperativeRemainingOperationDetail']['verify_status_id'] == 2) {
                            echo "Ditolak";
                        } else if ($item['CooperativeRemainingOperationDetail']['verify_status_id'] == 3) {
                            echo "Disetujui";
                        } else {
                            echo "Menunggu Persetujuan";
                        }
                        ?>
                    </td>
                </tr>
                <?php
                $i++;
            }
        }
        ?>
    </tbody>
</table>>