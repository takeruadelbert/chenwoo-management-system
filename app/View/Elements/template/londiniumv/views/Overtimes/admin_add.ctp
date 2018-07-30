<?php echo $this->Form->create("Overtime", array("class" => "form-horizontal form-separate", "action" => "add", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("Tambah Data Lembur Pegawai") ?>
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
                                    echo $this->Form->label("Overtime.tujuan", __("Tujuan"), array("class" => "col-sm-3 col-md-4 control-label"));
                                    echo $this->Form->input("Overtime.tujuan", array("div" => array("class" => "col-sm-9 col-md-8"), "options" => $tujuan, "label" => false, "class" => "select-full"));
                                    ?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" style="width:200px">
                                <div class="form-group">
                                    <?php
                                    echo $this->Form->label("Overtime.nomor", __("Pegawai"), array("class" => "col-sm-3 col-md-4 control-label"));
                                    echo $this->Form->input("Overtime.nomor", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "select-multiple", "options" => $pegawai, "multiple" => "multiple", "data-placeholder" => "-Pilih Pegawai-"));
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
                            <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Data Lembur") ?></h6>
                        </div>
                        <tr>
                            <td colspan="3" style="width:200px">
                                <div class="form-group">
                                    <?php
                                    echo $this->Form->label("Overtime.overtime_date", __("Tanggal Lembur"), array("class" => "col-sm-3 col-md-4 control-label"));
                                    echo $this->Form->input("Overtime.overtime_date", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control datepicker", "type" => "text"));
                                    ?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" style="width:200px">
                                <div class="form-group">
                                    <?php
                                    echo $this->Form->label("Overtime.start_time", __("Waktu Mulai Lembur"), array("class" => "col-sm-3 col-md-4 control-label"));
                                    echo $this->Form->input("Overtime.start_time", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control timepicker", "type" => "text"));
                                    ?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" style="width:200px">
                                <div class="form-group">
                                    <?php
                                    echo $this->Form->label("Overtime.end_time", __("Waktu Selesai Lembur"), array("class" => "col-sm-3 col-md-4 control-label"));
                                    echo $this->Form->input("Overtime.end_time", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control timepicker", "type" => "text"));
                                    ?>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Keterangan Lembur: </label>
            <div class="col-sm-10">
                <textarea rows="5" cols="5" class="limited form-control" name="data[Overtime][note]"></textarea>
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
        $("#OutboxTujuan").on("change", function () {
            if ($(this).val() == 'p') {
                $("#OutboxNomor").removeAttr("disabled");
            } else {
                $("#OutboxNomor").attr("disabled", "disabled");
            }
        })
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
            $('#OvertimeEmployeeId').val(suggestion.id);
            $('#bidang').val(suggestion.department);
        });
    })
</script>