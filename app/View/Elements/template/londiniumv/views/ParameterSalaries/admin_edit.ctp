<?php echo $this->Form->create("ParameterSalary", array("class" => "form-horizontal form-separate", "action" => "edit", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("UBAH DATA PARAMETER GAJI") ?>
                <small class="display-block">Mohon Isikan Dengan Sesuai dan Benar</small>
            </h6>
        </div>
        <div class="table-responsive">
            <table width="100%" class="table table-hover">
                <tbody>
                    <tr>
                        <td colspan="3" style="width:200px">
                            <div class="form-group">
                                <?php
                                echo $this->Form->label("ParameterSalary.name", __("Nama"), array("class" => "col-sm-2 control-label"));
                                echo $this->Form->input("ParameterSalary.name", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control"));
                                ?>
                                <?php
                                echo $this->Form->label("ParameterSalary.parameter_salary_type_id", __("Jenis Parameter Gaji"), array("class" => "col-sm-2 control-label"));
                                echo $this->Form->input("ParameterSalary.parameter_salary_type_id", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "select-full ParameterSalaryParameterSalaryTypeId", "data-placeholder" => "- Jenis Parameter Gaji -", "empty" => "", "tabindex" => "2"));
                                ?>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" style="width:200px">
                            <div class="form-group">
                                <?php
                                echo $this->Form->label("ParameterSalary.code", __("Kode"), array("class" => "col-sm-2 control-label"));
                                echo $this->Form->input("ParameterSalary.code", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control"));
                                ?>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" style="width:200px">
                            <div class="form-group">
                                <?php
                                echo $this->Form->label("ParameterSalary.note", __("Keterangan"), array("class" => "col-sm-2 control-label"));
                                echo $this->Form->input("ParameterSalary.note", array("div" => array("class" => "col-sm-10"), "label" => false, "class" => "ckeditor-fix", "placeholder" => "Enter text ...", "before" => "<div class = 'block-inner'>", "after" => "</div>"));
                                ?>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" style="width:200px">
                            <div class="form-actions text-center">
                                <input name="Button" type="button" onclick="history.go(-1);" class="btn btn-success" value="<?= __("Kembali") ?>">
                                <input type="reset" value="Reset" class="btn btn-info">
                                <button class="btn btn-danger" data-toggle="modal" data-target="#edit" type="button" href="<?php echo Router::url('/admin/popups/content?content=confirm_edit', true); ?>">
                                    <?= __("Simpan") ?>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php echo $this->Form->end() ?>