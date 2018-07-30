<div style="text-align: center">
    <div style="font-size:11px;font-weight: bold; font-family:Tahoma, Geneva, sans-serif;">
        Data Penarikan Kelebihan
    </div>
</div>
<br>
<table width="100%" class="table-data">
    <thead>
        <tr>
            <th width="50">No</th>
            <th width="350"><?= __("Nomor Penjualan Produk") ?></th>
            <?php
            if ($stnAdmin->branchPrivilege()) {
                ?>
                <th><?= __("Cabang") ?></th>
                <?php
            }
            ?>
            <th width="350"><?= __("Tipe Kas") ?></th>
            <th colspan = "2"><?= __("Nominal") ?></th>
            <th><?= __("Status Verifikasi") ?></th>
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
                <td class = "text-center" colspan = 7>Tidak Ada Data</td>
            </tr>
            <?php
        } else {
            foreach ($data['rows'] as $item) {
                ?>
                <tr>
                    <td class="text-center"><?= $i ?></td>
                    <td class="text-center"><?= $item['Sale']['sale_no'] ?></td>
                    <?php
                    if ($stnAdmin->branchPrivilege()) {
                        ?>
                        <td class="text-left"><?php echo $item["Sale"]["BranchOffice"]['name']; ?></td>
                        <?php
                    }
                    ?>
                    <td class="text-center"><?= $this->Echo->empty_strip($item['InitialBalance']['GeneralEntryType']['name']) ?></td>
                    <?php
                    if ($item['Sale']['Buyer']['buyer_type_id'] == 2) {
                        ?>
                        <td class="text-center" style = "border-right-style:none !important" width = "50">$ </td>
                        <td class="text-right" style = "border-left-style:none !important" width = "150"><?= ac_dollar($item['DebitInvoiceSale']['amount']) ?></td>
                        <?php
                    } else {
                        ?>
                        <td class="text-center" style = "border-right-style:none !important" width = "50">Rp.</td>
                        <td class="text-right" style = "border-left-style:none !important" width = "150"><?= ic_rupiah($item['DebitInvoiceSale']['amount']) ?></td>
                        <?php
                    }
                    ?>
                    <td class="text-center"  id = "target-change-status<?= $i ?>">
                        <?php
                        echo $item['VerifyStatus']['name'];
                        ?>
                    </td>
                </tr>
                <?php
                $i++;
            }
        }
        ?>
    </tbody>
</table>