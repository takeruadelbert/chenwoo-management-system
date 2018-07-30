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
                        <label><?= __("Nama Libur") ?></label>
                        <?= $this->Form->input(null, ["default" => isset($this->request->query['Holiday_name']) ? $this->request->query['Holiday_name'] : '', "name" => "Holiday.name", "class" => "form-control", "div" => false, "label" => false]) ?>
                    </div>
                    <div class="col-md-6">
                        <label ><?= __("Per Bulan") ?></label>
                        <div class="row">
                            <div class="col-md-8">
                                <?= $this->Form->input(null, ["default" => isset($this->request->query['bulan']) ? $this->request->query['bulan'] : "", "options" => $this->Echo->periodeBulan(), "name" => "bulan", "class" => "select-full", "div" => false, "label" => false, "empty" => "", "placeholder" => "- Semua -"]) ?>
                            </div>
                            <div class="col-md-4">
                                <?= $this->Form->input(null, ["default" => isset($this->request->query['tahun']) ? $this->request->query['tahun'] : "", "options" => $this->Echo->periodeTahun(date("Y") + 1, 2000), "name" => "tahun", "class" => "select-full", "div" => false, "label" => false, "empty" => "", "placeholder" => "- Semua -"]) ?>
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