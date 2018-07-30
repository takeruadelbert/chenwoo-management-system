<?php
echo $this->element(_TEMPLATE_DIR . "/{$template}/filter/material_entry_freeze");
?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("DATA PROSES STYLING") ?>
                <div class="pull-right">
                    <button class="btn btn-xs btn-default" type="button" onclick="exp('print', '<?php echo Router::url("freeze/print?" . $_SERVER['QUERY_STRING'], true) ?>')">
                        <i class="icon-print2"></i> 
                        <?= __("Cetak") ?>
                    </button>&nbsp;
                    <button class="btn btn-xs btn-default" type="button" onclick="exp('excel', '<?php echo Router::url("freeze/excel?" . $_SERVER['QUERY_STRING'], true) ?>')">
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
                            <th><?= __("Jenis Material") ?></th>
                            <th><?= __("Tanggal Nota Timbang") ?></th>
                            <th><?= __("Supplier") ?></th>
                            <th><?= __("Total Konversi / Loin") ?></th>
                            <th><?= __("Sisa Konversi / Loin") ?></th>
                            <?php
                            if ($stnAdmin->branchPrivilege()) {
                                ?>
                                <th><?= __("Cabang") ?></th>
                                <?php
                            }
                            ?>
                            <th><?= __("Status") ?></th>
                            <th width="125">Jumlah Styling<br/>Tidak Sesuai Rasio</th>
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
                                <td class = "text-center" colspan = "12">Tidak Ada Data</td>
                            </tr>
                            <?php
                        } else {
                            foreach ($data['rows'] as $item) {
                                ?>
                                <tr id="row-<?= $i ?>" class="removeRow<?php echo $item["MaterialEntry"]['id']; ?>">
                                    <td class="text-center"><input type="checkbox" name="data[<?php echo Inflector::classify($this->params['controller']) ?>][checkbox][]" value="<?php echo $item["MaterialEntry"]['id']; ?>"  id="checkBoxRow" class="styled checkboxDeleteRow" /></td>
                                    <td class="text-center"><?= $i ?></td>
                                    <td class="text-center"><?php echo $item['MaterialEntry']['material_entry_number']; ?></td>
                                    <td class="text-center"><?= $item['MaterialCategory']['name'] ?></td>
                                    <td class="text-center"><?php echo!empty($item['MaterialEntry']['id']) ? $this->Html->cvtTanggal($item['MaterialEntry']['weight_date'], false) : "-" ?></td>
                                    <td class="text-left"><?php echo $this->Echo->empty_strip($item['Supplier']['name']); ?></td>
                                    <td class="text-center">
                                        <?php
                                        if ($item["MaterialEntry"]["material_category_id"] == 2) {
                                            $total = 0;
                                            $remaining = 0;
                                            foreach ($item['MaterialEntryGrade'] as $grade) {
                                                $total += 1;
                                                $remaining+= $grade['remaining_weight'];
//                                                if (!$grade['is_used']) {
//                                                    $remaining++;
//                                                }
                                            }
                                            echo $total . " Loin";
                                        }else if ($item["MaterialEntry"]["material_category_id"] == 3) {
                                            $total = 0;
                                            $remaining = 0;
                                            foreach ($item['MaterialEntryGrade'] as $grade) {
                                                $total += 1;
                                                $remaining+= $grade['remaining_weight'];
//                                                if (!$grade['is_used']) {
//                                                    $remaining++;
//                                                }
                                            }
                                            echo $total . " Pcs";
                                        } else {
                                            $total = 0;
                                            $remaining = 0;
                                            foreach ($item['Conversion'] as $grade) {
                                                $total += 1;
                                                if (!isset($grade['Freeze']['id'])) {
                                                    $remaining++;
                                                }
                                            }
                                            echo $total . " Konversi";
                                        }
                                        ?>
                                    </td>
                                    <td class="text-center">
                                        <?php
                                        if ($item["MaterialEntry"]["material_category_id"] == 2 || $item["MaterialEntry"]["material_category_id"] == 3) {
                                            ?>
                                            <span class="label label-<?= $remaining > 0 ? "warning" : "success" ?>"><?= $remaining . " Kg"; ?></span>
                                            <?php
                                        } else if (count($item["Conversion"]) == 0) {
                                            ?>
                                            <span class="label label-info">Belum ada konversi</span>
                                            <?php
                                        } else {
                                            ?>
                                            <span class="label label-<?= $remaining > 0 ? "warning" : "success" ?>"><?= $remaining . " Konversi"; ?></span>
                                            <?php
                                        }
                                        ?>
                                    </td>
                                    <?php
                                    if ($stnAdmin->branchPrivilege()) {
                                        ?>
                                        <td class="text-left"><?php echo $item["BranchOffice"]['name']; ?></td>
                                        <?php
                                    }
                                    ?>
                                    <td class="text-center"  id = "target-change-status<?= $i ?>">
                                        <?php
                                        if ($item["MaterialEntry"]["material_category_id"] == 1 && count($item["Conversion"]) == 0) {
                                            ?>
                                            <span class="label label-info">Belum ada konversi</span>
                                            <?php
                                        } else {
                                            ?>
                                            <span class="label label-<?= $item["MaterialEntry"]["freezing_status_id"] == 1 ? "danger" : "success" ?>"><?= $item["FreezingStatus"]["name"] ?></span>
                                            <?php
                                        }
                                        ?>
                                    </td>
                                    <td class="text-center">
                                        <?php
                                        $countUnderRatio = 0;
                                        foreach ($item["Freeze"] as $freeze) {
                                            $countUnderRatio+=$freeze["ratio_status_id"] == 4 ? 1 : 0;
                                        }
                                        if ($countUnderRatio > 0) {
                                            ?>
                                            <span class="label label-warning"><?= $countUnderRatio ?> Styling</span>
                                            <?php
                                        } else {
                                            echo "-";
                                        }
                                        ?>
                                    </td>
                                    <td class="text-center">
                                        <?php
                                        $has_finished = [];
                                        foreach ($item['MaterialEntryGrade'] as $index => $detail) {
                                            if ($detail['is_used']) {
                                                $has_finished[$index] = true;
                                            } else {
                                                $has_finished[$index] = false;
                                            }
                                        }
                                        $is_finished = !in_array(false, $has_finished);
                                        if ($remaining > 0 && $item["MaterialEntry"]["material_category_id"] == 1) { //$item["MaterialEntry"]["material_category_id"] == 1 && 
                                            ?>
                                            <a href = "<?= Router::url("/admin/freezes/add_whole/{$item[Inflector::classify($this->params['controller'])]['id']} ", true) ?>" class = "btn btn-default btn-xs btn-icon btn-icon tip" title = "Proses Styling"><i class = "fa fa-snowflake-o fa-lg"></i></a>
                                            <?php
                                        } else if (($item["MaterialEntry"]["material_category_id"] == 2 || $item["MaterialEntry"]["material_category_id"] == 3) && $item["MaterialEntry"]["freezing_status_id"] == 1 && !$is_finished) {
                                            ?>
                                            <a href = "<?= Router::url("/admin/freezes/add_colly/{$item[Inflector::classify($this->params['controller'])]['id']} ", true) ?>" class = "btn btn-default btn-xs btn-icon btn-icon tip" title = "Proses Styling"><i class = "fa fa-snowflake-o fa-lg"></i></a>
                                            <?php
                                        }
                                        ?>
                                        <a data-toggle="modal" data-material-entry-id="<?= $item['MaterialEntry']['id'] ?>" role="button" href="#default-lihatConversion" class="btn btn-default btn-xs btn-icon btn-icon tip viewData" title="Lihat Data"><i class="icon-eye7"></i></a>
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
                        <h6 class="heading-hr">LIHAT DATA PROSES STYLING
                            <small class="display-block"><?= _APP_CORPORATE_FULL ?></small>
                        </h6>
                    </div>
                    <div class = "well block">
                        <div class = "tabbable">
                            <ul class = "nav nav-pills nav-justified" id = "targetTitleTab">

                            </ul>
                            <div class = "tab-content pill-content" id = "targetContentTab">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class = "modal-footer">
                <button type = "button" class = "btn btn-info" data-dismiss = "modal">Tutup Form</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        var remaining = <?= $remaining ?>;
        $(".viewData").click(function () {
            $("tr.transaction-material-data").html("");
            $("#targetTitleTab").html("");
            $("#targetContentTab").html("");
            //            var conversionId = $(this).data("conversion-id");
            var materialEntryId = $(this).data("material-entry-id");
            var e = $("tr.dynamic-row-conversion");
            $.ajax({
                url: BASE_URL + "freezes/get_data_material_entry/" + materialEntryId,
                type: "GET",
                dataType: "JSON",
                success: function (response) {
                    if (response.status == 206) {
                        var i = 1;
                        var nomor = 1;
                        var warning = "";
                        var update = "";
                        var is_active = "";
                        var in_active = "";
                        var number = 1;
                        var data = response.data[0];
//                        var warning = "";
                        if (data.MaterialEntry.material_category_id == 1) {
                            if (data.Conversion == "") {
                                $("div#targetContentTab").append("<div class='text-center text-danger'><h2>Belum ada data Konversi!</h2></div>");
                            } else {
                                $.each(response.data, function (indexData, data) {
                                    $.each(data.Conversion, function (index, value) {
                                        if (value.id != null) {
                                            var conversion_weight = value.total;
                                            var conversion_ratio = value.ratio;
                                            var freeze_weight = value.Freeze.total_weight;
                                            var freeze_ratio = value.Freeze.ratio;
                                            var start_date = cvtTanggal(value.Freeze.start_date);
                                            var end_date = cvtTanggal(value.Freeze.end_date);
                                            var titleTabTemplate = $("#tmpl-title-tab").html();
                                            var contentTabTemplate = $("#tmpl-content-tab").html();
                                            Mustache.parse(titleTabTemplate);
                                            Mustache.parse(contentTabTemplate);
                                            if (index == 0) {
                                                is_active = "active";
                                                in_active = "tab-pane fade in active";
                                            } else {
                                                is_active = "";
                                                in_active = "";
                                            }
                                            if (value.ratio_status_id == 4) {
                                                warning = "icon-warning";
                                            } else {
                                                warning = "";
                                            }
                                            if (isEmpty(value.Freeze)) {
                                                update = "icon-plus-circle";
                                            } else {
                                                update = "";
                                            }
                                            var options = {
                                                nomor: nomor,
                                                is_active: is_active,
                                                in_active: in_active,
                                                title_tab: "Konversi " + nomor,
                                                can_be_process: value.verify_status_id == 3 ? true : false,
                                                warning: warning,
                                                update: update,
                                                conversion_weight: ic_kg(conversion_weight),
                                                conversion_ratio: ic_persen(conversion_ratio),
                                                freeze_weight: ic_kg(freeze_weight),
                                                freeze_ratio: ic_persen(freeze_ratio),
                                                start_date: start_date,
                                                end_date: end_date
                                            };
                                            var rendered = Mustache.render(titleTabTemplate, options);
                                            var rendered2 = Mustache.render(contentTabTemplate, options);
                                            $("#targetTitleTab").append(rendered);
                                            $("#targetContentTab").append(rendered2);
                                            $("#ConversionNoConversion").val(value.no_conversion);
                                            //data NAMA PEGAWAI KONVERSI
                                            var emp = value.Employee;
                                            var employee_name_conv = emp.Account.Biodata.full_name;
                                            var employee_nip_conv = emp.nip;
                                            var employee_office_conv = emp.Office.name;
                                            var employee_department_conv = emp.Department.name;
                                            var template_emp_conv = $("#tmpl-employee-conv").html();
                                            Mustache.parse(template_emp_conv);
                                            var options = {
                                                employee_name_conv: employee_name_conv,
                                                employee_nip_conv: employee_nip_conv,
                                                employee_office_conv: employee_office_conv,
                                                employee_department_conv: employee_department_conv,
                                            };
                                            var rendered_emp_conv = Mustache.render(template_emp_conv, options);
                                            $("#target-employee-conversion" + nomor).append(rendered_emp_conv);

                                            //DATA KONVERSI
                                            var conversion = value;
                                            var conversion_number = conversion.no_conversion;
                                            var conversion_date = cvtTanggal(conversion.created);
                                            var template_conversion = $("#tmpl-conversion").html();
                                            Mustache.parse(template_conversion);
                                            var options = {
                                                conversion_number: conversion_number,
                                                conversion_date: conversion_date,
                                            };
                                            var rendered_conversion = Mustache.render(template_conversion, options);
                                            $("#target-conversion" + nomor).append(rendered_conversion);

                                            $.each(value.ConversionData, function (j, val) {
//                                                var name = val.MaterialDetail.Material.name + " " + val.MaterialDetail.name;
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
                                                    rejectedGradeType: rejectedGradeType,
                                                    weight: ic_kg(weight),
                                                };
                                                var render = Mustache.render(template3, options);
                                                $("#target-detail-transaction" + i).append(render);
                                            });
                                            var conversionId = value.id;
                                            if (isEmpty(value.Freeze)) {
                                                $("#pegawaiDataFreezing" + (index + 1)).hide();
                                                $("#hasilFreezing" + (index + 1)).hide();
                                            } else {
                                                $("#pegawaiDataFreezing").show();
                                                $("#hasilFreezing").show();
                                            }
                                            if (value.Freeze.length != 0) {
                                                //data NAMA OPERATOR
                                                var operator = value.Freeze.Operator;
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
                                                $("#target-operator" + nomor).append(rendered_operator);

                                                //data NAMA PEGAWAI produksi tahap 1
                                                var emp = value.Freeze.Employee;
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
                                                $("#target-employee" + nomor).append(rendered_emp);

                                                //DATA FREEZE
                                                var freeze = value.Freeze;
                                                var freeze_number = freeze.freeze_number;
                                                var freeze_date = cvtTanggal(freeze.created);
                                                var template_freeze = $("#tmpl-freeze").html();
                                                Mustache.parse(template_freeze);
                                                var options = {
                                                    freeze_number: freeze_number,
                                                    freeze_date: freeze_date,
                                                };
                                                var rendered_freeze = Mustache.render(template_freeze, options);
                                                $("#target-freeze" + nomor).append(rendered_freeze);

                                                //alert(value.id);
                                                if (value.Freeze.id == undefined) {
                                                    var href = "";
                                                    if (data.MaterialEntry.material_category_id == 1) { //if Whole
                                                        href = BASE_URL + "admin/freezes/add_whole?id=" + conversionId;
                                                    }
                                                    $("#content-freeze" + nomor).hide();
                                                    $("#add" + nomor).attr("href", href);
                                                    $("#boxAdd" + nomor).show();
                                                } else {
                                                    $.each(value.Freeze.FreezeDetail, function (j, val) {
                                                        var name = val.Product.Parent.name + " " + val.Product.name;
                                                        var weight = val.weight;
                                                        if (val.rejected_grade_type_id == null) {
                                                            var reject_type = "-";
                                                        } else {
                                                            var reject_type = val.RejectedGradeType.name;
                                                        }
                                                        var template3 = $('#tmpl-material-freeze').html();
                                                        Mustache.parse(template3);
                                                        var options = {
                                                            index: j + 1,
                                                            name: name,
                                                            reject_type: reject_type,
                                                            weight: ic_kg(weight),
                                                        };
                                                        var render = Mustache.render(template3, options);
                                                        $("#target-detail-freeze" + i).append(render);
                                                    });
                                                    $("#content-freeze" + nomor).show();
                                                    $("#boxAdd" + nomor).hide();
                                                }
                                                var temp = value.Freeze.note;
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
                                                $("#target-note" + nomor).append(rendered);
                                            }
                                            i++;
                                            nomor++;
                                        }
                                        //Check if freeze not exist then show button
                                    });
                                });
                            }
//                        } else if (data.Conversion == "") {
//                            alert("aaa");
//                            $("div#targetContentTab").append("<div class='text-center text-danger'><h2>Belum ada data Konversi!</h2></div>");
                        } else if (data.MaterialEntry.material_category_id == 2 || data.MaterialEntry.material_category_id == 3) {
                            var nomor = 1;
                            if (data.Freeze == "") {
                                $("div#targetContentTab").append("<div class='text-center text-danger'><h2>Belum ada data Styling!</h2></div>");
                            } else {
                                $.each(data.Freeze, function (indexData, dataFreeze) {
                                    if (nomor == 1) {
                                        is_active = "active";
                                        in_active = "tab-pane fade in active";
                                    } else {
                                        is_active = "";
                                        in_active = "";
                                    }
                                    if (dataFreeze.ratio_status_id == 4) {
                                        warning = "icon-warning";
                                    } else {
                                        warning = "";
                                    }
                                    var titleTabTemplate = $("#tmpl-title-tab").html();
                                    var contentTabTemplate = $("#tmpl-content-loin").html();
                                    Mustache.parse(titleTabTemplate);
                                    Mustache.parse(contentTabTemplate);
                                    var freeze_weight = dataFreeze.total_weight;
                                    var freeze_ratio = dataFreeze.ratio;
                                    var start_date = cvtTanggal(dataFreeze.start_date);
                                    var end_date = cvtTanggal(dataFreeze.end_date);
                                    var options = {
                                        nomor: nomor,
                                        is_active: is_active,
                                        in_active: in_active,
                                        title_tab: "Nota Timbang " + nomor,
                                        freeze_weight: ic_kg(freeze_weight),
                                        freeze_ratio: ic_persen(freeze_ratio),
                                        start_date: start_date,
                                        end_date: end_date
                                    };
                                    var rendered = Mustache.render(titleTabTemplate, options);
                                    var rendered2 = Mustache.render(contentTabTemplate, options);
                                    $("#targetTitleTab").append(rendered);
                                    $("#targetContentTab").append(rendered2);

                                    //                                $("#template-freeze-result" + i).append(rendered3);
                                    $.each(data.MaterialEntryGrade, function (j, val) {
                                        //if(val.is_used == 1) {
//                                        var name = val.MaterialDetail.Material.name + " " + val.MaterialDetail.name;
                                        var name = val.MaterialDetail.name;
                                        var size = val.MaterialSize.name;
                                        var weight = val.weight;
                                        var template3 = $('#tmpl-material-loin').html();
                                        Mustache.parse(template3);
                                        var options = {
                                            index: j + 1,
                                            name: name,
                                            size: size,
                                            weight: ic_kg(weight),
                                        };
                                        var render = Mustache.render(template3, options);
                                        $("tbody#target-detail-transaction-loin" + nomor).append(render);
                                        //}
                                    });
                                    var materialEntryId = data.MaterialEntry.id;

                                    //data NAMA PEGAWAI MATERIAL ENTRY
                                    var emp = data.Employee;
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
                                    $("#target-employee-material-entry" + nomor).append(rendered_emp);

                                    //DATA MATERIAL ENTRY
                                    var material_entry = data;
                                    var material_entry_number = material_entry.MaterialEntry.material_entry_number;
                                    var material_entry_date = cvtTanggal(material_entry.MaterialEntry.created);
                                    var material_entry_supplier = material_entry.Supplier.name;
                                    var template_material_entry = $("#tmpl-material-entry").html();
                                    Mustache.parse(template_material_entry);
                                    var options = {
                                        material_entry_number: material_entry_number,
                                        material_entry_date: material_entry_date,
                                        material_entry_supplier: material_entry_supplier,
                                    };
                                    var rendered_material_entry = Mustache.render(template_material_entry, options);
                                    $("#target-material-entry" + nomor).append(rendered_material_entry);

                                    if (isEmpty(dataFreeze)) {
                                        $("#pegawaiDataFreezingLoin" + nomor).hide();
                                        $("#hasilFreezingLoin" + nomor).hide();
                                    } else {
                                        $("#pegawaiDataFreezingLoin" + nomor).show();
                                        $("#hasilFreezingLoin" + nomor).show();
                                    }

                                    //data NAMA PEGAWAI produksi tahap 1
                                    var emp = dataFreeze.Employee;
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
                                    $("#target-employee" + nomor).append(rendered_emp);
                                    //data NAMA OPERATOR
                                    var operator = dataFreeze.Operator;
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
                                    $("#target-operator" + nomor).append(rendered_operator);

                                    //DATA FREEZE
//                                    console.log(dataFreeze);
                                    var freeze = dataFreeze;
                                    var freeze_number = freeze.freeze_number;
                                    var freeze_date = cvtTanggal(freeze.created);
                                    var template_freeze = $("#tmpl-freeze").html();
                                    Mustache.parse(template_freeze);
                                    var options = {
                                        freeze_number: freeze_number,
                                        freeze_date: freeze_date,
                                    };
                                    var rendered_freeze = Mustache.render(template_freeze, options);
                                    $("#target-freeze" + nomor).append(rendered_freeze);
                                    if (dataFreeze.id == undefined) {
                                        var href = "";
                                        if (data.MaterialEntry.material_category_id == 2 || data.MaterialEntry.material_category_id == 3) { //if Colly
                                            href = BASE_URL + "admin/freezes/add_colly?id=" + materialEntryId;
                                        }
                                        $("#content-freeze" + nomor).hide();
                                        $("#add" + nomor).attr("href", href);
                                        $("#boxAdd" + nomor).show();
                                        var template3 = $('#tmpl-material-data-empty').html();
                                        Mustache.parse(template3);
                                        var render = Mustache.render(template3, "");
                                        $("#target-detail-freeze" + nomor).append(render);
                                    } else {
                                        $.each(dataFreeze.FreezeDetail, function (j, val) {
                                            var name = val.Product.Parent.name + " " + val.Product.name;
                                            var weight = val.weight;
                                            if (val.rejected_grade_type_id == null) {
                                                var reject_type = "-";
                                            } else {
                                                var reject_type = val.RejectedGradeType.name;
                                            }
                                            var template3 = $('#tmpl-material-freeze').html();
                                            Mustache.parse(template3);
                                            var options = {
                                                index: j + 1,
                                                name: name,
                                                reject_type: reject_type,
                                                weight: ic_kg(weight),
                                            };
                                            var render = Mustache.render(template3, options);
                                            $("#target-detail-freeze" + nomor).append(render);
                                        });
                                        $("#content-freeze" + nomor).show();
                                        $("#boxAdd" + nomor).hide();
                                    }
                                    var source_weight = 0;
                                    $.each(dataFreeze.FreezeSourceDetail, function (j, source) {
//                                        var name = source.MaterialEntryGrade.MaterialDetail.Material.name + " " + source.MaterialEntryGrade.MaterialDetail.name;
                                        var name = source.MaterialEntryGrade.MaterialDetail.name;
                                        var size = source.MaterialEntryGrade.MaterialSize.name;
                                        source_weight += parseFloat(source.MaterialEntryGrade.weight);
                                        if(j == dataFreeze.FreezeSourceDetail.length - 1) {
                                            var template7 = $('#tmpl-beratIkanDiproses').html();
                                            Mustache.parse(template7);
                                            var options = {
                                                source_weight: ic_kg(source_weight),
                                            };
                                            var render = Mustache.render(template7, options);
                                            $("#target-beratIkanDiproses" + nomor).append(render);
                                        }
                                        $.each(source.MaterialEntryGrade.MaterialEntryGradeDetail, function (idx, details) {
                                            var detail_weight = details.weight;
                                            var template4 = $('#tmpl-source-detail').html();
                                            Mustache.parse(template4);
                                            var options = {
                                                index: j + 1,
                                                name: name,
                                                size: size,
                                                source_weight: ic_kg(source_weight),
                                                detail_weight: ic_kg(detail_weight),
                                            };
                                            var render = Mustache.render(template4, options);
                                            $("#target-source-freeze-detail" + nomor).append(render);
                                            //}
                                        });
                                    });
                                    var temp = dataFreeze.note;
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
                                    $("#target-note" + nomor).append(rendered);
                                    nomor++;
                                });
                            }
                        }
                    } else {
                        //                        $("#ConversionNoConversion").val("");
                        //                        var template = $("#tmpl-material-data-empty").html();
                        //                        Mustache.parse(template);
                        //                        var options = {};
                        //                        var rendered = Mustache.render(template, options);
                        //                        $("#target-detail-transaction").append(rendered);
                        //                        $("#add").show();
                        //                        var href = BASE_URL + "admin/conversions/conversion_process/" + materialEntryId;
                        //                        $("#add").attr("href", href);
                    }
                }
            });
        });

        // http://stackoverflow.com/questions/4994201/is-object-empty
        var hasOwnProperty = Object.prototype.hasOwnProperty;
        function isEmpty(obj) {
            // null and undefined are "empty"
            if (obj == null)
                return true;

            // Assume if it has a length property with a non-zero value
            // that that property is correct.
            if (obj.length > 0)
                return false;
            if (obj.length === 0)
                return true;

            // If it isn't an object at this point
            // it is empty, but it can't be anything *but* empty
            // Is it empty?  Depends on your application.
            if (typeof obj !== "object")
                return true;

            // Otherwise, does it have any properties of its own?
            // Note that this doesn't handle
            // toString and valueOf enumeration bugs in IE < 9
            for (var key in obj) {
                if (hasOwnProperty.call(obj, key))
                    return false;
            }
            return true;
        }
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
<script type="x-tmpl-mustache" id="tmpl-material-loin">
    <tr class="dynamic-row transaction-material-data">
    <td class="text-center nomorIdx" width="2%">{{index}}</td>
    <td class="text-left">
    {{name}}
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
<script type="x-tmpl-mustache" id="tmpl-material-freeze">
    <tr class="dynamic-row transaction-material-data">
    <td class="text-center nomorIdx">{{index}}</td>
    <td class="text-left">
    {{name}}
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
<script type="x-tmpl-mustache" id="tmpl-material-data-empty">
    <tr class="dynamic-row transaction-material-data">
    <td colspan="4" class="text-center">Tidak Ada Data</td>   
    </tr>
</script>
<script type="x-tmpl-mustache" id="tmpl-title-tab">
    <li class="{{is_active}}">
    <a href="#justified-pill{{nomor}}" data-toggle="tab">
    <i class="icon-file6"></i> {{title_tab}}<span class = "pull-right"><i class="{{warning}} text-danger tip" title="Tidak memenuhi rasio"></i><i class="{{update}} text-success tip" title="Belum diproses"></i></span>
    </a>
    </li>
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
<script type="x-tmpl-mustache" id="tmpl-employee-conv">
    <div class = "form-group">
    <div class = "col-md-2">
    <label class = "control-label">Nama Pegawai </label>
    </div>
    <div class = "col-md-4">
    <input type='text' class='form-control' value="{{employee_name_conv}}" disabled/>
    </div>
    <div class = "col-md-2">
    <label class = "control-label">NIP </label>
    </div>
    <div class = "col-md-4">
    <input type='text' class='form-control' value="{{employee_nip_conv}}" disabled/>
    </div>
    </div>
    <div class = "form-group">
    <div class = "col-md-2">
    <label class = "control-label">Departemen </label>
    </div>
    <div class = "col-md-4">
    <input type='text' class='form-control' value="{{employee_department_conv}}" disabled/>
    </div>
    <div class = "col-md-2">
    <label class = "control-label">Jabatan </label>
    </div>
    <div class = "col-md-4">
    <input type='text' class='form-control' value="{{employee_office_conv}}" disabled/>
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
<script type="x-tmpl-mustache" id="tmpl-content-tab">
    <div class="tab-pane fade {{in_active}}" id="justified-pill{{nomor}}">
    <br>
    <div class="panel-heading" style="background:#2179cc">
    <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Data Konversi") ?></h6>
    </div>
    <br>
    <div class="table-responsive" id="target-employee-conversion{{nomor}}">
    </div>
    <div class="table-responsive" id="target-conversion{{nomor}}">
    </div>
    <table width="100%" class="table table-hover table-bordered stn-table">
    <thead>
    <tr>
    <th width="50">No</th>
    <th>Nama Material</th>
    <th width = "150">Grade</th>
    <th width = "150">Alasan Turun Grade</th>
    <th width = "250" colspan="2">Berat Ikan</th>
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
    <br>
    <div id = "pegawaiDataFreezing{{nomor}}">
    <div class="panel-heading" style="background:#2179cc" id = "pegawaiDataFreezing{{nomor}}">
    <h6 class="panel-title" style=" color:#fff"><i class="icon-user"></i><?= __("Data Pegawai Yang Memasukkan Data Styling") ?></h6>
    </div>
    <br>
    <div class="table-responsive" id="target-employee{{nomor}}">
    </div>
    <div class="panel-heading" style="background:#2179cc">
    <h6 class="panel-title" style=" color:#fff"><i class="icon-user"></i><?= __("Data Pelaksana Styling") ?></h6>
    </div>
    <br>
    <div class="table-responsive" id="target-operator{{nomor}}">
    </div>
    <div class = "form-group">
    <div class = "col-md-2">
    <label class = "control-label">Tanggal Mulai Styling </label>
    </div>
    <div class = "col-md-4">
    <input type='text' class='form-control' value="{{start_date}}" disabled/>
    </div>
    <div class = "col-md-2">
    <label class = "control-label">Tanggal Selesai Styling </label>
    </div>
    <div class = "col-md-4">
    <input type='text' class='form-control' value="{{end_date}}" disabled/>
    </div>
    </div>
    </div>
    <div id = "hasilFreezing{{nomor}}">
    <div class="panel-heading" style="background:#2179cc">
    <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Hasil Styling") ?></h6>
    </div>
    <br>
    <div class="table-responsive" id="target-freeze{{nomor}}">
    </div>
    <table width="100%" class="table table-hover table-bordered stn-table">
    <thead>
    <tr>
    <th width="50">No</th>
    <th>Produk</th>
    <th width="250">Alasan Turun Grade</th>
    <th width = "250" colspan = "2">Berat Ikan</th>
    </tr>
    </thead>
    <tbody id="target-detail-freeze{{nomor}}">
    </tbody>
    <tfoot>
    <tr>
    <td colspan = 3 class= "text-right">
    <strong>Berat Styling</strong>
    </td>
    <td class="text-right" style="border-right-style:none;">
    {{freeze_weight}}
    </td> 
    <td class = "text-left" style= "width:50px; border-left-style:none;">
    Kg
    </td>  
    </tr>
    <tr>
    <td colspan = 3 class= "text-right">
    <strong>Ratio Styling</strong>
    </td>
    <td class="text-right" style="border-right-style:none;">
    {{freeze_ratio}}
    </td> 
    <td class = "text-left" style= "width:50px; border-left-style:none;">
    %
    </td> 
    </tr>
    </tfoot>
    </table>
    <br><br>
    <div class="table-responsive" id="target-note{{nomor}}">
    </div>
    </div> 
    </div>                    
</script>
<script type="x-tmpl-mustache" id="tmpl-freeze">
    <div class = "form-group">
    <div class = "col-md-2">
    <label class = "control-label">Nomor Styling </label>
    </div>
    <div class = "col-md-4">
    <input type='text' class='form-control' value="{{freeze_number}}" disabled/>
    </div>
    <div class = "col-md-2">
    <label class = "control-label">Tanggal Styling </label>
    </div>
    <div class = "col-md-4">
    <input type='text' class='form-control' value="{{freeze_date}}" disabled/>
    </div>
    </div>
</script>
<script type="x-tmpl-mustache" id="tmpl-material-entry">
    <div class = "form-group">
    <div class = "col-md-2">
    <label class = "control-label">Nomor Nota Timbang </label>
    </div>
    <div class = "col-md-4">
    <input type='text' class='form-control' value="{{material_entry_number}}" disabled/>
    </div>
    <div class = "col-md-2">
    <label class = "control-label">Tanggal Dibuat </label>
    </div>
    <div class = "col-md-4">
    <input type='text' class='form-control' value="{{material_entry_date}}" disabled/>
    </div>
    </div>
    <div class = "form-group">
    <div class = "col-md-2">
    <label class = "control-label">Supplier </label>
    </div>
    <div class = "col-md-4">
    <input type='text' class='form-control' value="{{material_entry_supplier}}" disabled/>
    </div>
    <div class = "col-md-2">
    <label class = "control-label">Basket </label>
    </div>
    </div>
</script>
<script type="x-tmpl-mustache" id="tmpl-content-loin">
    <div class="tab-pane fade {{in_active}}" id="justified-pill{{nomor}}">
    <div class="panel-heading" style="background:#2179cc">
    <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Nota Timbang") ?></h6>
    </div>
    <br>
    <div class="table-responsive" id="target-employee-material-entry{{nomor}}">
    </div>
    <div class="table-responsive" id="target-material-entry{{nomor}}">
    </div>
    <table width="100%" class="table table-hover table-bordered stn-table">
    <thead>
    <tr>
    <th width="50">No</th>
    <th>Nama Material</th>
    <th width = "250">Grade</th>
    <th width = "250" colspan = "2">Berat Ikan</th>
    </tr>
    </thead>
    <tbody id="target-detail-transaction-loin{{nomor}}">
    </tbody>
    </table>
    <br>
    <div id = "pegawaiDataFreezingLoin{{nomor}}">
    <div class="panel-heading" style="background:#2179cc" id = "pegawaiDataFreezing{{nomor}}">
    <h6 class="panel-title" style=" color:#fff"><i class="icon-user"></i><?= __("Data Pegawai Yang Memasukkan Data Freezing") ?></h6>
    </div>
    <br>
    <div class="table-responsive" id="target-employee{{nomor}}">
    </div>
    <div class="panel-heading" style="background:#2179cc">
    <h6 class="panel-title" style=" color:#fff"><i class="icon-user"></i><?= __("Data Pelaksana Freezing") ?></h6>
    </div>
    <br>
    <div class="table-responsive" id="target-operator{{nomor}}">
    </div>
    <div class = "form-group">
    <div class = "col-md-2">
    <label class = "control-label">Tanggal Awal </label>
    </div>
    <div class = "col-md-4">
    <input type='text' class='form-control' value="{{start_date}}" disabled/>
    </div>
    <div class = "col-md-2">
    <label class = "control-label">Tanggal Akhir </label>
    </div>
    <div class = "col-md-4">
    <input type='text' class='form-control' value="{{end_date}}" disabled/>
    </div>
    </div>
    </div>
    <div id = "hasilFreezingLoin{{nomor}}">
    <div class="panel-heading" style="background:#2179cc">
    <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Hasil Freezing") ?></h6>
    </div>
    <br>
    <div class="table-responsive" id="target-freeze{{nomor}}">
    </div>
    <table width="100%" class="table table-hover table-bordered stn-table">
    <thead>
    <tr>
    <th width="50">No</th>
    <th>Produk</th>
    <th width="250">Alasan Turun Grade</th>
    <th width="250" colspan="2">Berat Ikan</th>
    </tr>
    </thead>
    <tbody id="target-detail-freeze{{nomor}}">
    </tbody>
    <tfoot>
    <tr>
    <td colspan = 3 class= "text-right">
    <strong>Berat Konversi</strong>
    </td>
    <td class="text-right" style="border-right-style:none;">
    {{freeze_weight}}
    </td> 
    <td class = "text-left" style= "width:50px; border-left-style:none;">
    Kg
    </td>  
    </tr>
    <tr>
    <td colspan = 3 class= "text-right">
    <strong>Ratio Konversi</strong>
    </td>
    <td class="text-right" style="border-right-style:none;">
    {{freeze_ratio}}
    </td> 
    <td class = "text-left" style= "width:50px; border-left-style:none;">
    %
    </td> 
    </tr>
    </tfoot>
    </table>
    <br>
    <div class="panel-heading" style="background:#2179cc">
    <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Data Ikan Yang Diproses") ?></h6>
    </div>
    <br>
    <table width="100%" class="table table-hover table-bordered stn-table">
    <thead>
    <tr>
    <th width="50">No</th>
    <th>Nama Material</th>
    <th width="250">Grade</th>
    <th width="250" colspan="2">Berat</th>
    </tr>
    </thead>
    <tbody id="target-source-freeze-detail{{nomor}}">
    </tbody>
    <tfoot id="target-beratIkanDiproses{{nomor}}">
    </tfoot>
    </table>
    <br>
    <div class="table-responsive" id="target-note{{nomor}}">
    </div>
    </div> 
    </div>                     
</script>
<script type="x-tmpl-mustache" id="tmpl-source-detail">
    <tr class="dynamic-row">
    <td class="text-center nomorIdx">{{index}}</td>
    <td class="text-left">
    {{name}}
    </td> 
    <td class="text-center">
    {{size}}
    </td> 
    <td class="text-right" style="border-right-style:none;">
    {{detail_weight}}
    </td> 
    <td class = "text-left" style= "width:50px; border-left-style:none;">
    Kg
    </td>        
    </tr>
</script>
<script type="x-tmpl-mustache" id="tmpl-beratIkanDiproses">
    <tr>
    <td colspan = 3 class= "text-right">
    <strong>Berat Ikan Yang Diproses </strong>
    </td>
    <td class="text-right" style="border-right-style:none;">
    {{source_weight}}
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