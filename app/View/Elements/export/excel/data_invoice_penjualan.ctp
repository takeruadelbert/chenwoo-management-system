<div style="text-align: center">
    <div style="font-size:11px;font-weight: bold; font-family:Tahoma, Geneva, sans-serif;">
        Data Invoice Penjualan
    </div>
    <div style="font-size:11px;font-style: italic; font-family:Tahoma, Geneva, sans-serif;">Periode : <?= $this->Echo->laporanPeriodeBulan(@$periodeLaporanStartDate, @$periodeLaporanEndDate) ?></div>
</div>
<br>
<table width="100%" class="table-data">
    <thead>
        <tr>
            <th width="50">No</th>
            <th><?= __("Nomor Invoice") ?></th>
            <th><?= __("Nomor PO") ?></th>
            <th><?= __("Nama Pembeli") ?></th>
            <th colspan = "2"><?= __("Total Tagihan") ?></th>
            <th><?= __("Tanggal Jatuh Tempo") ?></th>
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
                    <td class="text-left"><?= $item['Sale']['sale_no'] ?></td>
                    <td class="text-center"><?= $item['Sale']['po_number'] ?></td>
                    <td class="text-left"><?= $item['Buyer']['company_name'] ?></td>
                    <?php
                    if ($item['Buyer']['buyer_type_id'] == 1) {
                        ?>
                        <td class="text-center" style = "border-right:none !important">Rp.</td>
                        <td class="text-right" style = "border-left:none !important"><?php echo ($item['Sale']['grand_total']); ?></td>
                        <?php
                    } else if ($item['Buyer']['buyer_type_id'] == 2) {
                        ?>
                        <td class="text-center" style = "border-right-style:none !important" width = "50">$ </td>
                        <td class="text-right" style = "border-left-style:none !important" width = "150"><?= ($item['Sale']['grand_total']) ?></td>
                        <?php
                    }
                    ?>
                    <td class="text-center"><?= $this->Html->cvtTanggal($item['Sale']['due_date']) ?></td>  
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