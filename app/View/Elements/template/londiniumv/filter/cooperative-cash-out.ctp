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
                        if (isset($this->request->query['select_CooperativeCashOut_id'])) {
                            $number = ClassRegistry::init("CooperativeCashOut")->find("first", ["conditions" => ["CooperativeCashOut.id" => $this->request->query['select_CooperativeCashOut_id']]]);
                            if (!empty($number)) {
                                $numbers = $number['CooperativeCashOut']['cash_out_number'];
                            } else {
                                $numbers = "";
                            }
                        } else {
                            $numbers = "";
                        }
                        echo $this->Form->input(null, ["div" => false, "label" => false, "type" => "hidden", "name" => "select.CooperativeCashOut.id", "id" => "cashDisbursementNumber"])
                        ?>
                        <div class="has-feedback">
                            <input type="text" placeholder="Silahkan Cari Nomor Kas ..." class="form-control typeahead-ajax-transaction1" value="<?= $numbers ?>">
                            <i class="icon-search3 form-control-feedback" style = "top:0px;"></i>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label><?= __("Tipe Kas") ?></label>
                        <?= $this->Form->input(null, ["default" => isset($this->request->query['select_CooperativeCashOut_cooperative_cash_id']) ? $this->request->query['select_CooperativeCashOut_cooperative_cash_id'] : 0, "name" => "select.CooperativeCashOut.cooperative_cash_id", "options" => $cooperativeCashes, "class" => "select-full", "div" => false, "label" => false, "empty" => "", "placeholder" => "- Semua -"]) ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <label><?= __("Tanggal Awal") ?></label>
                        <?= $this->Form->input(null, ["type" => "text", "div" => false, "label" => false, "class" => "form-control datetime", "default" => isset($this->request->query["start_date"]) ? $this->request->query['start_date'] : "", "name" => "start_date", "id" => "startDate"]) ?>
                    </div>
                    <div class="col-md-6">
                        <label><?= __("Tanggal Akhir") ?></label>
                        <?= $this->Form->input(null, ["type" => "text", "div" => false, "label" => false, "class" => "form-control datetime", "default" => isset($this->request->query["end_date"]) ? $this->request->query['end_date'] : "", "name" => "end_date", "id" => "endDate"]) ?>
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
            prefetch: '<?= Router::url("/admin/cooperative_cash_outs/list", true) ?>',
            remote: {
                url: '<?= Router::url("/admin/cooperative_cash_outs/list", true) ?>' + '?q=%QUERY',
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
                    return '<p>Nomor Kas : ' + context.cash_out_number + '<br>Dibuat oleh : ' + context.fullname + '<br>Tanggal Dibuat : ' + context.datetime + '</p>';
                },
                empty: [
                    '<center><h5>Data Kas</h5></center><hr> <center><p> Hasil Pencarian Anda Tidak Dapat Ditemukan. </p></center>',
                ]
            }
        });
        $('input.typeahead-ajax-transaction1').bind('typeahead:select', function (ev, suggestion) {
            $('#cashDisbursementNumber').val(suggestion.id);
        });
    });
</script>
