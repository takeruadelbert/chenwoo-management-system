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
                        <label><?= __("Nomor Mutasi") ?></label>
                        <?= $this->Form->input(null, ["default" => isset($this->request->query['CooperativeTransactionMutation_id_number']) ? $this->request->query['CooperativeTransactionMutation_id_number'] : '', "name" => "CooperativeTransactionMutation.id_number", "class" => "form-control", "div" => false, "label" => false]) ?>
                    </div>
                    <div class="col-md-6">
                        <label><?= __("Nomor Transaksi") ?></label>
                        <?= $this->Form->input(null, ["default" => isset($this->request->query['nomor_transaksi']) ? $this->request->query['nomor_transaksi'] : '', "name" => "nomor_transaksi", "class" => "form-control", "div" => false, "label" => false]) ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <div class="has-feedback">
                            <?php
                            $employee = "";
                            if (isset($this->request->query['select_CooperativeTransactionMutation_employee_id'])) {
                                $employee = ClassRegistry::init("Employee")->find("first", [
                                    "conditions" => [
                                        "Employee.id" => $this->request->query['select_CooperativeTransactionMutation_employee_id']
                                    ],
                                    "contain" => [
                                        "Account" => [
                                            "Biodata"
                                        ]
                                    ]
                                ]);
                            }
                            ?>
                            <label><?= __("Pegawai Pelaksana") ?></label>
                            <input type="text" placeholder="Cari Nama Pegawai ..." class="form-control typeahead-ajax-employee" value="<?= !empty($employee) ? $employee['Account']['Biodata']['full_name'] : "" ?>">
                            <input type="hidden" name="select.CooperativeTransactionMutation.employee_id" id="employee" value="<?= @$this->request->query['select_CooperativeTransactionMutation_employee_id'] ?>">
                            <i class="icon-search3 form-control-feedback"></i>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label><?= __("Kas Asal") ?></label>
                        <?= $this->Form->input(null, ["div" => false, "label" => false, "class" => "select-full", "default" => isset($this->request->query["select_CooperativeTransactionMutation_cooperative_cash_id"]) ? $this->request->query['select_CooperativeTransactionMutation_cooperative_cash_id'] : "", "name" => "select.CooperativeTransactionMutation.cooperative_cash_id", "options" => $cooperativeCashes, "empty" => "", "placeholder" => "- Semua -"]) ?>
                    </div>                    
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-3">
                        <label><?= __("Periode") ?></label>
                        <?= $this->Form->input(null, ["type" => "text", "div" => false, "label" => false, "placeholder" => "Awal Periode", "class" => "form-control datepicker", "default" => isset($this->request->query["awal_CooperativeTransactionMutation_transaction_date"]) ? $this->request->query['awal_CooperativeTransactionMutation_transaction_date'] : "", "name" => "awal.CooperativeTransactionMutation.transaction_date", "id" => "startDate"]) ?>
                    </div>
                    <div class="col-md-3">
                        <label><?= __("&nbsp;") ?></label>
                        <?= $this->Form->input(null, ["type" => "text", "div" => false, "label" => false, "placeholder" => "Akhir Periode","class" => "form-control datepicker", "default" => isset($this->request->query["akhir_CooperativeTransactionMutation_transaction_date"]) ? $this->request->query['akhir_CooperativeTransactionMutation_transaction_date'] : "", "name" => "akhir.CooperativeTransactionMutation.transaction_date", "id" => "endDate"]) ?>
                    </div>
                    <div class="col-md-6">
                        <label><?= __("Cabang Perusahaan") ?></label>
                        <?= $this->Form->input(null, ["default" => isset($this->request->query['select_Employee_branch_office_id']) ? $this->request->query['select_Employee_branch_office_id'] : '', "name" => "select.Employee.branch_office_id", "class" => "select-full", "div" => false, "label" => false, "options" => $branchOffices, "empty" => "", "placeholder" => "- Semua -"]) ?>
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
    var employee = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('full_name'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        prefetch: '<?= Router::url("/admin/employees/list_cooperative", true) ?>',
        remote: {
            url: '<?= Router::url("/admin/employees/list_cooperative", true) ?>' + '?q=%QUERY',
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
