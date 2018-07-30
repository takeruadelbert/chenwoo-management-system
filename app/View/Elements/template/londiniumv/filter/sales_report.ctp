<form action="#" role="form" class="panel-filter">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h6 class="panel-title">Filter Data</h6>
            <div class="panel-icons-group"> <a href="#" data-panel="collapse" class="btn btn-link btn-icon"><i class="icon-arrow-up9"></i></a></div>
        </div>
        <div class="panel-body">
            <div class = "form-group">
                <div class="row">
                    <div class="col-md-6">
                        <label ><?= __("Per Bulan") ?></label>
                        <div class="row">
                            <div class="col-md-8">
                                <?= $this->Form->input(null, ["default" => isset($this->request->query["Laporan_bulan"]) ? $this->request->query["Laporan_bulan"] : date("m"), "options" => $this->Echo->periodeBulan(), "name" => "Laporan.bulan", "class" => "select-full", "div" => false, "label" => false]) ?>
                            </div>
                            <div class="col-md-4">
                                <?= $this->Form->input(null, ["default" => isset($this->request->query["Laporan_tahun"]) ? $this->request->query["Laporan_tahun"] : date("m"), "options" => $this->Echo->periodeTahun(), "name" => "Laporan.tahun", "class" => "select-full", "div" => false, "label" => false]) ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label ><?= __("Kurs") ?></label>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="input-group">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" type="button">Rp.</button>
                                    </span>
                                    <?= $this->Form->input(null, ["default" => isset($this->request->query["Laporan_kurs"]) ? $this->request->query["Laporan_kurs"] : 0, "name" => "Laporan.kurs", "class" => "form-control text-right isdecimal", "value" => $this->Html->getExchangeRate(1, "USD", "IDR"), "div" => false, "label" => false]) ?>
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" type="button">,00.</button>
                                    </span>
                                </div>
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
