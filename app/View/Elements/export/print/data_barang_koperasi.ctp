<div class="text-center">
    <div style="font-size:11px;font-weight: bold; font-family:Tahoma, Geneva, sans-serif;">
        <b>Data Barang Koperasi</b>
    </div>
    <div style="font-size:11px;font-weight: 400; font-style: italic; font-family:Tahoma, Geneva, sans-serif;">Tanggal Cetak : <?= $this->Html->cvtTanggalWaktu(null, true) ?>
    </div> 
</div>
<br/>
<table width="100%" class="table-data">
    <thead>
        <tr>
            <th width="50">No</th>
            <th><?= __("Kode Barang") ?></th>
            <th><?= __("Barcode Barang") ?></th> 
            <th width="450"><?= __("Nama Barang") ?></th>                  
            <th><?= __("Kategori Barang") ?></th>
            <th colspan = "2"><?= __("Harga Rata-Rata Modal") ?></th>
            <th colspan = "2"><?= __("Harga Jual") ?></th>
            <th colspan = "2"><?= __("Stok") ?></th>
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
                <td class = "text-center" colspan = "12">Tidak Ada Data</td>
            </tr>
            <?php
        } else {
            foreach ($data['rows'] as $item) {
                ?>
                <tr>
                    <td class="text-center"><?= $i ?></td>
                    <td class="text-center"><?= $item['CooperativeGoodList']['code'] ?></td>
                    <td class="text-center"><?= $item['CooperativeGoodList']['barcode'] ?></td>
                    <td class="text-left"><?= $item['CooperativeGoodList']['name'] ?></td>
                    <td class="text-center"><?= $item['GoodType']['name'] ?></td>
                    <td class="text-center" style = "border-right-style:none !important" width = "50">Rp. </td>                                    
                    <td class="text-right" style = "border-left-style:none !important" width = "150"><?= $this->Html->Rp($item['CooperativeGoodList']['average_capital_price']) ?></td>
                    <td class="text-center" style = "border-right-style:none !important" width = "50">Rp. </td>
                    <td class="text-right" style = "border-left-style:none !important" width = "150"><?= $this->Html->Rp($item['CooperativeGoodList']['sale_price']) ?></td>
                    <td class="text-right" style = "border-right-style:none !important"><?= $item['CooperativeGoodList']['stock_number'] ?></td>
                    <td class="text-right" style = "border-left-style:none !important"><?= $item['CooperativeGoodListUnit']['name'] ?></td>
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