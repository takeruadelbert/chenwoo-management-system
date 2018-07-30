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
                        echo $this->Form->input(null, ["div" => false, "label" => false, "type" => "hidden", "value" => 0, "name" => "TransactionEntry.transaction_number", "id" => "transNumber", "default" => isset($this->request->query['TransactionEntry_transaction_number']) ? $this->request->query['TransactionEntry_transaction_number'] : ""])
                        ?>
                        <div class="has-feedback">
                            <input type="text" placeholder="Silahkan Cari Nomor Transaksi ..." class="form-control typeahead-ajax-transaction">
                            <i class="icon-search3 form-control-feedback" style = "top:0px;"></i>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label><?= __("Nomor Nota Timbang") ?></label>
                        <?php
                        if (isset($this->request->query['MaterialEntry_id'])) {
                            $number = ClassRegistry::init("MaterialEntry")->find("first", ["conditions" => ["MaterialEntry.id" => $this->request->query['MaterialEntry_id']]]);
                            if (!empty($number)) {
                                $numbers = $number['MaterialEntry']['material_entry_number'];
                            } else {
                                $numbers = "";
                            }
                        } else {
                            $numbers = "";
                        }
                        echo $this->Form->input(null, ["div" => false, "label" => false, "type" => "hidden", "value" => 0, "name" => "TransactionEntry.material_entry_id", "id" => "transEntry"])
                        ?>
                        <div class="has-feedback">
                            <input type="text" placeholder="Silahkan Cari Nomor Nota Timbang ..." class="form-control typeahead-ajax-entry">
                            <i class="icon-search3 form-control-feedback" style = "top:0px;"></i>
                        </div>
                    </div> 
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-3">
                        <label><?= __("Periode Nota Timbang") ?></label>
                        <?= $this->Form->input(null, ["default" => isset($this->request->query['awal_MaterialEntry_weight_date']) ? $this->request->query['awal_MaterialEntry_weight_date'] : '', "name" => "awal.MaterialEntry.weight_date", "class" => "form-control datepicker", "id" => "startDate", "div" => false, "label" => false, "placeholder" => "Awal Periode"]) ?>
                    </div>
                    <div class="col-md-3">
                        <label><?= __("&nbsp;") ?></label>
                        <?= $this->Form->input(null, ["default" => isset($this->request->query['akhir_MaterialEntry_weight_date']) ? $this->request->query['akhir_MaterialEntry_weight_date'] : '', "name" => "akhir.MaterialEntry.weight_date", "class" => "form-control datepicker", "id" => "endDate", "div" => false, "label" => false, "placeholder" => "Akhir Periode"]) ?>
                    </div>
                    <div class="col-md-6">
                        <label><?= __("Cabang Perusahaan") ?></label>
                        <?= $this->Form->input(null, ["default" => isset($this->request->query['select_TransactionEntry_branch_office_id']) ? $this->request->query['select_TransactionEntry_branch_office_id'] : '', "name" => "select.TransactionEntry.branch_office_id", "class" => "select-full", "div" => false, "label" => false, "options" => $branchOffices, "empty" => "", "placeholder" => "- Semua -"]) ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <label><?= __("Nama Supplier") ?></label>
                        <?php
                        $supplierName = "";
                        $supplierId = "";
                        if(isset($this->request->query['TransactionEntry_supplier_id']) && !empty($this->request->query['TransactionEntry_supplier_id'])) {
                            $dataSupplier = ClassRegistry::init("Supplier")->find("first",[
                                "conditions" => [
                                    "Supplier.id" => $this->request->query['TransactionEntry_supplier_id']
                                ],
                                "recursive" => -1
                            ]);
                            $supplierName = $dataSupplier['Supplier']['name'];
                            $supplierId = $dataSupplier['Supplier']['id'];
                        }
                        echo $this->Form->input(null, ["div" => false, "label" => false, "type" => "hidden", "name" => "TransactionEntry.supplier_id", "id" => "supplierId", 'value' => $supplierId ]);
                        ?>
                        <div class="has-feedback">
                            <input type="text" placeholder="Silahkan Cari Nama Supplier ..." class="form-control typeahead-ajax-supplier" value="<?= $supplierName ?>">
                            <i class="icon-search3 form-control-feedback" style = "top:0px;"></i>
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
    $(document).ready(function () {
        var transaction = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('transaction_number'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            prefetch: '<?= Router::url("/admin/transaction_entries/list", true) ?>',
            remote: {
                url: '<?= Router::url("/admin/transaction_entries/list", true) ?>' + '?q=%QUERY',
                wildcard: '%QUERY',
            }
        });
        transaction.clearPrefetchCache();
        transaction.initialize(true);
        $('input.typeahead-ajax-transaction').typeahead({
            hint: false,
            highlight: true
        }, {
            name: 'transaction',
            display: 'transaction_number',
            source: transaction.ttAdapter(),
            templates: {
                header: '<center><h5>Data Transaksi</h5></center><hr>',
                suggestion: function (context) {
                    return '<p>Nomor Transaksi : ' + context.transaction_number + '<br>Total Tagihan : ' + RP(context.total_invoice) + '</p>';
                },
                empty: [
                    '<center><h5>Data Transaksi</h5></center><hr> <center><p> Hasil Pencarian Anda Tidak Dapat Ditemukan. </p></center>',
                ]
            }
        });
        $('input.typeahead-ajax-entry').typeahead({
            hint: false,
            highlight: true
        }, {
            name: 'transaction',
            display: 'transaction_number',
            source: transaction.ttAdapter(),
            templates: {
                header: '<center><h5>Data Nota Timbang</h5></center><hr>',
                suggestion: function (context) {
                    return '<p>Nomor Nota Timbang : ' + context.material_entry_number + '</p>';
                },
                empty: [
                    '<center><h5>Data Transaksi</h5></center><hr> <center><p> Hasil Pencarian Anda Tidak Dapat Ditemukan. </p></center>',
                ]
            }
        });
        $('input.typeahead-ajax-transaction').bind('typeahead:select', function (ev, suggestion) {
            $('#transNumber').val(suggestion.transaction_number);
            $('#invoice').val(suggestion.total_invoice);
        });
        $('input.typeahead-ajax-entry').bind('typeahead:select', function (ev, suggestion) {
            $('#transEntry').val(suggestion.material_entry_id);
            console.log(suggestion);
        });

        // Supplier Name
        var supplier = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            prefetch: '<?= Router::url("/admin/suppliers/list", true) ?>',
            remote: {
                url: '<?= Router::url("/admin/suppliers/list", true) ?>' + '?q=%QUERY',
                wildcard: '%QUERY',
            }
        });
        supplier.clearPrefetchCache();
        supplier.initialize(true);
        $('input.typeahead-ajax-supplier').typeahead({
            hint: false,
            highlight: true
        }, {
            name: 'supplier',
            display: 'name',
            source: supplier.ttAdapter(),
            templates: {
                header: '<center><h5>Data Supplier</h5></center><hr>',
                suggestion: function (context) {
                    return '<p>Nama : ' + context.name + "<br>Alamat : " + context.address + "<br>Lokasi : " + context.location + "<br>No. Telepon : " + context.phone + "<br>No. HP : " + context.handphone + '</p>';
                },
                empty: [
                    '<center><h5>Data Supplier</h5></center><hr> <center><p> Hasil Pencarian Anda Tidak Dapat Ditemukan. </p></center>',
                ]
            }
        });
        $('input.typeahead-ajax-supplier').bind('typeahead:select', function (ev, suggestion) {
            $('#supplierId').val(suggestion.id);
        });
    });
</script>
