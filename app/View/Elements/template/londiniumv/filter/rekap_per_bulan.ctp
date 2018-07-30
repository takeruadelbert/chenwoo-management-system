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
                        <label><?= __("Tanggal Awal Pembobotan") ?></label>
                        <?= $this->Form->input(null, ["type" => "text", "div" => false, "label" => false, "class" => "form-control datepicker", "default" => isset($this->request->query["start_date"]) ? $this->request->query['start_date'] : "", "name" => "start_date", "id" => "startDate"]) ?>
                    </div>
                    <div class="col-md-6">
                        <label><?= __("Tanggal Akhir Pembobotan") ?></label>
                        <?= $this->Form->input(null, ["type" => "text", "div" => false, "label" => false, "class" => "form-control datepicker", "default" => isset($this->request->query["end_date"]) ? $this->request->query['end_date'] : "", "name" => "end_date", "id" => "endDate"]) ?>                   
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <label><?= __("Kurs") ?></label>
                        <div class="input-group">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button">Rp.</button>
                            </span>
                            <?= $this->Form->input(null, ["default" => isset($this->request->query["Laporan_kurs"]) ? $this->request->query["Laporan_kurs"] : 0, "name" => "Laporan.kurs", "class" => "form-control text-right isdecimal", "value" => $this->Html->getExchangeRate(1, "USD", "IDR"), "div" => false, "label" => false]) ?>
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button">,00.</button>
                            </span>
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