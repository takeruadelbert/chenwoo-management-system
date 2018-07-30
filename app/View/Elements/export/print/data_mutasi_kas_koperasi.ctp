<div style="text-align: center">
    <div style="font-size:18px;font-weight: bold">
        Data Mutasi Kas Koperasi
    </div>
    <div>Periode : <?= $this->Echo->laporanPeriodeBulan(@$startDate, @$endDate) ?></div>
</div>
<table width="100%" class="table-data">
    <thead>
        <tr>
            <th width="50">No</th>
            <th><?= __("Nomor Mutasi") ?></th>
            <th><?= __("Dari") ?></th>
            <th><?= __("Tujuan") ?></th>
            <th colspan = "2"><?= __("Nominal") ?></th>
            <th><?= __("Tanggal") ?></th>
            <th><?= __("Pegawai Pelaksana") ?></th>
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
                <td class = "text-center" colspan = "8">Tidak Ada Data</td>
            </tr>
            <?php
        } else {
            foreach ($data['rows'] as $item) {
                ?>
                <tr id="row-<?= $i ?>" class="removeRow<?php echo $item[Inflector::classify($this->params['controller'])]['id']; ?>">
                    <td class="text-center"><?= $i ?></td>
                    <td class="text-left"><?= $item['CooperativeCashMutation']['id_number'] ?></td>
                    <td class="text-left"><?= $item['CooperativeCashTransfered']['name'] ?></td>
                    <td class="text-left"><?= $item['CooperativeCashReceived']['name'] ?></td>
                    <td class="text-center" style = "border-right-style:none !important" width = "50">Rp. </td>
                    <td class="text-right" style = "border-left-style:none !important" width = "150"><?= $this->Html->Rp($item['CooperativeCashMutation']['nominal']) ?></td>
                    <td class="text-left"><?= $this->Html->cvtWaktu($item['CooperativeCashMutation']['transfer_date']) ?></td>
                    <td class="text-left"><?= $item['Creator']['Account']['Biodata']['full_name'] ?></td>
                </tr>
                <?php
                $i++;
            }
        }
        ?>
    </tbody>
</table>