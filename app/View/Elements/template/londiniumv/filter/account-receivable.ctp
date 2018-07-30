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
                        <label>Nomor Piutang</label>
                        <div class="has-feedback">
                            <?php
                            $data = "";
                            if(isset($this->request->query['select_AccountReceivable_id'])) {
                                $temp = ClassRegistry::init("AccountReceivable")->find("first",[
                                    "conditions" => [
                                        "AccountReceivable.id" => $this->request->query['select_AccountReceivable_id']
                                    ]
                                ]);
                                $data = $temp['AccountReceivable']['account_receivable_number'];
                            }
                            ?>
                            <input type="text" placeholder="cari nomor piutang" class="form-control typeahead-ajax" id="nomorPiutang" value="<?= $data ?>">
                            <input type="hidden" name="select.AccountReceivable.id" id="piutang">
                            <i class="icon-search3 form-control-feedback" style="top:1px;"></i>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label><?= __("Tanggal") ?></label>
                        <?= $this->Form->input(null, ["div" => false, "label" => false, "class" => "form-control datepicker", "name" => "AccountReceivable.date", "default" => isset($this->request->query['AccountReceivable_date']) ? $this->request->query['AccountReceivable_date'] : ""]) ?>
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
    $(document).ready(function() {
        /* Cari Nomor Piutang */
        var piutang = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('number'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            prefetch: '<?= Router::url("/admin/account_receivables/account_receivable_number_list", true) ?>',
            remote: {
                url: '<?= Router::url("/admin/account_receivables/account_receivable_number_list", true) ?>' + '?q=%QUERY',
                wildcard: '%QUERY',
            }
        });
        piutang.clearPrefetchCache();
        piutang.initialize(true);
        $('input.typeahead-ajax').typeahead({
            hint: false,
            highlight: true
        }, {
            name: 'piutang',
            display: 'number',
            source: piutang.ttAdapter(),
            templates: {
                header: '<center><h5>Data Piutang</h5></center><hr>',
                suggestion: function (context) {
                    return '<p> Nomor Piutang : ' + context.number + '<br>Tanggal : ' + context.date + '<br>Nominal : ' + RP(context.nominal) + '</p>';
                },
                empty: [
                    '<center><h5>Data Piutang</h5></center><hr> <center><p> Hasil Pencarian Anda Tidak Dapat Ditemukan. </p></center>',
                ]
            }
        });
        $('input.typeahead-ajax').bind('typeahead:select', function (ev, suggestion) {
            $('#piutang').val(suggestion.id);
        });
    });
</script>
