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
                        <label><?= __("Nama Perusahaan") ?></label>
                        <?= $this->Form->input(null, array("default" => isset($this->request->query['Buyer_company_name']) ? $this->request->query['Buyer_company_name'] : '', "name" => "Buyer.company_name", "div" => false, "label" => false, "class" => "form-control tip")) ?>
                    </div>
                    <div class="col-md-6">
                        <label><?= __("Kode Perusahaan") ?></label>
                        <?= $this->Form->input(null, array("default" => isset($this->request->query['Buyer_company_uniq_name']) ? $this->request->query['Buyer_company_uniq_name'] : '', "name" => "Buyer.company_uniq_name", "div" => false, "label" => false, "class" => "form-control tip")) ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <label><?= __("Negara") ?></label>
                        <?= $this->Form->input(null, array("default" => isset($this->request->query['select_Buyer_country_id']) ? $this->request->query['select_Buyer_country_id'] : '', "name" => "select.Buyer.country_id", "div" => false, "label" => false, "options" => $countries, "class" => "select-full state-country", "data-state-country-target" => "#BuyerStateId", "empty" => "", "placeholder" => "- Semua -")) ?>
                    </div>
                    <div class="col-md-6">
                        <label><?= __("Provinsi") ?></label>
                        <?= $this->Form->input(null, array("default" => isset($this->request->query['select_Buyer_state_id']) ? $this->request->query['select_Buyer_state_id'] : '', "name" => "select.Buyer.state_id", "div" => false, "label" => false, "id" => "BuyerStateId", "options" => $states, "class" => "select-full city-state state-country-target", "data-city-state-target" => "#BuyerCityId", "empty" => "", "placeholder" => "- Semua -")) ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <label><?= __("Kota") ?></label>
                        <?= $this->Form->input(null, array("default" => isset($this->request->query['select_Buyer_city_id']) ? $this->request->query['select_Buyer_city_id'] : '', "name" => "select.Buyer.city_id", "div" => false, "label" => false, "id" => "BuyerCityId", "options" => $cities, "class" => "select-full city-state-target", "empty" => "", "placeholder" => "- Semua -")) ?>
                    </div>
                    <div class="col-md-6">
                        <label><?= __("Tipe Pembeli") ?></label>
                        <?= $this->Form->input(null, array("default" => isset($this->request->query['select_Buyer_buyer_type_id']) ? $this->request->query['select_Buyer_buyer_type_id'] : '', "name" => "select.Buyer.buyer_type_id", "div" => false, "label" => false, "options" => $buyerTypes, "class" => "select-full", "empty" => "", "placeholder" => "- Semua -")) ?>
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
