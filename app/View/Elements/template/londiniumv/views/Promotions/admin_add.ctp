<?php echo $this->Form->create("Promotion", array("class" => "form-horizontal form-separate", "action" => "add", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("Tambah Data Kenaikan Jabatan") ?>
                <small class="display-block">Mohon Isikan Dengan Sesuai dan Benar</small>
            </h6>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="table-responsive">
                    <table width="100%" class="table table-hover table-bordered">
                        <div class="panel-heading" style="background:#2179cc">
                            <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Data Pegawai") ?></h6>
                        </div>
                        <tr>
                            <td>Cari Nama Pegawai</td>
                            <td>:</td>
                            <td>
                                <div class="has-feedback">
                                    <?php
                                    echo $this->Form->input("Promotion.name", array("div" => false, "label" => false, "class" => "form-control typeahead-ajax"));
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
                                echo $this->Form->input("Employee.nip", array("div" => array("class" => ""), "label" => false, "class" => "form-control", "disabled" => true));
                                ?>
                                <?php
                                echo $this->Form->input("Promotion.employee_id", array("type" => "hidden", "class" => "form-control"));
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
                                <?php
                                echo $this->Form->input("Promotion.previous_office_id", array("type" => "hidden", "class" => "form-control", "id" => "previousOfficeID"));
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
                    <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Kenaikan Jabatan") ?></h6>
                </div>
                <div class="form-group">
                    <?php
                    echo $this->Form->label("Promotion.promotion_type_id", __("Jenis Kenaikan Jabatan"), array("class" => "col-sm-3 col-md-4 control-label"));
                    echo $this->Form->input("Promotion.promotion_type_id", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "select-full", "empty" => "", "placeholder" => "- Pilih Jenis Kenaikan Jabatan -"));
                    ?>
                </div>
                <div class="form-group">
                    <?php
                    echo $this->Form->label("Promotion.current_office_id", __("Jabatan Baru"), array("class" => "col-sm-3 col-md-4 control-label"));
                    echo $this->Form->input("Promotion.current_office_id", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "select-full", "empty" => "", "placeholder" => "- Pilih Jabatan -"));
                    ?>
                </div>
                <div class="form-group">
                    <?php
                    echo $this->Form->label("Promotion.promotion_date", __("Tanggal Kenaikan Jabatan"), array("class" => "col-sm-3 col-md-4 control-label"));
                    echo $this->Form->input("Promotion.promotion_date", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control datepicker", "type" => "text"));
                    ?>
                </div>
                <div class="form-group">
                    <?php
                    echo $this->Form->label("Promotion.no_sk_promotion", __("No. SK Kenaikan Jabatan"), array("class" => "col-sm-3 col-md-4 control-label"));
                    echo $this->Form->input("Promotion.no_sk_promotion", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control"));
                    ?>
                </div>
            </div>
        </div>
        <br/>
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
                                    echo $this->Form->input("Promotion.name", array("div" => false, "label" => false, "class" => "form-control typeahead-ajax1"));
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
                                echo $this->Form->input("Employee.nip", array("div" => array("class" => ""), "label" => false, "class" => "form-control", "disabled" => true, "id" => "nip1"));
                                ?>
                                <?php
                                echo $this->Form->input("Promotion.chief_id", array("type" => "hidden", "class" => "form-control"));
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Jabatan</td>
                            <td>:</td>
                            <td>
                                <?php
                                echo $this->Form->input("Office.name", array("div" => array("class" => ""), "label" => false, "class" => "form-control", "disabled" => true, "id" => "jabatan1"));
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Department</td>
                            <td>:</td>
                            <td>
                                <?php
                                echo $this->Form->input("Department.name", array("div" => array("class" => ""), "label" => false, "class" => "form-control", "disabled" => true, "id" => "bidang1"));
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
                <textarea rows="5" cols="5" class="form-control editor" name="data[Promotion][note]"></textarea>
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
            console.log(suggestion);
            $('#EmployeeNip').val(suggestion.nip);
            $('#OfficeName').val(suggestion.jabatan);
            $('#bidang').val(suggestion.department);
            $('#PromotionEmployeeId').val(suggestion.id);
            $('#previousOfficeID').val(suggestion.jabatan_id);
        });
    })
</script>

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
        $('input.typeahead-ajax1').typeahead({
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
        $('input.typeahead-ajax1').bind('typeahead:select', function (ev, suggestion) {
            console.log(suggestion);
            $('#nip1').val(suggestion.nip);
            $('#jabatan1').val(suggestion.jabatan);
            $('#PromotionChiefId').val(suggestion.id);
            $('#bidang1').val(suggestion.department);
        });
    })
</script>