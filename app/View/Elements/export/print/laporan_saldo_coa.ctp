<div style="text-align: center">
    <div style="font-size:11px;font-weight: bold; font-family:Tahoma, Geneva, sans-serif;">
        LAPORAN SALDO COA
    </div>
</div>
<br>
<table width="100%" class="table table-hover table-bordered">
    <thead>
        <tr>
            <th width="50">No</th>
            <th width="150"><?= __("Kode") ?></th>
            <th><?= __("Uraian") ?></th>
            <th width="200"><?= __("Klasifikasi") ?></th>
            <th colspan="2"><?= __("Saldo") ?></th>
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
                    <td class="text-center"><?= emptyToStrip($item['GeneralEntryType']['code']) ?></td>
                    <td class="text-left"><?php echo $item["GeneralEntryType"]['name']; ?></td>
                    <td class="text-left"><?= emptyToStrip($item['Parent']['name']) ?></td>
                    <?php
                    if (!empty($item['Currency']['uniq_name'])) {
                        if ($item['Currency']['uniq_name'] == "Rp") {
                            ?>
                            <td class="text-center" style = "border-right-style:none !important" width = "50">Rp. </td>
                            <td class="text-right" style = "border-left-style:none !important" width = "150"><?= $this->Html->Rp($item['GeneralEntryType']['latest_balance']) ?> </td>
                            <?php
                        } else {
                            ?>
                            <td class="text-center" style = "border-right-style:none !important" width = "50">$ </td>
                            <td class="text-right" style = "border-left-style:none !important" width = "150"><?= ac_dollar($item['GeneralEntryType']['latest_balance']) ?> </td>
                            <?php
                        }
                    } else {
                        ?>
                        <td colspan="2" class="text-center">-</td>
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