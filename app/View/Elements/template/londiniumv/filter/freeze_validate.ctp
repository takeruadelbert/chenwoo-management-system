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
                        <label><?= __("Nomor Nota Timbang") ?></label>
                        <?= $this->Form->input(null, ["div" => false, "label" => false, "class" => "form-control tip", "name" => "MaterialEntry.material_entry_number", "default" => isset($this->request->query['MaterialEntry_material_entry_number']) ? $this->request->query['MaterialEntry_material_entry_number'] : ""]) ?>
                    </div>
                    <div class="col-md-6">
                        <label><?= __("Nomor Konversi") ?></label>
                        <?= $this->Form->input(null, ["div" => false, "label" => false, "class" => "form-control tip", "name" => "Conversion.no_conversion", "default" => isset($this->request->query['Conversion_no_conversion']) ? $this->request->query['Conversion_no_conversion'] : ""]) ?>
                    </div>
                    <!--                    <div class="col-md-6">
                    <?php
                    $konversi = "";
                    if (isset($this->request->query['select_Conversion_id'])) {
                        $konversi = ClassRegistry::init("Conversion")->find("first", [
                            "conditions" => [
                                "Conversion.id" => $this->request->query['select_Conversion_id']
                            ],
                        ]);
                    }
                    ?>
                                            <label><?= __("Nomor Konversi") ?></label>
                                            <div class="has-feedback">
                                                <input type="text" placeholder="Silahkan Cari Nomor Konversi ..." class="form-control typeahead-ajax-conversion" value="<?= !empty($konversi) ? $konversi['Conversion']['no_conversion'] : "" ?>">
                                                <input type="hidden" name="select.Conversion.id" id="conversionNumber">
                                                <i class="icon-search3 form-control-feedback" style = "top:0px;"></i>
                                            </div>
                                        </div>  -->   
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <label><?= __("Nomor Styling") ?></label>
                        <?php
                        if (isset($this->request->query['select_Freeze_id'])) {
                            $number = ClassRegistry::init("Freeze")->find("first", ["conditions" => ["Freeze.id" => $this->request->query['select_Freeze_id']]]);
                            if (!empty($number)) {
                                $numbers = $number['Freeze']['freeze_number'];
                            } else {
                                $numbers = "";
                            }
                        } else {
                            $numbers = "";
                        }
                        echo $this->Form->input(null, ["div" => false, "label" => false, "type" => "hidden", "name" => "select.Freeze.id", "id" => "freezeNumber"])
                        ?>
                        <div class="has-feedback">
                            <input type="text" placeholder="Silahkan Cari Nomor Styling ..." class="form-control typeahead-ajax-transaction1" value="<?= $numbers ?>">
                            <i class="icon-search3 form-control-feedback" style = "top:0px;"></i>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="has-feedback">
                            <?php
                            $employee = "";
                            if (isset($this->request->query['Freeze_employee_id'])) {
                                $employee = ClassRegistry::init("Employee")->find("first", [
                                    "conditions" => [
                                        "Employee.id" => $this->request->query['Freeze_employee_id']
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
                            <input type="hidden" name="Freeze.employee_id" id="employee">
                            <i class="icon-search3 form-control-feedback"></i>
                        </div>
                    </div> 
                </div> 
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <label><?= __("Tipe Material") ?></label>
                        <?= $this->Form->input(null, ["default" => isset($this->request->query['select_MaterialEntry_material_category_id']) ? $this->request->query['select_MaterialEntry_material_category_id'] : '', "name" => "select.MaterialEntry.material_category_id", "class" => "select-full", "div" => false, "label" => false, "options" => $materialCategories, "empty" => "", "placeholder" => "- Semua -"]) ?>
                    </div>
                    <div class="col-md-3">
                        <label><?= __("Periode Dibuat") ?></label>
                        <?= $this->Form->input(null, ["default" => isset($this->request->query['awal_Freeze_created']) ? $this->request->query['awal_Freeze_created'] : '', "name" => "awal.Freeze.created", "class" => "form-control datepicker", "id" => "startDate", "div" => false, "label" => false, "placeholder" => "Awal Periode"]) ?>
                    </div>
                    <div class="col-md-3">
                        <label><?= __("&nbsp;") ?></label>
                        <?= $this->Form->input(null, ["default" => isset($this->request->query['akhir_Freeze_created']) ? $this->request->query['akhir_Freeze_created'] : '', "name" => "akhir.Freeze.created", "class" => "form-control datepicker", "id" => "endDate", "div" => false, "label" => false, "placeholder" => "Akhir Periode"]) ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <label><?= __("Cabang Perusahaan") ?></label>
                        <?= $this->Form->input(null, ["default" => isset($this->request->query['select_Freeze_branch_office_id']) ? $this->request->query['select_Freeze_branch_office_id'] : '', "name" => "select.Freeze.branch_office_id", "class" => "select-full", "div" => false, "label" => false, "options" => $branchOffices, "empty" => "", "placeholder" => "- Semua -"]) ?>
                    </div>
                    <div class="col-md-3">
                        <label><?= __("Periode Nota Timbang") ?></label>
                        <?= $this->Form->input(null, ["default" => isset($this->request->query['awal_MaterialEntry_weight_date']) ? $this->request->query['awal_MaterialEntry_weight_date'] : '', "name" => "awal.MaterialEntry.weight_date", "class" => "form-control datepicker", "id" => "startDateMaterialEntry", "div" => false, "label" => false, "placeholder" => "Awal Periode Nota Timbang"]) ?>
                    </div>
                    <div class="col-md-3">
                        <label><?= __("&nbsp;") ?></label>
                        <?= $this->Form->input(null, ["default" => isset($this->request->query['akhir_MaterialEntry_weight_date']) ? $this->request->query['akhir_MaterialEntry_weight_date'] : '', "name" => "akhir.MaterialEntry.weight_date", "class" => "form-control datepicker", "id" => "endDateMaterialEntry", "div" => false, "label" => false, "placeholder" => "Akhir Periode Nota Timbang"]) ?>
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

