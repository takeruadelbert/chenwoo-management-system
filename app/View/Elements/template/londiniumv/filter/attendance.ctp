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
                        <label><?= __("Nama Pegawai") ?></label>
                        <?= $this->Form->input(null, ["default" => isset($this->request->query['select_Attendance_employee_id']) ? $this->request->query['select_Attendance_employee_id'] : '', "name" => "select.Attendance.employee_id", "class" => "select-full", "div" => false, "label" => false, "options" => $employees, "empty" => "", "placeholder" => "- Semua -"]) ?>
                    </div>
                    <div class="col-md-3">
                        <label><?= __("Periode Absensi") ?></label>
                        <?= $this->Form->input(null, ["default" => isset($this->request->query['awal_Attendance_dt']) ? $this->request->query['awal_Attendance_dt'] : '', "name" => "awal.Attendance.dt", "class" => "form-control datepicker", "div" => false, "label" => false, "id" => "startDate", "placeholder" => "Awal Periode"]) ?>
                    </div>
                    <div class="col-md-3">
                        <label><?= __("&nbsp;") ?></label>
                        <?= $this->Form->input(null, ["default" => isset($this->request->query['akhir_Attendance_dt']) ? $this->request->query['akhir_Attendance_dt'] : '', "name" => "akhir.Attendance.dt", "class" => "form-control datepicker", "div" => false, "label" => false, "id" => "endDate", "placeholder" => "Akhir Periode"]) ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <label><?= __("Tipe Pegawai") ?></label>
                        <?= $this->Form->input(null, ["default" => isset($this->request->query['select_Employee_employee_type_id']) ? $this->request->query['select_Employee_employee_type_id'] : '', "name" => "select.Employee.employee_type_id", "class" => "select-full", "div" => false, "label" => false, "options" => $employeeTypes, "empty" => "", "placeholder" => "- Semua -"]) ?>
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
