<form action="#" role="form" class="panel-filter">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h6 class="panel-title">Filter Data</h6>
            <div class="panel-icons-group"> <a href="#" data-panel="collapse" class="btn btn-link btn-icon"><i class="icon-arrow-up9"></i></a></div>
        </div>
        <div class="panel-body">
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <div class="has-feedback">
                            <?php
                            $value = "";
                            if (!empty($this->request->query['select_MaterialAdditionalOpnameStock_id'])) {
                                $dataStockOpname = ClassRegistry::init("MaterialAdditionalOpnameStock")->find("first", [
                                    "conditions" => [
                                        "MaterialAdditionalOpnameStock.id" => $this->request->query['select_MaterialAdditionalOpnameStock_id']
                                    ]
                                ]);
                                $value = $dataStockOpname['MaterialAdditionalOpnameStock']['opname_stock_number'];
                            }
                            ?>
                            <label><?= __("Nomor Stok Opname") ?></label>
                            <input type="text" placeholder="Cari Nomor Stok Opname ..." class="form-control typeahead-ajax" value="<?= $value ?>">
                            <input type="hidden" name="select.MaterialAdditionalOpnameStock.id" id="opnameStock">
                            <i class="icon-search3 form-control-feedback"></i>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="has-feedback">
                            <?php
                            $value1 = "";
                            if (!empty($this->request->query['select_MaterialAdditional_id'])) {
                                $dataMaterialAdditional = ClassRegistry::init("MaterialAdditional")->find("first", [
                                    "conditions" => [
                                        "MaterialAdditional.id" => $this->request->query['select_MaterialAdditional_id']
                                    ],
                                    "contain" => [
                                        "Parent"
                                    ]
                                ]);
                                $value1 = $dataMaterialAdditional['Parent']['name'] . " " . $dataMaterialAdditional['MaterialAdditional']['name'];
                            }
                            ?>
                            <label><?= __("Nomor Produk") ?></label>
                            <input type="text" placeholder="Cari Nama Produk ..." class="form-control typeahead-ajax-product" value="<?= $value1 ?>">
                            <input type="hidden" name="select.MaterialAdditional.id" id="produk">
                            <i class="icon-search3 form-control-feedback"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-3">
                        <label><?= __("Periode Stok Opname") ?></label>
                        <?= $this->Form->input(null, ["type" => "text", "div" => false, "label" => false, "class" => "form-control datepicker", "default" => isset($this->request->query["awal_MaterialAdditionalOpnameStock_opname_date"]) ? $this->request->query['awal_MaterialAdditionalOpnameStock_opname_date'] : "", "name" => "awal.MaterialAdditionalOpnameStock.opname_date", "id" => "startDate", "placeholder" => "Periode Awal"]) ?>
                    </div>
                    <div class="col-md-3">
                        <label><?= __("&nbsp;") ?></label>
                        <?= $this->Form->input(null, ["type" => "text", "div" => false, "label" => false, "class" => "form-control datepicker", "default" => isset($this->request->query["akhir_MaterialAdditionalOpnameStock_opname_date"]) ? $this->request->query['akhir_MaterialAdditionalOpnameStock_opname_date'] : "", "name" => "akhir.MaterialAdditionalOpnameStock.opname_date", "id" => "startDate", "placeholder" => "Periode Akhir"]) ?>
                    </div>
                    <div class="col-md-6">
                        <label><?= __("Cabang Perusahaan") ?></label>
                        <?= $this->Form->input(null, ["div" => false, "label" => false, "class" => "select-full", "name" => "select.MaterialAdditionalOpnameStock.branch_office_id", "default" => isset($this->request->query['select_MaterialAdditionalOpnameStock_branch_office_id']) ? $this->request->query['select_MaterialAdditionalOpnameStock_branch_office_id'] : "", "options" => $branchOffices, "empty" => "", "placeholder" => "- Semua -"]) ?>
                    </div>
                </div>
            </div>
            <div class="form-actions text-center">
                <input type="button" value="<?= __("Reset") ?>" class="btn btn-danger btn-filter-reset">
                <input type="button" value="<?= __("Cari") ?>" class="btn btn-info btn-filter">
            </div>
        </div>
    </div>
</form>
<script>
    filterReload();
    /* Cari Nama Pegawai */
    var opname = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('stock_opname_number'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        prefetch: '<?= Router::url("/admin/material_additional_opname_stocks/list", true) ?>',
        remote: {
            url: '<?= Router::url("/admin/material_additional_opname_stocks/list", true) ?>' + '?q=%QUERY',
            wildcard: '%QUERY',
        }
    });
    opname.clearPrefetchCache();
    opname.initialize(true);
    $('input.typeahead-ajax').typeahead({
        hint: false,
        highlight: true
    }, {
        name: 'opname',
        display: 'stock_opname_number',
        source: opname.ttAdapter(),
        templates: {
            header: '<center><h5>Data Stok Opname Material Pembantu</h5></center><hr>',
            suggestion: function (data) {
                return '<p> Nomor Stok Opname : ' + data.stock_opname_number + '<br/> Nama Mt. Pembantu : ' + data.material_name + " " + data.material_size + '</p>';
            },
            empty: [
                '<center><h5>Data Stok Opname Material Pembantu</h5></center><hr> <center><p> Hasil Pencarian Anda Tidak Dapat Ditemukan. </p></center>',
            ]
        }
    });
    $('input.typeahead-ajax').bind('typeahead:select', function (ev, suggestion) {
        $("#opnameStock").val(suggestion.id);
    });
</script>

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
        $('input.typeahead-ajax-product').typeahead({
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
        $('input.typeahead-ajax-product').bind('typeahead:select', function (ev, suggestion) {
            $('#produk').val(suggestion.id);
        });
    });
</script>