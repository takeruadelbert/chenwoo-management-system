<div class="row">
    <div class="col-md-12">
        <div class="panel-heading" style="background:#2179cc">
            <h6 class="panel-title" style=" color:#fff"><i class="icon-stats"></i>Data Statistik </h6>
        </div>
        <ul class="page-stats list-justified">
            <li class="bg-default">
                <div class="page-stats-showcase"> <span>Belum Dibaca</span>
                    <h2><?= $mailUnread ?></h2>
                </div>
                <div class="bar-warning chart">10,14,8,45,23,41,22,31,19,12, 28, 21, 24, 20</div>
            </li>
            <li class="bg-default">
                <div class="page-stats-showcase"> <span>Sudah Dibaca</span>
                    <h2><?= $mailRead ?></h2>
                </div>
                <div class="bar-primary chart">10,14,8,45,23,41,22,31,19,12, 28, 21, 24, 20</div>
            </li>
            <li class="bg-default">
                <div class="page-stats-showcase"> <span>Diteruskan</span>
                    <h2><?= $dispositionMail ?></h2>
                </div>
                <div class="bar-info chart">10,14,8,45,23,41,22,31,19,12, 28, 21, 24, 20</div>
            </li>
            <li class="bg-default">
                <div class="page-stats-showcase"> <span>Total</span>
                    <h2><?= $total ?></h2>
                </div>
                <div class="bar-danger chart">10,14,8,45,23,41,22,31,19,12, 28, 21, 24, 20</div>
            </li>
        </ul>
    </div>
</div>
<?php
echo $this->element(_TEMPLATE_DIR . "/{$template}/filter/disposisi");
?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("DATA DISPOSISI SURAT") ?>
                <div class="pull-right">
                    <button class="btn btn-xs btn-default action-surat action-disposisi" type="button" onclick="" disabled>
                        <i class="icon-paper-plane" style="color:red"></i> 
                        <?= __("Disposisi Surat") ?>
                    </button>&nbsp;
                    <button class="btn btn-xs btn-default action-surat action-cetak-disposisi" type="button" onclick="jumpTo(this)" disabled data-href="#">
                        <i class="icon-archive"></i> 
                        <?= __("Lembar Disposisi") ?>
                    </button>&nbsp;
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
                            <th colspan="2"><?= __("Surat") ?></th>
                            <th colspan="2"><?= __("Pengirim / Dispositor") ?></th>
                            <th colspan="2"><?= __("Penerima") ?></th>
                            <th colspan="2"><?= __("Diteruskan") ?></th>
                            <th rowspan="2"><?= __("Status") ?></th>
                            <th width="100" rowspan="2"><?= __("Lihat") ?></th>
                        </tr>
                        <tr>
                            <th><?= __("No. Agenda") ?></th>
                            <th><?= __("No. Surat") ?></th>
                            <th><?= __("NIP") ?></th>
                            <th><?= __("Nama") ?></th>
                            <th><?= __("NIP") ?></th>
                            <th><?= __("Nama") ?></th>
                            <th><?= __("NIP") ?></th>
                            <th><?= __("Nama") ?></th>
                        </tr>
                    </thead>
                    <tbody class="action-target-search"> 
                        <?php
                        $limit = intval(isset($this->params['named']['limit']) ? $this->params['named']['limit'] : 10);
                        $page = intval(isset($this->params['named']['page']) ? $this->params['named']['page'] : 1);
                        $i = ($limit * $page) - ($limit - 1);
                        if (!empty($data['rows'])) {
                            $MailRecipient = ClassRegistry::init("MailRecipient");
                            foreach ($data['rows'] as $item) {
                                $next = $MailRecipient->getForward($item['MailRecipient']['id']);
                                ?>
                                <tr id="row-<?= $i ?>" class="removeRow<?php echo $item[Inflector::classify($this->params['controller'])]['id']; ?> stn-selectable" 
                                    data-id="<?= $item["IncomingMail"]['id']; ?>"
                                    data-employee-id="<?= $item['MailRecipient']['employee_id'] ?>"
                                    data-seq="<?= $item['MailRecipient']['seq'] ?>"
                                    data-mail-recipient-id="<?= $item['MailRecipient']['id'] ?>"
                                    data-forwarded="<?= $item['MailRecipient']['forwarded'] ?>"
                                    >
                                    <td class="text-center"><input type="checkbox" name="data[<?php echo Inflector::classify($this->params['controller']) ?>][checkbox][]" value="<?php echo $item[Inflector::classify($this->params['controller'])]['id']; ?>"  id="checkBoxRow" class="styled checkboxDeleteRow" /></td>
                                    <td class="text-center"><?= $i ?></td>
                                    <td class="text-center"><?= $this->Html->cvtHariTanggal($item['MailRecipient']['created'], false) ?></td>
                                    <td class="text-center"><?= $item['IncomingMail']['nomor_agenda'] ?></td>
                                    <td class="text-center"><?= $item['IncomingMail']['nomor_surat'] ?></td>
                                    <td class="text-center"><?= $this->Sidispop->nipDispositor($item) ?></td>
                                    <td class="text-center"><?= $this->Sidispop->namaDispositor($item) ?></td>
                                    <td class="text-center"><?= $item['Employee']['nip_baru'] ?></td>
                                    <td class="text-center"><?= $item['Employee']['Account']['Biodata']['full_name'] ?></td>
                                    <td class="text-center"><?= $this->Sidispop->nipDiteruskan($next) ?></td>
                                    <td class="text-center"><?= $this->Sidispop->namaDiteruskan($next) ?></td>
                                    <td class="text-center"><?= $item['MailRecipient']['seen'] == 0 ? "Belum dibaca" : "Sudah dibaca" ?></td>
                                    <td class="text-center">
                                        <a href="<?= Router::url("/admin/incoming_mails/detailsurat/{$item['IncomingMail']['id']}") ?>"><button type="button" class="btn btn-default btn-xs btn-icon tip" title="Detail"><i class="icon-file"></i></button></a>
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
<script>
    $(document).ready(function () {
        $(".stn-selectable").click(function () {
            $(".stn-selectable").removeClass("selected");
            $(this).addClass("selected");
            reloadActionButton();
        });
        $(".stn-selectable input[type=checkbox]").click(function (e) {
            e.stopPropagation();
        });
        $(".action-surat.action-disposisi").on("click", function () {
            $selectedRow = $(".action-target-search").find(".selected").first();
            $.ajax({
                url: BASE_URL + "admin/incoming_mails/detailsurat/" + $selectedRow.data("id"),
                dataType: "JSON",
                type: "GET",
                success: function (response) {
                    //tembusan
                    var ccs = [];
                    $.each(response.data.IncomingMailCarbonCopy, function (k, v) {
                        ccs.push({nip: v.Employee.nip_baru, nama: v.Employee.Account.Biodata.full_name, bidang: v.Employee.Department.name, jabatan: v.Employee.Office.name});
                    })
                    var tmpl = $("#tmpl-data-tembusan").html();
                    Mustache.parse(tmpl);
                    var rendered = Mustache.render(tmpl, {ccs: ccs});
                    $("#target-tembusan tr:not(:last)").remove();
                    $("#target-tembusan").find("tr").last().before(rendered);
                    fixNumber($("#target-tembusan"));
                    //berkas
                    var berkas = [];
                    $.each(response.data.IncomingMailFile, function (k, v) {
                        berkas.push({
                            ektensi: v.AssetFile.ext,
                            nama: v.AssetFile.filename,
                            hit: v.AssetFile.hit,
                            href: BASE_URL + "admin/asset_files/getfile/" + v.AssetFile.id + "/" + v.AssetFile.token,
                            dt: cvtHariTanggal(v.AssetFile.created),
                        });
                    })
                    var tmpl = $("#tmpl-data-berkas").html();
                    Mustache.parse(tmpl);
                    var rendered = Mustache.render(tmpl, {berkas: berkas});
                    $("#target-data-berkas").html(rendered);
                    fixNumber($("#target-data-berkas"));
                    //riwayat disposisi/ekspedisi surat
                    var riwayat = [];
                    $.each(response.data.MailRecipient, function (k, v) {
                        if (v.dispositor_id == null) {
                            var namaDispositor = "[mailroom]";
                            var nipDispositor = "[mailroom]";
                        } else {
                            var namaDispositor = v.Dispositor.Account.Biodata.full_name;
                            var nipDispositor = v.Dispositor.nip_baru;
                        }
                        riwayat.push({
                            namaPenerima: v.Employee.Account.Biodata.full_name,
                            nipPenerima: v.Employee.nip_baru,
                            statusBaca: v.seen == 1,
                            namaDispositor: namaDispositor,
                            nipDispositor: nipDispositor,
                            dt: cvtHariTanggal(v.created),
                        });
                    })
                    console.log(riwayat);
                    var tmpl = $("#tmpl-riwayat-disposisi").html();
                    Mustache.parse(tmpl);
                    var rendered = Mustache.render(tmpl, {riwayat: riwayat});
                    $("#target-riwayat-disposisi").html(rendered);
                    fixNumber($("#target-riwayat-disposisi"));

                    $("#modaldisposisisuratmasuk").modal("show");
                }
            });
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
                    seq: $selectedRow.data("seq"),
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
    });

    function reloadActionButton() {
        $selectedRow = $(".action-target-search").find(".selected").first();
        var forwarded = $selectedRow.data("forwarded");
        var mail_recipient_id = $selectedRow.data("mail-recipient-id");
        if (forwarded) {
            $(".action-surat").attr("disabled", "disabled");
            $(".action-surat.action-cetak-disposisi").data("href", BASE_URL + "admin/mail_recipients/cetak_disposisi/" + mail_recipient_id);
            $(".action-surat.action-cetak-disposisi").removeAttr("disabled");
        } else {
            $(".action-surat").attr("disabled", "disabled");
            $(".action-surat.action-cetak-disposisi").data("href", BASE_URL + "admin/mail_recipients/cetak_disposisi/" + mail_recipient_id);
            $(".action-surat.action-disposisi").removeAttr("disabled");
            $(".action-surat.action-cetak-disposisi").removeAttr("disabled");
        }
    }

    function jumpTo(e) {
        var targetUrl = $(e).data("href");
        window.open(targetUrl, "_blank");
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
    employees.clearPrefetchCache();
    employees.initialize(true);
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
                empty: [
                    '<center><h5>Data Pegawai</h5></center><hr> <center><p> Hasil Pencarian Anda Tidak Dapat Ditemukan. </p></center>',
                ]
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
                    '<center><h5>Data Pegawai</h5></center><hr> <center><p> Hasil Pencarian Anda Tidak Dapat Ditemukan. </p></center>',
                ]
            }
        });
        e.bind('typeahead:select', function (ev, suggestion) {
            $("#target-id").val(suggestion.id);
            $("#target-jabatan").val(suggestion.jabatan);
            $("#target-department-uniq-name").val(suggestion.department_uniq_name);
        });
    }
</script>