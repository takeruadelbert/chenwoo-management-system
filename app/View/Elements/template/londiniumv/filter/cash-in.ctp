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
                            $cashIn = "";
                            if (isset($this->request->query['select_CashIn_id'])) {
                                $cashIn = ClassRegistry::init("CashIn")->find("first", [
                                    "conditions" => [
                                        "CashIn.id" => $this->request->query['select_CashIn_id']
                                    ],
                                ]);
                            }
                            ?>
                            <label><?= __("Nomor Kas Masuk") ?></label>
                            <input type="text" placeholder="Cari Nomor Kas Masuk ..." class="form-control typeahead-ajax-cashIn" value="<?= !empty($cashIn) ? $cashIn['CashIn']['cash_in_number'] : "" ?>">
                            <input type="hidden" name="select.CashIn.id" id="cashIn">
                            <i class="icon-search3 form-control-feedback"></i>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="has-feedback">
                            <?php
                            $employee = "";
                            if (isset($this->request->query['select_Creator_id'])) {
                                $employee = ClassRegistry::init("Employee")->find("first", [
                                    "conditions" => [
                                        "Employee.id" => $this->request->query['select_Creator_id']
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
                            <input type="hidden" name="select.Creator.id" id="employee">
                            <i class="icon-search3 form-control-feedback"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <label><?= __("Tipe Kas") ?></label>
                        <?= $this->Form->input(null, ["default" => isset($this->request->query['select_CashIn_initial_balance_id']) ? $this->request->query['select_CashIn_initial_balance_id'] : 0, "name" => "select.CashIn.initial_balance_id", "options" => $initialBalances, "class" => "select-full", "div" => false, "label" => false, "empty" => "", "placeholder" => "- Semua -"]) ?>
                    </div>
                    <div class="col-md-3">
                        <label><?= __("Periode Kas") ?></label>
                        <?= $this->Form->input(null, ["type" => "text", "div" => false, "placeholder" => "Awal Periode", "label" => false, "class" => "form-control datetime", "default" => isset($this->request->query["awal_CashIn_created_datetime"]) ? $this->request->query['awal_CashIn_created_datetime'] : "", "name" => "awal.CashIn.created_datetime", "id" => "awal.CashIn.created_datetime"]) ?>
                    </div>
                    <div class="col-md-3">
                        <label><?= __("&nbsp;") ?></label>
                        <?= $this->Form->input(null, ["type" => "text", "div" => false, "placeholder" => "Akhir Periode", "label" => false, "class" => "form-control datetime", "default" => isset($this->request->query["akhir_CashIn_created_datetime"]) ? $this->request->query['akhir_CashIn_created_datetime'] : "", "name" => "akhir.CashIn.created_datetime", "id" => "akhir.CashIn.created_datetime"]) ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <label><?= __("Cabang Perusahaan") ?></label>
                        <?= $this->Form->input(null, ["default" => isset($this->request->query['select_CashIn_branch_office_id']) ? $this->request->query['select_CashIn_branch_office_id'] : '', "name" => "select.CashIn.branch_office_id", "class" => "select-full", "div" => false, "label" => false, "options" => $branchOffices, "empty" => "", "placeholder" => "- Semua -"]) ?>
                    </div>
                    <div class="col-md-6">
                        <label><?= __("Keterangan") ?></label>
                        <?= $this->Form->input(null, ["default" => isset($this->request->query['CashIn_note']) ? $this->request->query['CashIn_note'] : '', "name" => "CashIn.note", "class" => "form-control", "div" => false, "label" => false, 'placeholder' => 'Keterangan ...']) ?>
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
    /* Cari Nomor Kas Masuk */
    var cashIn = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('cash_in_number'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        prefetch: '<?= Router::url("/admin/cash_ins/list", true) ?>',
        remote: {
            url: '<?= Router::url("/admin/cash_ins/list", true) ?>' + '?q=%QUERY',
            wildcard: '%QUERY',
        }
    });
    cashIn.clearPrefetchCache();
    cashIn.initialize(true);
    $('input.typeahead-ajax-cashIn').typeahead({
        hint: false,
        highlight: true
    }, {
        name: 'cashIn',
        display: 'cash_in_number',
        source: cashIn.ttAdapter(),
        templates: {
            header: '<center><h5>Data Kas Masuk</h5></center><hr>',
            suggestion: function (data) {
                return '<p> Nomor Kas Masuk : ' + data.cash_in_number + '<br/> Nominal : ' + RP(data.amount) + '<br/> Tanggal : ' + cvtWaktu(data.created_datetime) + '</p>';
            },
            empty: [
                '<center><h5>Data Kas Masuk</h5></center><hr> <center><p> Hasil Pencarian Anda Tidak Dapat Ditemukan. </p></center>',
            ]
        }
    });
    $('input.typeahead-ajax-cashIn').bind('typeahead:select', function (ev, suggestion) {
        $("#cashIn").val(suggestion.id);
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