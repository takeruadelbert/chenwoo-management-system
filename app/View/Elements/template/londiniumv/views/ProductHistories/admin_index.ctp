<?php
echo $this->element(_TEMPLATE_DIR . "/{$template}/filter/product-history");
?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("HISTORI PRODUK") ?>
                <div class="pull-right">
                    <button class="btn btn-xs btn-default" type="button" onclick="exp('print', '<?php echo Router::url("index/print?" . $_SERVER['QUERY_STRING'], true) ?>')">
                        <i class="icon-print2"></i> 
                        <?= __("Cetak") ?>
                    </button>&nbsp;
                    <button class="btn btn-xs btn-default" type="button" onclick="exp('excel', '<?php echo Router::url("index/excel?" . $_SERVER['QUERY_STRING'], true) ?>')">
                        <i class="icon-file-excel"></i>
                        Excel
                    </button>
                </div>
                <small class="display-block"><?= _APP_CORPORATE_FULL ?></small>
            </h6>
        </div>
        <div class="table-responsive pre-scrollable stn-table">
            <form id="checkboxForm" method="post" name="checkboxForm" action="<?php echo Router::url('/' . $this->params['prefix'] . '/' . $this->params['controller'] . '/multiple_delete', true); ?>">
                <table width="100%" class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th width="50">No</th>
                            <th><?= __("Nomor Referensi") ?></th>
                            <th><?= __("Nama Produk") ?></th>
                            <th colspan="2"><?= __("Berat") ?></th>
                            <th><?= __("Tanggal") ?></th>
                            <th><?= __("Tipe") ?></th>
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
                                <td class = "text-center" colspan = 7>Tidak Ada Data</td>
                            </tr>
                            <?php
                        } else {
                            foreach ($data['rows'] as $item) {
                                ?>
                                <tr>
                                    <td class="text-center"><?= $i ?></td>
                                    <td class="text-center">
                                        <a data-toggle="modal" data-target="#default-view-product-history" role="button" href="<?= Router::url("/admin/popups/content?content=viewproducthistories&id={$item[Inflector::classify($this->params['controller'])]['id']}") ?>">
                                        <?php
                                        if(!empty($item['ProductHistory']['treatment_id'])) {
                                            echo $item['Treatment']['treatment_number'];
                                        } else {
                                            echo $item['Shipment']['shipment_number'];
                                        }
                                        ?>
                                        </a>
                                    </td>
                                    <td class="text-center"><?= $item['Product']['Parent']['name'] . " " . $item['Product']['name'] ?></td>
                                    <td class="text-right" style = "border-right: none !important"><?= ic_kg($item['ProductHistory']['weight']) ?></td>
                                    <td width = "50" class = "text-center">Kg</td>
                                    <td class="text-center"><?= $this->Html->cvtWaktu($item['ProductHistory']['history_datetime']) ?></td>
                                    <td class="text-center"><?= $item['ProductHistoryType']['name'] ?></td>
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