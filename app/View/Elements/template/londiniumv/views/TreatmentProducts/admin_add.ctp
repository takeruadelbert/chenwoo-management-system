<?php echo $this->Form->create("TreatmentProduct", array("class" => "form-horizontal form-separate", "action" => "add", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="tab-pane active fade in" id="data-utama">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="block-inner text-danger">
                <h6 class="heading-hr"><?= __("Tambah Produk Treatment") ?>
                </h6>
            </div>
            <div class="form-group">
                <div class = "row">
                    <div class = "col-md-6">
                        <?php
                        echo $this->Form->label("TreatmentProduct.name", __("Nama Produk"), array("class" => "col-sm-3 col-md-4 control-label"));
                        echo $this->Form->input("TreatmentProduct.name", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control"));
                        ?>
                    </div>
                    <div class = "col-md-6">
                        <?php
                        echo $this->Form->label("TreatmentProduct.code", __("Kode Produk"), array("class" => "col-sm-3 col-md-4 control-label"));
                        echo $this->Form->input("TreatmentProduct.code", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control"));
                        ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class = "row">
                    <div class = "col-md-6">
                        <div class="col-sm-3 col-md-4 control-label label-required">
                            <label>Harga</label>
                        </div>
                        <div class="col-sm-9 col-md-8">
                            <div class="input-group">
                                <span class="input-group-addon"><strong>$</strong></span>
                                <input type="text" class="form-control text-right isdecimal" name="data[TreatmentProduct][price]">
                            </div>
                        </div>
                    </div>
                    <div class = "col-md-6">
                        <?php
                        echo $this->Form->label("TreatmentProduct.product_unit_id", __("Satuan Unit Produk"), array("class" => "col-sm-3 col-md-4 control-label"));
                        echo $this->Form->input("TreatmentProduct.product_unit_id", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "select-full", "empty" => "- Pilih Unit Produk -"));
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
