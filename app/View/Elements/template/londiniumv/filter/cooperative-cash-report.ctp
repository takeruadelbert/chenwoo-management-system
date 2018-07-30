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
                        <label><?= __("Nama Kas") ?></label>
                        <?= $this->Form->input(null, ["div" => false, "label" => false, "class" => "form-control tip", "name" => "CooperativeCash.name", "default" => isset($this->request->query['CooperativeCash_name']) ? $this->request->query['CooperativeCash_name'] : ""]) ?>
                    </div>
                    <div class="col-md-6">
                        <label><?= __("Tipe Kas") ?></label>
                        <?= $this->Form->input(null, ["div" => false, "label" => false, "class" => "select-full", "name" => "select.CooperativeCash.cash_type_id", "default" => isset($this->request->query['select_CooperativeCash_cash_type_id']) ? $this->request->query['select_CooperativeCash_cash_type_id'] : "", "empty" => "", "placeholder" => "- Semua -", "options" => $cashTypes]) ?>
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
