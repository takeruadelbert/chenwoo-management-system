<?php
echo $this->element(_TEMPLATE_DIR . "/{$template}/filter/cooperative-entries");
?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("DATA KEUNTUNGAN PENJUALAN PRODUK TAMBAHAN") ?>
                <div class="pull-right">
                    <button class="btn btn-xs btn-default" type="button" onclick="exp('print', '<?php echo Router::url("sale_product_additional_list/print?" . $_SERVER['QUERY_STRING'], true) ?>')">
                        <i class="icon-print2"></i> 
                        <?= __("Cetak") ?>
                    </button>&nbsp;
                    <button class="btn btn-xs btn-default" type="button" onclick="exp('excel', '<?php echo Router::url("sale_product_additional_list/excel?" . $_SERVER['QUERY_STRING'], true) ?>')">
                        <i class="icon-file-excel"></i>
                        Excel
                    </button>
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
                            <th><?= __("Nomor Penjualan") ?></th>
                            <th><?= __("Penanggungjawab") ?></th>
                            <th><?= __("Nama Kas Koperasi") ?></th>
                            <th><?= __("Nama Pembeli") ?></th>
                            <th colspan="2"><?= __("Keuntungan yang Didapat") ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $limit = intval(isset($this->params['named']['limit']) ? $this->params['named']['limit'] : 10);
                        $page = intval(isset($this->params['named']['page']) ? $this->params['named']['page'] : 1);
                        $i = ($limit * $page) - ($limit - 1);
                        $grandTotal = 0;
                        if (empty($data['rows'])) {
                            ?>
                            <tr>
                                <td class = "text-center" colspan = 7>Tidak Ada Data</td>
                            </tr>
                            <?php
                        } else {
                            foreach ($data['rows'] as $item) {
                                $grandTotal += $item['CooperativeTransactionMutation']['nominal'];
                                ?>
                                <tr>
                                    <td class="text-center"><?= $i ?></td>
                                    <td class="text-center">
                                        <a data-toggle="modal" href="<?= Router::url("/admin/popups/content?content=viewsaleproductadditional&id={$item["CooperativeTransactionMutation"]['SaleProductAdditional']["id"]}") ?>" data-target="#default-view-sale-product-additional"><?= $item["CooperativeTransactionMutation"]['SaleProductAdditional']["reference_number"] ?></a>
                                    </td>
                                    <td class="text-center"><?= $item['CooperativeTransactionMutation']['SaleProductAdditional']['Employee']['Account']['Biodata']['full_name'] ?></td>
                                    <td class="text-center"><?= $item['CooperativeTransactionMutation']['CooperativeCash']['name'] ?></td>
                                    <td class="text-center"><?= $item['CooperativeTransactionMutation']['SaleProductAdditional']['Purchaser']['Account']['Biodata']['full_name'] ?></td>
                                    <td class="text-center" style = "border-right-style:none !important" width = "50">Rp. </td>
                                    <td class="text-right" style = "border-left-style:none !important" width = "150"><?= ic_rupiah($item['CooperativeTransactionMutation']['nominal']) ?></td>
                                </tr>
                                <?php
                                $i++;
                            }
                        }
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="5" class="text-right"><strong>Total Keuntungan</strong></td>
                            <td class="text-center" style = "border-right-style:none !important" width = "50">Rp. </td>
                            <td class="text-right" style = "border-left-style:none !important" width = "150"><strong><?= ic_rupiah($grandTotal) ?></strong></td>
                        </tr>
                    </tfoot>
                </table>
            </form>
        </div>
    </div>
    <?php echo $this->element(_TEMPLATE_DIR . "/{$template}/pagination") ?>
</div>