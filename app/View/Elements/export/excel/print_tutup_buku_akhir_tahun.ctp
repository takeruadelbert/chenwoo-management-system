<div style="text-align: center">
    <div style="font-size:11px;font-weight: bold; font-family:Tahoma, Geneva, sans-serif;">
        Tutup Buku Akhir Tahun
    </div>
</div>
<br>
<table width="100%" class="table-data">
    <thead>
        <tr>
            <th width="50"><input type="checkbox" class="styled checkall"/></th>
            <th width="50">No</th>
            <th><?= __("Tanggal Tutup Buku") ?></th>
            <th><?= __("Nama Pegawai") ?></th>
            <th><?= __("Jabatan") ?></th>
            <th><?= __("Kode COA") ?></th>
            <th><?= __("COA") ?></th>                            
            <th colspan="2"><?= __("Saldo Sebelumnya") ?></th>
            <th colspan="2"><?= __("Saldo Sekarang") ?></th>
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
                <td class = "text-center" colspan = 11>Tidak Ada Data</td>
            </tr>
            <?php
        } else {
            foreach ($data['rows'] as $item) {
                ?>
                <tr id="row-<?= $i ?>" class="removeRow<?php echo $item[Inflector::classify($this->params['controller'])]['id']; ?>">
                    <td class="text-center"><input type="checkbox" name="data[<?php echo Inflector::classify($this->params['controller']) ?>][checkbox][]" value="<?php echo $item[Inflector::classify($this->params['controller'])]['id']; ?>"  id="checkBoxRow" class="styled checkboxDeleteRow" /></td>
                    <td class="text-center"><?= $i ?></td>
                    <td class="text-center"><?= $this->Html->cvtWaktu($item['ClosingBook']['closing_datetime']) ?></td>
                    <td class="text-center"><?= $item['Employee']['Account']['Biodata']['full_name'] ?></td>
                    <td class="text-center"><?= !empty($item['Employee']['Office']['id']) ? $item['Employee']['Office']['name'] : "-" ?></td>
                    <td class="text-center"><?= emptyToStrip($item['GeneralEntryType']['code']) ?></td>
                    <td class="text-center"><?= $item['GeneralEntryType']['name'] ?></td>                                    
                    <td class="text-center" style = "border-right-style:none !important" width = "50">Rp. </td>
                    <td class="text-right" style = "border-left-style:none !important" width = "150"><?= ic_rupiah($item['ClosingBook']['previous_balance']) ?></td>
                    <td class="text-center" style = "border-right-style:none !important" width = "50">Rp. </td>
                    <td class="text-right" style = "border-left-style:none !important" width = "150"><?= ic_rupiah($item['ClosingBook']['current_balance']) ?></td>
                </tr>
                <?php
                $i++;
            }
        }
        ?>
    </tbody>
</table>