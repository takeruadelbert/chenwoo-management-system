<h3 style="text-align: center">
    Data Material
</h3>
<table width="100%" class="table-data">
    <thead>
        <tr>
            <th width="50">No</th>
            <th><?= __("Nama Ikan") ?></th>
            <th><?= __("Kategori") ?></th>
            <th><?= __("Detail") ?></th>
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
                <td class = "text-center" colspan = "4">Tidak Ada Data</td>
            </tr>
            <?php
        } else {
            foreach ($data['rows'] as $material) {
                ?>
                <tr>
                    <td class="text-center"><?= $i ?></td>
                    <td class="text-center"><?= $material['Material']['name'] ?></td>
                    <td class="text-center"><?= $material['MaterialCategory']['name'] ?></td>
                    <td>
                        <ul>
                            <?php
                            foreach ($material["MaterialDetail"] as $materialDetail) {
                                ?>
                                <li><?= $materialDetail["name"] . " ({$materialDetail["Unit"]["name"]})" ?></li>
                                <?php
                            }
                            ?>
                        </ul>
                    </td>
                </tr>
                <?php
                $i++;
            }
        }
        ?>
    </tbody>
</table>