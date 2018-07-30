<?php
echo $this->element(_TEMPLATE_DIR . "/{$template}/filter/PO_material_pembantu");
?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("BARANG MASUK SESUAI PURCHASE ORDER MATERIAL PEMBANTU") ?>
                <div class="pull-right">
                    <button class="btn btn-xs btn-default" type="button" onclick="exp('print', '<?php echo Router::url("entry/print?" . $_SERVER['QUERY_STRING'], true) ?>')">
                        <i class="icon-print2"></i> 
                        <?= __("Cetak") ?>
                    </button>&nbsp;
                    <button class="btn btn-xs btn-default" type="button" onclick="exp('excel', '<?php echo Router::url("entry/excel?" . $_SERVER['QUERY_STRING'], true) ?>')">
                        <i class="icon-file-excel"></i>
                        Excel
                    </button>&nbsp;
                    <?= $this->element(_TEMPLATE_DIR . "/{$template}/roleaccess/delete") ?>
                </div>
                <small class="display-block"><?= _APP_CORPORATE_FULL ?></small>
            </h6>
        </div>
        <div class = "table-responsive pre-scrollable stn-table stn-table-nowrap">
            <form id = "checkboxForm" method = "post" name = "checkboxForm" action = "<?php echo Router::url('/' . $this->params['prefix'] . '/' . $this->params['controller'] . '/multiple_delete', true); ?> ">
                <table width = "100%" class = "table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th width = "50"><input type = "checkbox" class = "styled checkall"/></th>
                            <th width = "50">No</th>
                            <th width="200"><?= __("Nomor PO") ?></th>
                            <th><?= __("Supplier") ?></th>
                            <th width="150"><?= __("Tanggal PO") ?></th>
                            <th><?= __("Nama Pegawai") ?></th>
                            <?php
                            if ($stnAdmin->branchPrivilege()) {
                                ?>
                                <th><?= __("Cabang") ?></th>
                                <?php
                            }
                            ?>
                            <th width="170"><?= __("Jumlah Material Diorder") ?></th>
                            <th width="150"><?= __("Kekurangan Material") ?></th>
                            <th width="50"><?= __("Aksi") ?></th>
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
                                <td class = "text-center" colspan = 10>Tidak Ada Data</td>
                            </tr>
                            <?php
                        } else {
                            foreach ($data['rows'] as $item) {
                                ?>
                                <tr id="row-<?= $i ?>" class="removeRow<?php echo $item["PurchaseOrderMaterialAdditional"]['id']; ?>">
                                    <td class="text-center"><input type="checkbox" name="data[<?php echo Inflector::classify($this->params['controller']) ?>][checkbox][]" value="<?php echo $item["PurchaseOrderMaterialAdditional"]['id']; ?>"  id="checkBoxRow" class="styled checkboxDeleteRow" /></td>
                                    <td class="text-center"><?= $i ?></td>
                                    <td class="text-center">
                                        <a data-toggle="modal" data-target="#default-view-coop-transaction" href="<?= Router::url("/admin/popups/content?content=viewcoopmaterialadditional-entry&id={$item[Inflector::classify($this->params['controller'])]['id']}") ?>" class="ajax-modal"><?= $item["PurchaseOrderMaterialAdditional"]['po_number']; ?></a>                                           
                                    </td>
                                    <td class="text-left"><?php echo $item["MaterialAdditionalSupplier"]['name']; ?></td>
                                    <td class="text-center"><?php echo $this->Html->cvtTanggal($item["PurchaseOrderMaterialAdditional"]['po_date']); ?></td>
                                    <td class="text-left"><?php echo $item['Employee']['Account']['Biodata']['full_name']; ?></td>
                                    <?php
                                    if ($stnAdmin->branchPrivilege()) {
                                        ?>
                                        <td class="text-left"><?php echo $item["BranchOffice"]['name']; ?></td>
                                        <?php
                                    }
                                    ?>
                                    <td class="text-center"  id = "target-change-status<?= $i ?>">
                                        <?php
                                        $total = 0;
                                        $remaining = 0;
                                        foreach ($item["PurchaseOrderMaterialAdditionalDetail"] as $detail) {
                                            $total += $detail['quantity'];
                                            $remaining += $detail['quantity_remaining'];
                                        }
                                        if ($remaining > 0) {
                                            $btn = "warning";
                                        } else {
                                            $btn = "success";
                                        }
                                        echo ic_kg($total);
                                        ?>
                                    </td>
                                    <td class="text-center"  id = "target-change-status<?= $i ?>">
                                        <span class="label label-<?= $btn ?>">
                                            <?php
                                            echo ic_kg($remaining);
                                            ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <a href = "<?= Router::url("/admin/purchase_order_material_additionals/entry_edit/{$item[Inflector::classify($this->params['controller'])]['id']} ", true) ?>" class = "btn btn-default btn-xs btn-icon btn-icon tip" title = "Edit Entry Material Pembantu"><i class = "icon-pencil"></i></a>
                                        <?php
                                            if ($remaining > 0) {
                                            ?>
                                            <a href = "<?= Router::url("/admin/material_additional_entries/add?id={$item[Inflector::classify($this->params['controller'])]['id']} ", true) ?>" class = "btn btn-default btn-xs btn-icon btn-icon tip" title = "Entry Material Pembantu"><i class = "icon-loop"></i></a>
                                                <?php
                                            }
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
            </form>
        </div>
    </div>
    <?php echo $this->element(_TEMPLATE_DIR . "/{$template}/pagination") ?>
</div>