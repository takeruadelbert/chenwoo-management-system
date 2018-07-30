<?php echo $this->Form->create("ProductMaterialAdditional", array("class" => "form-horizontal form-separate", "action" => "add", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="tabbable page-tabs">
    <div class="tab-pane active fade in" id="data-utama">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="block-inner text-danger">
                    <h6 class="heading-hr"><?= __("Tambah Paremeter Pemakaian Material Pembantu (Plastik)") ?>
                        <small class="display-block">Mohon Isikan Dengan Sesuai dan Benar</small>
                    </h6>
                </div>
                <div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <?php
                                echo $this->Form->label("ProductMaterialAdditional.product_id", __("Produk"), array("class" => "col-md-4 control-label"));
                                echo $this->Form->input("ProductMaterialAdditional.product_id", array("div" => array("class" => "col-md-8"), "label" => false, "class" => "select-full", 'empty' => "", 'placeholder' => "- Pilih Produk -"));
                                echo $this->Form->hidden("ProductMaterialAdditional.material_additional_category_id", ["value" => 2]);
                                ?> 
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <?php
                                echo $this->Form->label("ProductMaterialAdditional.material_additional_id", __("Material Pembantu"), array("class" => "col-md-4 control-label"));
                                echo $this->Form->input("ProductMaterialAdditional.material_additional_id", array("options" => $plastikMaterialAdditionals, "div" => array("class" => "col-md-8"), "label" => false, "class" => "select-full", 'empty' => "", 'placeholder' => "- Pilih Material Pembantu -"));
                                ?> 
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <?php
                                echo $this->Form->label("ProductMaterialAdditional.quantity", __("Jumlah Pemakaian"), array("class" => "col-md-4 control-label"));
                                echo $this->Form->input("ProductMaterialAdditional.quantity", array("div" => array("class" => "col-md-8"), "label" => false, "class" => "form-control quantity", 'placeholder' => "Rata-rata pemakaian per kilo"));
                                ?> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <div class="form-actions text-center">
                <input name="Button" type="button" onclick="history.go(-1);" class="btn btn-success" value="<?= __("Kembali") ?>">
                <input type="reset" value="Reset" class="btn btn-info">
                <button class="btn btn-danger buttonSubmit" data-toggle="modal" data-target="#add" type="button" href="<?php echo Router::url('/admin/popups/content?content=confirm_add', true); ?>">
                    <?= __("Simpan") ?>
                </button>
            </div>
        </div>
    </div>
</div>
<?php echo $this->Form->end() ?>
<script>
    $(document).ready(function () {
        $(".quantity").on("keyup", function () {
            var quantity = $(this).val();
            if (parseFloat(quantity) < 0) {
                notif("warning", "Jumlah Pemakaiaan Tidak Boleh Minus", "growl");
                $('.buttonSubmit').removeAttr("data-toggle", "modal");
                return false;
            } else {
                $('.buttonSubmit').attr("data-toggle", "modal");
                return true;
            }
        });
    });
</script>