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
                            $employee = "";
                            if (isset($this->request->query['select_TransferEmployee_employee_id'])) {
                                $employee = ClassRegistry::init("Employee")->find("first", [
                                    "conditions" => [
                                        "Employee.id" => $this->request->query['select_TransferEmployee_employee_id']
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
                            <input type="hidden" name="select.TransferEmployee.employee_id" id="employee">
                            <i class="icon-search3 form-control-feedback"></i>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label><?= __("Departemen") ?></label>
                        <?= $this->Form->input(null, ["default" => isset($this->request->query['select_Employee_department_id']) ? $this->request->query['select_Employee_department_id'] : 0, "name" => "select.Employee.department_id", "options" => $departments, "class" => "select-full", "div" => false, "label" => false, "empty" => "", "placeholder" => "- Semua -"]) ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <label><?= __("Tipe Pegawai") ?></label>
                        <?= $this->Form->input(null, ["default" => isset($this->request->query['select_Employee_employee_type_id']) ? $this->request->query['select_Employee_employee_type_id'] : '', "name" => "select.Employee.employee_type_id", "class" => "select-full", "div" => false, "label" => false, "options" => $employeeTypes, "empty" => "", "placeholder" => "- Semua -"]) ?>
                    </div>
                    <div class="col-md-3">
                        <label><?= __("Periode Mutasi") ?></label>
                        <?= $this->Form->input(null, ["default" => isset($this->request->query['awal_TransferEmployee_tanggal_sk_mutasi']) ? $this->request->query['awal_TransferEmployee_tanggal_sk_mutasi'] : '', "name" => "awal.TransferEmployee.tanggal_sk_mutasi", "class" => "form-control datepicker", "div" => false, "label" => false, "id" => "startDate", "placeholder" => "Awal Periode"]) ?>
                    </div>
                    <div class="col-md-3">
                        <label><?= __("&nbsp;") ?></label>
                        <?= $this->Form->input(null, ["default" => isset($this->request->query['akhir_TransferEmployee_tanggal_sk_mutasi']) ? $this->request->query['akhir_TransferEmployee_tanggal_sk_mutasi'] : '', "name" => "akhir.TransferEmployee.tanggal_sk_mutasi", "class" => "form-control datepicker", "div" => false, "label" => false, "id" => "endDate", "placeholder" => "Akhir Periode"]) ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
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