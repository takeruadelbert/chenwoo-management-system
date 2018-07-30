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
                        <label><?= __("Judul Agenda") ?></label>
                        <?= $this->Form->input(null, ["div" => false, "label" => false, "class" => "form-control tip", "name" => "DepartmentAgenda.title", "default" => isset($this->request->query['IndividualAgenda_title']) ? $this->request->query['IndividualAgenda_title'] : ""]) ?>
                    </div>
                    <div class="col-md-6">
                        <label><?= __("Departemen") ?></label>
                        <?= $this->Form->input(null, ['div' => false, 'label' => false, "class" => "select-full", 'name' => "select.DepartmentAgenda.department_id", "default" => isset($this->request->query['select_DepartmentAgenda_department_id']) ? $this->request->query['select_DepartmentAgenda_department_id'] : "", "empty" => "", "placeholder" => "- Pilih Departemen -", "options" => $departments]) ?>
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
