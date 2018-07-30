<?php
echo $this->element(_TEMPLATE_DIR . "/{$template}/filter/product_detail");
?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("DATA HASIL PRODUKSI") ?>
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
                    <?= $this->element(_TEMPLATE_DIR . "/{$template}/roleaccess/add") ?>
                </div>
                <small class="display-block"><?= _APP_CORPORATE_FULL ?></small>
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
                            <th><?= __("PDC") ?></th>
                            <th><?= __("Tanggal Produksi") ?></th>
                            <th colspan = "2"><?= __("Sisa Berat") ?></th>
                            <?php
                            if ($stnAdmin->branchPrivilege()) {
                                ?>
                                <th><?= __("Cabang") ?></th>
                                <?php
                            }
                            ?>
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
                                <td class = "text-center" colspan = 9>Tidak Ada Data</td>
                            </tr>
                            <?php
                        } else {
                            $total=0;
                            foreach ($data['rows'] as $item) {
                                ?>
                                <tr id="row-<?= $i ?>" class="removeRow<?php echo $item["ProductDetail"]['id']; ?>">
                                    <td class="text-center"><input type="checkbox" name="data[<?php echo Inflector::classify($this->params['controller']) ?>][checkbox][]" value="<?php echo $item["ProductDetail"]['id']; ?>"  id="checkBoxRow" class="styled checkboxDeleteRow" /></td>
                                    <td class="text-center"><?= $i ?></td>
                                    <td><?php echo $item['Product']['Parent']['name'] . " " . $item["Product"]['name']; ?></td>
                                    <td class="text-center"><?php echo $item["ProductDetail"]['batch_number']; ?></td>
                                    <td class="text-center"><?php echo $this->Html->cvtTanggal($item["ProductDetail"]['production_date']); ?></td>
                                    <td class="text-right" style = "border-right: none !important"><?php echo $item["ProductDetail"]['remaining_weight']; ?></td>
                                    <td width = "50" class = "text-center" style = "border-left: none !important"><?php echo $item["Product"]["ProductUnit"]['name']; ?></td>
                                    <?php
                                    if ($stnAdmin->branchPrivilege()) {
                                        ?>
                                        <td class="text-left"><?php echo $item["BranchOffice"]['name']; ?></td>
                                        <?php
                                    }
                                    ?>
                                    <td class="text-center"> 
                                        <a data-toggle="modal" data-detail-id="<?= $item[Inflector::classify($this->params['controller'])]['id'] ?>" role="button" href="#default-lihatdetail" class="btn btn-default btn-xs btn-icon btn-icon tip viewData" title="Lihat Data"><i class="icon-eye7"></i></a>
                                        <?= $this->element(_TEMPLATE_DIR . "/{$template}/roleaccess/edit", ["editUrl" => Router::url("/admin/{$this->params['controller']}/edit/{$item[Inflector::classify($this->params['controller'])]['id']}")]) ?>
                                    </td>
                                </tr>
                                <?php
                                $i++;
                                $total+=$item["ProductDetail"]['remaining_weight'];
                            }
                            ?>
                                <tr id="row-<?= $i ?>" class="removeRow<?php echo $item["ProductDetail"]['id']; ?>">
                                    <td colspan="4"></td>
                                    <td>Total</td>
                                    <td class="text-right" style = "border-right: none !important"><?php echo $total; ?></td>
                                    <td width = "50" class = "text-center" style = "border-left: none !important"><?php echo "Kg"; ?></td>
                                    <td colspan="2"></td>
                                </tr>
                            <?php    
                        }
                        ?>
                    </tbody>
                </table>
            </form>
        </div>
    </div>
    <?php echo $this->element(_TEMPLATE_DIR . "/{$template}/pagination") ?>
</div>

<div id="default-lihatdetail" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg-6">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">FORM</h4>
            </div>
            <!-- New invoice template -->
            <div class="panel form-horizontal">
                <div class="panel-body">
                    <div class="block-inner text-danger">
                        <h6 class="heading-hr">LIHAT DATA DETAIL PRODUK
                            <small class="display-block"><?= _APP_CORPORATE_FULL ?></small>
                        </h6>
                    </div>
                    <!-- Justified pills -->
                    <div class="well block">                        
                        <table width="100%" class="table table-hover">
                            <tr>
                                <td>
                                    <div class="form-group">
                                        <?php
                                        echo $this->Form->label("Product.name", __("Produk"), array("class" => "col-sm-3 col-md-4 control-label"));
                                        echo $this->Form->input("Product.name", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled"));
                                        ?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="form-group">
                                        <?php
                                        echo $this->Form->label("ProductDetail.batch_number", __("PDC"), array("class" => "col-sm-3 col-md-4 control-label"));
                                        echo $this->Form->input("ProductDetail.batch_number", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled"));
                                        ?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="form-group">
                                        <?php
                                        echo $this->Form->label("ProductDetail.production_date", __("Tanggal Produksi"), array("class" => "col-sm-3 col-md-4 control-label"));
                                        echo $this->Form->input("ProductDetail.production_date", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control datepicker", "type" => "text", "disabled"));
                                        ?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="form-group">
                                        <?php
                                        echo $this->Form->label("ProductDetail.remaining_weight", __("Sisa Berat"), array("class" => "col-sm-3 col-md-4 control-label"));
                                        ?>
                                        <div class="col-sm-9 col-md-8">
                                            <div class="input-group">
                                                <?php
                                                echo $this->Form->input("ProductDetail.remaining_weight", array("div" => array("class" => ""), "label" => false, "class" => "form-control text-right", "disabled"));
                                                ?>
                                                <span class="input-group-btn">
                                                    <button class="btn btn-default" type="button">Kg</button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>                                
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup Form</button>
            </div>
        </div>
    </div>    
</div>

<script>
    $(document).ready(function () {
        $(".viewData").click(function () {
            var detailId = $(this).data("detail-id");
            $.ajax({
                url: BASE_URL + "product_details/view_data_product_detail/" + detailId,
                type: "GET",
                dataType: "JSON",
                data: {},
                success: function (data) {
                    $("#ProductName").val(data.Product.Parent.name + " " + data.Product.name);
                    $("#ProductDetailBatchNumber").val(data.ProductDetail.batch_number);
                    $("#ProductDetailProductionDate").val(cvtTanggal(data.ProductDetail.production_date));
                    $("#ProductDetailRemainingWeight").val(data.ProductDetail.remaining_weight);
                }
            });
        });
    });
</script>