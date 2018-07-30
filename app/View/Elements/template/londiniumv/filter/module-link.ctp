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
                        <?= $this->Form->input(null, ["label" => false, "div" => false, "class" => "form-control tip", "name" => "ModuleLink.name", "default" => isset($this->request->query['ModuleLink_name']) ? $this->request->query['ModuleLink_name'] : ""]) ?>
                    </div>
                    <div class="col-md-6">
                        <label ><?= __("Alias") ?></label>
                        <?= $this->Form->input(null, ["label" => false, "div" => false, "class" => "form-control tip", "name" => "ModuleLink.alias", "default" => isset($this->request->query['ModuleLink_alias']) ? $this->request->query['ModuleLink_alias'] : ""]) ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <label><?= __("Modul") ?></label>
                        <?= $this->Form->input(null, ['label' => false, "div" => false, 'options' => $modules, "name" => "select.ModuleLink.module_id","class"=>"select-full","empty"=>"-".__("- Semua -")."-", "default" => isset($this->request->query['select_ModuleLink_module_id']) ? $this->request->query['select_ModuleLink_module_id'] : ""]) ?>
                    </div>
                    <div class="col-md-6">
                        <label ><?= __("Konten Modul") ?></label>
                        <?= $this->Form->input(null, ['label' => false, "div" => false, 'options' => $moduleContents, "name" => "select.ModuleLink.module_content_id","class"=>"select-full","empty"=>"-".__("- Semua -")."-", "default" => isset($this->request->query['select_ModuleLink_module_content_id']) ? $this->request->query['select_ModuleLink_module_content_id'] : ""]) ?>
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
