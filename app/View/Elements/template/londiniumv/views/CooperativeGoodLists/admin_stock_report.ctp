<?php
echo $this->element(_TEMPLATE_DIR . "/{$template}/filter/cooperative-good-list");
?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("LAPORAN STOK BARANG KOPERASI") ?>
                <div class="pull-right">
                    <button class="btn btn-xs btn-default" type="button" onclick="exp('print', '<?php echo Router::url("stock_report/print?" . $_SERVER['QUERY_STRING'], true) ?>')">
                        <i class="icon-print2"></i> 
                        <?= __("Cetak") ?>
                    </button>&nbsp;
                    <button class="btn btn-xs btn-default" type="button" onclick="exp('excel', '<?php echo Router::url("stock_report/excel?" . $_SERVER['QUERY_STRING'], true) ?>')">
                        <i class="icon-file-excel"></i>
                        Excel
                    </button>&nbsp;
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
                            <th><?= __("Kode Barang") ?></th>
                            <th><?= __("Barcode Barang") ?></th>
                            <th><?= __("Nama Barang") ?></th>
                            <th><?= __("Kategori Barang") ?></th>
                            <th colspan = "2"><?= __("Stok") ?></th>
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
                                <td class = "text-center" colspan = "7">Tidak Ada Data</td>
                            </tr>
                            <?php
                        } else {
                            foreach ($data['rows'] as $item) {
                                ?>
                                <tr>
                                    <td class="text-center"><?= $i ?></td>                                    
                                    <td class="text-left"><?= $item['CooperativeGoodList']['code'] ?></td>
                                    <td class="text-left"><?= $item['CooperativeGoodList']['barcode'] ?></td>
                                    <td class="text-left"><?= $item['CooperativeGoodList']['name'] ?></td>
                                    <td class="text-left"><?= $item['GoodType']['name'] ?></td>
                                    <td class="text-right" style = "border-right-style:none !important"><?= $item['CooperativeGoodList']['stock_number'] ?></td>
                                    <td class="text-left" style = "border-left-style:none !important" width = "75"><?= $item['CooperativeGoodListUnit']['name'] ?></td>
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