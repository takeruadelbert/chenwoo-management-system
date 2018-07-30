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
                        <label><?= __("Kategori") ?></label>
                        <?= $this->Form->input(null, array("options" => $materialAdditionalCategories, "default" => isset($this->request->query['select_ProductMaterialAdditional_material_additional_category_id']) ? $this->request->query['select_ProductMaterialAdditional_material_additional_category_id'] : '', "name" => "select.ProductMaterialAdditional.material_additional_category_id", "div" => false, "label" => false, "class" => "select-full tip", "empty" => "", "placeholder" => "- Semua -")) ?>
                    </div>
                    <div class="col-md-6">
                        <label><?= __("Produk") ?></label>
                        <?= $this->Form->input(null, array("options" => $products, "default" => isset($this->request->query['select_ProductMaterialAdditional_product_id']) ? $this->request->query['select_ProductMaterialAdditional_product_id'] : '', "name" => "select.ProductMaterialAdditional.product_id", "div" => false, "label" => false, "class" => "select-full tip", "empty" => "", "placeholder" => "- Semua -")) ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <label><?= __("Material Pembantu") ?></label>
                        <?= $this->Form->input(null, array("options" => $materialAdditionals, "default" => isset($this->request->query['select_ProductMaterialAdditional_material_additional_id']) ? $this->request->query['select_ProductMaterialAdditional_material_additional_id'] : '', "name" => "select.ProductMaterialAdditional.material_additional_id", "div" => false, "label" => false, "class" => "select-full tip", "empty" => "", "placeholder" => "- Semua -")) ?>
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
