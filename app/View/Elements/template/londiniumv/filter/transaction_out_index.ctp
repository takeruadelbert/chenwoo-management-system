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
                        <label><?= __("Nomor Invoice") ?></label>
                        <?php
                        if (isset($this->request->query['select_TransactionOut_id'])) {
                            $number = ClassRegistry::init("TransactionOut")->find("first", ["conditions" => ["TransactionOut.id" => $this->request->query['select_TransactionOut_id']]]);
                            if (!empty($number)) {
                                $numbers = $number['TransactionOut']['invoice_number'];
                            } else {
                                $numbers = "";
                            }
                        } else {
                            $numbers = "";
                        }
                        echo $this->Form->input(null, ["div" => false, "label" => false, "type" => "hidden", "name" => "TransactionOut.id", "id" => "invoiceNumber"])
                        ?>
                        <div class="has-feedback">
                            <input type="text" placeholder="Silahkan Cari Nomor Invoice ..." class="form-control typeahead-ajax-transaction" value="<?= $numbers ?>">
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
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('invoice_number'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            prefetch: '<?= Router::url("/admin/transaction_outs/list", true) ?>',
            remote: {
                url: '<?= Router::url("/admin/transaction_outs/list", true) ?>' + '?q=%QUERY',
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
            display: 'invoice_number',
            source: transaction.ttAdapter(),
            templates: {
                header: '<center><h5>Data Transaksi</h5></center><hr>',
                suggestion: function (context) {
                    return '<p>Nomor Invoice : ' + context.invoice_number + '<br>Total Tagihan : ' + RP(context.total_invoice) + '</p>';
                },
            }
        });
        $('input.typeahead-ajax-transaction').bind('typeahead:select', function (ev, suggestion) {
            $('#invoiceNumber').val(suggestion.id);
            $('#invoice').val(suggestion.total_invoice);
            console.log(suggestion);
        });
    });
</script>
