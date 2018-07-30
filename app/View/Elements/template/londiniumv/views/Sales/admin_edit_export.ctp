<?php echo $this->Form->create("Sale", array("class" => "form-horizontal form-separate", "action" => "edit_export", "type" => "file", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="tab-pane active fade in" id="data-utama">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="block-inner text-danger">
                <h6 class="heading-hr"><?= __("Ubah Penjualan Produk Eksport") ?>
                    <small class="display-block">Mohon Isikan Dengan Sesuai dan Benar</small>
                </h6>
            </div>
            <div class="well block">
                <div class="tabbable">
                    <ul class="nav nav-pills nav-justified">
                        <li class="active"><a href="#justified-pill1" data-toggle="tab"><i class="icon-mail-send"></i> Data Penjualan Produk</a></li>
                        <li><a href="#justified-pill3" data-toggle="tab"><i class="icon-file6"></i> Dokumen Penjualan Produk </a></li>
                    </ul>
                    <div class="tab-content pill-content">
                        <div class="tab-pane fade in active" id="justified-pill1">
                            <div>
                                <div class="form-group">
                                    <?php
                                    echo $this->Form->label("Sale.po_number", __("Nomor PO"), array("class" => "col-md-2 control-label"));
                                    echo $this->Form->input("Sale.po_number", array("div" => array("class" => "col-md-4"), "label" => false, "class" => "form-control"));
                                    ?>
                                </div>    
                            </div>
                            <div>
                                <div class="form-group">
                                    <?php
                                    echo $this->Form->label("Sale.buyer_id", __("Pembeli"), array("class" => "col-md-2 control-label"));
                                    echo $this->Form->input("Sale.buyer_id", array("div" => array("class" => "col-md-4"), "empty" => "", "label" => false, "options" => $buyerExports, "class" => "select-full", "placeholder" => "-- Pilih Pembeli --"));
                                    ?>
                                    <?php
                                    echo $this->Form->label("Sale.due_date", __("Tanggal Jatuh Tempo"), array("class" => "col-md-2 control-label"));
                                    echo $this->Form->input("Sale.due_date", array("div" => array("class" => "col-md-4"), "empty" => "", "label" => false, "type" => "text", "class" => "form-control datepicker"));
                                    ?>
                                </div>    
                            </div>
                            <div>
                                <div class="form-group">
                                    <?php
                                    echo $this->Form->label("Sale.shipment_payment_type_id", __("Tipe Pembayaran Shipment"), array("class" => "col-md-2 control-label"));
                                    echo $this->Form->input("Sale.shipment_payment_type_id", array("div" => array("class" => "col-md-4"), "empty" => "", "label" => false, "class" => "select-full", "placeholder" => "-- Pilih Tipe Pembayaran Shipment --"));
                                    ?>
                                    <div class="col-sm-2 control-label label-required">
                                        <label>Biaya Pengiriman</label>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="input-group">
                                            <span class="input-group-btn">
                                                <button class="btn btn-default" type="button">$</button>
                                            </span>
                                            <input type="text" class="form-control text-right" name="data[Sale][shipping_cost]" value="<?= !empty($this->data['Sale']['shipping_cost']) ? $this->data['Sale']['shipping_cost'] : "" ?>">
                                        </div>
                                    </div>
                                </div>    
                            </div>
                            <div>
                                <div class="form-group">
                                    <div class="col-sm-2 control-label label-required">
                                        <label>Kurs</label>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="input-group">
                                            <span class="input-group-btn">
                                                <button class="btn btn-default" type="button">Rp</button>
                                            </span>
                                            <input type="text" class="form-control text-right" name="data[Sale][exchange_rate]" required="required" value = <?= !empty($this->data['Sale']['exchange_rate']) ? $this->data['Sale']['exchange_rate'] : $this->Html->getExchangeRate(1, "USD", "IDR") ?>>
                                            <span class="input-group-btn">
                                                <button class="btn btn-default" type="button">,00.</button>
                                            </span>
                                        </div>
                                    </div>
                                </div>    
                            </div>
                            <div class="pre-scrollable stn-table stn-table-nowrap">
                                <table width="100%" class="table table-hover table-bordered stn-table">
                                    <thead>
                                        <tr>
                                            <th width="50" style="text-align: center;">No</th>
                                            <th width="230" style="text-align: center;min-width:150px">Nama Produk</th>
                                            <th width="170" style="min-width:150px">Kode Produk Buyer</th>
                                            <th width="130" style="text-align: center;min-width:125px">Jumlah Produk (MC)</th>
                                            <th width="125" style="text-align: center;min-width:150px">Isi Per MC</th>
                                            <th width="100" style="text-align: center;min-width:150px">Jumlah (Kg)</th>
                                            <th width="100" style="text-align: center;min-width:150px">Jumlah (Lbs)</th>
                                            <th width="150" style="text-align: center;min-width:125px">Harga Produk ($ / Lbs)</th>
                                            <th width="150" style="text-align: center;min-width:150px">Total</th>
                                            <th width="50" style="text-align: center;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="target-product-data">

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="10">
                                                <a class="text-success firstrunclick"  href="javascript:void(false)" onclick="addThisRow(this, 'product-data', '')" data-n="1"><i class="icon-plus-circle"></i></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="8" align="right">
                                                <strong>Grand Total</strong>
                                            </td>
                                            <td colspan="1">
                                                <div class="input-group">
                                                    <span class="input-group-addon">$</span>
                                                    <input type="text" class="form-control text-right auto-calculate-grand-total-produk-data" id="GrandTotal" name="data[Sale][grand_total]" readonly>
                                                </div>
                                            </td>
                                            <td></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div> 
                        </div>                    
                        <div class="tab-pane fade" id="justified-pill3">
                            <table class="table table-hover table-bordered stn-table" width="100%">
                                <thead>
                                    <tr>
                                        <th width="3%">No</th>
                                        <th width="25%">File</th>
                                        <th width="3%">Aksi</th>
                                    </tr>
                                <thead>
                                <tbody id="target-detail-kas-keluar" class = "tbody">
                                    <tr>
                                        <td colspan="3">
                                            <a class="text-success dataN0" href="javascript:void(false)" onclick="addThisRows($(this), 'detail-kas-keluar', 'anakOptionss')" data-n="0"><i class="icon-plus-circle"></i></a>
                                        </td>
                                        <?php
                                        $index = 1;
                                        if(!empty($this->data['SaleDetail'])) {
                                            foreach ($this->data['SaleDetail'] as $saleDetails) {
                                        ?>
                                        <input type="hidden" name="data[SaleDetail][<?= $index ?>][id]" value="<?= $saleDetails['id'] ?>">
                                        <?php
                                                $index++;
                                            }
                                        }
                                        ?>
                                    </tr>
                                </tbody>
                            </table>
                        </div>                 
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <div class="form-actions text-center">
                <input name="Button" type="button" onclick="history.go(-1);" class="btn btn-success" value="<?= __("Kembali") ?>">
                <input type="reset" value="Reset" class="btn btn-info">
                <button class="btn btn-danger" data-toggle="modal" data-target="#add" type="button" href="<?php echo Router::url('/admin/popups/content?content=confirm_add', true); ?>">
                    <?= __("Simpan") ?>
                </button>
            </div>
        </div>
    </div>
</div>
<?php echo $this->Form->end() ?>
<?php
$listProduct = [];
foreach ($dataProduct as $product) {
    $childs = [];
    foreach ($product["Child"] as $child) {
        $childs[] = [
            "id" => $child["id"],
            "label" => $product["Product"]["name"] . " " . $child["name"],
            "price" => $child["price_usd"],
        ];
    }
    $listProduct[] = [
        "id" => $product["Product"]["id"],
        "label" => $product["Product"]["name"],
        "child" => $childs,
    ];
}
$listMcWeight = [];
foreach ($dataMcWeight as $mcWeight) {
    $listMcWeight[] = [
        "value" => $mcWeight["McWeight"]["id"],
        "label" => $mcWeight["McWeight"]["label_lbs"],
        "kg" => $mcWeight["McWeight"]["kg"],
        "lbs" => $mcWeight["McWeight"]["lbs"],
    ];
}

?>
<script>
    var count = 0;
    var data_product = <?= json_encode($listProduct) ?>;
    var data_mcweight =<?= json_encode($listMcWeight) ?>;
    var data_sale_detail = <?= json_encode($this->data['SaleDetail']) ?>;
    $(document).ready(function () {
        for (var i = 0; i < data_sale_detail.length; i++) {
            addThisRow(".firstrunclick", 'product-data', '');
            $("#SaleDetail" + (i + 1) + "Price").select2().select2('val', data_sale_detail[i]['Product']['id']);
            $("#SaleDetail" + (i + 1) + "ItemCode").val(data_sale_detail[i]['item_code']);
            $("#SaleDetail" + (i + 1) + "Quantity").val(data_sale_detail[i]['quantity']);
            $("#mcweight" + (i + 1)).select2().select2('val', data_sale_detail[i]['mc_weight_id']);
            $("#SaleDetail" + (i + 1) + "ProductPrice").val(data_sale_detail[i]['price']);
            var kg = $("#mcweight" + (i + 1)).select2().find(":selected").data("kg");
            var lbs = $("#mcweight" + (i + 1)).select2().find(":selected").data("lbs");
            $("#SaleDetail" + (i + 1) + "NettWeight").val(ac_dollar(data_sale_detail[i]['quantity'] * kg));
            $("#lbs" + (i + 1)).val(data_sale_detail[i]['quantity'] * lbs);
            var total = data_sale_detail[i]['quantity'] * lbs * data_sale_detail[i]['price'];
            $("#SaleDetail" + (i + 1) + "Total").val(total.toFixed(2));
            updateTotal(i);
        }
    });
    function listenerSelectProduct() {
        $(".selectProduct").select(function () {
            var id = $(this).select2('data').element[0].attributes[2].nodeValue;
            var price = $(this).select2('data').element[0].attributes[1].nodeValue;
            $(".SaleDetail" + id + "Price").val(price);
        });
    }

    function listenerProduk(e, n) {
    }

    String.prototype.replaceAll = function (find, replace) {
        var str = this;
        return str.replace(new RegExp(find.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&'), 'g'), replace);
    };

    function deleteThisRow(e) {
        var tbody = $(e).parents("tbody");
        var n = $(".dataN0").data("n");
        e.parents("tr").remove();
        count--;
        fixNumber(tbody);
        updateTotal(n);
    }

    function fixNumber(e) {
        var i = 1;
        $.each(e.find("tr.dynamic-row").not(".hidden"), function () {
            $(this).find(".nomorIdx").html(i);
            $(this).find(".product_id").attr("id", "SaleDetail" + i + "Price");
            i++;
        })
    }

    function updateTotal(n) {
        var grandTotal = 0;
        var price = parseFloat($("input.SaleDetail" + n + "Price").val());
        var weight = parseFloat($("#lbs" + n).val());
        var total = price * weight;
        $("input.SaleDetail" + n + "Total").val(total.toFixed(2));
        $.each($(".subtotal"), function () {
            grandTotal += parseFloat($(this).val());
        })
        $("input.auto-calculate-grand-total-produk-data").val(grandTotal);
//        $("input.auto-calculate-grand-total-produk-data").val(ac_dollar(grandTotal));
    }

    function updateJumlahBerat(n) {
        $("#mcweight" + n).on("change", function () {
            var total = 0;
            var total_lbs = 0;
            var kg = $(this).select2().find(":selected").data("kg");
            var mc = $(this).select2().find(":selected").data("lbs");
            if (kg == undefined) {
                kg = 0;
                $("input.SaleDetail" + n + "NettWeight").val(0);
                $("#lbs" + n).val(0);
                $("input.SaleDetail" + n + "Total").val(0);
            }
            if (mc == undefined) {
                mc = 0;
                $("input.SaleDetail" + n + "NettWeight").val(0);
                $("#lbs" + n).val(0);
                $("input.SaleDetail" + n + "Total").val(0);
            }
            var quantity = 0;
            if ($("input.SaleDetail" + n + "Quantity").val() != "") {
                quantity = parseFloat($("input.SaleDetail" + n + "Quantity").val().replace(".", ""));
            }
            $thisTotal = ic_number_reverse(ic_kg(quantity * kg));
            total = $thisTotal;
            $thisTotalLbs = quantity * mc;
            total_lbs = $thisTotalLbs;
            $("input.SaleDetail" + n + "NettWeight").val(total);
            $("#lbs" + n).val(total_lbs);
            updateTotal(n);
        });
        $("input.SaleDetail" + n + "Quantity").on("change keyup", function () {
            var total = 0;
            var total_lbs = 0;
            var kg = $("#mcweight" + n).select2().find(":selected").data("kg");
            var mc = $("#mcweight" + n).select2().find(":selected").data("lbs");
            var quantity = parseFloat($(this).val().replace(".", ""));
            if (kg == '' && kg == null) {
                kg = 0;
            }
            if (mc == '' && mc == null) {
                mc = 0;
            }
            $thisTotal = ic_number_reverse(ic_kg(quantity * kg));
            total = $thisTotal;
            $thisTotalLbs = (quantity * mc);
            total_lbs = $thisTotalLbs;
            $("input.SaleDetail" + n + "NettWeight").val(total);
            $("#lbs" + n).val(total_lbs);
            updateTotal(n);
        });
    }

    function addThisRow(e, t, optFunc) {
        var n = $(e).data("n");
        var template = $('#tmpl-' + t).html();
        Mustache.parse(template);
        var options = {i: 2, n: n, data_product: data_product, data_mcweight: data_mcweight};
        var rendered = Mustache.render(template, options);
        $('#target-' + t).append(rendered);
        $(e).data("n", n + 1);
        fixNumber($('#target-' + t));
        reloadisdecimal();
        reloadSelect2();
        listenerProduk($('#target-' + t).find("tr").last(), n);
        count++;
        listenerSelectProduct();
        updateTotal(n);
        updateJumlahBerat(n);
    }

    function getPrice(product, n) {
        $("input#SaleDetail" + n + "Price").val(data_product[product.options[product.selectedIndex].value]['Child']['price']);
    }

    function addProduct() {
        var list_products = "<select name='data[PackageDetail][" + count + "][product_data_id]' class='form-control' id='PackageData1ProductId'>";
        list_products += "<option value='0'>-Pilih Data Produk-</option>";
        for (i = 0; i < data_product_no.length; i++) {
            list_products += "<option value='" + data_product_no[i] + "'>" + data_product_nama[i] + "</option>";
        }
        list_products += "</select>";
        $("#productList").append("<div class='form-group'><label for='PackageDetail[" + count + "]id' class='col-md-2 control-label'>Nama Data Produk " + count + "</label><div class='col-md-4'>" + list_products + "</div></div>");
        count++;
    }
</script>
<script>
    //this script for upload file
    function deleteThisRows(e) {
        var tbody = $(e).parents("tr");
        tbody.remove();
        var temp = $(".tbody");
        fixNumbers(temp);
    }
    function addThisRows(e, t, optFunc) {
        var n = $(e).data("n");
        var k = $(e).data("k");
        var template = $('#tmpl-' + t).html();
        Mustache.parse(template);
        var options = {
            i: 2,
            n: n,
            k: k
        };
        if (typeof (optFunc) !== 'undefined') {
            $.extend(options, window[optFunc]());
        }
        var rendered = Mustache.render(template, options);
        $('#target-' + t + " tr:last").before(rendered);
        $(e).data("n", n + 1);
        $(e).data("k", k + 1);
        reloadDatePicker();
        reloadSelect2();
        reloadisdecimal()
        fixNumbers($(".tbody"));
    }
    function fixNumbers(e) {
        var i = 1;
        $.each(e.find("tr"), function () {
            $(this).find(".nomorIdxs").html(i);
            i++;
        })
    }
    function anakOptionss() {
        return {
        };
    }
    reloadStyled();
</script>
<script type="x-tmpl-mustache" id="tmpl-product-data">
    <tr class="dynamic-row">
    <td class="text-center nomorIdx">{{n}}</td>
    <td class="text-center">{{list_materials}}
    <select name='data[SaleDetail][{{n}}][product_id]' id="selectProduct" class='select-full product_id selectProduct' onchange="" style="width:100%"> //getPrice(this,{{n}})
    <option value='0'>-Pilih Produk-</option>
    {{#data_product}}
    <optgroup label="{{label}}">
    {{#child}}
    <option value="{{id}}" data-price="{{price}}" data-id="{{n}}">{{label}}</option>
    {{/child}}
    </optgroup>
    {{/data_product}}
    </select>
    </td>
    <td>
    <input type="text" name="data[SaleDetail][{{n}}][item_code]" id='SaleDetail{{n}}ItemCode' class="form-control text-right">                            
    </td>
    <td class="text-center">
    <div class="input-group">
    <input type='text' name='data[SaleDetail][{{n}}][quantity]' class='form-control SaleDetail{{n}}Quantity qtyIdx text-right quantityWeight' id='SaleDetail{{n}}Quantity'/>
    <span class="input-group-addon">MC</span>
    </div>        
    </td>
    <td>
    <select name="data[SaleDetail][{{n}}][mc_weight_id]" class="select-full" id="mcweight{{n}}" style="width:100%;">
    <option value="">- Pilih -</option>
    {{#data_mcweight}}
    <option value="{{value}}" data-kg="{{kg}}" data-lbs="{{lbs}}">{{label}}</option>
    {{/data_mcweight}}
    </select>
    </td>
    <td class="text-center">
    <div class="input-group">
    <input type='text' name='data[SaleDetail][{{n}}][nett_weight]' class='form-control SaleDetail{{n}}NettWeight text-right' id='SaleDetail{{n}}NettWeight' value="0" readonly/>
    <span class="input-group-addon">Kg</span>
    </div>        
    </td>
    <td class="text-center">
    <div class="input-group">
    <input type='text' class='form-control text-right totalLbs' id='lbs{{n}}' value="0" disabled/>
    <span class="input-group-addon">Lbs</span>
    </div>        
    </td>
    <td class="text-center">
    <div class="input-group">
    <span class="input-group-addon">$</span>        
    <input type='text' name="data[SaleDetail][{{n}}][price]" class='form-control SaleDetail{{n}}Price qtyPrice text-right' value="0" id="SaleDetail{{n}}ProductPrice" onkeyup="updateTotal({{n}})"/>
    <div>        
    </td>  
    <td class="text-center">
    <div class="input-group">        
    <span class="input-group-addon">$</span> 
    <input type='text' name="data[SaleDetail][{{n}}][total]" class='form-control SaleDetail{{n}}Total text-right subtotal' value="0" id="SaleDetail{{n}}Total" readonly />
    </div>
    </td>  
    <td align="center">
    <a href="javascript:void(false)" onclick="deleteThisRow($(this))">
    <button type="button" class="btn btn-default btn-xs btn-icon tip" title="Hapus">
    <i class="icon-remove3"></i>
    </button>
    </a>
    </td>    
    </tr>
</script>
<script type="x-tmpl-mustache" id="tmpl-detail-kas-keluar">
    <tr class = "trs">
    <td class="text-center nomorIdxs">
    {{i}}
    </td>
    <td>
    <input type="file" class="form-control" name="data[SaleFile][{{n}}][file]">
    </td>
    <td class="text-center">
    <a href="javascript:void(false)" onclick="deleteThisRows($(this))" class="test"><i class="icon-remove3"></i></a>
    </td>
    </tr>
</script>