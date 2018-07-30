<?php echo $this->Form->create("AssetProperty", array("class" => "form-horizontal form-separate", "action" => "buy_new_asset", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="tabbable page-tabs">
    <div class="tab-pane active fade in" id="data-utama">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="block-inner text-danger">
                    <h6 class="heading-hr"><?= __("Tambah Asset") ?>
                        <small class="display-block">Mohon Isikan Dengan Sesuai dan Benar</small>
                    </h6>
                </div>
                <div>
                    <div class="form-group">
                        <?php
                        echo $this->Form->label("AssetProperty.name", __("Nama Asset"), array("class" => "col-md-2 control-label"));
                        echo $this->Form->input("AssetProperty.name", array("div" => array("class" => "col-md-4"), "label" => false, "class" => "form-control"));
                        ?>
                        <div class="col-md-2 control-label">
                            <label>Nominal</label>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <button class="btn btn-default rupiah" type="button">Rp.</button>
                                </span>
                                <input type="text" label="false" class="form-control text-right isdecimal" name="data[AssetProperty][nominal]">
                                <span class="input-group-btn">
                                    <button class="btn btn-default rupiah" type="button">,00.</button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <?php
                    echo $this->Form->label("AssetProperty.initial_balance_id", __("Kas"), array("class" => "col-md-2 control-label"));
                    echo $this->Form->input("AssetProperty.initial_balance_id", array("div" => array("class" => "col-md-4"), "label" => false, "class" => "select-full", "empty" => "", "placeholder" => "- Pilih Kas -"));
                    ?>
                    <?php
                    echo $this->Form->label("AssetProperty.asset_property_type_id", __("Tipe Aset"), array("class" => "col-md-2 control-label"));
                    echo $this->Form->input("AssetProperty.asset_property_type_id", array("div" => array("class" => "col-md-4"), "label" => false, "class" => "select-full", "empty" => "", "placeholder" => "- Pilih Tipe Aset -"));
                    ?>
                </div>
                <div class="form-group">
                    <?php
                    echo $this->Form->label("AssetProperty.general_entry_type_id", __("COA Aset"), array("class" => "col-md-2 control-label"));
                    echo $this->Form->input("AssetProperty.general_entry_type_id", array("div" => array("class" => "col-md-4"), "label" => false, "class" => "select-full","empty" => "", "placeholder" => "- Pilih COA - "));
                    ?>
                    <?php
                    echo $this->Form->label("AssetProperty.date", __("Tanggal"), array("class" => "col-md-2 control-label"));
                    echo $this->Form->input("AssetProperty.date", array("type" => "text", "div" => array("class" => "col-md-4"), "label" => false, "class" => "form-control datepicker"));
                    ?>
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