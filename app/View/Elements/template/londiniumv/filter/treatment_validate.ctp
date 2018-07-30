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
                        if (isset($this->request->query['select_Treatment_id'])) {
                            $number = ClassRegistry::init("Treatment")->find("first", ["conditions" => ["Treatment.id" => $this->request->query['select_Treatment_id']]]);
                            if (!empty($number)) {
                                $numbers = $number['Treatment']['treatment_number'];
                            } else {
                                $numbers = "";
                            }
                        } else {
                            $numbers = "";
                        }
                        echo $this->Form->input(null, ["div" => false, "label" => false, "type" => "hidden", "name" => "select.Treatment.id", "id" => "treatmentNumber"])
                        ?>
                        <label><?= __("Nomor Treatment") ?></label>
                        <div class="has-feedback">
                            <input type="text" placeholder="Silahkan Cari Nomor Treatment ..." class="form-control typeahead-ajax" value="<?= $numbers ?>">
                            <i class="icon-search3 form-control-feedback" style = "top:0px;"></i>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label><?= __("Nomor Styling") ?></label>
                        <?= $this->Form->input(null, ["div" => false, "label" => false, "class" => "form-control tip", "name" => "Freeze.freeze_number", "default" => isset($this->request->query['Freeze_freeze_number']) ? $this->request->query['Freeze_freeze_number'] : ""]) ?>
                    </div>
                    <!--                    <div class="col-md-6">
                                            <label><?= __("Nomor Pembekuan") ?></label>
                    <?php
                    if (isset($this->request->query['Freeze_id'])) {
                        $number = ClassRegistry::init("Freeze")->find("first", ["conditions" => ["Freeze.id" => $this->request->query['Freeze_id']]]);
                        if (!empty($number)) {
                            $numbers = $number['Freeze']['freeze_number'];
                        } else {
                            $numbers = "";
                        }
                    } else {
                        $numbers = "";
                    }
                    echo $this->Form->input(null, ["div" => false, "label" => false, "type" => "hidden", "name" => "Freeze.id", "id" => "freezeNumber"])
                    ?>
                                            <div class="has-feedback">
                                                <input type="text" placeholder="Silahkan Cari Nomor Pembekuan ..." class="form-control typeahead-ajax-transaction1" value="<?= $numbers ?>">
                                                <i class="icon-search3 form-control-feedback" style = "top:0px;"></i>
                                            </div>
                                        </div>-->
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <div class="has-feedback">
                            <?php
                            $employee = "";
                            if (isset($this->request->query['Treatment_employee_id'])) {
                                $employee = ClassRegistry::init("Employee")->find("first", [
                                    "conditions" => [
                                        "Employee.id" => $this->request->query['Treatment_employee_id']
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
                            <input type="hidden" name="Treatment.employee_id" id="employee">
                            <i class="icon-search3 form-control-feedback"></i>
                        </div>
                    </div>  
                    <div class="col-md-3">
                        <label><?= __("Periode Treatment") ?></label>
                        <?= $this->Form->input(null, ["default" => isset($this->request->query['awal_Treatment_created']) ? $this->request->query['awal_Treatment_created'] : '', "name" => "awal.Treatment.created", "class" => "form-control datepicker", "id" => "startDate", "div" => false, "label" => false, "placeholder" => "Awal Periode"]) ?>
                    </div>
                    <div class="col-md-3">
                        <label><?= __("&nbsp;") ?></label>
                        <?= $this->Form->input(null, ["default" => isset($this->request->query['akhir_Treatment_created']) ? $this->request->query['akhir_Treatment_created'] : '', "name" => "akhir.Treatment.created", "class" => "form-control datepicker", "id" => "endDate", "div" => false, "label" => false, "placeholder" => "Akhir Periode"]) ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <label><?= __("Cabang Perusahaan") ?></label>
                        <?= $this->Form->input(null, ["default" => isset($this->request->query['select_Treatment_branch_office_id']) ? $this->request->query['select_Treatment_branch_office_id'] : '', "name" => "select.Treatment.branch_office_id", "class" => "select-full", "div" => false, "label" => false, "options" => $branchOffices, "empty" => "", "placeholder" => "- Semua -"]) ?>
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
</script>
<script>
    $(document).ready(function () {
        var dataTreatment = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('treatment_number'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            prefetch: '<?= Router::url("/admin/treatments/list_treatment_validate", true) ?>',
            remote: {
                url: '<?= Router::url("/admin/treatments/list_treatment_validate", true) ?>' + '?q=%QUERY',
                wildcard: '%QUERY',
            }
        });
        dataTreatment.clearPrefetchCache();
        dataTreatment.initialize(true);
        $('input.typeahead-ajax').typeahead({
            hint: false,
            highlight: true
        }, {
            name: 'dataTreatment',
            display: 'treatment_number',
            source: dataTreatment.ttAdapter(),
            templates: {
                header: '<center><h5>Data Treatment</h5></center><hr>',
                suggestion: function (context) {
                    return '<p>Nomor Treatment Barang : ' + context.treatment_number + '<br>Berat : ' + context.total + ' Kg' + '<br>Ratio : ' + context.ratio + ' %<br>Penanggungjawab : ' + context.full_name + '</p>';
                },
                empty: [
                    '<center><h5>Data Treatment</h5></center><hr> <center><p> Hasil Pencarian Anda Tidak Dapat Ditemukan. </p></center>',
                ]
            }
        });
        $('input.typeahead-ajax').bind('typeahead:select', function (ev, suggestion) {
            $('#treatmentNumber').val(suggestion.id);
        });
    })
</script>

<script>
    filterReload();

    $(document).ready(function () {
        var freeze = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('freeze_number'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            prefetch: '<?= Router::url("/admin/freezes/list", true) ?>',
            remote: {
                url: '<?= Router::url("/admin/freezes/list", true) ?>' + '?q=%QUERY',
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