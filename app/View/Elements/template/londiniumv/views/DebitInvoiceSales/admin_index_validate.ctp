<?php
echo $this->element(_TEMPLATE_DIR . "/{$template}/filter/debit-sale-validate");
?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("VALIDASI PENERIMAAN KELEBIHAN") ?>
                <div class="pull-right">
                    <button class="btn btn-xs btn-default" type="button" onclick="exp('print', '<?php echo Router::url("index_validate/print?" . $_SERVER['QUERY_STRING'], true) ?>')">
                        <i class="icon-print2"></i> 
                        <?= __("Cetak") ?>
                    </button>&nbsp;
                    <button class="btn btn-xs btn-default" type="button" onclick="exp('excel', '<?php echo Router::url("index_validate/excel?" . $_SERVER['QUERY_STRING'], true) ?>')">
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
                            <th><?= __("Nomor Penjualan Produk") ?></th>
                            <?php
                            if ($stnAdmin->branchPrivilege()) {
                                ?>
                                <th><?= __("Cabang") ?></th>
                                <?php
                            }
                            ?>
                            <th><?= __("Tipe Kas") ?></th>
                            <th colspan = "2"><?= __("Nominal") ?></th>
                            <th class="text-center" width="250"><?= __("Status Verifikasi") ?></th>
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
                                <td class = "text-center" colspan = 9>Tidak Ada Data</td>
                            </tr>
                            <?php
                        } else {
                            foreach ($data['rows'] as $item) {
                                ?>
                                <tr id="row-<?= $i ?>" class="removeRow<?php echo $item[Inflector::classify($this->params['controller'])]['id']; ?>">
                                    <td class="text-center"><input type="checkbox" name="data[<?php echo Inflector::classify($this->params['controller']) ?>][checkbox][]" value="<?php echo $item[Inflector::classify($this->params['controller'])]['id']; ?>"  id="checkBoxRow" class="styled checkboxDeleteRow" /></td>
                                    <td class="text-center"><?= $i ?></td>
                                    <td class="text-center"><?= $item['Sale']['sale_no'] ?></td>
                                    <?php
                                    if ($stnAdmin->branchPrivilege()) {
                                        ?>
                                        <td class="text-left"><?php echo $item["Sale"]["BranchOffice"]['name']; ?></td>
                                        <?php
                                    }
                                    ?>
                                    <td class="text-center"><?= $this->Echo->empty_strip($item['InitialBalance']['GeneralEntryType']['name']) ?></td>
                                    <?php
                                    if ($item['Sale']['Buyer']['buyer_type_id'] == 2) {
                                        ?>
                                        <td class="text-center" style = "border-right-style:none !important" width = "50">$ </td>
                                        <td class="text-right" style = "border-left-style:none !important" width = "150"><?= ac_dollar($item['DebitInvoiceSale']['amount']) ?></td>
                                        <?php
                                    } else {
                                        ?>
                                        <td class="text-center" style = "border-right-style:none !important" width = "50">Rp.</td>
                                        <td class="text-right" style = "border-left-style:none !important" width = "150"><?= ic_rupiah($item['DebitInvoiceSale']['amount']) ?></td>
                                        <?php
                                    }
                                    ?>
                                    <td class="text-center"  id = "target-change-status<?= $i ?>">
                                        <?php
                                        if ($item['DebitInvoiceSale']['verify_status_id'] == 2) {
                                            echo "Ditolak";
                                        } else if ($item['DebitInvoiceSale']['verify_status_id'] == 3) {
                                            echo "Disetujui";
                                        } else {
                                            echo $this->Html->changeStatusSelect($item['DebitInvoiceSale']['id'], ClassRegistry::init("VerifyStatus")->find("list", array("fields" => array("VerifyStatus.id", "VerifyStatus.name"))), $item['DebitInvoiceSale']['verify_status_id'], Router::url("/admin/debit_invoice_sales/change_status_verify"), "#target-change-status$i");
                                        }
                                        ?>
                                    </td>
                                    <td class="text-center">
                                        <a data-toggle="modal" data-target="#default-view-coop-transaction" role="button" href="<?= Router::url("/admin/popups/content?content=viewdebitinvoice-sale&id={$item[Inflector::classify($this->params['controller'])]['id']}") ?>"><button type="button" class="btn btn-default btn-xs btn-icon tip" title="Tambah Data"><i class="icon-eye7"></i></button></a>
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
