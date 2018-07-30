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
                        <label><?= __("Nama Asset") ?></label>
                        <?= $this->Form->input(null,array("default" => isset($this->request->query['AssetProperty_name']) ? $this->request->query['AssetProperty_name'] :'',"name"=>"AssetProperty.name","div"=>false,"label"=>false,"class"=>"form-control tip"))?>
                    </div>
                    <div class="col-md-6">
                        <label><?= __("Kas") ?></label>
                        <?= $this->Form->input(null,array("default" => isset($this->request->query['select_AssetProperty_initial_balance_id']) ? $this->request->query['select_AssetProperty_initial_balance_id'] :'',"name"=>"select.AssetProperty.initial_balance_id","div"=>false,"label"=>false,"class"=>"select-full", "empty" => "", "placeholder" => "- Semua -", "options" => $initialBalances))?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <label><?= __("Tipe Aset") ?></label>
                        <?= $this->Form->input(null,array("default" => isset($this->request->query['select_AssetProperty_asset_property_type_id']) ? $this->request->query['select_AssetProperty_asset_property_type_id'] :'',"name"=>"select.AssetProperty.asset_property_type_id","div"=>false,"label"=>false,"class"=>"select-full", "empty" => "", "placeholder" => "- Semua -", "options" => $assetPropertyTypes))?>
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
