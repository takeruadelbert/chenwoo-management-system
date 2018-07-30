<?php echo $this->Form->create("PackageDetail", array("class" => "form-horizontal form-separate", "action" => "set_package_to_container", "type" => "file", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="tabbable page-tabs">
    <div class="tab-pane active fade in" id="data-utama">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="block-inner text-danger">
                    <h6 class="heading-hr"><?= __("Set Paket Ke Kontainer") ?>
                        <small class="display-block">Mohon Isikan Dengan Sesuai dan Benar</small>
                    </h6>
                </div>
                <div>
                    <div class = "row">
                        <div class = "col-md-12">
                            <div class="form-group">
                                <?php
                                echo $this->Form->label("PackageDetail.sale_id", __("Nomor Penjualan"), array("class" => "col-md-2 control-label"));
                                echo $this->Form->input("PackageDetail.sale_id", array("div" => array("class" => "col-md-4"), "empty" => "", "placeholder" => "- Pilih Nomor Penjualan -","id"=>"noPO", "label" => false, "class" => "select-full"));
                                ?>
                                <?php
                                echo $this->Form->label("PackageDetail.packaging_dt", __("Tanggal "), array("class" => "col-md-2 control-label"));
                                echo $this->Form->input("PackageDetail.packaging_dt", array("div" => array("class" => "col-md-4"), "type" => "text", "label" => false, "value" => date("Y-m-d"), "class" => "form-control datepicker"));
                                ?>
                            </div>
                        </div>
                        
                    </div>
                    <div class="pre-scrollable stn-table stn-table-nowrap" style="height:400px;">
                        <table width="100%" class="table table-hover table-bordered ">
                            <thead>
                                <tr>
                                    <th width="50" style="text-align: center;">No</th>
                                    <th width="230" style="text-align: center;min-width:150px">No Paket</th>
                                    <th width="230" style="text-align: center;min-width:150px">Nama Produk</th>
                                    <th width="230" style="text-align: center;min-width:150px">Batch Number</th>
                                    <th width="100" style="text-align: center;min-width:150px">Berat Bersih</th>    
                                    <th width="100" style="text-align: center;min-width:150px">Berat Kotor</th>
                                    <th width="130" style="text-align: center;min-width:125px">Jumlah Produk (Pcs)</th>
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
                            </tfoot>
                        </table>
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
<script>
    var count = 0;
    var data_product = "";//<= json_encode($listProduct) ?>;
    $(document).ready(function () {
        
        
        //if select product
        $("#noPO").on("change", function () {
            $("tr.material-data-input").remove();
            var saleID = $("#noPO").val();
            if (saleID!= "") {
                $.ajax({
                    url: BASE_URL + "admin/package_details/get_product_by_sale_id/" + saleID,
                    type: "GET",
                    dataType: "JSON",
                    data: {},
                    success: function (data) {
                        data_product=data;
                        addThisRow(".firstrunclick", 'product-data', '');
                    }
                })
                
            }
        })
//        $(".selectProduct").on("change", function () {
//            alert("aaa");
//            var productID = $(this).attr('id');
//            alert(productID);
//            if (saleID!= "") {
//                $.ajax({
//                    url: BASE_URL + "admin/package_details/get_product_by_sale_id/" + saleID,
//                    type: "GET",
//                    dataType: "JSON",
//                    data: {},
//                    success: function (data) {
//                        data_product=data;
//                        addThisRow(".firstrunclick", 'product-data', '');
//                    }
//                })
//                
//            }
//        })
//        $(".batch-number").on("change", function() {
//            alert("aa");
//            get_batch_number(this, $(this).data("select-batch-number"));
//        });
    });
    
//    function get_batch_number_by_product_id(n) {
//        var product_id = $("#selectProduct" + n).val();
//        alert(product_id);
//    }

    function typeaheadPaket(n){
        var productDetail = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('package_no'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            prefetch: '<?= Router::url("/admin/package_details/getPackageDetail", true) ?>',
            remote: {
                url: '<?= Router::url("/admin/package_details/getPackageDetail", true) ?>' + '?q=%QUERY',
                wildcard: '%QUERY',
            }
        });
        productDetail.clearPrefetchCache();
        productDetail.initialize(true);
        $('input.typeahead-ajax-productdetail'+n).typeahead({
            hint: false,
            highlight: true
        }, {
            name: 'productDetail',
            display: 'package_no',
            source: productDetail.ttAdapter(),
            templates: {
                header: '<center><h5>Nomor Paket</h5></center><hr>',
                suggestion: function (data) {
                    return '<p> Nomor Paket : ' + data.package_no + '</p>';
                },
                empty: [
                    '<center><h5>Data Nomor Paket</h5></center><hr> <center><p> Hasil Pencarian Anda Tidak Dapat Ditemukan. </p></center>',
                ]
            }
        });
        $('input.typeahead-ajax-productdetail'+n).bind('typeahead:select', function (ev, suggestion) {
            $("#productdetail"+n).val(suggestion.id);
        });
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
//            $(this).find(".product_id").attr("id", "SaleDetail" + i + "Price");
            i++;
        })
    }
    
    function addThisRow(e, t, optFunc) {
        var n = $(e).data("n");
        var template = $('#tmpl-' + t).html();
        Mustache.parse(template);
        var options = {i: 2, n: n, data_product: data_product};
        var rendered = Mustache.render(template, options);
        $('#target-' + t).append(rendered);
        $(e).data("n", n + 1);
        fixNumber($('#target-' + t));
        reloadisdecimal();
        reloadSelect2();
        count++;
        typeaheadPaket(n); 
    }
    
    function get_batch_number(e, targetE) {
        var product_id = $(e).val();
        $.ajax({
            url: BASE_URL + "admin/package_details/get_batch_number_by_product_id/" + product_id,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                var $target = $(targetE);
                $($target).find('option').remove();
                $target.append("<option value='0'>-Pilih Batch-</option>");
                $($target).val('0').trigger('change');
                $.each(data.data, function (k, v) {
                    $target.append("<option value='" + k + "'>" + v + "</option>");
                });
                $("div.select-batch-number").find('option').remove();
            }
        });
    }
</script>
<script type="x-tmpl-mustache" id="tmpl-product-data">
    <tr class="dynamic-row material-data-input">
    <td class="text-center nomorIdx">{{n}}</td>
    <td class="text-center">{{list_packages}}
<!--    <select name='data[dummy][n}}][id]' id="selectpackage" class='select-full package_id selectPackage' onchange=""> //getPrice(this,n}})
    <option value='0'>-Pilih Paket-</option>
    data_package}}
    <option value="id}}">label}}</option>
    data_package}}
    </select>-->
    <input type="text" placeholder="Cari Nomor Paket ..." class="form-control typeahead-ajax-productdetail{{n}}">
    <input type="hidden" name="data[dummy][{{n}}][id]" id="productdetail{{n}}">
    </td>    
    <td class="text-center">{{list_materials}}
    <select name='data[dummy][{{n}}][product_id]' id="selectProduct{{n}}" class='select-full product_id selectProduct batch-number' data-select-batch-number-target="#selectBatch{{n}}" onchange="get_batch_number(this, $(this).data('select-batch-number-target'))"> //getPrice(this,{{n}})
    <option value='0'>-Pilih Produk-</option>
    {{#data_product}}
    <option value="{{id}}">{{name}}</option>
    {{/data_product}}
    </select>
    </td>
    <td class="text-center">
    <select name='data[dummy][{{n}}][product_detail_id]' id="selectBatch{{n}}" class='select-full batch_id'> //getPrice(this,{{n}})
    <option value='0'>-Pilih Batch-</option>
    </select>
    </td>
    <td class="text-center">
    <div class="input-group">
    <input type='text' name='data[dummy][{{n}}][nett_weight]' class='form-control text-right'/>
    <span class="input-group-addon">kg</span>
    </div>        
    </td>
    <td>
    <div class="input-group">                                            
    <input type="text" name="data[dummy][{{n}}][brut_weight]" class="form-control text-right">
    <span class="input-group-addon">kg</span>
    </div>  
    </td>
    <td class="text-center">
    <div class="input-group">
    <input type='text' name='data[dummy][{{n}}][quantity_per_pack]' class='form-control text-right isdecimal'/>
    <span class="input-group-addon">Pcs</span>
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