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
                            $debtNumber = "";
                            if (isset($this->request->query['select_Debt_id']) && !empty($this->request->query['select_Debt_id'])) {
                                $data = ClassRegistry::init("Debt")->find("first", [
                                    "conditions" => [
                                        "Debt.id" => $this->request->query['select_Debt_id']
                                    ]
                                ]);
                                $debtNumber = $data['Debt']['debt_number'];
                            }
                            ?>
                            <label><?= __("Nomor Hutang") ?></label>
                            <input type="text" placeholder="Cari Nomor Hutang ..." class="form-control typeahead-ajax" value="<?= !empty($debtNumber) ? $debtNumber : "" ?>">
                            <input type="hidden" name="Debt.id" id="debtNumber">
                            <i class="icon-search3 form-control-feedback"></i>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label><?= __("Tanggal") ?></label>
                        <?= $this->Form->input(null, ["default" => isset($this->request->query['Debt_debt_date']) ? $this->request->query['Debt_debt_date'] : "", "name" => "Debt.debt_date", "class" => "form-control datepicker", "type" => "text", "div" => false, "label" => false]) ?>
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
    /* Cari Nama Pegawai */
    var number = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('debt_number'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        prefetch: '<?= Router::url("/admin/debts/receipt_debt_number_list", true) ?>',
        remote: {
            url: '<?= Router::url("/admin/debts/receipt_debt_number_list", true) ?>' + '?q=%QUERY',
            wildcard: '%QUERY',
        }
    });
    number.clearPrefetchCache();
    number.initialize(true);
    $('input.typeahead-ajax').typeahead({
        hint: false,
        highlight: true
    }, {
        name: 'number',
        display: 'debt_number',
        source: number.ttAdapter(),
        templates: {
            header: '<center><h5>Data Hutang</h5></center><hr>',
            suggestion: function (data) {
                return '<p> Nomor Hutang : ' + data.debt_number + '<br/> Total Hutang : ' + RP(data.total_debt_amount) + '<br/> Tanggal : ' + cvtWaktu(data.debt_date) + '</p>';
            },
            empty: [
                '<center><h5>Data Hutang</h5></center><hr> <center><p> Hasil Pencarian Anda Tidak Dapat Ditemukan. </p></center>',
            ]
        }
    });
    $('input.typeahead-ajax').bind('typeahead:select', function (ev, suggestion) {
        $("#debtNumber").val(suggestion.id);
    });
</script>