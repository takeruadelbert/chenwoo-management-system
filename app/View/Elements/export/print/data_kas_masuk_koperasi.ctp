<h2 style="text-align: center">
    Data Kas Masuk Koperasi
</h2>
<table width="100%" class="table-data">
    <thead>
        <tr>
            <th width="50">No</th>
            <th><?= __("Nomor Kas Masuk") ?></th>
            <th><?= __("Nama Pegawai") ?></th>
            <th colspan = "2"><?= __("Nominal") ?></th>
            <th><?= __("Tanggal") ?></th>
            <th><?= __("Tipe Kas Koperasi") ?></th>
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
                <td class = "text-center" colspan = 7>Tidak Ada Data</td>
            </tr>
            <?php
        } else {
            foreach ($data['rows'] as $item) {
                ?>
                <tr id="row-<?= $i ?>" class="removeRow<?php echo $item[Inflector::classify($this->params['controller'])]['id']; ?>">
                    <td class="text-center"><?= $i ?></td>
                    <td class="text-center"><?= $item['CooperativeCashIn']['cash_in_number'] ?></td>
                    <td class="text-center"><?= $item['Creator']['Account']['Biodata']['full_name'] ?></td>
                    <td class="text-center" style = "border-right-style:none !important" width = "50">Rp. </td>
                    <td class="text-right" style = "border-left-style:none !important" width = "150"><?= $this->Html->Rp($item['CooperativeCashIn']['amount']) ?></td>
                    <td class="text-center"><?= $this->Html->cvtWaktu($item['CooperativeCashIn']['created_datetime']) ?></td>
                    <td class="text-center"><?= $item['CooperativeCash']['name'] ?></td>
                </tr>
                <?php
                $i++;
            }
        }
        ?>
    </tbody>
</table>