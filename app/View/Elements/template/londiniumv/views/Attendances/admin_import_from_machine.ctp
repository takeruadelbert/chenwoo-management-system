<?php echo $this->Form->create("Attendance", array("class" => "form-horizontal form-separate", "action" => "import_from_machine", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="block-inner text-danger">
                    <h6 class="heading-hr"><?= __("Import Data Absensi") ?>
                    </h6>
                </div>
                <div class="table-responsive">
                    <table width="100%" class="table">
                        <tr>
                            <td>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <?php
                                            echo $this->Form->label("Attendance.attendance_machine_id", __("Mesin Absensi"), array("class" => "col-sm-3 col-md-4 control-label"));
                                            echo $this->Form->input("Attendance.attendance_machine_id", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "select-full"));
                                            ?>
                                        </div>
                                        <div class="col-md-6">
                                            <?php
                                            echo $this->Form->label("Attendance.from", __("Tanggal"), array("class" => "col-sm-3 col-md-4 control-label"));
                                            echo $this->Form->input("Attendance.from", array("div" => array("class" => "col-sm-4 col-md-4"), "label" => false, "class" => "form-control datepicker tip", "type" => "text", "placeholder" => "Dari", "data-toggle" => "tooltip", "data-trigger" => "focus", "title" => "Kosongkan untuk import hari ini"));
                                            echo $this->Form->input("Attendance.to", array("div" => array("class" => "col-sm-4 col-md-4"), "label" => false, "class" => "form-control datepicker tip", "type" => "text", "placeholder" => "Sampai", "data-toggle" => "tooltip", "data-trigger" => "focus", "title" => "Kosongkan untuk import hari ini"));
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="form-actions text-right">
                                    <input name="Button" type="button" onclick="history.go(-1);" class="btn btn-success" value="<?= __("Kembali") ?>">
                                    <input type="reset" value="Reset" class="btn btn-info">
                                    <input type="submit" value="<?= __("Simpan") ?>" class="btn btn-danger">
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <!--        <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="block-inner text-danger">
                            <div class="form-actions text-center">
                                <input name="Button" type="button" onclick="history.go(-1);" class="btn btn-success" value="<?= __("Kembali") ?>">
                                <input type="reset" value="Reset" class="btn btn-info">
                                <input type="submit" value="<?= __("Import") ?>" class="btn btn-danger">
                            </div>
                        </div>
                    </div>
                </div>-->
    </div>
</div>
<?php echo $this->Form->end() ?>