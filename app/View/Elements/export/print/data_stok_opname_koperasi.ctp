<div style="text-align: center">
    <div style="font-size:11px;font-weight: bold; font-family:Tahoma, Geneva, sans-serif;">
        Data Stok Opname Koperasi
    </div>
</div>
<br>
<table width="100%" class="table-data">
    <thead>
        <tr>
            <th width="50">No</th>
            <th width="170"><?= __("Nomor Stok Opname") ?></th>
            <th><?= __("Nama Barang") ?></th>
            <th width="150" colspan = "2"><?= __("Stok") ?></th>
            <th width="150" colspan = "2"><?= __("Selisih Stok") ?></th>
            <th><?= __("Nama Pegawai") ?></th>
            <th><?= __("NIK") ?></th>
            <?php
            if ($stnAdmin->cooperativeBranchPrivilege()) {
                ?>
                <th width = "250"><?= __("Cabang") ?></th>
                <?php
            }
            ?>
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
                <td class = "text-center" colspan = 10>Tidak Ada Data</td>
            </tr>
            <?php
        } else {
            foreach ($data['rows'] as $item) {
                ?>
                <tr>
                    <td class="text-center"><?= $i ?></td>
                    <td class="text-center"><?= $item['CooperativeOpnameStock']['opname_stock_number'] ?></td>
                    <td class="text-left"><?= $item['CooperativeGoodList']['name'] ?></td>
                    <td class="text-right" style = "border-right-style:none !important"><?= $item['CooperativeOpnameStock']['stock_number'] ?></td>
                    <td class="text-right" style = "border-left-style:none !important" width = "75"><?= $item['CooperativeGoodList']['CooperativeGoodListUnit']['name'] ?></td>
                    <td class="text-right" style = "border-right-style:none !important"><?= $item['CooperativeOpnameStock']['stock_difference'] ?></td>
                    <td class="text-right" style = "border-left-style:none !important" width = "75"><?= $item['CooperativeGoodList']['CooperativeGoodListUnit']['name'] ?></td>
                    <td class="text-center"><?= $item['Employee']['Account']['Biodata']['full_name'] ?></td>
                    <td class="text-center"><?= $item['Employee']['nip'] ?></td>
                    <?php
                    if ($stnAdmin->cooperativeBranchPrivilege()) {
                        ?>
                        <td class="text-left"><?php echo emptyToStrip($item["BranchOffice"]['name']); ?></td>
                        <?php
                    }
                    ?>
                </tr>
                <?php
                $i++;
            }
        }
        ?>
    </tbody>
</table>