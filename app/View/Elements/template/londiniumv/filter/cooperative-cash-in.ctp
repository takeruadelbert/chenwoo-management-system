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
                        <div class="has-feedback">
                            <?php
                            $cashIn = "";
                            if (isset($this->request->query['select_CooperativeCashIn_id'])) {
                                $cashIn = ClassRegistry::init("CooperativeCashIn")->find("first", [
                                    "conditions" => [
                                        "CooperativeCashIn.id" => $this->request->query['select_CooperativeCashIn_id']
                                    ],
                                ]);
                            }
                            ?>
                            <label><?= __("Nomor Kas Masuk") ?></label>
                            <input type="text" placeholder="Cari Nomor Kas Masuk ..." class="form-control typeahead-ajax-cashIn" value="<?= !empty($cashIn) ? $cashIn['CooperativeCashIn']['cash_in_number'] : "" ?>">
                            <input type="hidden" name="select.CooperativeCashIn.id" id="cashIn">
                            <i class="icon-search3 form-control-feedback"></i>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label><?= __("Tipe Kas") ?></label>
                        <?= $this->Form->input(null, ["default" => isset($this->request->query['select_CooperativeCashIn_cooperative_cash_id']) ? $this->request->query['select_CooperativeCashIn_cooperative_cash_id'] : "", "name" => "select.CooperativeCashIn.cooperative_cash_id", "options" => $cooperativeCashes, "class" => "select-full", "div" => false, "label" => false, "empty" => "", "placeholder" => "- Semua -"]) ?>
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
    /* Cari Nomor Kas Masuk */
    var cashIn = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('cash_in_number'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        prefetch: '<?= Router::url("/admin/cooperative_cash_ins/list", true) ?>',
        remote: {
            url: '<?= Router::url("/admin/cooperative_cash_ins/list", true) ?>' + '?q=%QUERY',
            wildcard: '%QUERY',
        }
    });
    cashIn.clearPrefetchCache();
    cashIn.initialize(true);
    $('input.typeahead-ajax-cashIn').typeahead({
        hint: false,
        highlight: true
    }, {
        name: 'cashIn',
        display: 'cash_in_number',
        source: cashIn.ttAdapter(),
        templates: {
            header: '<center><h5>Data Kas Masuk</h5></center><hr>',
            suggestion: function (data) {
                return '<p> Nomor Kas Masuk : ' + data.cash_in_number + '<br/> Nominal : ' + RP(data.amount) + '<br/> Tanggal : ' + cvtWaktu(data.created_datetime) + '</p>';
            },
            empty: [
                '<center><h5>Data Kas Masuk</h5></center><hr> <center><p> Hasil Pencarian Anda Tidak Dapat Ditemukan. </p></center>',
            ]
        }
    });
    $('input.typeahead-ajax-cashIn').bind('typeahead:select', function (ev, suggestion) {
        $("#cashIn").val(suggestion.id);
    });
</script>