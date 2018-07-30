<?php echo $this->Form->create("Pension", array("class" => "form-horizontal form-separate", "action" => "add", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("Tambah Data Pensiun") ?>
                <small class="display-block">Mohon Isikan Dengan Sesuai dan Benar</small>
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
                                    echo $this->Form->label("Pension.name", __("Nama Pegawai"), array("class" => "col-sm-3 col-md-4 control-label"));
                                    ?>
                                    <div class="col-sm-9 col-md-8">
                                        <div class="has-feedback">
                                            <?php
                                            echo $this->Form->input("Pension.name", array("div" => false, "label" => false, "class" => "form-control typeahead-ajax", "placeholder" => "Cari Nomor Pegawai ..."));
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
                                    echo $this->Form->input("Pension.employee_id", array("type" => "hidden", "class" => "form-control"));
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
                            <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Data Pensiun") ?></h6>
                        </div>
                        <tr>
                            <td colspan="3" style="width:200px">
                                <div class="form-group">
                                    <?php
                                    echo $this->Form->label("Pension.pension_type_id", __("Jenis Pensiun"), array("class" => "col-sm-3 col-md-4 control-label"));
                                    echo $this->Form->input("Pension.pension_type_id", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "select-full", "empty" => "", "placeholder" => "- Pilih Jenis Pensiun -"));
                                    ?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" style="width:200px">
                                <div class="form-group">
                                    <?php
                                    echo $this->Form->label("Pension.nomor_sk", __("No. SK Pensiun"), array("class" => "col-sm-3 col-md-4 control-label"));
                                    echo $this->Form->input("Pension.nomor_sk", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control"));
                                    ?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" style="width:200px">
                                <div class="form-group">
                                    <?php
                                    echo $this->Form->label("Pension.tanggal_sk", __("Tanggal SK Pensiun"), array("class" => "col-sm-3 col-md-4 control-label"));
                                    echo $this->Form->input("Pension.tanggal_sk", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control datepicker", "type" => "text"));
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
            $('#EmployeeNip').val(suggestion.nip);
            $('#OfficeName').val(suggestion.jabatan);
            $('#PensionEmployeeId').val(suggestion.id);
            $('#bidang').val(suggestion.department);
        });
    })
</script>