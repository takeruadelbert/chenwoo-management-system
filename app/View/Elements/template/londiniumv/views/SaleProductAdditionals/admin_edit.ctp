<?php echo $this->Form->create("ProdukCategory", array("class" => "form-horizontal form-separate", "action" => "edit", "type" => "file", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="tabbable page-tabs">
    <div class="tab-pane active fade in" id="data-utama">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="block-inner text-danger">
                    <h6 class="heading-hr"><?= __("Ubah Kategori Material") ?>
                        <small class="display-block">Mohon Isikan Dengan Sesuai dan Benar</small>
                    </h6>
                </div>
                <div>
                    <div class="form-group">
                        <?php
                        echo $this->Form->label("ProductAdditional.name", __("Nama Produk Tambahan"), array("class" => "col-md-2 control-label"));
                        echo $this->Form->input("ProductAdditional.name", array("div" => array("class" => "col-md-4"), "label" => false, "class" => "form-control"));
                        ?>
                        <div class="col-sm-2 control-label">
                            <label>Harga (Per Kg)</label>
                        </div>
                        <div class="col-sm-4">
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button">Rp.</button>
                                </span>
                                <input type="text" class="form-control text-right isdecimal" name="data[ProductAdditional][price]" value="<?= $this->data['ProductAdditional']['price'] ?>">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button">,00.</button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-2 control-label">
                        <label>Default Harga Untuk Koperasi</label>
                    </div>
                    <div class="col-sm-4">
                        <div class="input-group">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button">Rp.</button>
                            </span>
                            <input type="text" class="form-control text-right isdecimal" name="data[ProductAdditional][default_price]" value="<?= $this->data['ProductAdditional']['default_price'] ?>">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button">,00.</button>
                            </span>
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
                <button class="btn btn-danger" data-toggle="modal" data-target="#edit" type="button" href="<?php echo Router::url('/admin/popups/content?content=confirm_edit', true); ?>">
                    <?= __("Simpan") ?>
                </button>
            </div>
        </div>
    </div>
</div>
<?php echo $this->Form->end() ?>