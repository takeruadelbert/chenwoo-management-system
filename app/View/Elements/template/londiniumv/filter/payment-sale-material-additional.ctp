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
                        if (isset($this->request->query['select_PaymentSaleMaterialAdditional_id'])) {
                            $number = ClassRegistry::init("PaymentSaleMaterialAdditional")->find("first", ["conditions" => ["PaymentSaleMaterialAdditional.id" => $this->request->query['select_PaymentSaleMaterialAdditional_id']]]);
                            if (!empty($number)) {
                                $numbers = $number['PaymentSaleMaterialAdditional']['receipt_number'];
                            } else {
                                $numbers = "";
                            }
                        } else {
                            $numbers = "";
                        }
                        echo $this->Form->input(null, ["div" => false, "label" => false, "type" => "hidden", "name" => "select.PaymentSaleMaterialAdditional.id", "id" => "receiptNumber"])
                        ?>
                        <div class="has-feedback">
                            <input type="text" placeholder="Silahkan Cari Nomor Kwitansi ..." class="form-control typeahead-ajax-transaction1"  value="<?= $numbers ?>">
                            <i class="icon-search3 form-control-feedback" style = "top:0px;"></i>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label><?= __("Nomor Penjualan Produk") ?></label>
                        <?php
                        if (isset($this->request->query['select_MaterialAdditionalSale_id'])) {
                            $number = ClassRegistry::init("MaterialAdditionalSale")->find("first", ["conditions" => ["MaterialAdditionalSale.id" => $this->request->query['select_MaterialAdditionalSale_id']]]);
                            if (!empty($number)) {
                                $numbers = $number['MaterialAdditionalSale']['no_sale'];
                            } else {
                                $numbers = "";
                            }
                        } else {
                            $numbers = "";
                        }
                        echo $this->Form->input(null, ["div" => false, "label" => false, "type" => "hidden", "name" => "select.MaterialAdditionalSale.id", "id" => "transNumber"])
                        ?>
                        <div class="has-feedback">
                            <input type="text" placeholder="Silahkan Cari Nomor Penjualan Produk ..." class="form-control typeahead-ajax-transaction" value="<?= $numbers ?>">
                            <i class="icon-search3 form-control-feedback" style = "top:0px;"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <div class="has-feedback">
                            <?php
                            $employee = "";
                            if (isset($this->request->query['select_PaymentSaleMaterialAdditional_employee_id'])) {
                                $employee = ClassRegistry::init("Employee")->find("first", [
                                    "conditions" => [
                                        "Employee.id" => $this->request->query['select_PaymentSaleMaterialAdditional_employee_id']
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
                            <input type="hidden" name="select.PaymentSaleMaterialAdditional.employee_id" id="employee">
                            <i class="icon-search3 form-control-feedback"></i>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label><?= __("Periode Pembayaran") ?></label>
                        <?= $this->Form->input(null, ["default" => isset($this->request->query['awal_PaymentSaleMaterialAdditional_payment_date']) ? $this->request->query['awal_PaymentSaleMaterialAdditional_payment_date'] : '', "name" => "awal.PaymentSaleMaterialAdditional.payment_date", "class" => "form-control datepicker", "id" => "startDate", "div" => false, "label" => false, "placeholder" => "Awal Pembayaran"]) ?>
                    </div>
                    <div class="col-md-3">
                        <label><?= __("&nbsp;") ?></label>
                        <?= $this->Form->input(null, ["default" => isset($this->request->query['akhir_PaymentSaleMaterialAdditional_payment_date']) ? $this->request->query['akhir_PaymentSaleMaterialAdditional_payment_date'] : '', "name" => "akhir.PaymentSaleMaterialAdditional.payment_date", "class" => "form-control datepicker", "id" => "endDate", "div" => false, "label" => false, "placeholder" => "Akhir Pembayaran"]) ?>
                    </div> 
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <label><?= __("Tipe Pembayaran") ?></label>
                        <?= $this->Form->input(null, ["div" => false, "label" => false, "class" => "select-full", "options" => $paymentTypes, "name" => "select.PaymentType.id", "empty" => "", "placeholder" => "- Semua -", "default" => isset($this->request->query['select_PaymentType_id']) ? $this->request->query['select_PaymentType_id'] : ""]) ?>
                    </div>
                    <div class="col-md-6">
                        <label><?= __("Cabang Perusahaan") ?></label>
                        <?= $this->Form->input(null, ["default" => isset($this->request->query['select_MaterialAdditionalSale_branch_office_id']) ? $this->request->query['select_MaterialAdditionalSale_branch_office_id'] : '', "name" => "select.MaterialAdditionalSale.branch_office_id", "class" => "select-full", "div" => false, "label" => false, "options" => $branchOffices, "empty" => "", "placeholder" => "- Semua -"]) ?>
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
        var sale = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('sale_no'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            prefetch: '<?= Router::url("/admin/material_additional_sales/list_hutang", true) ?>' + '?q=%QUERY',
            remote: {
                url: '<?= Router::url("/admin/material_additional_sales/list_hutang", true) ?>' + '?q=%QUERY',
                wildcard: '%QUERY',
            }
        });
        sale.clearPrefetchCache();
        sale.initialize(true);
        $('input.typeahead-ajax-transaction').typeahead({
            hint: false,
            highlight: true
        }, {
            name: 'sale',
            display: 'sale_no',
            source: sale.ttAdapter(),
            templates: {
                header: '<center><h5>Data Penjualan Material Penjual</h5></center><hr>',
                suggestion: function (context) {
                    return '<p>Nomor Penjualan : ' + context.no_sale + '<br>Total Tagihan : Rp ' + ic_rupiah(context.total_invoice) + '</p>';
                },
                empty: [
                    '<center><h5>Data Penjualan Material Pembantu</h5></center><hr> <center><p> Hasil Pencarian Anda Tidak Dapat Ditemukan. </p></center>',
                ]
            }
        });
        $('input.typeahead-ajax-transaction').bind('typeahead:select', function (ev, suggestion) {
            $('#transNumber').val(suggestion.id);
            $('#invoice').val(suggestion.total_invoice);
//            console.log(suggestion);
        });
    });

    $(document).ready(function () {
        var transaction = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('receipt_number'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            prefetch: '<?= Router::url("/admin/payment_sale_material_additionals/list", true) ?>' + '?q=%QUERY',
            remote: {
                url: '<?= Router::url("/admin/payment_sale_material_additionals/list", true) ?>' + '?q=%QUERY',
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
                    return '<p>Nomor Kwitansi : ' + context.receipt_number + '<br>Supplier : ' + context.supplier_name + '<br>Jumlah Pembayaran : Rp. ' + ic_rupiah(context.amount) + '</p>';
                },
                empty: [
                    '<center><h5>Data Kwitansi</h5></center><hr> <center><p> Hasil Pencarian Anda Tidak Dapat Ditemukan. </p></center>',
                ]
            }
        });
        $('input.typeahead-ajax-transaction1').bind('typeahead:select', function (ev, suggestion) {
            $('#receiptNumber').val(suggestion.id);
            $('#amount').val(suggestion.amount);
            $('#supplier').val(suggestion.supplier);
//            console.log(suggestion);
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
