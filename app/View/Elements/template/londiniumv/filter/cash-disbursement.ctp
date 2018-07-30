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
                        <label><?= __("Nomor Kas") ?></label>
                        <?php
                        if (isset($this->request->query['CashDisbursement_id'])) {
                            $number = ClassRegistry::init("CashDisbursement")->find("first", ["conditions" => ["CashDisbursement.id" => $this->request->query['CashDisbursement_id']]]);
                            if (!empty($number)) {
                                $numbers = $number['CashDisbursement']['cash_disbursement_number'];
                            } else {
                                $numbers = "";
                            }
                        } else {
                            $numbers = "";
                        }
                        echo $this->Form->input(null, ["div" => false, "label" => false, "type" => "hidden", "name" => "CashDisbursement.id", "id" => "cashDisbursementNumber"])
                        ?>
                        <div class="has-feedback">
                            <input type="text" placeholder="Silahkan Cari Nomor Kas ..." class="form-control typeahead-ajax-transaction1" value="<?= $numbers ?>">
                            <i class="icon-search3 form-control-feedback" style = "top:0px;"></i>
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
                        <?= $this->Form->input(null, ["default" => isset($this->request->query['select_CashDisbursement_initial_balance_id']) ? $this->request->query['select_CashDisbursement_initial_balance_id'] : 0, "name" => "select.CashDisbursement.initial_balance_id", "options" => $initialBalances, "class" => "select-full", "div" => false, "label" => false, "empty" => "", "placeholder" => "- Semua -"]) ?>
                    </div>
                    <div class="col-md-3">
                        <label><?= __("Periode Dibuat") ?></label>
                        <?= $this->Form->input(null, ["type" => "text", "div" => false, "placeholder" => "Awal Periode", "label" => false, "class" => "form-control datetime", "default" => isset($this->request->query["awal_CashDisbursement_created_datetime"]) ? $this->request->query['awal_CashDisbursement_created_datetime'] : "", "name" => "awal.CashDisbursement.created_datetime", "id" => "startDate"]) ?>
                    </div>
                    <div class="col-md-3">
                        <label><?= __("&nbsp;") ?></label>
                        <?= $this->Form->input(null, ["type" => "text", "div" => false, "placeholder" => "Akhir Periode", "label" => false, "class" => "form-control datetime", "default" => isset($this->request->query["akhir_CashDisbursement_created_datetime"]) ? $this->request->query['akhir_CashDisbursement_created_datetime'] : "", "name" => "akhir.CashDisbursement.created_datetime", "id" => "endDate"]) ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <label><?= __("Cabang Perusahaan") ?></label>
                        <?= $this->Form->input(null, ["default" => isset($this->request->query['select_CashDibursement_branch_office_id']) ? $this->request->query['select_CashDibursement_branch_office_id'] : '', "name" => "select.CashDisbursement.branch_office_id", "class" => "select-full", "div" => false, "label" => false, "options" => $branchOffices, "empty" => "", "placeholder" => "- Semua -"]) ?>
                    </div>
                    <div class="col-md-6">
                        <label><?= __("Tipe Transaksi") ?></label>
                        <?= $this->Form->input(null, ['div' => false, 'label' => false, 'class' => 'select-full', 'empty' => "", "placeholder" => "- Pilih Tipe Transaksi -", 'default' => isset($this->request->query['CashDisbursement_transaction_currency_type_id']) ? $this->request->query['CashDisbursement_transaction_currency_type_id'] : "", 'options' => $transactionCurrencyTypes, 'name' => 'CashDisbursement.transaction_currency_type_id']) ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <label><?= __("Keterangan") ?></label>
                        <?= $this->Form->input(null, ["default" => isset($this->request->query['CashDibursement_note']) ? $this->request->query['CashDibursement_note'] : '', "name" => "CashDisbursement.note", "class" => "form-control", "div" => false, "label" => false, "placeholder" => "Keterangan ..."]) ?>
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
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('cash_disbursement_number'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            prefetch: '<?= Router::url("/admin/cash_disbursements/list", true) ?>',
            remote: {
                url: '<?= Router::url("/admin/cash_disbursements/list", true) ?>' + '?q=%QUERY',
                wildcard: '%QUERY',
            }
        });
        transaction.clearPrefetchCache();
        transaction.initialize(true);
        $('input.typeahead-ajax-transaction1').typeahead({
            hint: false,
            highlight: true
        }, {
            name: 'cash',
            display: 'cash_disbursement_number',
            source: transaction.ttAdapter(),
            templates: {
                header: '<center><h5>Data Kas</h5></center><hr>',
                suggestion: function (context) {
                    return '<p>Nomor Kas : ' + context.cash_disbursement_number + '<br>Dibuat oleh : ' + context.fullname + '<br>Tanggal Dibuat : ' + context.datetime + '</p>';
                },
                empty: [
                    '<center><h5>Data Kas</h5></center><hr> <center><p> Hasil Pencarian Anda Tidak Dapat Ditemukan. </p></center>',
                ]
            }
        });
        $('input.typeahead-ajax-transaction1').bind('typeahead:select', function (ev, suggestion) {
            $('#cashDisbursementNumber').val(suggestion.id);
            $('#datetime').val(suggestion.datetime);
            $('#fullname').val(suggestion.fullname);
            console.log(suggestion);
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
