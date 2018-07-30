<form action="#" role="form" class="panel-filter">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h6 class="panel-title">Filter Data</h6>
            <div class="panel-icons-group"> <a href="#" data-panel="collapse" class="btn btn-link btn-icon"><i class="icon-arrow-up9"></i></a></div>
        </div>
        <div class="panel-body">
            <div class="form-group">
                <div class="row">
                    <div class="col-md-3">
                        <label><?= __("Periode Histori") ?></label>
                        <?= $this->Form->input(null, ["type" => "text", "div" => false, "label" => false, "class" => "form-control datetime", "default" => isset($this->request->query["awal_ProductHistory_history_datetime"]) ? $this->request->query['awal_ProductHistory_history_datetime'] : "", "name" => "awal_ProductHistory_history_datetime", "id" => "startDate", "placeholder" => "Awal Periode"]) ?>
                    </div>
                    <div class="col-md-3">
                        <label><?= __("&nbsp;") ?></label>
                        <?= $this->Form->input(null, ["type" => "text", "div" => false, "label" => false, "class" => "form-control datetime", "default" => isset($this->request->query["akhir_ProductHistory_history_datetime"]) ? $this->request->query['akhir_ProductHistory_history_datetime'] : "", "name" => "akhir_ProductHistory_history_datetime", "id" => "endDate", "placeholder" => "Akhir Periode"]) ?>
                    </div>
                    <div class="col-md-6">
                        <label><?= __("Nama Produk") ?></label>
                        <?= $this->Form->input(null, ["div" => false, "label" => false, "class" => "select-full", "name" => "select.ProductHistory.product_id", "default" => isset($this->request->query['select_ProductHistory_product_id']) ? $this->request->query['select_ProductHistory_product_id'] : "", "empty" => "", "placeholder" => "- Semua -", "options" => $products]) ?>
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