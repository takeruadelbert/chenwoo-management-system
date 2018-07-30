<?php echo $this->Form->create("CooperativeEntryType", array("class" => "form-horizontal form-separate", "action" => "add", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="block-inner text-danger">
                    <h6 class="heading-hr"><?= __("Tambah Jenis Transaksi") ?>
                        <small class="display-block">Mohon Isikan Dengan Sesuai dan Benar</small>
                    </h6>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <?php
                            echo $this->Form->label("CooperativeEntryType.code", __("Kode"), array("class" => "col-sm-4 control-label"));
                            echo $this->Form->input("CooperativeEntryType.code", array("div" => array("class" => "col-sm-8"), "label" => false, "class" => "form-control"));
                            ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <?php
                            echo $this->Form->label("CooperativeEntryType.name", __("Nama"), array("class" => "col-sm-4 control-label"));
                            echo $this->Form->input("CooperativeEntryType.name", array("div" => array("class" => "col-sm-8"), "label" => false, "class" => "form-control"));
                            ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <?php
                            echo $this->Form->label("CooperativeEntryType.category", __("Kategori"), array("class" => "col-sm-4 control-label"));
                            echo $this->Form->input("CooperativeEntryType.category", array("div" => array("class" => "col-sm-8"), "label" => false, "class" => "select-full", "options" => $transactionCategories));
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
    </div>
</div>
<?php echo $this->Form->end() ?>