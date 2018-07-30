<?php
echo $this->element(_TEMPLATE_DIR . "/{$template}/filter/sale-package");
?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("DATA PACKAGING") ?>
                <div class="pull-right">
                    <button class="btn btn-xs btn-default" type="button" onclick="exp('print', '<?php echo Router::url("package/print?" . $_SERVER['QUERY_STRING'], true) ?>')">
                        <i class="icon-print2"></i> 
                        <?= __("Cetak") ?>
                    </button>&nbsp;
                    <button class="btn btn-xs btn-default" type="button" onclick="exp('excel', '<?php echo Router::url("package/excel?" . $_SERVER['QUERY_STRING'], true) ?>')">
                        <i class="icon-file-excel"></i>
                        Excel
                    </button>&nbsp;
                    <?= $this->element(_TEMPLATE_DIR . "/{$template}/roleaccess/delete") ?>
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
                            <th><?= __("Pembeli") ?></th>
                            <th><?= __("Nomor PO") ?></th>
                            <th><?= __("Nomor Penjualan") ?></th>
                            <th><?= __("Waktu Penginputan Penjualan ") ?></th>
                            <th colspan = 2><?= __("Jumlah Permintaan MC") ?></th>
                            <th colspan = 2><?= __("Jumlah Permintaan Berat") ?></th>
                            <th colspan = 2><?= __("MC Terpenuhi") ?></th>
                            <th colspan = 2><?= __("Berat Terpenuhi") ?></th>
                            <?php
                            if ($stnAdmin->branchPrivilege()) {
                                ?>
                                <th><?= __("Cabang") ?></th>
                                <?php
                            }
                            ?>
                            <th><?= __("Status") ?></th>
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
                                <td class = "text-center" colspan = "17">Tidak Ada Data</td>
                            </tr>
                            <?php
                        } else {
                            foreach ($data['rows'] as $item) {
                                $requestedMC = array_sum(array_column($item["SaleDetail"], "quantity"));
                                $requestedWeight = array_sum(array_column($item["SaleDetail"], "nett_weight"));
                                $fulFilledMC = array_sum(array_column($item["SaleDetail"], "quantity_production"));
                                $fulFilledWeight = array_sum(array_column($item["SaleDetail"], "fulfill_weight"));
                                ?>
                                <tr id="row-<?= $i ?>" class="removeRow<?php echo $item["Sale"]['id']; ?>">
                                    <td class="text-center"><input type="checkbox" name="data[<?php echo Inflector::classify($this->params['controller']) ?>][checkbox][]" value="<?php echo $item["Sale"]['id']; ?>"  id="checkBoxRow" class="styled checkboxDeleteRow" /></td>
                                    <td class="text-center"><?= $i ?></td>
                                    <td class="text-center"><?php echo $item['Buyer']['company_name']; ?></td>
                                    <td class="text-center"><?php echo $item['Sale']['po_number']; ?></td>
                                    <td class="text-center"><?php echo $item['Sale']['sale_no']; ?></td>
                                    <td class="text-center"><?php echo $this->Html->cvtWaktu($item["Sale"]['created'], false); ?></td>
                                    <td class="text-right"><?php echo ic_decimalseperator($requestedMC); ?></td>
                                    <td class="text-right" width = 30> MC</td>
                                    <td class="text-right"><?php echo ic_kg($requestedWeight); ?> </td>
                                    <td class="text-right" width = 30> Kg</td>
                                    <td class="text-right"><span class="label label-<?= $fulFilledMC < $requestedMC ? "danger" : "success" ?>"><?= ic_decimalseperator($fulFilledMC); ?></span></td>
                                    <td class="text-right" width = 30> MC</td>
                                    <td class="text-right"><span class="label label-<?= $fulFilledWeight < $requestedWeight ? "danger" : "success" ?>"><?= ic_kg($fulFilledWeight); ?></span></td>
                                    <td class="text-right" width = 30> Kg</td>
                                    <?php
                                    if ($stnAdmin->branchPrivilege()) {
                                        ?>
                                        <td class="text-left"><?php echo $item["BranchOffice"]['name']; ?></td>
                                        <?php
                                    }
                                    ?>
                                    <td class="text-center"><span class="label label-<?= $item["Sale"]["packaging_status_id"] == 1 ? "danger" : "success" ?>"><?= $item["PackagingStatus"]["name"]; ?></span></td>
                                    <td class="text-center">
                                        <a data-toggle="modal" href="<?= Router::url("/admin/popups/content?content=viewsalepackage&id={$item["Sale"]["id"]}") ?>" data-target="#default-ajax-modal"><button type="button" class="btn btn-default btn-xs btn-icon tip" title="Lihat Data Penjualan"><i class="icon-eye7"></i></button></a>
                                        <a target="_blank" href="<?= Router::url("/admin/package_details/view_package?sale_id={$item[Inflector::classify($this->params['controller'])]['id']}&type=packaging") ?>"><button type="button" class="btn btn-default btn-xs btn-icon tip" title="Lihat Data Paket"><i class="icon-cube"></i></button></a>
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