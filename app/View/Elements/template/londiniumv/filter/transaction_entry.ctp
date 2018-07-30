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
                        <label><?= __("Tanggal Awal Pembayaran") ?></label>
                        <?= $this->Form->input(null, ["default" => isset($this->request->query['start_date']) ? $this->request->query['start_date'] : '', "name" => "start_date", "class" => "form-control datepicker", "id" => "startDate", "div" => false, "label" => false]) ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <label><?= __("Cabang Perusahaan") ?></label>
                        <?= $this->Form->input(null, ["default" => isset($this->request->query['select_Employee_branch_office_id']) ? $this->request->query['select_Employee_branch_office_id'] : '', "name" => "select.Employee.branch_office_id", "class" => "select-full", "div" => false, "label" => false, "options" => $branchOffices, "empty" => "", "placeholder" => "- Semua -"]) ?>
                    </div>
                    <div class="col-md-6">
                        <label><?= __("Tanggal Akhir Pembayaran") ?></label>
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
        $('input.typeahead-ajax-transaction').bind('typeahead:select', function (ev, suggestion) {
            $('#transNumber').val(suggestion.transaction_number);
            $('#invoice').val(suggestion.total_invoice);
            console.log(suggestion);
        });
    });
</script>
