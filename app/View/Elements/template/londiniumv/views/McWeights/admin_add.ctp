<?php echo $this->Form->create("McWeight", array("class" => "form-horizontal form-separate", "action" => "add", "type" => "file", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="tabbable page-tabs">
    <div class="tab-pane active fade in" id="data-utama">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="block-inner text-danger">
                    <h6 class="heading-hr"><?= __("Tambah Berat Per MC") ?>
                        <small class="display-block">Mohon Isikan Dengan Sesuai dan Benar</small>
                    </h6>
                </div>
                <div>
                    <div class="form-group">
                        <?php
                        echo $this->Form->label("McWeight.lbs", __("LBS"), array("class" => "col-md-2 control-label"));
                        ?>
                        <div class="col-sm-4 col-md-4">
                            <div class="input-group">
                                <input type="text" class="form-control text-right" id="lbs" name="data[McWeight][lbs]">
                                <span class="input-group-addon"><strong>lbs</strong></span>
                            </div>
                        </div>
                        <?php
                        echo $this->Form->label("McWeight.kg", __("KG"), array("class" => "col-md-2 control-label"));
                        ?>
                        <div class="col-sm-4 col-md-4">
                            <div class="input-group">
                                <input type="text" class="form-control text-right" id="kg" name="data[McWeight][kg]">
                                <span class="input-group-addon"><strong>kg</strong></span>
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
                <button class="btn btn-danger" data-toggle="modal" data-target="#add" type="button" href="<?php echo Router::url('/admin/popups/content?content=confirm_add', true); ?>">
                    <?= __("Simpan") ?>
                </button>
            </div>
        </div>
    </div>
</div>
<?php echo $this->Form->end() ?>