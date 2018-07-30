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
                        <label><?= __("Nama Mesin Absensi") ?></label>
                        <?= $this->Form->input(null, array("default" => isset($this->request->query['AttendanceMachine_name']) ? $this->request->query['AttendanceMachine_name'] : '', "name" => "AttendanceMachine.name", "div" => false, "label" => false, "class" => "form-control tip")) ?>
                    </div>
                    <div class="col-md-6">
                        <label><?= __("IP Mesin Absensi") ?></label>
                        <?= $this->Form->input(null, array("default" => isset($this->request->query['AttendanceMachine_ipv4']) ? $this->request->query['AttendanceMachine_ipv4'] : '', "name" => "AttendanceMachine.ipv4", "div" => false, "label" => false, "class" => "form-control tip")) ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <label><?= __("UID Pegawai") ?></label>
                        <?= $this->Form->input(null, array("default" => isset($this->request->query['AttendanceEmployeeUid_uid']) ? $this->request->query['AttendanceEmployeeUid_uid'] : '', "name" => "AttendanceEmployeeUid.uid", "div" => false, "label" => false, "class" => "form-control tip")) ?>
                    </div>
                    <div class="col-md-6">
                        <label><?= __("Nama Pegawai") ?></label>
                        <?= $this->Form->input(null, ["default" => isset($this->request->query['select_AttendanceEmployeeUid_employee_id']) ? $this->request->query['select_AttendanceEmployeeUid_employee_id'] : 0, "options" => $employees, "name" => "select.AttendanceEmployeeUid.employee_id", "class" => "select-full", "div" => false, "label" => false, "empty" => "", "placeholder" => "- Semua -"]) ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <label><?= __("Tipe Pegawai") ?></label>
                        <?= $this->Form->input(null, ["default" => isset($this->request->query['select_Employee_employee_type_id']) ? $this->request->query['select_Employee_employee_type_id'] : '', "name" => "select.Employee.employee_type_id", "class" => "select-full", "div" => false, "label" => false, "options" => $employeeTypes, "empty" => "", "placeholder" => "- Semua -"]) ?>
                    </div>
                    <div class="col-md-6">
                        <label><?= __("Cabang Perusahaan") ?></label>
                        <?= $this->Form->input(null, ["default" => isset($this->request->query['select_Employee_branch_office_id']) ? $this->request->query['select_Employee_branch_office_id'] : '', "name" => "select.Employee.branch_office_id", "class" => "select-full", "div" => false, "label" => false, "options" => $branchOffices, "empty" => "", "placeholder" => "- Semua -"]) ?>
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
