<div style="text-align: center">
    <div style="font-size:11px;font-weight: bold; font-family:Tahoma, Geneva, sans-serif;">
        Data Kategori Barang Koperasi
    </div>
</div>
<br>
<table width="100%" class="table-data">
    <thead>
        <tr>
            <th width="50">No</th>
            <th width="150"><?= __("Kategori") ?></th>
            <th><?= __("Nama Barang") ?></th>
            <th><?= __("Keterangan") ?></th>
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
                <td class = "text-center" colspan = 4>Tidak Ada Data</td>
            </tr>
            <?php
        } else {
            foreach ($data['rows'] as $item) {
                ?>
                <tr >
                    <td class="text-center"><?= $i ?></td>
                    <td class="text-center"><?= $this->Echo->empty_strip($item['Parent']['name']) ?></td>
                    <td class="text-left"><?= $item['GoodType']['name'] ?></td>
                    <td class="text-left"><?= $item['GoodType']['note'] ?></td>
                </tr>
                <?php
                $i++;
            }
        }
        ?>
    </tbody>
</table>