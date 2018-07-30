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
                        <label><?= __("Tanggal Pengolahan Ikan") ?></label>
                        <?= $this->Form->input(null, ["type" => "text", "div" => false, "label" => false, "class" => "form-control datepicker", "default" => isset($this->request->query["Conversion_date"]) ? $this->request->query['Conversion_date'] : "", "name" => "Conversion.date"]) ?>
                    </div>
                    <div class="col-md-6">
                        <label>Cabang Perusahaan</label>
                        <?= $this->Form->input(null, ["div" => false, "label" => false, "class" => "select-full", "default" => isset($this->request->query['select_Conversion_branch_office_id']) ? $this->request->query['select_Conversion_branch_office_id'] : "", "empty" => "", "name" => "select.Conversion.branch_office_id", "placeholder" => "- Semua -", "options" => $branchOffices]) ?>
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