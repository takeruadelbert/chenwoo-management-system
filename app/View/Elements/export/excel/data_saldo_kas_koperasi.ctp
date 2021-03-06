<div style="text-align: center">
    <div style="font-size:11px;font-weight: bold; font-family:Tahoma, Geneva, sans-serif;">
        Data Saldo Kas Koperasi
    </div>
</div>
<br>
<table width="100%" class="table-data">
    <thead>
        <tr>
            <th width="50">No</th>
            <th><?= __("Nama Kas") ?></th>
            <th><?= __("Nomor Rekening") ?></th>
            <th><?= __("Atas Nama") ?></th>
            <th><?= __("Bank") ?></th>
            <th colspan = "2"><?= __("Nominal") ?></th>
            <th><?= __("Tanggal Dibuat") ?></th>
            <th><?= __("Tipe Kas") ?></th>
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
                <td class = "text-center" colspan ="9">Tidak Ada Data</td>
            </tr>
            <?php
        } else {
            foreach ($data['rows'] as $item) {
                ?>
                <tr>
                    <td class="text-center"><?= $i ?></td>
                    <td class="text-center"><?= $item['CooperativeCash']['name'] ?></td>
                    <td class="text-center"><?= !empty($item['CooperativeBankAccount']['id']) ? $item['CooperativeBankAccount']['code'] : "-" ?></td>
                    <td class="text-center"><?= !empty($item['CooperativeBankAccount']['id']) ? $item['CooperativeBankAccount']['on_behalf'] : "-" ?></td>
                    <td class="text-center"><?= !empty($item['CooperativeBankAccount']['id']) ? $item['CooperativeBankAccount']['BankAccountType']['name'] : "-" ?></td>
                    <td class="text-center" style = "border-right-style:none !important" width = "50">Rp. </td>
                    <td class="text-right" style = "border-left-style:none !important" width = "150"><?= $this->Html->Rp($item['CooperativeCash']['nominal']) ?></td>
                    <td class="text-center"><?= $this->Html->cvtTanggal($item['CooperativeCash']['created_date']) ?></td>
                    <td class="text-center"><?= $item['CashType']['name'] ?></td>
                </tr>
                <?php
                $i++;
            }
        }
        ?>
    </tbody>
</table>