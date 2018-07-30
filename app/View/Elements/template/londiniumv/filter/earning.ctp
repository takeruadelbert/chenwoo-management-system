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
                        <label ><?= __("Periode Awal") ?></label>
                        <div class="row">
                            <div class="col-md-8">
                                <?= $this->Form->input(null, ["default" => isset($this->request->query['awalint_EmployeeSalary_month_period']) ? $this->request->query['awalint_EmployeeSalary_month_period'] : 0, "options" => $this->Echo->periodeBulan(), "name" => "awalint.EmployeeSalary.month_period", "class" => "select-full", "selected" => date("n"), "div" => false, "label" => false]) ?>
                            </div>
                            <div class="col-md-4">
                                <?= $this->Form->input(null, ["default" => isset($this->request->query['awalint_EmployeeSalary_year_period']) ? $this->request->query['awalint_EmployeeSalary_year_period'] : 0, "options" => $this->Echo->periodeTahun(), "name" => "awalint.EmployeeSalary.year_period", "class" => "select-full", "div" => false, "label" => false]) ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label ><?= __("Periode Akhir") ?></label>
                        <div class="row">
                            <div class="col-md-8">
                                <?= $this->Form->input(null, ["default" => isset($this->request->query['akhirint_EmployeeSalary_month_period']) ? $this->request->query['akhirint_EmployeeSalary_month_period'] : 0, "options" => $this->Echo->periodeBulan(), "name" => "akhirint.EmployeeSalary.month_period", "class" => "select-full", "selected" => date("n"), "div" => false, "label" => false]) ?>
                            </div>
                            <div class="col-md-4">
                                <?= $this->Form->input(null, ["default" => isset($this->request->query['akhirint_EmployeeSalary_year_period']) ? $this->request->query['akhirint_EmployeeSalary_year_period'] : 0, "options" => $this->Echo->periodeTahun(), "name" => "akhirint.EmployeeSalary.year_period", "class" => "select-full", "div" => false, "label" => false]) ?>
                            </div>
                        </div>
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
