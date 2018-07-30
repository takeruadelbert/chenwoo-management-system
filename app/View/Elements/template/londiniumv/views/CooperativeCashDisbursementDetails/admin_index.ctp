<?php
echo $this->element(_TEMPLATE_DIR . "/{$template}/filter/cooperative-cash-disbursement-detail");
?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("DATA RINCIAN TRANSAKSI PEMBELIAN KOPERASI") ?>
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
                            <th width="10">No</th>
                            <th width="170"><?= __("Nomor Transaksi") ?></th>
                            <th><?= __("Pegawai Pelaksana") ?></th>
                            <?php
                            if ($stnAdmin->cooperativeBranchPrivilege()) {
                                ?>
                                <th width = "250"><?= __("Cabang") ?></th>
                                <?php
                            }
                            ?>
                            <th width="170"><?= __("Tanggal Pembelian") ?></th>
                            <th width="470"><?= __("Nama Barang") ?></th>
                            <th width="100" colspan = "2"><?= __("Jumlah") ?></th>
                            <th colspan="2"><?= __("Harga Satuan") ?></th>
                            <th width="50"><?= __("Diskon") ?></th>
                            <th colspan="2"><?= __("Total Harga") ?></th>
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
                                <td class = "text-center" colspan ="13">Tidak Ada Data</td>
                            </tr>
                            <?php
                        } else {
                            foreach ($data['rows'] as $item) {
                                ?>
                                <tr id="row-<?= $i ?>" class="removeRow<?php echo $item[Inflector::classify($this->params['controller'])]['id']; ?>">
                                    <td class="text-center"><input type="checkbox" name="data[<?php echo Inflector::classify($this->params['controller']) ?>][checkbox][]" value="<?php echo $item[Inflector::classify($this->params['controller'])]['id']; ?>"  id="checkBoxRow" class="styled checkboxDeleteRow" /></td>
                                    <td class="text-center"><?= $i ?></td>
                                    <td class="text-center">
                                        <a data-toggle="modal" data-target="#default-view-coop-transaction" role="button" href="<?= Router::url("/admin/popups/content?content=viewcooptransaction-pmbl&id={$item["CooperativeCashDisbursement"]['id']}") ?>"><?= $item['CooperativeCashDisbursement']['cash_disbursement_number'] ?></a>
                                    </td>
                                    <td class="text-left"><?= $item['CooperativeCashDisbursement']['Creator']['Account']['Biodata']['full_name'] ?></td>
                                    <?php
                                    if ($stnAdmin->cooperativeBranchPrivilege()) {
                                        if (!empty($item['CooperativeCashDisbursement']['branch_office_id'])) {
                                            ?>
                                            <td class="text-left"><?php echo emptyToStrip($item['CooperativeCashDisbursement']["BranchOffice"]['name']); ?></td>
                                            <?php
                                        } else {
                                            ?>
                                            <td class="text-left">-</td>
                                            <?php
                                        }
                                    }
                                    ?>
                                    <td class="text-left"><?= $item['CooperativeCashDisbursement']['created_date__ic'] ?></td>
                                    <td class="text-left"><?= $item['CooperativeGoodList']["name"] ?></td>
                                    <td class="text-right" style = "border-right-style:none !important" ><?= $item['CooperativeCashDisbursementDetail']["quantity"] ?></td>
                                    <td class="text-right" style = "border-left-style:none !important" width = "50"><?= $item['CooperativeGoodList']['CooperativeGoodListUnit']['name'] ?></td>
                                    <td class="text-center" style = "border-right-style:none !important" width = "25">Rp. </td>
                                    <td class="text-right" style = "border-left-style:none !important" width="150"><?= $item['CooperativeCashDisbursementDetail']['amount__ic'] ?></td>
                                    <td class="text-right"><?= $item['CooperativeCashDisbursementDetail']["discount"] ?> %</td>
                                    <td class="text-center" style = "border-right-style:none !important" width = "25">Rp. </td>
                                    <td class="text-right" style = "border-left-style:none !important" width="150"><?= $item['CooperativeCashDisbursementDetail']['total_amount__ic'] ?></td>
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