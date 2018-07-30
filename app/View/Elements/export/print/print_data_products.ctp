<table width="100%" class="" style="border: none !important; font-size:14px;">
    <thead>
        <tr style="border-bottom: 1px solid">
            <td style = "font-weight: bold;" class="text-center"><?= __("No") ?> </td>
            <td style = "font-weight: bold;"  class="text-center"><?= __("Product") ?></td>
            <td style = "font-weight: bold;" class="text-center"><?= __("Satuan") ?> </td>
            <td style = "font-weight: bold;"  class="text-center"><?= __("Kategori") ?></td>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
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
                foreach ($item['ProductSize'] as $detail) {
                    ?>
                    <tr>
                        <td><?= $no ?></td>
                        <td><?= $item['Product']['name'] . " - " . $detail['name'] ?></td>
                        <td><?= $detail['ProductUnit']['name'] ?></td>
                        <td><?= $item['ProductCategory']['name'] ?></td>
                        <?php
                        $no++;
                        $i++;
                    }
                }
            }
            ?>
    </tbody>
</table>
