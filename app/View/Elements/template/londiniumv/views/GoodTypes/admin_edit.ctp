<?php echo $this->Form->create("GoodType", array("class" => "form-horizontal form-separate", "action" => "edit", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="block-inner text-danger">
                    <h6 class="heading-hr"><?= __("Ubah Kategori Barang") ?>
                        <small class="display-block">Mohon Isikan Dengan Sesuai dan Benar</small>
                    </h6>
                </div>
                <div class="table-responsive">
                    <table width="100%" class="table">
                        <div class="panel-heading" style="background:#2179cc">
                            <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Data Kategori Barang") ?></h6>
                        </div>
                        <tr>
                            <td colspan="3" style="width:200px">
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <?php
                                        echo $this->Form->label("GoodType.name", __("Nama Barang"), array("class" => "col-sm-3 col-md-4 control-label"));
                                        echo $this->Form->input("GoodType.name", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control"));
                                        ?>
                                    </div>
                                    <div class="col-md-6">
                                        <?php
                                        echo $this->Form->label("GoodType.parent_id", __("Kategori"), array("class" => "col-sm-3 col-md-4 control-label"));
                                        echo $this->Form->input("GoodType.parent_id", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "select-full", "empty" => "", "placeholder" => "- Pilih -"));
                                        ?>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" style="width:200px">
                                <div class="form-group">
                                    <?php
                                    echo $this->Form->label("GoodType.note", __("Keterangan"), array("class" => "col-sm-2 control-label"));
                                    echo $this->Form->input("GoodType.note", array("div" => array("class" => "col-sm-10"), "label" => false, "class" => "ckeditor-fix", "placeholder" => "Silhkan diisi jika ada ..."));
                                    ?>
                                </div>
                            </td>
                        </tr>
                    </table>
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
    </div>
</div>
<?php echo $this->Form->end() ?>