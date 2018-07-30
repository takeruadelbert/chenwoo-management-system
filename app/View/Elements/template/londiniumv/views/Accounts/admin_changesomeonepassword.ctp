<?php echo $this->Form->create("Account", array("class" => "form-horizontal form-separate", "action" => "changesomeonepassword", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("Ganti Kata Sandi Pengguna") ?>
            </h6>
        </div>
        <div class="table-responsive">
            <table width="100%" class="table">
                <tr>
                    <td colspan="3" style="width:200px">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php
                                    echo $this->Form->label("User.username", __("Username"), array("class" => "col-sm-3 col-md-4 control-label"));
                                    echo $this->Form->input("User.username", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled"));
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php
                                    echo $this->Form->label("User.email", __("Email"), array("class" => "col-sm-3 col-md-4 control-label"));
                                    echo $this->Form->input("User.email", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled"));
                                    ?>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" style="width:200px">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php
                                    echo $this->Form->label("User.password", __("Kata Sandi Baru"), array("class" => "col-sm-3 col-md-4 control-label"));
                                    echo $this->Form->input("User.password", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control","value"=>""));
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php
                                    echo $this->Form->label("User.repeat_password", __("Ulangi Kata Sandi Baru"), array("class" => "col-sm-3 col-md-4 control-label"));
                                    echo $this->Form->input("User.repeat_password", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control","value"=>"","type"=>"password"));
                                    ?>
                                </div>
                            </div>
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
                <input type="submit" value="<?= __("Simpan") ?>" class="btn btn-danger">
            </div>
        </div>
    </div>
</div>
<?php echo $this->Form->end() ?>