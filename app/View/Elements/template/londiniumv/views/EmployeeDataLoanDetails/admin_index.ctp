<?php
echo $this->element(_TEMPLATE_DIR . "/{$template}/filter/employee-data-loan-detail");
?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("DATA TRANSAKSI ANGSURAN") ?>
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
                            <?= __("Bayar Angsuran") ?>
                        </button>
                    </a>
                </div>
                <small class="display-block"><?= _APP_CORPORATE_FULL ?></small>
            </h6>
        </div>
        <div class="table-responsive pre-scrollable stn-table">
            <form id="checkboxForm" method="post" name="checkboxForm" action="<?php echo Router::url('/' . $this->params['prefix'] . '/' . $this->params['controller'] . '/multiple_delete', true); ?>">
                <table style="width:100%;table-layout: fixed" class="table table-hover table-bordered">
                    <colgroup>
                        <col width="50"/>
                        <col width="50"/>
                        <col width="150"/>
                        <col width="150"/>
                        <col width="150"/>
                        <col width="150"/>
                        <col width="75"/>
                        <col width="25"/>
                        <col width="75"/>
                        <col width="25"/>
                        <col width="75"/>
                        <col width="25"/>
                        <col width="75"/>
                        <col width="100"/>
                        <col width="100"/>
                        <col width="100"/>
                    </colgroup>
                    <thead>
                        <tr>
                            <th><input type="checkbox" class="styled checkall"/></th>
                            <th>No</th>
                            <th><?= __("Nomor Angsuran") ?></th>
                            <th><?= __("Nomor Pinjaman") ?></th>
                            <th><?= __("Pegawai Peminjam") ?></th>                          
                            <th><?= __("Operator Pelaksana") ?></th>                          
                            <th><?= __("Angsuran ke") ?></th>                          
                            <th colspan = "2"><?= __("Total Pinjaman") ?></th>
                            <th colspan = "2"><?= __("Jumlah Pembayaran") ?></th>
                            <th colspan = "2"><?= __("Sisa Pinjaman") ?></th>
                            <th><?= __("Tanggal Jatuh Tempo") ?></th>
                            <th><?= __("Tanggal Bayar") ?></th>
                            <th><?= __("Aksi") ?></th>
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
                                <td class = "text-center" colspan ="16">Tidak Ada Data</td>
                            </tr>
                            <?php
                        } else {
                            foreach ($data['rows'] as $item) {
                                ?>
                                <tr id="row-<?= $i ?>" class="removeRow<?php echo $item[Inflector::classify($this->params['controller'])]['id']; ?>">
                                    <td class="text-center"><input type="checkbox" name="data[<?php echo Inflector::classify($this->params['controller']) ?>][checkbox][]" value="<?php echo $item[Inflector::classify($this->params['controller'])]['id']; ?>"  id="checkBoxRow" class="styled checkboxDeleteRow" /></td>
                                    <td class="text-right"><?= $i ?></td>
                                    <td class="text-center"><?= $item['EmployeeDataLoanDetail']['coop_receipt_number'] ?></td>
                                    <td class="text-center">
                                        <a data-toggle="modal" data-target="#default-view-coop-transaction" role="button" href="<?= Router::url("/admin/popups/content?content=viewcooptransaction-pnju&id={$item["EmployeeDataLoan"]['id']}") ?>">
                                            <?= $item['EmployeeDataLoan']['receipt_loan_number'] ?>
                                        </a>
                                    </td>
                                    <td class="text-left"><?= $item['EmployeeDataLoan']['Employee']['Account']['Biodata']['full_name'] ?></td>
                                    <td class="text-left"><?= emptyToStrip(@$item['Creator']['Account']['Biodata']['full_name']) ?></td>
                                    <td class="text-center"><?= $item['EmployeeDataLoanDetail']['installment_of'] ?></td>
                                    <td class="text-center" style = "border-right-style:none !important">Rp. </td>
                                    <td class="text-right" style = "border-left-style:none !important"><?= $item['EmployeeDataLoan']['total_amount_loan__ic'] ?></td>                                   
                                    <td class="text-center" style = "border-right-style:none !important">Rp. </td>
                                    <td class="text-right" style = "border-left-style:none !important"><?= $item['EmployeeDataLoanDetail']['amount__ic'] ?></td>
                                    <td class="text-center" style = "border-right-style:none !important">Rp. </td>
                                    <td class="text-right" style = "border-left-style:none !important"><?= $item['EmployeeDataLoanDetail']['remaining_loan__ic'] ?></td>
                                    <td class="text-center"><?= $item['EmployeeDataLoanDetail']['due_date__ic'] ?></td>
                                    <td class="text-center"><?= $item['EmployeeDataLoanDetail']['paid_date__ic'] ?></td>
                                    <td class="text-center">
                                        <a data-toggle="modal" data-target="#default-view-coop-transaction" role="button" href="<?= Router::url("/admin/popups/content?content=viewcooptransaction-ansr&id={$item["EmployeeDataLoanDetail"]['id']}") ?>" class="btn btn-default btn-xs btn-icon btn-icon tip ajax-modal" title="" data-original-title="Lihat Transaksi"><i class="icon-eye7"></i></a>
                                        <a target = "_blank" href = "<?= Router::url("/admin/{$this->params['controller']}/print_loan_history/{$item[Inflector::classify($this->params['controller'])]['id']} ", true) ?>" class = "btn btn-default btn-xs btn-icon btn-icon tip" title = "Cetak Kwitansi Angsuran Pinjaman"><i class = "icon-print2"></i></a>
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
