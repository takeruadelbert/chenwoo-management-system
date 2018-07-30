<?php
echo $this->element(_TEMPLATE_DIR . "/{$template}/filter/cash-disbursement");
?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("DATA KAS KELUAR") ?>
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
                    <a href="<?= Router::url("/admin/{$this->params['controller']}/add", true) ?>">
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
                            <th width="50"><input type="checkbox" class="styled checkall"/></th>
                            <th width="50">No</th>
                            <th><?= __("Nomor Kas") ?></th>
                            <th><?= __("Nama Pegawai") ?></th>
                            <?php
                            if ($stnAdmin->branchPrivilege()) {
                                ?>
                                <th><?= __("Cabang") ?></th>
                                <?php
                            }
                            ?>
                            <th colspan="2"><?= __("Nominal") ?></th>
                            <th><?= __("Tanggal Dibuat") ?></th>
                            <th><?= __("Tipe Kas") ?></th>
                            <th><?= __("Tipe Transaksi") ?></th>
                            <th><?= __("Keterangan") ?></th>
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
                                <td class = "text-center" colspan = 12>Tidak Ada Data</td>
                            </tr>
                            <?php
                        } else {
                            foreach ($data['rows'] as $item) {
                                $totalDisbursement = 0;
                                ?>
                                <tr id="row-<?= $i ?>" class="removeRow<?php echo $item[Inflector::classify($this->params['controller'])]['id']; ?>">
                                    <td class="text-center"><input type="checkbox" name="data[<?php echo Inflector::classify($this->params['controller']) ?>][checkbox][]" value="<?php echo $item[Inflector::classify($this->params['controller'])]['id']; ?>"  id="checkBoxRow" class="styled checkboxDeleteRow" /></td>
                                    <td class="text-center"><?= $i ?></td>
                                    <td class="text-center"><?= $item['CashDisbursement']['cash_disbursement_number'] ?></td>
                                    <td class="text-center"><?= $item['Creator']['Account']['Biodata']['full_name'] ?></td>
                                    <?php
                                    if ($stnAdmin->branchPrivilege()) {
                                        ?>
                                        <td class="text-left"><?php echo $item["BranchOffice"]['name']; ?></td>
                                        <?php
                                    }
                                    ?>
                                    <td class="text-center" style = "border-right-style:none !important" width = "50"><?= $item['CashDisbursement']['transaction_currency_type_id'] == 1 ? "Rp." : "$" ?> </td>
                                    <td class="text-right" style = "border-left-style:none !important" width = "150">
                                        <?php
                                        foreach ($item['CashDisbursementDetail'] as $details) {
                                            $totalDisbursement += $details['amount'];
                                        }
                                        echo $item['CashDisbursement']['transaction_currency_type_id'] == 1 ? ic_rupiah($totalDisbursement) : ac_dollar($totalDisbursement);
                                        ?>
                                    </td>
                                    <td class="text-center"><?= $this->Html->cvtWaktu($item['CashDisbursement']['created_datetime']) ?></td>
                                    <td class="text-center"><?= $item['InitialBalance']['GeneralEntryType']['name'] ?></td>
                                    <td class="text-center"><?= $item['TransactionCurrencyType']['name'] ?></td>
                                    <td class="text-center"><?= $item['CashDisbursement']['note'] ?></td>
                                    <td class="text-center"> 
                                        <a data-toggle="modal" data-target="#default-view-cash-disbursement" role="button" href="<?= Router::url("/admin/popups/content?content=viewcashdisbursement&id={$item[Inflector::classify($this->params['controller'])]['id']}") ?>" class="ajax-modal btn btn-default btn-xs btn-icon btn-icon tip" title="Lihat Data Kas Keluar"><i class="icon-eye7"></i></a>
                                        <a target="_blank" href="<?= Router::url("/admin/{$this->params['controller']}/print_cash_disbursement_receipt/{$item[Inflector::classify($this->params['controller'])]['id']}", true) ?>" class="btn btn-default btn-xs btn-icon btn-icon tip" title="Print Bukti Kas Keluar"><i class="icon-print2"></i></a>
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