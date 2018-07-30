<?php
echo $this->element(_TEMPLATE_DIR . "/{$template}/filter/conversion-product");
?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("DATA PROSES KONVERSI") ?>
                <div class="pull-right">
                    <button class="btn btn-xs btn-default" type="button" onclick="exp('print', '<?php echo Router::url("conversion/print?" . $_SERVER['QUERY_STRING'], true) ?>')">
                        <i class="icon-print2"></i> 
                        <?= __("Cetak") ?>
                    </button>&nbsp;
                    <button class="btn btn-xs btn-default" type="button" onclick="exp('excel', '<?php echo Router::url("conversion/excel?" . $_SERVER['QUERY_STRING'], true) ?>')">
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
                            <th><?= __("Nomor Nota Timbang") ?></th>
                            <th><?= __("Tanggal Nota Timbang") ?></th>
                            <th><?= __("Pembuat Nota Timbang") ?></th>
                            <th><?= __("Supplier") ?></th>
                            <th><?= __("Total Material") ?></th>
                            <th><?= __("Sisa Material") ?></th>
                            <?php
                            if ($stnAdmin->branchPrivilege()) {
                                ?>
                                <th><?= __("Cabang") ?></th>
                                <?php
                            }
                            ?>
                            <th><?= __("Status") ?></th>
                            <th>Jumlah Konversi<br/>Tidak Sesuai Rasio</th>
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
                                <td class = "text-center" colspan ="12">Tidak Ada Data</td>
                            </tr>
                            <?php
                        } else {
                            foreach ($data['rows'] as $item) {
                                ?>
                                <tr id="row-<?= $i ?>" class="removeRow<?php echo $item["MaterialEntry"]['id']; ?>">
                                    <td class="text-center"><input type="checkbox" name="data[<?php echo Inflector::classify($this->params['controller']) ?>][checkbox][]" value="<?php echo $item["MaterialEntry"]['id']; ?>"  id="checkBoxRow" class="styled checkboxDeleteRow" /></td>
                                    <td class="text-center"><?= $i ?></td>
                                    <td class="text-center"><?php echo $item['MaterialEntry']['material_entry_number']; ?></td>
                                    <td class="text-left"><?php echo!empty($item['MaterialEntry']['id']) ? $this->Html->cvtTanggal($item['MaterialEntry']['weight_date']) : "-" ?></td>
                                    <td class="text-left"><?php echo $item['Employee']['Account']["Biodata"]["first_name"]; ?></td>
                                    <td class="text-left"><?php echo $this->Echo->empty_strip($item['Supplier']['name']); ?></td>
                                    <td class="text-center">
                                        <?php
                                        $total = 0;
                                        $remaining = 0;
                                        $btn = "";
                                        foreach ($item['MaterialEntryGrade'] as $grade) {
                                            $total += $grade['quantity'];
                                            foreach ($grade['MaterialEntryGradeDetail'] as $details) {
                                                if (!$details['is_used']) {
                                                    $remaining++;
                                                }
                                            }
                                        }
                                        if ($remaining > 0) {
                                            $btn = "warning";
                                        } else {
                                            $btn = "success";
                                        }
                                        echo $total . " ikan";
                                        ?>
                                    </td>
                                    <td class="text-center">
                                        <span class="label label-<?= $btn ?>"><?= $remaining ?> ikan</span>
                                    </td>
                                    <?php
                                    if ($stnAdmin->branchPrivilege()) {
                                        ?>
                                        <td class="text-left"><?php echo $item["BranchOffice"]['name']; ?></td>
                                        <?php
                                    }
                                    ?>
                                    <td class="text-center"  id = "target-change-status<?= $i ?>">
                                        <span class="label label-<?= $item["MaterialEntry"]["conversion_status_id"] == 1 ? "danger" : "success" ?>"><?= $item["ConversionStatus"]["name"] ?></span>
                                    </td>
                                    <td class="text-center">
                                        <?php
                                        $countUnderRatio = 0;
                                        foreach ($item["Conversion"] as $conversion) {
                                            $countUnderRatio+=$conversion["ratio_status_id"] == 4 ? 1 : 0;
                                        }
                                        if ($countUnderRatio > 0) {
                                            ?>
                                            <span class="label label-warning"><?= $countUnderRatio ?> Konversi</span>
                                            <?php
                                        } else {
                                            echo "-";
                                        }
                                        ?>
                                    </td>
                                    <td class="text-center">
                                        <?php
                                        if ($remaining > 0) {
                                            ?>
                                            <a href = "<?= Router::url("/admin/conversions/conversion_process/{$item[Inflector::classify($this->params['controller'])]['id']} ", true) ?>" class = "btn btn-default btn-xs btn-icon btn-icon tip" title = "Proses Konversi"><i class = "icon-loop"></i></a>
                                            <?php
                                        }
                                        ?>
                                        <a data-toggle="modal" data-material-entry-id="<?= $item['MaterialEntry']['id'] ?>" data-remaining="<?= $remaining ?>" role="button" href="#default-lihatConversion" class="btn btn-default btn-xs btn-icon btn-icon tip viewData" title="Lihat Data"><i class="icon-eye7"></i></a>
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
<div id="default-lihatConversion" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">FORM</h4>
            </div>
            <!-- New invoice template -->
            <div class="panel form-horizontal">
                <div class="panel-body">
                    <div class="block-inner text-danger">
                        <h6 class="heading-hr">LIHAT DATA PEMROSESAN IKAN
                            <small class="display-block"><?= _APP_CORPORATE_FULL ?></small>
                        </h6>
                    </div>
                    <div class="well block">
                        <div class="tabbable">
                            <ul class="nav nav-pills nav-justified" id="targetTitleTab">

                            </ul>
                            <div class="tab-content pill-content" id="targetContentTab">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <!--<a href="#" id="add"><button type="button" class="btn btn-success">Tambah Data</button></a>-->
                <button type="button" class="btn btn-info" data-dismiss="modal">Tutup Form</button>
            </div>
        </div>
    </div>    
</div>
<script>
    $(document).ready(function () {
        loadckeditor();
        fixckeditor();
        $(".viewData").click(function () {
            $("tr.transaction-material-data").html("");
            $("#targetTitleTab").html("");
            $("#targetContentTab").html("");
//            var conversionId = $(this).data("conversion-id");
            var materialEntryId = $(this).data("material-entry-id");
            var e = $("tr.dynamic-row-conversion");
            var remaining = $(this).data("remaining");
            var is_empty = false;
            $.ajax({
                url: BASE_URL + "conversions/get_data_material_entry/" + materialEntryId,
                type: "GET",
                dataType: "JSON",
                beforeSend: function (xhr) {
                    ajaxLoadingStart();
                },
                success: function (response) {
                    if (response.data.Conversion.length == 0) {
                        $("div#targetContentTab").append("<div class='text-center text-danger'><h2>Belum ada data Konversi!</h2></div>");
                    }
                    if (response.status == 206) {
                        var i = 1;
                        var nomor = 1;
                        var is_active = "";
                        var in_active = "";
                        var warning = "";
                        var number = 1;
                        $.each(response.data.Conversion, function (index, value) {
                            if (value.id != null) {
                                var conversion_weight = value.total;
                                var conversion_ratio = value.ratio;
                                var start_date = cvtTanggal(value.start_date);
                                var end_date = cvtTanggal(value.end_date);
                                var titleTabTemplate = $("#tmpl-title-tab").html();
                                var contentTabTemplate = $("#tmpl-content-tab").html();
                                Mustache.parse(titleTabTemplate);
                                Mustache.parse(contentTabTemplate);
                                if (index == 0) {
                                    is_active = "active";
                                    in_active = "in active";
                                } else {
                                    is_active = "";
                                    in_active = "";
                                }
                                if (value.ratio_status_id == 4) {
                                    warning = "icon-warning";
                                } else {
                                    warning = "";
                                }
                                var options = {
                                    nomor: nomor,
                                    is_active: is_active,
                                    in_active: in_active,
                                    title_tab: "Konversi " + nomor,
                                    warning: warning,
                                    conversion_weight: ic_kg(conversion_weight),
                                    conversion_ratio: ic_persen(conversion_ratio),
                                    start_date: start_date,
                                    end_date: end_date
                                };
                                var rendered = Mustache.render(titleTabTemplate, options);
                                var rendered2 = Mustache.render(contentTabTemplate, options);

                                $("#targetTitleTab").append(rendered);
                                $("#targetContentTab").append(rendered2);
                                $("#ConversionNoConversion").val(value.no_conversion);
                                //data NAMA PEGAWAI
                                var emp = value.Employee;
                                var employee_name = emp.Account.Biodata.full_name;
                                var employee_nip = emp.nip;
                                var employee_office = emp.Office.name;
                                var employee_department = emp.Department.name;
                                var template_emp = $("#tmpl-employee").html();
                                Mustache.parse(template_emp);
                                var options = {
                                    employee_name: employee_name,
                                    employee_nip: employee_nip,
                                    employee_office: employee_office,
                                    employee_department: employee_department,
                                };
                                var rendered_emp = Mustache.render(template_emp, options);
                                $("#target-employee" + number).append(rendered_emp);

                                //data NAMA OPERATOR
                                var operator = value.Operator;
                                var operator_name = operator.Account.Biodata.full_name;
                                var operator_nip = operator.nip;
                                var operator_office = operator.Office.name;
                                var operator_department = operator.Department.name;
                                var template_operator = $("#tmpl-operator").html();
                                Mustache.parse(template_operator);
                                var options = {
                                    operator_name: operator_name,
                                    operator_nip: operator_nip,
                                    operator_office: operator_office,
                                    operator_department: operator_department,
                                };
                                var rendered_operator = Mustache.render(template_operator, options);
                                $("#target-operator" + number).append(rendered_operator);

                                //DATA KONVERSI
                                var conversion = value;
                                var conversion_number = conversion.no_conversion;
                                var conversion_date = cvtTanggal(conversion.created);
                                var template_conversion = $("#tmpl-conversion").html();
                                Mustache.parse(template_emp);
                                var options = {
                                    conversion_number: conversion_number,
                                    conversion_date: conversion_date,
                                };
                                var rendered_conversion = Mustache.render(template_conversion, options);
                                $("#target-conversion" + number).append(rendered_conversion);

                                $.each(value.ConversionData, function (j, val) {
//                                    var name = val.MaterialDetail.Material.name + " " + val.MaterialDetail.name;
                                    var name = val.MaterialDetail.name;
                                    var size = val.MaterialSize.name;
                                    var weight = val.material_size_quantity;
                                    if (val.rejected_grade_type_id == null) {
                                        var rejectedGradeType = "-";
                                    } else {
                                        var rejectedGradeType = val.RejectedGradeType.name;
                                    }
                                    var template3 = $('#tmpl-material-data').html();
                                    Mustache.parse(template3);
                                    var options = {
                                        index: j + 1,
                                        name: name,
                                        size: size,
                                        weight: ic_kg(weight),
                                        rejectedGradeType: rejectedGradeType,
                                    };
                                    var render = Mustache.render(template3, options);
                                    $("#target-detail-transaction" + i).append(render);
                                });
                                var processWeight = 0;
                                $.each(value.MaterialEntryGradeDetail, function (index, val) {
//                                    var grade = val.MaterialEntryGrade.MaterialDetail.name + " " + val.MaterialEntryGrade.MaterialDetail.Material.name;
                                    var grade = val.MaterialEntryGrade.MaterialDetail.name;
                                    var size = val.MaterialEntryGrade.MaterialSize.name;
                                    if (val.is_used == 1) {
                                        var weight = val.weight;
                                        var template4 = $("#tmpl-processed-material").html();
                                        Mustache.parse(template4);
                                        var options = {
                                            index: index + 1,
                                            grade: grade,
                                            size: size,
                                            weight: ic_kg(weight),
                                            number: number
                                        };
                                        processWeight += parseFloat(weight);
                                        var rendered = Mustache.render(template4, options);
                                        $("#target-detail-processed-material" + number).append(rendered);
                                    }
                                });
                                $("#processWeight" + number).text(ic_kg(processWeight));
                                var temp = value.note;
                                if (temp != null && temp != "") {
                                    var note = "<div class='text-center'><br><b>" + temp.replace(/<(?:.|\n)*?>/gm, '') + "</b></div>";
                                } else {
                                    var note = "<div class='text-center'><br><b>Tidak Ada Keterangan</b></div>";
                                }
                                var template5 = $("#tmpl-note").html();
                                Mustache.parse(template5);
                                var options = {
                                    note: note
                                };
                                var rendered = Mustache.render(template5, options);
                                $("#target-note" + number).append(rendered);
                                i++;
                                nomor++;
                                number++;
                            }
                        });
//                        if (remaining > 0) {
//                            var href = BASE_URL + "admin/conversions/conversion_process/" + materialEntryId;
//                            $("#add").attr("href", href);
//                            $("#add").show();
//                        } else {
//                            $("#add").hide();
//                        }
                    }
                    ajaxLoadingSuccess();
                }
            });
        });
    });
</script>
<script type="x-tmpl-mustache" id="tmpl-material-data">
    <tr class="dynamic-row transaction-material-data">
    <td class="text-center nomorIdx">{{index}}</td>
    <td class="text-left">
    {{name}}
    </td> 
    <td class="text-center">
    {{size}}
    </td>
    <td class="text-center">
    {{rejectedGradeType}}
    </td>
    <td class="text-right" style="border-right-style:none;">
    {{weight}}
    </td> 
    <td class = "text-left" style= "width:50px; border-left-style:none;">
    Kg
    </td>         
    </tr>
</script>
<script type="x-tmpl-mustache" id="tmpl-material-data-empty">
    <tr class="dynamic-row transaction-material-data">
    <td colspan="4" class="text-center">Tidak Ada Data</td>   
    </tr>
</script>
<script type="x-tmpl-mustache" id="tmpl-title-tab">
    <li class="{{is_active}}"><a href="#justified-pill{{nomor}}" data-toggle="tab"><i class="icon-file6"></i> {{title_tab}} <i class="{{warning}} pull-right text-danger tip" title="Tidak memenuhi rasio"></i></a></li>
</script>
<script type="x-tmpl-mustache" id="tmpl-employee">
    <div class = "form-group">
    <div class = "col-md-2">
    <label class = "control-label">Nama Pegawai </label>
    </div>
    <div class = "col-md-4">
    <input type='text' class='form-control' value="{{employee_name}}" disabled/>
    </div>
    <div class = "col-md-2">
    <label class = "control-label">NIP </label>
    </div>
    <div class = "col-md-4">
    <input type='text' class='form-control' value="{{employee_nip}}" disabled/>
    </div>
    </div>
    <div class = "form-group">
    <div class = "col-md-2">
    <label class = "control-label">Departemen </label>
    </div>
    <div class = "col-md-4">
    <input type='text' class='form-control' value="{{employee_department}}" disabled/>
    </div>
    <div class = "col-md-2">
    <label class = "control-label">Jabatan </label>
    </div>
    <div class = "col-md-4">
    <input type='text' class='form-control' value="{{employee_office}}" disabled/>
    </div>
    </div>
</script>
<script type="x-tmpl-mustache" id="tmpl-operator">
    <div class = "form-group">
    <div class = "col-md-2">
    <label class = "control-label">Nama Pegawai </label>
    </div>
    <div class = "col-md-4">
    <input type='text' class='form-control' value="{{operator_name}}" disabled/>
    </div>
    <div class = "col-md-2">
    <label class = "control-label">NIP </label>
    </div>
    <div class = "col-md-4">
    <input type='text' class='form-control' value="{{operator_nip}}" disabled/>
    </div>
    </div>
    <div class = "form-group">
    <div class = "col-md-2">
    <label class = "control-label">Departemen </label>
    </div>
    <div class = "col-md-4">
    <input type='text' class='form-control' value="{{operator_department}}" disabled/>
    </div>
    <div class = "col-md-2">
    <label class = "control-label">Jabatan </label>
    </div>
    <div class = "col-md-4">
    <input type='text' class='form-control' value="{{operator_office}}" disabled/>
    </div>
    </div>
</script>
<script type="x-tmpl-mustache" id="tmpl-conversion">
    <div class = "form-group">
    <div class = "col-md-2">
    <label class = "control-label">Nomor Konversi </label>
    </div>
    <div class = "col-md-4">
    <input type='text' class='form-control' value="{{conversion_number}}" disabled/>
    </div>
    <div class = "col-md-2">
    <label class = "control-label">Tanggal Konversi </label>
    </div>
    <div class = "col-md-4">
    <input type='text' class='form-control' value="{{conversion_date}}" disabled/>
    </div>
    </div>
</script>
<script type="x-tmpl-mustache" id="tmpl-content-tab">
    <div class="tab-pane fade {{in_active}}" id="justified-pill{{nomor}}">
    <div class="panel-heading" style="background:#2179cc">
    <h6 class="panel-title" style=" color:#fff"><i class="icon-user"></i><?= __("Data Pegawai Yang Memasukkan Data") ?></h6>
    </div>
    <br>
    <div class="table-responsive" id="target-employee{{nomor}}">
    </div>
    <div class="panel-heading" style="background:#2179cc">
    <h6 class="panel-title" style=" color:#fff"><i class="icon-user"></i><?= __("Data Pelaksana Konversi") ?></h6>
    </div>
    <br>
    <div class="table-responsive" id="target-operator{{nomor}}">
    </div>
    <div class = "form-group">
    <div class = "col-md-2">
    <label class = "control-label">Tanggal Mulai Konversi</label>
    </div>
    <div class = "col-md-4">
    <input type='text' class='form-control' value="{{start_date}}" disabled/>
    </div>
    <div class = "col-md-2">
    <label class = "control-label">Tanggal Selesai Konversi</label>
    </div>
    <div class = "col-md-4">
    <input type='text' class='form-control' value="{{end_date}}" disabled/>
    </div>
    </div>
    <div class="panel-heading" style="background:#2179cc">
    <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Hasil Konversi") ?></h6>
    </div>
    <br>
    <div class="table-responsive" id="target-conversion{{nomor}}">
    </div>
    <table width="100%" class="table table-hover table-bordered stn-table">
    <thead>
    <tr>
    <th width="50">No</th>
    <th width = "300">Nama Material</th>
    <th width = "175">Grade</th>
    <th width = "175">Alasan Turun Grade</th>
    <th width = "150" colspan = "2">Berat Ikan</th>
    </tr>
    </thead>
    <tbody id="target-detail-transaction{{nomor}}">
    </tbody>
    <tfoot>
    <tr>
    <td colspan = 4 class= "text-right">
    <strong>Berat Konversi</strong>
    </td>
    <td class="text-right" style="border-right-style:none;">
    {{conversion_weight}}
    </td> 
    <td class = "text-left" style= "width:50px; border-left-style:none;">
    Kg
    </td>  
    </tr>
    <tr>
    <td colspan = 4 class= "text-right">
    <strong>Ratio Konversi</strong>
    </td>
    <td class="text-right" style="border-right-style:none;">
    {{conversion_ratio}}
    </td> 
    <td class = "text-left" style= "width:50px; border-left-style:none;">
    %
    </td> 
    </tr>
    </tfoot>
    </table>
    <br><br>
    <table width="100%" class="table table-hover table-bordered stn-table">
    <div class="panel-heading" style="background:#2179cc">
    <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Data Ikan Yang Diproses") ?></h6>
    </div>
    <thead>
    <tr>
    <th width="50">No</th>
    <th>Nama Material</th>
    <th width = "200">Grade</th>
    <th width = "200" colspan="2">Berat Ikan</th>
    </tr>
    </thead>
    <tbody id="target-detail-processed-material{{nomor}}">
    </tbody>
    <tfoot>
    <tr>
    <td colspan = 3 class= "text-right">
    <strong>Berat Total Ikan yang Diproses</strong>
    </td>
    <td class="text-right" id="processWeight{{nomor}}" style="border-right-style:none;">
    </td> 
    <td class = "text-left" style= "width:50px; border-left-style:none;">
    Kg
    </td>
    </tr>
    </tfoot>
    </table>
    <br><br>
    <div class="table-responsive" id="target-note{{nomor}}">
    </div>
    </div>                    
</script>
<script type="x-tmpl-mustache" id="tmpl-processed-material">
    <tr class="dynamic-row processed-material-data">
    <td class="text-center nomorIdx">{{index}}</td>
    <td class="text-left">
    {{grade}}
    </td> 
    <td class="text-center">
    {{size}}
    </td>
    <td class="text-right" style="border-right-style:none;">
    {{weight}}
    </td> 
    <td class = "text-left" style= "width:50px; border-left-style:none;">
    Kg
    </td>       
    </tr>
</script>
<script type="x-tmpl-mustache" id="tmpl-note">
    <div class="panel-heading" style="background:#2179cc">
    <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Keterangan") ?></h6>
    </div>
    <div class="row">
    <div class='col-md-12'>
    <div>{{{note}}}</div>
    </div>
    </div>
</script>