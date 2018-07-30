<div style="text-align: center">
    <div style="font-size:11px;font-weight: bold; font-family:Tahoma, Geneva, sans-serif;">
        Data Setup Bunga Pinjaman
    </div>
</div>
<br>
<table width="100%" class="table-data">
    <thead>
        <tr>
            <th width="50">No</th>
            <th><?= __("Tipe Pinjaman") ?></th>
            <th width="150"><?= __("Bunga") ?></th>
            <th width="350"><?= __("Range Pinjaman") ?></th>
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
                <tr>
                    <td class="text-center"><?= $i ?></td>
                    <td class="text-left"><?= $item['CooperativeLoanType']['name'] ?></td>
                    <td class="text-right"><?= $item['CooperativeLoanInterest']['interest'] ?>%</td>
                    <td class="text-left"><?= $this->Html->IDR($item['CooperativeLoanInterest']['bottom_limit']) . " s/d " . $this->Html->IDR($item['CooperativeLoanInterest']['upper_limit']) ?></td>
                </tr>
                <?php
                $i++;
            }
        }
        ?>
    </tbody>
</table>