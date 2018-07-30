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
                        <label><?= __("Nama Supplier") ?></label>
                        <?= $this->Form->input(null, ["div" => false, "label" => false, "class" => "form-control tip", "name" => "Supplier.name", "default" => isset($this->request->query['Supplier_name']) ? $this->request->query['Supplier_name'] : ""]) ?>
                    </div>
                    <div class="col-md-6">
                        <label><?= __("Tipe Supplier") ?></label>
                        <?= $this->Form->input(null, ["div" => false, "label" => false, "class" => "select-full", "empty" => "", "placeholder" => "- Semua -", "options" => $supplierTypes, "name" => "select.Supplier.supplier_type_id", "default" => isset($this->request->query['select_Supplier_supplier_type_id']) ? $this->request->query['select_Supplier_supplier_type_id'] : ""]) ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <label><?= __("Negara") ?></label>
                        <?= $this->Form->input(null, array("default" => isset($this->request->query['select_Supplier_country_id']) ? $this->request->query['select_Supplier_country_id'] : '', "name" => "select.Supplier.country_id", "div" => false, "label" => false, "options" => $countries, "class" => "select-full state-country", "data-state-country-target" => "#SupplierStateId", "empty" => "", "placeholder" => "- Pilih Negara -")) ?>
                    </div>
                    <div class="col-md-6">
                        <label><?= __("Provinsi") ?></label>
                        <?= $this->Form->input(null, array("default" => isset($this->request->query['select_Supplier_state_id']) ? $this->request->query['select_Supplier_state_id'] : '', "name" => "select.Supplier.state_id", "div" => false, "label" => false, "id" => "SupplierStateId", "options" => $states, "class" => "select-full city-state", "data-city-state-target" => "#SupplierCityId", "empty" => "", "placeholder" => "- Pilih Provinsi -")) ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <label><?= __("Kota") ?></label>
                        <?= $this->Form->input(null, array("default" => isset($this->request->query['select_Supplier_city_id']) ? $this->request->query['select_Supplier_city_id'] : '', "name" => "select.Supplier.city_id", "div" => false, "label" => false, "id" => "SupplierCityId", "options" => $cities, "class" => "select-full city-state-target", "empty" => "", "placeholder" => "- Pilih Kota -")) ?>
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
