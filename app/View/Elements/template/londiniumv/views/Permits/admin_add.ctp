<?php echo $this->Form->create("Permit", array("class" => "form-horizontal form-separate", "action" => "add", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("Tambah Data Izin") ?>
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
                                    echo $this->Form->label("Permit.nomor", __("Pegawai"), array("class" => "col-sm-3 col-md-4 control-label"));
                                    echo $this->Form->input("Permit.nomor", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "select-multiple", "options" => $pegawai, "multiple" => "multiple", "data-placeholder" => "-Pilih Pegawai-"));
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
                        <tr id = "sisaquotacutitahunan">
                            <td colspan="3" style="width:200px">
                                <div class="form-group">
                                    <?php
                                    echo $this->Form->label("Dummy.quota", __("Sisa Jatah Cuti Tahunan"), array("class" => "col-sm-3 col-md-4 control-label"));
                                    echo $this->Form->input("Dummy.quota", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "type" => "text", "disabled"));
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
                <textarea rows="5" cols="5" class="limited form-control" name="data[Permit][keterangan]" data-tip-limit="limit-text1"></textarea>
                <span class="help-block" id="limit-text1">Keterangan dibatasi hingga 100 Karakter</span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Catatan Personalia : </label>
            <div class="col-sm-10">
                <textarea rows="5" cols="5" class="limited form-control" name="data[Permit][personalia_note]" data-tip-limit="limit-text2"></textarea>
                <span class="help-block" id="limit-text2">Catatan Personalia dibatasi hingga 100 Karakter</span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Catatan General Manager : </label>
            <div class="col-sm-10">
                <textarea rows="5" cols="5" class="limited form-control" name="data[Permit][general_manager_note]" data-tip-limit="limit-text3"></textarea>
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
                <button class="btn btn-danger" data-toggle="modal" data-target="#add" type="button" href="<?php echo Router::url('/admin/popups/content?content=confirm_add', true); ?>">
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
        $("#sisaquotacutitahunan").hide();
        var employees = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('full_name'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            prefetch: '<?= Router::url("/admin/employees/list", true) ?>',
            remote: {
                url: '<?= Router::url("/admin/employees/list", true) ?>' + '?q=%QUERY',
                wildcard: '%QUERY',
            }
        });
        employees.clearPrefetchCache();
        employees.initialize(true);
        $('input.typeahead-ajax').typeahead({
            hint: false,
            highlight: true
        }, {
            name: 'employees',
            display: 'full_name',
            source: employees.ttAdapter(),
            templates: {
                header: '<center><h5>Data Pegawai</h5></center><hr>',
                suggestion: function (context) {
                    return '<p>Nama : ' + context.full_name + '<br>NIP : ' + context.nip + '<br>Jabatan : ' + context.jabatan + '<br>Department : ' + context.department + '<br/>Cabang : ' + context.branch_office + '</p>';
                },
                empty: [
                    '<center><h5>Data Pegawai</h5></center><hr> <center><p> Hasil Pencarian Anda Tidak Dapat Ditemukan. </p></center>',
                ]
            }
        });
        $('input.typeahead-ajax').bind('typeahead:select', function (ev, suggestion) {
            $('#EmployeeNip').val(suggestion.nip);
            $('#OfficeName').val(suggestion.jabatan);
            $('#PermitEmployeeId').val(suggestion.id);
            $('#BranchOfficeName').val(suggestion.branch_office);
            $('#bidang').val(suggestion.department);
            getQuotaCuti();
        });
        $("#PermitPermitTypeId").on("select2-selecting change", function (e) {
            $("#sisaquotacutitahunan").hide();
            if ($("#PermitPermitTypeId").val() == 3) {
                $('#tujuanDinas').hide();
                $('#jamKeluar').show();
            } else if ($("#PermitPermitTypeId").val() == 9) {
                $('#tujuanDinas').show();
                $('#jamKeluar').hide();
            } else {
                $('#tujuanDinas').hide();
                $('#jamKeluar').hide();
                getQuotaCuti();
            }
        });
        $("#idpck_PermitStartDate").on("change paste keyup", function () {
            getQuotaCuti();
        })
    })

    function getQuotaCuti() {
        var permitTypeId = $("#PermitPermitTypeId").val();
        if (permitTypeId != 4) {
            return false;
        }
        $("#sisaquotacutitahunan").show();
        var employeeId = $("#PermitEmployeeId").val();
        if (!employeeId) {
            return false;
        }
        var startDt = $("#idpck_PermitStartDate").val();
        if (!startDt) {
            return false;
        }
        $.ajax({
            url: BASE_URL + "admin/permits/get_quota_cuti/?employee_id=" + employeeId + "&start_dt=" + startDt,
            type: "GET",
            dataType: "JSON",
            success: function (response) {
                $("#DummyQuota").val(response.data.quota);
            }
        });
    }
</script>