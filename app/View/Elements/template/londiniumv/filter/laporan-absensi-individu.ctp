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
                        <label ><?= __("Per Bulan") ?></label>
                        <div class="row">
                            <div class="col-md-8">
                                <?= $this->Form->input(null, ["options" => $this->Echo->periodeBulan(), "name" => "Laporan.bulan", "class" => "select-full", "selected" => date("n"), "div" => false, "label" => false]) ?>
                            </div>
                            <div class="col-md-4">
                                <?= $this->Form->input(null, ["options" => $this->Echo->periodeTahun(), "name" => "Laporan.tahun", "class" => "select-full", "div" => false, "label" => false]) ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-6">
                                <label><?= __("Periode Absensi") ?></label>
                                <?= $this->Form->input(null, ["default" => isset($this->request->query['Laporan_tanggal_awal']) ? $this->request->query['Laporan_tanggal_awal'] : '', "placeholder" => "Awal Periode", "name" => "Laporan.tanggal_awal", "class" => "form-control datepicker", "id" => "startDate", "div" => false, "label" => false]) ?>
                            </div>
                            <div class="col-md-6">
                                <label><?= __("&nbsp;") ?></label>
                                <?= $this->Form->input(null, ["default" => isset($this->request->query['Laporan_tanggal_akhir']) ? $this->request->query['Laporan_tanggal_akhir'] : '', "placeholder" => "Akhir Periode", "name" => "Laporan.tanggal_akhir", "class" => "form-control datepicker", "id" => "endDate", "div" => false, "label" => false]) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
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