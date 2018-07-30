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
                            if (!empty($this->request->query['select_CooperativeOpnameStock_id'])) {
                                $dataStockOpname = ClassRegistry::init("CooperativeOpnameStock")->find("first", [
                                    "conditions" => [
                                        "CooperativeOpnameStock.id" => $this->request->query['select_CooperativeOpnameStock_id']
                                    ]
                                ]);
                                $value = $dataStockOpname['CooperativeOpnameStock']['opname_stock_number'];
                            }
                            ?>
                            <label><?= __("Nomor Stok Opname") ?></label>
                            <input type="text" placeholder="Cari Nomor Stok Opname ..." class="form-control typeahead-ajax" value="<?= $value ?>">
                            <input type="hidden" name="select.CooperativeOpnameStock.id" id="opnameStock">
                            <i class="icon-search3 form-control-feedback"></i>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label><?= __("Nama Barang") ?></label>
                        <?= $this->Form->input(null, ["div" => false, "label" => false, "class" => "form-control tip", "name" => "CooperativeGoodList.name", "default" => isset($this->request->query['CooperativeGoodList_name']) ? $this->request->query['CooperativeGoodList_name'] : ""]) ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <label><?= __("Cabang Perusahaan") ?></label>
                        <?= $this->Form->input(null, ["div" => false, "label" => false, "class" => "select-full", "name" => "select.CooperativeOpnameStock.branch_office_id", "default" => isset($this->request->query['select_CooperativeOpnameStock_branch_office_id']) ? $this->request->query['select_CooperativeOpnameStock_branch_office_id'] : "", "options" => $branchOffices, "empty" => "", "placeholder" => "- Semua -"]) ?>
                    </div>
                    <div class="col-md-6">
                        <div class="has-feedback">
                            <?php
                            $employee = "";
                            if (isset($this->request->query['select_CooperativeOpnameStock_employee_id'])) {
                                $employee = ClassRegistry::init("Employee")->find("first", [
                                    "conditions" => [
                                        "Employee.id" => $this->request->query['select_CooperativeOpnameStock_employee_id']
                                    ],
                                    "contain" => [
                                        "Account" => [
                                            "Biodata"
                                        ]
                                    ]
                                ]);
                            }
                            ?>
                            <label><?= __("Nama Pegawai") ?></label>
                            <input type="text" placeholder="Cari Nama Pegawai ..." class="form-control typeahead-ajax-employee" value="<?= !empty($employee) ? $employee['Account']['Biodata']['full_name'] : "" ?>">
                            <input type="hidden" name="select.CooperativeOpnameStock.employee_id" id="employee">
                            <i class="icon-search3 form-control-feedback"></i>
                        </div>
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
        prefetch: '<?= Router::url("/admin/cooperative_opname_stocks/list", true) ?>',
        remote: {
            url: '<?= Router::url("/admin/cooperative_opname_stocks/list", true) ?>' + '?q=%QUERY',
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
            header: '<center><h5>Data Stock Opname</h5></center><hr>',
            suggestion: function (data) {
                return '<p> Nomor Stok Opname : ' + data.stock_opname_number + '<br/> Nama Barang : ' + data.good_name + '</p>';
            },
            empty: [
                '<center><h5>Data Stock Opname</h5></center><hr> <center><p> Hasil Pencarian Anda Tidak Dapat Ditemukan. </p></center>',
            ]
        }
    });
    $('input.typeahead-ajax').bind('typeahead:select', function (ev, suggestion) {
        $("#opnameStock").val(suggestion.id);
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