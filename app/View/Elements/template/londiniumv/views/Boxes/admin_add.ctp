<?php echo $this->Form->create("Box", array("class" => "form-horizontal form-separate", "action" => "add", "type" => "file", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="tab-pane active fade in" id="data-utama">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="block-inner text-danger">
                <h6 class="heading-hr"><?= __("Tambah Pengepakan Paket Ikan") ?>
                    <small class="display-block">Input pengepakan paket! Mohon Isikan Dengan Sesuai dan Benar</small>
                </h6>
            </div>
            <div class="well block">
                <div>
                    <div class="form-group">
                        <?php
                        echo $this->Form->label("Sale.sale_id", __("Penjualan"), array("class" => "col-md-2 control-label"));
                        echo $this->Form->input("Sale.sale_id", array("div" => array("class" => "col-md-3"), "empty" => "", "placeholder" => "- Pilih Penjualan -", "label" => false, "class" => "select-full"));
                        ?>
                        <div id="detailPurchases" class="col-md-12">

                        </div>
                    </div>
                </div>    
                <div>
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="table-responsive stn-table">
                                <div class="panel-heading" style="background:#2179cc">
                                    <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Produk yang dipaketkan") ?></h6>
                                </div>
                                <br>
                                <table width="100%" class="table table-hover table-bordered">
                                    <thead>
                                    <th width="1%" style="text-align: center;">No</th>
                                    <th width="30%" style="text-align: center;">Nama Paket</th>
                                    <th width="30%" style="text-align: center;">Berat Paket</th>
                                    <th width="5%" style="text-align: center;">Aksi</th>
                                    </thead>
                                    <tbody id="target-product-data">

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                        <tr>
                                            <td colspan="8">
                                                <a class="text-success firstrunclick"  href="javascript:void(false)" onclick="addThisRow(this, 'product-data', '')" data-n="1" id="clickFunction"><i class="icon-plus-circle"></i></a>
                                            </td>
                                        </tr>
                                        <tr align="right">
                                            <td colspan="2">Total</td>
                                            <td>
                                                <span class="input-group" style="">
                                                    <input type="text" class="form-control text-right auto-calculate-grand-total-produk-data" name="data[Box][total_weight]"readonly>
                                                    <span class="input-group-addon">Kg</span>
                                                </span>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
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
$listPackage = [];
foreach ($dataPackage as $package) {
    $listPackage[] = [
        "id" => $package["PackageDetail"]["id"],
        "label" => $package["PackageDetail"]["package_no"] . " - " . $package["Product"]["Parent"]["name"] . " " . $package["Product"]["name"],
    ];
}
?>
<script>
    var count = 1;
    var data_product = <?= json_encode($listPackage) ?>;
    $(document).ready(function () {
        addThisRow(".firstrunclick", 'product-data', '');
    });
    function getDetailPurchase(purchase) {
        var data_purchase = "";
        var buyer = "";
        $.ajax({
            url: BASE_URL + "admin/purchases/get_purchase_list/" + purchase.value,
            type: "GET",
            dataType: "JSON",
            success: function (data) {
                buyer = data[0]['Buyer']['company_name'];
                for (i = 0; i < data[0]['PurchaseDetail'].length; i++) {
                    //alert(data[0]['PurchaseDetail'].length);
                    //data_purchase.push({name:data[0]['PurchaseDetail'][i]['id']});
                    data_purchase += "<p>" + (i + 1) + ". " + data[0]['PurchaseDetail'][i]['ProductSize']['Product']['name'] + " - " + data[0]['PurchaseDetail'][i]['ProductSize']['name'] + " sebanyak " + data[0]['PurchaseDetail'][i]['quantity'] + " " + data[0]['PurchaseDetail'][i]['ProductSize']['ProductUnit']['name'] + "</p>"
                    //alert(data_purchase);
                    //$("#detailPurchases").append("<h3 style='margin-top:20px'>Nama Pembeli: "+buyer+"</h3>"+data_purchase);
                }
                ;
                $("#detailPurchases").append("<h3 style='margin-top:20px'>Nama Pembeli: " + buyer + "</h3>" + data_purchase);
            }
        });
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

    function listenerProduk(e, n) {
    }

    String.prototype.replaceAll = function (find, replace) {
        var str = this;
        return str.replace(new RegExp(find.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&'), 'g'), replace);
    };

    function deleteThisRow(e) {
        var tbody = $(e).parents("tbody");
        e.parents("tr").remove();
        count--;
        //$("input.ParameterEmployeeSalaryNominalDebt").trigger("change");
        fixNumber(tbody);
    }

    function fixNumber(e) {
        var i = 1;
        $.each(e.find("tr.dynamic-row").not(".hidden"), function () {
            $(this).find(".nomorIdx").html(i);
            //$(this).find(".product_size_id").attr("id","PurchaseDetail"+i+"Price");
            i++;
        })
    }

    function updateTotal() {
        var total = 0;
        $('input.TotalMaterial').each(function () {
            $thisGrandTotalDebt = String($(this).val());
            total += parseInt($thisGrandTotalDebt);
        });
        $("input.auto-calculate-grand-total-produk-data").val(total);
    }

    function addThisRow(e, t, optFunc) {
        var n = $(e).data("n");
        var template = $('#tmpl-' + t).html();
        Mustache.parse(template);
//        var list_produk = products;
//        var list_produk_size = productSizes;
        var options = {i: 2, n: n, data_product: data_product};
//        if (typeof (optFunc) !== 'undefined') {
//            $.extend(options, window[optFunc]());
//        }
        var rendered = Mustache.render(template, options);
        $('#target-' + t).append(rendered);
        $(e).data("n", n + 1);
        fixNumber($('#target-' + t));
        reloadisdecimal();
        reloadSelect2();
        listenerProduk($('#target-' + t).find("tr").last(), n);
        count++;
    }
</script>
<script type="x-tmpl-mustache" id="tmpl-product-data">
    <tr class="dynamic-row">
    <td class="text-center nomorIdx">{{n}}</td>
    <td class="text-center">
    <select name='data[BoxDetail][{{n}}][package_detail_id]' class='select-full package_detail_id'>
    <option value='0'>-Pilih Produk-</option>
    {{#data_product}}
    <option value="{{id}}">{{label}}</option>
    {{/data_product}}
    </select>
    </td>
    <td>
    <span class="input-group" style="">
    <input type='text' id='BoxDetail{{n}}Weight' name='data[BoxDetail][{{n}}][weight]' class='form-control TotalMaterial' onkeyup="updateTotal()"/>
    <span class="input-group-addon">Kg</span>
    </span>            
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