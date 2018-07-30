<div style="text-align: center">
    <div style="font-size:11px;font-weight: bold; font-family:Tahoma, Geneva, sans-serif;">
        Data Depresiasi Aset
    </div>
</div>
<br>
<table width="100%" class="table-data">
    <thead>
        <tr>
            <th width="50">No</th>
            <th width="300"><?= __("Nama Aset") ?></th>
            <th colspan="2"><?= __("Harga Aset") ?></th>
            <th colspan="2"><?= __("Harga Aset Sekarang") ?></th>
            <th colspan="2"><?= __("Nominal Penyusutan") ?></th>
            <th width="300"><?= __("Durasi Penyusutan") ?></th>
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
                <td class = "text-center" colspan = 9>Tidak Ada Data</td>
            </tr>
            <?php
        } else {
            foreach ($data['rows'] as $item) {
                ?>
                <tr>
                    <td class="text-center"><?= $i ?></td>
                    <td class="text-center"><?= $item["AssetProperty"]['name'] ?></td>
                    <td class="text-center" style = "border-right-style:none !important" width = "50">Rp. </td>
                    <td class="text-right" style = "border-left-style:none !important" width = "150"><?= $this->Html->RpWithRemoveCent($item['AssetProperty']['nominal']) ?></td>
                    <td class="text-center" style = "border-right-style:none !important" width = "50">Rp. </td>
                    <td class="text-right" style = "border-left-style:none !important" width = "150"><?= $this->Html->RpWithRemoveCent($item['DepreciationAsset']['current_nominal']) ?></td>
                    <td class="text-center" style = "border-right-style:none !important" width = "50">Rp. </td>
                    <td class="text-right" style = "border-left-style:none !important" width = "150"><?= $this->Html->RpWithRemoveCent($item['DepreciationAsset']['depreciation_amount']) ?></td>
                    <td class="text-center"><?= $item['DepreciationAsset']['depreciation_duration'] ?> bulan</td>
                </tr>
                <?php
                $i++;
            }
        }
        ?>
    </tbody>
</table>