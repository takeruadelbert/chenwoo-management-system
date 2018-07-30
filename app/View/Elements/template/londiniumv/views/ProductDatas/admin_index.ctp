<?php
echo $this->element(_TEMPLATE_DIR . "/{$template}/filter/produk_data");
?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("Stok Produk") ?>
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
                            <th><?= __("Barcode") ?></th>
                            <th><?= __("Serial") ?></th>
                            <th><?= __("Nama") ?></th>
                            <th><?= __("Status") ?></th>
                            <th><?= __("Jumlah") ?></th>
                            <th><?= __("Tanggal Produksi") ?></th>
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
                                <td class = "text-center" colspan = 13>Tidak Ada Data</td>
                            </tr>
                            <?php
                        } else {
                            foreach ($data['rows'] as $item) {
                                //foreach($item["ProductSize"] as $itemDetail){
                                ?>
                                <tr id="row-<?= $i ?>" class="removeRow<?php echo $item["ProductData"]['id']; ?>">
                                    <td class="text-center"><input type="checkbox" name="data[<?php echo Inflector::classify($this->params['controller']) ?>][checkbox][]" value="<?php echo $item["ProductData"]['id']; ?>"  id="checkBoxRow" class="styled checkboxDeleteRow" /></td>
                                    <td class="text-center"><?= $i ?></td>
                                    <td class="text-center"><span class="isQRcode"><?php echo $item["ProductData"]['serial_number']; ?></span></td>
                                    <td class="text-center"><?php echo $item["ProductData"]['serial_number']; ?></td>
                                    <td class="text-center"><?php echo $item['ProductSize']['Product']['name']." - ".$item['ProductSize']['name']; ?></td>
                                    <td class="text-center"><?php echo $item["ProductStatus"]['name']; ?></td>
                                    <td class="text-center"><?php echo $item['ProductSize']['quantity']." ".$item['ProductSize']["ProductUnit"]["name"]; ?></td>
                                    <td class="text-center"><?php echo $this->Html->cvtTanggalWaktu($item["ProductData"]['created']); ?></td>
                                    <td><a href="<?= Router::url("/admin/{$this->params['controller']}/print_qr_code/{$item[Inflector::classify($this->params['controller'])]['id']}") ?>"><button type="button" class="btn btn-default btn-xs btn-icon tip" title="Print QRCode"><i class="icon-print2"></i></button></a></td>
                                </tr>
                                <?php
                                $i++;
                                //}
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
<script>
$(document).ready(function () {
    toQRcode();
})
</script>
