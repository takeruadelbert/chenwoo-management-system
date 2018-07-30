<?php echo $this->Form->create("Permit", array("class" => "form-horizontal form-separate", "action" => "selfadd", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("FORM PERMOHONAN IJIN PEGAWAI") ?>
                <small class="display-block">Mohon Isikan Form Permohonan Ijin Pegawai Dengan Sesuai dan Benar</small>
            </h6>
        </div>
        <div class="table-responsive">
            <table width="100%" class="table table-bordered">
                <tr>
                    <td width="20%" style="width:200px">Nama Pegawai</td>
                    <td width="1%" align="center" style="width:10px">:</td>
                    <td width="25%"><?= $this->Session->read("credential.admin.Biodata.full_name") ?></td>
                    <td width="1%" rowspan="3">&nbsp;</td>
                    <td width="20%">Jabatan</td>
                    <td width="1%" align="center">:</td>
                    <td width="25%"><?= $this->Session->read("credential.admin.Employee.Office.name") ?></td>
                </tr>
                <tr>
                    <td width="20%">NIP Pegawai</td>
                    <td width="1%" align="center">:</td>
                    <td width="25%"><?= $this->Echo->empty_strip($this->Session->read("credential.admin.Employee.nip")) ?></td>
                    <td width="20%">Department</td>
                    <td width="1%" align="center">:</td>
                    <td width="25%"><?= $this->Session->read("credential.admin.Employee.Department.name") ?></td>
                </tr>
                <tr>
                </tr>
            </table>
        </div>
        <br/>
        <div class="table-responsive">
            <table width="100%" class="table">
                <div class="panel-heading" style="background:#2179cc">
                    <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Periode Ijin") ?></h6>
                </div>
                <tr>
                    <td colspan="3" style="width:200px">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php
                                    echo $this->Form->label("Permit.start_date", __("Tanggal Awal"), array("class" => "col-sm-3 col-md-4 control-label"));
                                    echo $this->Form->input("Permit.start_date", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control datepicker", "type" => "text"));
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php
                                    echo $this->Form->label("Permit.end_date", __("Tanggal Akhir"), array("class" => "col-sm-3 col-md-4 control-label"));
                                    echo $this->Form->input("Permit.end_date", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control datepicker tip", "type" => "text", "data-toggle" => "tooltip", "data-trigger" => "focus", "title" => "Isikan sama dengan tanggal awal jika hanya 1 hari"));
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php
                                    echo $this->Form->label("Permit.permit_type_id", __("Jenis Ijin"), array("class" => "col-sm-3 col-md-4 control-label"));
                                    echo $this->Form->input("Permit.permit_type_id", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "select-full", "empty" => "", "placeholder" => "- Pilih Jenis Ijin -"));
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php
                                    echo $this->Form->label("Permit.lt_time", __("Jam Pulang Cepat/Terlambat"), array("class" => "col-sm-3 col-md-4 control-label"));
                                    echo $this->Form->input("Permit.lt_time", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control tip timepicker", "type" => "text", "data-toggle" => "tooltip", "data-trigger" => "focus", "title" => "Diisi jika ijin cepat pulang/terlambat datang"));
                                    ?>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="table-responsive">
                    <table width="100%" class="table table-hover table-bordered">
                        <div class="panel-heading" style="background:#2179cc">
                            <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Atasan Langsung") ?></h6>
                        </div>
                        <tr>
                            <td>Cari Nama Pegawai</td>
                            <td>:</td>
                            <td>
                                <div class="has-feedback">
                                    <?php
                                    echo $this->Form->input("Permit.name", array("div" => false, "label" => false, "class" => "form-control typeahead-ajax"));
                                    ?>
                                    <i class="icon-search3 form-control-feedback"></i>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>NIP</td>
                            <td>:</td>
                            <td>
                                <?php
                                echo $this->Form->input("Employee.nip_baru", array("div" => array("class" => ""), "label" => false, "class" => "form-control", "disabled" => true));
                                ?>
                                <?php
                                echo $this->Form->input("Permit.supervisor_id", array("type" => "hidden", "class" => "form-control"));
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Jabatan</td>
                            <td>:</td>
                            <td>
                                <?php
                                echo $this->Form->input("Office.name", array("div" => array("class" => ""), "label" => false, "class" => "form-control", "disabled" => true));
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Department</td>
                            <td>:</td>
                            <td>
                                <?php
                                echo $this->Form->input("Department.name", array("div" => array("class" => ""), "label" => false, "class" => "form-control", "disabled" => true, "id" => "bidang"));
                                ?>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="col-md-6">
                <div class="panel-heading" style="background:#2179cc">
                    <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Keterangan") ?></h6>
                </div>
                <br/>
                <textarea rows="5" cols="5" class="form-control editor" name="data[Permit][keterangan]"></textarea>
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
                    <?= __("Kirim") ?>
                </button>&nbsp;
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
            prefetch: '<?= Router::url("/admin/employees/list_office", true) ?>',
            remote: {
                url: '<?= Router::url("/admin/employees/list_office", true) ?>' + '?q=%QUERY',
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
                    return '<p>Nama : ' + context.full_name + '<br>NIP : ' + context.nip + '<br>Jabatan : ' + context.jabatan + '<br>Department : ' + context.department + '</p>';
                },
                empty: [
                    '<center><h5>Data Pegawai</h5></center><hr> <center><p> Hasil Pencarian Anda Tidak Dapat Ditemukan. </p></center>',
                ]
            }
        });
        $('input.typeahead-ajax').bind('typeahead:select', function (ev, suggestion) {
            console.log(suggestion);
            $('#EmployeeNipBaru').val(suggestion.nip);
            $('#OfficeName').val(suggestion.jabatan);
            $('#UnitPositionEselon').val(suggestion.eselon);
            $('#PermitSupervisorId').val(suggestion.id);
            $('#bidang').val(suggestion.department);
        });
    })
</script>