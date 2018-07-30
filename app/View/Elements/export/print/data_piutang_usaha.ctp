<div style="text-align: center">
    <div style="font-size:11px;font-weight: bold; font-family:Tahoma, Geneva, sans-serif;">
        Data Piutang Usaha
    </div>
    <div style="font-size:11px;font-style: italic; font-family:Tahoma, Geneva, sans-serif;">Periode : <?= $this->Echo->laporanPeriodeBulan(@$periodeLaporanStartDate, @$periodeLaporanEndDate) ?></div>
</div>
<br>
<table width="100%" class="table-data">
    <thead>
        <tr>
            <th width="50">No</th>
            <th><?= __("Nomor Invoice") ?></th>
            <th><?= __("Tanggal Jatuh Tempo") ?></th>
            <th colspan = "2"><?= __("Total Hutang") ?></th>
            <th colspan = "2"><?= __("Sisa Hutang") ?></th>
            <?php
            if ($stnAdmin->branchPrivilege()) {
                ?>
                <th><?= __("Cabang") ?></th>
                <?php
            }
            ?>
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
                    <td class="text-center"><?= $item['Sale']['sale_no'] ?></td>
                    <td class="text-center"><?= $this->Html->cvtTanggal($item['Sale']['due_date']) ?></td>
                    <?php
                    if ($item['Buyer']['buyer_type_id'] == 1) {
                        ?>
                        <td class = "text-center" style = "border-right-style:none !important" width = "50">Rp. </td>
                        <td class = "text-right" style = "border-left-style:none !important" width = "150"><?= ic_rupiah($item['Sale']['grand_total']) ?></td>
                        <td class="text-center" style = "border-right-style:none !important" width = "50">Rp. </td>
                        <td class="text-right" style = "border-left-style:none !important" width = "150"><?= ic_rupiah($item['Sale']['remaining']) ?></td>
                        <?php
                    } else if ($item['Buyer']['buyer_type_id'] == 2) {
                        ?>
                        <td class = "text-center" style = "border-right-style:none !important" width = "50">$ </td>
                        <td class = "text-right" style = "border-left-style:none !important" width = "150"><?= ac_dollar($item['Sale']['grand_total']) ?></td>
                        <td class="text-center" style = "border-right-style:none !important" width = "50">$ </td>
                        <td class="text-right" style = "border-left-style:none !important" width = "150"><?= ac_dollar($item['Sale']['remaining']) ?></td>
                        <?php
                    }
                    ?> 
                    <?php
                    if ($stnAdmin->branchPrivilege()) {
                        ?>
                        <td class="text-left"><?php echo $item["BranchOffice"]['name']; ?></td>
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