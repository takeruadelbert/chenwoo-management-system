<div style="text-align: center">
    <div style="font-size:11px;font-weight: bold; font-family:Tahoma, Geneva, sans-serif;">
        DATA PEGAWAI
    </div>
</div>
<br>
<table width="100%" class="table-data">
    <thead>
        <tr>
            <th width="50">No</th>
            <th><?= __("Nama Pegawai") ?></th>
            <th><?= __("NIP") ?></th>
            <th><?= __("Divisi") ?></th>
            <th><?= __("Jabatan") ?></th>
            <th><?= __("Tanggal Mulai Kerja") ?></th>
            <th><?= __("Jenis Kelamin") ?></th>
            <th><?= __("Tipe Pegawai") ?></th>
            <th><?= __("Cabang") ?></th>
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
                <td class = "text-center" colspan ="9">Tidak Ada Data</td>
            </tr>
            <?php
        } else {
            foreach ($data['rows'] as $item) {
                ?>
                <tr id="row-<?= $i ?>" class="removeRow<?php echo $item["Employee"]['id']; ?>">
                    <td class="text-center"><?= $i ?></td>
                    <td><?= $this->Echo->fullName($item['Biodata']) ?></td>
                    <td class="text-center"><?= $this->Echo->empty_strip($item['Employee']['nip']) ?></td>
                    <td><?= $this->Echo->empty_strip($item['Employee']['Department']['name']) ?></td>
                    <td><?= $this->Echo->empty_strip($item['Employee']['Office']['name']) ?></td>
                    <td class="text-center"><?= $this->Echo->empty_strip($this->Html->cvtTanggal($item['Employee']['tmt'])) ?></td>
                    <td class="text-center"><?= emptyToStrip(@$item['Biodata']['Gender']['name']) ?></td>
                    <td class="text-center"><?= emptyToStrip(@$item['Employee']['EmployeeType']['name']) ?></td>
                    <td><?= emptyToStrip(@$item['Employee']['BranchOffice']['name']) ?></td>
                </tr>
                <?php
                $i++;
            }
        }
        ?>
    </tbody>
</table>
