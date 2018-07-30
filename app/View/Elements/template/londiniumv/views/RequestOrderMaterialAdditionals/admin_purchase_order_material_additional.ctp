<?php
echo $this->element(_TEMPLATE_DIR . "/{$template}/filter/purchase_order_material_additional");
?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("PURCHASE ORDER MATERIAL PEMBANTU") ?>
                <div class="pull-right">
                    <button class="btn btn-xs btn-default" type="button" onclick="exp('print', '<?php echo Router::url("purchase_order_material_additional/print?" . $_SERVER['QUERY_STRING'], true) ?>')">
                        <i class="icon-print2"></i> 
                        <?= __("Cetak") ?>
                    </button>&nbsp;
                    <button class="btn btn-xs btn-default" type="button" onclick="exp('excel', '<?php echo Router::url("purchase_order_material_additional/excel?" . $_SERVER['QUERY_STRING'], true) ?>')">
                        <i class="icon-file-excel"></i>
                        Excel
                    </button>&nbsp;
                </div>
                <small class="display-block"><?= _APP_CORPORATE_FULL ?></small>
            </h6>
        </div>
        <div class="table-responsive pre-scrollable stn-table stn-table-nowrap">
            <form id="checkboxForm" method="post" name="checkboxForm" action="<?php echo Router::url('/' . $this->params['prefix'] . '/' . $this->params['controller'] . '/multiple_delete', true); ?>">
                <table width="100%" class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th width="50"><input type="checkbox" class="styled checkall"/></th>
                            <th width="50">No</th>
                            <th width = "200"><?= __("Nomor RO") ?></th>
                            <th width = "150"><?= __("Tanggal RO") ?></th>
                            <th width = "250"><?= __("Nama Pegawai") ?></th>
                            <?php
                            if ($stnAdmin->branchPrivilege()) {
                                ?>
                                <th><?= __("Cabang") ?></th>
                                <?php
                            }
                            ?>
                            <th width = "150"><?= __("Total Material RO") ?></th>
                            <th width = "150"><?= __("Sisa Material RO") ?></th>
                            <th width = "150"><?= __("Status") ?></th>
                            <th width="100"><?= __("Aksi") ?></th>
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
                                <tr id="row-<?= $i ?>" class="removeRow<?php echo $item["RequestOrderMaterialAdditional"]['id']; ?>">
                                    <td class="text-center"><input type="checkbox" name="data[<?php echo Inflector::classify($this->params['controller']) ?>][checkbox][]" value="<?php echo $item["RequestOrderMaterialAdditional"]['id']; ?>"  id="checkBoxRow" class="styled checkboxDeleteRow" /></td>
                                    <td class="text-center"><?= $i ?></td>
                                    <td class="text-center">
                                        <a data-toggle="modal" data-target="#default-view-coop-transaction" href="<?= Router::url("/admin/popups/content?content=viewcoopmaterialadditional-ro&id={$item[Inflector::classify($this->params['controller'])]['id']}") ?>" class="ajax-modal"><?= $item["RequestOrderMaterialAdditional"]['ro_number']; ?></a>                                           
                                    </td>
                                    <td class="text-center"><?php echo $this->Html->cvtTanggal($item["RequestOrderMaterialAdditional"]['ro_date']); ?></td>
                                    <td class="text-left"><?php echo $item['Employee']['Account']['Biodata']['full_name']; ?></td>
                                    <?php
                                    if ($stnAdmin->branchPrivilege()) {
                                        ?>
                                        <td class="text-left"><?php echo $item["BranchOffice"]['name']; ?></td>
                                        <?php
                                    }
                                    ?>
                                    <td class="text-center">
                                        <?php
                                        $remaining = 0;
                                        $total = 0;
                                        $finished = 0;
                                        foreach ($item['RequestOrderMaterialAdditionalDetail'] as $material) {
                                            if ($material['is_used']) {
                                                $finished++;
                                            }
                                            $total++;
                                        }
                                        $remaining = $total - $finished;
                                        echo $total . " Material";
                                        ?>
                                    </td>
                                    <td class="text-center">
                                        <?php
                                        if ($item['RequestOrderMaterialAdditional']['po_status'] == 0) {
                                            ?>
                                            <span class = "label label-warning"><?= $remaining ?> Material</span>
                                            <?php
                                        } else {
                                            ?>
                                            <span class = "label label-success"><?= $remaining ?> Material</span>
                                            <?php
                                        }
                                        ?>
                                    </td>
                                    <td class="text-center">
                                        <?php
                                        if ($item['RequestOrderMaterialAdditional']['po_status'] == 0) {
                                            ?>
                                            <span class = "label label-danger">Belum Selesai</span>
                                            <?php
                                        } else {
                                            ?>
                                            <span class = "label label-success">Sudah Selesai</span>
                                            <?php
                                        }
                                        ?>
                                    </td>
                                    <td class="text-center">
                                        <?php
                                        if ($remaining > 0) {
                                            ?>
                                            <a href = "<?= Router::url("/admin/purchase_order_material_additionals/process_order/{$item[Inflector::classify($this->params['controller'])]['id']} ", true) ?>" class = "btn btn-default btn-xs btn-icon btn-icon tip" title = "Proses PO Material Pembantu"><i class = "icon-loop"></i></a>
                                            <?php
                                        }
                                        ?>
                                        <?php
                                        if (!empty($item['PurchaseOrderMaterialAdditional'])) {
                                            ?>
                                            <a data-toggle="modal" data-target="#default-view-coop-transaction" href="<?= Router::url("/admin/popups/content?content=viewcoopmaterialadditional-po&id={$item[Inflector::classify($this->params['controller'])]['id']}") ?>" role="button" href="#default-lihatdata" class="ajax-modal btn btn-default btn-xs btn-icon btn-icon tip viewData" title="Lihat Data"><i class="icon-eye7"></i></a>
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