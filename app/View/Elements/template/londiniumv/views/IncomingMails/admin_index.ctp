<?php
echo $this->element(_TEMPLATE_DIR . "/{$template}/filter/incoming-mail");
?>
<div class="table-responsive">
    <table width="100%" class="table table-bordered">
        <div class="panel-heading" style="background:#2179cc">
            <h6 class="panel-title" style=" color:#fff"><i class="icon-stats"></i>Statistik </h6></span>
        </div>
        <tr>
            <td><strong><i class="icon-spam" style="color:red"></i>&nbsp;&nbsp;Belum Disetujui</strong></td>
            <td>:</td>
            <td><input type="text" value="<?= $summary['belum_disetujui'] ?>" disabled class="form-control"></td>
            <td><strong><i class="icon-checkmark3" style="color:green"></i>&nbsp;&nbsp;Disetujui</strong></td>
            <td>:</td>
            <td><input type="text" value="<?= $summary['disetujui'] ?>" disabled class="form-control"></td>
            <td><strong><i class="icon-sigma" style="color:green"></i>&nbsp;&nbsp;Total</strong></td>
            <td>:</td>
            <td><input type="text" value="<?= array_sum($summary) ?>" disabled class="form-control"></td>
        </tr>
        </tbody>
    </table>
</div>
<br/>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("DATA SURAT MASUK") ?>
                <div class="pull-right">
                    <?php
                    if ($roleAccess['edit']) {
                        ?>
                        <button class="btn btn-xs btn-default action-surat action-setujui" data-status-id="2" type="button" onclick="" disabled>
                            <i class="icon-checkmark-circle2" style="color:green"></i> 
                            <?= __("Disetujui") ?>
                        </button>&nbsp;
                    <?php } ?>
                    <button class="btn btn-xs btn-default action-surat action-ekspedisi" type="button" onclick="jumpTo(this)" disabled data-href="#">
                        <i class="icon-stack"></i> 
                        <?= __("Ekspedisi Surat") ?>
                    </button>&nbsp;
                    <button class="btn btn-xs btn-default action-surat action-korespondensi" type="button" onclick="jumpTo(this)" disabled data-href="#">
                        <i class="icon-archive"></i> 
                        <?= __("Korespondesi Surat") ?>
                    </button>&nbsp;
                    <?= $this->element(_TEMPLATE_DIR . "/{$template}/roleaccess/delete") ?>
                    <?php
                    if ($roleAccess['add']) {
                        ?>
                        <a href="<?= Router::url("/admin/{$this->params['controller']}/add", true) ?>">
                            <button class="btn btn-xs btn-default" type="button">
                                <i class="icon-envelop" style="color:red"></i>
                                <?= __("Buat Surat Masuk") ?>
                            </button>
                        </a>
                        <?php
                    }
                    ?>
                </div>
                <small class="display-block"><?= _APP_CORPORATE_FULL ?></small>
            </h6>
        </div>
        <div class="table-responsive pre-scrollable stn-table">
            <form id="checkboxForm" method="post" name="checkboxForm" action="<?php echo Router::url('/' . $this->params['prefix'] . '/' . $this->params['controller'] . '/multiple_delete', true); ?>">
                <table width="100%" class="table table-bordered">
                    <thead>
                        <tr>
                            <th width="50" rowspan="2"><input type="checkbox" class="styled checkall"/></th>
                            <th width="50" rowspan="2">No</th>
                            <th rowspan="2"><?= __("Tanggal") ?></th>
                            <th colspan="2"><?= __("Approval") ?></th>
                            <th colspan="5"><?= __("Detail Surat") ?></th>
                            <th colspan="2"><?= __("Keterangan") ?></th>
                            <th width="100" rowspan="2"><?= __("Aksi") ?></th>
                        </tr>
                        <tr>
                            <th width="100"><?= __("Status") ?></th>
                            <th><?= __("Tanggal") ?></th>
                            <th><?= __("No. Agenda") ?></th>
                            <th><?= __("No. Surat") ?></th>
                            <th><?= __("Tgl. Surat") ?></th>
                            <th><?= __("Pengirim") ?></th>
                            <th><?= __("Perihal") ?></th>
                            <th><?= __("Klasifikasi") ?></th>
                            <th><?= __("Sifat") ?></th>
                        </tr>
                    </thead>
                    <tbody class="action-target-search">
                        <?php
                        $limit = intval(isset($this->params['named']['limit']) ? $this->params['named']['limit'] : 10);
                        $page = intval(isset($this->params['named']['page']) ? $this->params['named']['page'] : 1);
                        $i = ($limit * $page) - ($limit - 1);
                        if (!empty($data['rows'])) {
                            foreach ($data['rows'] as $item) {
                                ?>
                                <tr id="row-<?= $i ?>" class="removeRow<?php echo $item[Inflector::classify($this->params['controller'])]['id']; ?> stn-selectable" 
                                    data-id="<?= $item[Inflector::classify($this->params['controller'])]['id']; ?>"
                                    data-status="<?= $item['MailStatus']['name'] ?>"
                                    data-status-id="<?= $item['IncomingMail']['mail_status_id'] ?>"
                                    data-penyetuju-nip="<?= !empty($item['IncomingMail']['approver_id']) ? $item['Approver']['nip_baru'] : "" ?>"
                                    data-penyetuju-nama="<?= !empty($item['IncomingMail']['approver_id']) ? $item['Approver']['Account']['Biodata']['full_name'] : "" ?>"
                                    data-penyetuju-tanggal="<?= $this->Html->cvtHariTanggal($item['IncomingMail']['status_action_dt'], false) ?>"
                                    >
                                    <td class="text-center"><input type="checkbox" name="data[<?php echo Inflector::classify($this->params['controller']) ?>][checkbox][]" value="<?php echo $item[Inflector::classify($this->params['controller'])]['id']; ?>"  id="checkBoxRow" class="styled checkboxDeleteRow" /></td>
                                    <td class="text-center"><?= $i ?></td>
                                    <td class="text-center"><?= $this->Html->cvtHariTanggal($item['IncomingMail']['created'], false) ?></td>
                                    <td class="text-center mail-status"><?= $item['MailStatus']['name'] ?></td>
                                    <td class="text-center mail-tanggal"><?= $this->Html->cvtHariTanggal($item['IncomingMail']['status_action_dt'], false) ?></td>
                                    <td class="text-center"><?= $item['IncomingMail']['nomor_agenda'] ?></td>
                                    <td class="text-center"><?= $item['IncomingMail']['nomor_surat'] ?></td>
                                    <td class="text-center"><?= $this->Html->cvtHariTanggal($item['IncomingMail']['dt'], false) ?></td>
                                    <td class="text-center"><?= $item['IncomingMail']['pengirim'] ?></td>
                                    <td class="text-center"><?= $item['IncomingMail']['perihal'] ?></td>
                                    <td class="text-center"><?= $item['MailClassification']['name'] ?></td>
                                    <td class="text-center"><?= $item['MailUrgency']['name'] ?></td>
                                    <td class="text-center">
                                        <a href="<?= Router::url("/admin/{$this->params['controller']}/view/{$item[Inflector::classify($this->params['controller'])]['id']}") ?>"><button type="button" class="btn btn-default btn-xs btn-icon tip" title="Detail"><i class="icon-file"></i></button></a>
                                        <?= $this->element(_TEMPLATE_DIR . "/{$template}/roleaccess/edit", ["editUrl" => Router::url("/admin/{$this->params['controller']}/edit/{$item[Inflector::classify($this->params['controller'])]['id']}")]) ?>
                                    </td>
                                </tr>
                                <?php
                                $i++;
                            }
                        } else {
                            ?>
                            <tr>
                                <td colspan="13" class="text-center">Tidak ada data.</td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </form>
        </div>
    </div>
    <?php echo $this->element(_TEMPLATE_DIR . "/{$template}/pagination") ?>
</div>
<div class="table-responsive">
    <table width="100%" align="center" class="table table-bordered">
        <div class="panel-heading" style="background:#2179cc">
            <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i>Detail Penyetujuan Surat </h6>
        </div>
        <tr>
            <td align="center"><strong>Status</strong></td>
            <td>:</td>
            <td align="center"><input id="target-status-surat" type="text" style="text-align:center" value="" disabled class="form-control" placeholder="status penyetujuan"></td>
            <td align="center"><strong>Pada Tanggal</strong></td>
            <td>:</td>
            <td align="center"><input id="target-tanggal" type="text" style="text-align:center" value="" disabled class="form-control" placeholder="tanggal penyetujuan"></td>
            <td align="center"><strong>Oleh</strong></td>
            <td>:</td>
            <td align="center"><input id="target-nip" type="text" style="text-align:center" value="" disabled class="form-control" placeholder="nip"></td>
            <td align="center"><input id="target-nama" type="text" style="text-align:center" value="" disabled class="form-control" placeholder="nama"></td>
        </tr>
        </tbody>
    </table>
</div>
<script>
    $(document).ready(function () {
        $("#edit").click(function () {
            $selectedRow = $(".action-target-search").find(".selected").first();
            var receiver = $("#target-ID").val();
            var seq = $("#target-seq").val();
            var status = $(".action-surat.action-setujui").data("status-id");
            $.ajax({
                url: BASE_URL + "admin/incoming_mails/change_status",
                data: {id: $selectedRow.data("id"), status: status, receiver: receiver},
                type: "PUT",
                dataType: "JSON",
                success: function (response) {
                    ajaxSuccessDefault(response, function () {
                        $selectedRow.find(".mail-status").html(response.data.status_label);
                        $selectedRow.find(".mail-tanggal").html(cvtHariTanggal(response.data.approver_tanggal));
                        $selectedRow.data("status-id", status);
                        $selectedRow.data("status", response.data.status_label);
                        $selectedRow.data("penyetuju-nip", response.data.approver_nip);
                        $selectedRow.data("penyetuju-nama", response.data.approver_name);
                        $selectedRow.data("penyetuju-tanggal", cvtHariTanggal(response.data.approver_tanggal));
                        reloadActionButton();
                        mailTips();
                    });
                },
                error: function () {
                    ajaxError();
                }
            })
        });
        $("#edit").click(function () {
            $selectedRow = $(".action-target-search").find(".selected").first();
            var memo = $("#target-memo").val();
            var regard = $("#target-regard").val();
            var department = $("#target-department-uniq-name").val();
            var employeeId = $("#target-id").val();
            var ccId = [];
            $(".cc-id").each(function () {
                ccId.push($(this).val());
            });
            $.ajax({
                url: BASE_URL + "admin/mailRecipients/disposisi_surat",
                data: {
                    id: $selectedRow.data("id"),
                    memo: memo,
                    regard: regard,
                    department: department,
                    employeeId: employeeId,
                    currentRecipientId: $selectedRow.data("mail-recipient-id"),
                    seq: 0,
                    ccId: ccId,
                },
                type: "PUT",
                dataType: "JSON",
                success: function (response) {
                    ajaxSuccessDefault(response, function () {
                        $selectedRow.data("dispositor_nip", response.data.dispositor_nip);
                        $selectedRow.data("dispositor_name", response.data.dispositor_name);
                        reloadActionButton();
                    });
                },
                error: function () {
                    ajaxError();
                }
            })
        });
        $(".stn-selectable").click(function () {
            $(".stn-selectable").removeClass("selected");
            $(this).addClass("selected");
            reloadActionButton();
            mailTips();
        });
        $(".action-surat.action-setujui,.action-surat.action-revisi").on("click", function () {
            $selectedRow = $(".action-target-search").find(".selected").first();
            var status = $(this).data("status-id");
            $("#modaldisposisisuratmasuk").modal("show");
        })
        $(".stn-selectable input[type=checkbox]").click(function (e) {
            e.stopPropagation();
        })


    })

    function reloadActionButton() {
        $selectedRow = $(".action-target-search").find(".selected").first();
        var mail_id = $selectedRow.data("id");
        $(".action-surat").attr("disabled", "disabled");
        switch ($selectedRow.data("status-id")) {
            case 1:
                $(".action-surat.action-setujui").removeAttr("disabled");
                $(".action-surat.action-revisi").removeAttr("disabled");
                $(".action-surat.action-korespondensi").removeAttr("disabled");
                $(".action-surat.action-korespondensi").data("href", BASE_URL + "admin/incoming_mails/korespondensi/" + mail_id);
                $(".action-surat.action-ekspedisi").removeAttr("disabled");
                $(".action-surat.action-ekspedisi").data("href", BASE_URL + "admin/incoming_mails/ekspedisi/" + mail_id);
                break;
            case 3:
                $(".action-surat.action-setujui").removeAttr("disabled");
                $(".action-surat.action-korespondensi").removeAttr("disabled");
                $(".action-surat.action-korespondensi").data("href", BASE_URL + "admin/incoming_mails/korespondensi/" + mail_id);
                $(".action-surat.action-ekspedisi").removeAttr("disabled");
                $(".action-surat.action-ekspedisi").data("href", BASE_URL + "admin/incoming_mails/ekspedisi/" + mail_id);
                break;
            case 2:
                $(".action-surat.action-korespondensi").removeAttr("disabled");
                $(".action-surat.action-korespondensi").data("href", BASE_URL + "admin/incoming_mails/korespondensi/" + mail_id);
                $(".action-surat.action-ekspedisi").removeAttr("disabled");
                $(".action-surat.action-ekspedisi").data("href", BASE_URL + "admin/incoming_mails/ekspedisi/" + mail_id);
                break;
        }
    }

    function mailTips() {
        $selectedRow = $(".action-target-search").find(".selected").first();
        $("#target-status-surat").val($selectedRow.data("status"));
        $("#target-nip").val($selectedRow.data("penyetuju-nip"));
        $("#target-nama").val($selectedRow.data("penyetuju-nama"));
        $("#target-tanggal").val($selectedRow.data("penyetuju-tanggal"));
    }

    function jumpTo(e) {
        var targetUrl = $(e).data("href");
        window.location.href = targetUrl;
    }
</script>
<?php
foreach ($data['rows'] as $item) {
    ?>
    <div id="modaldisposisisuratmasuk" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" >
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Disposisi Surat</h4>
                </div>
                <div class="modal-body" style="height:720px;overflow-y: auto">
                    <form id="form-disposisi">
                        <div class="tabbable page-tabs">
                            <ul class="nav nav-tabs" style="margin-bottom:0">
                                <li class="active"><a href="#data-penerima" data-toggle="tab"><i class="icon-user"></i> <?= __("Data Penerima") ?></a></li>
                                <li><a href="#data-tembusan" data-toggle="tab"><i class="icon-users"></i> <?= __("Data Tembusan") ?></a></li>
                                <li><a href="#data-berkas" data-toggle="tab"><i class="icon-file6"></i> <?= __("Data Berkas") ?></a></li>
                                <li><a href="#riwayat-disposisi" data-toggle="tab"><i class="icon-stack"></i> <?= __("Riwayat Disposisi") ?></a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active fade in" id="data-penerima">
                                    <div class="panel">
                                        <div class="panel-body">
                                            <div class="form-horizontal">
                                                <div class="block-inner text-danger">
                                                    <h6 class="heading-hr">Data Penerima</h6>
                                                </div>
                                                <div class="row">
                                                    <div class=" col-md-4 control-label">
                                                        <label>Cari Nama Pegawai</label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <input type="text" class="form-control" id="penerima"/>
                                                    </div>
                                                </div>
                                                <br/>
                                                <div class="row">
                                                    <div class=" col-md-4 control-label">
                                                        <label>Jabatan</label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <input type="text" class="form-control" disabled id="target-jabatan"/>
                                                    </div>
                                                </div>
                                                <br/>
                                                <div class="row">
                                                    <div class=" col-md-4 control-label">
                                                        <label>Dengan Hormat Harap</label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <input type="text" class="form-control" id="target-regard"/>
                                                    </div>
                                                </div>
                                                <br/>
                                                <div class="row">
                                                    <?php
                                                    echo $this->Form->label("MailDisposition.memo", __("Catatan"), array("class" => "col-md-4 control-label"));
                                                    ?>
                                                    <input type="hidden" id="target-department-uniq-name" disabled/>
                                                    <input type="hidden" id="target-id" disabled name="MailRecipient.employee_id"/>
                                                    <div class="col-sm-8">
                                                        <textarea rows="5" cols="5" class="limited form-control" id="target-memo" placeholder="100 Karakter"></textarea>
                                                        <span class="help-block" id="limit-text">Dibatasi 100 karakter</span>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class=" col-md-4 control-label">
                                                        <label>Lampiran</label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <?php
                                                        if (!is_null($item["IncomingMail"]["asset_file_id"])) {
                                                            ?>
                                                            <a href="<?= Router::url("/admin/asset_files/getfile/" . $item["AssetFile"]["id"] . "/" . $item["AssetFile"]["token"], true) ?>"><button type="button" class="btn btn-default btn-xs btn-icon tip" title="Download Lampiran"><i class="icon-download"></i></button></a>
                                                            <?php
                                                        } else {
                                                            echo __("Tidak ada lampiran");
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>   
                                </div>
                                <div class="tab-pane fade in" id="data-tembusan">
                                    <div class="panel">
                                        <div class="panel-body">
                                            <div class="block-inner text-danger">
                                                <h6 class="heading-hr">Data Tembusan</h6>
                                            </div>
                                            <div class="table-responsive stn-table">
                                                <table width="100%" class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th width="50">No</th>
                                                            <th><?= __("Nama") ?></th>
                                                            <th><?= __("Nip") ?></th>
                                                            <th><?= __("Jabatan") ?></th>
                                                            <th><?= __("Department") ?></th>
                                                            <th><?= __("Aksi") ?></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="target-tembusan">
                                                        <tr>
                                                            <td colspan="6">
                                                                <a class="text-success" href="javascript:void(false)" onclick="addThisRow($(this), 'tembusan')" data-n="1"><i class="icon-plus-circle"></i></a>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade in" id="data-berkas">
                                    <div class="panel">
                                        <div class="panel-body">
                                            <div class="block-inner text-danger">
                                                <h6 class="heading-hr"><?= __("Data Berkas") ?>
                                                </h6>
                                            </div>
                                            <div class="table-responsive stn-table">
                                                <table width="100%" class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th width="50">No</th>
                                                            <th><?= __("Nama File") ?></th>
                                                            <th><?= __("Ektensi File") ?></th>
                                                            <th><?= __("Tanggal Upload") ?></th>
                                                            <th><?= __("Hit(s)") ?></th>
                                                            <th width="100"><?= __("Aksi") ?></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="target-data-berkas">
                                                        <?php
                                                        $i = 0;
                                                        if (empty($item['IncomingMail'])) {
                                                            ?>
                                                            <tr>
                                                                <td colspan="6">
                                                                    Tidak Ada Data
                                                                </td>
                                                            </tr>
                                                            <?php
                                                        } else {
                                                            foreach ($item['IncomingMailFile'] as $file) {
                                                                ?>
                                                                <tr>
                                                                    <td class="text-center"><?= $i ?></td>
                                                                    <td class="text-center"><?= substr($file['AssetFile']['filename'], 0, (strrpos($file['AssetFile']['filename'], "."))); ?></td>
                                                                    <td class="text-center"><?= "." . $file['AssetFile']['ext'] ?></td>
                                                                    <td class="text-center"><?= $this->Html->cvtTanggal($file['AssetFile']['modified']) ?></td>
                                                                    <td class="text-center"><?= $file['AssetFile']['hit'] ?></td>
                                                                    <td class="text-center">
                                                                        <a href="<?= Router::url("/admin/asset_files/getfile/" . $file['AssetFile']['id'] . "/" . $file['AssetFile']['token'], true) ?>"><button type="button" class="btn btn-default btn-xs btn-icon tip" title="Download Dokumen"><i class="icon-download"></i></button></a>
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
                                <div class="tab-pane fade in" id="riwayat-disposisi">
                                    <div class="panel">
                                        <div class="panel-body">
                                            <div class="block-inner text-danger">
                                                <h6 class="heading-hr"><?= __("Riwayat Disposisi") ?>
                                                </h6>
                                            </div>
                                            <div class="table-responsive stn-table">
                                                <table width="100%" class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th width="238" rowspan="2" align="center" valign="middle" bgcolor="#FFFFCC" style=" text-align:center">TANGGAL</th>
                                                            <th colspan="3" align="center" valign="middle" bgcolor="#FFFFCC" style=" text-align:center">PENERIMA</th>
                                                            <th colspan="2" align="center" valign="middle" bgcolor="#FFFFCC" style=" text-align:center">PENGIRIM</th>
                                                        </tr>
                                                        <tr>
                                                            <th width="173" align="center" valign="middle" bgcolor="#FFFFCC" style=" text-align:center">NIP</th>
                                                            <th width="173" align="center" valign="middle" bgcolor="#FFFFCC" style=" text-align:center">NAMA</th>
                                                            <th width="182" align="center" valign="middle" bgcolor="#FFFFCC" style=" text-align:center">STATUS</th>
                                                            <th width="173" align="center" valign="middle" bgcolor="#FFFFCC" style=" text-align:center">NIP</th>
                                                            <th width="149" align="center" valign="middle" bgcolor="#FFFFCC" style=" text-align:center">NAMA</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="target-riwayat-disposisi">
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?= __("Tutup") ?></button>
                    <button type="button" class="btn btn-success" data-dismiss="modal" id="edit"><?= __("Disposisi") ?></button>
                </div>
            </div>
        </div>
    </div>
    <?php
}
?>
<script>
    var employeesPrio = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('full_name'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        prefetch: '<?= Router::url("/admin/employees/listprio", true) ?>',
        remote: {
            url: '<?= Router::url("/admin/employees/listprio", true) ?>' + '?q=%QUERY',
            wildcard: '%QUERY',
        }
    });
    employeesPrio.initialize();
    employeesPrio.clear();
    employeesPrio.clearPrefetchCache();
    employeesPrio.clearRemoteCache();
    $(document).ready(function () {
        bindTypeahead($("#penerima"));
    })
    function bindTypeahead(e) {
        e.typeahead({
            hint: false,
            highlight: true
        }, {
            name: 'employees',
            display: 'full_name',
            source: employeesPrio.ttAdapter(),
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
            $("#target-id").val(suggestion.id);
            $("#target-jabatan").val(suggestion.jabatan);
            $("#target-department-uniq-name").val(suggestion.department_uniq_name);
        });
    }
</script>
<script type="template" id="tmpl-data-tembusan">
    {{#ccs}}
    <tr>
    <td class="text-center nomorIdx">0</td>
    <td>{{nip}}</td>
    <td>{{nama}}</td>
    <td>{{bidang}}</td>
    <td>{{jabatan}}</td>
    <td></td>
    </tr>
    {{/ccs}}
</script>
<script type="x-tmpl-mustache" id="tmpl-tembusan">
    <tr>
    <td class="text-center nomorIdx">
    {{i}}
    </td>
    <td>
    <input type="hidden" name="data[IncomingMailCarbonCopy][{{n}}][employee_id]" id="IncomingMailCarbonCopy{{n}}EmployeeId" class="target-value cc-id">      
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
    <td class="text-center">
    <a href="javascript:void(false)" onclick="deleteThisRow($(this))"><i class="icon-remove3"></i></a>
    </td>
    </tr>
</script>
<script type="x-tmpl-mustache" id="tmpl-data-berkas">
    {{#berkas}}
    <tr>
    <td class="text-center nomorIdx">0</td>
    <td>{{nama}}</td>
    <td>{{ektensi}}</td>
    <td>{{dt}}</td>
    <td>{{hit}}</td>
    <td>
    <a href="{{href}}"><button type="button" class="btn btn-default btn-xs btn-icon tip" title="Download Dokumen"><i class="icon-download"></i></button></a>
    </td>
    </tr>
    {{/berkas}}
    {{^berkas}}
    <tr>
    <td class = "text-center" colspan = 6>Tidak Ada Data</td>
    </tr>
    {{/berkas}}
</script>
<script type="x-tmpl-mustache" id="tmpl-riwayat-disposisi">
    {{#riwayat}}
    <tr>
    <td valign="middle" style=" text-align:center">{{dt}}</td>
    <td valign="middle" style=" text-align:center">{{nipPenerima}}</td>
    <td valign="middle" style=" text-align:center">{{namaPenerima}}</td>
    <td valign="middle" style=" text-align:center">
    {{#statusBaca}}
    <i class="icon-bubble-check" style="color:green"></i>&nbsp;Sudah Dibaca
    {{/statusBaca}}
    {{^statusBaca}}
    <i class="icon-bubble-blocked" style="color:red"></i>&nbsp;Belum Dibaca  
    {{/statusBaca}}
    </td>
    <td valign="middle" style=" text-align:center">{{nipDispositor}}</td>
    <td valign="middle" style=" text-align:center">{{namaDispositor}}</td>

    </tr>
    {{/riwayat}}
    {{^riwayat}}
    <tr>
    <td class = "text-center" colspan = 6>Tidak Ada Data</td>
    </tr>
    {{/riwayat}}
</script>
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
    employees.initialize();
    $(document).ready(function () {
        bindTypeahead2($("input.typeahead-ajax"));
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
            bindTypeahead2($(this));
        })
    }
    function fixNumber(e) {
        var i = 1;
        $.each(e.find("tr"), function () {
            $(this).find(".nomorIdx").html(i);
            i++;
        })
    }
    function bindTypeahead2(e) {

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