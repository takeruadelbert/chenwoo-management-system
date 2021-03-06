<?php echo $this->Form->create("CooperativeContributionFee", array("class" => "form-horizontal form-separate", "action" => "edit", "type" => "file", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="tabbable page-tabs">
    <div class="tab-pane active fade in" id="data-utama">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="block-inner text-danger">
                    <h6 class="heading-hr"><?= __("Ubah Biaya Iuran") ?>
                        <small class="display-block">Mohon Isikan Dengan Sesuai dan Benar</small>
                    </h6>
                </div>
                <div>
                    <div class="form-group">
                        <?php
                        echo $this->Form->label("CooperativeContributionFee.cooperative_contribution_type_id", __("Jenis Iuran"), array("class" => "col-md-2 control-label"));
                        echo $this->Form->input("CooperativeContributionFee.cooperative_contribution_type_id", array("div" => array("class" => "col-md-4"), "label" => false, "class" => "select-full", "empty" => "", "placeholder" => "-Pilih Jenis Iuran-"));
                        ?>
                        <?php
                        echo $this->Form->label("CooperativeContributionFee.employee_type_id", __("Jenis Pegawai"), array("class" => "col-md-2 control-label"));
                        echo $this->Form->input("CooperativeContributionFee.employee_type_id", array("div" => array("class" => "col-md-4"), "label" => false, "class" => "select-full", "empty" => "", "placeholder" => "-Pilih Jenis Pegawai-"));
                        ?>
                    </div>
                </div>
                <div>
                    <div class="form-group">
                        <?php
                        echo $this->Form->label("CooperativeContributionFee.amount", __("Jumlah Iuran"), array("class" => "col-md-2 control-label"));
                        echo $this->Form->input("CooperativeContributionFee.amount", array("div" => array("class" => "col-md-4"), "label" => false, "class" => "form-control"));
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