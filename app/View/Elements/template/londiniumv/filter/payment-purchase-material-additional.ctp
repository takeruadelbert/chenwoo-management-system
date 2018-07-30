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
                        if (isset($this->request->query['select_PaymentPurchaseMaterialAdditional_id'])) {
                            $number = ClassRegistry::init("PaymentPurchaseMaterialAdditional")->find("first", ["conditions" => ["PaymentPurchaseMaterialAdditional.id" => $this->request->query['select_PaymentPurchaseMaterialAdditional_id']]]);
                            if (!empty($number)) {
                                $numbers = $number['PaymentPurchaseMaterialAdditional']['receipt_number'];
                            } else {
                                $numbers = "";
                            }
                        } else {
                            $numbers = "";
                        }
                        echo $this->Form->input(null, ["div" => false, "label" => false, "type" => "hidden", "name" => "select.PaymentPurchaseMaterialAdditional.id", "id" => "receiptNumber"])
                        ?>
                        <div class="has-feedback">
                            <input type="text" placeholder="Silahkan Cari Nomor Kwitansi ..." class="form-control typeahead-ajax-transaction1" value="<?= $numbers ?>">
                            <i class="icon-search3 form-control-feedback" style = "top:0px;"></i>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label><?= __("Nomor PO") ?></label>
                        <?php
                        if (isset($this->request->query['select_PurchaseOrderMaterialAdditional_id'])) {
                            $number = ClassRegistry::init("PurchaseOrderMaterialAdditional")->find("first", ["conditions" => ["PurchaseOrderMaterialAdditional.id" => $this->request->query['select_PurchaseOrderMaterialAdditional_id']]]);
                            if (!empty($number)) {
                                $numbers = $number['PurchaseOrderMaterialAdditional']['po_number'];
                            } else {
                                $numbers = "";
                            }
                        } else {
                            $numbers = "";
                        }
                        echo $this->Form->input(null, ["div" => false, "label" => false, "type" => "hidden", "name" => "select.PurchaseOrderMaterialAdditional.id", "id" => "transNumber"])
                        ?>
                        <div class="has-feedback">
                            <input type="text" placeholder="Silahkan Cari Nomor PO Material Pembantu ..." class="form-control typeahead-ajax-po-material-additional" value="<?= $numbers ?>">
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
                            if (isset($this->request->query['select_PaymentPurchaseMaterialAdditional_employee_id'])) {
                                $employee = ClassRegistry::init("Employee")->find("first", [
                                    "conditions" => [
                                        "Employee.id" => $this->request->query['select_PaymentPurchaseMaterialAdditional_employee_id']
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
                            <input type="hidden" name="select.PaymentPurchaseMaterialAdditional.employee_id" id="employee">
                            <i class="icon-search3 form-control-feedback"></i>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label><?= __("Periode Pembayaran Hutang") ?></label>
                        <?= $this->Form->input(null, ["default" => isset($this->request->query['awal_PaymentPurchaseMaterialAdditional_payment_date']) ? $this->request->query['awal_PaymentPurchaseMaterialAdditional_payment_date'] : '', "name" => "awal.PaymentPurchaseMaterialAdditional.payment_date", "class" => "form-control datepicker", "id" => "startDate", "div" => false, "label" => false, "placeholder" => "Awal Periode"]) ?>
                    </div>
                    <div class="col-md-3">
                        <label><?= __("&nbsp;") ?></label>
                        <?= $this->Form->input(null, ["default" => isset($this->request->query['akhir_PaymentPurchaseMaterialAdditional_payment_date']) ? $this->request->query['akhir_PaymentPurchaseMaterialAdditional_payment_date'] : '', "name" => "akhir.PaymentPurchaseMaterialAdditional.payment_date", "class" => "form-control datepicker", "id" => "endDate", "div" => false, "label" => false, "placeholder" => "Akhir Periode"]) ?>
                    </div> 
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-3">
                        <label><?= __("Tipe Pembayaran") ?></label>
                        <?= $this->Form->input(null, ["div" => false, "label" => false, "class" => "select-full", "options" => $paymentTypes, "name" => "select.PaymentType.id", "empty" => "", "placeholder" => "- Semua -", "default" => isset($this->request->query['select_PaymentType_id']) ? $this->request->query['select_PaymentType_id'] : ""]) ?>
                    </div>
                    <div class="col-md-3">
                        <label><?= __("Status Verifikasi") ?></label>
                        <?= $this->Form->input(null, ["div" => false, "label" => false, "class" => "select-full", "options" => $verifyStatuses, "name" => "select.PaymentPurchaseMaterialAdditional.verify_status_id", "empty" => "", "placeholder" => "- Semua -", "default" => isset($this->request->query['select_PaymentPurchaseMaterialAdditional_verify_status_id']) ? $this->request->query['select_PaymentPurchaseMaterialAdditional_verify_status_id'] : ""]) ?>
                    </div>
                    <div class="col-md-6">
                        <label><?= __("Cabang Perusahaan") ?></label>
                        <?= $this->Form->input(null, ["default" => isset($this->request->query['PaymentPurchaseMaterialAdditional_branch_office_id']) ? $this->request->query['PaymentPurchaseMaterialAdditional_branch_office_id'] : '', "name" => "PaymentPurchaseMaterialAdditional.branch_office_id", "class" => "select-full", "div" => false, "label" => false, "options" => $branchOffices, "empty" => "", "placeholder" => "- Pilih Cabang Perusahaan -"]) ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <label><?= __("Nama Supplier") ?></label>
                        <?= $this->Form->input(null, ["default" => isset($this->request->query['PurchaseOrderMaterialAdditional_material_additional_supplier_id']) ? $this->request->query['PurchaseOrderMaterialAdditional_material_additional_supplier_id'] : '', "name" => "PurchaseOrderMaterialAdditional.material_additional_supplier_id", "class" => "select-full", "div" => false, "label" => false, "options" => $suppliers, "empty" => "", "placeholder" => "Silahkan Cari Nama Supplier"]) ?>
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
        var po_material_additional = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('po_number'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            prefetch: '<?= Router::url("/admin/purchase_order_material_additionals/list", true) ?>',
            remote: {
                url: '<?= Router::url("/admin/purchase_order_material_additionals/list", true) ?>' + '?q=%QUERY',
                wildcard: '%QUERY',
            }
        });
        po_material_additional.clearPrefetchCache();
        po_material_additional.initialize(true);
        $('input.typeahead-ajax-po-material-additional').typeahead({
            hint: false,
            highlight: true
        }, {
            name: 'po_material_additional',
            display: 'po_number',
            source: po_material_additional.ttAdapter(),
            templates: {
                header: '<center><h5>Data PO Material Pembantu</h5></center><hr>',
                suggestion: function (context) {
                    return '<p>Nomor Transaksi : ' + context.po_number + '<br>Total Tagihan : ' + RP(context.total) + '<br>Sisa Tagihan : ' + RP(context.remaining) + '<br>Nama Supplier : ' + context.supplier_name + '</p>';
                },
                empty: [
                    '<center><h5>Data PO Material Pembantu</h5></center><hr> <center><p> Hasil Pencarian Anda Tidak Dapat Ditemukan. </p></center>',
                ]
            }
        });
        $('input.typeahead-ajax-po-material-additional').bind('typeahead:select', function (ev, suggestion) {
            $('#transNumber').val(suggestion.id);
            $('#invoice').val(suggestion.total);
        });
    });

    $(document).ready(function () {
        var transaction = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('receipt_number'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            prefetch: '<?= Router::url("/admin/payment_purchase_material_additionals/list", true) ?>',
            remote: {
                url: '<?= Router::url("/admin/payment_purchase_material_additionals/list", true) ?>' + '?q=%QUERY',
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
                    return '<p>Nomor Kwitansi : ' + context.receipt_number + '<br>Supplier : ' + context.supplier + '<br>Jumlah Pembayaran : ' + RP(context.amount) + '</p>';
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
