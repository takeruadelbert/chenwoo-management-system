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
                        <label><?= __("Nama Mesin") ?></label>
                        <?= $this->Form->input(null, array("default" => isset($this->request->query['AttendanceMachine_name']) ? $this->request->query['AttendanceMachine_name'] : '', "name" => "AttendanceMachine.name", "div" => false, "label" => false, "class" => "form-control tip")) ?>
                    </div>
                    <div class="col-md-6">
                        <label><?= __("IP") ?></label>
                        <?= $this->Form->input(null, array("default" => isset($this->request->query['AttendanceMachine_ipv4']) ? $this->request->query['AttendanceMachine_ipv4'] : '', "name" => "AttendanceMachine.ipv4", "div" => false, "label" => false, "class" => "form-control tip")) ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <label><?= __("Lokasi") ?></label>
                        <?= $this->Form->input(null, array("default" => isset($this->request->query['AttendanceMachine_location']) ? $this->request->query['AttendanceMachine_location'] : '', "name" => "AttendanceMachine.location", "div" => false, "label" => false, "class" => "form-control tip")) ?>
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
