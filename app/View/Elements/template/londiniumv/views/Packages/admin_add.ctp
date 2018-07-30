<?php

$groupedProduct = [];
$productNamed=[];
$listProduct = [];
foreach ($dataProduct as $product) {
    $groupedProduct[$product["Product"]["id"]] = [
        "label" => $product["Parent"]["name"] . " " . $product["Product"]["name"],
        "data" => [],
        "list" => [],
    ];
    $productName[$product["Product"]["id"]]=$product;
}
foreach ($dataProductDetail as $productDetail) {
    $groupedProduct[$productDetail["ProductDetail"]["product_id"]]["data"] = [
        "id" => $productDetail["ProductDetail"]["id"],
        "label" => $productDetail["ProductDetail"]["batch_number"],
        "weight" => $productDetail["ProductDetail"]["remaining_weight"],
    ];
    $groupedProduct[$productDetail["ProductDetail"]["product_id"]]["list"][$productDetail["ProductDetail"]["id"]] = $productDetail["ProductDetail"]["batch_number"]." | ".date("d/m/Y", strtotime($productDetail["ProductDetail"]['production_date']));
}
$productSale = [];
//foreach ($this->data["SaleDetail"] as $saleDetail) {
//    $productSale[$saleDetail["product_id"]] = [
//        "label" => $saleDetail["Product"]["Parent"]["name"] . " " . $saleDetail["Product"]["name"],
//        "data" => [],
//    ];
//}
//foreach ($this->data["PackageDetail"] as $packageDetail) {
//    $packageDetail["Product"]=$productName[$packageDetail["product_id"]];
//    $productSale[$packageDetail["product_id"]]["data"][] = $packageDetail;
//}

foreach ($dataProductDetail as $productDetail) {
    $listProduct[] = [
        "id" => $productDetail["ProductDetail"]["id"],
        "label" => $productDetail["ProductDetail"]["batch_number"]." | ".$productDetail["Product"]['Parent']["name"]." ".$productDetail["Product"]["name"],
        "productId" => $productDetail["ProductDetail"]["product_id"]
    ];
}
?>
<?php echo $this->Form->create("Package", array("class" => "form-horizontal form-separate", "action" => "add", "type" => "file", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="tab-pane active fade in" id="data-utama">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="block-inner text-danger">
                <h6 class="heading-hr"><?= __("Tambah Paket") ?>
                    <small class="display-block">Input data <i>Multiple</i> paket! Mohon Isikan Dengan Sesuai dan Benar</small>
                </h6>
            </div>
            <div class="well block">
                <div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <?php
                                echo $this->Form->label("Sale.sale_no", __("Nomor Penjualan"), array("class" => "col-md-4 control-label"));
                                echo $this->Form->input("Sale.sale_no", array("div" => array("class" => "col-md-8"), "type" => "text", "label" => false, "class" => "form-control", "disabled"));
                                echo $this->Form->hidden("Sale.id");
                                ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <?php
                                echo $this->Form->label("Sale.po_number", __("Nomor PO"), array("class" => "col-md-4 control-label"));
                                echo $this->Form->input("Sale.po_number", array("div" => array("class" => "col-md-8"), "type" => "text", "label" => false, "class" => "form-control", "disabled"));
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="panel panel-default">
                        <div class="panel-body" id="materialList">
                            <div class="table-responsive stn-table">
                                <div class="panel-heading" style="background:#2179cc">
                                    <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Detail Penjualan") ?></h6>
                                </div>
                                <table width="100%" class="table table-hover table-bordered">                        
                                    <thead>
                                        <tr>
                                            <th width="50">No</th>
                                            <th><?= __("Nama Produk") ?></th>
                                            <th width="10%"><?= __("Jumlah MC Diorder") ?></th>
                                            <th width="10%"><?= __("Jumlah MC Terpenuhi") ?></th>
                                            <th width="10%"><?= __("Berat Pemesanan") ?></th>
                                            <th width="10%"><?= __("Berat Terpenuhi") ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($this->data["SaleDetail"] as $k => $saleDetail) {
                                            ?>
                                        <tr>
                                            <td class="text-center"><?= $k + 1 ?></td>
                                            <td class="text-left"><?= $saleDetail["Product"]["Parent"]["name"] ?> - <?= $saleDetail["Product"]["name"] ?></td>
                                            <td class="text-right"><?= $saleDetail["quantity"] ?> MC</td>
                                            <td class="text-right"><?= $saleDetail["quantity_production"] ?> MC</td>
                                            <td class="text-right"><?= $saleDetail["nett_weight"] ?> <?= $saleDetail["Product"]["ProductUnit"]["name"] ?></td>
                                            <td class="text-right"><?= $saleDetail["fulfill_weight"] ?> <?= $saleDetail["Product"]["ProductUnit"]["name"] ?></td>
                                        </tr>
                                            <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>    
                </div>
                <div style="margin-top:10px;">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="table-responsive stn-table">
                                <div class="panel-heading" style="background:#2179cc">
                                    <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("MC yang belum terisi") ?></h6>
                                </div>
                                <table width="100%" class="table table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th width="50" style="text-align: center;">No</th>
                                            <th style="text-align: center;">No Paket</th>
                                            <th width="300" style="text-align: center;">PDC</th>
                                            <th width="150" style="text-align: center;">Berat Bersih</th>
                                            <th width="150" style="text-align: center;">Berat Kotor</th>
                                            <th width="150" style="text-align: center;">Jumlah Kemasan Per MC</th>
                                            <th width="150" style="text-align: center;">Hapus</th>
                                        </tr>
                                    </thead>
                                    <tbody id="target-package-detail">
                                        <tr id="addRow">
                                            <td colspan="7">
                                                <a class="text-success test firstrunclick" href="javascript:void(false)" onclick="addThisRow($(this), 'package-detail')" data-n="0"><i class="icon-plus-circle"></i></a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>    
                <!--                <div>
                                    <div class="panel panel-default">
                                        <div class="panel-body">
                                            <div class="pre-scrollable table-responsive stn-table">
                                                <div class="panel-heading" style="background:#2179cc">
                                                    <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><? = __("MC yang belum terisi") ?></h6>
                                                </div>
                                                <table width="100%" class="table table-hover table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th width="50" style="text-align: center;">No</th>
                                                            <th width="250" style="text-align: center;">No Paket</th>
                                                            <th width="250" style="text-align: center;">PDC</th>
                                                            <th width="250" style="text-align: center;">Nama Produk</th>
                                                            <th width="150" style="text-align: center;">Berat Bersih</th>
                                                            <th width="150" style="text-align: center;">Berat Kotor</th>
                                                            <th width="150" style="text-align: center;">Jumlah Kemasan Per MC</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                        <?php
                                        //$i = 0;
                                        //foreach ($productSale as $k => $groupedSaleDetail) {
                                            ?>
                                                            <tr>
                                                                <td colspan="6"><b><? = $groupedSaleDetail["label"] ?></b></td>
                                                            </tr>
                                            <?php
                                            /*
                                            $j = 1;
                                            $counter = 0;
                                            foreach ($groupedSaleDetail["data"] as $n => $packageDetail) {
                                                if ($packageDetail["is_filled"] == 1) {
                                                    $i++;
                                                    continue;
                                                }
                                                $counter++;
                                             */
                                                ?>
                                                                <tr>
                                                                    <td class="text-center"><?= $j++ ?></td>
                                                                    <td class="text-left">
                                                                        <? = $this->Form->input("PackageDetail.$i.product_detail_id", ["options" => [$groupedProduct[$packageDetail["product_id"]]["label"] => $groupedProduct[$packageDetail["product_id"]]["list"]], "empty" => "", "placeholder" => "- Pilih PDC Produk -", "class" => "select-full", "label" => false, "div" => false]) ?>
                                                                        <? = $this->Form->hidden("PackageDetail.$i.id") ?>
                                                                    </td>
                                                                    <td class="text-left">
                                                                        <? = $this->Form->input("Dummy.$k.$n.barcode", ["value" => $packageDetail["package_no"], "class" => "form-control", "disabled", "label" => false, "div" => false]) ?>
                                                                    </td>
                                                                    <td class="text-left">
                                                                        <? = $this->Form->input("PackageDetail.$i.nett_weight", [ "class" => "form-control addon-field text-right", "data-addon-symbol" => $packageDetail["Product"]["ProductUnit"]["name"], "label" => false, "div" => false]) ?>
                                                                    </td>
                                                                    <td class="text-left">
                                                                        <? = $this->Form->input("PackageDetail.$i.brut_weight", [ "class" => "form-control addon-field text-right", "data-addon-symbol" => $packageDetail["Product"]["ProductUnit"]["name"], "label" => false, "div" => false]) ?>
                                                                    </td>
                                                                    <td class="text-left">
                                                                        <? = $this->Form->input("PackageDetail.$i.quantity_per_pack", [ "class" => "form-control addon-field text-right", "data-addon-symbol" => "Pcs", "label" => false, "div" => false]) ?>
                                                                    </td>
                                                                </tr>
                                                <?php
                                                $i++;
                                            //}
                                            //if ($counter == 0) {
                                                ?>
                                                                <tr>
                                                                    <td colspan="7" class="text-center">MC untuk produk ini telah terpenuhi.</td>
                                                                </tr>
                                                <?php
                                             //}
                                        //}
                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>    -->

                <!--                <div>
                                    <div class="panel panel-default">
                                        <div class="panel-body">
                                            <div class="pre-scrollable table-responsive stn-table">
                                                <div class="panel-heading" style="background:#2179cc">
                                                    <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><? = __("MC yang terisi") ?></h6>
                                                </div>
                                                <table width="100%" class="table table-hover table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th width="50" style="text-align: center;">No</th>
                                                            <th style="text-align: center;">PDC</th>
                                                            <th width="150" style="text-align: center;">Barcode MC</th>
                                                            <th width="150" style="text-align: center;">Berat Bersih</th>
                                                            <th width="150" style="text-align: center;">Berat Kotor</th>
                                                            <th width="150" style="text-align: center;">Jumlah Kemasan Per MC</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                        <?php
                                        //$i = 0;
                                        //foreach ($productSale as $k => $groupedSaleDetail) {
                                            ?>
                                                            <tr>
                                                                <td colspan="6"><b><? = $groupedSaleDetail["label"] ?></b></td>
                                                            </tr>
                                            <?php
                                            /*
                                            $j = 1;
                                            $counter = 0;
                                            foreach ($groupedSaleDetail["data"] as $n => $packageDetail) {
                                                if ($packageDetail["is_filled"] == 0) {
                                                    $i++;
                                                    continue;
                                                }
                                                $counter++;
                                             * 
                                             */
                                                ?>
                                                                <tr>
                                                                    <td class="text-center"><? = $j++ ?></td>
                                                                    <td class="text-left">
                                                                        <? = $this->Form->input("Dummy.$i.batch_number", ["value" => $packageDetail["ProductDetail"]['batch_number']." | ".date("d/m/Y", strtotime($packageDetail["ProductDetail"]['production_date'])), "class" => "form-control", "label" => false, "div" => false, "disabled"]) ?>
                                                                    </td>
                                                                    <td class="text-left">
                                                                        <? = $this->Form->input("Dummy.$k.$n.barcode", ["value" => $packageDetail["package_no"], "class" => "form-control", "disabled", "label" => false, "div" => false]) ?>
                                                                    </td>
                                                                    <td class="text-left">
                                                                        <? = $this->Form->input("PackageDetail.$i.nett_weight", [ "class" => "form-control addon-field text-right", "data-addon-symbol" => $packageDetail["Product"]["ProductUnit"]["name"], "label" => false, "div" => false, "disabled"]) ?>
                                                                    </td>
                                                                    <td class="text-left">
                                                                        <? = $this->Form->input("PackageDetail.$i.brut_weight", [ "class" => "form-control addon-field text-right", "data-addon-symbol" => $packageDetail["Product"]["ProductUnit"]["name"], "label" => false, "div" => false, "disabled"]) ?>
                                                                    </td>
                                                                    <td class="text-left">
                                                                        <? = $this->Form->input("PackageDetail.$i.quantity_per_pack", [ "class" => "form-control addon-field text-right", "data-addon-symbol" => "Pcs", "label" => false, "div" => false, "disabled"]) ?>
                                                                    </td>
                                                                </tr>
                                                <?php
                                                /*
                                                $i++;
                                            }
                                            if ($counter == 0) {
                                                */
                                                ?>
                                                                <tr>
                                                                    <td colspan="6" class="text-center">Belum ada data.</td>
                                                                </tr>
                                                <?php
                                            //}
                                        //}
                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div> -->
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
                <button class="btn btn-danger submitButton" data-toggle="modal" data-target="#add" type="button" href="<?php echo Router::url('/admin/popups/content?content=confirm_add', true); ?>">
                    <?= __("Simpan") ?>
                </button>
            </div>
        </div>
    </div>
</div>
<?php echo $this->Form->end() ?>
<script>
    var data_product = <?= json_encode($listProduct) ?>;
    var id = 0; //Get Sales id
    var package = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('package_no'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        prefetch: false,
        remote: {
            url: '<?= Router::url("/admin/package_details/list", true) ?>' + '?q=%QUERY&sale_id=<?= $_GET["id"]?>',
            wildcard: '%QUERY',
        }
    });
    package.clearPrefetchCache();
    package.initialize(true);
    $(document).ready(function () {
        id = getUrlParameter('id');
        addThisRow(".firstrunclick", 'package-detail');
    })

    function deleteThisRow(e) {
        var tbody = $(e).parents("tbody");
        e.parents("tr").remove();
        fixNumber(tbody);
    }

    var getUrlParameter = function getUrlParameter(sParam) {
        var sPageURL = decodeURIComponent(window.location.search.substring(1)),
                sURLVariables = sPageURL.split('&'),
                sParameterName,
                i;

        for (i = 0; i < sURLVariables.length; i++) {
            sParameterName = sURLVariables[i].split('=');

            if (sParameterName[0] === sParam) {
                return sParameterName[1] === undefined ? true : sParameterName[1];
            }
        }
    };

    function addThisRow(e, t) {
        var n = $(e).data("n");
        var template = $('#tmpl-' + t).html();
        Mustache.parse(template);
        var options = {i: 2, n: n};
        if (typeof (optFunc) !== 'undefined') {
            $.extend(options, window[optFunc]());
        }
        var rendered = Mustache.render(template, options);
        $('#target-' + t + " tr:last").before(rendered);
        $(e).data("n", n + 1);
        reloadSelect2();
        reloadisdecimal();
        fixNumber($(e).parents("tbody"));

        $('input.typeahead-ajax-barang' + (n)).typeahead({
            hint: false,
            highlight: true
        }, {
            name: 'package',
            display: 'package_no',
            source: package.ttAdapter(),
            templates: {
                header: '<center><h5>Data Paket</h5></center><hr>',
                suggestion: function (context) {
                    return '<p> Nomor Paket : ' + context.package_no + '<br>Product : ' + context.product + '</p>';
                },
                empty: [
                    '<center><h5>Data Barang</h5></center><hr> <center><p> Hasil Pencarian Anda Tidak Dapat Ditemukan. </p></center>',
                ]
            }
        });
        $('input.typeahead-ajax-barang' + (n)).bind('typeahead:select', function (ev, suggestion) {
            listenerProduk(suggestion, n);
            $("#PackageDetail"+n+"product_detail_id").html("<option></option>");
            $.each(suggestion.product_detail, function (k, v) {
                $("#PackageDetail"+n+"product_detail_id").append("<option value='" + v.id + "' data-weight='" + v.remaining_weight + "'>" + v.batch_number + "</option>").trigger('change');
            })
            //$('#PackageDetail0product_detail_id ').val(e.id);
            //var status = $(this).data("produk-id");
        });
    }

    function listenerProduk(e, k) {
        $('#packageDetail' + k).val(e.id);
    }

    function fixNumber(e) {
        var i = 1;
        $.each(e.find("tr"), function () {
            $(this).find(".nomorIdx").html(i);
            i++;
        })
    }
</script>
<script type="x-tmpl-mustache" id="tmpl-package-detail">
    <tr id="data1">
    <td class="text-center nomorIdx">
    {{i}}
    </td>
    <td>
    <div class="has-feedback">
    <div> 
    <input type="text" class="form-control typeahead-ajax-barang{{n}}" id="typeaheadBarang{{n}}" placeholder="Cari Nama Barang ..."/>
    <i class="icon-search3 form-control-feedback"></i>
    <input type="hidden" name="data[PackageDetail][{{n}}][id]" id="packageDetail{{n}}">
    </div>
    </div>
    </td>
    <td>
    <div>
    <select name="data[PackageDetail][{{n}}][product_detail_id]" class="select-full productSelected" id="PackageDetail{{n}}product_detail_id" required="required" empty="" placeholder="- Pilih Jenis Produk -">
    <option></option>
    </select>
    </div>                                
    </td>
    <td>
    <div class="input-group">
    <input type="text" class="form-control text-right" name="data[PackageDetail][{{n}}][nett_weight]">
    <span class="input-group-addon"><strong>Kg</strong></span>
    </div>                                 
    </td>
    <td>
    <div class="input-group">
    <input type="text" class="form-control text-right" name="data[PackageDetail][{{n}}][brut_weight]">
    <span class="input-group-addon"><strong>Kg</strong></span>
    </div>                                 
    </td>
    <td>
    <div class="input-group">        
    <input type="text" class="form-control text-right differWeight" name="data[PackageDetail][{{n}}][quantity_per_pack]">
    <span class="input-group-addon"><strong>Pcs</strong></span>
    </div>                                  
    </td>
    <td class="text-center">
    <a href="javascript:void(false)" onclick="deleteThisRow($(this))"><i class="icon-remove3"></i></a>
    </td>
    </tr>
</script>
