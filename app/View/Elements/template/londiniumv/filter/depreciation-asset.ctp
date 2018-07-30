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
                        <label>Durasi Penyusutan</label>
                        <?php
                        $duration = "";
                        if(!empty($this->request->query['DepreciationAsset_depreciation_duration'])) {
                            $duration = $this->request->query['DepreciationAsset_depreciation_duration'];
                        }
                        ?>
                        <div class="input-group">
                            <input type="number" class="form-control text-right" name="DepreciationAsset.depreciation_duration" value="<?= $duration ?>">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button">bulan</button>
                            </span>
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
