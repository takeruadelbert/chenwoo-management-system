<?php
echo $this->element(_TEMPLATE_DIR . "/{$template}/filter/cooperative-data-transaction");
?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("DATA TRANSAKSI KOPERASI") ?>
                <div class="pull-right">
                    <button class="btn btn-xs btn-default" type="button" onclick="exp('print', '<?php echo Router::url("transaction_data/print?" . $_SERVER['QUERY_STRING'], true) ?>')">
                        <i class="icon-print2"></i> 
                        <?= __("Cetak") ?>
                    </button>&nbsp;
                    <button class="btn btn-xs btn-default" type="button" onclick="exp('excel', '<?php echo Router::url("transaction_data/excel?" . $_SERVER['QUERY_STRING'], true) ?>')">
                        <i class="icon-file-excel"></i>
                        Excel
                    </button>&nbsp;
                </div>
                <small class="display-block"><?= _APP_CORPORATE_FULL ?></small>
            </h6>
        </div>
        <div class="table-responsive pre-scrollable stn-table" style="max-height: 400px;">
            <form id="checkboxForm" method="post" name="checkboxForm" action="<?php echo Router::url('/' . $this->params['prefix'] . '/' . $this->params['controller'] . '/multiple_delete', true); ?>">
                <table width="100%" class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th width="50">No</th>
                            <th width="150"><?= __("Tipe Transaksi") ?></th>
                            <th width="150"><?= __("Nomor Transaksi") ?></th>
                            <th width="200"><?= __("Pegawai Pelaksana") ?></th>
                            <th width="150"><?= __("Waktu Proses") ?></th>
                            <th width="125"><?= __("Kas Asal/Tujuan") ?></th>
                            <th colspan = "2"><?= __("Total Transaksi") ?></th>
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
                                <td class = "text-center" colspan ="9">Tidak Ada Data</td>
                            </tr>
                            <?php
                        } else {
                            foreach ($data['rows'] as $item) {
                                ?>
                                <tr>
                                    <td class="text-center"><?= $i ?></td>
                                    <td class="text-left"><?= $item['CooperativeTransactionType']['name'] ?></td>
                                    <td class="text-center"><?= $this->Chenwoo->nomorTransaksiKoperasi($item) ?></td>
                                    <td class="text-left"><?= $item['Employee']['Account']['Biodata']['full_name'] ?></td>
                                    <td class="text-left"><?= $this->Html->cvtWaktu($item['CooperativeTransactionMutation']['transaction_date']) ?></td>
                                    <td class="text-left"><?= $item['CooperativeCash']['name'] ?></td>
                                    <td class="text-center" style = "border-right-style:none !important" width = "25">Rp. </td>
                                    <td class="text-right" style = "border-left-style:none !important" width = "75"><?= $item['CooperativeTransactionMutation']['nominal__ic'] ?></td>
                                    <td class="text-center">
                                        <?php
                                        $transaction_type = "";
                                        $link = "";
                                        $id = "";
                                        if($item['CooperativeTransactionType']['id'] == 1) { // pinjaman pegawai
                                            $id = $item['CooperativeTransactionMutation']['employee_data_loan_id'];
                                            $link = "employee_data_loans/print_request_loan";
                                        } else if($item['CooperativeTransactionType']['id'] == 4) { // pembelian kasir
                                            $id = $item['CooperativeTransactionMutation']['cooperative_cash_disbursement_id'];
                                            $link = "cooperative_cash_disbursements/print_cooperative_disbursement_receipt";
                                        } else if($item['CooperativeTransactionType']['id'] == 5) { // penjualan kasir
                                            $id = $item['CooperativeTransactionMutation']['cooperative_cash_receipt_id'];
                                            $link = "cooperative_cash_receipts/print_cooperative_cash_receipt";
                                        } else if($item['CooperativeTransactionType']['id'] == 2) { // simpanan pegawai
                                            $id = $item['CooperativeTransactionMutation']['employee_data_deposit_id'];
                                            $link = "employee_data_deposits/print_deposit";
                                        } else if($item['CooperativeTransactionType']['id'] == 3) { // penarikan simpanan
                                            $id = $item['CooperativeTransactionMutation']['employee_data_deposit_id'];
                                            $link = "employee_data_deposits/print_withdrawal";
                                        } else if($item['CooperativeTransactionType']['id'] == 6) { // angsuran pinjaman
                                            $id = $item['CooperativeTransactionMutation']['employee_data_loan_detail_id'];
                                            $link = "employee_data_loan_details/print_loan_history";
                                        }
                                        ?>
                                        <a href="<?= Router::url("/admin/$link/$id") ?>" target="_blank"><button type="button" class="btn btn-default btn-xs btn-icon tip" title="Cetak Transaksi <?= $item['CooperativeTransactionType']['name'] ?>"><i class="icon-print"></i></button></a>
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