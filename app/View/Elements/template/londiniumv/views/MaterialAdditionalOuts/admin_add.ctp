<?php echo $this->Form->create("MaterialAdditionalOut", array("class" => "form-horizontal form-separate", "action" => "add", "type" => "file", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="tabbable page-tabs">
    <div class="tab-pane active fade in" id="data-utama">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="block-inner text-danger">
                    <h6 class="heading-hr"><?= __("Tambah Pemakaian Material Pembantu") ?>
                        <small class="display-block">Mohon Isikan Dengan Sesuai dan Benar</small>
                    </h6>
                </div>
                <div>
                    <div class = "row">
                        <div class = "col-md-6">
                            <div class="form-group">
                                <?php
                                echo $this->Form->label("MaterialAdditionalOut.material_additional_id", __("Material Pembantu"), array("class" => "col-md-4 control-label"));
                                echo $this->Form->input("MaterialAdditionalOut.material_additional_id", array("div" => array("class" => "col-md-8"), "empty" => "", "placeholder" => "- Pilih Material Pembantu -", "label" => false, "class" => "select-full"));
                                ?>
                            </div>
                        </div>
                        <div class = "col-md-6">
                            <div class="form-group">
                                <?php
                                echo $this->Form->label("MaterialAdditionalOut.quantity", __("Jumlah Penggunaan Material Pembantu"), array("class" => "col-md-4 control-label"));
                                echo $this->Form->input("MaterialAdditionalOut.quantity", array("div" => array("class" => "col-md-8"), "empty" => "", "label" => false, "class" => "form-control isdecimaldollar", "type" => "text"));
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class = "row">
                        <div class = "col-md-6">
                            <div class="form-group">
                                <?php
                                echo $this->Form->label("MaterialAdditionalOut.use_dt", __("Tanggal Penggunaan"), array("class" => "col-md-4 control-label"));
                                echo $this->Form->input("MaterialAdditionalOut.use_dt", array("type" => "text", "div" => array("class" => "col-md-8"), "label" => false, "class" => "form-control datepicker"));
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
                <button class="btn btn-danger submitButton" data-toggle="modal" data-target="#add" type="button" href="<?php echo Router::url('/admin/popups/content?content=confirm_add', true); ?>">
                    <?= __("Simpan") ?>
                </button>
            </div>
        </div>
    </div>
</div>
<?php echo $this->Form->end() ?>