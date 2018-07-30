<div style="text-align: center">
    <div style="font-size:11px;font-weight: bold; font-family:Tahoma, Geneva, sans-serif;">
        Data Biaya Iuran Anggota
    </div>
</div>
<br>
<table width="100%" class="table-data">
    <thead>
        <tr>
            <th width="50">No</th>
            <th><?= __("Jenis Iuran") ?></th>
            <th><?= __("Jenis Pegawai") ?></th>
            <th><?= __("Jumlah Iuran") ?></th>
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
                <td class = "text-center" colspan = "4">Tidak Ada Data</td>
            </tr>
            <?php
        } else {
            foreach ($data['rows'] as $item) {
                ?>
                <tr>
                    <td class="text-center"><?= $i ?></td>
                    <td><?php echo $item["CooperativeContributionType"]['name']; ?></td>
                    <td><?php echo $item["EmployeeType"]['name']; ?></td>
                    <td class="text-right"><?php echo ic_rupiah($item["CooperativeContributionFee"]['amount']); ?></td>
                </tr>
                <?php
                $i++;
            }
        }
        ?>
    </tbody>
</table>