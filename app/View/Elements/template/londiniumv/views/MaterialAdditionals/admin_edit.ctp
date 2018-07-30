<?php echo $this->Form->create("MaterialAdditional", array("class" => "form-horizontal form-separate", "action" => "edit", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="tabbable page-tabs">
    <div class="tab-pane active fade in" id="data-utama">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="block-inner text-danger">
                    <h6 class="heading-hr"><?= __("Ubah Material Pembantu") ?>
                        <small class="display-block">Mohon Isikan Dengan Sesuai dan Benar</small>
                    </h6>
                </div>
                <div>
                    <div class="form-group">
                        <?php
                        echo $this->Form->label("MaterialAdditional.name", __("Nama Material Pembantu"), array("class" => "col-md-2 control-label"));
                        echo $this->Form->input("MaterialAdditional.name", array("div" => array("class" => "col-md-4"), "label" => false, "class" => "form-control"));
                        ?>
                        <?php
                        echo $this->Form->label("MaterialAdditional.material_additional_category_id", __("Tipe Material Pembantu"), array("class" => "col-md-2 control-label"));
                        echo $this->Form->input("MaterialAdditional.material_additional_category_id", array("div" => array("class" => "col-md-4"), "label" => false, "class" => "select-full", 'empty' => "", 'placeholder' => "- Pilih Kategori Material Tambahan -"));
                        ?> 
                    </div>
                    <div class="form-group">
                        <?php
                        echo $this->Form->label("MaterialAdditional.price", __("Harga Material Pembantu"), array("class" => "col-md-2 control-label"));
                        ?>
                        <div class="col-md-4">
                            <div class="input-group">
                                <span class="input-group-addon"> Rp. </span>
                                <?php
                                echo $this->Form->input("MaterialAdditional.price", array("div" => array("class" => ""), "label" => false, "class" => "form-control text-right isdecimal","type"=>"text", "value" => str_replace(".00", "", $this->data['MaterialAdditional']['price'])));
                                ?>
                                <span class="input-group-addon"> ,00. </span>
                            </div>
                        </div>
                        <?php
                        echo $this->Form->label("MaterialAdditional.size", __("Ukuran"), array("class" => "col-md-2 control-label"));
                        echo $this->Form->input("MaterialAdditional.size", array("div" => array("class" => "col-md-4"), "label" => false, "class" => "form-control"));
                        ?>
                    </div>
                    <div class="form-group">
                        <?php
                        echo $this->Form->label("MaterialAdditional.material_additional_unit_id", __("Unit Material Pembantu"), array("class" => "col-md-2 control-label"));
                        echo $this->Form->input("MaterialAdditional.material_additional_unit_id", array("div" => array("class" => "col-md-4"), "label" => false, "class" => "select-full", 'empty' => "", 'placeholder' => "- Pilih Unit Material Pembantu -"));
                        ?>
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
                <button class="btn btn-danger" data-toggle="modal" data-target="#add" type="button" href="<?php echo Router::url('/admin/popups/content?content=confirm_add', true); ?>">
                    <?= __("Simpan") ?>
                </button>
            </div>
        </div>
    </div>
</div>
<?php echo $this->Form->end() ?>