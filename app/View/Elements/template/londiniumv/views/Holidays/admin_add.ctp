<?php echo $this->Form->create("Holiday", array("class" => "form-horizontal form-separate", "action" => "add", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="block-inner text-danger">
                    <h6 class="heading-hr"><?= __("Tambah Kalender Libur") ?>
                    </h6>
                </div>
                <div class="table-responsive">
                    <table width="100%" class="table">
                        <div class="panel-heading" style="background:#2179cc">
                            <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Data Kalender Libur") ?></h6>
                        </div>
                        <tr>
                            <td>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <?php
                                            echo $this->Form->label("Holiday.name", __("Nama"), array("class" => "col-sm-3 col-md-4 control-label"));
                                            echo $this->Form->input("Holiday.name", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control"));
                                            ?>
                                        </div>
                                        <div class="col-md-6">
                                            <?php
                                            echo $this->Form->label("Holiday.start_date", __("Tanggal Libur"), array("class" => "col-sm-3 col-md-4 control-label"));
                                            echo $this->Form->input("Holiday.start_date", array("div" => array("class" => "col-sm-4 col-md-4"), "label" => false, "class" => "form-control datepicker", "type" => "text", "placeholder" => "Dari"));
                                            echo $this->Form->input("Holiday.end_date", array("div" => array("class" => "col-sm-4 col-md-4"), "label" => false, "class" => "form-control datepicker tip", "type" => "text", "placeholder" => "Sampai", "data-toggle" => "tooltip", "data-trigger" => "focus", "title" => "Isikan sama dengan tanggal mulai jika hanya 1 hari"));
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
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