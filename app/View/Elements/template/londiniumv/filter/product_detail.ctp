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
                        <label><?= __("Produk") ?></label>
                        <?= $this->Form->input(null, ["div" => false, "label" => false, "options" => $products, "class" => "select-full", "empty" => "", "placeholder" => "- Semua -", "name" => "select.ProductDetail.product_id", "default" => isset($this->request->query['select_ProductDetail_product_id']) ? $this->request->query['select_ProductDetail_product_id'] : ""]) ?>
                    </div>
                    <div class="col-md-6">
                        <label><?= __("PDC") ?></label>
                        <?= $this->Form->input(null, ["div" => false, "label" => false, "class" => "form-control tip", "name" => "ProductDetail.batch_number", "default" => isset($this->request->query['ProductDetail_batch_number']) ? $this->request->query['ProductDetail_batch_number'] : ""]) ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-3">
                        <label><?= __("Periode Tanggal") ?></label>
                        <?= $this->Form->input(null, ["default" => isset($this->request->query['awal_ProductDetail_production_date']) ? $this->request->query['awal_ProductDetail_production_date'] : '', "name" => "awal.ProductDetail.production_date", "class" => "form-control datepicker", "id" => "startDate", "div" => false, "label" => false, "placeholder" => "Awal Periode"]) ?>
                    </div>
                    <div class="col-md-3">
                        <label><?= __("&nbsp;") ?></label>
                        <?= $this->Form->input(null, ["default" => isset($this->request->query['akhir_ProductDetail_production_date']) ? $this->request->query['akhir_ProductDetail_production_date'] : '', "name" => "akhir.ProductDetail.production_date", "class" => "form-control datepicker", "id" => "endDate", "div" => false, "label" => false, "placeholder" => "Akhir Periode"]) ?>
                    </div>
                    <div class="col-md-6">
                        <label><?= __("Cabang Perusahaan") ?></label>
                        <?= $this->Form->input(null, ["default" => isset($this->request->query['select_ProductDetail_branch_office_id']) ? $this->request->query['select_ProductDetail_branch_office_id'] : '', "name" => "select.ProductDetail.branch_office_id", "class" => "select-full", "div" => false, "label" => false, "options" => $branchOffices, "empty" => "", "placeholder" => "- Semua -"]) ?>
                    </div>  
                </div>
            </div>
            <div class="form-group">
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

    $(document).ready(function () {
        var freeze = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('freeze_number'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            prefetch: '<?= Router::url("/admin/freezes/list_validate", true) ?>',
            remote: {
                url: '<?= Router::url("/admin/freezes/list_validate", true) ?>' + '?q=%QUERY',
                wildcard: '%QUERY',
            }
        });
        freeze.clearPrefetchCache();
        freeze.initialize(true);
        $('input.typeahead-ajax-transaction1').typeahead({
            hint: false,
            highlight: true
        }, {
            name: 'freeze',
            display: 'freeze_number',
            source: freeze.ttAdapter(),
            templates: {
                header: '<center><h5>Data Pembekuan</h5></center><hr>',
                suggestion: function (context) {
                    return '<p>Nomor Pembekuan : ' + context.freeze_number + '<br>Berat Pembekuan : ' + IDR(context.total_weight) + ' Kg' + '<br>Ratio Pembekuan : ' + context.ratio + ' %' + '<br>Dibuat oleh : ' + context.fullname + '</p>';
                },
                empty: [
                    '<center><h5>Data Pembekuan</h5></center><hr> <center><p> Hasil Pencarian Anda Tidak Dapat Ditemukan. </p></center>',
                ]
            }
        });
        $('input.typeahead-ajax-transaction1').bind('typeahead:select', function (ev, suggestion) {
            $('#freezeNumber ').val(suggestion.id);
        });
    });
</script>
<script>
    filterReload();

    $(document).ready(function () {
        var conversion = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('no_conversion'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            prefetch: '<?= Router::url("/admin/conversions/list_conversion", true) ?>',
            remote: {
                url: '<?= Router::url("/admin/conversions/list_conversion", true) ?>' + '?q=%QUERY',
                wildcard: '%QUERY',
            }
        });
        conversion.clearPrefetchCache();
        conversion.initialize(true);
        $('input.typeahead-ajax-conversion').typeahead({
            hint: false,
            highlight: true
        }, {
            name: 'conversion',
            display: 'no_conversion',
            source: conversion.ttAdapter(),
            templates: {
                header: '<center><h5>Data Konversi</h5></center><hr>',
                suggestion: function (context) {
                    return '<p>Nomor Konversi : ' + context.no_conversion + '<br>Berat Konversi : ' + IDR(context.conversion_weight) + ' Kg' + '<br>Ratio Konversi : ' + context.conversion_ratio + ' %' + '<br>Dibuat oleh : ' + context.fullname + '</p>';
                },
                empty: [
                    '<center><h5>Data Konversi</h5></center><hr> <center><p> Hasil Pencarian Anda Tidak Dapat Ditemukan. </p></center>',
                ]
            }
        });
        $('input.typeahead-ajax-conversion').bind('typeahead:select', function (ev, suggestion) {
            $('#conversionNumber').val(suggestion.id);
        });
    });
</script>

<script>
    filterReload();
    /* Cari Nama Pegawai */
    var employee = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('full_name'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        prefetch: '<?= Router::url("/admin/employees/list", true) ?>',
        remote: {
            url: '<?= Router::url("/admin/employees/list", true) ?>' + '?q=%QUERY',
            wildcard: '%QUERY',
        }
    });
    employee.clearPrefetchCache();
    employee.initialize(true);
    $('input.typeahead-ajax-employee').typeahead({
        hint: false,
        highlight: true
    }, {
        name: 'employee',
        display: 'full_name',
        source: employee.ttAdapter(),
        templates: {
            header: '<center><h5>Data Pegawai</h5></center><hr>',
            suggestion: function (data) {
                return '<p> Nama : ' + data.full_name + '<br/> NIP Pegawai : ' + data.nip + '<br/> Department : ' + data.department + '<br/> Position : ' + data.jabatan + '</p>';
            },
            empty: [
                '<center><h5>Data Pegawai</h5></center><hr> <center><p> Hasil Pencarian Anda Tidak Dapat Ditemukan. </p></center>',
            ]
        }
    });
    $('input.typeahead-ajax-employee').bind('typeahead:select', function (ev, suggestion) {
        $("#employee").val(suggestion.id);
    });
</script>

