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
                        <label ><?= __("Tahun") ?></label>
                        <?= $this->Form->input(null, ["default" => isset($this->request->query["Laporan_tahun"]) ? $this->request->query["Laporan_tahun"] : date("m"), "options" => $this->Echo->periodeTahun(), "name" => "Laporan.tahun", "class" => "select-full", "div" => false, "label" => false]) ?>
                    </div>
                    <?php
                    if ($stnAdmin->branchPrivilege()) {
                        ?>
                        <div class="col-md-6">
                            <label><?= __("Cabang") ?></label>
                            <?= $this->Form->input(null, ["default" => isset($this->request->query['Laporan_cabang']) ? $this->request->query['Laporan_cabang'] : '', "options" => $branchOffices, "name" => "Laporan.cabang", "class" => "select-full", "div" => false, "label" => false, "empty" => "", "placeholder" => "- Semua -"]) ?>
                        </div>
                        <?php
                    }
                    ?>
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