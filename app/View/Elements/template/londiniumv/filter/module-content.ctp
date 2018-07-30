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
                        <label><?= __("Label") ?></label>
                        <?= $this->Form->input(null, ["default" => isset($this->request->query['ModuleContent_name']) ? $this->request->query['ModuleContent_name'] : '', "name" => "ModuleContent.name", "class" => "form-control tip", "div" => false, "label" => false]) ?>
                    </div>
                    <div class="col-md-6">
                        <label><?= __("Alias") ?></label>
                        <?= $this->Form->input(null, ["default" => isset($this->request->query['ModuleContent_alias']) ? $this->request->query['ModuleContent_alias'] : '', "name" => "ModuleContent.alias", "class" => "form-control tip", "div" => false, "label" => false]) ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <label><?= __("Modul") ?></label>
                        <?= $this->Form->input(null, ["default" => isset($this->request->query['select_ModuleContent_module_id']) ? $this->request->query['select_ModuleContent_module_id'] : '', 'options' => $modules, "name" => "select.ModuleContent.module_id", "class" => "select-full", "div" => false, "label" => false, "empty" => "-" . __("- Semua -") . "-"]) ?>
                    </div>
                    <div class="col-md-6">
                        <label><?= __("Parent") ?></label>
                        <?= $this->Form->input(null, ["default" => isset($this->request->query['select_ModuleContent_parent_id']) ? $this->request->query['select_ModuleContent_parent_id'] : '', 'options' => $moduleContents, "name" => "select.ModuleContent.parent_id", "class" => "select-full", "div" => false, "label" => false, "empty" => "-" . __("- Semua -") . "-"]) ?>
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
