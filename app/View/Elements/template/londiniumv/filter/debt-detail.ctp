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
                            $debt = "";
                            if(isset($this->request->query['select_DebtDetail_debt_id'])) {
                                $debt = ClassRegistry::init("Debt")->find("first",[
                                    "conditions" => [
                                        "Debt.id" => $this->request->query['select_DebtDetail_debt_id']
                                    ]
                                ]);
                            }
                            ?>
                            <label><?= __("Nomor Hutang") ?></label>
                            <input type="text" placeholder="Cari Nomor Hutang ..." class="form-control typeahead-ajax-debt" value="<?= !empty($debt) ? $debt['Debt']['debt_number'] : "" ?>">
                            <input type="hidden" name="DebtDetail.debt_id" id="debtId">
                            <i class="icon-search3 form-control-feedback"></i>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="has-feedback">
                            <?php
                            $receiptNumber = "";
                            if(isset($this->request->query['DebtDetail_id'])) {
                                $receiptNumber = ClassRegistry::init("DebtDetail")->find("first",[
                                    "conditions" => [
                                        "DebtDetail.id" => $this->request->query['DebtDetail_id']
                                    ]
                                ]);
                            }
                            ?>
                            <label><?= __("Nomor Kwitansi") ?></label>
                            <input type="text" placeholder="Cari Nomor Kwitansi ..." class="form-control typeahead-ajax-debtDetail" value="<?= !empty($receiptNumber) ? $receiptNumber['DebtDetail']['receipt_number'] : "" ?>">
                            <input type="hidden" name="DebtDetail.id" id="receiptNumber">
                            <i class="icon-search3 form-control-feedback"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <label><?= __("Start Date") ?></label>
                        <?= $this->Form->input(null, ["div" => false, "label" => false, "type" => "text", "id" => "startDate", "class" => "form-control datetime", "name" => "start_date", "default" => isset($this->request->query['start_date']) ? $this->request->query['start_date'] : ""]) ?>
                    </div>
                    <div class="col-md-6">
                        <label><?= __("End Date") ?></label>
                        <?= $this->Form->input(null, ["div" => false, "label" => false, "type" => "text", "id" => "endDate", "class" => "form-control datetime", "name" => "end_date", "default" => isset($this->request->query['end_date']) ? $this->request->query['end_date'] : ""]) ?>
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
    /* Cari Nomor Hutang */
    var debt = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('debt_number'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        prefetch: '<?= Router::url("/admin/debts/receipt_debt_number_list", true) ?>',
        remote: {
            url: '<?= Router::url("/admin/debts/receipt_debt_number_list", true) ?>' + '?q=%QUERY',
            wildcard: '%QUERY',
        }
    });
    debt.clearPrefetchCache();
    debt.initialize(true);
    $('input.typeahead-ajax-debt').typeahead({
        hint: false,
        highlight: true
    }, {
        name: 'debt',
        display: 'debt_number',
        source: debt.ttAdapter(),
        templates: {
            header: '<center><h5>Data Hutang</h5></center><hr>',
            suggestion: function (data) {
                return '<p> Nomor Hutang : ' + data.debt_number + '<br/> Total Hutang : ' + data.total_debt_amount + '<br/> Tanggal : ' + cvtWaktu(data.debt_date) + '</p>';
            },
            empty:[
                '<center><h5>Data Hutang</h5></center><hr> <center><p> Hasil Pencarian Anda Tidak Dapat Ditemukan. </p></center>',
            ] 
        }
    });
    $('input.typeahead-ajax-debt').bind('typeahead:select', function (ev, suggestion) {
        $("#debtId").val(suggestion.id);
    });
    
    /* Cari Nomor Kwitansi */
    var debtDetail = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('receipt_number'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        prefetch: '<?= Router::url("/admin/debt_details/receipt_number_list", true) ?>',
        remote: {
            url: '<?= Router::url("/admin/debt_details/receipt_number_list", true) ?>' + '?q=%QUERY',
            wildcard: '%QUERY',
        }
    });
    debtDetail.clearPrefetchCache();
    debtDetail.initialize(true);
    $('input.typeahead-ajax-debtDetail').typeahead({
        hint: false,
        highlight: true
    }, {
        name: 'debtDetail',
        display: 'receipt_number',
        source: debtDetail.ttAdapter(),
        templates: {
            header: '<center><h5>Data Kwitansi</h5></center><hr>',
            suggestion: function (data) {
                return '<p> Nomor Kwitansi : ' + data.receipt_number + '<br/> Nominal Bayar : ' + data.amount + '</p>';
            },
            empty:[
                '<center><h5>Data Kwitansi</h5></center><hr> <center><p> Hasil Pencarian Anda Tidak Dapat Ditemukan. </p></center>',
            ] 
        }
    });
    $('input.typeahead-ajax-debtDetail').bind('typeahead:select', function (ev, suggestion) {
        $("#receiptNumber").val(suggestion.id);
    });
</script>