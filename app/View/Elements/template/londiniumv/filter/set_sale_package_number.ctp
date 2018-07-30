<form action="#" role="form" class="panel-filter" target="_blank">
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
                            <label><?= __("Nomor Paket") ?></label>
                            <input type="text" placeholder="Cari Nomor Paket ..." class="form-control typeahead-ajax-start-no-package" value="<?= !empty($this->request->query['start_no_package']) ? $this->request->query['start_no_package'] : "" ?>">
                            <input type="hidden" name="package_id" id="startNoPackage">
                            <i class="icon-search3 form-control-feedback"></i>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="has-feedback">
                            <label>&nbsp;</label>
                            <label><?= __("Nomor Penjualan") ?></label>
                            <input type="text" placeholder="Cari Nomor Penjualan ..." class="form-control typeahead-ajax-end-no-sale" value="<?= !empty($this->request->query['end_no_package']) ? $this->request->query['end_no_package'] : "" ?>">
                            <input type="hidden" name="no_sale" id="endNoSale">
                            <i class="icon-search3 form-control-feedback"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-actions text-center">
                <input type="button" value="<?= __("Reset") ?>" class="btn btn-danger btn-filter-reset">
                <a href="" target="_blank"><button class="btn btn-info btn-filter">Set</button></a>
            </div>
        </div>
    </div>
</form>
<script>
    filterReload();
    var startNoPackage = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('package_no'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        prefetch: '<?= Router::url("/admin/package_details/package_empty_list", true) ?>',
        remote: {
            url: '<?= Router::url("/admin/package_details/package_empty_list", true) ?>' + '?q=%QUERY',
            wildcard: '%QUERY',
        }
    });
    startNoPackage.clearPrefetchCache();
    startNoPackage.initialize(true);
    $('input.typeahead-ajax-start-no-package').typeahead({
        hint: false,
        highlight: true
    }, {
        name: 'startNoPackage',
        display: 'package_no',
        source: startNoPackage.ttAdapter(),
        templates: {
            header: '<center><h5>Data Nomor Paket</h5></center><hr>',
            suggestion: function (data) {
                return '<p> Nomor Paket : ' + data.package_no +'<br> Produk : '+ data.product + '</p>';
            },
            empty: [
                '<center><h5>Data Nomor Paket</h5></center><hr> <center><p> Hasil Pencarian Anda Tidak Dapat Ditemukan. </p></center>',
            ]
        }
    });
    $('input.typeahead-ajax-start-no-package').bind('typeahead:select', function (ev, suggestion) {
        $("#startNoPackage").val(suggestion.id);
    });
    
    var endNoSale = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('sale_no'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        prefetch: '<?= Router::url("/admin/sales/list", true) ?>',
        remote: {
            url: '<?= Router::url("/admin/sales/list", true) ?>' + '?q=%QUERY',
            wildcard: '%QUERY',
        }
    });
    endNoSale.clearPrefetchCache();
    endNoSale.initialize(true);
    $('input.typeahead-ajax-end-no-sale').typeahead({
        hint: false,
        highlight: true
    }, {
        name: 'endNoSale',
        display: 'sale_no',
        source: endNoSale.ttAdapter(),
        templates: {
            header: '<center><h5>Data Nomor Penjualan</h5></center><hr>',
            suggestion: function (data) {
                return '<p> Nomor Penjualan : ' + data.sale_no +'<br> Nomor PO : '+ data.po_number + '<br> Pembeli : ' + data.buyer_name + '</p>';
            },
            empty: [
                '<center><h5>Data Nomor Paket</h5></center><hr> <center><p> Hasil Pencarian Anda Tidak Dapat Ditemukan. </p></center>',
            ]
        }
    });
    $('input.typeahead-ajax-end-no-sale').bind('typeahead:select', function (ev, suggestion) {
        $("#endNoSale").val(suggestion.id);
    });
</script>