<div style="text-align: center">
    <div style="font-size:11px;font-weight: bold; font-family:Tahoma, Geneva, sans-serif;">
        Data Agen Pengiriman
    </div>
</div>
<br/> 
<table width="100%" class="table-data">
    <thead>
        <tr>
            <th width="50">No</th>
            <th><?= __("Nama Agen") ?></th>
            <th><?= __("Telepon") ?></th>
            <th><?= __("Alamat") ?></th>
            <th><?= __("Negara") ?></th>
            <th><?= __("Provinsi") ?></th>
            <th><?= __("Kota") ?></th>
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
                <tr>
                    <td class="text-center"><?= $i ?></td>
                    <td class="text-left"><?php echo $item['ShipmentAgent']['name']; ?></td>
                    <td class="text-left"><?php echo $item["ShipmentAgent"]["phone_number"]; ?></td>
                    <td class="text-left"><?php echo $item["ShipmentAgent"]["address"]; ?></td>
                    <td class="text-left"><?php echo $item["Country"]['name']; ?></td>
                    <td class="text-left"><?php echo $item["State"]['name']; ?></td>
                    <td class="text-left"><?php echo $item["City"]['name']; ?></td>
                </tr>
                <?php
                $i++;
            }
        }
        ?>
    </tbody>
</table>