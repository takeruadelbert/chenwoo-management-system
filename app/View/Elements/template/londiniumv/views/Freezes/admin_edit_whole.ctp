<?php echo $this->Form->create("Freeze", array("class" => "form-horizontal form-separate", "action" => "edit_whole", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("FORM UBAH PROSES PEMBEKUAN / STYLING WHOLE") ?>
                <small class="display-block">Mohon Isikan Dengan Sesuai dan Benar</small>
            </h6>
        </div>
        <div class="well block">
            <div class="tabbable">
                <ul class="nav nav-pills nav-justified">
                    <li class="active"><a href="#justified-pill1" data-toggle="tab"><i class="icon-user"></i> Data Pegawai</a></li>
                    <li><a href="#justified-pill2" data-toggle="tab"><i class="icon-file6"></i> Data Styling</a></li>
                    <li><a href="#justified-pill3" data-toggle="tab"><i class="icon-file6"></i> Input Hasil Styling</a></li>
                </ul>
                <div class="tab-content pill-content">
                    <div class="tab-pane fade in active" id="justified-pill1">
                        <div class="panel-heading" style="background:#2179cc">
                            <h6 class="panel-title" style=" color:#fff"><i class="icon-user"></i><?= __("Data Pegawai Yang Memasukkan Data") ?></h6>
                        </div>
                        <table width="100%" class="table table-hover">
                            <tbody>
                                <tr>
                                    <td colspan="3" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("Employee.Account.Biodata.full_name", __("Nama Pegawai"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Employee.Account.Biodata.full_name", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled"));
                                            ?>
                                            <?php
                                            echo $this->Form->label("Employee.nip", __("NIP"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Employee.nip", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled"));
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("Employee.Department.name", __("Departemen"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Employee.Department.name", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled"));
                                            ?>
                                            <?php
                                            echo $this->Form->label("Employee.Office.name", __("Jabatan"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Employee.Office.name", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled"));
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="panel-heading" style="background:#2179cc">
                            <h6 class="panel-title" style=" color:#fff"><i class="icon-user"></i><?= __("Data Pelaksana Styling") ?></h6>
                        </div>
                        <table width="100%" class="table table-hover">
                            <tbody>
                                <tr>
                                    <td colspan="3" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("Operator.Account.Biodata.full_name", __("Nama Pegawai"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Operator.Account.Biodata.full_name", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled"));
                                            ?>
                                            <?php
                                            echo $this->Form->label("Operator.nip", __("NIP"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Operator.nip", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled"));
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("Operator.Department.name", __("Departemen"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Operator.Department.name", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled"));
                                            ?>
                                            <?php
                                            echo $this->Form->label("Operator.Office.name", __("Jabatan"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Operator.Office.name", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled"));
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("Freeze.start_date", __("Tanggal Mulai Styling"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Freeze.start_date", array("div" => array("class" => "col-sm-4"), "label" => false, "type" => "text", "class" => "form-control datepicker"));
                                            ?>
                                            <?php
                                            echo $this->Form->label("Freeze.end_date", __("Tanggal Selesai Styling"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Freeze.end_date", array("div" => array("class" => "col-sm-4"), "label" => false, "type" => "text", "class" => "form-control datepicker"));
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
                                            echo $this->Form->label("Freeze.freeze_number", __("Nomor Styling"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Freeze.freeze_number", array("div" => array("class" => "col-sm-4"), "type" => "text", "label" => false, "class" => "form-control", "disabled"));
                                            ?>
                                            <?php
                                            echo $this->Form->label("Conversion.no_conversion", __("Nomor Konversi"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Conversion.no_conversion", array("div" => array("class" => "col-sm-4"), "type" => "text", "label" => false, "class" => "form-control", "disabled"));
                                            echo $this->Form->input("Freeze.conversion_id", array("div" => array("class" => "col-sm-4"), "type" => "hidden", "label" => false, "class" => "form-control"));
                                            echo $this->Form->input("Freeze.material_entry_id", array("div" => array("class" => "col-sm-4"), "type" => "hidden", "label" => false, "class" => "form-control"));
                                            ?>
                                        </div>
                                    </td>
                                </tr> 
                                <tr>
                                    <td colspan="11" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("Conversion.total", __("Berat Konversi"), array("class" => "col-sm-2 control-label"));
                                            ?>
                                            <div class="col-sm-4">
                                                <div class="input-group">
                                                    <?=
                                                    $this->Form->input("Conversion.total", array("div" => array("class" => ""), "type" => "text", "label" => false, "class" => "form-control text-right", "disabled"));
                                                    ?>
                                                    <span class="input-group-addon">Kg</span>
                                                </div>
                                            </div>
                                            <?php
                                            echo $this->Form->label("Conversion.ratio", __("Ratio Konversi"), array("class" => "col-sm-2 control-label"));
                                            ?>
                                            <div class="col-sm-4">
                                                <div class="input-group">
                                                    <?=
                                                    $this->Form->input("Conversion.ratio", array("div" => array("class" => ""), "type" => "text", "label" => false, "class" => "form-control text-right", "disabled"));
                                                    ?>
                                                    <span class="input-group-addon">%</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr> 
                            </tbody>
                        </table>
                        <div class="panel-heading" style="background:#2179cc">
                            <h6 class="panel-title" style=" color:#fff"><i class="icon-file"></i><?= __("Detail Data Konversi") ?></h6>
                        </div>
                        <div class="table-responsive stn-table">
                            <table width="100%" class="table table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th width="50">No</th>
                                        <th><?= __("Loin") ?></th>
                                        <th><?= __("Grade") ?></th>
                                        <th width="250"><?= __("Alasan Turun Grade") ?></th>
                                        <th colspan = 2><?= __("Berat") ?></th>
                                    </tr>
                                </thead>
                                <tbody id="target-installment">                                   
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="justified-pill3">
                        <div class="form-group">
                            <?php
                            echo $this->Form->label("Conversion.total", __("Total Berat Ikan Yang Distyling"), array("class" => "col-sm-4 control-label"));
                            ?>
                            <div class="col-sm-2">
                                <div class="input-group">
                                    <?=
                                    $this->Form->input("Conversion.total", array("div" => array("class" => ""), "type" => "text", "label" => false, "class" => "form-control text-right", "disabled"));
                                    ?>
                                    <span class="input-group-addon">Kg</span>
                                </div>
                            </div>
                        </div>
                        <table class="table table-hover table-bordered stn-table" width="100%">
                            <thead>
                                <tr>
                                    <th width="50">No</th>
                                    <th width="40%">Produk</th>
                                    <th width="30%">Alasan Turun Grade</th>
                                    <th width="30%">Berat</th>
                                    <th width="40">Aksi</th>
                                </tr>
                            <thead>
                            <tbody id="target-detail-kas-keluar">
                                <tr>
                                    <td colspan="5">
                                        <a class="text-success firstrunclick" href="javascript:void(false)" onclick="addThisRow($(this), 'detail-kas-keluar', 'anakOptions')" data-n="1"><i class="icon-plus-circle"></i></a>
                                    </td>
                                </tr>
                            </tbody> 
                            <tfoot>
                                <tr>
                                    <td colspan="3" align="right">
                                        <strong>Grand Total</strong>
                                    </td>
                                    <td>
                                        <div class="input-group">
                                            <input type="text" class="form-control text-right auto-calculate-grand-total-weight" id = "grandTotal" value="<?= $this->data['Freeze']['total_weight'] ?>" name="data[Freeze][total_weight]"readonly>
                                            <span class="input-group-addon"> Kg</span>
                                        </div>
                                    </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="3" align="right">
                                        <strong>Total Ratio</strong>
                                    </td>
                                    <td>
                                        <div class="input-group">
                                            <input type="text" class="form-control text-right auto-calculate-grand-total-ratio tip" id="ratios" value="<?= $this->data['Freeze']['ratio'] ?>" name="data[Freeze][ratio]"  data-toggle = "tooltip" readonly>
                                            <span class="input-group-addon"> %</span>
                                        </div>
                                    </td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                        <div class = "freezeNote">
                            <td colspan="12" style="width:200px">
                                <div class="form-group">
                                    <?php
                                    echo $this->Form->label("Freeze.note", __("Keterangan"), array("class" => "col-sm-2 control-label"));
                                    echo $this->Form->input("Freeze.note", array("div" => array("class" => "col-sm-10"), "label" => false, "class" => "ckeditor-fix"));
                                    ?>
                                </div>
                            </td>
                        </div> 
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
                <button class="btn btn-danger" data-toggle="modal" data-target="#add" type="button" href="<?php echo Router::url('/admin/popups/content?content=confirm_add', true); ?>">
                    <?= __("Simpan") ?>
                </button>
            </div>
        </div>
    </div>
</div>
<?php echo $this->Form->end() ?>
<?php
$listProduct = [];
foreach ($products as $product) {
    $childs = [];
    foreach ($product["Child"] as $child) {
        $childs[] = [
            "id" => $child["id"],
            "label" => $product["Product"]["name"] . " " . $child["name"],
        ];
    }
    $listProduct[] = [
        "id" => $product["Product"]["id"],
        "label" => $product["Product"]["name"],
        "child" => $childs,
    ];
}
?>
<script>
    var data_product = <?= json_encode($listProduct) ?>;
    var rejected_grade_type = <?= $this->Engine->toJSONoptions($rejectedGradeTypes, "- Pilih Alasan Turun Grade -") ?>;
    var weightTotals = 0;
    $(".freezeNote").hide();
    $(document).ready(function () {
//        viewDataConversion(getParameterByName("id"));
//        addThisRow(".firstrunclick", 'detail-kas-keluar', 'anakOptions');
        viewDataConversion(<?php echo $this->data['Conversion']['id'] ?>);
        callForFreezeData();
    });

    function callForFreezeData() {
        var data = <?php echo json_encode($rows['FreezeDetail']) ?>;
        $.each(data, function (index, value) {
            addThisRow(".firstrunclick", 'detail-kas-keluar', 'anakOptions');
            $("#FreezeDetailProduct" + (index + 1) + "Id").select2("val", value.product_id);
            $("#FreezeDetailRejectedGradeType" + (index + 1) + "Id").select2("val", value.rejected_grade_type_id);
            $("#FreezeDetail" + (index + 1) + "Id").val(value.id);
            $("#FreezeDetail" + (index + 1) + "weight").val(value.weight);
        });
    }

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

    function backToStep1() {
        enableStep1();
        disableStep2();
        gotoTab1();
    }

    function proceedToStep2() {
        if (!$("input[name='selectconversion']:checked").val()) {
            notif("warning", "Data Konversi Belum Dipilih", "growl")
            return false;
        } else {
            if ($("#FreezeOperatorId").val() == "") {
                notif("warning", "Data Pegawai Pelaksana Belum Diisi", "growl");
                return false;
            }
            viewDataConversion($("input[name='selectconversion']:checked").val());
            return true;
        }
    }

    function getParameterByName(name, url) {
        if (!url) {
            url = window.location.href;
        }
        name = name.replace(/[\[\]]/g, "\\$&");
        var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
                results = regex.exec(url);
        if (!results)
            return null;
        if (!results[2])
            return '';
        return decodeURIComponent(results[2].replace(/\+/g, " "));
    }

    function viewDataConversion(conversionId) {
        $.ajax({
            url: BASE_URL + "/conversions/view_data_conversion/" + conversionId,
            dataType: "JSON",
            type: "GET",
            data: {},
            beforeSend: function (xhr) {
                ajaxLoadingStart();
            },
            success: function (data) {
                var request = data.data;
                //console.log(request);
                if (request != null && request != '') {
                    if (request.Conversion.return_order_status == 0) {
                        $('input#conversion_ratio').val(request.Conversion.ratio);
                        $('input#conversion_weight').val(request.Conversion.total);
                        $('#processedWeight').val(request.Conversion.total);
                        $('input#conversionId').val(request.Conversion.id);
                        $('input#materialEntryId').val(request.Conversion.material_entry_id);
                        $('input#conversionNumber').val(request.Conversion.no_conversion);
                        var weightTotal = request.Conversion.total;
                        weightTotals = parseFloat(weightTotal);
                        var i = 1;
                        var template = $("#tmpl-installment").html();
                        Mustache.parse(template);
                        $("table tr#init").remove();
                        $('#target-installment').html("");
                        $.each(request.ConversionData, function (index, item) {
                            if (item.rejected_grade_type_id == null) {
                                var rejectedGradeType = "-";
                            } else {
                                var rejectedGradeType = item.RejectedGradeType.name;
                            }
                            var options = {
                                i: i,
                                detail: item.MaterialDetail.name,
                                size: item.MaterialSize.name,
                                quantity: item.material_size_quantity,
                                rejectedGradeType: rejectedGradeType,
                            };
                            var rendered = Mustache.render(template, options);
                            $('#target-installment').append(rendered);
                            i++;
                        });
                    }
                }
                ajaxLoadingSuccess()
            }
        })
    }

    var products =<?= $this->Engine->toJSONoptions($products) ?>;

    function deleteThisRow(e) {
        var tbody = $(e).parents("tbody");
        e.parents("tr").remove();
        fixNumber(tbody);
        $('.produkDeleteTrig').trigger("keyup");
        var n = $(e).data("n");
        listenerTotalWeight(n);
    }

    function addThisRow(e, t, optFunc) {
        var n = $(e).data("n");
        var template = $('#tmpl-' + t).html();
        Mustache.parse(template);
        var options = {i: 1, n: n};
        if (typeof (optFunc) !== 'undefined') {
            $.extend(options, window[optFunc]());
        }
        var rendered = Mustache.render(template, options);
        $('#target-' + t + " tr:last").before(rendered);
        $(e).data("n", n + 1);
        reloadSelect2();
        reloadisdecimal();
        fixNumber($(e).parents("tbody"));
        listenerTotalWeight(n);
    }

    function fixNumber(e) {
        var i = 1;
        $.each(e.find("tr"), function () {
            $(this).find(".nomorIdx").html(i);
            i++;
        })
    }

    function anakOptions() {
        return {data_product: data_product, rejected_grade_type: rejected_grade_type};
    }

    function listenerTotalWeight(n) {
        var ratio = 0;
        $('.inputWeight' + n).on("keyup change", function () {
            var grandTotal = 0; //parseInt($('#grandTotal').val());
            $('.totalWeight').each(function () {
                if ($(this).val()) {
                    $weight = $(this).val();
                } else {
                    $weight = 0;
                }
                grandTotal += parseFloat($weight);
            });
            ratio = (grandTotal / weightTotals) * 100;
            $("input.auto-calculate-grand-total-weight").val(grandTotal.toFixed(2));
            $("input.auto-calculate-grand-total-ratio").val(ratio.toFixed(2));
            //pengecekan ratio
            var batasAtas = 105;
            var batasBawah = 95;
            if (parseInt(ratio) < batasBawah) {
                $("#ratios").attr("data-original-title", "Ratio penurunan/kenaikan harus ±5% dari berat Konversi!")
                        .tooltip('fixTitle')
                        .tooltip('show');
//                $(".submitButton").attr("disabled", "disabled");
                $(".freezeNote").show();
            } else if (parseInt(ratio) > batasAtas) {
                $("#ratios").attr("data-original-title", "Ratio penurunan/kenaikan harus ±5% dari berat Konversi!")
                        .tooltip('fixTitle')
                        .tooltip('show');
//                $(".submitButton").attr("disabled", "disabled");
                $(".freezeNote").show();
            } else {
                $("#ratios").tooltip('hide');
                $(".freezeNote").hide();
//                $(".submitButton").removeAttr("disabled");
            }
        });
    }

    function replaceAll(str, find, replace) {
        return str.replace(new RegExp(find.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&'), 'g'), replace);
    }

    reloadStyled();
</script>
<script type="x-tmpl-mustache" id="tmpl-installment">
    <tr>
    <td class="text-center">{{i}}</td>
    <td class="text-left">{{detail}}</td> 
    <td class="text-center">{{size}}</td>        
    <td class="text-center">{{rejectedGradeType}}</td>        
    <td class="text-right" style="border-right-style:none;">{{quantity}} </td>     
    <td class = "text-left" style= "width:50px; border-left-style:none;"> Kg</td>
    </tr>
</script>
<script type="x-tmpl-mustache" id="tmpl-detail-kas-keluar">
    <tr>
    <td class="text-center nomorIdx">
    {{i}}
    </td>
    <td>
    <select class="select-full" name="data[FreezeDetail][{{n}}][product_id]" placeholder="- Pilih Produk -" id='FreezeDetailProduct{{n}}Id'>
    <option value='0'>-Pilih Produk-</option>
    {{#data_product}}
    <optgroup label="{{label}}">
    {{#child}}
    <option value="{{id}}" data-id="{{n}}">{{label}}</option>
    {{/child}}
    </optgroup>
    {{/data_product}}
    </select>         
    <input type="hidden" name="data[FreezeDetail][{{n}}][id]" id="FreezeDetail{{n}}Id"/>                           
    </td>
    <td>
    <select name='data[FreezeDetail][{{n}}][rejected_grade_type_id]' class='select-full' id='FreezeDetailRejectedGradeType{{n}}Id'>
    {{#rejected_grade_type}}
    <option value="{{value}}">{{label}}</option>
    {{/rejected_grade_type}}
    </select>
    </td>
    <td>
    <div class="input-group">
    <input name="data[FreezeDetail][{{n}}][weight]" id='FreezeDetail{{n}}weight' class="form-control totalWeight inputWeight{{n}} produkDeleteTrig text-right" data-trigger = "focus" maxlength="255" type="text">                                   
    <span class="input-group-addon">Kg</span>
    </div>
    </td>
    <td class="text-center">
    <a href="javascript:void(false)" onclick="deleteThisRow($(this))"><i class="icon-remove3"></i></a>
    </td>
    </tr>
</script></script>