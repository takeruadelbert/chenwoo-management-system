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
                            <label><?= __("Range Nomor Paket") ?></label>
                            <input type="text" placeholder="Cari Nomor Paket ..." class="form-control typeahead-ajax-start-no-package" value="<?= !empty($this->request->query['start_no_package']) ? $this->request->query['start_no_package'] : "" ?>">
                            <input type="hidden" name="start_no_package" id="startNoPackage">
                            <i class="icon-search3 form-control-feedback"></i>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="has-feedback">
                            <label>&nbsp;</label>
                            <input type="text" placeholder="Cari Nomor Paket ..." class="form-control typeahead-ajax-end-no-package" value="<?= !empty($this->request->query['end_no_package']) ? $this->request->query['end_no_package'] : "" ?>">
                            <input type="hidden" name="end_no_package" id="endNoPackage">
                            <i class="icon-search3 form-control-feedback"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-actions text-center">
                <input type="button" value="<?= __("Reset") ?>" class="btn btn-danger btn-filter-reset">
                <a href="" target="_blank"><button class="btn btn-info btn-filter">Cari</button></a>
            </div>
        </div>
    </div>
</form>
<script>
    filterReload();
    var startNoPackage = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('package_no'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        prefetch: '<?= Router::url("/admin/package_details/package_no_list", true) ?>',
        remote: {
            url: '<?= Router::url("/admin/package_details/package_no_list", true) ?>' + '?q=%QUERY',
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
                return '<p> Nomor Paket : ' + data.package_no + '</p>';
            },
            empty: [
                '<center><h5>Data Nomor Paket</h5></center><hr> <center><p> Hasil Pencarian Anda Tidak Dapat Ditemukan. </p></center>',
            ]
        }
    });
    $('input.typeahead-ajax-start-no-package').bind('typeahead:select', function (ev, suggestion) {
        $("#startNoPackage").val(suggestion.package_no);
    });
    
    var endNoPackage = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('package_no'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        prefetch: '<?= Router::url("/admin/package_details/package_no_list", true) ?>',
        remote: {
            url: '<?= Router::url("/admin/package_details/package_no_list", true) ?>' + '?q=%QUERY',
            wildcard: '%QUERY',
        }
    });
    endNoPackage.clearPrefetchCache();
    endNoPackage.initialize(true);
    $('input.typeahead-ajax-end-no-package').typeahead({
        hint: false,
        highlight: true
    }, {
        name: 'endNoPackage',
        display: 'package_no',
        source: endNoPackage.ttAdapter(),
        templates: {
            header: '<center><h5>Data Nomor Paket</h5></center><hr>',
            suggestion: function (data) {
                return '<p> Nomor Paket : ' + data.package_no + '</p>';
            },
            empty: [
                '<center><h5>Data Nomor Paket</h5></center><hr> <center><p> Hasil Pencarian Anda Tidak Dapat Ditemukan. </p></center>',
            ]
        }
    });
    $('input.typeahead-ajax-end-no-package').bind('typeahead:select', function (ev, suggestion) {
        $("#endNoPackage").val(suggestion.package_no);
    });
</script>