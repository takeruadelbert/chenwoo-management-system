<?php
echo $this->element(_TEMPLATE_DIR . "/{$template}/filter/transaction_out");
?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("DATA PIUTANG USAHA") ?>
                <div class="pull-right">
                    <button class="btn btn-xs btn-default" type="button" onclick="exp('print', '<?php echo Router::url("account_receivable_product_list/print?" . $_SERVER['QUERY_STRING'], true) ?>')">
                        <i class="icon-print2"></i> 
                        <?= __("Cetak") ?>
                    </button>&nbsp;
                    <button class="btn btn-xs btn-default" type="button" onclick="exp('excel', '<?php echo Router::url("account_receivable_product_list/excel?" . $_SERVER['QUERY_STRING'], true) ?>')">
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
                            <th width="50"><input type="checkbox" class="styled checkall"/></th>
                            <th width="50">No</th>
                            <th><?= __("Nomor Invoice") ?></th>
                            <th><?= __("Tanggal Jatuh Tempo") ?></th>
                            <th colspan = "2"><?= __("Total Hutang") ?></th>
                            <th colspan = "2"><?= __("Sisa Hutang") ?></th>
                            <?php
                            if ($stnAdmin->branchPrivilege()) {
                                ?>
                                <th><?= __("Cabang") ?></th>
                                <?php
                            }
                            ?>
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
                                <tr id="row-<?= $i ?>" class="removeRow<?php echo $item["Sale"]['id']; ?>">
                                    <td class="text-center"><input type="checkbox" name="data[<?php echo Inflector::classify($this->params['controller']) ?>][checkbox][]" value="<?php echo $item["Sale"]['id']; ?>"  id="checkBoxRow" class="styled checkboxDeleteRow" /></td>
                                    <td class="text-center"><?= $i ?></td>
                                    <td class="text-center">
                                        <a data-toggle="modal" data-sale-id="<?= $item["Sale"]['id'] ?>" role="button" href="#default-lihatTransactionEntry" class="tip viewData">
                                            <?= $item['Sale']['sale_no'] ?>
                                        </a>   
                                    </td>
                                    <td class="text-center"><?= $this->Html->cvtTanggal($item['Sale']['due_date']) ?></td>
                                    <?php
                                    if ($item['Buyer']['buyer_type_id'] == 1) {
                                        ?>
                                        <td class = "text-center" style = "border-right-style:none !important" width = "50">Rp. </td>
                                        <td class = "text-right" style = "border-left-style:none !important" width = "150"><?= ic_rupiah($item['Sale']['grand_total']) ?></td>
                                        <td class="text-center" style = "border-right-style:none !important" width = "50">Rp. </td>
                                        <td class="text-right" style = "border-left-style:none !important" width = "150"><?= ic_rupiah($item['Sale']['remaining']) ?></td>
                                        <?php
                                    } else if ($item['Buyer']['buyer_type_id'] == 2) {
                                        ?>
                                        <td class = "text-center" style = "border-right-style:none !important" width = "50">$ </td>
                                        <td class = "text-right" style = "border-left-style:none !important" width = "150"><?= ac_dollar($item['Sale']['grand_total']) ?></td>
                                        <td class="text-center" style = "border-right-style:none !important" width = "50">$ </td>
                                        <td class="text-right" style = "border-left-style:none !important" width = "150"><?= ac_dollar($item['Sale']['remaining']) ?></td>
                                        <?php
                                    }
                                    ?> 
                                    <?php
                                    if ($stnAdmin->branchPrivilege()) {
                                        ?>
                                        <td class="text-left"><?php echo $item["BranchOffice"]['name']; ?></td>
                                        <?php
                                    }
                                    ?>    
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
    <div class="modal-dialog" style = "width :1200px; margin-left:auto; margin-right : auto">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">FORM</h4>
            </div>
            <!-- New invoice template -->
            <div class="panel form-horizontal">
                <div class="panel-body">
                    <div class="block-inner text-danger">
                        <h6 class="heading-hr">LIHAT DATA PENJUALAN PRODUK 
                            <small class="display-block"><?= _APP_CORPORATE_FULL ?></small>
                        </h6>
                    </div>
                    <!-- Justified pills -->
                    <div class="well block">                        
                        <table width="100%" class="table table-hover" id="transactionList">
                            <tr>
                                <td>
                                    <div class="form-group">
                                        <?php
                                        echo $this->Form->label("Sale.sale_no", __("Nomor Pembelian"), array("class" => "col-md-2 control-label"));
                                        echo $this->Form->input("Sale.sale_no", array("div" => array("class" => "col-md-4"), "label" => false, "class" => "form-control", "disabled"));
                                        ?>
                                        <?php
                                        echo $this->Form->label("Sale.po_number", __("Nomor PO"), array("class" => "col-md-2 control-label"));
                                        echo $this->Form->input("Sale.po_number", array("div" => array("class" => "col-md-4"), "label" => false, "class" => "form-control", "disabled"));
                                        ?>
                                    </div>
                                </td>
                            </tr>
                            <tr id = "buyerType1">
                                <td>
                                    <div class="form-group">
                                        <div class="col-md-2 control-label label-required">
                                            <label>Biaya Pengiriman</label>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="input-group">
                                                <span class="input-group-btn">
                                                    <button class="btn btn-default" type="button">Rp</button>
                                                </span>
                                                <input type="text" class="form-control text-right" id="SaleShippingCost" name="data[Sale][shipping_cost]" readonly>
                                                <span class="input-group-btn">
                                                    <button class="btn btn-default" type="button">,00.</button>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-md-2 control-label label-required">
                                            <label>Grand Total</label>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="input-group">
                                                <span class="input-group-btn">
                                                    <button class="btn btn-default" type="button">Rp</button>
                                                </span>
                                                <input type="text" class="form-control text-right" id="SaleGrandTotal" name="data[Sale][grand_total]" readonly>
                                                <span class="input-group-btn">
                                                    <button class="btn btn-default" type="button">,00.</button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                </td>
                            </tr>
                            <tr id = "buyerType2">
                                <td>
                                    <div class="form-group">
                                        <div class="col-sm-2 control-label label-required">
                                            <label>Biaya Pengiriman</label>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="input-group">
                                                <span class="input-group-btn">
                                                    <button class="btn btn-default" type="button">$</button>
                                                </span>
                                                <input type="text" class="form-control text-right" id="SaleShippingCost2" name="data[Sale][shipping_cost]" readonly>
                                            </div>
                                        </div>
                                        <div class="col-sm-2 control-label label-required">
                                            <label>Grand Total</label>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="input-group">
                                                <span class="input-group-btn">
                                                    <button class="btn btn-default" type="button">$</button>
                                                </span>
                                                <input type="text" class="form-control text-right" id="SaleGrandTotal2" name="data[Sale][grand_total]" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="form-group">
                                        <?php
                                        echo $this->Form->label(null, __("Pembeli"), array("class" => "col-md-2 control-label"));
                                        echo $this->Form->input(null, array("div" => array("class" => "col-md-4"), "label" => false, "class" => "form-control", "disabled", "id" => "pembeli"));
                                        ?>
                                        <?php
                                        echo $this->Form->label(null, __("Tipe Pembayaran Shipment"), array("class" => "col-md-2 control-label"));
                                        echo $this->Form->input(null, array("div" => array("class" => "col-md-4"), "label" => false, "class" => "form-control", "disabled", "id" => "shipmentType"));
                                        ?>
                                    </div>
                                </td>
                            </tr>
                        </table>
                        <div class="panel-heading" style="background:#2179cc">
                            <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Data Penjualan") ?></h6>
                        </div>
                        <table width="100%" class="table table-hover table-bordered stn-table" id = "tableType1">
                            <thead>
                                <tr>
                                    <th width="50">No</th>
                                    <th width="250">Produk</th>
                                    <th>Kode Produk</th>
                                    <th colspan="2">Isi Per MC</th>
                                    <th colspan="2">Total Berat</th>
                                    <th colspan="2">Harga Produk (Rp / Kg)</th>
                                    <th colspan="2">Total</th>
                                </tr>
                            </thead>
                            <tbody id="target-detail-transaction1">
                                <tr class="dynamic-row-sale1 hidden" data-n="0">
                                </tr>
                            </tbody>
                        </table>
                        <table width="100%" class="table table-hover table-bordered stn-table" id = "tableType2">
                            <thead>
                                <tr>
                                    <th width="50">No</th>
                                    <th width = "250">Produk</th>
                                    <th>Kode Produk</th>
                                    <th colspan="2">Jumlah Produk (MC)</th>
                                    <th colspan="2">Isi Per MC</th>
                                    <th colspan="2">Jumlah (Lbs)</th>
                                    <th colspan="2">Total Berat</th>
                                    <th colspan="2">Harga Produk ($ / Lbs)</th>
                                    <th colspan="2">Total</th>
                                </tr>
                            </thead>
                            <tbody id="target-detail-transaction2">
                                <tr class="dynamic-row-sale2 hidden" data-n="0">
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
    $("#buyerType1").hide();
    $("#buyerType2").hide();
    $("#tableType1").hide();
    $("#tableType2").hide();
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
                    $("#pembeli").val(data.Buyer.company_name);
                    $("#shipmentType").val(data.ShipmentPaymentType.name);
                    if (data.Buyer.buyer_type_id == 1) {
                        $("#buyerType1").show();
                        $("#buyerType2").hide();
                        var shipping = data.Sale.shipping_cost;
                        $("#SaleShippingCost").val(ic_rupiah(shipping));
                        var grand = data.Sale.grand_total;
                        $("#SaleGrandTotal").val(ic_rupiah(grand));
                        $("#tableType1").show();
                        $("#tableType2").hide();
                        var emp = data.SaleDetail;
                        var i = 1;
                        $.each(emp, function (index, value) {
                            var product = value.Product.name;
                            var parent = value.Product.Parent.name;
                            var weight = ic_kg(value.nett_weight);
                            var price = value.price;
                            var prices = ic_rupiah(price.replace(".00", ""));
                            var item_code = value.item_code;
                            var mc_weight = value.McWeight.lbs;
                            var sub_total = ic_rupiah(value.nett_weight * price);
                            var n = e.data("n");
                            var template = $('#tmpl-material-data1').html();
                            Mustache.parse(template);
                            var options = {i: i, n: n, parent: parent, product: product, weight: weight, prices: prices, item_code: item_code, mc_weight: mc_weight, sub_total: sub_total};
                            i++;
                            var rendered = Mustache.render(template, options);
                            $('#target-detail-transaction1 tr.dynamic-row-sale1:last').before(rendered);
                            e.data("n", n + 1);
                        });
                    } else if (data.Buyer.buyer_type_id == 2) {
                        $("#buyerType1").hide();
                        $("#buyerType2").show();
                        $("#SaleShippingCost2").val(ac_dollar(data.Sale.shipping_cost));
                        $("#SaleGrandTotal2").val(ac_dollar(data.Sale.grand_total));
                        $("#tableType1").hide();
                        $("#tableType2").show();
                        var emp = data.SaleDetail;
                        var i = 1;
                        $.each(emp, function (index, value) {
                            var product = value.Product.name;
                            var parent = value.Product.Parent.name;
                            var quantity = value.quantity;
                            var weight = ic_kg(value.nett_weight);
                            var item_code = value.item_code;
                            var mc_weight = value.McWeight.lbs;
                            var total_lbs = mc_weight * quantity;
                            var price = value.price;
                            var sub_total = ac_dollar(total_lbs * price);
                            var n = e.data("n");
                            var template = $('#tmpl-material-data2').html();
                            Mustache.parse(template);
                            var options = {i: i, n: n, parent: parent, product: product, quantity: ic_nondecimal(quantity), weight: weight, price: ac_dollar(price), sub_total: sub_total, total_lbs: ac_lbs(total_lbs), item_code: item_code, mc_weight: mc_weight};
                            i++;
                            var rendered = Mustache.render(template, options);
                            $('#target-detail-transaction2 tr.dynamic-row-sale2:last').before(rendered);
                            e.data("n", n + 1);
                        });
                    }
                }
            });
        });
    });
</script>
<script type="x-tmpl-mustache" id="tmpl-material-data1">
    <tr class="dynamic-row transaction-material-data">
    <td class="text-center nomorIdx">{{i}}</td>
    <td class="text-left">
    {{parent}} - {{product}}
    </td> 
    <td class="text-center">
    {{item_code}}
    </td> 
    <td class = "text-right" style= "border-right-style:none;">
    {{mc_weight}}
    </td> 
    <td class = "text-left" style= "width:50px; border-left-style:none;">          
    Lbs
    </td> 
    <td class = "text-right" style= "border-right-style:none;">
    {{weight}}
    </td>
    <td class = "text-left" style= "width:50px; border-left-style:none;">
    Kg
    </td>
    <td class = "text-center" style= "width:50px; border-right-style:none;">
    Rp
    </td>
    <td class="text-right" style="border-left-style:none;">  
    {{prices}}
    </td>
    <td class = "text-center" style= "width:50px; border-right-style:none;">
    Rp
    </td>
    <td class="text-right" style="border-left-style:none;">  
    {{sub_total}}
    </td>
    </tr>
</script>

<script type="x-tmpl-mustache" id="tmpl-material-data2">
    <tr class="dynamic-row transaction-material-data">
    <td class="text-center nomorIdx">{{i}}</td>
    <td class="text-left">{{parent}} - {{product}}</td> 
    <td class="text-center">{{item_code}}</td> 
    <td class = "text-right" style="border-right-style:none;">{{quantity}}</td>   
    <td class = "text-left" style= "width:50px; border-left-style:none;">Pcs</td>
    <td class="text-right" style="border-right-style:none;">           
    {{mc_weight}}
    </td> 
    <td class = "text-left" style= "width:50px; border-left-style:none;">
    Lbs
    </td> 
    <td class="text-right" style="border-right-style:none;">     
    {{total_lbs}}
    </td> 
    <td class = "text-left" style= "width:50px; border-left-style:none;">             
    Lbs
    </td>
    <td class="text-right" style="border-right-style:none;">  
    {{weight}}
    </td> 
    <td class = "text-left" style= "width:50px; border-left-style:none;">
    Kg
    </td> 
    <td class="text-center" style= "width:50px; border-right-style:none;"> 
    $
    </td>
    <td class = "text-right" style="border-left-style:none;">
    {{price}}
    </td>
    <td class="text-center" style= "width:50px; border-right-style:none;"> 
    $
    </td>
    <td class = "text-right" style="border-left-style:none;">
    {{sub_total}}
    </td>
    </tr>
</script>

