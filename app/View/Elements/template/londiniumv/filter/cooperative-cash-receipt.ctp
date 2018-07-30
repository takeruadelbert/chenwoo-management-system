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
                        <label><?= __("Nomor Transaksi") ?></label>
                        <?php
                        if (isset($this->request->query['select_CooperativeCashReceipt_id'])) {
                            $number = ClassRegistry::init("CooperativeCashReceipt")->find("first", ["conditions" => ["CooperativeCashReceipt.id" => $this->request->query['select_CooperativeCashReceipt_id']]]);
                            if (!empty($number)) {
                                $numbers = $number['CooperativeCashReceipt']['reference_number'];
                            } else {
                                $numbers = "";
                            }
                        } else {
                            $numbers = "";
                        }
                        echo $this->Form->input(null, ["div" => false, "label" => false, "type" => "hidden", "name" => "select.CooperativeCashReceipt.id", "id" => "referenceNumber"])
                        ?>
                        <div class="has-feedback">
                            <input type="text" placeholder="Silahkan Cari Nomor Transaksi ..." class="form-control typeahead-ajax-transaction1" value="<?= $numbers ?>">
                            <i class="icon-search3 form-control-feedback" style = "top:0px;"></i>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="has-feedback">
                            <?php
                            $employee = "";
                            if (isset($this->request->query['select_CooperativeCashReceipt_operator_id'])) {
                                $employee = ClassRegistry::init("Employee")->find("first", [
                                    "conditions" => [
                                        "Employee.id" => $this->request->query['select_CooperativeCashReceipt_operator_id']
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
                            <input type="hidden" name="select.CooperativeCashReceipt.operator_id" id="employee">
                            <i class="icon-search3 form-control-feedback"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-3">
                        <label><?= __("Periode") ?></label>
                        <?= $this->Form->input(null, ["default" => isset($this->request->query['awal_CooperativeCashReceipt_date']) ? $this->request->query['awal_CooperativeCashReceipt_date'] : "", "name" => "awal.CooperativeCashReceipt.date", "class" => "form-control datepicker", "id" => "startDate", "type" => "text", "div" => false, "label" => false, "placeholder" => "Awal Periode"]) ?>
                    </div>
                    <div class="col-md-3">
                        <label><?= __("&nbsp;") ?></label>
                        <?= $this->Form->input(null, ["default" => isset($this->request->query['akhir_CooperativeCashReceipt_date']) ? $this->request->query['akhir_CooperativeCashReceipt_date'] : "", "name" => "akhir.CooperativeCashReceipt.date", "class" => "form-control datepicker", "id" => "endDate", "type" => "text", "div" => false, "label" => false, "placeholder" => "Akhir Periode"]) ?>
                    </div>
                    <div class="col-md-6">
                        <label><?= __("Cabang Perusahaan") ?></label>
                        <?= $this->Form->input(null, ["div" => false, "label" => false, "class" => "select-full", "name" => "select.CooperativeCashReceipt.branch_office_id", "default" => isset($this->request->query['select_CooperativeCashReceipt_branch_office_id']) ? $this->request->query['select_CooperativeCashReceipt_branch_office_id'] : "", "options" => $branchOffices, "empty" => "", "placeholder" => "- Semua -"]) ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <label><?= __("Jenis Pembayaran") ?></label>
                        <?= $this->Form->input(null, ["div" => false, "label" => false, "class" => "select-full", "name" => "select.CooperativeCashReceipt.cooperative_payment_type_id", "default" => isset($this->request->query['select_CooperativeCashReceipt_cooperative_payment_type_id']) ? $this->request->query['select_CooperativeCashReceipt_cooperative_payment_type_id'] : "", "options" => $cooperativePaymentTypes, "empty" => "", "placeholder" => "- Semua -"]) ?>
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
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('reference_number'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            prefetch: '<?= Router::url("/admin/cooperative_cash_receipts/reference_number_list", true) ?>',
            remote: {
                url: '<?= Router::url("/admin/cooperative_cash_receipts/reference_number_list", true) ?>' + '?q=%QUERY',
                wildcard: '%QUERY',
            }
        });
        transaction.clearPrefetchCache();
        transaction.initialize(true);
        $('input.typeahead-ajax-transaction1').typeahead({
            hint: false,
            highlight: true
        }, {
            name: 'transaction',
            display: 'reference_number',
            source: transaction.ttAdapter(),
            templates: {
                header: '<center><h5>Data Transaksi</h5></center><hr>',
                suggestion: function (context) {
                    return '<p>Nomor Kas : ' + context.reference_number + '<br>Dibuat oleh : ' + context.fullname + '<br>Tanggal Dibuat : ' + cvtWaktu(context.date) + '</p>';
                },
                empty: [
                    '<center><h5>Data Transaksi</h5></center><hr> <center><p> Hasil Pencarian Anda Tidak Dapat Ditemukan. </p></center>',
                ]
            }
        });
        $('input.typeahead-ajax-transaction1').bind('typeahead:select', function (ev, suggestion) {
            $('#referenceNumber').val(suggestion.id);
        });
    });
</script>

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