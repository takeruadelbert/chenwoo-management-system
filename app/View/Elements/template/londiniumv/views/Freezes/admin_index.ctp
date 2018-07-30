<?php
echo $this->element(_TEMPLATE_DIR . "/{$template}/filter/freeze");
?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("DATA STYLING") ?>
                <div class="pull-right">
                    <button class="btn btn-xs btn-default" type="button" onclick="exp('print', '<?php echo Router::url("index/print?" . $_SERVER['QUERY_STRING'], true) ?>')">
                        <i class="icon-print2"></i> 
                        <?= __("Cetak") ?>
                    </button>&nbsp;
                    <button class="btn btn-xs btn-default" type="button" onclick="exp('excel', '<?php echo Router::url("index/excel?" . $_SERVER['QUERY_STRING'], true) ?>')">
                        <i class="icon-file-excel"></i>
                        Excel
                    </button>&nbsp;
                    <?= $this->element(_TEMPLATE_DIR . "/{$template}/roleaccess/delete") ?>
                </div>
                <small class="display-block"><?= _APP_CORPORATE_FULL ?></small>
            </h6>
        </div>
        <div class="table-responsive pre-scrollable stn-table stn-table-nowrap">
            <form id="checkboxForm" method="post" name="checkboxForm" action="<?php echo Router::url('/' . $this->params['prefix'] . '/' . $this->params['controller'] . '/multiple_delete', true); ?>">
                <table width="100%" class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th width="50"><input type="checkbox" class="styled checkall"/></th>
                            <th width="50">No</th>
                            <th><?= __("Nomor Styling") ?></th>
                            <th><?= __("Nomor Konversi / Nota Timbang") ?></th>
                            <th><?= __("Nama Supplier") ?></th>
                            <th><?= __("Tanggal Nota Timbang") ?></th>
                            <th colspan = 2><?= __("Berat Styling") ?></th>
                            <th><?= __("Ratio Styling") ?></th>
                            <th><?= __("Tanggal Mulai Styling") ?></th>
                            <th><?= __("Tanggal Selesai Styling") ?></th>
                            <th><?= __("Tipe Material") ?></th>
                            <th><?= __("Diinput Oleh") ?></th>
                            <?php
                            if ($stnAdmin->branchPrivilege()) {
                                ?>
                                <th><?= __("Cabang") ?></th>
                                <?php
                            }
                            ?>
                            <th><?= __("Status Verifikasi") ?></th>
                            <th><?= __("Status Validasi") ?></th>
                            <th><?= __("Keterangan") ?></th>
                            <th width="100"><?= __("Aksi") ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $limit = intval(isset($this->params['named']['limit']) ? $this->params['named']['limit'] : 10);
                        $page = intval(isset($this->params['named']['page']) ? $this->params['named']['page'] : 1);
                        $i = ($limit * $page) - ($limit - 1);
                        if (empty($data['rows'])) {
                            ?>
                            <tr>
                                <td class = "text-center" colspan = "17">Tidak Ada Data</td>
                            </tr>
                            <?php
                        } else {
                            foreach ($data['rows'] as $item) {
                                $totalDisbursement = 0;
                                ?>
                                <tr id="row-<?= $i ?>" class="removeRow<?php echo $item[Inflector::classify($this->params['controller'])]['id']; ?>">
                                    <td class="text-center"><input type="checkbox" name="data[<?php echo Inflector::classify($this->params['controller']) ?>][checkbox][]" value="<?php echo $item[Inflector::classify($this->params['controller'])]['id']; ?>"  id="checkBoxRow" class="styled checkboxDeleteRow" /></td>
                                    <td class="text-center"><?= $i ?></td>
                                    <td class="text-center"><?= $item['Freeze']['freeze_number'] ?></td>
                                    <?php
                                    if (empty($item['Freeze']['conversion_id'])) {
                                        ?>
                                        <td class="text-center"><?= $item['MaterialEntry']['material_entry_number'] ?></td>
                                        <?php
                                    } else {
                                        ?>
                                        <td class="text-center"><?= $item['Conversion']['no_conversion'] ?></td>
                                        <?php
                                    }
                                    ?>
                                    <td><?= $item['MaterialEntry']['Supplier']['name'] ?></td>
                                    <td class="text-center"><?= $this->Html->cvtTanggal($item['MaterialEntry']['weight_date']) ?></td>
                                    <td class="text-right"><?= $item['Freeze']['total_weight'] ?> </td>
                                    <td class="text-center" wodth = "30"> Kg</td>
                                    <td class="text-center"><?= $item['Freeze']['ratio'] ?> %</td>
                                    <td class="text-center"><?= $this->Html->cvtTanggal($item['Freeze']['start_date']) ?> </td>
                                    <td class="text-center"><?= $this->Html->cvtTanggal($item['Freeze']['end_date']) ?></td>
                                    <td class="text-center"><?= $item['MaterialEntry']['MaterialCategory']['name'] ?></td>
                                    <td class="text-center"><?= $item['Employee']['Account']['Biodata']['full_name']; ?></td>
                                    <?php
                                    if ($stnAdmin->branchPrivilege()) {
                                        ?>
                                        <td class="text-left"><?php echo $item["BranchOffice"]['name']; ?></td>
                                        <?php
                                    }
                                    ?>
                                    <td class="text-center"  id = "target-change-status<?= $i ?>">
                                        <?php
                                        if ($item['Freeze']['verify_status_id'] == 2) {
                                            echo "Ditolak";
                                        } else if ($item['Freeze']['verify_status_id'] == 3) {
                                            echo "Disetujui";
                                        } else {
                                            echo "Menunggu Persetujuan";
                                        }
                                        ?>
                                    </td>
                                    <td class="text-center"  id = "target-change-statuses<?= $i ?>">
                                        <?php
                                        if ($roleAccess['edit']) {
                                            if ($item['Freeze']['validate_status_id'] == 1) {
                                                echo $this->Html->changeStatusSelect($item['Freeze']['id'], ClassRegistry::init("ValidateStatus")->find("list", array("fields" => array("ValidateStatus.id", "ValidateStatus.name"))), $item['Freeze']['validate_status_id'], Router::url("/admin/freezes/change_status_validate"), "#target-change-statuses$i");
                                            } else {
                                                echo $item['ValidateStatus']['name'];
                                            }
                                        } else {
                                            echo $item['ValidateStatus']['name'];
                                        }
                                        ?>
                                    </td>
                                    <td class="text-center"><?= $this->Echo->empty_strip($item['Freeze']['note']); ?></td>
                                    <td class="text-center"> 
                                        <?php
                                        if ($item['Freeze']['validate_status_id'] != 2) {
                                            if ($item['MaterialEntry']['material_category_id'] == 1) {
                                                ?>
                                                <?= $this->element(_TEMPLATE_DIR . "/{$template}/roleaccess/edit", ["editUrl" => Router::url("/admin/{$this->params['controller']}/edit_whole/{$item[Inflector::classify($this->params['controller'])]['id']}")]) ?>
                                                <?php
                                            } else if ($item['MaterialEntry']['material_category_id'] == 2) {
                                                ?>
                                                <?= $this->element(_TEMPLATE_DIR . "/{$template}/roleaccess/edit", ["editUrl" => Router::url("/admin/{$this->params['controller']}/edit_colly/{$item[Inflector::classify($this->params['controller'])]['id']}")]) ?>
                                                <?php
                                            }
                                        }
                                        ?>
                                        <a data-toggle="modal" role="button" href="#default-view" class="btn btn-default btn-xs btn-icon btn-icon tip viewData" title="" data-original-title="Lihat File" data-freeze-id="<?= $item[Inflector::classify($this->params['controller'])]['id'] ?>"><i class="icon-eye7"></i></a>
                                    </td>
                                </tr>
                                <?php
                                $i++;
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </form>
        </div>
    </div>
    <?php echo $this->element(_TEMPLATE_DIR . "/{$template}/pagination") ?>
</div>

<!-- Default modal -->
<div id="default-view" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">FORM</h4>
            </div>
            <!-- New invoice template -->
            <div class="panel">
                <div class="panel-body">
                    <div class="block-inner text-danger">
                        <h6 class="heading-hr">LIHAT DATA STYLING
                            <small class="display-block"><?= _APP_CORPORATE_FULL ?></small>
                        </h6>
                    </div>
                    <div class="well block">
                        <div class="tabbable">
                            <ul class="nav nav-pills nav-justified">
                                <li class="active"><a href="#justified-pill1" data-toggle="tab"><i class="icon-user"></i> Staff Penginput</a></li>
                                <li><a href="#justified-pill2" data-toggle="tab"><i class="icon-user"></i> Data Pegawai Pelaksana Styling </a></li>
                                <li><a href="#justified-pill3" data-toggle="tab"><i class="icon-loop"></i> Data Konversi / Nota Timbang </a></li>
                                <li><a href="#justified-pill4" data-toggle="tab"><i class="fa fa-snowflake-o"></i> Rincian Produk Styling </a></li>
                            </ul>
                            <div class="tab-content pill-content">
                                <div class="tab-pane fade in active" id="justified-pill1">
                                    <table width="100%" class="table table-hover">
                                        <tbody>
                                            <tr>
                                                <td colspan="11" style="width:200px">
                                                    <div class="form-group">
                                                        <?php
                                                        echo $this->Form->label("Dummy.employee", __("Nama Pegawai"), array("class" => "col-sm-2 control-label"));
                                                        echo $this->Form->input("Dummy.employee", array("div" => array("class" => "col-sm-4"), "type" => "text", "label" => false, "class" => "form-control", "disabled"));
                                                        ?>
                                                        <?php
                                                        echo $this->Form->label("Dummy.nip", __("NIP"), array("class" => "col-sm-2 control-label"));
                                                        echo $this->Form->input("Dummy.nip", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "readonly"));
                                                        ?>
                                                    </div>
                                                </td>
                                            </tr> 
                                            <tr>
                                                <td colspan="11" style="width:200px">
                                                    <div class="form-group">
                                                        <?php
                                                        echo $this->Form->label("Dummy.department", __("Departemen"), array("class" => "col-sm-2 control-label"));
                                                        echo $this->Form->input("Dummy.department", array("div" => array("class" => "col-sm-4"), "type" => "text", "label" => false, "class" => "form-control", "disabled"));
                                                        ?>
                                                        <?php
                                                        echo $this->Form->label("Dummy.jabatan", __("Jabatan"), array("class" => "col-sm-2 control-label"));
                                                        echo $this->Form->input("Dummy.jabatan", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "readonly"));
                                                        ?>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="justified-pill2">
                                    <table width="100%" class="table table-hover">
                                        <tbody>
                                            <tr>
                                                <td colspan="11" style="width:200px">
                                                    <div class="form-group">
                                                        <?php
                                                        echo $this->Form->label("Operator.employee", __("Nama Pegawai"), array("class" => "col-sm-2 control-label"));
                                                        echo $this->Form->input("Operator.employee", array("div" => array("class" => "col-sm-4"), "type" => "text", "label" => false, "class" => "form-control", "disabled"));
                                                        ?>
                                                        <?php
                                                        echo $this->Form->label("Operator.nip", __("NIP"), array("class" => "col-sm-2 control-label"));
                                                        echo $this->Form->input("Operator.nip", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "readonly"));
                                                        ?>
                                                    </div>
                                                </td>
                                            </tr> 
                                            <tr>
                                                <td colspan="11" style="width:200px">
                                                    <div class="form-group">
                                                        <?php
                                                        echo $this->Form->label("Operator.department", __("Departemen"), array("class" => "col-sm-2 control-label"));
                                                        echo $this->Form->input("Operator.department", array("div" => array("class" => "col-sm-4"), "type" => "text", "label" => false, "class" => "form-control", "disabled"));
                                                        ?>
                                                        <?php
                                                        echo $this->Form->label("Operator.jabatan", __("Jabatan"), array("class" => "col-sm-2 control-label"));
                                                        echo $this->Form->input("Operator.jabatan", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "readonly"));
                                                        ?>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="justified-pill3">
                                    <table width="100%" class="table table-hover">
                                        <tbody>
                                            <tr>
                                                <td colspan="11" style="width:200px">
                                                    <div class="form-group">
                                                        <?php
                                                        echo $this->Form->label("Freeze.freeze_number", __("Nomor Styling"), array("class" => "col-sm-2 control-label"));
                                                        echo $this->Form->input("Freeze.freeze_number", array("div" => array("class" => "col-sm-4"), "type" => "text", "label" => false, "class" => "form-control", "value" => "Akan Dibuat Setelah Disimpan", "disabled"));
                                                        ?>
                                                        <?php
                                                        echo $this->Form->label("Dummy.no_conversion", __("Nomor Konversi / Nota Timbang"), array("class" => "col-sm-2 control-label"));
                                                        echo $this->Form->input("Dummy.no_conversion", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "readonly"));
                                                        ?>
                                                    </div>
                                                </td>
                                            </tr> 
                                            <tr>
                                                <td colspan="11" style="width:200px">
                                                    <div class="form-group">
                                                        <?php
                                                        echo $this->Form->label("Dummy.weight", __("Berat Konversi / Nota Timbang"), array("class" => "col-sm-2 control-label"));
                                                        ?>
                                                        <div class="col-sm-4">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control text-right" id="conversion_weight" disabled>
                                                                <span class="input-group-addon"> Kg</span>
                                                            </div>
                                                        </div>
                                                        <?php
                                                        echo $this->Form->label("Dummy.ratio", __("Ratio Konversi / Nota Timbang"), array("class" => "col-sm-2 control-label"));
                                                        ?>
                                                        <div class="col-sm-4">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control text-right" id="conversion_ratio" disabled>
                                                                <span class="input-group-addon">% </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" style="width:200px">
                                                    <div class="form-group">
                                                        <?php
                                                        echo $this->Form->label("Freeze.status", __("Status"), array("class" => "col-sm-2 control-label"));
                                                        echo $this->Form->input("Freeze.status", array("type" => "text", "div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled"));
                                                        ?>
                                                        <?php
                                                        echo $this->Form->label("Freeze.verified", __("Diverifikasi Oleh"), array("class" => "col-sm-2 control-label"));
                                                        echo $this->Form->input("Freeze.verified", array("type" => "text", "div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled"));
                                                        ?>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <div class="panel panel-default">
                                        <div class="panel-body">
                                            <div class="table-responsive stn-table">
                                                <div class="panel-heading" style="background:#2179cc">
                                                    <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Detail Data Konversi / Nota Timbang") ?></h6>
                                                </div>
                                                <table width="100%" class="table table-hover table-bordered" id="table-whole">                        
                                                    <thead>
                                                        <tr>
                                                            <th width="50">No</th>
                                                            <th><?= __("Nama Material") ?></th>
                                                            <th><?= __("Grade") ?></th>
                                                            <th><?= __("Alasan Turun Grade") ?></th>
                                                            <th colspan="2"><?= __("Berat Ikan") ?></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="target-installment">
                                                        <tr id="init">
                                                            <td class = "text-center" colspan = 5>Tidak Ada Data</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <table width="100%" class="table table-hover table-bordered" id="table-loin">                        
                                                    <thead>
                                                        <tr>
                                                            <th width="50">No</th>
                                                            <th><?= __("Nama Material") ?></th>
                                                            <th><?= __("Grade") ?></th>
                                                            <th colspan="2"><?= __("Berat Ikan") ?></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="target-installment-loin">
                                                        <tr id="init">
                                                            <td class = "text-center" colspan = 4>Tidak Ada Data</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>                 
                                <div class="tab-pane fade" id="justified-pill4">
                                    <table class="table table-hover table-bordered stn-table" width="100%">
                                        <thead>
                                            <tr>
                                                <th width="50">No</th>
                                                <th>Produk</th>
                                                <th width = "250">Alasan Turun Grade</th>
                                                <th width = "250" colspan="2">Berat</th>
                                            </tr>
                                        <thead>
                                        <tbody id="target-detail-kas-keluar">
                                            <tr class="dynamic-row-pendapatan hidden" data-n="0">
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="3" align="right">
                                                    <strong>Berat Total</strong>
                                                </td>
                                                <td class="text-right auto-calculate-grand-total-weight" id = "grandTotal" style="border-right-style:none;">
                                                </td> 
                                                <td class = "text-left" style= "width:50px; border-left-style:none;">
                                                    Kg
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" align="right">
                                                    <strong>Total Ratio</strong>
                                                </td>
                                                <td class="text-right auto-calculate-grand-total-ratio tip" id="ratios" style="border-right-style:none;">
                                                </td> 
                                                <td class = "text-left" style= "width:50px; border-left-style:none;">
                                                    %
                                                </td>
                                            </tr>  
                                            <tr class = "freezeNote">
                                                <td colspan="4" style="width:200px">
                                                    <div class="form-group">
                                                        <?php
                                                        echo $this->Form->label("Freeze.note", __("Keterangan"), array("class" => "col-sm-2 control-label"));
                                                        ?>
                                                        <div id ="FreezeNote" style = "padding-top:10px !important;padding-left:165px !important;">
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tfoot>      
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /new invoice template -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup Form</button>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<script>
    $(document).ready(function () {
        $('.viewData').click(function () {
            $("tr.dynamic-row-pendapatan").html("");
            var freezeId = $(this).data("freeze-id");
            var e = $("tr.dynamic-row-pendapatan");
            fixNumberPendapatan(e.parents("tbody"));
            $.ajax({
                url: BASE_URL + "/freezes/view_data_freeze/" + freezeId,
                dataType: "JSON",
                type: "GET",
                data: {},
                success: function (data) {
                    $('input#DummyEmployee').val(data.Employee.Account.Biodata.full_name);
                    $('input#DummyNip').val(data.Employee.nip);
                    $('input#DummyDepartment').val(data.Employee.Department.name);
                    $('input#DummyJabatan').val(data.Employee.Office.name);

                    if (data.Freeze.operator_id != null && data.Freeze.operator_id != "") {
                        $('#OperatorEmployee').val(data.Operator.Account.Biodata.full_name);
                        $('#OperatorNip').val(data.Operator.nip);
                        $('#OperatorDepartment').val(data.Operator.Department.name);
                        $('#OperatorJabatan').val(data.Operator.Office.name);
                    }

                    if (data.Freeze.conversion_id == null) {
                        $('input#FreezeFreezeNumber').val(data.Freeze.freeze_number);
                        $('input#DummyNoConversion').val(data.MaterialEntry.material_entry_number);
                        viewDataConversion1(data.MaterialEntry.id);
                        $('#target-installment-loin').empty();
                        $('#table-whole').hide();
                        $('#table-loin').show();
                    } else {
                        $('input#FreezeFreezeNumber').val(data.Freeze.freeze_number);
                        $('input#DummyNoConversion').val(data.Conversion.no_conversion);
                        $('#conversion_weight').val(ic_kg(data.Conversion.total));
                        $('#conversion_ratio').val(data.Conversion.ratio);
                        viewDataConversion(data.Conversion.id);
                        $('#target-installment').empty();
                        $('#table-whole').show();
                        $('#table-loin').hide();
                    }
                    $("#FreezeStatus").val(data.VerifyStatus.name);
                    if (data.Freeze.verify_status_id == 1) {
                        $("#FreezeVerified").val("");
                    } else {
                        $("#FreezeVerified").val(data.VerifiedBy.Account.Biodata.full_name);
                    }
                    if (data.Freeze.note == "" || data.Freeze.note == null || data.Freeze.note.length == 0) {
                        $(".freezeNote").hide();
                    } else {
                        $(".freezeNote").show();
                        $('#FreezeNote').html(data.Freeze.note);
                    }
                    var freezeDetail = data.FreezeDetail;
                    var i = 1;
                    $('.auto-calculate-grand-total-weight').text(ic_kg(data.Freeze.total_weight));
                    $('.auto-calculate-grand-total-ratio').text(data.Freeze.ratio);
                    $('#target-detail-kas-keluar tr').not(".dynamic-row-pendapatan").remove();
                    $.each(freezeDetail, function (index, value) {
                        var name = value.Product.name;
                        var parent = value.Product.Parent.name;
                        var weight = ic_kg(value.weight);
                        if (value.rejected_grade_type_id == null) {
                            var reject_type = "-";
                        } else {
                            var reject_type = value.RejectedGradeType.name;
                        }
                        var n = e.data("n");
                        var template = $('#tmpl-detail-kas-keluar').html();
                        Mustache.parse(template);
                        var options = {
                            i: i,
                            n: n,
                            parent: parent,
                            name: name,
                            weight: weight,
                            reject_type: reject_type
                        };
                        i++;
                        var rendered = Mustache.render(template, options);
                        $('#target-detail-kas-keluar tr.dynamic-row-pendapatan:last').before(rendered);
                        e.data("n", n + 1);
                    });
                }
            });
        });
    });

    function fixNumberPendapatan(e) {
        var i = 1;
        $.each(e.find("tr.dynamic-row-pendapatan").not(".hidden"), function () {
            $(this).find(".nomorIdx").html(i);
            i++;
        })
    }

    function viewDataConversion(conversionId) {
        $.ajax({
            url: BASE_URL + "conversions/view_data_conversion/" + conversionId,
            dataType: "JSON",
            type: "GET",
            data: {},
            success: function (data) {
                if (data != null && data != '') {
                    var req = data.data;
                    var i = 1;
                    var template = $("#tmpl-installment").html();
                    Mustache.parse(template);
                    $("table tr#init").remove();
                    $.each(req.ConversionData, function (index, items) {
                        if (items.rejected_grade_type_id == null) {
                            var reject_type = "-";
                        } else {
                            var reject_type = items.RejectedGradeType.name;
                        }
                        var options = {
                            i: i,
                            detail: items.MaterialDetail.name,
                            size: items.MaterialSize.name,
                            quantity: ic_kg(items.material_size_quantity),
                            reject_type: reject_type,
                        };
                        var rendered = Mustache.render(template, options);
                        $('#target-installment').append(rendered);
                        i++;
                    })
                }
            }
        })
    }

    function viewDataConversion1(materialEntryId) {
        var total_quantity = 0;
        $.ajax({
            url: BASE_URL + "admin/material_entries/view_data_material_entry/" + materialEntryId,
            dataType: "JSON",
            type: "GET",
            data: {},
            success: function (data) {
                if (data != null && data != '') {
                    var temp = data.data;
                    var i = 1;
                    var template = $("#tmpl-installment-loin").html();
                    Mustache.parse(template);
                    $("table tr#init").remove();
                    $.each(temp.MaterialEntryGrade, function (index, item) {
                        var options = {
                            i: i,
                            detail: item.MaterialDetail.name,
                            size: item.MaterialSize.name,
                            quantity: ic_kg(item.weight),
                        };
                        total_quantity += parseFloat(item.weight);
                        $('#conversion_weight').val(ic_kg(total_quantity));
                        $('#conversion_ratio').val(100);
                        var rendered = Mustache.render(template, options);
                        $('#target-installment-loin').append(rendered);
                        i++;
                    });
                }
            }
        })
    }
</script>
<script type="x-tmpl-mustache" id="tmpl-installment">
    <tr>
    <td class="text-center">{{i}}</td>
    <td class="text-center">{{detail}}</td>     
    <td class="text-center">{{size}}</td>    
    <td class="text-center">{{reject_type}}</td>  
    <td class="text-right" style="border-right-style:none;">
    {{quantity}}
    </td> 
    <td class = "text-left" style= "width:50px; border-left-style:none;">
    Kg
    </td> 
    </tr>
</script>
<script type="x-tmpl-mustache" id="tmpl-installment-loin">
    <tr>
    <td class="text-center">{{i}}</td>
    <td class="text-center">{{detail}}</td>     
    <td class="text-center">{{size}}</td>       
    <td class="text-right" style="border-right-style:none;">
    {{quantity}}
    </td> 
    <td class = "text-left" style= "width:50px; border-left-style:none;">
    Kg
    </td> 
    </tr>
</script>
<script type="x-tmpl-mustache" id="tmpl-detail-kas-keluar">
    <tr>
    <td class="text-center nomorIdx">
    {{i}}
    </td>
    <td>
    {{parent}} - {{name}}
    </td>
    <td class="text-center">
    {{reject_type}}
    </td>
    <td class="text-right" style="border-right-style:none;">
    {{weight}}
    </td> 
    <td class = "text-left" style= "width:50px; border-left-style:none;">
    Kg
    </td> 
    </tr>
</script>