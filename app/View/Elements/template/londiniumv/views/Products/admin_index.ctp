<?php
echo $this->element(_TEMPLATE_DIR . "/{$template}/filter/produk");
?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("DATA PRODUK") ?>
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
                            <th><?= __("Kategori Produk") ?></th>
                            <th><?= __("Nama Produk") ?></th>
                            <th><?= __("Label Produk") ?></th>
                            <th><?= __("Satuan") ?></th>
                            <th colspan = "2"><?= __("Harga (USD)") ?></th>
                            <th colspan = "2"><?= __("Harga (Rupiah)") ?></th>
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
                                <td class = "text-center" colspan = "11">Tidak Ada Data</td>
                            </tr>
                            <?php
                        } else {
                            foreach ($data['rows'] as $item) {
                                ?>
                                <tr id="row-<?= $i ?>" class="removeRow<?php echo $item['Product']['id']; ?>">
                                    <td class="text-center"><input type="checkbox" name="data[<?php echo Inflector::classify($this->params['controller']) ?>][checkbox][]" value="<?php echo $item['Product']['id']; ?>"  id="checkBoxRow" class="styled checkboxDeleteRow" /></td>
                                    <td class="text-center"><?= $i ?></td>
                                    <td class="text-center"><?= !empty($item['Product']['parent_id']) ? $item['Parent']['name'] : "-" ?></td>
                                    <td class="text-center"><?php echo $item['Product']['name']; ?></td>
                                    <td class="text-center"><?php echo $item['Product']['name_label']; ?></td>
                                    <td class="text-center"><?= emptyToStrip($item['ProductUnit']['name']); ?></td>
                                    <td class="text-center" style = "border-right-style: none !important" width = "50"><?= !empty($item['Product']['parent_id']) ? "$" : "" ?></td>
                                    <td class="text-right" style = "border-left-style: none !important" width = "80"><?= !empty($item['Product']['parent_id']) ? ac_dollar($item['Product']['price_usd']) : "-" ?></td>
                                    <td class="text-center" style = "border-right-style: none !important" width = "50"><?= !empty($item['Product']['parent_id']) ? "Rp" : "" ?></td>
                                    <td class="text-right" style = "border-left-style: none !important" width = "80"><?= !empty($item['Product']['parent_id']) ? ic_rupiah($item['Product']['price_rupiah']) : "-" ?></td>
                                    <?php
                                    if ($stnAdmin->branchPrivilege()) {
                                        ?>
                                        <td class="text-left"><?php echo $item["BranchOffice"]['name']; ?></td>
                                        <?php
                                    }
                                    ?>
                                    <td class="text-center">
                                        <a data-toggle="modal" data-permit-id="<?= $item[Inflector::classify($this->params['controller'])]['id'] ?>" role="button" href="#default-lihatijin" class="btn btn-default btn-xs btn-icon btn-icon tip viewData" title="Lihat Data"><i class="icon-eye7"></i></a>
                                        <?= $this->element(_TEMPLATE_DIR . "/{$template}/roleaccess/edit", ["editUrl" => Router::url("/admin/{$this->params['controller']}/edit/{$item[Inflector::classify($this->params['controller'])]['id']}")]) ?>
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

<div id="default-lihatijin" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">FORM</h4>
            </div>
            <!-- New invoice template -->
            <div class="panel form-horizontal">
                <div class="panel-body">
                    <div class="block-inner text-danger">
                        <h6 class="heading-hr">LIHAT DATA PRODUK
                            <small class="display-block"><?= _APP_CORPORATE_FULL ?></small>
                        </h6>
                    </div>
                    <!-- Justified pills -->
                    <div class="well block">                        
                        <table width="100%" class="table table-hover">
                            <tr>
                                <td>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-6 ">
                                                <?php
                                                echo $this->Form->label("Product.name", __("Nama Produk"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                echo $this->Form->input("Product.name", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled"));
                                                ?>
                                            </div>
                                            <div class="col-md-6 ">
                                                <?php
                                                echo $this->Form->label("Product.par", __("Kategori"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                echo $this->Form->input("Product.par", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled", "id" => "parent"));
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-6 ">
                                                <?php
                                                echo $this->Form->label("Product.unit", __("Satuan Produk"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                echo $this->Form->input("Product.unit", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled", "id" => "satuan"));
                                                ?>
                                            </div>
                                            <div class="col-md-6 ">
                                                <div class="col-sm-3 col-md-4 control-label">
                                                    <label>Berat</label>
                                                </div>
                                                <div class="col-sm-9 col-md-8">
                                                    <div class="input-group">
                                                        <input type="number" class="form-control text-right" id="weight" disabled name="data[Product][weight]">
                                                        <span class="input-group-addon"><strong>Kg</strong></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>                        
                            <tr>
                                <td>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-6 ">
                                                <?php
                                                echo $this->Form->label("Product.code", __("Kode Produk"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                echo $this->Form->input("Product.code", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled"));
                                                ?>
                                            </div>
                                            <div class="col-md-6 ">
                                                <div class="col-sm-3 col-md-4 control-label">
                                                    <label>Harga</label>
                                                </div>
                                                <div class="col-sm-9 col-md-8">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><strong>$</strong></span>
                                                        <input type="number" class="form-control text-right" id="price" name="data[Product][price]" disabled>
                                                    </div>
                                                </div>
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
            var permitId = $(this).data("permit-id");
            $.ajax({
                url: BASE_URL + "products/view_data_product/" + permitId,
                type: "GET",
                dataType: "JSON",
                data: {},
                success: function (data) {
                    $("#ProductName").val(data.Product.name);
                    if (data.Parent.id != '' && data.Parent.id != null) {
                        $("#parent").val(data.Parent.name);
                    } else {
                        $("#parent").val("-");
                    }
                    $("#satuan").val(data.ProductUnit.name);
                    $("#weight").val(data.Product.weight);
                    $("#ProductCode").val(data.Product.code);
                    $("#ProductCategory").val(data.ProductCategory.name);
                    $("#price").val(data.Product.price);
                }
            });
        });
    });
</script>