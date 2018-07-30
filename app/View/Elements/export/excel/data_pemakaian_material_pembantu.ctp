<div style="text-align: center">
    <div style="font-size:11px;font-weight: bold; font-family:Tahoma, Geneva, sans-serif;">
        Data Pemakaian Material Pembantu
    </div>
    <div style="font-size:11px;font-style: italic; font-family:Tahoma, Geneva, sans-serif;">Periode : <?= $this->Echo->laporanPeriodeBulan(@$periodeLaporanStartDate, @$periodeLaporanEndDate) ?></div>
</div>
<br>
<table width="100%" class="table-data">
    <thead>
        <tr>
            <th width="50">No</th>
            <th><?= __("Barang Terpakai") ?></th>
            <th colspan = "2"><?= __("Jumlah") ?></th>
            <th><?= __("Penanggung Jawab") ?></th>
            <th><?= __("Tanggal Barang Terpakai") ?></th>
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
                <td class = "text-center" colspan = 5>Tidak Ada Data</td>
            </tr>
            <?php
        } else {
            foreach ($data['rows'] as $item) {
                ?>
                <tr>
                    <td class="text-center"><?= $i ?></td>
                    <td class="text-left"><?php echo $item["MaterialAdditional"]['full_label']; ?></td>
                    <td class="text-right" style = "border-right-style: none !important;"><?php echo ic_kg($item["MaterialAdditionalOut"]['quantity']); ?></td>
                    <td class="text-left" style = "border-left-style: none !important;" width = "50"><?php echo $item["MaterialAdditional"]["MaterialAdditionalUnit"]['uniq']; ?></td>
                    <td class="text-center"><?php echo $item['Employee']['Account']['Biodata']['full_name']; ?></td>
                    <td class="text-center"><?php echo !empty($item['MaterialAdditionalOut']['use_dt']) ? $this->Html->cvtTanggal($item['MaterialAdditionalOut']['use_dt']) : "-"; ?></td>
                </tr>
                <?php
                $i++;
            }
        }
        ?>
    </tbody>
</table>