<?php echo $this->Form->create("MaterialAdditionalPerContainer", array("class" => "form-horizontal form-separate", "action" => "add", "type" => "file", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="tabbable page-tabs">
    <div class="tab-pane active fade in" id="data-utama">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="block-inner text-danger">
                    <h6 class="heading-hr"><?= __("Permintaan Material Pembantu Ke Gudang") ?>
                        <small class="display-block">Mohon Isikan Dengan Sesuai dan Benar</small>
                    </h6>
                </div>
                <div>        
                    <div class="form-group">
                        <input type="hidden" name="data[MaterialAdditionalPerContainer][sale_id]" id="poNumber">
                        <?php
                        echo $this->Form->label("MaterialAdditionalPerContainer.po_number", __("Nomor PO"), array("class" => "col-sm-3 col-md-3 control-label"));
                        echo $this->Form->input("MaterialAdditionalPerContainer.po_number", array("div" => array("class" => "col-sm-3 col-md-3"), "label" => false, "class" => "form-control", "disabled"));
                        ?>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="table-responsive stn-table">
                        <div class="panel-heading" style="background:#2179cc">
                            <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Detail Material Pembantu") ?></h6>
                        </div>
                        <br>
                        <table width="100%" class="table table-hover table-bordered">
                            <thead>
                            <th width="1%" style="text-align: center;">No</th>
                            <th width="38%" style="text-align: center;">Produk</th>
                            <th width="30%" style="text-align: center;">Jumlah MC Dipesan</th>
                            <th width="30%" style="text-align: center;">Berat</th>
                            </thead>
                            <tbody id="target-installment">
                                <tr id="init">
                                    <td class = "text-center" colspan = 4>Tidak Ada Data</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>    
                </div>
                <div class="panel-body" id="materialList">
                    <div class="table-responsive stn-table">
                        <div class="panel-heading" style="background:#2179cc">
                            <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Detail Material Pembantu") ?></h6>
                        </div>
                        <br>
                        <table width="100%" class="table table-hover table-bordered">
                            <thead>
                            <th width="1%" style="text-align: center;">No</th>
                            <th width="20%" style="text-align: center;">Produk</th>
                            <th width="10%" style="text-align: center;">Material Pembantu Master Carton</th>
                            <th width="15%" style="text-align: center;">Jumlah</th>
                            <th width="10%" style="text-align: center;">Material Pembantu Plastik</th>
                            <th width="15%" style="text-align: center;">Jumlah</th>
                            </thead>
                            <tbody id="target-material-data">

                            </tbody>
                            <tfoot>
                                <div class="firstrunclick" data-n="1"></div>
                            </tfoot>
                        </table>
                    </div>
                </div> 
                <div class = "note">
                    <div class="form-group">
                        <?php
                        echo $this->Form->label("MaterialAdditionalPerContainer.note", __("Keterangan"), array("class" => "col-sm-3 col-md-4 control-label"));
                        echo $this->Form->input("MaterialAdditionalPerContainer.note", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control ckeditor-fix"));
                        ?>
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
                <button class="btn btn-danger submitButton" data-toggle="modal" data-target="#add" type="button" href="<?php echo Router::url('/admin/popups/content?content=confirm_add', true); ?>">
                    <?= __("Simpan") ?>
                </button>
            </div>
        </div>
    </div>
</div>
<?php echo $this->Form->end() ?>
<?php
$listMaterialMC = [];
$listMaterialPlastik = [];
foreach ($materialAdditionalMC as $material) {
    $listMaterialMC[] = [
        "id" => $material["MaterialAdditional"]["id"],
        "label" => $material["MaterialAdditional"]["name"]." ".$material["MaterialAdditional"]["size"],
        "price" => $material["MaterialAdditional"]["price"],
    ];
}
foreach ($materialAdditionalPlastik as $material) {
    $listMaterialPlastik[] = [
        "id" => $material["MaterialAdditional"]["id"],
        "label" => $material["MaterialAdditional"]["name"]." ".$material["MaterialAdditional"]["size"],
        "price" => $material["MaterialAdditional"]["price"],
    ];
}
?>
<script>
    $(document).ready(function () {
        $('.note').hide();
        var sale = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('po_number'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            prefetch: '<?= Router::url("/admin/sales/list_po_number", true) ?>',
            remote: {
                url: '<?= Router::url("/admin/sales/list_po_number", true) ?>' + '?q=%QUERY',
                wildcard: '%QUERY',
            }
        });
        sale.clearPrefetchCache();
        sale.initialize(true);
        $('input.typeahead-ajax-ponumber').typeahead({
            hint: false,
            highlight: true
        }, {
            name: 'sale',
            display: 'po_number',
            source: sale.ttAdapter(),
            templates: {
                header: '<center><h5>Data Purchase Order</h5></center><hr>',
                suggestion: function (data) {
                    return '<p> Nomor PO : ' + data.po_number + '<br/> Buyer : ' + data.buyer_name + '</p>';
                },
                empty: [
                    '<center><h5>Data Purchase Order</h5></center><hr> <center><p> Hasil Pencarian Anda Tidak Dapat Ditemukan. </p></center>',
                ]
            }
        });
        $('input.typeahead-ajax-ponumber').bind('typeahead:select', function (ev, suggestion) {
            $("#poNumber").val(suggestion.id);
            $.ajax({
                url: BASE_URL + "material_additional_per_containers/get_data_po_number/" + suggestion.id,
                type: "GET",
                dataType: "JSON",
                data: {},
                success: function (data) {
                    if (data.Sale.id != null && data.Sale.id != "") {
                        $('.note').show();
                    } else {
                        $('.note').hide();
                    }
                }
            })
        });
    });
</script>
<script>
    var count = 1;
    var listMaterialMC = <?= json_encode($listMaterialMC) ?>;
    var listMaterialPlastik = <?= json_encode($listMaterialPlastik) ?>;
    $(document).ready(function () {
        $.ajax({
            url: BASE_URL + "admin/sales/view_data_sale/" + getParameterByName('id'),
            dataType: "JSON",
            type: "GET",
            data: {},
            beforeSend: function (xhr) {
                ajaxLoadingStart();
            },
            success: function (data) {
                var numberProduct=1;
                var i=0;
                if (data != null && data != '') {
                    $('input#MaterialAdditionalPerContainerPoNumber').val(data.Sale.po_number);
                    $('#poNumber').val(data.Sale.id);
                    $.each(data.SaleDetail, function (index, item) {
                        var template = $("#tmpl-installment").html();
                        Mustache.parse(template);
                        $("table tr#init").remove();
                        var optSale = {
                            i: numberProduct,
                            product: item.Product.Parent.name+" "+item.Product.name,
                            weight: item.nett_weight,
                            quantity: item.quantity,
                        };
                        var rendered = Mustache.render(template, optSale);
                        $('#target-installment').append(rendered);
                        numberProduct++;
                        
                        var options = {
                            i: i,
                            id:item.Product.id,
                            product: item.Product.Parent.name+" "+item.Product.name,
                        };
                        i++;
                        addThisRow(".firstrunclick", 'material-data', options);
                    });
                }
                ajaxLoadingSuccess();
            }
        });
    });
    
    function getParameterByName(name, url) {
        if (!url) {
          url = window.location.href;
        }
        name = name.replace(/[\[\]]/g, "\\$&");
        var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
            results = regex.exec(url);
        if (!results) return null;
        if (!results[2]) return '';
        return decodeURIComponent(results[2].replace(/\+/g, " "));
    }

    function updateTotal(n) {
        var total = 0;
        if (document.getElementById("PurchaseOrderAdditionalMaterialDetail" + n + "Quantity").value != null && document.getElementById("PurchaseOrderAdditionalMaterialDetail" + n + "Price").value != null) {
            $quantity = document.getElementById("PurchaseOrderAdditionalMaterialDetail" + n + "Quantity").value;
            $price = document.getElementById("PurchaseOrderAdditionalMaterialDetail" + n + "Price").value;
            document.getElementById("TotalMaterial" + n).value = IDR(parseInt(parseInt($quantity.replaceAll('.', '')) * parseInt($price.replaceAll('.', ''))));
        }
        $('input.TotalMaterial').each(function () {
            $thisGrandTotalDebt = String($(this).val());
            total += parseInt($thisGrandTotalDebt.replaceAll('.', ''));
        });
        $("input.auto-calculate-grand-total-produk-data").val(IDR(total));
    }

    function showDetails(n) {
        document.getElementById("weight_material_details" + n).innerHTML = "";
        var count = parseInt($("input.TransactionMaterialEntry" + n + "Quantity").val());
        $("#weight_material_details" + n).append("<div class='panel-heading' style='background:#ff0000'><h6 class='panel-title' style=' color:#fff'><i class='icon-menu2'></i>Rincian Berat Ikan (Sesuai Nota Timbang):</h6></div>");
        for (i = 0; i < count; i++) {
            $("#weight_material_details" + n).append("<div class='col-md-2' style='margin:6px auto 6px auto'><div class='input-group'><input type='text' placeholder ='Ikan " + (i + 1) + "' class='form-control isDecimal beratTimbangan" + n + "" + i + "' name='data[TransactionMaterialEntry][" + n + "][TransactionMaterialEntryDetail][" + i + "][weight]' id='beratTimbangan" + n + "" + i + "Weight' onkeyup='calculateWeight(" + n + ")'><span class='input-group-addon'>Kg</span></div></div>");
        }

    }

    function calculateWeight(n) {
        var total = 0;
        var count = parseInt($("input.TransactionMaterialEntry" + n + "Quantity").val());
        for (i = 0; i < count; i++) {
            if ($("input.beratTimbangan" + n + i).val() != "") {
                total += parseInt($("input.beratTimbangan" + n + i).val());
            }

        }
        $("input.totalWeight" + n).val(total);
        $("input.totalRemainingWeight" + n).val(total);
    }

    function listenerProduk(e, n) {
    }

    String.prototype.replaceAll = function (find, replace) {
        var str = this;
        return str.replace(new RegExp(find.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&'), 'g'), replace);
    };

    function deleteThisRow(e, n) {
        var tbody = $(e).parents("tbody");
        e.parents("tr").remove();
        $("tr#material-detail-data-input" + n).remove();
        count--;
        fixNumber(tbody);
        updateTotal(0);
    }

    function fixNumber(e) {
        var i = 1;
        $.each(e.find("tr.dynamic-row").not(".hidden"), function () {
            $(this).find(".nomorIdx").html(i);
            i++;
        })
    }

    function addThisRow(e, t, optFunc) {
        var n = $(e).data("n");
        var template = $('#tmpl-' + t).html();
        Mustache.parse(template);
        var options = {i: 2, n: n, listMaterialMC: listMaterialMC, listMaterialPlastik: listMaterialPlastik};
        var allData = Object.assign(options, optFunc);
        var rendered = Mustache.render(template, allData);
        $('#target-' + t).append(rendered);
        $(e).data("n", n + 1);
        fixNumber($('#target-' + t));
        reloadisdecimal();
        reloadSelect2();
        listenerProduk($('#target-' + t).find("tr").last(), n);
        count++;
    }

    function getPriceMC(n) {
        var sel = document.getElementById('MaterialAdditionalPerContainerMC' + n);
        var selected = sel.options[sel.selectedIndex];
        var price = selected.getAttribute('data-price');
        $("input#MaterialAdditionalPerContainerMC" + n + "Price").val(IDR(price.replaceAll(".00", "")));
    }

    function getPricePlastik(n) {
        var sel = document.getElementById('MaterialAdditionalPerContainerPlastik' + n);
        var selected = sel.options[sel.selectedIndex];
        var price = selected.getAttribute('data-price');
        $("input#MaterialAdditionalPerContainerPlastik" + n + "Price").val(IDR(price.replaceAll(".00", "")));
    }

    function calculateTotal() {
        var n = $(".firstrunclick").data("n");
        var grandTotal = 0;
        for (i = 1; i < n; i++) {
            var mcPrice = $("input#MaterialAdditionalPerContainerMC" + i + "Price").val();
            var mcQty = $("input#MaterialAdditionalPerContainerMC" + i + "Quantity").val();
            if (mcPrice != "" && mcQty != "") {
                grandTotal += parseInt(mcPrice.replace(".", "")) * parseInt(mcQty.replace(".", ""));
            }
            var plastikPrice = $("input#MaterialAdditionalPerContainerPlastik" + i + "Price").val();
            var plastikQty = $("input#MaterialAdditionalPerContainerPlastik" + i + "Quantity").val();
            if (plastikPrice != "" && plastikQty != "") {
                grandTotal += parseInt(plastikPrice.replace(".", "")) * parseInt(plastikQty.replace(".", ""));
            }
        }
        $("input#GrandTotal").val(IDR(grandTotal));
    }
</script>
<script type="x-tmpl-mustache" id="tmpl-material-data">
    <tr class="dynamic-row material-data-input">
    <td class="text-center nomorIdx">{{n}}</td>
    <td class="text-center">
        <input type="text" value="{{product}}" name="data['MaterialAdditionalPerContainerDetailTemp'][{{n}}][product]" id="MaterialAdditionalPerContainerDetailTempProduct" class="form-control" readonly/>
        <input type="hidden" value="{{id}}" name="data[MaterialAdditionalPerContainerDetail][{{n}}][product_id]" id="MaterialAdditionalPerContainerDetailProductId"/>
    </td>            
    <td class="text-center">
    <select name='data[MaterialAdditionalPerContainerDetail][{{n}}][material_additional_mc_id]' class='select-full' id='MaterialAdditionalPerContainerMC{{n}}' onchange="getPriceMC({{n}})">
    <option value='0'>-Pilih Material Pembantu-</option>
    {{#listMaterialMC}}
    <option value="{{id}}" data-price="{{price}}">{{label}}</option>
    {{/listMaterialMC}}
    </select>
    </td>
    <td class="text-center">
    <div class="input-group">
    <input type='input' name="data[MaterialAdditionalPerContainerDetail][{{n}}][quantity_mc]" class='form-control isdecimal text-right' id="MaterialAdditionalPerContainerMC{{n}}Quantity"/>
    <span class="input-group-addon">pcs</span>
    </div>
    </td>
    <td class="text-center">
    <select name='data[MaterialAdditionalPerContainerDetail][{{n}}][material_additional_plastic_id]' class='select-full' id='MaterialAdditionalPerContainerPlastik{{n}}' onchange="getPricePlastik({{n}})">
    <option value='0'>-Pilih Material Pembantu-</option>
    {{#listMaterialPlastik}}
    <option value="{{id}}" data-price="{{price}}">{{label}}</option>
    {{/listMaterialPlastik}}
    </select>
    </td>
    <td class="text-center">
    <div class="input-group">
    <input type='input' name="data[MaterialAdditionalPerContainerDetail][{{n}}][quantity_plastic]" class='form-control isdecimal text-right' id="MaterialAdditionalPerContainerPlastik{{n}}Quantity"/>
    <span class="input-group-addon">pcs</span>
    </div>
    </td>      
    </tr>
</script>
<script type="x-tmpl-mustache" id="tmpl-installment">
    <tr>
    <td class="text-center">{{i}}</td>
    <td class="text-left">{{product}}</td> 
    <td class="text-center">{{quantity}}</td>        
    <td class="text-center">{{weight}} Kg</td>
    </tr>
</script>
