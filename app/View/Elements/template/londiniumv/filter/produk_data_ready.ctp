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
                        <label><?= __("Nama Product Size") ?></label>
                        <?= $this->Form->input(null, ["div" => false, "label" => false, "class" => "form-control tip", "type" => "text", "name" => "ProductSize.name", "default" => isset($this->request->query['ProductSize_name']) ? $this->request->query['ProductSize_name'] : ""]) ?>
                    </div>
                    <div class="col-md-6">
                        <label><?= __("Tanggal Produksi") ?></label>
                        <?= $this->Form->input(null, ["div" => false, "label" => false, "class" => "form-control tip datepicker", "type" => "text", "name" => "ProductData.created", "default" => isset($this->request->query['ProductData_created']) ? $this->request->query['ProductData_created'] : ""]) ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <label><?= __("Status") ?></label>
                        <?= $this->Form->input(null, ["div" => false, "label" => false, "options" => $productStatuses,"empty" => "- Semua -", "class" => "select-full", "name" => "select.ProductData.product_status_id", "default" => isset($this->request->query['select_ProductData_product_status_id']) ? $this->request->query['select_ProductData_product_status_id'] : ""]) ?>
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
