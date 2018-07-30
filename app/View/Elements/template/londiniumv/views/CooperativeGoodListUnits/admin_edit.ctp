<?php echo $this->Form->create("CooperativeGoodListUnit", array("class" => "form-horizontal form-separate", "action" => "edit", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="block-inner text-danger">
                    <h6 class="heading-hr"><?= __("Ubah Satuan Barang Koperasi") ?>
                        <small class="display-block">Mohon Isikan Dengan Sesuai dan Benar</small>
                    </h6>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                            <?php
                            echo $this->Form->label("CooperativeGoodListUnit.name", __("Nama Satuan"), array("class" => "col-sm-3 col-md-4 control-label"));
                            echo $this->Form->input("CooperativeGoodListUnit.name", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control"));
                            ?>
                        </div>
                    </div>
                </div>
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
</div>
<?php echo $this->Form->end() ?>