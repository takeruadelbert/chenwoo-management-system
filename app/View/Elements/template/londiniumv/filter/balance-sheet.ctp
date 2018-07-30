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
                        <label><?= __("Bulan") ?></label>
                        <?= $this->Form->input(null, array("div" => array("class" => "col-md-12", "style" => "padding-left:0px;"), "value" => date("m"), "label" => false, "options" => $this->Echo->periodeBulan(), "class" => "select-full", "default" => isset($this->request->query["bulan"]) ? $this->request->query['bulan'] : "", "name" => "bulan", "id" => "bulan", "data-placeholder" => "- Pilih Periode Bulan -", "empty" => "")); ?>
                    </div>
                    <div class="col-md-6">
                        <label><?= __("Tahun") ?></label>
                        <?= $this->Form->input(null, array("div" => array("class" => "col-md-12", "style" => "padding-left:0px;"), "value" => date("Y"), "label" => false, "options" => $this->Echo->periodeTahun(), "class" => "select-full", "default" => isset($this->request->query["tahun"]) ? $this->request->query['tahun'] : "", "name" => "tahun", "id" => "tahun", "data-placeholder" => "- Pilih Periode Tahun -", "empty" => "")); ?>
                    </div>
                </div>
            </div>
<!--            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <label><?= __("Kurs") ?></label>
                        <div class="input-group">
                            <span class="input-group-addon"><strong>Rp.</strong></span>
                            <?= $this->Form->input(null, array("div" => false, "label" => false, "class" => "form-control isdecimal text-right", "default" => isset($this->request->query["exchange_rate"]) ? $this->request->query['exchange_rate'] : "", "name" => "exchange_rate", "value" => $this->Html->getExchangeRate(1, "USD", "IDR"))); ?>
                            <span class="input-group-addon"><strong>,00.</strong></span>
                        </div>
                    </div>
                </div>
            </div>-->
            <div class="form-actions text-center">
                <input type="button" value="<?= __("Reset") ?>" class="btn btn-danger btn-filter-reset">
                <a href="" target="_blank"><button class="btn btn-info btn-filter">Cari</button></a>
            </div>
        </div>
    </div>
</form>