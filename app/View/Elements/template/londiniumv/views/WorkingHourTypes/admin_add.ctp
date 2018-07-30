<?php echo $this->Form->create("WorkingHourType", array("class" => "form-horizontal form-separate", "action" => "add", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="block-inner text-danger">
                    <h6 class="heading-hr"><?= __("Tambah Jenis Jam Kerja") ?>
                        <small class="display-block"><?= _APP_CORPORATE_FULL ?></small>
                    </h6>
                </div>
                <div class="table-responsive">
                    <table width="100%" class="table">
                        <div class="panel-heading" style="background:#2179cc">
                            <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Jenis Jam Kerja") ?></h6>
                        </div>
                        <tr>
                            <td colspan="3" style="width:200px">
                                <div class="form-group">
                                    <?php
                                    echo $this->Form->label("WorkingHourType.name", __("Jenis Jam Kerja"), array("class" => "col-sm-3 col-md-4 control-label"));
                                    echo $this->Form->input("WorkingHourType.name", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "type" => "text"));
                                    ?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" style="width:200px">
                                <div class="form-group">
                                    <?php
                                    echo $this->Form->label("WorkingHourType.is_custom", __("Auto?"), array("class" => "col-sm-3 col-md-4 control-label"));
                                    ?>
                                    <label class="radio-inline radio-success">
                                        <input type="radio" name="data[WorkingHourType][is_custom]" value="0" class="styled" checked> <b>Ya</b> &nbsp; &nbsp; &nbsp; &nbsp;
                                        <input type="radio" name="data[WorkingHourType][is_custom]" value="1" class="styled"> <b>Tidak</b>
                                    </label>
                                </div>
                            </td>
                        </tr>
                        <tr class="toggleauto">
                            <td colspan="3" style="width:200px">
                                <div class="form-group">
                                    <?php
                                    echo $this->Form->label("WorkingHourType.ignore_holiday", __("Abaikan Hari Libur?"), array("class" => "col-sm-3 col-md-4 control-label"));
                                    ?>
                                    <label class="radio-inline radio-success">
                                        <input type="radio" name="data[WorkingHourType][ignore_holiday]" value="1" class="styled" checked> <b>Ya</b> &nbsp; &nbsp; &nbsp; &nbsp;
                                        <input type="radio" name="data[WorkingHourType][ignore_holiday]" value="0" class="styled"> <b>Tidak</b>
                                    </label>
                                </div>
                            </td>
                        </tr>
                        <tr class="toggleauto">
                            <td colspan="3" style="width:200px">
                                <div class="form-group">
                                    <?php
                                    echo $this->Form->label("WorkingHourTypeDetail.day_id", __("Daftar Hari Kerja : "), array("class" => "col-sm-3 col-md-4 control-label"));
                                    ?>
                                    <?php
                                    foreach ($days as $k => $day) {
                                        ?>
                                        <label class="checkbox-inline checkbox-success toggleable-fields " data-name="<?= $day ?>">
                                            <input type="checkbox" class="styled" name="data[WorkingHourTypeDetail][<?= $k ?>][day_id]" value='<?php echo $k ?>'> <b><?= $day ?></b> &nbsp;
                                        </label>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </td>
                        </tr>
                    </table>
                    <?php
                    foreach ($days as $n => $day) {
                        ?>
                        <table width="100%" class="table toggle-disabled hidden toggleauto" id="data<?= $day ?>">
                            <div class="panel-heading hidden toggleauto" style="background:#2179cc" id="data<?= $day ?>Field">
                                <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __($day) ?></h6>
                            </div>
                            <tr>
                                <td colspan="3" style="width:200px">
                                    <div class="form-group">
                                        <div class="col-sm-6">
                                            <?php
                                            echo $this->Form->label("WorkingHourTypeDetail.$n.start_work", __("Jam Masuk Kerja"), array("class" => "col-sm-3 col-md-4 control-label"));
                                            echo $this->Form->input("WorkingHourTypeDetail.$n.start_work", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control timepicker", "type" => "text", "disabled" => "true"));
                                            ?>
                                        </div>
                                        <div class="col-sm-6">
                                            <?php
                                            echo $this->Form->label("WorkingHourTypeDetail.$n.end_work", __("Jam Pulang"), array("class" => "col-sm-3 col-md-4 control-label"));
                                            echo $this->Form->input("WorkingHourTypeDetail.$n.end_work", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control timepicker", "type" => "text", "disabled" => "true"));
                                            ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-6">
                                            <?php
                                            echo $this->Form->label("WorkingHourTypeDetail.$n.start_in", __("Jam Awal Absen Masuk Kerja"), array("class" => "col-sm-3 col-md-4 control-label"));
                                            echo $this->Form->input("WorkingHourTypeDetail.$n.start_in", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control timepicker", "type" => "text", "disabled" => "true"));
                                            ?>
                                        </div>
                                        <div class="col-sm-6">
                                            <?php
                                            echo $this->Form->label("WorkingHourTypeDetail.$n.end_in", __("Jam Terakhir Absen Masuk Kerja"), array("class" => "col-sm-3 col-md-4 control-label"));
                                            echo $this->Form->input("WorkingHourTypeDetail.$n.end_in", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control timepicker", "type" => "text", "disabled" => "true"));
                                            ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-6">
                                            <?php
                                            echo $this->Form->label("WorkingHourTypeDetail.$n.start_home", __("Jam Awal Absen Pulang"), array("class" => "col-sm-3 col-md-4 control-label"));
                                            echo $this->Form->input("WorkingHourTypeDetail.$n.start_home", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control timepicker", "type" => "text", "disabled" => "true"));
                                            ?>
                                        </div>
                                        <div class="col-sm-6">
                                            <?php
                                            echo $this->Form->label("WorkingHourTypeDetail.$n.end_home", __("Jam Terakhir Absen Pulang"), array("class" => "col-sm-3 col-md-4 control-label"));
                                            echo $this->Form->input("WorkingHourTypeDetail.$n.end_home", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control timepicker", "type" => "text", "disabled" => "true"));
                                            ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-6">
                                            <?php
                                            echo $this->Form->label("WorkingHourTypeDetail.$n.start_out", __("Jam Istirahat"), array("class" => "col-sm-3 col-md-4 control-label"));
                                            echo $this->Form->input("WorkingHourTypeDetail.$n.start_out", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control timepicker", "type" => "text", "disabled" => "true"));
                                            ?>
                                        </div>
                                        <div class="col-sm-6">
                                            <?php
                                            echo $this->Form->label("WorkingHourTypeDetail.$n.end_out", __("Jam Selesai Istirahat"), array("class" => "col-sm-3 col-md-4 control-label"));
                                            echo $this->Form->input("WorkingHourTypeDetail.$n.end_out", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control timepicker", "type" => "text", "disabled" => "true"));
                                            ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-6">
                                            <?php
                                            echo $this->Form->label("WorkingHourTypeDetail.$n.overtime_in", __("Jam Mulai Lembur"), array("class" => "col-sm-3 col-md-4 control-label"));
                                            echo $this->Form->input("WorkingHourTypeDetail.$n.overtime_in", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control timepicker", "type" => "text", "disabled" => "true"));
                                            ?>
                                        </div>
                                        <div class="col-sm-6">
                                            <?php
                                            echo $this->Form->label("WorkingHourTypeDetail.$n.overtime_out", __("Jam Selesai Lembur"), array("class" => "col-sm-3 col-md-4 control-label"));
                                            echo $this->Form->input("WorkingHourTypeDetail.$n.overtime_out", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control timepicker", "type" => "text", "disabled" => "true"));
                                            ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-6">
                                            <?php
                                            echo $this->Form->label("WorkingHourTypeDetail.$n.tolerance_late", __("Toleransi Keterlambatan (menit)"), array("class" => "col-sm-3 col-md-4 control-label"));
                                            echo $this->Form->input("WorkingHourTypeDetail.$n.tolerance_late", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "type" => "text", "disabled" => "true"));
                                            ?>
                                        </div>
                                        <div class="col-sm-6">
                                            <?php
                                            echo $this->Form->label("WorkingHourTypeDetail.$n.tolerance_home_early", __("Toleransi Pulang Awal (menit)"), array("class" => "col-sm-3 col-md-4 control-label"));
                                            echo $this->Form->input("WorkingHourTypeDetail.$n.tolerance_home_early", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "type" => "text", "disabled" => "true"));
                                            ?>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                        <?php
                    }
                    ?>
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

<script>
    $(document).ready(function () {
        $('.toggleable-fields').change(function () {
            if ($(this).find('input.styled').is(':checked')) {
                $("#data" + $(this).data("name")).find("input").removeAttr('disabled');
            } else {
                $("#data" + $(this).data("name")).find("input").attr('disabled', 'true');
            }
            $("#data" + $(this).data("name") + ",#data" + $(this).data("name") + "Field").toggleClass("hidden");
        });
        $(".toggle-disabled").not(".hidden").find("input").removeAttr('disabled');
        $('input[name="data[WorkingHourType][is_custom]"]').change(function () {
            if ($(this, "input:checked").val() == 0) {
                $(".toggleauto").show();
            } else {
                $(".toggleauto").hide();
            }
        });
    });

</script>