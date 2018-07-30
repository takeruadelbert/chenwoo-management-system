<?php
echo $this->element(_TEMPLATE_DIR . "/{$template}/filter/produk_stok");
?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("STOK PRODUKSI") ?>
                <div class="pull-right">
                    <button class="btn btn-xs btn-default" type="button" onclick="exp('print', '<?php echo Router::url("stock/print?" . $_SERVER['QUERY_STRING'], true) ?>')">
                        <i class="icon-print2"></i> 
                        <?= __("Cetak") ?>
                    </button>&nbsp;
                    <button class="btn btn-xs btn-default" type="button" onclick="exp('excel', '<?php echo Router::url("stock/excel?" . $_SERVER['QUERY_STRING'], true) ?>')">
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
                            <th><?= __("Nama") ?></th>
                            <th><?= __("Kode") ?></th>
                            <th colspan = "2"><?= __("Berat Produk yang Tersedia") ?></th>
                            <?php
                            if ($stnAdmin->branchPrivilege()) {
                                ?>
                                <th><?= __("Cabang") ?></th>
                                <?php
                            }
                            ?>
                            <th width = "100"><?= __("Aksi") ?></th>
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
                                <td class = "text-center" colspan ="7">Tidak Ada Data</td>
                            </tr>
                            <?php
                        } else {
                            $total=0;
                            foreach ($data['rows'] as $item) {
                                ?>
                                <tr id="row-<?= $i ?>">
                                    <td class="text-center"><?= $i ?></td>
                                    <td><?= $item['Parent']['name'] . " - " . $item["Product"]['name']; ?><?= !empty($item["Product"]['weight']) ? " ({$item["Product"]['weight']} {$item["ProductUnit"]["name"]})" : "" ?></td>
                                    <td class="text-center"><?= $item["Product"]['code']; ?></td>
                                    <td class="text-right"><?= empty($item["Product"]['stock']) ? 0 : ic_kg($item["Product"]['stock']); ?></td>
                                    <td class="text-right" width = "50"><?= $item['ProductUnit']['name'] ?></td>
                                    <?php
                                    if ($stnAdmin->branchPrivilege()) {
                                        ?>
                                        <td class="text-left"><?php echo $item["BranchOffice"]['name']; ?></td>
                                        <?php
                                    }
                                    ?>
                                    <td class = "text-center">
                                        <a data-toggle="modal" href="<?= Router::url("/admin/popups/content?content=detailstockproduksi&id={$item["Product"]["id"]}") ?>" data-target="#default-ajax-modal"><button type="button" class="btn btn-default btn-xs btn-icon tip" title="Lihat Rincian Stok"><i class="icon-eye7"></i></button></a>
                                    </td>
                                </tr>
                                <?php
                                $i++;
                                $total+=$item["Product"]['stock'];
                            }
                            ?>
                                <tr id="row-<?= $i ?>">
                                    <td colspan="2"></td>
                                    <td class="text-right">Total</td>
                                    <td class="text-right" style = "border-right: none !important"><?php echo $total; ?></td>
                                    <td width = "50" class = "text-center" style = "border-left: none !important"><?php echo "Kg"; ?></td>
                                    <td colspan="2"></td>
                                </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </form>
        </div>
    </div>
    <?php echo $this->element(_TEMPLATE_DIR . "/{$template}/pagination") ?>
</div>