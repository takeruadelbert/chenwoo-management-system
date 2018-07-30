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
                        <label><?= __("Nomor Kwitansi") ?></label>
                        <?php
                        echo $this->Form->input(null, ["div" => false, "label" => false, "type" => "hidden", "name" => "select.EmployeeDataLoanDetail.coop_receipt_number", "id" => "receiptNumber", "default" => isset($this->request->query['EmployeeDataLoanDetail_coop_receipt_number']) ? $this->request->query['EmployeeDataLoanDetail_coop_receipt_number'] : ""])
                        ?>
                        <div class="has-feedback">
                            <?php
                            if (isset($this->request->query['select_EmployeeDataLoanDetail_coop_receipt_number'])) {
                                $receiptNumber = $this->request->query['select_EmployeeDataLoanDetail_coop_receipt_number'];
                            } else {
                                $receiptNumber = "";
                            }
                            ?>
                            <input type="text" placeholder="Silahkan Cari Nomor Kwitansi ..." class="form-control typeahead-ajax-transaction1" value="<?= $receiptNumber ?>">
                            <i class="icon-search3 form-control-feedback" style = "top:0px;"></i>
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
                    <div class="col-md-6">
                        <label><?= __("Tanggal Awal Bayar") ?></label>
                        <?= $this->Form->input(null, ["default" => isset($this->request->query['start_date']) ? $this->request->query['start_date'] : '', "name" => "start_date", "class" => "form-control datepicker", "id" => "startDate", "div" => false, "label" => false]) ?>
                    </div>
                    <div class="col-md-6">
                        <label><?= __("Tanggal Akhir Bayar") ?></label>
                        <?= $this->Form->input(null, ["default" => isset($this->request->query['end_date']) ? $this->request->query['end_date'] : '', "name" => "end_date", "class" => "form-control datepicker", "id" => "endDate", "div" => false, "label" => false]) ?>
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
        var transaction = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('receipt_number'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            prefetch: '<?= Router::url("/admin/employee_data_loan_details/list", true) ?>',
            remote: {
                url: '<?= Router::url("/admin/employee_data_loan_details/list", true) ?>' + '?q=%QUERY',
                wildcard: '%QUERY',
            }
        });
        transaction.clearPrefetchCache();
        transaction.initialize(true);
        $('input.typeahead-ajax-transaction1').typeahead({
            hint: false,
            highlight: true
        }, {
            name: 'kwitansi',
            display: 'receipt_number',
            source: transaction.ttAdapter(),
            templates: {
                header: '<center><h5>Data Kwitansi</h5></center><hr>',
                suggestion: function (context) {
                    return '<p>Nomor Kwitansi : ' + context.receipt_number + '<br>Nama Pegawai : ' + context.employee + '<br>Jumlah Pembayaran : ' + RP(context.amount) + '</p>';
                },
                empty: [
                    '<center><h5>Data Kwitansi</h5></center><hr> <center><p> Hasil Pencarian Anda Tidak Dapat Ditemukan. </p></center>',
                ]
            }
        });
        $('input.typeahead-ajax-transaction1').bind('typeahead:select', function (ev, suggestion) {
            $('#receiptNumber').val(suggestion.receipt_number);
            $('#amount').val(suggestion.amount);
            $('#employee').val(suggestion.employee);
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