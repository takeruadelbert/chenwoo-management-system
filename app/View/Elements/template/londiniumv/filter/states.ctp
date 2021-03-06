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
                        <label><?= __("State") ?></label>
                        <?= $this->Form->input(null, array("default" => isset($this->request->query['State_name']) ? $this->request->query['State_name'] : '', "name" => "State.name", "div" => false, "label" => false, "class" => "form-control tip")) ?>
                    </div>
                    <div class="col-md-6">
                        <label><?= __("Country") ?></label>
                        <?= $this->Form->input(null, array("options" => $countries, "default" => isset($this->request->query['select_State_country_id']) ? $this->request->query['select_State_country_id'] : '', "name" => "select.State.country_id", "div" => false, "label" => false, "class" => "select-full", "empty" => "", "placeholder" => "- Semua -")) ?>
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
