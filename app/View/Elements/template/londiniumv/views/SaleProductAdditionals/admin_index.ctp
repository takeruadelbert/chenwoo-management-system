<?php
echo $this->element(_TEMPLATE_DIR . "/{$template}/filter/sale-product-additional");
?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("DATA PENJUALAN PRODUK TAMBAHAN") ?>
                <div class="pull-right">
                    <button class="btn btn-xs btn-default" type="button" onclick="exp('print', '<?php echo Router::url("index/print?" . $_SERVER['QUERY_STRING'], true) ?>')">
                        <i class="icon-print2"></i> 
                        <?= __("Cetak") ?>
                    </button>&nbsp;
                    <button class="btn btn-xs btn-default" type="button" onclick="exp('excel', '<?php echo Router::url("index/excel?" . $_SERVER['QUERY_STRING'], true) ?>')">
                        <i class="icon-file-excel"></i>
                        Excel
                    </button>&nbsp;
                    <?= $this->element(_TEMPLATE_DIR . "/{$template}/roleaccess/delete") ?>
                    <?= $this->element(_TEMPLATE_DIR . "/{$template}/roleaccess/add") ?>
                </div>
                <small class="display-block"><?= _APP_CORPORATE_FULL ?></small>
            </h6>
        </div>
        <div class="table-responsive pre-scrollable stn-table stn-table-nowrap">
            <form id="checkboxForm" method="post" name="checkboxForm" action="<?php echo Router::url('/' . $this->params['prefix'] . '/' . $this->params['controller'] . '/multiple_delete', true); ?>">
                <table width="100%" class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th width="10"><input type="checkbox" class="styled checkall"/></th>
                            <th width="10">No</th>
                            <th><?= __("Nomor Penjualan") ?></th>
                            <th><?= __("Tgl Penjualan") ?></th>
                            <th colspan="2"><?= __("Total Harga Penjualan") ?></th>
                            <th><?= __("Penanggungjawab") ?></th>
                            <th><?= __("Pembeli") ?></th>
                            <th><?= __("Tipe Pembayaran") ?></th>
                            <th><?= __("Status Pembayaran") ?></th>
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
                                <td class = "text-center" colspan = "11">Tidak Ada Data</td>
                            </tr>
                            <?php
                        } else {
                            foreach ($data['rows'] as $item) {
                                ?>
                                <tr id="row-<?= $i ?>" class="removeRow<?php echo $item["SaleProductAdditional"]['id']; ?>">
                                    <td class="text-center"><input type="checkbox" name="data[<?php echo Inflector::classify($this->params['controller']) ?>][checkbox][]" value="<?php echo $item["SaleProductAdditional"]['id']; ?>"  id="checkBoxRow" class="styled checkboxDeleteRow" /></td>
                                    <td class="text-center"><?= $i ?></td>
                                    <td class="text-center"><?php echo $item["SaleProductAdditional"]['reference_number']; ?></td>
                                    <td class="text-center"><?php echo !empty($item["SaleProductAdditional"]['sale_date']) ? $this->Html->cvtTanggal($item["SaleProductAdditional"]['sale_date']) : "-"; ?></td>
                                    <td class="text-center" style = "border-right-style:none !important" width = "10">Rp. </td>
                                    <td class="text-right" style = "border-left-style:none !important" width = "75"><?= ic_rupiah($item['SaleProductAdditional']['grand_total']); ?></td>
                                    <td class="text-left"><?= emptyToStrip(@$item['Employee']['Account']['Biodata']['full_name']) ?></td>
                                    <td class="text-left"><?= emptyToStrip(@$item['Purchaser']["Account"]['Biodata']['full_name']) ?></td>
                                    <td class="text-center"><?= emptyToStrip(@$item['PaymentType']['name']) ?></td>
                                    <td class="text-center"><?= $item['PaymentStatus']["name"] ?></td>
                                    <td class="text-center">
                                        <a data-toggle="modal" data-target="#default-view-sale-product-additional" role="button" href="<?= Router::url("/admin/popups/content?content=viewsaleproductadditional&id={$item[Inflector::classify($this->params['controller'])]['id']}") ?>" class="ajax-modal btn btn-default btn-xs btn-icon btn-icon tip" title="Lihat Data"><i class="icon-eye7"></i></a>
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