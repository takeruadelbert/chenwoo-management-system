<?php echo $this->Form->create("IncomingMail", array("class" => "form-horizontal form-separate", "type" => "file", "action" => "add", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#data-utama" data-toggle="tab"><i class="icon-envelop"></i> <?= __("Form Surat Masuk") ?></a></li>
        <li><a href="#data-berkas" data-toggle="tab"><i class="icon-file6"></i> <?= __("Data Berkas") ?></a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active fade in" id="data-utama">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="block-inner text-danger">
                        <h6 class="heading-hr"><?= __("Data Utama") ?>
                            <small class="display-block">Mohon Isikan Form Tambah Data Surat Masuk Dengan Sesuai dan Benar</small>
                        </h6>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="panel-heading" style="background:#2179cc">
                                <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Atribut Surat") ?></h6>
                            </div>
                            <br/>
                            <div class="form-group">
                                <?php
                                echo $this->Form->label("IncomingMail.mail_type_id", __("Jenis Surat"), array("class" => "col-md-4 control-label"));
                                echo $this->Form->input("IncomingMail.mail_type_id", array("div" => array("class" => "col-md-8"), "label" => false, "class" => "select-full", "empty" => "", "placeholder" => "- Pilih Jenis Surat -"));
                                ?>
                            </div>
                            <div class="form-group">
                                <?php
                                echo $this->Form->label("IncomingMail.mail_classification_id", __("Klasifikasi Surat"), array("class" => "col-md-4 control-label"));
                                echo $this->Form->input("IncomingMail.mail_classification_id", array("div" => array("class" => "col-md-8"), "label" => false, "class" => "select-full", "empty" => "", "placeholder" => "- Pilih Klasifikasi Surat -"));
                                ?>
                            </div>
                            <div class="form-group">
                                <?php
                                echo $this->Form->label("IncomingMail.mail_urgency_id", __("Sifat Surat"), array("class" => "col-md-4 control-label"));
                                echo $this->Form->input("IncomingMail.mail_urgency_id", array("div" => array("class" => "col-md-8"), "label" => false, "class" => "select-full", "empty" => "", "placeholder" => "- Pilih Sifat Surat -"));
                                ?>
                            </div>
                            <div class="form-group">
                                <?php
                                echo $this->Form->label("IncomingMail.mail_origin_id", __("Asal Surat"), array("class" => "col-md-4 control-label"));
                                echo $this->Form->input("IncomingMail.mail_origin_id", array("div" => array("class" => "col-md-8"), "label" => false, "class" => "select-full", "empty" => "", "placeholder" => "- Pilih Asal Surat -"));
                                ?>
                            </div>
                            <div class="form-group">
                                <?php
                                echo $this->Form->label("IncomingMail.mail_rack_id", __("Rak Surat"), array("class" => "col-md-4 control-label"));
                                echo $this->Form->input("IncomingMail.mail_rack_id", array("div" => array("class" => "col-md-8"), "label" => false, "class" => "select-full", "empty" => "", "placeholder" => "- Pilih Rak Surat -"));
                                ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="panel-heading" style="background:#2179cc">
                                <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Korespondensi Surat Keluar") ?></h6>
                            </div>
                            <br/>
                            <div class="form-group">
                                <?php
                                echo $this->Form->label("IncomingMail.nomor_agenda", __("Nomor Agenda Surat"), array("class" => "col-md-4 control-label"));
                                ?>
                                <div class="col-sm-9 col-md-8">
                                    <div class="has-feedback">
                                        <?php
                                        echo $this->Form->input("", array("div" => false, "label" => false, "class" => "form-control typeahead2-ajax", "placeholder" => "Cari nomor agenda surat keluar"));
                                        ?>
                                        <i class="icon-search3 form-control-feedback"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <?php
                                echo $this->Form->label("OutgoingMail.nomor_surat", __("Nomor Surat Keluar"), array("class" => "col-md-4 control-label"));
                                echo $this->Form->input("OutgoingMail.nomor_surat", array("div" => array("class" => "col-md-8"), "label" => false, "class" => "form-control", "disabled"));
                                ?>
                                <?php
                                echo $this->Form->input("IncomingMail.korespondensi_id", array("type" => "hidden", "class" => "form-control"));
                                ?>
                            </div>
                            <div class="form-group">
                                <?php
                                echo $this->Form->label("IncomingMail.catatan", __("Catatan"), array("class" => "col-md-4 control-label"));
                                ?>
                                <div class="col-sm-8">
                                    <textarea rows="5" cols="5" class="limited form-control" placeholder="Limited to 100 characters" name="data[IncomingMail][catatan]"></textarea>
                                    <span class="help-block" id="limit-text">Field limited to 100 characters.</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="panel-heading" style="background:#2179cc">
                                <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Detail Surat") ?></h6>
                            </div>
                            <br/>
                            <div class="form-group">
                                <?php
                                echo $this->Form->label("IncomingMail.nomor_agenda", __("Nomor Agenda"), array("class" => "col-md-4 control-label"));
                                echo $this->Form->input("IncomingMail.nomor_agenda", array("div" => array("class" => "col-md-8"), "label" => false, "class" => "form-control", "disabled", "placeholder" => "Akan dibuat setelah disimpan"));
                                ?>
                            </div>
                            <div class="form-group">
                                <?php
                                echo $this->Form->label("IncomingMail.dt", __("Tanggal Surat"), array("class" => "col-md-4 control-label"));
                                echo $this->Form->input("IncomingMail.dt", array("div" => array("class" => "col-md-8"), "label" => false, "class" => "form-control datepicker", "type" => "text"));
                                ?>
                            </div>
                            <div class="form-group">
                                <?php
                                echo $this->Form->label("IncomingMail.nomor_surat", __("No. Surat Masuk"), array("class" => "col-md-4 control-label"));
                                echo $this->Form->input("IncomingMail.nomor_surat", array("div" => array("class" => "col-md-8"), "label" => false, "class" => "form-control"));
                                ?>
                            </div>
                            <div class="form-group">
                                <?php
                                echo $this->Form->label("IncomingMail.pengirim", __("Pengirim"), array("class" => "col-md-4 control-label"));
                                echo $this->Form->input("IncomingMail.pengirim", array("div" => array("class" => "col-md-8"), "label" => false, "class" => "form-control"));
                                ?>
                            </div>
                            <div class="form-group">
                                <?php
                                echo $this->Form->label("IncomingMail.tujuan", __("Tujuan"), array("class" => "col-md-4 control-label"));
                                echo $this->Form->input("IncomingMail.tujuan", array("div" => array("class" => "col-md-8"), "label" => false, "class" => "form-control"));
                                ?>
                            </div>
                            <div class="form-group">
                                <?php
                                echo $this->Form->label("IncomingMail.lampiran", __("Lampiran"), array("class" => "col-md-4 control-label"));
                                ?>
                                <div class="col-md-8">
                                    <?php
                                    echo $this->Form->input("IncomingMail.lampiran", array("div" => false, "label" => false, "class" => "form-control styled", "type" => "file"));
                                    ?>
                                    <span class="help-block">Format File Hanya Bisa: gif, png, jpg. Dengan Ukuran File Maksimal 2Mb</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <?php
                                echo $this->Form->label("IncomingMail.perihal", __("Perihal"), array("class" => "col-md-4 control-label"));
                                echo $this->Form->input("IncomingMail.perihal", array("div" => array("class" => "col-md-8"), "label" => false, "class" => "form-control"));
                                ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="panel-heading" style="background:#2179cc">
                                <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Ringkasan Surat") ?></h6>
                            </div>
                            <br/>
                            <div class="form-group">
                                <?php
                                echo $this->Form->input("IncomingMail.ringkasan", array("div" => array("class" => "col-md-12"), "label" => false, "class" => "form-control ckeditor-fix"));
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade in" id="data-penerima">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="block-inner text-danger">
                        <h6 class="heading-hr"><?= __("Penerima") ?>
                            <small class="display-block">Mohon Isikan Data Penerima Surat Masuk dengan Sesuai dan Benar</small>
                        </h6>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered stn-table" width="100%">
                            <thead>
                                <tr>
                                    <th width="40">No</th>
                                    <th>Nama</th>
                                    <th>NIP</th>
                                    <th>Department</th>
                                    <th>Jabatan</th>
                                    <th>Eselon</th>
                                    <th width="40">Aksi</th>
                                </tr>
                            <thead>
                            <tbody id="target-penerima">
                                <tr>
                                    <td colspan="7">
                                        <a class="text-success" href="javascript:void(false)" onclick="addThisRow($(this), 'penerima')" data-n="1"><i class="icon-plus-circle"></i></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade in" id="data-berkas">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="block-inner text-danger">
                        <h6 class="heading-hr">DATA BERKAS SURAT MASUK<small class="display-block"></small></h6>
                    </div>
                    <div class="block">	
                        <div class="berkas-uploader">Browser anda tidak mensupport native uploader.</div>
                    </div>
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
    $(document).ready(function () {
        bindTypeahead($("input.typeahead-ajax"));
    })
    function deleteThisRow(e) {
        var tbody = $(e).parents("tbody");
        e.parents("tr").remove();
        fixNumber(tbody);
    }
    function addThisRow(e, t, optFunc) {
        var n = $(e).data("n");
        var template = $('#tmpl-' + t).html();
        Mustache.parse(template);
        var options = {i: 2, n: n};
        if (typeof (optFunc) !== 'undefined') {
            $.extend(options, window[optFunc]());
        }
        var rendered = Mustache.render(template, options);
        $('#target-' + t + " tr:last").before(rendered);
        $(e).data("n", n + 1);
        reloadDatePicker();
        fixNumber($(e).parents("tbody"));
        var $es = $(e).parents("tbody").find(".target-typeahead-ajax")
        $.each($es, function () {
            $(this).removeClass("target-typeahead-ajax");
            bindTypeahead($(this));
        })
    }
    function fixNumber(e) {
        var i = 1;
        $.each(e.find("tr"), function () {
            $(this).find(".nomorIdx").html(i);
            i++;
        })
    }
    function bindTypeahead(e) {

        e.typeahead({
            hint: false,
            highlight: true
        }, {
            name: 'employees',
            display: 'full_name',
            source: employees.ttAdapter(),
            templates: {
                header: '<center><h5>Data Pegawai</h5></center><hr>',
                suggestion: function (context) {
                    return '<p>Nama : ' + context.full_name + '<br>NIP : ' + context.nip + '<br>Eselon : ' + context.eselon + '<br>Jabatan : ' + context.jabatan + '<br>Department : ' + context.department + '</p>';
                },
                empty: [
                    "<center><h5>Data Pegawai</h5></center> <hr> <center><p>Hasil pencarian Anda tidak dapat ditemukan<p></center>",
                ],
            }
        });
        e.bind('typeahead:select', function (ev, suggestion) {
            $(this).parent().siblings(".target-value").val(suggestion.id);
            $(this).parents("tr").find(".dummynip").val(suggestion.nip);
            $(this).parents("tr").find(".dummybidang").val(suggestion.department);
            $(this).parents("tr").find(".dummyjabatan").val(suggestion.jabatan);
            $(this).parents("tr").find(".dummyeselon").val(suggestion.eselon);
        });
    }
</script>
<script type="x-tmpl-mustache" id="tmpl-penerima">
    <tr>
    <td class="text-center nomorIdx">
    {{i}}
    </td>
    <td>
    <input type="hidden" name="data[MailRecipient][{{n}}][employee_id]" id="MailRecipient{{n}}EmployeeId" class="target-value">      
    <input name="data[DummyMR][{{n}}][name]" class="form-control target-typeahead-ajax " placeholder="Cari Nama Pegawai" type="text" id="DummyMR{{n}}Name"> 
    </td>
    <td>
    <input name="data[DummyMR][{{n}}][nip]" class="form-control dummynip" type="text" disabled="disabled" id="DummyMR{{n}}Nip">                                    
    </td>
    <td>
    <input name="data[DummyMR][{{n}}][bidang]" class="form-control dummybidang" type="text" disabled="disabled" id="DummyMR{{n}}Department">                                    
    </td>
    <td>
    <input name="data[DummyMR][{{n}}][jabatan]" class="form-control dummyjabatan" type="text" disabled="disabled" id="DummyMR{{n}}Jabatan">                                   
    </td>
    <td>
    <input name="data[DummyMR][{{n}}][eselon]" class="form-control dummyeselon" type="text" disabled="disabled" id="DummyMR{{n}}Eselon">                                    
    </td>
    <td class="text-center">
    <a href="javascript:void(false)" onclick="deleteThisRow($(this))"><i class="icon-remove3"></i></a>
    </td>
    </tr>
</script>
<script type="x-tmpl-mustache" id="tmpl-input-berkas-hidden">
    <input type="hidden" name="data[IncomingMailFile][{{n}}][asset_file_id]" value="{{value}}"/>
</script>
<script>
    $(document).ready(function () {
        var n = 0;
        $(".berkas-uploader").pluploadQueue({
            runtimes: 'html5, html4',
            url: '<?= Router::url("/admin/asset_files/upload_berkas_surat_masuk", true) ?>',
            chunk_size: '1mb',
            unique_names: false,
            filters: {
                max_file_size: '10mb',
                mime_types: [
                    {title: "Image files", extensions: "jpg,jpeg,png,pdf,doc,docx"},
                ]
            },
            file_data_name: "data[fileberkas]",
            init: {
                FileUploaded: function (up, file, info) {
                    var response = JSON.parse(info.response);
                    console.log(response);
                    switch (response.status) {
                        case 206:
                            var template = $('#tmpl-input-berkas-hidden').html();
                            Mustache.parse(template);
                            var rendered = Mustache.render(template, {value: response.data.asset_file_id, n: n});
                            $('#data-berkas').append(rendered);
                            n++;
                            break;
                        case 405:
                            break;
                    }
                },
            }
        });
    })
</script>

<script>
    $(document).ready(function () {
        var outgoing_mails = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('nomor_agenda'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            prefetch: '<?= Router::url("/admin/outgoingMails/list", true) ?>',
            remote: {
                url: '<?= Router::url("/admin/outgoingMails/list", true) ?>' + '?q=%QUERY',
                wildcard: '%QUERY',
            }
        });
        outgoing_mails.initialize();
        $('input.typeahead2-ajax').typeahead({
            hint: false,
            highlight: true
        }, {
            name: 'outgoing_mails',
            display: 'nomor_agenda',
            source: outgoing_mails.ttAdapter(),
            templates: {
                header: '<center><h5>Data Surat Keluar</h5></center><hr>',
                suggestion: function (context) {
                    console.log(context);
                    return '<p>Nomor Agenda : ' + context.nomor_agenda + '<br>Nomor Surat : ' + context.nomor_surat + '<br>Pengirim : ' + context.pengirim + '<br>Perihal : ' + context.perihal + '</p>';
                },
            }
        });
        $('input.typeahead2-ajax').bind('typeahead:select', function (ev, suggestion) {
            console.log(suggestion);
            $('#OutgoingMailNomorSurat').val(suggestion.nomor_surat);
            $('#IncomingMailKorespondensiId').val(suggestion.id);
        });
    })
</script>