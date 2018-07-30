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
                        <label><?= __("Tipe Pegawai") ?></label>
                        <?= $this->Form->input(null, ["default" => isset($this->request->query['select_CooperativeItemLoanPayment_employee_type_id']) ? $this->request->query['select_CooperativeItemLoanPayment_employee_type_id'] : '', "name" => "select.CooperativeItemLoanPayment.employee_type_id", "class" => "select-full", "div" => false, "label" => false, "options" => $employeeTypes, "empty" => "", "placeholder" => "- Semua -"]) ?>
                    </div>
                    <div class="col-md-3">
                        <label><?= __("Periode") ?></label>
                        <?= $this->Form->input(null, ["default" => isset($this->request->query['CooperativeItemLoanPayment_start_period']) ? $this->request->query['CooperativeItemLoanPayment_start_period'] : '', "name" => "CooperativeItemLoanPayment.start_period", "class" => "form-control datepicker", "div" => false, "label" => false, "placeholder" => "Awal Periode"]) ?>
                    </div>
                    <div class="col-md-3">
                        <label><?= __("&nbsp;") ?></label>
                        <?= $this->Form->input(null, ["default" => isset($this->request->query['CooperativeItemLoanPayment_end_period']) ? $this->request->query['CooperativeItemLoanPayment_end_period'] : '', "name" => "CooperativeItemLoanPayment.end_period", "class" => "form-control datepicker", "div" => false, "label" => false, "placeholder" => "Akhir Periode"]) ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <div class="has-feedback">
                            <?php
                            $pelaksana = "";
                            if (isset($this->request->query['select_CooperativeItemLoanPayment_creator_id'])) {
                                $pelaksana = ClassRegistry::init("Employee")->find("first", [
                                    "conditions" => [
                                        "Employee.id" => $this->request->query['select_CooperativeItemLoanPayment_creator_id']
                                    ],
                                    "contain" => [
                                        "Account" => [
                                            "Biodata"
                                        ]
                                    ]
                                ]);
                            }
                            ?>
                            <label><?= __("Staff Pembuat") ?></label>
                            <input type="text" placeholder="Cari Nama Pegawai ..." class="form-control typeahead-ajax-pelaksana" value="<?= !empty($pelaksana) ? $pelaksana['Account']['Biodata']['full_name'] : "" ?>">
                            <input type="hidden" name="select.CooperativeItemLoanPayment.creator_id" id="pelaksana">
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