<form action="#" role="form" class="panel-filter">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h6 class="panel-title">Filter Data</h6>
            <div class="panel-icons-group"> <a href="#" data-panel="collapse" class="btn btn-link btn-icon"><i class="icon-arrow-up9"></i></a></div>
        </div>
        <div class="panel-body">
            <div class="form-group">
                <div class="row">
                    <div class="col-md-3">
                        <label><?= __("Periode Jurnal") ?></label>
                        <?= $this->Form->input(null,["type" => "text", "div" => false, "placeholder" => "Awal Periode", "label" => false, "class" => "form-control datepicker", "default" => isset($this->request->query["start_date"]) ? $this->request->query['start_date'] : date("Y-m-01"), "name" => "start_date", "id" => "startDate"]) ?>
                    </div>
                    <div class="col-md-3">
                        <label><?= __("&nbsp") ?></label>
                        <?= $this->Form->input(null,["type" => "text", "div" => false, "placeholder" => "Akhir Periode", "label" => false, "class" => "form-control datepicker", "default" => isset($this->request->query["end_date"]) ? $this->request->query['end_date'] : date("Y-m-t"), "name" => "end_date", "id" => "endDate"]) ?>
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