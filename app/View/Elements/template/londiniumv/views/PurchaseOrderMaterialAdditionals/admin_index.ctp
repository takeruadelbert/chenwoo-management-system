<?php
echo $this->element(_TEMPLATE_DIR . "/{$template}/filter/po_material_additional");
?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("DATA PURCHASE ORDER MATERIAL PEMBANTU") ?>
                <div class="pull-right">
                    <button class="btn btn-xs btn-default" type="button" onclick="exp('print', '<?php echo Router::url("index/print?" . $_SERVER['QUERY_STRING'], true) ?>')">
                        <i class="icon-print2"></i> 
                        <?= __("Cetak") ?>
                    </button>&nbsp;
                    <button class="btn btn-xs btn-default" type="button" onclick="exp('excel', '<?php echo Router::url("index/excel?" . $_SERVER['QUERY_STRING'], true) ?>')">
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
                            <th width="50"><input type="checkbox" class="styled checkall"/></th>
                            <th width="50">No</th>
                            <th><?= __("Nomor PO") ?></th>
                            <th><?= __("Supplier") ?></th>
                            <th><?= __("Tanggal PO") ?></th>
                            <th><?= __("Nama Pegawai") ?></th>
                            <?php
                            if ($stnAdmin->branchPrivilege()) {
                                ?>
                                <th><?= __("Cabang") ?></th>
                                <?php
                            }
                            ?>
                            <th><?= __("Status") ?></th>
                            <th width="150"><?= __("Aksi") ?></th>
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
                                <td class = "text-center" colspan = 9>Tidak Ada Data</td>
                            </tr>
                            <?php
                        } else {
                            foreach ($data['rows'] as $item) {
                                ?>
                                <tr id="row-<?= $i ?>" class="removeRow<?php echo $item["PurchaseOrderMaterialAdditional"]['id']; ?>">
                                    <td class="text-center"><input type="checkbox" name="data[<?php echo Inflector::classify($this->params['controller']) ?>][checkbox][]" value="<?php echo $item["PurchaseOrderMaterialAdditional"]['id']; ?>"  id="checkBoxRow" class="styled checkboxDeleteRow" /></td>
                                    <td class="text-center"><?= $i ?></td>
                                    <td class="text-center"><?php echo $item["PurchaseOrderMaterialAdditional"]['po_number']; ?></td>
                                    <td class="text-center"><?php echo $item["MaterialAdditionalSupplier"]['name']; ?></td>
                                    <td class="text-center"><?php echo $this->Html->cvtTanggal($item["PurchaseOrderMaterialAdditional"]['po_date']); ?></td>
                                    <td class="text-center"><?php echo $item['Employee']['Account']['Biodata']['full_name']; ?></td>
                                    <?php
                                    if ($stnAdmin->branchPrivilege()) {
                                        ?>
                                        <td class="text-left"><?php echo $item["BranchOffice"]['name']; ?></td>
                                        <?php
                                    }
                                    ?>
                                    <td class="text-center">
                                        <?php
                                        echo $item['PurchaseOrderMaterialAdditionalStatus']['name'];
                                        ?>
                                    </td>
                                    <td class="text-center">
                                        <a data-toggle="modal" data-target="#default-view-coop-transaction" href="<?= Router::url("/admin/popups/content?content=viewpo-materialadditional&id={$item[Inflector::classify($this->params['controller'])]['id']}") ?>" role="button" href="#default-lihatdata" class="ajax-modal btn btn-default btn-xs btn-icon btn-icon tip viewData" title="Lihat Data"><i class="icon-eye7"></i></a>                          
                                        <?php
                                        if ($item['PurchaseOrderMaterialAdditional']['purchase_order_material_additional_status_id'] == 2) {
                                            ?>
                                            <a target = "_blank" href = "<?= Router::url("/admin/{$this->params['controller']}/print_purchase_order/{$item[Inflector::classify($this->params['controller'])]['id']} ", true) ?>" class = "btn btn-default btn-xs btn-icon btn-icon tip" title = "Cetak Purchase Order"><i class = "icon-print2"></i></a>
                                            <?php
                                                if($item['PurchaseOrderMaterialAdditional']['remaining']>0){
                                            ?>
                                                    <a href="<?= Router::url("/admin/purchaseOrderMaterialAdditionals/edit/{$item[Inflector::classify($this->params['controller'])]['id']}") ?>"><button type="button" class="btn btn-default btn-xs btn-icon tip" title="Ubah"><i class="icon-pencil"></i></button></a>    
                                            <?php
                                                }
                                            ?>
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