<?php
echo $this->element(_TEMPLATE_DIR . "/{$template}/filter/material_entry_treatment");
?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("DATA PROSES TREATMENT (RETOUCHING)") ?>
                <div class="pull-right">
                    <button class="btn btn-xs btn-default" type="button" onclick="exp('print', '<?php echo Router::url("treatment/print?" . $_SERVER['QUERY_STRING'], true) ?>')">
                        <i class="icon-print2"></i> 
                        <?= __("Cetak") ?>
                    </button>&nbsp;
                    <button class="btn btn-xs btn-default" type="button" onclick="exp('excel', '<?php echo Router::url("treatment/excel?" . $_SERVER['QUERY_STRING'], true) ?>')">
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
                            <th><?= __("Supplier") ?></th>
                            <th><?= __("Total Styling") ?></th>
                            <th><?= __("Berat Tersisa") ?></th>
                            <?php
                            if ($stnAdmin->branchPrivilege()) {
                                ?>
                                <th><?= __("Cabang") ?></th>
                                <?php
                            }
                            ?>
                            <th><?= __("Status") ?></th>
                            <th>Jumlah Treatment<br/>Tidak Sesuai Rasio</th>
                            <th><?= __("Aksi") ?></th>
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
                                <td class = "text-center" colspan = 11>Tidak Ada Data</td>
                            </tr>
                            <?php
                        } else {
//                            debug($data['rows']);
                            foreach ($data['rows'] as $item) {
                                ?>
                                <tr id="row-<?= $i ?>" class="removeRow<?php echo $item["MaterialEntry"]['id']; ?>">
                                    <td class="text-center"><input type="checkbox" name="data[<?php echo Inflector::classify($this->params['controller']) ?>][checkbox][]" value="<?php echo $item["MaterialEntry"]['id']; ?>"  id="checkBoxRow" class="styled checkboxDeleteRow" /></td>
                                    <td class="text-center"><?= $i ?></td>
                                    <td class="text-center"><?php echo $item['MaterialEntry']['material_entry_number']; ?></td>
                                    <td class="text-center"><?php echo!empty($item['MaterialEntry']['id']) ? $this->Html->cvtTanggal($item['MaterialEntry']['weight_date']) : "-" ?></td>
                                    <td class="text-center"><?php echo $this->Echo->empty_strip($item['Supplier']['name']); ?></td>
                                    <td class="text-center">
                                        <?php
                                        $total = 0;
                                        $remaining = 0;
                                        if ($item["MaterialEntry"]['material_category_id'] == 1) { //whole
                                            foreach ($item['Conversion'] as $grade) {
                                                if (isset($grade['Freeze']['id'])) {
                                                    $total +=1;
                                                    if (!isset($grade['Freeze']['Treatment']['id'])) {
                                                        $remaining+=1;
                                                    }
                                                }
                                            }
                                            echo $total . " Styling";
                                        } else {//loin
                                            foreach ($item['Freeze'] as $freeze) {
                                                if (isset($freeze['id'])) {
                                                    $total +=1;
                                                    if (!isset($freeze['Treatment']['id'])) {
                                                        $remaining+=1;
                                                    }
                                                }
                                            }
                                            echo $total . " Styling";
                                        }
                                        ?>
                                    </td>
                                    <td class="text-center">
                                        <?php
                                        $weightRemaining = 0;
                                        $weightRemainingIgnoreMinus = 0;
                                        foreach ($item['Freeze'] as $freeze) {
                                            foreach ($freeze['FreezeDetail'] as $freezeDetail) {
                                                //ignore minus value
                                                if(floatval($freezeDetail['remaining_weight'])>=0){
                                                    $weightRemainingIgnoreMinus += floatval($freezeDetail['remaining_weight']);
                                                }
                                                $weightRemaining+= floatval($freezeDetail['remaining_weight']);
                                            }
                                        }
                                        ?>
                                        <span class="label label-<?= $weightRemaining > 0 ? "warning" : "success" ?>"><?= $weightRemaining . " Kg"; ?></span>
                                    </td>
                                    <?php
                                    if ($stnAdmin->branchPrivilege()) {
                                        ?>
                                        <td class="text-left"><?php echo $item["BranchOffice"]['name']; ?></td>
                                        <?php
                                    }
                                    ?>
                                    <td class="text-center">
                                        <span class="label label-<?= $item["MaterialEntry"]["treatment_status_id"] == 1 ? "danger" : "success" ?>"><?= $item["TreatmentStatus"]["name"] ?></span>
                                    </td>
                                    <td class="text-center">
                                        <?php
                                        $countUnderRatio = 0;
                                        foreach ($item["Treatment"] as $treatment) {
                                            $countUnderRatio+=$treatment["ratio_status_id"] == 4 ? 1 : 0;
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
                                        if ($weightRemainingIgnoreMinus > 0) {
                                            ?>
                                            <a href = "<?= Router::url("/admin/treatments/add/{$item[Inflector::classify($this->params['controller'])]['id']} ", true) ?>" class = "btn btn-default btn-xs btn-icon btn-icon tip" title = "Proses Treament"><i class = "icon-stopwatch"></i></a>
                                            <?php
                                        }
                                        ?>
                                        <!--<a data-toggle="modal" data-material-entry-id="<?= $item['MaterialEntry']['id'] ?>" role="button" href="#default-lihatConversion" class="btn btn-default btn-xs btn-icon btn-icon tip viewData" title="Lihat Data"><i class="icon-eye7"></i></a>-->
                                        <a data-toggle="modal" data-target="#default-view-treatment" role="button" href="<?= Router::url("/admin/popups/content?content=viewtreatment&id={$item['MaterialEntry']['id']}") ?>" class="ajax-modal btn btn-default btn-xs btn-icon btn-icon tip" title="Lihat Data Treatment"><i class="icon-eye7"></i></a>
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
<!--<div id="default-lihatConversion" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">FORM</h4>
            </div>
            <div class="panel form-horizontal">
                <div class="panel-body">
                    <div class="block-inner text-danger">
                        <h6 class="heading-hr">LIHAT DATA PROSES TREATMENT (RETOUCHING)-->
                            <!--<small class="display-block"><?= _APP_CORPORATE_FULL ?></small>-->
<!--                        </h6>
                    </div>
                    <div class="well block">
                        <div class="tabbable">
                            <ul class="nav nav-pills nav-justified" id="targetTitleTab">

                            </ul>
                            <div class="tab-content pill-content" id="targetContentTab">

                            </div>
                            <div class="tab-content pill-content" id="targetContentTabTreatment">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info" data-dismiss="modal">Tutup Form</button>
            </div>
        </div>
    </div>    
</div>-->
<!--<script>
    $(document).ready(function () {
        var remaining = <?= $remaining ?>;
        $(".viewData").click(function () {
            $("tr.transaction-material-data").html("");
            $("#targetTitleTab").html("");
            $("#targetContentTab").html("");
            $("#targetContentTabTreatment").html("");
//            var conversionId = $(this).data("conversion-id");
            var materialEntryId = $(this).data("material-entry-id");
            var e = $("tr.dynamic-row-conversion");
            var is_empty = false;
            $.ajax({
                url: BASE_URL + "freezes/get_data_material_entry/" + materialEntryId,
                type: "GET",
                dataType: "JSON",
                success: function (response) {
                    console.log(response);
                    if (response.status == 206) {
                        var i = 1;
                        var nomor = 1;
                        var is_active = "";
                        var in_active = "";
                        var warning = "";
                        var update = "";
                        $.each(response.data, function (index, data) {
                            $.each(data.Freeze, function (index, value) {
                                if (value.id != null) {
                                    var freeze_weight = value.total_weight;
                                    var freeze_ratio = value.ratio;
                                    var treatment_weight = value.Treatment.total;
                                    var treatment_ratio = value.Treatment.ratio;
                                    var start_date = cvtTanggal(value.Treatment.start_date);
                                    var end_date = cvtTanggal(value.Treatment.end_date);
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
                                    if (value.Treatment == 0) {
                                        update = "icon-plus-circle";
                                    } else {
                                        update = "";
                                    }
                                    var options = {
                                        nomor: nomor,
                                        is_active: is_active,
                                        in_active: in_active,
                                        warning: warning,
                                        update: update,
                                        title_tab: "Styling " + i,
                                        freeze_weight: freeze_weight,
                                        freeze_ratio: freeze_ratio,
                                        treatment_weight: treatment_weight,
                                        treatment_ratio: treatment_ratio,
                                        start_date: start_date,
                                        end_date: end_date
                                    };
                                    var rendered = Mustache.render(titleTabTemplate, options);
                                    var rendered2 = Mustache.render(contentTabTemplate, options);
                                    $("#targetTitleTab").append(rendered);
                                    $("#targetContentTab").append(rendered2);

                                    $("#ConversionNoConversion").val(value.no_conversion);

                                    //data pegawai freeze
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
                                    $("#target-employee" + i).append(rendered_emp);

                                    //DATA FREEZE
                                    var freeze = value;
                                    var freeze_number = freeze.freeze_number;
                                    var freeze_date = cvtTanggal(freeze.created);
                                    var template_freeze = $("#tmpl-freeze").html();
                                    Mustache.parse(template_freeze);
                                    var options = {
                                        freeze_number: freeze_number,
                                        freeze_date: freeze_date,
                                    };
                                    var rendered_freeze = Mustache.render(template_freeze, options);
                                    $("#target-freeze" + i).append(rendered_freeze);

                                    $.each(value.FreezeDetail, function (j, val) {
                                        var name = val.Product.Parent.name + " " + val.Product.name;
                                        var weight = val.weight;
                                        if (val.rejected_grade_type_id == null) {
                                            var reject_type = "-";
                                        } else {
                                            var reject_type = val.RejectedGradeType.name;
                                        }
                                        var template3 = $('#tmpl-material-data').html();
                                        Mustache.parse(template3);
                                        var options = {
                                            index: j + 1,
                                            name: name,
                                            weight: weight,
                                            reject_type: reject_type
                                        };
                                        var render = Mustache.render(template3, options);
                                        $("#target-detail-transaction" + i).append(render);
                                    });

                                    if (value.Treatment == 0) {
                                        $("#pegawaiDataFreezing" + (index + 1)).hide();
                                        $("#hasilFreezing" + (index + 1)).hide();
                                    } else {
                                        $("#pegawaiDataFreezing").show();
                                        $("#hasilFreezing").show();
                                    }
                                    if (value.Treatment.length != 0) {
                                        var emp = value.Treatment.Employee;
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
                                        $("#target-employee-treatment" + nomor).append(rendered_emp);

                                        //data NAMA OPERATOR
                                        var operator = value.Treatment.Operator;
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

                                        //DATA treatment
                                        var treatment = value.Treatment;
                                        var treatment_number = treatment.treatment_number;
                                        var treatment_date = cvtTanggal(treatment.created);
                                        var template_treatment = $("#tmpl-treatment").html();
                                        Mustache.parse(template_treatment);
                                        var options = {
                                            treatment_number: treatment_number,
                                            treatment_date: treatment_date,
                                        };
                                        var rendered_treatment = Mustache.render(template_treatment, options);
                                        $("#target-treatment" + nomor).append(rendered_treatment);

                                        var FreezeId = value.id;
                                        var number = 1;
                                        if (value.Treatment.id == undefined) {
                                            var href = BASE_URL + "admin/treatments/add?id=" + FreezeId;
                                            $("#add" + nomor).attr("href", href);
                                            $("#boxAdd" + nomor).show();
                                            $("#treatment-detail" + nomor).css("visibility", "hidden");
                                            $("#treatment-detail" + nomor).css("height", "0");
                                        } else {
                                            $("#boxAdd" + nomor).hide();
                                            //Tampilkan Treatment data
                                            $.each(value.Treatment.TreatmentDetail, function (j, val) {
                                                var product = val.Product.Parent.name + " " + val.Product.name;
                                                var weight = val.weight;
                                                if (val.rejected_grade_type_id == null) {
                                                    var reject_type = "-";
                                                } else {
                                                    var reject_type = val.RejectedGradeType.name;
                                                }
                                                var template3 = $('#tmpl-treatment-material').html();
                                                Mustache.parse(template3);
                                                var options = {
                                                    index: j + 1,
                                                    product: product,
                                                    weight: weight,
                                                    reject_type: reject_type
                                                };
                                                var render = Mustache.render(template3, options);
                                                $("#target-treatment-transaction" + nomor).append(render);
                                            });
                                        }
                                        var temp = value.Treatment.note;
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
                            });
                        });
                        if (i == 1) {
                            $("div#targetContentTab").append("<div class='text-center text-danger'><h2>Belum Ada Data Treatment!</h2></div>");
                        }
                    }
                }
            });
        });
    });
</script>-->
<!--<script type="x-tmpl-mustache" id="tmpl-material-data">
    <tr class="dynamic-row transaction-material-data">
    <td class="text-center nomorIdx">{{index}}</td>
    <td class="text-center">
    <input class='form-control' id='ConversionDataMaterialDetailId' value="{{name}}" disabled>
    </td> 
    <td>
    <input class='form-control text-center' id='ConversionDataRejectedGradeTypeId' value="{{reject_type}}" disabled>
    </td> 
    <td>
    <span class="input-group" style="">
    <input type='text' id='ConversionDataMaterialSize{{n}}Quantity' class='form-control TotalMaterial text-right' value="{{weight}}" disabled/>
    <span class="input-group-addon">Kg</span>
    </span>
    </td>        
    </tr>
</script>
<script type="x-tmpl-mustache" id="tmpl-material-data-empty">
    <tr class="dynamic-row transaction-material-data">
    <td colspan="4" class="text-center">Tidak Ada Data</td>   
    </tr>
</script>
<script type="x-tmpl-mustache" id="tmpl-title-tab">
    <li class="{{is_active}}"><a href="#justified-pill{{nomor}}" data-toggle="tab"><i class="icon-file6"></i> {{title_tab}}<span class = "pull-right"><i class="{{warning}} text-danger tip" title="Tidak memenuhi rasio"></i><i class="{{update}} text-success tip" title="Belum diproses"></i></span></a></li>
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
<script type="x-tmpl-mustache" id="tmpl-treatment">
    <div class = "form-group">
    <div class = "col-md-2">
    <label class = "control-label">Nomor Treatment </label>
    </div>
    <div class = "col-md-4">
    <input type='text' class='form-control' value="{{treatment_number}}" disabled/>
    </div>
    <div class = "col-md-2">
    <label class = "control-label">Tanggal Treatment </label>
    </div>
    <div class = "col-md-4">
    <input type='text' class='form-control' value="{{treatment_date}}" disabled/>
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
<script type="x-tmpl-mustache" id="tmpl-treatment-tab">
    <div class="tab-pane fade {{in_active}}" id="treatment-detail{{nomor}} justified-pill{{nomor}}">
    <table width="100%" class="table table-hover table-bordered stn-table">
    <thead>
    <tr>
    <th width="50">No</th>
    <th>Nama Material</th>
    <th width = "250">Berat Ikan</th>
    </tr>
    </thead>
    <tbody id="target-treatment-transaction{{nomor}}">
    </tbody>
    </table>
    <br><br>       
    </div>                    
</script>
<script type="x-tmpl-mustache" id="tmpl-treatment-material">
    <tr class="dynamic-row processed-material-data">
    <td class="text-center nomorIdx">{{index}}</td>
    <td class="text-center">
    <input class='form-control' value="{{product}}" disabled>
    </td> 
    <td>
    <input class='form-control text-center' value="{{reject_type}}" disabled>
    </td> 
    <td>
    <span class="input-group" style="">
    <input type='text' class='form-control text-right' value="{{weight}}" disabled/>
    <span class="input-group-addon">Kg</span>
    </span>
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
<script type="x-tmpl-mustache" id="tmpl-content-tab">
    <div class="tab-pane fade {{in_active}}" id="justified-pill{{nomor}}">
    <div class="panel-heading" style="background:#2179cc">
    <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Data Styling") ?></h6>
    </div>
    <br>
    <div class="table-responsive" id="target-employee{{nomor}}">
    </div>
    <div class="table-responsive" id="target-freeze{{nomor}}">
    </div>
    <table width="100%" class="table table-hover table-bordered stn-table">
    <thead>
    <tr>
    <th width="50">No</th>
    <th>Produk</th>
    <th width = "250">Alasan Turun Grade</th>
    <th width = "250">Berat Produk</th>
    </tr>
    </thead>
    <tbody id="target-detail-transaction{{nomor}}">
    </tbody>
    <tfoot>
    <tr>
    <td colspan = 3 class= "text-right">
    <b>Berat Styling</b>
    </td>
    <td class= "text-right">
    <span class="input-group" style="">
    <input class='form-control text-right' value="{{freeze_weight}}" disabled>
    <span class="input-group-addon">Kg</span>
    </td>
    </tr>
    <tr>
    <td colspan = 3 class= "text-right">
    <b>Ratio Styling</b>
    </td>
    <td class= "text-right">
    <span class="input-group" style="">
    <input class='form-control text-right' value="{{freeze_ratio}}" disabled>
    <span class="input-group-addon">%</span>
    </td>
    </tr>
    </tfoot>
    </table>
    <br><br> 

    <div id = "pegawaiDataFreezing{{nomor}}">
    <div class="panel-heading" style="background:#2179cc" id = "pegawaiDataFreezing{{nomor}}">
    <h6 class="panel-title" style=" color:#fff"><i class="icon-user"></i><?= __("Data Pegawai Yang Memasukkan Data Styling") ?></h6>
    </div>
    <br>
    <div class="table-responsive" id="target-employee-treatment{{nomor}}">
    </div>
    <div class="panel-heading" style="background:#2179cc">
    <h6 class="panel-title" style=" color:#fff"><i class="icon-user"></i><?= __("Data Pelaksana Styling") ?></h6>
    </div>
    <br>
    <div class="table-responsive" id="target-operator{{nomor}}">
    </div>
    <div class = "form-group">
    <div class = "col-md-2">
    <label class = "control-label">Tanggal Mulai Treatment </label>
    </div>
    <div class = "col-md-4">
    <input type='text' class='form-control' value="{{start_date}}" disabled/>
    </div>
    <div class = "col-md-2">
    <label class = "control-label">Tanggal Selesai Treatment </label>
    </div>
    <div class = "col-md-4">
    <input type='text' class='form-control' value="{{end_date}}" disabled/>
    </div>
    </div>
    </div>
    <div id = "hasilFreezing{{nomor}}">
    <div id="treatment-detail{{nomor}}">
    <div class="panel-heading" style="background:#2179cc">
    <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Hasil Treatment") ?></h6>
    </div>
    <br>
    <div class="table-responsive" id="target-treatment{{nomor}}">
    </div>
    <table width="100%" class="table table-hover table-bordered stn-table">
    <thead>
    <tr>
    <th width="50">No</th>
    <th>Produk</th>
    <th width = "250">Alasan Turun Grade</th>
    <th width = "250">Berat Produk</th>
    </tr>
    </thead>
    <tbody id="target-treatment-transaction{{nomor}}">
    </tbody>
    <tfoot>
    <tr>
    <td colspan = 3 class= "text-right">
    <b>Berat Treatment</b>
    </td>
    <td class= "text-right">
    <span class="input-group" style="">
    <input class='form-control text-right' value="{{treatment_weight}}" disabled>
    <span class="input-group-addon">Kg</span>
    </td>
    </tr>
    <tr>
    <td colspan = 3 class= "text-right">
    <b>Ratio Treatment</b>
    </td>
    <td class= "text-right">
    <span class="input-group" style="">
    <input class='form-control text-right' value="{{treatment_ratio}}" disabled>
    <span class="input-group-addon">%</span>
    </td>
    </tr>
    </tfoot>
    </table>
    </div>
    <br><br>
    <div class="table-responsive" id="target-note{{nomor}}">
    </div>
    </div>  
    </div>                              
</script>-->