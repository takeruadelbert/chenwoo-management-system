<?php echo $this->Form->create("BuyerType", array("class" => "form-horizontal form-separate", "action" => "edit", "type" => "file", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="tabbable page-tabs">
    <div class="tab-pane active fade in" id="data-utama">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="block-inner text-danger">
                    <h6 class="heading-hr"><?= __("Ubah Tipe Pembeli") ?>
                        <small class="display-block">Mohon Isikan Dengan Sesuai dan Benar</small>
                    </h6>
                </div>
                <div>
                    <div class="form-group">
                        <?php
                        echo $this->Form->label("BuyerType.name", __("Nama Tipe Pembeli"), array("class" => "col-md-2 control-label"));
                        echo $this->Form->input("BuyerType.name", array("div" => array("class" => "col-md-4"), "label" => false, "class" => "form-control"));
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
                <button class="btn btn-danger" data-toggle="modal" data-target="#edit" type="button" href="<?php echo Router::url('/admin/popups/content?content=confirm_edit', true); ?>">
                    <?= __("Simpan") ?>
                </button>
            </div>
        </div>
    </div>
</div>
<?php echo $this->Form->end() ?>