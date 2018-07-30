<?php echo $this->Form->create("Product", array("class" => "form-horizontal form-separate", "action" => "edit", "type" => "file", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="tab-pane active fade in" id="data-utama">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="block-inner text-danger">
                <h6 class="heading-hr"><?= __("Ubah Produk") ?>
                </h6>
            </div>
            <div class="form-group">
                <?php
                echo $this->Form->label("ProductSize.name", __("Nama"), array("class" => "col-md-3 control-label"));
                echo $this->Form->input("ProductSize.name", array("div" => array("class" => "col-md-3"), "label" => false, "class" => "form-control"));
                echo $this->Form->input("ProductSize.id", array("div" => array("class" => "col-md-9"), "type"=> "hidden","label" => false, "class" => "form-control"));
                ?>
                <?php
                echo $this->Form->label("ProductSize.product_unit_id", __("Satuan"), array("class" => "col-md-3 control-label"));
                echo $this->Form->input("ProductSize.product_unit_id", array("div" => array("class" => "col-md-3"), "label" => false, "class" => "form-control","empty"=>"- Pilih Satuan -"));
                ?>
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
                <input type="submit" value="<?= __("Simpan") ?>" class="btn btn-danger">
            </div>
        </div>
    </div>
</div>
<?php echo $this->Form->end() ?>