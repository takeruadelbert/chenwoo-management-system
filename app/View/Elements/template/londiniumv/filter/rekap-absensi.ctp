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
                        <label><?= __("locale0002") ?></label>
                        <?= $this->Form->input(null, ["default" => isset($this->request->query["Laporan_department"]) ? $this->request->query["Laporan_department"] : "", "options" => $departments, "name" => "Laporan.department", "class" => "select-full", "div" => false, "label" => false, "empty" => "- Semua -"]) ?>
                    </div>
                    <div class="col-md-6">
                        <label><?= __("Tipe Pegawai") ?></label>
                        <?= $this->Form->input(null, ["default" => isset($this->request->query['select_Employee_employee_type_id']) ? $this->request->query['select_Employee_employee_type_id'] : '', "name" => "select.Employee.employee_type_id", "class" => "select-full", "div" => false, "label" => false, "options" => $employeeTypes, "empty" => "", "placeholder" => "- Semua -"]) ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-3">
                        <label><?= __("Periode") ?></label>
                        <?= $this->Form->input(null, ['default' => isset($this->request->query['Laporan_tanggal_mulai']) ? $this->request->query['Laporan_tanggal_mulai'] : "", 'name' => "Laporan.tanggal_mulai", "class" => "form-control datepicker", "div" => false, "label" => false, "type" => "text", "id" => "StartDate", "placeholder" => "Periode Awal"]) ?>
                    </div>
                    <div class="col-md-3">
                        <label><?= __("&nbsp;") ?></label>
                        <?= $this->Form->input(null, ['default' => isset($this->request->query['Laporan_tanggal_akhir']) ? $this->request->query['Laporan_tanggal_akhir'] : "", 'name' => "Laporan.tanggal_akhir", "class" => "form-control datepicker", "div" => false, "label" => false, "type" => "text", "id" => "endDate", "placeholder" => "Periode Akhir"]) ?>
                    </div>
                    <div class="col-md-6">
                        <label ><?= __("Per Bulan") ?></label>
                        <div class="row">
                            <div class="col-md-8">
                                <?= $this->Form->input(null, ["default" => isset($this->request->query["Laporan_bulan"]) ? $this->request->query["Laporan_bulan"] : date("n"), "options" => $this->Echo->periodeBulan(), "name" => "Laporan.bulan", "class" => "select-full", "div" => false, "label" => false, "empty" => "- Semua -"]) ?>
                            </div>
                            <div class="col-md-4">
                                <?= $this->Form->input(null, ["default" => isset($this->request->query["Laporan_tahun"]) ? $this->request->query["Laporan_tahun"] : date("Y"), "options" => $this->Echo->periodeTahun(), "name" => "Laporan.tahun", "class" => "select-full", "div" => false, "label" => false, "empty" => "- Semua -"]) ?>
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