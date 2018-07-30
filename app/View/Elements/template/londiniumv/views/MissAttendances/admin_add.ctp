<?php echo $this->Form->create("MissAttendance", array("class" => "form-horizontal form-separate", "action" => "add", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("Tambah Data Lupa Absen Pegawai") ?>
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
                                    echo $this->Form->label("MissAttendance.name", __("Cari Nama Pegawai"), array("class" => "col-sm-3 col-md-4 control-label"));
                                    ?>
                                    <div class="col-sm-9 col-md-8">
                                        <div class="has-feedback">
                                            <?php
                                            echo $this->Form->input("MissAttendance.name", array("div" => false, "label" => false, "class" => "form-control typeahead2-ajax"));
                                            ?>
                                            <i class="icon-search3 form-control-feedback"></i>
                                        </div>
                                    </div>
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
                                    echo $this->Form->input("MissAttendance.employee_id", array("type" => "hidden", "class" => "form-control"));
                                    ?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" style="width:200px">
                                <div class="form-group">
                                    <?php
                                    echo $this->Form->label("Office.name", __("Jabatan"), array("class" => "col-sm-3 col-md-4 control-label"));
                                    echo $this->Form->input("Office.name", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled" => true));
                                    ?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" style="width:200px">
                                <div class="form-group">
                                    <?php
                                    echo $this->Form->label("Department.name", __("Department"), array("class" => "col-sm-3 col-md-4 control-label"));
                                    echo $this->Form->input("Department.name", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled" => true, "id" => "bidang"));
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
                            <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Data Lupa Absen") ?></h6>
                        </div>
                        <tr>
                            <td colspan="3" style="width:200px">
                                <div class="form-group">
                                    <?php
                                    echo $this->Form->label("MissAttendance.attendance_type_id", __("Jenis Lupa Absen"), array("class" => "col-sm-3 col-md-4 control-label"));
                                    echo $this->Form->input("MissAttendance.attendance_type_id", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "select-full", "empty" => "", "placeholder" => "- Pilih Jenis Lupa Absen -"));
                                    ?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" style="width:200px">
                                <div class="form-group">
                                    <?php
                                    echo $this->Form->label("MissAttendance.miss_date", __("Tanggal Lupa Absen"), array("class" => "col-sm-3 col-md-4 control-label"));
                                    echo $this->Form->input("MissAttendance.miss_date", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control datepicker", "type" => "text"));
                                    ?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" style="width:200px">
                                <div class="form-group">
                                    <?php
                                    echo $this->Form->label("MissAttendance.miss_time", __("Jam Lupa Absen"), array("class" => "col-sm-3 col-md-4 control-label"));
                                    echo $this->Form->input("MissAttendance.miss_time", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control timepicker", "type" => "text"));
                                    ?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" style="width:200px">
                                <div class="form-group">
                                    <?php
                                    echo $this->Form->label("Dummy.name", __("Cari Nama Atasan"), array("class" => "col-sm-3 col-md-4 control-label"));
//                                    echo $this->Form->label("Supervisor.atasan", __("Atasan"), array("class" => "col-sm-3 col-md-4 control-label"));
//                                    echo $this->Form->input("Supervisor.atasan", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled" => true, "id" => "namaAtasan"));
                                    ?>
                                    <div class="col-sm-9 col-md-8">
                                        <div class="has-feedback">
                                            <?php
                                            echo $this->Form->input("Dummy.name", array("div" => false, "label" => false, "class" => "form-control typeahead-ajax"));
                                            ?>
                                            <i class="icon-search3 form-control-feedback"></i>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" style="width:200px">
                                <div class="form-group">
                                    <?php
//                                    echo $this->Form->label("Supervisor.nip", __("NIP Atasan"), array("class" => "col-sm-3 col-md-4 control-label"));
//                                    echo $this->Form->input("Supervisor.nip", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled" => true, "id" => "nipAtasan"));
                                    echo $this->Form->label("Supervisor.nip_baru", __("NIP Atasan"), array("class" => "col-sm-3 col-md-4 control-label"));
                                    echo $this->Form->input("Supervisor.nip_baru", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled" => true, "id" => "atasan"));
                                    ?>
                                    <?php
                                    echo $this->Form->input("MissAttendance.supervisor_id", array("type" => "hidden", "class" => "form-control", "id" => "idAtasan"));
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
                <textarea rows="5" cols="5" class="limited form-control" name="data[MissAttendance][note]"></textarea>
                <span class="help-block" id="limit-text">Keterangan dibatasi hingga 100 Karakter</span>
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
        var employees = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('full_name'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            prefetch: '<?= Router::url("/admin/employees/list", true) ?>',
            remote: {
                url: '<?= Router::url("/admin/employees/list", true) ?>' + '?q=%QUERY',
                wildcard: '%QUERY',
            }
        });
        var supervisors = new Bloodhound({
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
        supervisors.clearPrefetchCache();
        supervisors.initialize(true);
        //cari data pegawai
        $('input.typeahead2-ajax').typeahead({
            hint: false,
            highlight: true
        }, {
            name: 'employees',
            display: 'full_name',
            source: employees.ttAdapter(),
            templates: {
                header: '<center><h5>Data Pegawai</h5></center><hr>',
                suggestion: function (context) {
                    return '<p>Nama : ' + context.full_name + '<br>NIP : ' + context.nip + '<br>Jabatan : ' + context.jabatan + '<br>Department : ' + context.department + '</p>';
                },
                empty: [
                    '<center><h5>Data Pegawai</h5></center><hr> <center><p> Hasil Pencarian Anda Tidak Dapat Ditemukan. </p></center>',
                ]
            }
        });
        $('input.typeahead2-ajax').bind('typeahead:select', function (ev, suggestion) {
            $('#EmployeeNip').val(suggestion.nip);
            $('#OfficeName').val(suggestion.jabatan);
            $('#MissAttendanceEmployeeId').val(suggestion.id);
            $('#bidang').val(suggestion.department);
//            getAtasan(suggestion.jabatan_id);
        });
//cari data atasan
        $('input.typeahead-ajax').typeahead({
            hint: false,
            highlight: true
        }, {
            name: 'supervisors',
            display: 'full_name',
            source: supervisors.ttAdapter(),
            templates: {
                header: '<center><h5>Data Atasan</h5></center><hr>',
                suggestion: function (context) {
                    return '<p>Nama : ' + context.full_name + '<br>NIP : ' + context.nip + '<br>Eselon : ' + context.eselon + '<br>Jabatan : ' + context.jabatan + '<br>Department : ' + context.department + '</p>';
                },
                empty: [
                    '<center><h5>Data Atasan</h5></center><hr> <center><p> Hasil Pencarian Anda Tidak Dapat Ditemukan. </p></center>',
                ]
            }
        });
        $('input.typeahead-ajax').bind('typeahead:select', function (ev, suggestion) {
            $('#atasan').val(suggestion.nip);
            $('#idAtasan').val(suggestion.id);
        });
    })

//    function getAtasan(office_id) {
//        var result = 0;
//        $.ajax({
//            url: BASE_URL + "admin/miss_attendances/get_atasan/" + office_id,
//            type: "GET",
//            dataType: "JSON",
//            data: {},
//            success: function (data) {
//                console.log(data);
//                $('#namaAtasan').val(data.Account.Biodata.full_name);
//                $('#nipAtasan').val(data.Employee.nip);
//                $('#idAtasan').val(data.Employee.id);
//            }
//        });
//    }
</script>