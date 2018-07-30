<?php echo $this->Form->create("MaterialAdditionalOpnameStock", array("class" => "form-horizontal form-separate", "action" => "add", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="block-inner text-danger">
                    <h6 class="heading-hr"><?= __("Tambah Data Stok Opname Material Pembantu") ?>
                        <small class="display-block">Mohon Isikan Dengan Sesuai dan Benar</small>
                    </h6>
                </div>
                <div class="table-responsive">
                    <table width="100%" class="table">
                        <div class="panel-heading" style="background:#2179cc">
                            <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Data Material Pembantu") ?></h6>
                        </div>
                        <tr>
                            <td colspan="3" style="width:200px">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col-sm-3 col-md-4 control-label">
                                                <label>Nama Material Pembantu</label>
                                            </div>
                                            <div class="has-feedback">
                                                <div class="col-sm-9 col-md-8">                                                
                                                    <input type="text" class="form-control typeahead-ajax" placeholder="Cari Nama Material Pembantu ...">
                                                    <i class="icon-search3 form-control-feedback"></i>
                                                    <input type="hidden" name="data[MaterialAdditionalOpnameStock][material_additional_id]" id="material">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("Dummy.category", __("Kategori Material Pembantu"), array("class" => "col-sm-3 col-md-4 control-label"));
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
                                                    <span class="input-group-addon" id = "unit">&nbsp</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("MaterialAdditionalOpnameStock.stock_number", __("Stok Fisik"), array("class" => "col-sm-3 col-md-4 control-label"));
                                            ?>
                                            <div class="col-sm-9 col-md-8">
                                                <div class="input-group">
                                                    <?php
                                                    echo $this->Form->input("MaterialAdditionalOpnameStock.stock_number", array("div" => array("class" => ""), "label" => false, "id" => "physicStock", "class" => "form-control text-right", "min" => 0));
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
                                            echo $this->Form->label("MaterialAdditionalOpnameStock.stock_difference", __("Selisih Stok"), array("class" => "col-sm-3 col-md-4 control-label"));
                                            ?>
                                            <div class="col-sm-9 col-md-8">
                                                <div class="input-group">
                                                    <?php
                                                    echo $this->Form->input("MaterialAdditionalOpnameStock.stock_difference", array("div" => array("class" => ""), "label" => false, "class" => "form-control text-right", "readonly"));
                                                    ?>
                                                    <span class="input-group-addon" id = "unit2">&nbsp</span>
                                                </div>
                                            </div>
                                        </div>  
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("MaterialAdditionalOpnameStock.opname_date", __("Tanggal Stok Opname"), array("class" => "col-sm-3 col-md-4 control-label"));
                                            echo $this->Form->input("MaterialAdditionalOpnameStock.opname_date", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "type" => "text", "value" => date('Y-m-d H:i:s'), "class" => "form-control datetime"));
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
                                    echo $this->Form->label("MaterialAdditionalOpnameStock.note", __("Keterangan"), array("class" => "col-sm-2 control-label"));
                                    echo $this->Form->input("MaterialAdditionalOpnameStock.note", array("div" => array("class" => "col-sm-10"), "label" => false, "class" => "ckeditor-fix"));
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
            prefetch: '<?= Router::url("/admin/material_additionals/list", true) ?>',
            remote: {
                url: '<?= Router::url("/admin/material_additionals/list", true) ?>' + '?q=%QUERY',
                wildcard: '%QUERY',
            }
        });
        product.clearPrefetchCache();
        product.initialize(true);
        $('input.typeahead-ajax').typeahead({
            hint: false,
            highlight: true
        }, {
            name: 'good',
            display: 'label',
            source: product.ttAdapter(),
            templates: {
                header: '<center><h5>Data Material Pembantu</h5></center><hr>',
                suggestion: function (context) {
                    return '<p> Nama Mat. Pembantu : ' + context.label + '<br>Kategori : ' + context.category_type + '</p>';
                },
                empty: [
                    '<center><h5>Data Material Pembantu</h5></center><hr> <center><p> Hasil Pencarian Anda Tidak Dapat Ditemukan. </p></center>',
                ]
            }
        });
        $('input.typeahead-ajax').bind('typeahead:select', function (ev, suggestion) {
            $('#material').val(suggestion.id);
            $("#DummyCategory").val(suggestion.category_type);
            $("#unit").html(suggestion.unit);
            $("#unit1").html(suggestion.unit);
            $("#unit2").html(suggestion.unit);
            $("#currentStock").val(ic_number_reverse(ic_kg(suggestion.quantity)));
        });
        listenerSelisihProduk();
    });

    function listenerSelisihProduk() {
        $("#physicStock").on("keyup", function () {
            var stockDifference = 0;
            var currentStock = $('#currentStock').val();
            $stockNumber = $(this).val();

            stockDifference = parseFloat($stockNumber - currentStock);
            $('#MaterialAdditionalOpnameStockStockDifference').val(ic_number_reverse(ic_kg(stockDifference)));
        });
    }
</script>