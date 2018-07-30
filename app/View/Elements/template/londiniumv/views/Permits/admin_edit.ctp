<?php echo $this->Form->create("Permit", array("class" => "form-horizontal form-separate", "action" => "edit", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("Ubah Data Izin") ?>
            </h6>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="table-responsive">
                    <table width="100%" class="table">
                        <div class="panel-heading" style="background:#2179cc">
                            <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Data Pegawai") ?></h6>
                        </div>
                        <tr>
                            <td colspan="3" style="width:200px">
                                <div class="form-group">
                                    <?php
                                    echo $this->Form->label("Employee.Account.Biodata.full_name", __("Nama Pegawai"), array("class" => "col-sm-3 col-md-4 control-label"));
                                    echo $this->Form->input("Employee.Account.Biodata.full_name", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled" => true));
                                    ?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" style="width:200px">
                                <div class="form-group">
                                    <?php
                                    echo $this->Form->label("Employee.nip", __("NIP"), array("class" => "col-sm-3 col-md-4 control-label"));
                                    echo $this->Form->input("Employee.nip", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled" => true));
                                    ?>
                                    <?php
                                    echo $this->Form->input("Permit.employee_id", array("type" => "hidden", "class" => "form-control"));
                                    ?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" style="width:200px">
                                <div class="form-group">
                                    <?php
                                    echo $this->Form->label("Employee.Office.name", __("Jabatan"), array("class" => "col-sm-3 col-md-4 control-label"));
                                    echo $this->Form->input("Employee.Office.name", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled" => true));
                                    ?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" style="width:200px">
                                <div class="form-group">
                                    <?php
                                    echo $this->Form->label("Employee.Department.name", __("Department"), array("class" => "col-sm-3 col-md-4 control-label"));
                                    echo $this->Form->input("Employee.Department.name", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled" => true, "id" => "bidang"));
                                    ?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" style="width:200px">
                                <div class="form-group">
                                    <?php
                                    echo $this->Form->label("Employee.BranchOffice.name", __("Cabang"), array("class" => "col-sm-3 col-md-4 control-label"));
                                    echo $this->Form->input("Employee.BranchOffice.name", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled" => true, "required" => false));
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
                            <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Data Izin") ?></h6>
                        </div>
                        <tr>
                            <td colspan="3" style="width:200px">
                                <div class="form-group">
                                    <?php
                                    echo $this->Form->label("Permit.permit_type_id", __("Jenis Izin"), array("class" => "col-sm-3 col-md-4 control-label"));
                                    echo $this->Form->input("Permit.permit_type_id", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "select-full", "empty" => "", "placeholder" => "- Pilih Jenis Izin -"));
                                    ?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" style="width:200px">
                                <div class="form-group">
                                    <?php
                                    echo $this->Form->label("Permit.start_date", __("Tanggal Awal"), array("class" => "col-sm-3 col-md-4 control-label"));
                                    echo $this->Form->input("Permit.start_date", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control datepicker", "type" => "text"));
                                    ?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" style="width:200px">
                                <div class="form-group">
                                    <?php
                                    echo $this->Form->label("Permit.end_date", __("Tanggal Akhir"), array("class" => "col-sm-3 col-md-4 control-label"));
                                    echo $this->Form->input("Permit.end_date", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control datepicker", "type" => "text"));
                                    ?>
                                </div>
                            </td>
                        </tr>
                        <tr id = "jamKeluar">
                            <td colspan="3" style="width:200px">
                                <div class="form-group">
                                    <?php
                                    echo $this->Form->label("Permit.jam_keluar", __("Jam Keluar"), array("class" => "col-sm-3 col-md-4 control-label"));
                                    echo $this->Form->input("Permit.jam_keluar", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control timepicker", "type" => "text"));
                                    ?>
                                </div>
                            </td>
                        </tr>
                        <tr id = "tujuanDinas">
                            <td colspan="3" style="width:200px">
                                <div class="form-group">
                                    <?php
                                    echo $this->Form->label("Permit.tujuan_dinas", __("Tujuan Dinas"), array("class" => "col-sm-3 col-md-4 control-label"));
                                    echo $this->Form->input("Permit.tujuan_dinas", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "type" => "text", "placeholder" => "Isikan jika tipe izin 'Dinas'"));
                                    ?>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Keterangan : </label>
            <div class="col-sm-10">
                <?= $this->Form->input("Permit.keterangan", array("div" => false, "label" => false, "class" => "form-control")) ?>
                <span class="help-block" id="limit-text">Keterangan dibatasi hingga 100 Karakter</span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Catatan Personalia : </label>
            <div class="col-sm-10">
                <?= $this->Form->input("Permit.personalia_note", array("div" => false, "label" => false, "class" => "form-control")) ?>
                <span class="help-block" id="limit-text2">Catatan Personalia dibatasi hingga 100 Karakter</span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Catatan General Manager : </label>
            <div class="col-sm-10">
                <?= $this->Form->input("Permit.general_manager_note", array("div" => false, "label" => false, "class" => "form-control")) ?>
                <span class="help-block" id="limit-text3">Catatan General Manager dibatasi hingga 100 Karakter</span>
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
<script>
    $(document).ready(function () {
        $('#tujuanDinas').hide();
        $('#jamKeluar').hide();
        var id = $("#PermitPermitTypeId").val();
        if (id == 9) {
            $('#tujuanDinas').show();
            $('#jamKeluar').hide();
        } else if (id == 3) {
            $('#tujuanDinas').hide();
            $('#jamKeluar').show();
        }
        $("#PermitPermitTypeId").on("select2-selecting change", function (e) {
            if ($("#PermitPermitTypeId").val() == 3) {
                $('#tujuanDinas').hide();
                $('#jamKeluar').show();
            } else if ($("#PermitPermitTypeId").val() == 9) {
                $('#tujuanDinas').show();
                $('#jamKeluar').hide();
            } else {
                $('#tujuanDinas').hide();
                $('#jamKeluar').hide();
            }
        });
    })
</script>