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
                        <label><?= __("Nama") ?></label>
                        <?= $this->Form->input(null, array("default" => isset($this->request->query['Material_name']) ? $this->request->query['Material_name'] : '', "name" => "Material.name", "div" => false, "label" => false, "class" => "form-control tip")) ?>
                    </div>
                    <div class="col-md-6">
                        <label><?= __("Kategori") ?></label>
                        <?= $this->Form->input(null, array("default" => isset($this->request->query['select_Material_material_category_id']) ? $this->request->query['select_Material_material_category_id'] : '', "name" => "select.Material.material_category_id", "options" => $materialCategories, "placeholder" => "- Semua -", "empty" => "", "div" => false, "label" => false, "class" => "select-full")) ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
<!--                    <div class="col-md-6">
                        <label><?= __("Satuan") ?></label>
                        <?= $this->Form->input(null, array("default" => isset($this->request->query['select_Unit_name']) ? $this->request->query['select_Unit_name'] : '', "name" => "select.Unit.name", "options" => $units, "placeholder" => "- Semua -", "empty" => "", "div" => false, "label" => false, "class" => "select-full")) ?>
                    </div>-->
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
