<?php
echo $this->element(_TEMPLATE_DIR . "/{$template}/filter/debt-list");
?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("DATA HUTANG USAHA") ?>
                <div class="pull-right">
                    <button class="btn btn-xs btn-default" type="button" onclick="exp('print', '<?php echo Router::url("index/print?" . $_SERVER['QUERY_STRING'], true) ?>')">
                        <i class="icon-print2"></i> 
                        <?= __("Cetak") ?>
                    </button>&nbsp;
                    <button class="btn btn-xs btn-default" type="button" onclick="exp('excel', '<?php echo Router::url("index/excel?" . $_SERVER['QUERY_STRING'], true) ?>')">
                        <i class="icon-file-excel"></i>
                        Excel
                    </button>&nbsp;
                </div>
                <small class="display-block">PT. CHENWOOFISHERY - Fisheries Processing Plant -</small>
            </h6>
        </div>
        <div class="table-responsive pre-scrollable stn-table">
            <form id="checkboxForm" method="post" name="checkboxForm" action="<?php echo Router::url('/' . $this->params['prefix'] . '/' . $this->params['controller'] . '/multiple_delete', true); ?>">
                <table width="100%" class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center" width="1%" bgcolor="#FFFFCC" style="color: #000;"><input type="checkbox" class="styled checkall"/></th>
                            <th class="text-center" width="1%" bgcolor="#FFFFCC" style="color: #000;">No</th>
                            <th class="text-center" width="10%" bgcolor="#FFFFCC" style="color: #000;"><?= __("Nomor Transaksi") ?></th>
                            <th class="text-center" width="8%" bgcolor="#FFFFCC" style="color: #000;"><?= __("Total Tagihan") ?></th>
                            <th class="text-center" width="8%" bgcolor="#FFFFCC" style="color: #000;"><?= __("Sisa Tagihan") ?></th>>
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
                                    <td class="text-center"><?= $this->Echo->empty_strip($item['TransactionEntry']['transaction_number']) ?></td>
                                    <td class="text-center"><?= $this->Html->Rp($item['PaymentPurchase']['total_invoice_amount']); ?></td>
                                    <td class="text-center"><?= $this->Html->Rp($item['PaymentPurchase']['remaining']); ?></td>
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