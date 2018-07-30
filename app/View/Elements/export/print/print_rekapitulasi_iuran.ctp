<div style="text-align: center">
    <div style="font-size:11px;font-weight: bold; font-family:Tahoma, Geneva, sans-serif;">
        Rekapitulasi Iuran
    </div>
</div>
<br>
<table width="100%" class="table-data">
    <thead>
        <tr>
            <th width="50">No</th>
            <th><?= __("Nama Pegawai") ?></th>
            <th colspan="2"><?= __("Total Iuran") ?></th>
            <th colspan="2"><?= __("Jumlah Pengambilan") ?></th>
            <th colspan="2"><?= __("Sisa Iuran") ?></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 1;
        if (empty($data['rows'])) {
            ?>
            <tr>
                <td class = "text-center" colspan = "8">Tidak Ada Data</td>
            </tr>
            <?php
        } else {
            $grandTotal = 0;
            $paidTotal = 0;
            foreach ($data['rows'] as $item) {
                $grandTotal+=$item["CooperativeContribution"]["total"];
                $paidTotal+=$item["CooperativeContribution"]["paid"];
                ?>
                <tr id="row-<?= $i ?>" class="removeRow<?php echo $item[Inflector::classify($this->params['controller'])]['id']; ?>">
                    <td class="text-center"><?= $i ?></td>
                    <td><?= $item['Employee']["Account"]["Biodata"]['full_name'] ?></td>
                    <td class="text-center" style = "border-right-style:none !important" width = "25">Rp. </td>
                    <td class="text-right"  style = "border-left-style:none !important" width="100"><?= ic_rupiah($item["CooperativeContribution"]["total"]) ?></td>
                    <td class="text-center" style = "border-right-style:none !important" width = "25">Rp. </td>
                    <td class="text-right"  style = "border-left-style:none !important" width="100"><?= ic_rupiah($item["CooperativeContribution"]["paid"]) ?></td>
                    <td class="text-center" style = "border-right-style:none !important" width = "25">Rp. </td>
                    <td class="text-right"  style = "border-left-style:none !important" width="100"><?= ic_rupiah($item["CooperativeContribution"]["total"] - $item["CooperativeContribution"]["paid"]) ?></td>
                </tr>
                <?php
                $i++;
            }
        }
        ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="2"><?= __("Total") ?></td>
            <td class="text-center" style = "border-right-style:none !important" width = "25">Rp. </td>
            <td class="text-right"  style = "border-left-style:none !important" width="100"><?= ic_rupiah($grandTotal) ?></td>
            <td class="text-center" style = "border-right-style:none !important" width = "25">Rp. </td>
            <td class="text-right"  style = "border-left-style:none !important" width="100"><?= ic_rupiah($paidTotal) ?></td>
            <td class="text-center" style = "border-right-style:none !important" width = "25">Rp. </td>
            <td class="text-right"  style = "border-left-style:none !important" width="100"><?= ic_rupiah($grandTotal - $paidTotal) ?></td>
        </tr>
    </tfoot>
</table>