<?php
echo $this->element(_TEMPLATE_DIR . "/{$template}/filter/outgoing-mail");
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
            <td><strong><i class="icon-pencil4" style="color:green"></i>&nbsp;&nbsp;Revisi</strong></td>
            <td>:</td>
            <td><input type="text" value="<?= $summary['revisi'] ?>" disabled class="form-control"></td>
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
            <h6 class="heading-hr"><?= __("DATA SURAT KELUAR") ?>
                <div class="pull-right">
                    <?php
                    if ($roleAccess['edit']) {
                        ?>
                        <button class="btn btn-xs btn-default action-surat action-setujui" data-status-id="2" type="button" onclick="" disabled>
                            <i class="icon-checkmark-circle2" style="color:green"></i> 
                            <?= __("Disetujui") ?>
                        </button>&nbsp;
                        <button class="btn btn-xs btn-default action-surat action-revisi" data-status-id="3" type="button" onclick="" disabled>
                            <i class="icon-notification" style="color:red"></i> 
                            <?= __("Revisi") ?>
                        </button>&nbsp;
                        <?php
                    }
                    ?>
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
                                <?= __("Buat Surat Keluar") ?>
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
                            <th><?= __("Tujuan") ?></th>
                            <th><?= __("Perihal") ?></th>
                            <th><?= __("Jenis Surat") ?></th>
                            <th><?= __("Klasifikasi Surat") ?></th>
                        </tr>
                    </thead>
                    <tbody class="action-target-search">
                        <?php
                        $limit = intval(isset($this->params['named']['limit']) ? $this->params['named']['limit'] : 10);
                        $page = intval(isset($this->params['named']['page']) ? $this->params['named']['page'] : 1);
                        $i = ($limit * $page) - ($limit - 1);
                        $status = "";
                        if (!empty($data['rows'])) {
                            foreach ($data['rows'] as $item) {
                                if (!empty($item['OutgoingMail']['mail_status_id'])) {
                                    if ($item['OutgoingMail']['mail_status_id'] == 1) {
                                        $status = "Belum Disetujui";
                                    } else if ($item['OutgoingMail']['mail_status_id'] == 2) {
                                        $status = "Sudah Disetujui";
                                    } else if ($item['OutgoingMail']['mail_status_id'] == 3) {
                                        $status = "Revisi";
                                    } else {
                                        $status = "Ditolak";
                                    }
                                } else {
                                    $status = "";
                                }
                                ?>
                                <tr id="row-<?= $i ?>" class="removeRow<?php echo $item[Inflector::classify($this->params['controller'])]['id']; ?> stn-selectable" 
                                    data-id="<?= $item[Inflector::classify($this->params['controller'])]['id']; ?>"
                                    data-status="<?= $item['MailStatus']['name'] ?>"
                                    data-status-id="<?= $item['OutgoingMail']['mail_status_id'] ?>"
                                    data-penyetuju-nip="<?= !empty($item['OutgoingMail']['approver_id']) ? $item['Approver']['nip_baru'] : "" ?>"
                                    data-penyetuju-nama="<?= !empty($item['OutgoingMail']['approver_id']) ? $item['Approver']['Account']['Biodata']['full_name'] : "" ?>"
                                    data-penyetuju-tanggal="<?= $this->Html->cvtHariTanggal($item['OutgoingMail']['status_action_dt'], false) ?>"
                                    title="<?= $status ?>"
                                    >
                                    <td class="text-center"><input type="checkbox" name="data[<?php echo Inflector::classify($this->params['controller']) ?>][checkbox][]" value="<?php echo $item[Inflector::classify($this->params['controller'])]['id']; ?>"  id="checkBoxRow" class="styled checkboxDeleteRow" /></td>
                                    <td class="text-center"><?= $i ?></td>
                                    <td class="text-center"><?= $this->Html->cvtHariTanggal($item['OutgoingMail']['created'], false) ?></td>
                                    <td class="text-center mail-status"><?= $item['MailStatus']['name'] ?></td>
                                    <td class="text-center mail-tanggal"><?= $this->Html->cvtHariTanggal($item['OutgoingMail']['status_action_dt'], false) ?></td>
                                    <td class="text-center"><?= $item['OutgoingMail']['nomor_agenda'] ?></td>
                                    <td class="text-center"><?= $item['OutgoingMail']['nomor_surat'] ?></td>
                                    <td class="text-center"><?= $this->Html->cvtHariTanggal($item['OutgoingMail']['dt'], false) ?></td>
                                    <td class="text-center"><?= $item['OutgoingMail']['tujuan'] ?></td>
                                    <td class="text-center"><?= $item['OutgoingMail']['perihal'] ?></td>
                                    <td class="text-center"><?= $item['MailType']['name'] ?></td>
                                    <td class="text-center"><?= $item['MailClassification']['name'] ?></td>
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
        $(".stn-selectable").click(function () {
            $(".stn-selectable").removeClass("selected");
            $(this).addClass("selected");
            reloadActionButton();
            mailTips();
        });
        $(".action-surat.action-revisi").on("click", function () {
            $selectedRow = $(".action-target-search").find(".selected").first();
            var status = $(this).data("status-id");
            $("#modalRevisiSuratKeluar").modal("show");
        })
        $("#revisi").on("click", function () {
            $selectedRow = $(".action-target-search").find(".selected").first();
            var status = $(".action-surat.action-revisi").data("status-id");
            var memo = $("#target-memo").val();
            $.ajax({
                url: BASE_URL + "admin/outgoing_mails/change_status",
                data: {id: $selectedRow.data("id"), status: status, memo: memo},
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
        })
        $(".action-surat.action-setujui").on("click", function () {
            $selectedRow = $(".action-target-search").find(".selected").first();
            var status = $(this).data("status-id");
            $.ajax({
                url: BASE_URL + "admin/outgoing_mails/change_status",
                data: {id: $selectedRow.data("id"), status: status},
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
                $(".action-surat.action-korespondensi").data("href", BASE_URL + "admin/outgoing_mails/korespondensi/" + mail_id);
                $(".action-surat.action-ekspedisi").removeAttr("disabled");
                break;
            case 3:
                $(".action-surat.action-setujui").removeAttr("disabled");
                $(".action-surat.action-korespondensi").removeAttr("disabled");
                $(".action-surat.action-korespondensi").data("href", BASE_URL + "admin/outgoing_mails/korespondensi/" + mail_id);
                $(".action-surat.action-ekspedisi").removeAttr("disabled");
                break;
            case 2:
                $(".action-surat.action-korespondensi").removeAttr("disabled");
                $(".action-surat.action-korespondensi").data("href", BASE_URL + "admin/outgoing_mails/korespondensi/" + mail_id);
                $(".action-surat.action-ekspedisi").removeAttr("disabled");
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

<div id="modalRevisiSuratKeluar" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" >
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Revisi Surat Keluar</h4>
            </div>
            <div class="modal-body" style="height:220px;overflow-y: auto">
                <form id="form-disposisi">
                    <div class="panel">
                        <div class="panel-body">
                            <div class="form-horizontal">
                                <div class="block-inner text-danger">
                                    <h6 class="heading-hr">Data Surat Keluar</h6>
                                </div>
                                <div class="row">
                                    <?php
                                    echo $this->Form->label("OutgoingMail.revision_memo", __("Catatan Revisi"), array("class" => "col-md-4 control-label"));
                                    ?>
<!--                                    <input type="hidden" id="target-department-uniq-name" disabled/>
                                    <input type="hidden" id="target-id" disabled name="MailRecipient.employee_id"/>-->
                                    <div class="col-sm-8">
                                        <textarea rows="5" cols="5" class="limited form-control" id="target-memo" placeholder="100 Karakter"></textarea>
                                        <span class="help-block" id="limit-text">Dibatasi 100 karakter</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?= __("Tutup") ?></button>
                <button type="button" class="btn btn-success" data-dismiss="modal" id="revisi"><?= __("Revisi") ?></button>
            </div>
        </div>
    </div>
</div>