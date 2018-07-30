<div style="text-align: center">
    <div style="font-size:11px;font-weight: bold; font-family:Tahoma, Geneva, sans-serif;">
        Data Saldo Awal Rekening
    </div>
</div>
<br>
<table width="100%" class="table-data">
    <thead>
        <tr>
            <th width="50">No</th>
            <th><?= __("Nama") ?></th>
            <th><?= __("Atas Nama Rekening Bank") ?></th>
            <th><?= __("Nomor Rekening") ?></th>
            <th><?= __("Bank") ?></th>
            <th><?= __("Tanggal") ?></th>
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
                <td class = "text-center" colspan = 6>Tidak Ada Data</td>
            </tr>
            <?php
        } else {
            foreach ($data['rows'] as $item) {
                ?>
                <tr>
                    <td class="text-center"><?= $i ?></td>
                    <td class="text-center"><?= $item['GeneralEntryType']['name'] ?></td>
                    <td><?= $item['BankAccount']['on_behalf'] ?></td>
                    <td class="text-center"><?= !empty($item['BankAccount']['id']) ? $item['BankAccount']['code'] : "-" ?></td>
                    <td class="text-center"><?= !empty($item['BankAccount']['id']) ? $item['BankAccount']['BankAccountType']['name'] : "-" ?></td>
                    <td class="text-center"><?= $this->Html->cvtTanggal($item['InitialBalance']['initial_date']) ?></td>           
                </tr>
                <?php
                $i++;
            }
        }
        ?>
    </tbody>
</table>
