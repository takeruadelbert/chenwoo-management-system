<div style="text-align: center">
    <div style="font-size:11px;font-weight: bold; font-family:Tahoma, Geneva, sans-serif;">
    Data Partner
</div>
<br>
<table width="100%" class="table-data">
    <thead>
        <tr>
            <th width="50">No</th>
            <th><?= __("ID Partner") ?></th>
            <th><?= __("Nama Partner") ?></th>
            <th><?= __("Alamat") ?></th>
            <th><?= __("Provinsi") ?></th>
            <th><?= __("Kota") ?></th>
            <th><?= __("Negara") ?></th>
            <th><?= __("No. Telepon") ?></th>
            <th><?= __("Email") ?></th>
            <th><?= __("Website") ?></th>
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
                    <td class="text-center"><?= $item['Partner']['id_partner'] ?></td>
                    <td class="text-center"><?= $item['Partner']['name'] ?></td>
                    <td class="text-center"><?= $item['Partner']['address'] ?></td>
                    <td class="text-center"><?= $item['City']['name'] ?></td>
                    <td class="text-center"><?= $item['State']['name'] ?></td>
                    <td class="text-center"><?= $item['Country']['name'] ?></td>
                    <td class="text-center"><?= $item['Partner']['phone_number'] ?></td>
                    <td class="text-center"><?= $this->Echo->empty_strip($item['Partner']['email']) ?></td>
                    <td class="text-center"><?= $this->Echo->empty_strip($item['Partner']['website']) ?></td>
                </tr>
                <?php
                $i++;
            }
        }
        ?>
    </tbody>
</table>