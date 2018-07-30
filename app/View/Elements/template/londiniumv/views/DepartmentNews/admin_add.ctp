<?php echo $this->Form->create("DepartmentNews", array("class" => "form-horizontal form-separate", "action" => "add", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="block-inner text-danger">
                    <h6 class="heading-hr"><?= __("Tambah Berita Departemen") ?>
                    </h6>
                </div>
                <div class="table-responsive">
                    <table width="100%" class="table">
                        <div class="panel-heading" style="background:#2179cc">
                            <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Data Berita Departemen") ?></h6>
                        </div>
                        <tr>
                            <td colspan="3" style="width:200px">
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <?php
                                        echo $this->Form->label("DepartmentNews.title", __("Judul"), array("class" => "col-sm-3 col-md-4 control-label"));
                                        echo $this->Form->input("DepartmentNews.title", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control"));
                                        echo $this->Form->input("DepartmentNews.employee_id", ["type" => "hidden", "value" => $this->Session->read("credential.admin.Employee.id")]);
                                        ?>
                                    </div>
                                    <div class="col-md-6">
                                        <?php
                                        echo $this->Form->label("DepartmentNews.department_id", __("Departemen Tujuan"), array("class" => "col-sm-3 col-md-4 control-label"));
                                        echo $this->Form->input("DepartmentNews.department_id", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "select-full", "empty" => "", "placeholder" => "- Pilih Departemen -"));
                                        ?>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" style="width:200px">
                                <div class="form-group">
                                    <?php
                                    echo $this->Form->label("DepartmentNews.synopsis", __("Sinopsis"), array("class" => "col-sm-3 col-md-4 control-label"));
                                    echo $this->Form->input("DepartmentNews.synopsis", array("div" => array("class" => "col-sm-12 col-md-12"), "label" => false, "class" => "ckeditor-fix"));
                                    ?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" style="width:200px">
                                <div class="form-group">
                                    <?php
                                    echo $this->Form->label("DepartmentNews.content", __("Konten"), array("class" => "col-sm-3 col-md-4 control-label"));
                                    echo $this->Form->input("DepartmentNews.content", array("div" => array("class" => "col-sm-12 col-md-12"), "label" => false, "class" => "ckeditor-fix"));
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
                        <button class="btn btn-danger" data-toggle="modal" data-target="#add" type="button" href="<?php echo Router::url('/admin/popups/content?content=confirm_add', true); ?>">
                            <?= __("Simpan") ?>
                        </button>&nbsp;
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo $this->Form->end() ?>