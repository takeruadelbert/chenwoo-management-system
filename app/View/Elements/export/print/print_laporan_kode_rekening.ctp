<?php
if (!empty($data['rows'])) {
    ?>
    <table width="100%" class="table-data" style = "border: 1px solid">
        <thead>
            <tr>
                <th style = "border:1px solid" class="text-center" width="50">No</th>
                <th style = "border:1px solid" class="text-center"><?= __("Nomor Rekening") ?></th>
                <th style = "border:1px solid" class="text-center"><?= __("Bank") ?></th>
                <th style = "border:1px solid" class="text-center"><?= __("Atas Nama") ?> </th>
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
                        <td style = "border:1px solid" class="text-center"><?= $i ?></td>
                        <td style = "border:1px solid"  class="text-center"><?= $item['BankAccount']['code'] ?></td>
                        <td style = "border:1px solid"  class="text-center"><?= $item['BankAccountType']['name'] ?></td>
                        <td style = "border:1px solid"  class="text-center"><?= $item['BankAccount']['on_behalf'] ?></td>
                    </tr>
                    <?php
                    $i++;
                }
            }
            ?>
        </tbody>
    </table>
<?php } ?>