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
                        <label><?= __("Nama Pegawai yang Keluar") ?></label>
                        <?php
                        if (isset($this->request->query['employee_id']) && !empty($this->request->query['employee_id'])) {
                            echo $this->Form->input(null, ["default" => isset($this->request->query['employee_id']) ? $this->request->query['employee_id'] : 0, "options" => $excludedEmployees, "name" => "employee_id", "class" => "select-full", "div" => false, "label" => false, "empty" => "- Semua -"]);
                        } else {
                            echo $this->Form->input(null, ["name" => "employee.id", 'options' => $excludedEmployees, 'label' => false, 'div' => false, 'class' => 'select-full', 'empty' => "", 'placeholder' => "- Semua -", 'value' => $emp_id]);
                        }
                        ?>
                    </div>
                    <div class="col-md-6">
                        <label ><?= __("Periode") ?></label>
                        <div class="row">
                            <?php
                            $month = date("m", strtotime($start_date));
                            $year = date("Y", strtotime($end_date));
                            ?>
                            <div class="col-md-8">
                                <?= $this->Form->input(null, ["default" => $month, "options" => $this->Echo->periodeBulan(), "name" => "Laporan.bulan", "class" => "select-full", "div" => false, "label" => false]) ?>
                            </div>
                            <div class="col-md-4">
                                <?= $this->Form->input(null, ["default" => $year, "options" => $this->Echo->periodeTahun(), "name" => "Laporan.tahun", "class" => "select-full", "div" => false, "label" => false]) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-actions text-center">
                <input name="show" value="1" type="hidden"/>
                <input type="button" value="<?= __("Reset") ?>" class="btn btn-danger btn-filter-reset">
                <input type="button" value="<?= __("Cari") ?>" class="btn btn-info btn-filter">
            </div>
        </div>
    </div>
</form>
<script>
    filterReload();
</script>