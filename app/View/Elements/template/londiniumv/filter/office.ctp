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
                        <label><?= __("Jabatan") ?></label>
                        <?= $this->Form->input(null, array("default" => isset($this->request->query['Office_name']) ? $this->request->query['Office_name'] : '', "name" => "Office.name", "div" => false, "label" => false, "class" => "form-control tip")) ?>
                    </div>
                    <div class="col-md-6">
                        <label><?= __("Atasan") ?></label>
                        <?= $this->Form->input(null, array("default" => isset($this->request->query['select_Office_supervisor_id']) ? $this->request->query['select_Office_supervisor_id'] : '', "name" => "select.Office.supervisor_id", "div" => false, "label" => false, "class" => "select-full", "empty" => "", "placeholder" => "- Semua -", "options" => $supervisors)) ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <label><?= __("Department") ?></label>
                        <?= $this->Form->input(null, array("default" => isset($this->request->query['select_Office_department_id']) ? $this->request->query['select_Office_department_id'] : '', "name" => "select.Office.department_id", "div" => false, "label" => false, "class" => "select-full", "options" => $departments, "empty" => "", "placeholder" => "- Semua -")) ?>
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
