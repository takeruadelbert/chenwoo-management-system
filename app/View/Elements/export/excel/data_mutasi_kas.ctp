<div style="text-align: center">
    <div style="font-size:11px;font-weight: bold; font-family:Tahoma, Geneva, sans-serif;">
        Data Mutasi Kas
    </div>
    <div style="font-size:11px;font-style: italic; font-family:Tahoma, Geneva, sans-serif;">Periode : <?= $this->Echo->laporanPeriodeBulan(@$periodeLaporanStartDate, @$periodeLaporanEndDate) ?></div>
</div>
<br>
<table width="100%" class="table-data"> 
    <thead>
        <tr>
            <th width="50">No</th>
            <th><?= __("Dari") ?></th>
            <th><?= __("Tujuan") ?></th>
            <th colspan = "2"><?= __("Nominal") ?></th>
            <th><?= __("Nama Pegawai") ?></th>
            <th><?= __("Tanggal") ?></th>
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
                <td class = "text-center" colspan = 8>Tidak Ada Data</td>
            </tr>
            <?php
        } else {
            foreach ($data['rows'] as $item) {
                ?>
                <tr>
                    <td class="text-center"><?= $i ?></td>
                    <td class="text-left"><?= $item['CashTransfered']['GeneralEntryType']['name'] ?></td>
                    <td class="text-left"><?= $item['CashReceived']['GeneralEntryType']['name'] ?></td>
                    <?php
                    if ($item['CashMutation']['currency_id'] == 1) {
                        ?>
                        <td class="text-center" style = "border-right-style:none !important" width = "50">Rp. </td>
                        <td class="text-right" style = "border-left-style:none !important" width = "150"><?= ic_rupiah($item['CashMutation']['nominal']) ?></td>
                        <?php
                    } else {
                        ?>
                        <td class="text-center" style = "border-right-style:none !important" width = "50">$</td>
                        <td class="text-right" style = "border-left-style:none !important" width = "150"><?= ac_dollar($item['CashMutation']['nominal']) ?></td>
                        <?php
                    }
                    ?>
                    <td class="text-left"><?= $item['Creator']['Account']['Biodata']['full_name'] ?></td>
                    <td class="text-center"><?= $this->Html->cvtWaktu($item['CashMutation']['transfer_date']) ?></td>
                    <td class="text-center"><?= $item['CashMutation']['note'] ?></td>
                </tr>
                <?php
                $i++;
            }
        }
        ?>
    </tbody>
</table>