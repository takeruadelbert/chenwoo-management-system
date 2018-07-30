<?php echo $this->Form->create("Container", array("class" => "form-horizontal form-separate", "action" => "add", "type" => "file", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="tabbable page-tabs">
    <div class="tab-pane active fade in" id="data-utama">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="block-inner text-danger">
                    <h6 class="heading-hr"><?= __("Tambah Kontainer") ?>
                    </h6>
                </div>
                <div>
                    <div class="form-group">
                        <?php
                        echo $this->Form->label("Container.number_container", __("Nomor Kontainer"), array("class" => "col-md-2 control-label"));
                        echo $this->Form->input("Container.number_container", array("div" => array("class" => "col-md-4"), "label" => false, "class" => "form-control"));
                        ?>
                    </div>
                </div>
                <div>
                    <div class="form-group">
                        <?php
                        echo $this->Form->label("Container.shield", __("Shield"), array("class" => "col-md-2 control-label"));
                        echo $this->Form->input("Container.shield", array("div" => array("class" => "col-md-4"), "label" => false, "class" => "form-control"));
                        ?>
                    </div>
                </div>
                <div>
                    <div class="form-group">
                        <?php
                        echo $this->Form->label("Container.driver", __("Pengemudi"), array("class" => "col-md-2 control-label"));
                        echo $this->Form->input("Container.driver", array("div" => array("class" => "col-md-4"), "label" => false, "class" => "form-control"));
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