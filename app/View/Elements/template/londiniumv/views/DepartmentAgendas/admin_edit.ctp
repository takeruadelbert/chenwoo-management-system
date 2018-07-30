<?php echo $this->Form->create("DepartmentAgenda", array("class" => "form-horizontal form-separate", "action" => "edit", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("Ubah Data Agenda Departemen") ?>
            </h6>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="table-responsive">
                    <table width="100%" class="table">
                        <div class="panel-heading" style="background:#2179cc">
                            <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Data Agenda") ?></h6>
                        </div>
                        <tr>
                            <td colspan="3" style="width:200px">
                                <div class="form-group">
                                    <?php
                                    echo $this->Form->label("DepartmentAgenda.title", __("Judul Agenda"), array("class" => "col-sm-3 col-md-4 control-label"));
                                    echo $this->Form->input("DepartmentAgenda.title", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control"));
                                    echo $this->Form->input("DepartmentAgenda.id", array("type" => "hidden", "class" => "form-control"));
                                    ?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" style="width:200px">
                                <div class="form-group">
                                    <?php
                                    echo $this->Form->label("DepartmentAgenda.description", __("Deskripsi Agenda"), array("class" => "col-sm-3 col-md-4 control-label"));
                                    echo $this->Form->input("DepartmentAgenda.description", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control"));
                                    ?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" style="width:200px">
                                <div class="form-group">
                                    <?php
                                    echo $this->Form->label("DepartmentAgenda.department_id", __("Nama Departemen"), array("class" => "col-sm-3 col-md-4 control-label"));
                                    echo $this->Form->input("DepartmentAgenda.department_id", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "empty" => "-- Pilih Departemen --"));
                                    ?>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="col-md-6">
                <div class="table-responsive">
                    <table width="100%" class="table">
                        <div class="panel-heading" style="background:#2179cc">
                            <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Detail Waktu Agenda") ?></h6>
                        </div>
                        <tr>
                            <td colspan="3" style="width:200px">
                                <div class="form-group">
                                    <?php
                                    echo $this->Form->label("DepartmentAgenda.start", __("Waktu Mulai"), array("class" => "col-sm-3 col-md-4 control-label"));
                                    echo $this->Form->input("DepartmentAgenda.start", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control datetime", "type" => "text", "id" => "start"));
                                    ?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" style="width:200px">
                                <div class="form-group">
                                    <?php
                                    echo $this->Form->label("DepartmentAgenda.end", __("Waktu Selesai"), array("class" => "col-sm-3 col-md-4 control-label"));
                                    echo $this->Form->input("DepartmentAgenda.end", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control datetime", "type" => "text", "id" => "end"));
                                    ?>
                                </div>
                            </td>
                        </tr>
                    </table>
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
                <button class="btn btn-danger" data-toggle="modal" data-target="#edit" type="button" href="<?php echo Router::url('/admin/popups/content?content=confirm_edit', true); ?>">
                    <?= __("Simpan") ?>
                </button>
            </div>
        </div>
    </div>
</div>
<?php echo $this->Form->end() ?>