<div style="text-align: center">
    <div style="font-size:11px;font-weight: bold; font-family:Tahoma, Geneva, sans-serif;">
        Data Hutang Sembako
    </div>
</div>
<br>
<table width="100%" class="table-data">
    <thead>
        <tr>
            <th width="10">No</th>
            <th width="300"><?= __("Nama Pegawai") ?></th>
            <th width="200"><?= __("Nik Pegawai") ?></th>
            <th width="200"><?= __("Jumlah Hutang (Rp)") ?></th>
            <th width="200"><?= __("Terbayar (Rp)") ?></th>
            <th width="200"><?= __("Sisa Hutang (Rp)") ?></th>
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
                <tr id="row-<?= $i ?>" class="removeRow<?php echo $item[Inflector::classify($this->params['controller'])]['id']; ?>">
                    <td class="text-center"><?= $i ?></td>
                    <td class="text-left"><?= $item['Employee']["Account"]["Biodata"]["full_name"] ?></td>
                    <td class="text-left"><?= $item['Employee']["nip"] ?></td>
                    <td class="text-right"><?= ic_rupiah($item['CooperativeItemLoan']['total_loan']) ?></td>
                    <td class="text-right"><?= ic_rupiah($item['CooperativeItemLoan']['paid']) ?></td>
                    <td class="text-right"><?= ic_rupiah($item['CooperativeItemLoan']['remaining']) ?></td>
                </tr>
                <?php
                $i++;
            }
        }
        ?>
    </tbody>
</table>