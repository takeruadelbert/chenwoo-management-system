<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("REKAPITULASI IURAN") ?>
                <div class="pull-right">
                    <button class="btn btn-xs btn-default" type="button" onclick="exp('print', '<?php echo Router::url("rekap/print?" . $_SERVER['QUERY_STRING'], true) ?>')">
                        <i class="icon-print2"></i> 
                        <?= __("Cetak") ?>
                    </button>&nbsp;
                </div>
                <small class="display-block"><?= _APP_CORPORATE_FULL ?></small>
            </h6>
        </div>
        <div class="table-responsive stn-table stn-table-nowrap">
            <table width="100%" class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <th width="50">No</th>
                        <th><?= __("Nama Pegawai") ?></th>
                        <th colspan="2"><?= __("Total Iuran") ?></th>
                        <th colspan="2"><?= __("Jumlah Pengambilan") ?></th>
                        <th colspan="2"><?= __("Sisa Iuran") ?></th>
                        <th width="50"><?= __("Aksi") ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    if (empty($data['rows'])) {
                        ?>
                        <tr>
                            <td class = "text-center" colspan = "9">Tidak Ada Data</td>
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
                                <td class="text-center">
                                    <?= $this->element(_TEMPLATE_DIR . "/{$template}/roleaccess/edit", ["editTitle" => "Pengambilan Iuran", "editIcon" => "icon-paper-plane", "editUrl" => Router::url("/admin/cooperative_contribution_withdraws/add/{$item["Employee"]["id"]}")]) ?>
                                </td>
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
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>