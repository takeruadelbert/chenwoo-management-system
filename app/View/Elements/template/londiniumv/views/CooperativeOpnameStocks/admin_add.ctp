<?php echo $this->Form->create("CooperativeOpnameStock", array("class" => "form-horizontal form-separate", "action" => "add", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="block-inner text-danger">
                    <h6 class="heading-hr"><?= __("Tambah Data Stok Opname Koperasi") ?>
                        <small class="display-block">Mohon Isikan Dengan Sesuai dan Benar</small>
                    </h6>
                </div>
                <div class="table-responsive">
                    <table width="100%" class="table">
                        <div class="panel-heading" style="background:#2179cc">
                            <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Data Barang") ?></h6>
                        </div>
                        <tr>
                            <td colspan="3" style="width:200px">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col-sm-3 col-md-4 control-label">
                                                <label>Nama Barang</label>
                                            </div>
                                            <div class="has-feedback">
                                                <div class="col-sm-9 col-md-8">                                                
                                                    <input type="text" class="form-control typeahead-ajax-barang" placeholder="Cari Nama Barang ...">
                                                    <i class="icon-search3 form-control-feedback"></i>
                                                    <input type="hidden" name="data[CooperativeOpnameStock][cooperative_good_list_id]" id="good">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("Dummy.code", __("Kode Barang"), array("class" => "col-sm-3 col-md-4 control-label"));
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
                                            echo $this->Form->label("Dummy.barcode", __("Barcode Barang"), array("class" => "col-sm-3 col-md-4 control-label"));
                                            echo $this->Form->input("Dummy.barcode", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled"));
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("Dummy.category", __("Kategori Barang"), array("class" => "col-sm-3 col-md-4 control-label"));
                                            echo $this->Form->input("Dummy.category", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled"));
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
                                                    <span class="input-group-addon unit"><strong></strong></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("CooperativeOpnameStock.stock_number", __("Stok Fisik"), array("class" => "col-sm-3 col-md-4 control-label"));
                                            ?>
                                            <div class="col-sm-9 col-md-8">
                                                <div class="input-group">
                                                    <?php
                                                    echo $this->Form->input("CooperativeOpnameStock.stock_number", array("div" => array("class" => ""), "label" => false, "id" => "physicStock", "class" => "form-control text-right", "min" => 0));
                                                    ?>
                                                    <span class="input-group-addon unit"><strong></strong></span>
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
                                            echo $this->Form->label("CooperativeOpnameStock.stock_difference", __("Selisih Stok"), array("class" => "col-sm-3 col-md-4 control-label"));
                                            ?>
                                            <div class="col-sm-9 col-md-8">
                                                <div class="input-group">
                                                    <?php
                                                    echo $this->Form->input("CooperativeOpnameStock.stock_difference", array("div" => array("class" => ""), "label" => false, "class" => "form-control text-right", "readonly"));
                                                    ?>
                                                    <span class="input-group-addon unit"><strong></strong></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("CooperativeOpnameStock.opname_date", __("Tanggal Stok Opname"), array("class" => "col-sm-3 col-md-4 control-label"));
                                            echo $this->Form->input("CooperativeOpnameStock.opname_date", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "type" => "text", "value" => date('Y-m-d H:i:s'), "class" => "form-control datetime"));
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
                                    echo $this->Form->label("CooperativeOpnameStock.note", __("Keterangan"), array("class" => "col-sm-2 control-label"));
                                    echo $this->Form->input("CooperativeOpnameStock.note", array("div" => array("class" => "col-sm-10"), "label" => false, "class" => "ckeditor-fix"));
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
        var good = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            prefetch: '<?= Router::url("/admin/cooperative_good_lists/list", true) ?>',
            remote: {
                url: '<?= Router::url("/admin/cooperative_good_lists/list", true) ?>' + '?q=%QUERY',
                wildcard: '%QUERY',
            }
        });
        good.clearPrefetchCache();
        good.initialize(true);
        $('input.typeahead-ajax-barang').typeahead({
            hint: false,
            highlight: true
        }, {
            name: 'good',
            display: 'name',
            source: good.ttAdapter(),
            templates: {
                header: '<center><h5>Data Barang</h5></center><hr>',
                suggestion: function (context) {
                    return '<p> Nama : ' + context.name + '<br>Kode Barang : ' + context.good_code + '<br>Barcode : ' + context.barcode + '<br>Kategori : ' + context.category_type + '</p>';
                },
                empty: [
                    '<center><h5>Data Barang</h5></center><hr> <center><p> Hasil Pencarian Anda Tidak Dapat Ditemukan. </p></center>',
                ]
            }
        });
        $('input.typeahead-ajax-barang').bind('typeahead:select', function (ev, suggestion) {
            $('#good').val(suggestion.id);
            $("#DummyCode").val(suggestion.good_code);
            $("#DummyBarcode").val(suggestion.barcode);
            $("#DummyCategory").val(suggestion.category_type);
            $("#currentStock").val(suggestion.stock_number);
            $(".unit").html(suggestion.unit);
        });
        listenerSelisihProduk();
    });

    function listenerSelisihProduk() {
        $("#physicStock").on("keyup", function () {
            var stockDifference = 0;
            var currentStock = $('#currentStock').val();
            $stockNumber = $(this).val();
            stockDifference = $stockNumber - currentStock;
            $('#CooperativeOpnameStockStockDifference').val(stockDifference);
        });
    }
</script>