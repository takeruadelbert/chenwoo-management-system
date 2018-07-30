<form action="#" role="form" class="panel-filter" target="_blank">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h6 class="panel-title">Filter Data</h6>
            <div class="panel-icons-group"> <a href="#" data-panel="collapse" class="btn btn-link btn-icon"><i class="icon-arrow-up9"></i></a></div>
        </div>
        <div class="panel-body">
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <label><?= __("Tanggal Awal") ?></label>
                        <?= $this->Form->input(null,["type" => "text", "value" => date("Y-m-d"), "div" => false, "label" => false, "class" => "form-control datepicker", "default" => isset($this->request->query["start_date"]) ? $this->request->query['start_date'] : "", "name" => "start_date", "id" => "startDate"]) ?>
                    </div>
                    <div class="col-md-6">
                        <label><?= __("Tanggal Akhir") ?></label>
                        <?= $this->Form->input(null,["type" => "text", "value" => date("Y-m-d"), "div" => false, "label" => false, "class" => "form-control datepicker", "default" => isset($this->request->query["end_date"]) ? $this->request->query['end_date'] : "", "name" => "end_date", "id" => "endDate"]) ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <label>Kas</label>
                        <?= $this->Form->input(null, ["div" => false, "class" => "select-full", "empty" => "", "placeholder" => "- Pilih Kas -", "name" => "select.TransactionMutation.initial_balance_id", "options" => $initialBalances]) ?>
                    </div>
                </div>
            </div>
            <div class="form-actions text-center">
                <input type="button" value="<?= __("Reset") ?>" class="btn btn-danger btn-filter-reset">
                <a href="" target="_blank"><button class="btn btn-info btn-filter">Cari</button></a>
            </div>
        </div>
    </div>
</form>