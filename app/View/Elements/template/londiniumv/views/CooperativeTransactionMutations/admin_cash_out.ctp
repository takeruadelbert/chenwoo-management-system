<?php
echo $this->element(_TEMPLATE_DIR . "/{$template}/filter/cooperative-transaction-mutation_cash_out");
?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("KAS KELUAR") ?>
                <div class="pull-right">
                    <button class="btn btn-xs btn-default" type="button" onclick="exp('print', '<?php echo Router::url("cash_out/print?" . $_SERVER['QUERY_STRING'], true) ?>')">
                        <i class="icon-print2"></i> 
                        <?= __("Cetak") ?>
                    </button>&nbsp;
                    <button class="btn btn-xs btn-default" type="button" onclick="exp('excel', '<?php echo Router::url("cash_out/excel?" . $_SERVER['QUERY_STRING'], true) ?>')">
                        <i class="icon-file-excel"></i>
                        Excel
                    </button>&nbsp;
                    <?= $this->element(_TEMPLATE_DIR . "/{$template}/roleaccess/add", ["addLabel" => "Tambah Pengeluaran", "addUrl" => "/admin/cooperative_cash_outs/selfadd"]) ?>
                </div>
                <small class="display-block"><?= _APP_CORPORATE_FULL ?></small>
            </h6>
        </div>
        <div class="table-responsive pre-scrollable stn-table stn-table-nowrap">
            <form id="checkboxForm" method="post" name="checkboxForm" action="<?php echo Router::url('/' . $this->params['prefix'] . '/' . $this->params['controller'] . '/multiple_delete', true); ?>">
                <table width="100%" class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th width="50">No</th>
                            <th><?= __("Kas Asal") ?></th>
                            <th><?= __("Tipe Transaksi") ?></th>
                            <th><?= __("Nomor Mutasi") ?></th>
                            <th><?= __("Nomor Transaksi") ?></th>
                            <th><?= __("Pegawai Pelaksana") ?></th>
                            <?php
                            if ($stnAdmin->cooperativeBranchPrivilege()) {
                                ?>
                                <th width = "250"><?= __("Cabang") ?></th>
                                <?php
                            }
                            ?>
                            <th><?= __("Waktu Proses") ?></th>
                            <th colspan = "2"><?= __("Nominal") ?></th>
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
                                <td class = "text-center" colspan ="11">Tidak Ada Data</td>
                            </tr>
                            <?php
                        } else {
                            foreach ($data['rows'] as $item) {
                                ?>
                                <tr>
                                    <td class="text-center"><?= $i ?></td>
                                    <td class="text-LEFT"><?= $item['CooperativeCash']['name']; ?></td>
                                    <td class="text-left"><?= $item['CooperativeTransactionType']['name'] ?></td>
                                    <td class="text-center">
                                        <a data-toggle="modal" href="<?= Router::url("/admin/popups/content?content=viewcooptransaction-trns&id={$item["CooperativeTransactionMutation"]["id"]}") ?>" data-target="#default-view-coop-transaction"><?= $item["CooperativeTransactionMutation"]["id_number"] ?></a>
                                    </td>
                                    <td class="text-center"><?= $this->Chenwoo->nomorTransaksiKoperasi($item) ?></td>
                                    <td class="text-left"><?= $item['Employee']['Account']['Biodata']['full_name'] . " ({$item['Employee']['nip']})" ?></td>
                                    <?php
                                    if ($stnAdmin->cooperativeBranchPrivilege()) {
                                        ?>
                                        <td class="text-left"><?php echo $this->Chenwoo->cabangKoperasi($item); ?></td>
                                        <?php
                                    }
                                    ?>
                                    <td class="text-center"><?= $this->Html->cvtWaktu($item['CooperativeTransactionMutation']['transaction_date'], false) ?></td>
                                    <td class="text-center" style = "border-right-style:none !important" width = "50">Rp. </td>
                                    <td class="text-right" style = "border-left-style:none !important" width = "150"><?= $item['CooperativeTransactionMutation']['nominal__ic'] ?></td>
                                    <td class="text-center">
                                        <?php
                                        $transaction_type = "";
                                        $link = "";
                                        $id = "";
                                        if ($item['CooperativeTransactionType']['id'] == 1) { // pinjaman pegawai
                                            $id = $item['CooperativeTransactionMutation']['employee_data_loan_id'];
                                            $link = "employee_data_loans/print_request_loan";
                                        } else if ($item['CooperativeTransactionType']['id'] == 4) { // pembelian kasir
                                            $id = $item['CooperativeTransactionMutation']['cooperative_cash_disbursement_id'];
                                            $link = "cooperative_cash_disbursements/print_cooperative_disbursement_receipt";
                                        } else if ($item['CooperativeTransactionType']['id'] == 3) { // penarikan simpanan
                                            $id = $item['CooperativeTransactionMutation']['employee_data_deposit_id'];
                                            $link = "employee_data_deposits/print_withdrawal";
                                        }
                                        ?>
                                        <a href="<?= Router::url("/admin/$link/$id") ?>" target="_blank"><button type="button" class="btn btn-default btn-xs btn-icon tip" title="Cetak Transaksi <?= $item['CooperativeTransactionType']['name'] ?>"><i class="icon-print"></i></button></a>
                                        <a href="<?= Router::url("/admin/cooperative_transaction_mutations/print_transaction_mutation/{$item[Inflector::classify($this->params['controller'])]['id']}") ?>" target="_blank"><button type="button" class="btn btn-default btn-xs btn-icon tip" title="Cetak Mutasi"><i class="icon-print2"></i></button></a>
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