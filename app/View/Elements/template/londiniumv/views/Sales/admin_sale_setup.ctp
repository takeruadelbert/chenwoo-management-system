<?php echo $this->Form->create("Sale", array("class" => "form-horizontal form-separate", "action" => "sale_setup", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("PILIH TIPE PEMBELI") ?>
                <small class="display-block"><?= _APP_CORPORATE_FULL ?></small>
            </h6>
        </div>
        <div class = "col-md-12">
            <div class = "col-md-3">
            </div>
            <div class = "col-md-6">
                <div class="form-group">
                    <?php
                    echo $this->Form->label("Buyer.buyer_type_id", __("Tipe Pembeli"), array("class" => "col-md-4 control-label"));
                    echo $this->Form->input("Buyer.buyer_type_id", array("div" => array("class" => "col-md-8"), "label" => false, "class" => "select-full", "empty" => "", "placeholder" => "- Pilih Tipe Pembeli -", "options" => $buyerTypes));
                    ?>
                </div>
            </div>
            <div class = "col-md-3">
            </div>
        </div>
        <br/>
        <div class="form-actions text-center">
            <input name="Button" type="button" onclick="history.go(-1);" class="btn btn-success" value="<?= __("Kembali") ?>">
            <input type="submit" value="<?= __("Lanjut") ?>" class="btn btn-danger">
        </div>
    </div>
</div>

<?php echo $this->Form->end() ?>

