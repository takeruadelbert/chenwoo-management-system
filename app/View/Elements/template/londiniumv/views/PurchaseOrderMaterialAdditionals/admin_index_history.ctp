<?php
echo $this->element(_TEMPLATE_DIR . "/{$template}/filter/purchase_order_material_additional_history");
?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("HISTORI TRANSAKSI MATERIAL PEMBANTU") ?>
                <div class="pull-right">
                    <button class="btn btn-xs btn-default" type="button" onclick="exp('print', '<?php echo Router::url("index_history/print?" . $_SERVER['QUERY_STRING'], true) ?>')">
                        <i class="icon-print2"></i> 
                        <?= __("Cetak") ?>
                    </button>&nbsp;
                    <button class="btn btn-xs btn-default" type="button" onclick="exp('excel', '<?php echo Router::url("index_history/excel?" . $_SERVER['QUERY_STRING'], true) ?>')">
                        <i class="icon-file-excel"></i>
                        Excel
                    </button>&nbsp;
                </div>
                <small class="display-block"><?= _APP_CORPORATE_FULL ?></small>
            </h6>
        </div>
        <div class="table-responsive pre-scrollable stn-table">
            <form id="checkboxForm" method="post" name="checkboxForm" action="<?php echo Router::url('/' . $this->params['prefix'] . '/' . $this->params['controller'] . '/multiple_delete', true); ?>">
                <table width="100%" class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th width="50">No</th>
                            <th><?= __("Nomor PO") ?></th>
                            <th><?= __("Nomor RO") ?></th>
                            <th><?= __("Nama Pegawai Pembuat RO") ?></th>
                            <?php
                            if ($stnAdmin->branchPrivilege()) {
                                ?>
                                <th><?= __("Cabang") ?></th>
                                <?php
                            }
                            ?>
                            <th colspan = "2"><?= __("Total Transaksi") ?></th>
                            <th colspan = "2"><?= __("Sisa Pembayaran") ?></th>
                            <th><?= __("Nama Kasir") ?></th>
                            <th><?= __("Tanggal PO") ?></th>
                            <th><?= __("Supplier") ?></th>
                            <th><?= __("Status") ?></th>
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
                                <td class = "text-center" colspan = 13>Tidak Ada Data</td>
                            </tr>
                            <?php
                        } else {
                            foreach ($data['rows'] as $item) {
                                ?>
                                <tr >
                                    <td class="text-center"><?= $i ?></td>
                                    <td class="text-center">
                                        <a data-toggle="modal" data-target="#default-view-coop-transaction" href="<?= Router::url("/admin/popups/content?content=viewpo-materialadditional&id={$item[Inflector::classify($this->params['controller'])]['id']}") ?>" class="ajax-modal"><?= $item["PurchaseOrderMaterialAdditional"]['po_number']; ?></a>                                 
                                    </td>
                                    <td class="text-center">
                                        <a data-toggle="modal" data-target="#default-view-coop-transaction" href="<?= Router::url("/admin/popups/content?content=viewcoopmaterialadditional-ro&id={$item['RequestOrderMaterialAdditional']['id']}") ?>" class="ajax-modal"><?= $item["RequestOrderMaterialAdditional"]['ro_number']; ?></a>                                           
                                    </td>
                                    <td class="text-center"><?= $item['RequestOrderMaterialAdditional']['Employee']['Account']['Biodata']['full_name'] ?></td>
                                    <?php
                                    if ($stnAdmin->branchPrivilege()) {
                                        ?>
                                        <td class="text-left"><?php echo $item["BranchOffice"]['name']; ?></td>
                                        <?php
                                    }
                                    ?>
                                    <td class="text-center" style = "border-right-style:none !important" width = "50">Rp. </td>
                                    <td class="text-right" style = "border-left-style:none !important" width = "100"><?php echo emptyToStrip(ic_rupiah($item["PurchaseOrderMaterialAdditional"]['total'])); ?></td>
                                    <td class="text-center" style = "border-right-style:none !important" width = "50">Rp. </td>
                                    <td class="text-right" style = "border-left-style:none !important" width = "100"><?php echo emptyToStrip(ic_rupiah($item["PurchaseOrderMaterialAdditional"]['remaining'])); ?></td>
                                    <td class="text-center"><?php echo!empty($item['Employee']['id']) ? $item['Employee']['Account']['Biodata']['full_name'] : "-"; ?></td>
                                    <td class="text-center"><?php echo!empty($item['PurchaseOrderMaterialAdditional']['po_date']) ? $this->Html->cvtWaktu($item["PurchaseOrderMaterialAdditional"]['po_date']) : "-"; ?></td>
                                    <td class="text-center"><?php echo $item['MaterialAdditionalSupplier']['name']; ?></td>
                                    <td class="text-center"><?= $item['PurchaseOrderMaterialAdditionalStatus']['name'] ?></td>      
                                </tr>
                                <?php
                                $i++;
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </form>
        </div>
    </div>
    <?php echo $this->element(_TEMPLATE_DIR . "/{$template}/pagination") ?>
</div>