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
                        <?= $this->Form->input(null, ["div" => false, "label" => false, "class" => "form-control tip", "name" => "CooperativeCashMutation.id_number", "default" => isset($this->request->query['CooperativeCashMutation_id_number']) ? $this->request->query['CooperativeCashMutation_id_number'] : ""]) ?>
                    </div>
                    <div class="col-md-6">
                        <div class="has-feedback">
                            <?php
                            $employee = "";
                            if (isset($this->request->query['select_CooperativeCashMutation_creator_id'])) {
                                $employee = ClassRegistry::init("Employee")->find("first", [
                                    "conditions" => [
                                        "Employee.id" => $this->request->query['select_CooperativeCashMutation_creator_id']
                                    ],
                                    "contain" => [
                                        "Account" => [
                                            "Biodata"
                                        ]
                                    ]
                                ]);
                            }
                            ?>
                            <label><?= __("Staff Pelaksana") ?></label>
                            <input type="text" placeholder="Ketik NIK / Nama Pegawai ..." class="form-control typeahead-ajax-employee" value="<?= !empty($employee) ? $employee['Account']['Biodata']['full_name'] : "" ?>">
                            <input type="hidden" name="select.CooperativeCashMutation.creator_id" id="employee" value="<?= !empty($employee) ? $employee['Employee']['id'] : "" ?>">
                            <i class="icon-search3 form-control-feedback"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <label><?= __("Kas Asal") ?></label>
                        <?= $this->Form->input(null, ["options"=>$cooperativeCashs,"div" => false, "label" => false, "class" => "select-full", "default" => isset($this->request->query["select_CooperativeCashMutation_cooperative_cash_transfered_id"]) ? $this->request->query['select_CooperativeCashMutation_cooperative_cash_transfered_id'] : "", "name" => "select.CooperativeCashMutation.cooperative_cash_transfered_id","empty"=>"","placeholder"=>"- Semua -"]) ?>
                    </div>
                    <div class="col-md-6">
                        <label><?= __("Kas Tujuan") ?></label>
                       <?= $this->Form->input(null, ["options"=>$cooperativeCashs,"div" => false, "label" => false, "class" => "select-full", "default" => isset($this->request->query["select_CooperativeCashMutation_cooperative_cash_received_id"]) ? $this->request->query['select_CooperativeCashMutation_cooperative_cash_received_id'] : "", "name" => "select.CooperativeCashMutation.cooperative_cash_received_id","empty"=>"","placeholder"=>"- Semua -"]) ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <label><?= __("Tanggal Awal") ?></label>
                        <?= $this->Form->input(null, ["type" => "text", "div" => false, "label" => false, "class" => "form-control datetime", "default" => isset($this->request->query["start_date"]) ? $this->request->query['start_date'] : "", "name" => "start_date", "id" => "startDate"]) ?>
                    </div>
                    <div class="col-md-6">
                        <label><?= __("Tanggal Akhir") ?></label>
                        <?= $this->Form->input(null, ["type" => "text", "div" => false, "label" => false, "class" => "form-control datetime", "default" => isset($this->request->query["end_date"]) ? $this->request->query['end_date'] : "", "name" => "end_date", "id" => "endDate"]) ?>
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