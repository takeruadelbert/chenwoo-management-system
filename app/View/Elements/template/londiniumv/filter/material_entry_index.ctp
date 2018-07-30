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
                        <?php
                        $materialEntry = "";
                        if (isset($this->request->query['select_MaterialEntry_id'])) {
                            $materialEntry = ClassRegistry::init("MaterialEntry")->find("first", [
                                "conditions" => [
                                    "MaterialEntry.id" => $this->request->query['select_MaterialEntry_id']
                                ],
                            ]);
                        }
                        ?>
                        <label><?= __("Nomor Nota Timbang") ?></label>
                        <div class="has-feedback">
                            <input type="text" placeholder="Silahkan Cari Nomor Nota Timbang ..." class="form-control typeahead-ajax-material" value="<?= !empty($materialEntry) ? $materialEntry['MaterialEntry']['material_entry_number'] : "" ?>">
                            <input type="hidden" name="select.MaterialEntry.id" id="materialEntry">
                            <i class="icon-search3 form-control-feedback" style = "top:0px;"></i>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="has-feedback">
                            <?php
                            $employee = "";
                            if (isset($this->request->query['select_MaterialEntry_employee_id'])) {
                                $employee = ClassRegistry::init("Employee")->find("first", [
                                    "conditions" => [
                                        "Employee.id" => $this->request->query['select_MaterialEntry_employee_id']
                                    ],
                                    "contain" => [
                                        "Account" => [
                                            "Biodata"
                                        ]
                                    ]
                                ]);
                            }
                            ?>
                            <label><?= __("Penanggung Jawab") ?></label>
                            <input type="text" placeholder="Cari Nama Pegawai ..." class="form-control typeahead-ajax-employee" value="<?= !empty($employee) ? $employee['Account']['Biodata']['full_name'] : "" ?>">
                            <input type="hidden" name="select.MaterialEntry.employee_id" id="employee">
                            <i class="icon-search3 form-control-feedback"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-3">
                        <label><?= __("Periode Nota Timbang") ?></label>
                        <?= $this->Form->input(null, ["default" => isset($this->request->query['awal_MaterialEntry_weight_date']) ? $this->request->query['awal_MaterialEntry_weight_date'] : '', "name" => "awal.MaterialEntry.weight_date", "class" => "form-control datepicker", "id" => "startDate", "div" => false, "label" => false, "placeholder" => "Awal Periode"]) ?>
                    </div>
                    <div class="col-md-3">
                        <label><?= __("&nbsp;") ?></label>
                        <?= $this->Form->input(null, ["default" => isset($this->request->query['akhir_MaterialEntry_weight_date']) ? $this->request->query['akhir_MaterialEntry_weight_date'] : '', "name" => "akhir.MaterialEntry.weight_date", "class" => "form-control datepicker", "id" => "endDate", "div" => false, "label" => false, "placeholder" => "Akhir Periode"]) ?>
                    </div>
                    <div class="col-md-6">
                        <label><?= __("Status") ?></label>
                        <?= $this->Form->input(null, ["default" => isset($this->request->query['select_MaterialEntry_verify_status_id']) ? $this->request->query['select_MaterialEntry_verify_status_id'] : '', "name" => "select.MaterialEntry.verify_status_id", "class" => "select-full", "div" => false, "label" => false, "options" => $verifyStatuses, "empty" => "", "placeholder" => "- Semua -"]) ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <div class="has-feedback">
                            <?php
                            $pelaksana = "";
                            if (isset($this->request->query['select_MaterialEntry_operator_id'])) {
                                $pelaksana = ClassRegistry::init("Employee")->find("first", [
                                    "conditions" => [
                                        "Employee.id" => $this->request->query['select_MaterialEntry_operator_id']
                                    ],
                                    "contain" => [
                                        "Account" => [
                                            "Biodata"
                                        ]
                                    ]
                                ]);
                            }
                            ?>
                            <label><?= __("Pelaksana") ?></label>
                            <input type="text" placeholder="Cari Nama Pegawai ..." class="form-control typeahead-ajax-pelaksana" value="<?= !empty($pelaksana) ? $pelaksana['Account']['Biodata']['full_name'] : "" ?>">
                            <input type="hidden" name="select.MaterialEntry.operator_id" id="pelaksana">
                            <i class="icon-search3 form-control-feedback"></i>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label><?= __("Cabang Perusahaan") ?></label>
                        <?= $this->Form->input(null, ["default" => isset($this->request->query['select_MaterialEntry_branch_office_id']) ? $this->request->query['select_MaterialEntry_branch_office_id'] : '', "name" => "select.MaterialEntry.branch_office_id", "class" => "select-full", "div" => false, "label" => false, "options" => $branchOffices, "empty" => "", "placeholder" => "- Semua -"]) ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <div class="has-feedback">
                            <?php
                            $supplier = "";
                            if (isset($this->request->query['select_MaterialEntry_supplier_id'])) {
                                $supplier = ClassRegistry::init("Supplier")->find("first", [
                                    "conditions" => [
                                        "Supplier.id" => $this->request->query['select_MaterialEntry_supplier_id']
                                    ]
                                ]);
                            }
                            ?>
                            <label><?= __("Supplier") ?></label>
                            <input type="text" placeholder="Cari Nama Supplier ..." class="form-control typeahead-ajax-supplier" value="<?= !empty($supplier) ? $supplier['Supplier']['name']: "" ?>">
                            <input type="hidden" name="select.MaterialEntry.supplier_id" id="supplier">
                            <i class="icon-search3 form-control-feedback"></i>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label><?= __("Tipe Material") ?></label>
                        <?= $this->Form->input(null, ["default" => isset($this->request->query['select_MaterialEntry_material_category_id']) ? $this->request->query['select_MaterialEntry_material_category_id'] : '', "name" => "select.MaterialEntry.material_category_id", "class" => "select-full", "div" => false, "label" => false, "options" => $materialCategories, "empty" => "", "placeholder" => "- Semua -"]) ?>
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
    $(document).ready(function () {
        var material = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('material_entry_number'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            prefetch: '<?= Router::url("/admin/material_entries/list_normal", true) ?>',
            remote: {
                url: '<?= Router::url("/admin/material_entries/list_normal", true) ?>' + '?q=%QUERY',
                wildcard: '%QUERY',
            }
        });
        material.clearPrefetchCache();
        material.initialize(true);
        $('input.typeahead-ajax-material').typeahead({
            hint: false,
            highlight: true
        }, {
            name: 'material',
            display: 'material_entry_number',
            source: material.ttAdapter(),
            templates: {
                header: '<center><h5>Data Nota Timbang</h5></center><hr>',
                suggestion: function (context) {
                    return '<p>Nomor Nota Timbang : ' + context.material_entry_number + '<br>Tanggal Dibuat : ' + cvtTanggal(context.created_date) + '<br>Supplier : ' + context.supplier_name + '</p>';
                },
                empty: [
                    '<center><h5>Data Nota Timbang</h5></center><hr> <center><p> Hasil Pencarian Anda Tidak Dapat Ditemukan. </p></center>',
                ]
            }
        });
        $('input.typeahead-ajax-material').bind('typeahead:select', function (ev, suggestion) {
            $('#materialEntry').val(suggestion.id);
            $('#martsNumber').val(suggestion.material_entry_number);
            $('#invoice').val(suggestion.total_invoice);
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
<script>
    filterReload();
    /* Cari Nama Pegawai */
    var pelaksana = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('full_name'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        prefetch: '<?= Router::url("/admin/employees/list", true) ?>',
        remote: {
            url: '<?= Router::url("/admin/employees/list", true) ?>' + '?q=%QUERY',
            wildcard: '%QUERY',
        }
    });
    pelaksana.clearPrefetchCache();
    pelaksana.initialize(true);
    $('input.typeahead-ajax-pelaksana').typeahead({
        hint: false,
        highlight: true
    }, {
        name: 'employee',
        display: 'full_name',
        source: pelaksana.ttAdapter(),
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
    $('input.typeahead-ajax-pelaksana').bind('typeahead:select', function (ev, suggestion) {
        $("#pelaksana").val(suggestion.id);
    });
</script>
<script>
    filterReload();
    /* Cari Nama Pegawai */
    var supplier = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        prefetch: '<?= Router::url("/admin/suppliers/list", true) ?>',
        remote: {
            url: '<?= Router::url("/admin/suppliers/list", true) ?>' + '?q=%QUERY',
            wildcard: '%QUERY',
        }
    });
    supplier.clearPrefetchCache();
    supplier.initialize(true);
    $('input.typeahead-ajax-supplier').typeahead({
        hint: false,
        highlight: true
    }, {
        name: 'supplier',
        display: 'name',
        source: supplier.ttAdapter(),
        templates: {
            header: '<center><h5>Data Supplier</h5></center><hr>',
            suggestion: function (data) {
                return '<p> Nama : ' + data.name + '<br/>' + '</p>';
            },
            empty: [
                '<center><h5>Data Supplier</h5></center><hr> <center><p> Hasil Pencarian Anda Tidak Dapat Ditemukan. </p></center>',
            ]
        }
    });
    $('input.typeahead-ajax-supplier').bind('typeahead:select', function (ev, suggestion) {
        $("#supplier").val(suggestion.id);
    });
</script>

