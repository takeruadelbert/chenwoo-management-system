<?php
echo $this->element(_TEMPLATE_DIR . "/{$template}/filter/general-entry");
?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("BUKU BESAR") ?>
                <div class="pull-right">
                    <button class="btn btn-xs btn-default" type="button" onclick="exp('print', '<?php echo Router::url("ledger/print?" . $_SERVER['QUERY_STRING'], true) ?>')">
                        <i class="icon-print2"></i> 
                        <?= __("Cetak") ?>
                    </button>&nbsp;
                    <button class="btn btn-xs btn-default" type="button" onclick="exp('excel', '<?php echo Router::url("ledger/excel?" . $_SERVER['QUERY_STRING'], true) ?>')">
                        <i class="icon-file-excel"></i>
                        Excel
                    </button>&nbsp;
                </div>
                <small class="display-block"></small>
            </h6>
        </div>
        <div class="table-responsive pre-scrollable stn-table" style="max-height: 600px;">
            <form id="checkboxForm" method="post" name="checkboxForm" action="<?php echo Router::url('/' . $this->params['prefix'] . '/' . $this->params['controller'] . '/multiple_delete', true); ?>">
                <table width="100%" class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th width = "300"><?= __("Tanggal Transaksi") ?></th>
                            <th width = "450"><?= __("Nomor Referensi") ?></th>
                            <th width = "300"><?= __("Keterangan") ?></th>
                            <th width = "250"><?= __("Debit") ?></th>
                            <th><?= __("Kredit") ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $totalDebit = 0;
                        $totalCredit = 0;
                        if (empty($dataTransactions)) {
                            ?>
                            <tr>
                                <td class = "text-center" colspan = 5>Tidak Ada Data</td>
                            </tr>
                            <?php
                        } else {
                            foreach ($dataTransactions as $item) {
                                ?>
                                <tr>
                                    <td class="text-center"><?= $this->Html->cvtTanggal($item['TransactionMutation']['transaction_date']) ?></td>
                                    <td class="text-center"><?= $item['TransactionMutation']['reference_number'] ?></td>
                                    <td class="text-center"><?= $item['TransactionMutation']['transaction_name'] ?></td>
                                    <td class="text-right">
                                        <?php
                                        if (!empty($item['TransactionMutation']['debit'])) {
                                            $totalDebit += $item['TransactionMutation']['debit'];
                                            echo $this->Html->IDR($item['TransactionMutation']['debit']);
                                        } else {
                                            echo "Rp. 0,-";
                                        }
                                        ?>
                                    </td>
                                    <td class="text-right">
                                        <?php
                                        if (!empty($item['TransactionMutation']['credit'])) {
                                            $totalCredit += $item['TransactionMutation']['credit'];
                                            echo $this->Html->IDR($item['TransactionMutation']['credit']);
                                        } else {
                                            echo "Rp. 0,-";
                                        }
                                        ?>
                                    </td>
                                </tr>                            
                                <?php
                            }
                            ?>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </form>
        </div>

        <br/>
        <table width="100%" class="table table-hover table-bordered">
            <tr bgcolor="#e7fec8">
                <td width = "300" class="text-center"><strong>Saldo Awal</strong></td>
                <td width = "450" class="text-left"><strong><?= !empty($dataTransactions) ? $this->Html->IDR($dataTransactions[0]['TransactionMutation']['initial_balance']) : $this->Html->IDR(0) ?></strong></td>
                <td width = "300" class="text-center"><strong>Total</strong></td>
                <td width = "250" class="text-right"><strong><?= $this->Html->IDR($totalDebit) ?></strong></td>
                <td class="text-right"><strong><?= $this->Html->IDR($totalCredit) ?></strong></td>
            </tr>
            <tr bgcolor="#e7fec8">
                <td class="text-center"><strong>Saldo Akhir</strong></td>
                <td class="text-left">
                    <strong>
                        <?php
                        $reverseDataTransactions = array_reverse($dataTransactions);
                        echo !empty($dataTransactions) ? $this->Html->IDR($reverseDataTransactions[0]['TransactionMutation']['mutation_balance']) : $this->Html->IDR(0);
                        ?>
                    </strong>
                </td>
                <td class="text-center"><strong>Mutasi</strong></td>
                <td class="text-right"><strong><?= $this->Html->IDR($totalDebit - $totalCredit) ?></strong></td>
                <td></td>
            </tr>
        </table>
    </div>
</div>