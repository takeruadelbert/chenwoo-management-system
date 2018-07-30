<?php
echo $this->element(_TEMPLATE_DIR . "/{$template}/filter/sale-invoice");
?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("KASIR PENJUALAN") ?>
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
                    <a href="<?= Router::url("/admin/{$this->params['controller']}/payment_sale_setup", true) ?>">
                        <button class="btn btn-xs btn-success" type="button">
                            <i class="icon-file-plus"></i>
                            <?= __("Tambah Data") ?>
                        </button>
                    </a>
                </div>
                <small class="display-block"><?= _APP_CORPORATE_FULL ?></small>
            </h6>
        </div>
        <div class="table-responsive pre-scrollable stn-table">
            <form id="checkboxForm" method="post" name="checkboxForm" action="<?php echo Router::url('/' . $this->params['prefix'] . '/' . $this->params['controller'] . '/multiple_delete', true); ?>">
                <table width="100%" class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center nowrap" width="1%"><input type="checkbox" class="styled checkall"/></th>
                            <th class="text-center" width="1%">No</th>
                            <th class="text-center" width="8%"><?= __("Nomor Kwitansi") ?></th>
                            <th class="text-center" width="10%"><?= __("Nomor Invoice") ?></th>
                            <th class="text-center" width="8%" colspan = "2"><?= __("Total Tagihan") ?></th>
                            <th class="text-center" width="8%" colspan="2"><?= __("Sisa Tagihan") ?></th>
                            <th class="text-center nowrap" width="8%" colspan = "2"><?= __("Jumlah Pembayaran") ?></th>
                            <th class="text-center" width="8%"><?= __("Tipe Pembayaran") ?></th>
                            <th class="text-center" width="8%"><?= __("Tipe Kas") ?></th>
                            <th class="text-center" width="8%"><?= __("Tanggal Pembayaran") ?></th>
                            <th><?= __("Nama Pegawai") ?></th>
                            <?php
                            if ($stnAdmin->branchPrivilege()) {
                                ?>
                                <th><?= __("Cabang") ?></th>
                                <?php
                            }
                            ?>
                            <th class="text-center" width="6%" ><?= __("Aksi") ?></th>
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
                                <td class = "text-center" colspan = 16>Tidak Ada Data</td>
                            </tr>
                            <?php
                        } else {
                            foreach ($data['rows'] as $item) {
                                ?>
                                <tr id="row-<?= $i ?>" class="removeRow<?php echo $item[Inflector::classify($this->params['controller'])]['id']; ?>">
                                    <td class="text-center"><input type="checkbox" name="data[<?php echo Inflector::classify($this->params['controller']) ?>][checkbox][]" value="<?php echo $item[Inflector::classify($this->params['controller'])]['id']; ?>"  id="checkBoxRow" class="styled checkboxDeleteRow" /></td>
                                    <td class="text-center"><?= $i ?></td>
                                    <td class="text-left"><?= $this->Echo->empty_strip($item['PaymentSale']['receipt_number']) ?></td>
                                    <td class="text-center"><?= $this->Echo->empty_strip($item['Sale']['sale_no']) ?></td>
                                    <?php
                                    if ($item ['InitialBalance']['currency_id'] == 1) {
                                        ?>
                                        <td class="text-center" style = "border-right-style:none !important" width = "50">Rp </td>
                                        <td class="text-right" style = "border-left-style:none !important" width = "150"><?= ic_rupiah($item['PaymentSale']['total_invoice_amount']); ?></td>
                                        <td class="text-center" style = "border-right-style:none !important" width = "50">Rp </td>
                                        <td class="text-right" style = "border-left-style:none !important" width = "150"><?= ic_rupiah($item['PaymentSale']['remaining']); ?></td>
                                        <td class="text-center" style = "border-right-style:none !important" width = "50">Rp </td>
                                        <td class="text-right" style = "border-left-style:none !important" width = "150"><?= ic_rupiah($item['PaymentSale']['amount']); ?></td>
                                        <?php
                                    } else if ($item ['InitialBalance']['currency_id'] == 2) {
                                        ?>
                                        <td class="text-center" style = "border-right-style:none !important" width = "50">$ </td>
                                        <td class="text-right" style = "border-left-style:none !important" width = "150"><?= ac_dollar($item['PaymentSale']['total_invoice_amount']); ?></td>
                                        <td class="text-center" style = "border-right-style:none !important" width = "50">$ </td>
                                        <td class="text-right" style = "border-left-style:none !important" width = "150"><?= ac_dollar($item['PaymentSale']['remaining']); ?></td>
                                        <td class="text-center" style = "border-right-style:none !important" width = "50">$ </td>
                                        <td class="text-right" style = "border-left-style:none !important" width = "150"><?= ac_dollar($item['PaymentSale']['amount']); ?></td>
                                        <?php
                                    }
                                    ?>
                                    <td class="text-center"><?= $item['PaymentType']['name'] ?></td>
                                    <td class="text-center"><?= $this->Echo->empty_strip($item['InitialBalance']['GeneralEntryType']['name']) ?></td>
                                    <td class="text-center"><?= $this->Html->cvtTanggalWaktu(@$item['PaymentSale']['payment_date'], false) ?></td>
                                    <td class="text-left"><?php echo!empty($item['Employee']['id']) ? $item['Employee']['Account']['Biodata']['full_name'] : "-"; ?></td>
                                    <?php
                                    if ($stnAdmin->branchPrivilege()) {
                                        ?>
                                        <td class="text-left"><?php echo $item["Sale"]["BranchOffice"]['name']; ?></td>
                                        <?php
                                    }
                                    ?>
                                    <td class="text-center">
                                        <a data-toggle="modal" data-target="#default-view-coop-transaction" role="button" href="<?= Router::url("/admin/popups/content?content=viewpaymentsale&id={$item[Inflector::classify($this->params['controller'])]['id']}") ?>"><button type="button" class="btn btn-default btn-xs btn-icon tip" title="Lihat Data"><i class="icon-eye7"></i></button></a>

                                        <?php
                                        if ($item['Sale']['Buyer']['buyer_type_id'] == 1) {
                                            ?> 
                                            <a target = "_blank" href = "<?= Router::url("/admin/{$this->params['controller']}/print_sale_receipt/{$item[Inflector::classify($this->params['controller'])]['id']} ", true) ?>" class = "btn btn-default btn-xs btn-icon btn-icon tip" title = "Cetak Kwitansi Penjualan"><i class = "icon-print2"></i></a>
                                            <?php
                                        } else if ($item['Sale']['Buyer']['buyer_type_id'] == 2) {
                                            ?> 
                                            <a target = "_blank" href = "<?= Router::url("/admin/{$this->params['controller']}/print_sale_receipt_export/{$item[Inflector::classify($this->params['controller'])]['id']} ", true) ?>" class = "btn btn-default btn-xs btn-icon btn-icon tip" title = "Cetak Kwitansi Penjualan"><i class = "icon-print2"></i></a>
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
