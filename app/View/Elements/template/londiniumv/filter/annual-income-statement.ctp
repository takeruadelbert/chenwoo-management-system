<form action="#" role="form" class="panel-filter" target="_blank">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h6 class="panel-title">Filter Data</h6>
            <div class="panel-icons-group"> <a href="#" data-panel="collapse" class="btn btn-link btn-icon"><i class="icon-arrow-up9"></i></a></div>
        </div>
        <div class="panel-body">
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <label><?= __("Tahun") ?></label>
                        <select name="year" class="select-full">
                            <option value="">- Pilih Tahun -</option>
                            <?php
                            $isSelected = "";
                            for($year = date("Y"); $year >= 1990; $year--) {
                                if(!empty($this->request->query['year'])) {
                                    if($this->request->query['year'] == $year) {
                                        $isSelected = "selected";
                                    } else {
                                        $isSelected = "";
                                    }
                                }
                            ?>
                            <option value="<?= $year ?>" <?= $isSelected ?>><?= $year ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-actions text-center">
                <input type="button" value="<?= __("Reset") ?>" class="btn btn-danger btn-filter-reset">
                <a href="" target="_blank"><button class="btn btn-info btn-filter">Cari</button></a>
            </div>
        </div>
    </div>
</form>