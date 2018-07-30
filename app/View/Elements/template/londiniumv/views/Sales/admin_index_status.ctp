<?php
echo $this->element(_TEMPLATE_DIR . "/{$template}/filter/sale_status");
?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("PRODUKSI TAHAP 4") ?>
                <div class="pull-right">
                    <button class="btn btn-xs btn-default" type="button" onclick="exp('print', '<?php echo Router::url("index_status/print?" . $_SERVER['QUERY_STRING'], true) ?>')">
                        <i class="icon-print2"></i> 
                        <?= __("Cetak") ?>
                    </button>&nbsp;
                    <button class="btn btn-xs btn-default" type="button" onclick="exp('excel', '<?php echo Router::url("index_status/excel?" . $_SERVER['QUERY_STRING'], true) ?>')">
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
                            <th><?= __("Pembeli") ?></th>
                            <th><?= __("Nomor PO") ?></th>
                            <th><?= __("Nomor Penjualan") ?></th>
                            <th><?= __("Berat Penjualan") ?></th>
                            <th><?= __("Berat Terpenuhi") ?></th>
                            <th><?= __("Tanggal") ?></th>
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
                                <td class = "text-center" colspan = 13>Tidak Ada Data</td>
                            </tr>
                            <?php
                        } else {
                            foreach ($data['rows'] as $item) {
                                $quantitiy = 0;
                                $quantity_production = 0;
                                foreach ($item['SaleDetail'] as $detail) {
                                    $quantitiy = $detail['quantity'];
                                    $quantity_production = $detail['quantity_production'];
                                }
                                ?>
                                <tr id="row-<?= $i ?>" class="removeRow<?php echo $item["Sale"]['id']; ?>">
                                    <td class="text-center"><input type="checkbox" name="data[<?php echo Inflector::classify($this->params['controller']) ?>][checkbox][]" value="<?php echo $item["Sale"]['id']; ?>"  id="checkBoxRow" class="styled checkboxDeleteRow" /></td>
                                    <td class="text-center"><?= $i ?></td>
                                    <td class="text-center"><?php echo $item['Buyer']['company_name']; ?></td>
                                    <td class="text-center"><?php echo $item['Sale']['po_number']; ?></td>
                                    <td class="text-center"><?php echo $item['Sale']['sale_no']; ?></td>
                                    <td class="text-center"><?php echo $quantitiy . " Pcs"; ?></td>
                                    <td class="text-center"><?php echo $quantity_production . " Pcs"; ?></td>
                                    <td class="text-center"><?php echo $this->Html->cvtTanggalWaktu($item["Sale"]['created']); ?></td>
                                    <td class="text-center">
                                        <!--<a href="<? Router::url("/admin/{$this->params['controller']}/print_nota/" . $item["Sale"]['id'], true) ?>" class = ""><button type="button" class="btn btn-default btn-xs btn-icon tip" title="Print Nota"><i class = "icon-print2"></i></button></a> -->
                                        <a data-toggle="modal" data-sale-id="<?= $item["Sale"]['id'] ?>" role="button" href="#default-lihatTransactionEntry" class="btn btn-default btn-xs btn-icon btn-icon tip viewData" title="Lihat Data"><i class="icon-eye7"></i></a>
                                        <?php //$this->element(_TEMPLATE_DIR . "/{$template}/roleaccess/edit", ["editUrl" => Router::url("/admin/{$this->params['controller']}/edit/{$item[Inflector::classify($this->params['controller'])]['id']}")]) ?>
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
<div id="default-lihatTransactionEntry" class="modal fade" tabindex="-1" role="dialog">
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
                        <h6 class="heading-hr">LIHAT DATA PRODUKSI TAHAP 4
                            <small class="display-block"><?= _APP_CORPORATE_FULL ?></small>
                        </h6>
                    </div>
                    <!--Justified pills -->
                    <div class = "well block">
                        <table width = "100%" class = "table table-hover" id = "transactionList">
                            <tr>
                                <td>
                                    <div class = "form-group">
                                        <?php
                                        echo $this->Form->label("Sale.sale_no", __("Nomor Pembelian"), array("class" => "col-sm-3 col-md-3 control-label"));
                                        echo $this->Form->input("Sale.sale_no", array("div" => array("class" => "col-sm-3 col-md-3"), "label" => false, "class" => "form-control", "disabled"));
                                        ?>
                                        <?php
                                        echo $this->Form->label("Sale.po_number", __("Nomor PO"), array("class" => "col-sm-3 col-md-3 control-label"));
                                        echo $this->Form->input("Sale.po_number", array("div" => array("class" => "col-sm-3 col-md-3"), "label" => false, "class" => "form-control", "disabled"));
                                        ?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="form-group">
                                        <?php
                                        echo $this->Form->label("Sale.buyer", __("Pembeli"), array("class" => "col-sm-3 col-md-3 control-label"));
                                        echo $this->Form->input("Sale.buyer", array("div" => array("class" => "col-sm-3 col-md-3"), "label" => false, "class" => "form-control", "disabled"));
                                        ?>
                                    </div>
                                </td>
                            </tr>
                        </table>
                        <div class="panel-heading" style="background:#2179cc">
                            <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Data Kebutuhan Produk") ?></h6>
                        </div>
                        <table width="100%" class="table table-hover table-bordered stn-table">
                            <thead>
                                <tr>
                                    <th width="50">No</th>
                                    <th>Produk</th>
                                    <th>Jumlah MC Pembelian</th>
                                    <th>Jumlah MC Terpenuhi</th>
                                    <th>Total Berat</th>
                                </tr>
                            </thead>
                            <tbody id="target-detail-transaction">
                                <tr class="dynamic-row-sale hidden" data-n="0">
                                </tr>
                            </tbody>
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
            $("tr.transaction-material-data").html("");
            var saleId = $(this).data("sale-id");
            var e = $("tr.dynamic-row-sale");
            $.ajax({
                url: BASE_URL + "admin/sales/view_data_sale/" + saleId,
                type: "GET",
                dataType: "JSON",
                data: {},
                success: function (data) {
                    $("#SaleSaleNo").val(data.Sale.sale_no);
                    $("#SalePoNumber").val(data.Sale.po_number);
                    $("#SaleBuyer").val(data.Buyer.company_name);
                    var emp = data.SaleDetail;
                    var i = 1;
                    $.each(emp, function (index, value) {
                        var product = value.Product.name;
                        var quantity = value.quantity;
                        var quantity_production = value.quantity_production;
                        var weight = value.nett_weight;
                        var n = e.data("n");
                        var template = $('#tmpl-material-data').html();
                        Mustache.parse(template);
                        var options = {i: i, n: n, product: product, quantity: quantity, weight: weight, quantity_production: quantity_production};
                        i++;
                        var rendered = Mustache.render(template, options);
                        $('#target-detail-transaction tr.dynamic-row-sale:last').before(rendered);
                        e.data("n", n + 1);
                    });
                }
            });
        });
    });
</script>
<script type="x-tmpl-mustache" id="tmpl-material-data">
    <tr class="dynamic-row transaction-material-data">
    <td class="text-center nomorIdx">{{i}}</td>
    <td class="text-center">
    <div class="input-group">
    <input name='data[SaleDetail][{{n}}][product_id]' class='form-control' id='SaleDetailProductId' value="{{product}}" readonly>
    </div>
    </td> 
    <td>
    <div class="input-group">            
    <input name='data[SaleDetail][{{n}}][quantity]' class='form-control' id='SaleDetailQuantity' value="{{quantity}}" readonly>
    <span class="input-group-addon"><strong>Pcs</strong></span>
    </div>
    </td>
    <td>
    <div class="input-group">            
    <input name='data[SaleDetail][{{n}}][quantity_production]' class='form-control' id='SaleDetailQuantity' value="{{quantity_production}}" readonly>
    <span class="input-group-addon"><strong>Pcs</strong></span>
    </div>
    </td>
    <td>
    <div class="input-group">            
    <input name='data[SaleDetail][{{n}}][weight]' class='form-control' id='SaleDetailWeight' value="{{weight}}" readonly>
    <span class="input-group-addon"><strong>Kg</strong></span>
    </div>
    </td>
</script>
