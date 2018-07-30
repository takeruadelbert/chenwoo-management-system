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
                        <label><?= __("Nomor Penjualan") ?></label>
                        <?= $this->Form->input(null, ["div" => false, "label" => false, "class" => "form-control tip", "type" => "text", "name" => "SaleProductAdditional.reference_number", "default" => isset($this->request->query['SaleProductAdditional_reference_number']) ? $this->request->query['SaleProductAdditional_reference_number'] : ""]) ?>
                    </div>
                    <div class="col-md-6">
                        <label><?= __("Kas Koperasi Yang Digunakan") ?></label>
                        <?= $this->Form->input(null, ["div" => false, "label" => false, "class" => "select-full", "name" => "CooperativeTransactionMutation.SaleProductAdditional.cooperative_cash_id", "default" => isset($this->request->query['CooperativeTransactionMutation_SaleProductAdditional_cooperative_cash_id']) ? $this->request->query['CooperativeTransactionMutation_SaleProductAdditional_cooperative_cash_id'] : "", "empty" => "", "placeholder" => "- Pilih Kas -", "options" => $cooperativeCashes]) ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">                    
                    <div class="col-md-6">
                        <div class="has-feedback">
                            <?php
                            $employee = "";
                            if (isset($this->request->query['CooperativeTransactionMutation_SaleProductAdditional_employee_id'])) {
                                $employee = ClassRegistry::init("Employee")->find("first", [
                                    "conditions" => [
                                        "Employee.id" => $this->request->query['CooperativeTransactionMutation_SaleProductAdditional_employee_id']
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
                            <input type="hidden" name="CooperativeTransactionMutation.SaleProductAdditional.employee_id" id="employee">
                            <i class="icon-search3 form-control-feedback"></i>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="has-feedback">
                            <?php
                            $purchaser = "";
                            if (isset($this->request->query['CooperativeTransactionMutation_SaleProductAdditional_purchaser_id'])) {
                                $purchaser = ClassRegistry::init("Employee")->find("first", [
                                    "conditions" => [
                                        "Employee.id" => $this->request->query['CooperativeTransactionMutation_SaleProductAdditional_purchaser_id']
                                    ],
                                    "contain" => [
                                        "Account" => [
                                            "Biodata"
                                        ]
                                    ]
                                ]);
                            }
                            ?>
                            <label><?= __("Nama Pembeli") ?></label>
                            <input type="text" placeholder="Cari Nama Pembeli ..." class="form-control typeahead-ajax-purchaser" value="<?= !empty($purchaser) ? $purchaser['Account']['Biodata']['full_name'] : "" ?>">
                            <input type="hidden" name="CooperativeTransactionMutation.SaleProductAdditional.purchaser_id" id="purchaser">
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
    
    /* Cari Nama Pembeli */
    var purchaser = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('full_name'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        prefetch: '<?= Router::url("/admin/employees/list_cooperative", true) ?>',
        remote: {
            url: '<?= Router::url("/admin/employees/list_cooperative", true) ?>' + '?q=%QUERY',
            wildcard: '%QUERY',
        }
    });
    purchaser.clearPrefetchCache();
    purchaser.initialize(true);
    $('input.typeahead-ajax-purchaser').typeahead({
        hint: false,
        highlight: true
    }, {
        name: 'purchaser',
        display: 'full_name',
        source: purchaser.ttAdapter(),
        templates: {
            header: '<center><h5>Data Pembeli</h5></center><hr>',
            suggestion: function (data) {
                return '<p> Nama : ' + data.full_name + '<br/> NIP Pegawai : ' + data.nip + '<br/> Department : ' + data.department + '<br/> Position : ' + data.jabatan + '</p>';
            },
            empty: [
                '<center><h5>Data Pembeli</h5></center><hr> <center><p> Hasil Pencarian Anda Tidak Dapat Ditemukan. </p></center>',
            ]
        }
    });
    $('input.typeahead-ajax-purchaser').bind('typeahead:select', function (ev, suggestion) {
        $("#purchaser").val(suggestion.id);
    });
</script>