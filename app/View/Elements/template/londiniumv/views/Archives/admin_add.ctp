<?php echo $this->Form->create("Archive", array("class" => "form-horizontal form-separate", "type" => "file", "action" => "add", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="block-inner text-danger">
                    <h6 class="heading-hr"><?= __("Tambah Arsip") ?>
                    </h6>
                </div>

                <div class="table-responsive">
                    <table width="100%" class="table">
                        <div class="panel-heading" style="background:#2179cc">
                            <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Data Arsip") ?></h6>
                        </div>
                        <tr>
                            <td>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <?php
                                            echo $this->Form->label("Archive.name", __("Nama Dokumen"), array("class" => "col-sm-3 col-md-4 control-label"));
                                            echo $this->Form->input("Archive.name", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control"));
                                            ?>
                                        </div>
                                        <div class="col-md-6">
                                            <?php
                                            echo $this->Form->label("Archive.document_type_id", __("Tipe Dokumen"), array("class" => "col-sm-3 col-md-4 control-label"));
                                            echo $this->Form->input("Archive.document_type_id", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "select-full", "empty" => "", "placeholder" => "- Pilih Tipe Dokumen -"));
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <?php
                                            echo $this->Form->label("Archive.archive_slot_id", __("Rak Penyimpanan"), array("class" => "col-sm-3 col-md-4 control-label"));
                                            echo $this->Form->input("Archive.archive_slot_id", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "select-full", "empty" => "", "placeholder" => "- Pilih Rak Penyimpanan -"));
                                            ?>
                                        </div>
                                        <div class="col-md-6">
                                            <?php
                                            echo $this->Form->label("Archive.file", __("File"), array("class" => "col-sm-3 col-md-4 control-label"));
                                            echo $this->Form->input("Archive.file", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "type" => "file"));
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
<!--                        <tr>
                            <td>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <?php
                                            echo $this->Form->label("Dummy.department_id", __("Bagikan kepada"), array("class" => "col-sm-3 col-md-4 control-label"));
                                            echo $this->Form->input("Dummy.department_id", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "multi-select-all", "multiple" => "multiple", "tabindex" => "2"));
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>-->
                        <tr>
                            <td>
                                <div class="form-actions text-center">
                                    <input name="Button" type="button" onclick="history.go(-1);" class="btn btn-success" value="<?= __("Kembali") ?>">
                                    <input type="reset" value="Reset" class="btn btn-info">
                                    <button class="btn btn-danger" data-toggle="modal" data-target="#add" type="button" href="<?php echo Router::url('/admin/popups/content?content=confirm_add', true); ?>">
                                        <?= __("Simpan") ?>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
<?php echo $this->Form->end() ?>
