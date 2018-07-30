<?php echo $this->Form->create("ProductOpnameStock", array("class" => "form-horizontal form-separate", "action" => "add", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="block-inner text-danger">
                    <h6 class="heading-hr"><?= __("Tambah Data Stok Opname Produk") ?>
                        <small class="display-block">Mohon Isikan Dengan Sesuai dan Benar</small>
                    </h6>      
                </div>
                <div class="table-responsive">
                    <table width="100%" class="table" style="display:none">
<!--                        <div class="panel-heading" style="background:#2179cc">
                            <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><? __("Jenis Stok Opname") ?></h6>
                        </div>-->
                        <tr>
                            <td colspan="3" style="width:200px">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col-sm-3 col-md-4 control-label">
                                                <label>Jenis Stok Opname</label>
                                            </div>
                                            <div class="has-feedback">
                                                <div class="col-sm-9 col-md-8"> 
                                                        <input type="radio" class="form-control styled" id="init-option optTypeStock" name="data[Dummy][type]" value="Init" onchange="checkTypeInitStock()">
                                                        <label for="init-option">Inisialisasi Produk Awal</label>
                                                        <br>
                                                        <input type="radio" class="form-control styled" id="monthly-option optTypeStock" name="data[Dummy][type]" value="Monthly" onchange="checkTypeInitStock()">
                                                        <label for="monthly-option">Stok Opname Bulanan</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </table>
                    <table width="100%" class="table">
                        <div class="panel-heading" style="background:#2179cc">
                            <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Data Produk") ?></h6>
                        </div>
                        <tr>
                            <td colspan="3" style="width:200px">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col-sm-3 col-md-4 control-label">
                                                <label>Nama Produk</label>
                                            </div>
                                            <div class="has-feedback">
                                                <div class="col-sm-9 col-md-8">                                                
                                                    <input type="text" class="form-control typeahead-ajax-product" placeholder="Cari Nama Produk ...">
                                                    <i class="icon-search3 form-control-feedback"></i>
                                                    <input type="hidden" name="data[ProductOpnameStock][product_id]" id="product">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("Dummy.code", __("Kode Produk"), array("class" => "col-sm-3 col-md-4 control-label"));
                                            echo $this->Form->input("Dummy.code", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled"));
                                            ?>
                                        </div>
                                    </div>
                                </div>                                
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" style="width:200px">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("ProductOpnameStock.product_detail_id", __("PDC"), array("class" => "col-sm-3 col-md-4 control-label"));
                                            echo $this->Form->input("ProductOpnameStock.product_detail_id", array("options" => [], "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "select-full", "placeholder" => "- Pilih PDC -", "empty" => ""));
                                            ?>
                                        </div>
                                    </div>
                                </div>  
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" style="width:200px">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("Dummy.stock_number", __("Stok Sistem"), array("class" => "col-sm-3 col-md-4 control-label"));
                                            ?>
                                            <div class="col-sm-9 col-md-8">
                                                <div class="input-group">
                                                    <?php
                                                    echo $this->Form->input("Dummy.stock_number", array("div" => array("class" => ""), "label" => false, "id" => "currentStock", "data-stock" => 0, "class" => "form-control text-right", "disabled"));
                                                    ?>
                                                    <span class="input-group-addon" id = "unit">&nbsp</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("ProductOpnameStock.stock_number", __("Stok Fisik"), array("class" => "col-sm-3 col-md-4 control-label"));
                                            ?>
                                            <div class="col-sm-9 col-md-8">
                                                <div class="input-group">
                                                    <?php
                                                    echo $this->Form->input("ProductOpnameStock.stock_number", array("div" => array("class" => ""), "label" => false, "id" => "physicStock", "class" => "form-control text-right", "min" => 0));
                                                    ?>
                                                    <span class="input-group-addon" id = "unit1">&nbsp</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>    
                                </div>  
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" style="width:200px">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("ProductOpnameStock.stock_difference", __("Selisih Stok"), array("class" => "col-sm-3 col-md-4 control-label"));
                                            ?>
                                            <div class="col-sm-9 col-md-8">
                                                <div class="input-group">
                                                    <?php
                                                    echo $this->Form->input("ProductOpnameStock.stock_difference", array("div" => array("class" => ""), "label" => false, "class" => "form-control text-right", "readonly"));
                                                    ?>
                                                    <span class="input-group-addon" id = "unit2">&nbsp</span>
                                                </div>
                                            </div>
                                        </div>  
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("ProductOpnameStock.opname_date", __("Tanggal Stok Opname"), array("class" => "col-sm-3 col-md-4 control-label"));
                                            echo $this->Form->input("ProductOpnameStock.opname_date", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "type" => "text", "value" => date('Y-m-d H:i:s'), "class" => "form-control datetime"));
                                            ?>
                                        </div>
                                    </div>
                                </div>  
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="form-group">
                                    <?php
                                    echo $this->Form->label("ProductOpnameStock.note", __("Keterangan"), array("class" => "col-sm-2 control-label"));
                                    echo $this->Form->input("ProductOpnameStock.note", array("div" => array("class" => "col-sm-10"), "label" => false, "class" => "ckeditor-fix"));
                                    ?>
                                </div>
                            </td>
                        </tr>
                    </table>
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
    </div>
</div>
<?php echo $this->Form->end() ?>

<script>
    $(document).ready(function () {
        /* Cari Nama Barang */
        var product = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('label'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            prefetch: '<?= Router::url("/admin/products/list", true) ?>',
            remote: {
                url: '<?= Router::url("/admin/products/list", true) ?>' + '?q=%QUERY',
                wildcard: '%QUERY',
            }
        });
        product.clearPrefetchCache();
        product.initialize(true);
        $('input.typeahead-ajax-product').typeahead({
            hint: false,
            highlight: true
        }, {
            name: 'good',
            display: 'label',
            source: product.ttAdapter(),
            templates: {
                header: '<center><h5>Data Produk</h5></center><hr>',
                suggestion: function (context) {
                    return '<p> Nama Produk : ' + context.label + '<br>Kode Produk : ' + context.product_code + '</p>';
                },
                empty: [
                    '<center><h5>Data Produk</h5></center><hr> <center><p> Hasil Pencarian Anda Tidak Dapat Ditemukan. </p></center>',
                ]
            }
        });
        $('input.typeahead-ajax-product').bind('typeahead:select', function (ev, suggestion) {
        console.log(suggestion);
            $('#product').val(suggestion.id);
            $("#DummyCode").val(suggestion.product_code);
            $("#unit").html(suggestion.unit);
            $("#unit1").html(suggestion.unit);
            $("#unit2").html(suggestion.unit);
            $("#ProductOpnameStockProductDetailId").html("<option></option>");
            $.each(suggestion.product_detail, function (k, v) {
                $("#ProductOpnameStockProductDetailId").append("<option value='" + v.id + "' data-weight='" + v.weight + "'>" + v.label + "</option>").trigger('change');
            })
            $("#ProductOpnameStockProductDetailId").on("select2-selected", function () {
                $("#currentStock").val($("#ProductOpnameStockProductDetailId option:selected").data("weight"));
            })
        });
        listenerSelisihProduk();
    });
    
    function checkTypeInitStock(){
        if ($('input[name=data[Dummy][type]]:checked').length > 0) {
            alert("aa");
        }
//        if(document.getElementById('init-option').checked) {
//            //Male radio button is checked
//            alert("a");
//        }else if(document.getElementById('monthly-option').checked) {
//            //Female radio button is checked
//            alert("b");
//        }
    }

    function listenerSelisihProduk() {
        $("#physicStock").on("keyup", function () {
            var stockDifference = 0;
            var currentStock = $('#currentStock').val();
            $stockNumber = $(this).val();
            stockDifference = $stockNumber - currentStock;
            $('#ProductOpnameStockStockDifference').val(stockDifference.toFixed(2));
        });
    }
</script>