<?php
//echo $this->element(_TEMPLATE_DIR . "/{$template}/filter/package_stok_ready");
?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("Stok Produk Siap Jual") ?>
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
                <small class="display-block"></small>
            </h6>
        </div>
        <div class="table-responsive pre-scrollable stn-table">
            <form id="checkboxForm" method="post" name="checkboxForm" action="<?php echo Router::url('/' . $this->params['prefix'] . '/' . $this->params['controller'] . '/multiple_delete', true); ?>">
                <table width="100%" class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th width="50"><input type="checkbox" class="styled checkall"/></th>
                            <th width="50">No</th>
                            <th><?= __("Nama") ?></th>
                            <th><?= __("Nomor Paket") ?></th>
                            <th><?= __("Berat Produk") ?></th>
                            <th><?= __("Satuan") ?></th>
                            <th><?= __("Status") ?></th>
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
                                <td class = "text-center" colspan = 13>Tidak Ada Data</td>
                            </tr>
                            <?php
                        } else {
                            foreach ($data['rows'] as $item) {
                                foreach ($item['PackageDetail'] as $detail) {
                                ?>
                                <tr id="row-<?= $i ?>" class="removeRow<?php echo $detail['id']; ?>">
                                    <td class="text-center"><input type="checkbox" name="data[<?php echo Inflector::classify($this->params['controller']) ?>][checkbox][]" value="<?php echo $detail['id']; ?>"  id="checkBoxRow" class="styled checkboxDeleteRow" /></td>
                                    <td class="text-center"><?= $i ?></td>
                                    <td><?php echo $detail['Product']['Parent']['name']." ".$detail['Product']['name']; ?></td>
                                    <td class="text-center"><?php echo $detail['package_no']; ?></td>
                                    <td class="text-center"><?php echo $detail['nett_weight']; ?></td>
                                    <td class="text-center"><?php echo $detail['Product']['ProductUnit']['name']; ?></td>
                                    <td class="text-center"><?php echo "Tersedia"; ?></td>
                                </tr>
                                <?php
                                $i++;
                                }
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

