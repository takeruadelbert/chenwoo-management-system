<?php echo $this->Form->create("Conversion", array("class" => "form-horizontal form-separate", "action" => "conversion_process", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="tab-pane active fade in" id="data-utama">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="block-inner text-danger">
                <h6 class="heading-hr"><?= __("Konversi Whole ke Loin") ?>
                    <small class="display-block">Mohon Isikan Dengan Sesuai dan Benar</small>
                </h6>
            </div>
            <div class="well block">
                <div class="tabbable">
                    <ul class="nav nav-pills nav-justified">
                        <li class="active"><a href="#justified-pill0" data-toggle="tab"><i class="icon-people"></i> Data Pegawai</a></li>
                        <li id="tab-step1"><a href="#justified-pill1" data-toggle="tab"><i class="icon-file6"></i> Rincian Barang Masuk</a></li>
                        <li id="tab-step2a"><a href="#justified-pill3" data-toggle="tab" id="test"><i class="icon-file6"></i> Rincian Hasil Pemotongan Ikan </a></li>
                    </ul>
                    <div class="tab-content pill-content" id="tabs">
                        <div class="tab-pane fade in active" id="justified-pill0">
                            <div class="panel-heading" style="background:#2179cc">
                                <h6 class="panel-title" style=" color:#fff"><i class="icon-user"></i><?= __("Data Pegawai Yang Memasukkan Data") ?></h6>
                            </div>
                            <table width="100%" class="table table-hover">
                                <tbody>
                                    <tr>
                                        <td colspan="3" style="width:200px">
                                            <div class="form-group">
                                                <?php
                                                echo $this->Form->label("Dummy.name", __("Nama Pegawai"), array("class" => "col-sm-2 control-label"));
                                                echo $this->Form->input("Dummy.name", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled", "value" => $this->Session->read("credential.admin.Biodata.full_name")));
                                                echo $this->Form->input("Conversion.employee_id", ["type" => "hidden", "value" => $this->Session->read("credential.admin.Employee.id")]);
                                                ?>
                                                <?php
                                                echo $this->Form->label("Dummy.nip", __("NIP"), array("class" => "col-sm-2 control-label"));
                                                echo $this->Form->input("Dummy.nip", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled", "value" => $this->Session->read("credential.admin.Employee.nip")));
                                                ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" style="width:200px">
                                            <div class="form-group">
                                                <?php
                                                echo $this->Form->label("Dummy.department_name", __("Departemen"), array("class" => "col-sm-2 control-label"));
                                                echo $this->Form->input("Dummy.department_name", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled", "value" => $this->Session->read("credential.admin.Employee.Department.name")));
                                                ?>
                                                <?php
                                                echo $this->Form->label("Dummy.office_name", __("Jabatan"), array("class" => "col-sm-2 control-label"));
                                                echo $this->Form->input("Dummy.office_name", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled", "value" => $this->Session->read("credential.admin.Employee.Office.name")));
                                                ?>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table><div class="panel-heading" style="background:#2179cc">
                                <h6 class="panel-title" style=" color:#fff"><i class="icon-user"></i><?= __("Data Pelaksana Konversi") ?></h6>
                            </div>
                            <table width="100%" class="table table-hover">
                                <tbody>
                                    <tr>
                                        <td colspan="3" style="width:200px">
                                            <div class="form-group">
                                                <?php
                                                echo $this->Form->label("Conversion.name", __("Cari Nama Pegawai"), array("class" => "col-sm-2 control-label"));
                                                ?>
                                                <div class="col-sm-4">
                                                    <div class="has-feedback">
                                                        <?php
                                                        echo $this->Form->input("Conversion.name", array("div" => false, "label" => false, "class" => "form-control typeahead-ajax"));
                                                        ?>
                                                        <?php
                                                        echo $this->Form->input("Conversion.operator_id", array("type" => "hidden", "class" => "form-control"));
                                                        ?>
                                                        <i class="icon-search3 form-control-feedback"></i>
                                                    </div>
                                                </div>
                                                <?php
                                                echo $this->Form->label("Conversion.nip", __("NIP"), array("class" => "col-sm-2 control-label"));
                                                echo $this->Form->input("Conversion.nip", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled"));
                                                ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" style="width:200px">
                                            <div class="form-group">
                                                <?php
                                                echo $this->Form->label("Conversion.department_name", __("Departemen"), array("class" => "col-sm-2 control-label"));
                                                echo $this->Form->input("Conversion.department_name", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled"));
                                                ?>
                                                <?php
                                                echo $this->Form->label("Conversion.office_name", __("Jabatan"), array("class" => "col-sm-2 control-label"));
                                                echo $this->Form->input("Conversion.office_name", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled"));
                                                ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" style="width:200px">
                                            <div class="form-group">
                                                <?php
                                                echo $this->Form->label("Conversion.start_date", __("Tanggal Mulai Konversi"), array("class" => "col-sm-2 control-label"));
                                                echo $this->Form->input("Conversion.start_date", array("div" => array("class" => "col-sm-4"), "label" => false, "type" => "text", "class" => "form-control datepicker", "value" => date("Y-m-d h:i:s")));
                                                ?>
                                                <?php
                                                echo $this->Form->label("Conversion.end_date", __("Tanggal Selesai Konversi"), array("class" => "col-sm-2 control-label"));
                                                echo $this->Form->input("Conversion.end_date", array("div" => array("class" => "col-sm-4"), "label" => false, "type" => "text", "class" => "form-control datepicker", "value" => date("Y-m-d h:i:s")));
                                                ?>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="form-actions text-center">
                                        <input name="Button" type="button" onclick="gotoTab1()" class="btn btn-info" value="<?= __("Next") ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="justified-pill1">
                            <div>
                                <div class="form-group">
                                    <?php
                                    echo $this->Form->label("Dummy.material", __("Nomor Nota Timbang"), array("class" => "col-md-2 control-label"));
                                    echo $this->Form->input("Dummy.material", array("type" => "text", "div" => array("class" => "col-md-4"), "label" => false, "class" => "form-control", "disabled", "value" => $this->data['MaterialEntry']['material_entry_number']));
                                    echo $this->Form->input("Conversion.material_entry_id", ["type" => "hidden", "value" => $this->data['MaterialEntry']['id']]);
                                    echo $this->Form->label("Conversion.employee_id", __("Nama Pegawai"), array("class" => "col-md-2 control-label"));
                                    echo $this->Form->input("Conversion.employee_id", array("type" => "text", "div" => array("class" => "col-md-4"), "label" => false, "class" => "form-control", "disabled", "value" => $this->Session->read("credential.admin.Biodata.full_name")));
                                    echo $this->Form->input("Conversion.employee_id", ["type" => "hidden", "value" => $this->Session->read("credential.admin.Employee.id")]);
                                    ?>
                                </div>
                            </div>
                            <div>
                                <div class="form-group">
                                    <?php
                                    echo $this->Form->label("Conversion.created_date", __("Waktu Input Nota Timbang"), array("class" => "col-md-2 control-label"));
                                    echo $this->Form->input("Conversion.created_date", array("type" => "text", "div" => array("class" => "col-md-4"), "label" => false, "class" => "form-control datetime", "value" => $this->data['MaterialEntry']['created'], "disabled"));
                                    echo $this->Form->label("Conversion.created_date", __("Waktu Input Konversi"), array("class" => "col-md-2 control-label"));
                                    echo $this->Form->input("Conversion.created_date", array("type" => "text", "div" => array("class" => "col-md-4"), "label" => false, "class" => "form-control datetime", "value" => date("Y-m-d H:i:s")));
                                    ?>
                                </div>
                            </div>
                            <div>
                                <div class="panel panel-default">
                                    <div class="panel-body" id="materialList">
                                        <div class="table-responsive stn-table">
                                            <div class="panel-heading" style="background:#2179cc">
                                                <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Detail Material Yang Diproses") ?></h6>
                                            </div>
                                            <div class="table-responsive pre-scrollable stn-table">
                                                <table width="100%" class="table table-hover table-bordered">                        
                                                    <thead>
                                                        <tr>
                                                            <th width="50">No</th>
                                                            <th><?= __("Nama Ikan") ?></th>
                                                            <th><?= __("Ikan Ke") ?></th>
                                                            <th><?= __("Grade") ?></th>
                                                            <th><?= __("Berat") ?></th>
                                                            <th><?= __("Diproses") ?></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="target-process">
                                                        <tr id="init">
                                                            <td class = "text-center" colspan = 6>Tidak Ada Data</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>    
                                    </div>
                                    <div>
                                        <div class="panel panel-default">
                                            <div class="panel-body" id="materialList">
                                                <div class="table-responsive stn-table">
                                                    <div class="panel-heading" style="background:#2179cc">
                                                        <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Detail Material Masuk") ?></h6>
                                                    </div>
                                                    <div class="table-responsive pre-scrollable stn-table">
                                                        <table width="100%" class="table table-hover table-bordered">                        
                                                            <thead>
                                                                <tr>
                                                                    <th width="50">No</th>
                                                                    <th><?= __("Nama Ikan") ?></th>
                                                                    <th><?= __("Ikan Ke") ?></th>
                                                                    <th><?= __("Grade") ?></th>
                                                                    <th><?= __("Berat") ?></th>
                                                                    <th><?= __("Status") ?></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="target-source">
                                                                <tr id="init">
                                                                    <td class = "text-center" colspan = 6>Tidak Ada Data</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>    
                                    </div>                            
                                    <div class="panel panel-default">
                                        <div class="panel-body">
                                            <div class="block-inner text-danger">
                                                <div class="form-actions text-center">
                                                    <a href="#justified-pill3" onclick="step2a()"><input type="button" value="Next" class="btn btn-info"></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>   
                            </div> 
                        </div>                
                        <div class="tab-pane fade" id="justified-pill3">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div>
                                        <div class="form-group">
                                            <div class="col-md-4 control-label">
                                                <label>Total Berat Ikan Yang Diproses</label>
                                            </div>
                                            <div class="col-md-2">
                                                <span class="input-group">
                                                    <input type="text" class="form-control text-right" id="processedWeight" disabled value="0">
                                                    <span class="input-group-addon"><strong>Kg</strong></span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="table-responsive stn-table">
                                        <div class="panel-heading" style="background:#2179cc">
                                            <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Detail Hasil Pemotongan Ikan") ?></h6>
                                        </div>
                                        <table width="100%" class="table table-hover table-bordered">
                                            <thead>
                                                <tr>
                                                    <th align="center" valign="middle" width="1%">No</th>
                                                    <th align="center" valign="middle" width="30%">Nama Ikan</th>
                                                    <th align="center" valign="middle" width="15%">Grade</th>
                                                    <th align="center" valign="middle" width="15%">Alasan Turun Grade</th>
                                                    <th align="center" valign="middle" width="30%">Berat</th>
                                                    <th align="center" valign="middle" width="5%">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody id="target-material-data">

                                            </tbody>
                                            <tfoot>   
                                                <tr>
                                                    <td colspan="6">
                                                        <a class="text-success firstrunclick"  href="javascript:void(false)" id="addProductButton" onclick="addThisRow(this, 'material-data', 'anakOptions')" data-n="0"><i class="icon-plus-circle"></i></a>
                                                    </td>
                                                </tr>
                                                <tr align="right">
                                                    <td colspan="4">Total</td>
                                                    <td>
                                                        <span class="input-group" style="">
                                                            <input type="text" class="form-control text-right auto-calculate-grand-total-produk-data" name="data[Conversion][total]"readonly>
                                                            <span class="input-group-addon">Kg</span>
                                                        </span>
                                                    </td>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                <tr align="right">
                                                    <td colspan="4">Ratio</td>
                                                    <td>
                                                        <span class="input-group" style="">
                                                            <input type="text" class="form-control text-right auto-calculate-ratio-total-produk-data" id="ratios" data-toggle = "tooltip" name="data[Conversion][ratio]"readonly>
                                                            <span class="input-group-addon">%</span>
                                                        </span>
                                                    </td>
                                                    <td>&nbsp;</td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                        <div class = "conversionNote">
                                            <td colspan="12" style="width:200px">
                                                <div class="form-group">
                                                    <?php
                                                    echo $this->Form->label("Conversion.note", __("Keterangan"), array("class" => "col-sm-2 control-label"));
                                                    echo $this->Form->input("Conversion.note", array("div" => array("class" => "col-sm-10"), "label" => false, "class" => "ckeditor-fix notes"));
                                                    ?>
                                                    <?php
//                                                    echo $this->Form->input("Dummy.ratioNote", array("type" => "text", "class" => "form-control ratioNote"));
                                                    ?>
                                                </div>
                                            </td>
                                        </div>
                                    </div>
                                </div>                
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="block-inner text-danger">
                                        <div class="form-actions text-center">
                                            <input name="Button" type="button" onclick="step1()" class="btn btn-success" value="<?= __("Kembali") ?>">
                                            <!--<button class="btn btn-danger submitButton" data-toggle="modal" data-target="#add" type="button" href="<?php echo Router::url('/admin/popups/content?content=confirm_add', true); ?>">-->
                                            <button class="btn btn-danger checkdata" id="buttonSubmit"  type="button"  href="#">
                                                <?= __("Simpan") ?>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>    
        </div>
    </div>    
</div>
<?php echo $this->Form->end() ?>
<?php
$listSize = [];
$listMaterial = [];
foreach ($dataMaterialSize as $size) {
    $listSize[] = [
        "id" => $size["MaterialSize"]["id"],
        "label" => $size["MaterialSize"]["name"],
    ];
}
foreach ($dataMaterial as $material) {
    foreach ($material['MaterialDetail'] as $detail) {
        $listMaterial[] = [
            "id" => $detail["id"],
            "label" => $detail['name'],
        ];
    }
}
?>
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
                    return '<p>Nama : ' + context.full_name + '<br>NIP : ' + context.nip + '<br>Jabatan : ' + context.jabatan + '<br>Department : ' + context.department + '<br/>Cabang : ' + context.branch_office + '</p>';
                },
                empty: [
                    '<center><h5>Data Pegawai</h5></center><hr> <center><p> Hasil Pencarian Anda Tidak Dapat Ditemukan. </p></center>',
                ]
            }
        });
        $('input.typeahead-ajax').bind('typeahead:select', function (ev, suggestion) {
            $('#ConversionOperatorId').val(suggestion.id);
            $('#ConversionNip').val(suggestion.nip);
            $('#ConversionOfficeName').val(suggestion.jabatan);
            $('#ConversionDepartmentName').val(suggestion.department);
        });
    })
</script>
<script>
    var count = 1;
    var countMaterialEntry = 0;
    var weightTotal = 0;
    var data_material_size = <?= json_encode($listSize) ?>;
    var productId = <?= $this->data['MaterialEntry']['id'] ?>;
    var data_material = <?= json_encode($listMaterial) ?>;
    var rejected_grade_type = <?= $this->Engine->toJSONoptions($rejectedGradeTypes, "- Pilih Alasan Turun Grade -") ?>;
    var checkbox = [];
    var hrefButtonUrl = "<?php echo Router::url('/admin/popups/content?content=confirm_add', true); ?>";

    $(document).ready(function () {
        disableStep2();
        $(".conversionNote").hide();
        getDetailProduct(productId);

        $("#buttonSubmit").click(function () {
            var status = true;
            //check value
            $('.validate[type="text"]').each(function () {
                if ($.trim($(this).val()) == '') {
                    status = false;
                    $(this).css({
                        "border": "1px solid red",
                        "background": "#FFCECE"
                    });

                } else {
                    $(this).css({
                        "border": "",
                        "background": ""
                    });
                }

            });
            $('select#ConversionDataMaterialDetailId').each(function () {
                var ConversionDataMaterialDetailId = $(this).val();
                if (ConversionDataMaterialDetailId == 0) {
                    status = false;
                    $("#s2id_ConversionDataMaterialDetailId").attr("data-original-title", "Harus Dipilih!");
                    $("#s2id_ConversionDataMaterialDetailId").tooltip("fixTitle");
                    $("#s2id_ConversionDataMaterialDetailId").tooltip("show");
                } else {
                    $("#s2id_ConversionDataMaterialDetailId").removeAttr("data-original-title");
                    $("#s2id_ConversionDataMaterialDetailId").tooltip("hide");
                }
            });
            $('select#ConversionDataMaterialSizeId').each(function () {
                var MaterialEntryGradeId = $(this).val();
                if (MaterialEntryGradeId == 0) {
                    status = false;
                    $("#s2id_ConversionDataMaterialSizeId").attr("data-original-title", "Harus Dipilih!");
                    $("#s2id_ConversionDataMaterialSizeId").tooltip("fixTitle");
                    $("#s2id_ConversionDataMaterialSizeId").tooltip("show");
                } else {
                    $("#s2id_ConversionDataMaterialSizeId").removeAttr("data-original-title");
                    $("#s2id_ConversionDataMaterialSizeId").tooltip("hide");
                }
            });
//            alert($('.ratioNote').val());
//            if ($('.ratioNote').val() < 55 && $('.ratioNote').val() > 100) {
//                if ($('.notes').val() == "") {
//                    status = false;
//                    notif("warning", "Notes Belum Diisi", "growl");
//                }
//            }
            if (status == true) {
                $("#buttonSubmit").attr("href", hrefButtonUrl);
                $("#buttonSubmit").attr("data-toggle", "modal");
                $("#buttonSubmit").attr("data-target", "#add");
                $("#buttonSubmit").click();
                //$("#formSubmit").submit();
                return true;
            } else {
                return false;
                alert("Harap Check Field yang Kosong!");
            }
        });
    });

    function step1() {
        disableStep2();
        enableStep1();
        gotoTab1();
    }

    function step2a() {
        if (proceedToStep2()) {
            disableStep1();
            enableStep2();
            gotoTab2a();
        }
    }

    function disableStep1() {
        $("#tab-step1").addClass("disabled");
        $("#tab-step1 a").on("click", function (e) {
            return false;
        });
    }

    function disableStep2() {
        $("#tab-step2a").addClass("disabled");
        $("#tab-step2b").addClass("disabled");
        $("#tab-step2a a").on("click", function (e) {
            return false;
        });
        $("#tab-step2b a").on("click", function (e) {
            return false;
        });
    }

    function enableStep1() {
        $("#tab-step1").removeClass("disabled");
        $("#tab-step1 a").unbind("click");
    }

    function enableStep2() {
        $("#tab-step2a").removeClass("disabled");
        $("#tab-step2a a").unbind("click");
        $("#tab-step2b").removeClass("disabled");
        $("#tab-step2b a").unbind("click");
    }

    function gotoTab1() {
        $("#tab-step1 a").trigger("click");
    }
    function gotoTab2a() {
        $("#tab-step2a a").trigger("click");
    }
    function gotoTab2b() {
        $("#tab-step2b a").trigger("click");
    }

    function proceedToStep2() {
        if (!$(".selectIkan:checked").val()) {
            notif("warning", "Data Ikan Belum Dipilih", "growl")
            return false;
        } else {
            if ($("#ConversionOperatorId").val() == "") {
                notif("warning", "Data Pegawai Pelaksana Belum Diisi", "growl");
                return false;
            }
            return true;
        }
    }

    function sumWeight() {
        weightTotal = 0;
        $(".weight-material:enabled").each(function () {
            weightTotal += parseFloat($(this).val());
        });
        $("#processedWeight").val(ic_kg(weightTotal));
    }

    function getDetailProduct(id) {
        $("tr.data-material-source").html("");
        $("tr.data-material-process").html("");
        $.ajax({
            url: BASE_URL + "admin/material_entries/get_material_list/" + id,
            type: "GET",
            dataType: "JSON",
            success: function (data) {
                var numberSource = 1;
                var numberProcess = 1;
                var templateSource = $("#tmpl-material-source").html();
                var templateProcess = $("#tmpl-material-process").html();
                var is_returned = 0;
                Mustache.parse(templateSource);
                Mustache.parse(templateProcess);
                $("table tr#init").remove();
                for (i = 0; i < data["MaterialEntryGrade"].length; i++) {
                    for (j = 0; j < data["MaterialEntryGrade"][i]['MaterialEntryGradeDetail'].length; j++) {
                        var is_returned = data['MaterialEntryGrade'][i]['MaterialEntryGradeDetail'][j]['return_order_status'];
                        var is_used = true;
                        if (data["MaterialEntryGrade"][i]['MaterialEntryGradeDetail'][j]["is_used"] == true) {
                            is_used = true;
                        } else {
                            is_used = false;
                        }
                        var optionSource = {
                            i: numberSource,
//                            material: data["MaterialEntryGrade"][i]["MaterialDetail"]["name"] + " " + data["MaterialEntryGrade"][i]["MaterialDetail"]['Material']["name"],
                            material: data["MaterialEntryGrade"][i]["MaterialDetail"]["name"],
                            materialId: data["MaterialEntryGrade"][i]["MaterialDetail"]["id"],
                            materialDetailId: data["MaterialEntryGrade"][i]["MaterialEntryGradeDetail"][j]["id"],
                            detail: "Ikan " + (j + 1),
                            size: data["MaterialEntryGrade"][i]["MaterialSize"]["name"],
                            sizeId: data["MaterialEntryGrade"][i]["MaterialSize"]["id"],
                            quantity: data["MaterialEntryGrade"][i]['MaterialEntryGradeDetail'][j]["weight"],
                            quantity_formated: ic_kg(data["MaterialEntryGrade"][i]['MaterialEntryGradeDetail'][j]["weight"]),
                            materialEntryGradeId: data["MaterialEntryGrade"][i]['id'],
                            is_used: is_used,
                        };
                        var renderedSource = Mustache.render(templateSource, optionSource);
                        $('#target-source').append(renderedSource);
                        countMaterialEntry++;
                        numberSource++;
                        if (data["MaterialEntryGrade"][i]['MaterialEntryGradeDetail'][j]["is_used"] == 0) {
                            var is_disabled = "";
                            var is_checked = "";
                        } else {
                            var is_disabled = "disabled";
                            var is_checked = "checked";
                        }
                        if (is_used == 0 && is_returned == 0) {
                            var optionProcess = {
                                i: numberProcess,
//                                material: data["MaterialEntryGrade"][i]["MaterialDetail"]["name"] + " " + data["MaterialEntryGrade"][i]["MaterialDetail"]['Material']["name"],
                                material: data["MaterialEntryGrade"][i]["MaterialDetail"]["name"],
                                materialId: data["MaterialEntryGrade"][i]["MaterialDetail"]["id"],
                                materialDetailId: data["MaterialEntryGrade"][i]["MaterialEntryGradeDetail"][j]["id"],
                                detail: "Ikan " + (j + 1),
                                size: data["MaterialEntryGrade"][i]["MaterialSize"]["name"],
                                sizeId: data["MaterialEntryGrade"][i]["MaterialSize"]["id"],
                                quantity: data["MaterialEntryGrade"][i]['MaterialEntryGradeDetail'][j]["weight"],
                                quantity_formated: ic_kg(data["MaterialEntryGrade"][i]['MaterialEntryGradeDetail'][j]["weight"]),
                                materialEntryGradeId: data["MaterialEntryGrade"][i]['id'],
                                is_used: is_used,
                                is_disabled: is_disabled,
                                is_checked: is_checked
                            };
                            var renderedProcess = Mustache.render(templateProcess, optionProcess);
                            $('#target-process').append(renderedProcess);
                            numberProcess++;
                        }
                    }
                }
                callUpdateTotal();
                reloadStyled();
            }
        });
        addThisRow(".firstrunclick", 'material-data', 'anakOptions');
    }

    function callUpdateTotal() {
        $('.checkboxProcessMaterial').change(function () {
            checkbox.push($(this));
            if (this.checked) {
//                $(this).siblings(".todisabled").removeAttr("disabled");
                $(this).closest("td").find(".todisabled").removeAttr("disabled");
            } else {
//                $(this).siblings(".todisabled").attr("disabled", "disabled");
                $(this).closest("td").find(".todisabled").attr("disabled", "disabled");
            }
            sumWeight();
            updateTotal();
        });
    }

    function updateTotal(n) {
        var total = 0;
        var ratio = 0;
        $('input.TotalMaterial').each(function () {
            if ($(this).val() == "") {
                $thisGrandTotalDebt = 0;
            } else {
                $thisGrandTotalDebt = $(this).val();
            }
            total += parseFloat($thisGrandTotalDebt);
        });
        ratio = (total / weightTotal) * 100;
        $("input.auto-calculate-grand-total-produk-data").val((total.toFixed(2)));
        $("input.auto-calculate-ratio-total-produk-data").val((ratio.toFixed(2)));
//        $(".ratioNote").val((ratio.toFixed(2)));
        if (ratio >= 55 && ratio <= 100) {
            $("#ratios").tooltip('hide');
            $(".conversionNote").hide();
        } else {
            $(".conversionNote").show();
            $("#ratios").attr("data-original-title", "Ratio harus lebih dari 55% dan kurang dari 100%").tooltip('fixTitle').tooltip('show');
        }
    }

    function showDetailProduct(id) {
        $.ajax({
            url: BASE_URL + "admin/products/get_detail_product/" + id.value,
            type: "GET",
            dataType: "JSON",
            success: function (data) {
                for (i = 0;
                        i < data.length;
                        i++) {
                    for (j = 0;
                            j < data[i]['ProductDetail'].length;
                            j++) {
                        $("#materialList" + id.value).append("<label for='ProductDetail[" + id.value + "]name' class='col-md-2 control-label'>" + data[i]['ProductDetail'][j]['name'] + "</label>");
                    }
                }
            }
        });
    }

    String.prototype.replaceAll = function (find, replace) {
        var str = this;
        return str.replace(new RegExp(find.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&'), 'g'), replace);
    };

    function deleteThisRow(e) {
        var tbody = $(e).parents("tbody");
        e.parents("tr").remove();
        count--;
        fixNumber(tbody);
    }

    function fixNumber(e) {
        var i = 1;
        $.each(e.find("tr.dynamic-row").not(".hidden"), function () {
            $(this).find(".nomorIdx").html(i);
            $(this).find(".TotalMaterial").attr("id", "TotalMaterial" + i);
            i++;
        })
    }
    function anakOptions() {
        return {rejected_grade_type: rejected_grade_type};
    }

    function addThisRow(e, t, optFunc) {
        var n = $(e).data("n");
        var template = $('#tmpl-' + t).html();
        Mustache.parse(template);
        var options = {i: 2, n: n, data_material_size: data_material_size, data_material: data_material, rejected_grade_type: rejected_grade_type};
        var rendered = Mustache.render(template, options);
        $('#target-' + t).append(rendered);
        $(e).data("n", n + 1);
        fixNumber($('#target-' + t));
        reloadisdecimal();
        reloadSelect2();
        count++;
        callUpdateTotal();
    }

    function updateWeightTotal(n) {
        weightTotal = 0
        for (i = 1;
                i <= countMaterialEntry;
                i++) {
            weightTotal += $("input.materialProcess" + i).val();
        }
    }

    $('.nextTab').click(function () {
        $('.nav-pills > .active').next('li').find('a').trigger('click');
        $("html, body").animate({scrollTop: 0}, "slow");
    });
</script>
<script type="x-tmpl-mustache" id="tmpl-material-source">
    <tr class="data-material-source">
    <td class="text-center">{{i}}</td>
    <td class="text-left">{{material}}</td> 
    <td class="text-center">{{detail}}</td> 
    <td class="text-center">{{size}}</td>        
    <td class="text-right">{{quantity_formated}} Kg</td>
    <td class="text-center">
    {{#is_used}}
    <span class="label label-success">Sudah Diproses</span>
    {{/is_used}}
    {{^is_used}}
    <span class="label label-danger">Belum Diproses</span>
    {{/is_used}}
    </td>
    </tr>
</script>
<script type="x-tmpl-mustache" id="tmpl-material-process">
    <tr class="data-material-process">
    <td class="text-center">{{i}}</td>
    <td class="text-left">{{material}}</td> 
    <td class="text-center">{{detail}}</td> 
    <td class="text-center">{{size}}</td>   
    <td class="text-right">{{quantity_formated}} Kg</td>   
    <td width="1%" align="center">
    <label class="checkbox-inline checkbox-success">
    <input type="checkbox" name="data[MaterialProcess][{{i}}][material_entry_grade_detail_id]" class="styled checkboxDeleteRow checkboxProcessMaterial selectIkan" value="{{materialDetailId}}" {{is_disabled}} {{is_checked}} id="checkbox{{i}}">
    </label>
    <input type="hidden" disabled class="form-control text-right materialProcess{{i}} todisabled weight-material" name="data[MaterialProcess][{{i}}][weight]" value="{{quantity}}">
    <input type="hidden" disabled class="form-control text-right todisabled" name="data[MaterialProcess][{{i}}][material_detail_id]" value='{{materialId}}'>
    <input type="hidden" disabled class="form-control text-right todisabled" name="data[MaterialProcess][{{i}}][material_size_id]" value='{{sizeId}}'>
    <input type="hidden" disabled class="form-control text-right todisabled" name="data[Conversion][material_entry_grade_id]" value='{{materialEntryGradeId}}'>     
    </td>
    </tr>
</script>
<script type="x-tmpl-mustache" id="tmpl-material-data">
    <tr class="dynamic-row material-data-conversion">
    <td class="text-center nomorIdx">{{n}}</td>
    <td class="text-center">
    <select name='data[ConversionData][{{n}}][material_detail_id]' class='select-full' id='ConversionDataMaterialDetailId'>
    <option value='0'>-Pilih Ikan-</option>
    {{#data_material}}
    <option value="{{id}}">{{label}}</option>
    {{/data_material}}
    </select>
    </td> 
    <td>
    <select name='data[ConversionData][{{n}}][material_size_id]' class='select-full' id='ConversionDataMaterialSizeId'>
    <option value='0'>-Pilih Grade-</option>
    {{#data_material_size}}
    <option value="{{id}}">{{label}}</option>
    {{/data_material_size}}
    </select>
    </td>
    <td>
    <select name='data[ConversionData][{{n}}][rejected_grade_type_id]' class='select-full' id='ConversionDataRejectedGradeTypeId'>
    {{#rejected_grade_type}}
    <option value="{{value}}">{{label}}</option>
    {{/rejected_grade_type}}
    </select>
    </td>
    <td>
    <div class="input-group">
    <input type='text' id='ConversionDataMaterialSize{{n}}Quantity' name='data[ConversionData][{{n}}][material_size_quantity]' class='form-control TotalMaterial text-right validate' onkeyup='updateTotal({{n}})'/>
    <span class="input-group-addon">Kg</span>
    </div>
    </td>    
    <td align="center">
    <a href="javascript:void(false)" onclick="deleteThisRow($(this))">
    <button type="button" class="btn btn-default btn-xs btn-icon tip" title="Hapus">
    <i class="icon-remove3"></i>
    </button>
    </a>
    </td>    
    </tr>
</script>