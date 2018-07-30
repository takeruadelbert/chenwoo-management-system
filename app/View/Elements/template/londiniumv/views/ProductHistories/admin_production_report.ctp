<?php
echo $this->element(_TEMPLATE_DIR . "/{$template}/filter/product_history_report");
?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("LAPORAN HASIL PRODUKSI") ?>
                <div class="pull-right">
                    <button class="btn btn-xs btn-default" type="button" onclick="exp('print', '<?php echo Router::url("production_report/print?" . $_SERVER['QUERY_STRING'], true) ?>')">
                        <i class="icon-print2"></i> 
                        <?= __("Cetak") ?>
                    </button>&nbsp;
                    <button class="btn btn-xs btn-default" type="button" onclick="exp('excel', '<?php echo Router::url("production_report/excel?" . $_SERVER['QUERY_STRING'], true) ?>')">
                        <i class="icon-file-excel"></i>
                        Excel
                    </button>&nbsp;
                </div>
                <small class="display-block"><?= _APP_CORPORATE_FULL ?></small>
            </h6>
        </div>
        <div class="table-responsive stn-table">
            <form id="checkboxForm" method="post" name="checkboxForm" action="<?php echo Router::url('/' . $this->params['prefix'] . '/' . $this->params['controller'] . '/multiple_delete', true); ?>">
                <table width="100%" class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th width="50">No</th>
                            <th><?= __("Nama") ?></th>
                            <th colspan = "2"><?= __("Berat") ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
//                        $limit = intval(isset($this->params['named']['limit']) ? $this->params['named']['limit'] : 10);
//                        $page = intval(isset($this->params['named']['page']) ? $this->params['named']['page'] : 1);
//                        $i = ($limit * $page) - ($limit - 1);
                        if (empty($data['rows'])) {
                            ?>
                            <tr>
                                <td class = "text-center" colspan = 9>Tidak Ada Data</td>
                            </tr>
                            <?php
                        } else {
                            $product_datas = [];
                            foreach ($data['rows'] as $item) {
                                if($product_datas==null){
                                    array_push($product_datas,[$item["Product"]['Parent']['name']." ".$item["Product"]['name'],$item["ProductHistory"]['weight'],$item['Product']['ProductUnit']['name']]);
                                }else{
                                    for($i=0;$i<count($product_datas);$i++){
                                        if($product_datas[$i][0]==$item["Product"]['Parent']['name']." ".$item["Product"]['name']){
                                            $tempWeight = $product_datas[$i][1]+$item["ProductHistory"]['weight'];
                                            $product_datas[$i][1] = $tempWeight;
                                        }else if($i==count($product_datas)-1){
                                            array_push($product_datas,[$item["Product"]['Parent']['name']." ".$item["Product"]['name'],$item["ProductHistory"]['weight'],$item['Product']['ProductUnit']['name']]);
                                        }
                                    }
                                }
                            }
                            $i=1;
                            foreach ($product_datas as $item) {
                                ?>
                                <tr id="row-<?= $i ?>" class="removeRow">
                                    <td class="text-center"><?= $i ?></td>
                                    <td><?php echo $item[0]; ?></td>
                                    <td class="text-right" style = "border-right: none !important"><?php echo $item[1]; ?></td>
                                    <td width = "50" class = "text-center" style = "border-left: none !important"><?php echo $item[2]; ?></td>
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
    <?php //echo $this->element(_TEMPLATE_DIR . "/{$template}/pagination") ?>
</div>