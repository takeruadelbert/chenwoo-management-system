<?php echo $this->Form->create("OutgoingMail", array("class" => "form-horizontal form-separate", "type" => "file", "action" => "view", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#data-utama" data-toggle="tab"><i class="icon-envelop"></i> <?= __("Form Surat Keluar") ?></a></li>
        <li><a href="#data-berkas" data-toggle="tab"><i class="icon-file6"></i> <?= __("Data Berkas") ?></a></li>
        <li><a href="#Informasi" data-toggle="tab"><i class="icon-users"></i> <?= __("Informasi") ?></a></li>
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
                                echo $this->Form->label("OutgoingMail.mail_type_id", __("Jenis Surat"), array("class" => "col-md-4 control-label"));
                                echo $this->Form->input("OutgoingMail.mail_type_id", array("div" => array("class" => "col-md-8"), "label" => false, "class" => "form-control", "empty" => "- Pilih Jenis Surat -", "disabled" => true));
                                ?>
                            </div>
                            <div class="form-group">
                                <?php
                                echo $this->Form->label("OutgoingMail.mail_classification_id", __("Klasifikasi Surat"), array("class" => "col-md-4 control-label"));
                                echo $this->Form->input("OutgoingMail.mail_classification_id", array("div" => array("class" => "col-md-8"), "label" => false, "class" => "form-control", "empty" => "- Pilih Klasifikasi Surat -", "disabled" => true));
                                ?>
                            </div>
                            <div class="form-group">
                                <?php
                                echo $this->Form->label("OutgoingMail.mail_rack_id", __("Rak Surat"), array("class" => "col-md-4 control-label"));
                                echo $this->Form->input("OutgoingMail.mail_rack_id", array("div" => array("class" => "col-md-8"), "label" => false, "class" => "form-control", "empty" => "- Pilih Rak Surat -", "disabled" => true));
                                ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="panel-heading" style="background:#2179cc">
                                <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Referensi Surat Masuk") ?></h6>
                            </div>
                            <br/>
                            <div class="form-group">
                                <?php
                                echo $this->Form->label("IncomingMail.nomor_agenda", __("Nomor Agenda Surat"), array("class" => "col-md-4 control-label"));
                                ?>
                                <div class="col-sm-9 col-md-8">
                                    <div class="has-feedback">
                                        <?php
                                        echo $this->Form->input("", array("div" => false, "label" => false, "class" => "form-control typeahead2-ajax", "placeholder" => "Cari nomor agenda surat masuk", "value" => $this->data['Referensi']['nomor_agenda'] ,"disabled"));
                                        ?>
                                        <i class="icon-search3 form-control-feedback"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <?php
                                echo $this->Form->label("IncomingMail.nomor_surat", __("Nomor Surat Masuk"), array("class" => "col-md-4 control-label"));
                                echo $this->Form->input("IncomingMail.nomor_surat", array("div" => array("class" => "col-md-8"), "label" => false, "class" => "form-control", "value" => $this->data['Referensi']['nomor_surat'],"disabled"));
                                ?>
                                <?php
                                echo $this->Form->input("OutgoingMail.referensi_id", array("type" => "hidden", "class" => "form-control"));
                                ?>
                            </div>
                            <div class="form-group">
                                <?php
                                echo $this->Form->label("OutgoingMail.catatan", __("Catatan"), array("class" => "col-md-4 control-label"));
                                ?>
                                <div class="col-sm-8">
                                    <textarea rows="5" cols="5" class="limited form-control" placeholder="Limited to 100 characters" name="data[OutgoingMail][catatan]" disabled><?= $this->data['OutgoingMail']['catatan'] ?></textarea>
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
                                echo $this->Form->label("OutgoingMail.nomor_agenda", __("Nomor Agenda"), array("class" => "col-md-4 control-label"));
                                echo $this->Form->input("OutgoingMail.nomor_agenda", array("div" => array("class" => "col-md-8"), "label" => false, "class" => "form-control", "disabled", "placeholder" => "Akan dibuat setelah disimpan", "disabled" => true));
                                ?>
                            </div>
                            <div class="form-group">
                                <?php
                                echo $this->Form->label("OutgoingMail.dt", __("Tanggal Surat"), array("class" => "col-md-4 control-label"));
                                echo $this->Form->input("OutgoingMail.dt", array("div" => array("class" => "col-md-8"), "label" => false, "class" => "form-control datepicker", "type" => "text", "disabled" => true));
                                ?>
                            </div>
                            <div class="form-group">
                                <?php
                                echo $this->Form->label("OutgoingMail.nomor_surat", __("No. Surat Keluar"), array("class" => "col-md-4 control-label"));
                                echo $this->Form->input("OutgoingMail.nomor_surat", array("div" => array("class" => "col-md-8"), "label" => false, "class" => "form-control", "disabled" => true));
                                ?>
                            </div>
                            <div class="form-group">
                                <?php
                                echo $this->Form->label("OutgoingMail.pengirim", __("Pengirim"), array("class" => "col-md-4 control-label"));
                                echo $this->Form->input("OutgoingMail.pengirim", array("div" => array("class" => "col-md-8"), "label" => false, "class" => "form-control", "disabled" => true));
                                ?>
                            </div>
                            <div class="form-group">
                                <?php
                                echo $this->Form->label("OutgoingMail.tujuan", __("Tujuan"), array("class" => "col-md-4 control-label"));
                                echo $this->Form->input("OutgoingMail.tujuan", array("div" => array("class" => "col-md-8"), "label" => false, "class" => "form-control", "disabled" => true));
                                ?>
                            </div>
                            <div class="form-group">
                                <?php
                                echo $this->Form->label("OutgoingMail.lampiran", __("Lampiran"), array("class" => "col-md-4 control-label", "disabled" => true));
                                ?>
                                <div class="col-md-8">
                                    <?php
                                    if (!is_null($this->data["OutgoingMail"]["asset_file_id"])) {
                                        ?>
                                        <a href="<?= Router::url("/admin/asset_files/getfile/" . $this->data["AssetFile"]["id"] . "/" . $this->data["AssetFile"]["token"], true) ?>"><button type="button" class="btn btn-default btn-xs btn-icon tip" title="Download Lampiran"><i class="icon-download"></i></button></a>
                                        <?php
                                    } else {
                                        echo __("Tidak ada lampiran");
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <?php
                                echo $this->Form->label("OutgoingMail.perihal", __("Perihal"), array("class" => "col-md-4 control-label"));
                                echo $this->Form->input("OutgoingMail.perihal", array("div" => array("class" => "col-md-8"), "label" => false, "class" => "form-control", "disabled" => true));
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
                                echo $this->Form->input("OutgoingMail.ringkasan", array("div" => array("class" => "col-md-12"), "label" => false, "class" => "form-control ckeditor-fix", "disabled" => true));
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade in" id="data-berkas">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="block-inner text-danger">
                        <h6 class="heading-hr"><?= __("Data Berkas") ?>
                            <small class="display-block">Daftar Data Berkas Surat Keluar</small>
                        </h6>
                    </div>
                    <div class="table-responsive pre-scrollable stn-table">
                        <table width="100%" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th width="50" rowspan="2">No</th>
                                    <th><?= __("Nama File") ?></th>
                                    <th><?= __("Ektensi File") ?></th>
                                    <th><?= __("Tanggal Upload") ?></th>
                                    <th><?= __("Hit(s)") ?></th>
                                    <th width="100"><?= __("Aksi") ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $limit = intval(isset($this->params['named']['limit']) ? $this->params['named']['limit'] : 10);
                                $page = intval(isset($this->params['named']['page']) ? $this->params['named']['page'] : 1);
                                $i = ($limit * $page) - ($limit - 1);
                                if (empty($this->data['OutgoingMailFile'])) {
                                    ?>
                                    <tr>
                                        <td class = "text-center" colspan = 5>Tidak Ada Data</td>
                                    </tr>
                                    <?php
                                } else {
                                    foreach ($this->data['OutgoingMailFile'] as $item) {
                                        ?>
                                        <tr>
                                            <td class="text-center"><?= $i ?></td>
                                            <td class="text-center"><?= substr($item['AssetFile']['filename'], 0 , (strrpos($item['AssetFile']['filename'], "."))); ?></td>
                                            <td class="text-center"><?= "." . $item['AssetFile']['ext'] ?></td>
                                            <td class="text-center"><?= $this->Html->cvtTanggal($item['AssetFile']['modified']) ?></td>
                                            <td class="text-center"><?= $item['AssetFile']['hit'] ?></td>
                                            <td class="text-center">
                                                <a href="<?= Router::url("/admin/asset_files/getfile/" . $item['AssetFile']['id'] . "/" . $item['AssetFile']['token'], true) ?>"><button type="button" class="btn btn-default btn-xs btn-icon tip" title="Download Dokumen"><i class="icon-download"></i></button></a>
                                            </td>
                                        </tr>
                                        <?php
                                        $i++;
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade in" id="Informasi">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="block-inner text-danger">
                        <h6 class="heading-hr">INFORMASI<small class="display-block"></small></h6>
                    </div>
                    <div class="table-responsive">
                        <table width="100%" class="table table-bordered">
                            <tr>
                                <td colspan="3" align="center" bgcolor="#FFFFCC" style="width:200px"><strong>PEMBUATAN SURAT</strong></td>
                                <td width="1%" rowspan="4">&nbsp;</td>
                                <td colspan="3" align="center" bgcolor="#FFFFCC"><strong>PENYETUJUAN SURAT</strong></td>
                            </tr>
                            <tr>
                                <td width="20%" style="width:200px">Dibuat Pada Tanggal</td>
                                <td width="1%" align="center" style="width:10px">:</td>
                                <td width="25%"><?= $this->Html->cvtTanggal($this->data['OutgoingMail']['created'], false) ?></td>
                                <td width="20%">Disetujui Pada Tanggal</td>
                                <td width="1%" align="center">:</td>
                                <td width="25%"><?= !empty($this->data['OutgoingMail']['approver_id']) ? $this->Html->cvtHariTanggal($this->data['OutgoingMail']['status_action_dt'], false) : "" ?></td>
                            </tr>
                            <tr>
                                <td width="20%">Nama Pegawai</td>
                                <td width="1%" align="center">:</td>
                                <td width="25%"><?= $this->data['Creator']['Account']['Biodata']['full_name'] ?></td>
                                <td width="20%">Nama Pegawai</td>
                                <td width="1%" align="center">:</td>
                                <td width="25%"><?= !empty($this->data['OutgoingMail']['approver_id']) ? $this->data['Approver']['Account']['Biodata']['full_name'] : "" ?></td>
                            </tr>
                            <tr>
                                <td width="20%">NIP</td>
                                <td width="1%" align="center">:</td>
                                <td width="25%"><?= $this->data['Creator']['nip_baru'] ?></td>
                                <td>NIP</td>
                                <td align="center">:</td>
                                <td><?= !empty($this->data['OutgoingMail']['approver_id']) ? $this->data['Approver']['nip_baru'] : "" ?></td>
                            </tr>
                        </table>
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
            </div>
        </div>
    </div>
</div>
<?php echo $this->Form->end() ?>
<script type="x-tmpl-mustache" id="tmpl-input-berkas-hidden">
    <input type="hidden" name="data[OutgoingMailFile][{{n}}][asset_file_id]" value="{{value}}"/>
</script>
<script>
    $(document).ready(function () {
        var n = 0;
        $(".berkas-uploader").pluploadQueue({
            runtimes: 'html5, html4',
            url: '<?= Router::url("/admin/asset_files/upload_berkas_surat_keluar", true) ?>',
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
<style>
    select{
        padding: 11px 50px 11px 10px;
        background: rgba(255,255,255,1);
        border-radius: 7px;
        -webkit-border-radius: 7px;
        -moz-border-radius: 7px;
        border: 0;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        color: #8ba2d4;
    }
</style>