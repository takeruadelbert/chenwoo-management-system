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
                            $loan = "";
                            if (isset($this->request->query['select_EmployeeDataLoanDetail_id'])) {
                                $loan = ClassRegistry::init("EmployeeDataLoanDetail")->find("first", [
                                    "conditions" => [
                                        "EmployeeDataLoanDetail.id" => $this->request->query['select_EmployeeDataLoanDetail_id']
                                    ],
                                    "contain" => [
                                    ]
                                ]);
                            }
                            ?>
                            <label><?= __("Nomor Kwitansi") ?></label>
                            <input type="text" placeholder="Cari Nomor Kwitansi ..." class="form-control typeahead-ajax-dataloan" value="<?= !empty($loan) ? $loan['EmployeeDataLoanDetail']['coop_receipt_number'] : "" ?>">
                            <input type="hidden" name="select.EmployeeDataLoanDetail.id" id="detailId">
                            <i class="icon-search3 form-control-feedback"></i>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="has-feedback">
                            <?php
                            $employee = "";
                            if (isset($this->request->query['select_EmployeeDataLoan_employee_id'])) {
                                $employee = ClassRegistry::init("Employee")->find("first", [
                                    "conditions" => [
                                        "Employee.id" => $this->request->query['select_EmployeeDataLoan_employee_id']
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
                            <input type="hidden" name="select.EmployeeDataLoan.employee_id" id="employee">
                            <i class="icon-search3 form-control-feedback"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-3">
                        <label><?= __("Periode Tarikan Angsuran") ?></label>
                        <?= $this->Form->input(null, ["default" => isset($this->request->query['awal_EmployeeDataLoanDetail_paid_date']) ? $this->request->query['awal_EmployeeDataLoanDetail_paid_date'] : '', "name" => "awal.EmployeeDataLoanDetail.paid_date", "class" => "form-control datepicker", "id" => "startDate", "div" => false, "label" => false, "placeholder" => "Awal Periode"]) ?>
                    </div>
                    <div class="col-md-3">
                        <label><?= __("&nbsp;") ?></label>
                        <?= $this->Form->input(null, ["default" => isset($this->request->query['akhir_EmployeeDataLoanDetail_paid_date']) ? $this->request->query['akhir_EmployeeDataLoanDetail_paid_date'] : '', "name" => "akhir.EmployeeDataLoanDetail.paid_date", "class" => "form-control datepicker", "id" => "endDate", "div" => false, "label" => false, "placeholder" => "Akhir Periode"]) ?>
                    </div>
<!--                    <div class="col-md-6">
                        <label><?= __("Cabang Perusahaan") ?></label>
                        <?= $this->Form->input(null, ["default" => isset($this->request->query['select_Employee_branch_office_id']) ? $this->request->query['select_Employee_branch_office_id'] : '', "name" => "select.Employee.branch_office_id", "class" => "select-full", "div" => false, "label" => false, "options" => $branchOffices, "empty" => "", "placeholder" => "- Semua -"]) ?>
                    </div>-->
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
<script>
    filterReload();
    /* Cari Nama Pegawai */
    var loan = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('receipt_number'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        prefetch: '<?= Router::url("/admin/employee_data_loan_details/list", true) ?>',
        remote: {
            url: '<?= Router::url("/admin/employee_data_loan_details/list", true) ?>' + '?q=%QUERY',
            wildcard: '%QUERY',
        }
    });
    loan.clearPrefetchCache();
    loan.initialize(true);
    $('input.typeahead-ajax-dataloan').typeahead({
        hint: false,
        highlight: true
    }, {
        name: 'loan',
        display: 'receipt_number',
        source: loan.ttAdapter(),
        templates: {
            header: '<center><h5>Data Kwitansi</h5></center><hr>',
            suggestion: function (data) {
                return '<p> Nomor Kwitansi : ' + data.receipt_number + '<br/> Nama Pegawai : ' + data.employee + '<br/> Total Pinjaman : ' + data.amount + '</p>';
            },
            empty: [
                '<center><h5>Data Kwitansi</h5></center><hr> <center><p> Hasil Pencarian Anda Tidak Dapat Ditemukan. </p></center>',
            ]
        }
    });
    $('input.typeahead-ajax-dataloan').bind('typeahead:select', function (ev, suggestion) {
        $("#detailId").val(suggestion.id);
    });
</script>