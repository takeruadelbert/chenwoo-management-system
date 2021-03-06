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
                        <label><?= __("Nama") ?></label>
                        <?= $this->Form->input(null, ["div" => false, "label" => false, "class" => "form-control tip", "name" => "GeneralEntryType.name", "default" => isset($this->request->query['GeneralEntryType_name']) ? $this->request->query['GeneralEntryType_name'] : ""]) ?>
                    </div>
                    <div class="col-md-6">
                        <label><?= __("Kode") ?></label>
                        <?= $this->Form->input(null, ["div" => false, "label" => false, "class" => "form-control tip iscoa", "name" => "GeneralEntryType.code", "default" => isset($this->request->query['GeneralEntryType_code']) ? $this->request->query['GeneralEntryType_code'] : "", "maxlength" => 11]) ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <label><?= __("Klasifikasi") ?></label>
                        <?= $this->Form->input(null, ["div" => false, "label" => false, "class" => "select-full", "name" => "select.GeneralEntryType.parent_id", "default" => isset($this->request->query['select_GeneralEntryType_parent_id']) ? $this->request->query['select_GeneralEntryType_parent_id'] : "", "options" => $generalEntryTypes, "empty" => "", "placeholder" => "- Semua -"]) ?>
                    </div>
                    <div class="col-md-6">
                        <label><?= __("Mata Uang") ?></label>
                        <?= $this->Form->input(null, ["div" => false, "label" => false, "class" => "select-full", "name" => "select.GeneralEntryType.currency_id", "default" => isset($this->request->query['select_GeneralEntryType_currency_id']) ? $this->request->query['select_GeneralEntryType_currency_id'] : "", "options" => $currencies, "empty" => "", "placeholder" => "- Semua -"]) ?>
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
</script>
