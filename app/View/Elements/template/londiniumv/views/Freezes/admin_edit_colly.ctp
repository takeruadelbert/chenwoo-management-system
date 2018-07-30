<?php echo $this->Form->create("Freeze", array("class" => "form-horizontal form-separate", "action" => "edit_colly", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("FORM UBAH PROSES PEMBEKUAN / STYLING LOIN") ?>
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
                                            echo $this->Form->label("MaterialEntry.material_entry_number", __("Nomor Nota Timbang"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("MaterialEntry.material_entry_number", array("div" => array("class" => "col-sm-4"), "type" => "text", "label" => false, "class" => "form-control", "disabled"));
                                            ?>
                                        </div>
                                    </td>
                                </tr> 
                                <tr>
                                    <td colspan="11" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("MaterialEntry.weight_date", __("Tanggal Timbang"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("MaterialEntry.weight_date", array("div" => array("class" => "col-sm-4"), "type" => "text", "label" => false, "class" => "form-control datepicker", "disabled"));
                                            ?>
                                        </div>
                                    </td>
                                </tr> 
                            </tbody>
                        </table>
                        <div class="panel-heading" style="background:#2179cc">
                            <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Rincian Berat Ikan") ?></h6>
                        </div>
                        <div class="table-responsive stn-table">
                            <table width="100%" class="table table-hover table-bordered">    
                                <thead>
                                    <tr>
                                        <th width="50">No</th>
                                        <th><?= __("Nama Ikan") ?></th>
                                        <th><?= __("Grade") ?></th>
                                        <th><?= __("Berat") ?></th>
                                        <th><?= __("Berat Tersedia") ?></th>
                                        <th><?= __("Berat Diproses") ?></th>
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
                            echo $this->Form->label("Dummy.total", __("Total Berat Ikan Yang Distyling"), array("class" => "col-sm-4 control-label"));
                            ?>
                            <div class="col-sm-2">
                                <div class="input-group">
                                    <?=
                                    $this->Form->input("Dummy.total", array("div" => array("class" => ""), "type" => "text", "label" => false, "class" => "form-control text-right weightTotals", "id" => "beratStyling", "disabled"));
                                    ?>
                                    <span class="input-group-addon">Kg</span>

                                </div>
                            </div>
                        </div>
                        <table class="table table-hover table-bordered stn-table" width="100%">
                            <thead>
                                <tr>
                                    <th width="50">No</th>
                                    <th>Produk</th>
                                    <th width="250">Alasan Turun Grade</th>
                                    <th width="250">Berat</th>
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
                                        <strong>Total Berat</strong>
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
                <input type="reset" value="Reset" class="btn btn-info">
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
//    var weightTotals = 0;

    $(".freezeNote").hide();
    $(document).ready(function () {
        //$("#basket").on("change", function() {
        $("tbody#target-installment").html("");
        $("tr.detail-hasil-styling").remove();
        $("input#button-data-potong-next").removeAttr('disabled');
        viewDataConversion(<?= $this->data['MaterialEntry']['id'] ?>);
        callForFreezeData();

        var ratio = $('#ratios').val();
        //pengecekan ratio
        var batasAtas = 105;
        var batasBawah = 95;
        if (parseInt(ratio) < batasBawah) {
            $("#ratios").attr("data-original-title", "Ratio penurunan/kenaikan harus ±5% dari ratio Konversi!")
                    .tooltip('fixTitle')
                    .tooltip('show');
            $(".freezeNote").show();
        } else if (parseInt(ratio) > batasAtas) {
            $("#ratios").attr("data-original-title", "Ratio penurunan/kenaikan harus ±5% dari ratio Konversi!")
                    .tooltip('fixTitle')
                    .tooltip('show');
            $(".freezeNote").show();
        } else {
            $("#ratios").tooltip('hide');
            $(".freezeNote").hide();
        }
    });

    function viewDataConversion(materialEntryId) {
        var total_quantity = 0;
        $.ajax({
            url: BASE_URL + "admin/material_entries/view_data_material_entry/" + materialEntryId,
            dataType: "JSON",
            type: "GET",
            data: {},
            success: function (data) {
                var request = data.data;
                var status = true;
                if (data != null && data != '') {
                    $('input#materialId').val(request.MaterialEntry.id);
                    $('input#materialEntryNumber').val(request.MaterialEntry.material_entry_number);
                    var i = 1;
                    var template = $("#tmpl-installment").html();
                    Mustache.parse(template);
                    $("table tr#init").remove();
                    $("#detail").remove();
                    $.each(request.MaterialEntryGrade, function (index, items) {
                        //if (items.id == basketId) {
                        $.each(items.MaterialEntryGradeDetail, function (idx, val) {
                            if (val.return_order_status == 1) {
                                status = false;
                            }
                        });
//                        if (status && items.remaining_weight > 0) {
                        if (status) {
                            var options = {
                                i: i,
//                                detail: items.MaterialDetail.Material.name + " " + items.MaterialDetail.name,
                                detail: items.MaterialDetail.name,
                                size: items.MaterialSize.name,
                                weight: items.weight,
                                quantity: items.remaining_weight,
                                material_entry_grade_id: items.id,
                                material_entry_id: items.material_entry_id,
                                processed_weight: (parseFloat(items.weight - items.remaining_weight)).toFixed(2),
                            };
//                            total_quantity += parseFloat(items.weight);
                            weightTotals = parseFloat(items.weight - items.remaining_weight);
                            var rendered = Mustache.render(template, options);
                            $('#target-installment').append(rendered);
                            i++;

                        }
                        //}
                    })
//                    addThisRow(".firstrunclick", 'detail-kas-keluar', 'anakOptions');
                } else {

                }
                $('.weightTotals').val(weightTotals.toFixed(2));
                //$('#processedWeight').val(total_quantity);

            }
        });
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
        var options = {i: 1, n: n, data_product: data_product, rejected_grade_type: rejected_grade_type};
//        if (typeof (optFunc) !== 'undefined') {
//            $.extend(options, window[optFunc]());
//        }
        var rendered = Mustache.render(template, options);
        $('#target-' + t + " tr:last").before(rendered);
        $(e).data("n", n + 1);
        reloadSelect2();
        reloadisdecimal();
        fixNumber($(e).parents("tbody"));
        listenerTotalWeight(n);
    }

    function callForFreezeData() {
        var data = <?php echo json_encode($rows['FreezeDetail']) ?>;
        $.each(data, function (index, value) {
            addThisRow(".firstrunclick", 'detail-kas-keluar', 'anakOptions');
            $("#FreezeDetailProduct" + (index + 1) + "Id").select2("val", value.product_id);
            $("#FreezeDetailRejectedGradeType" + (index + 1) + "Id").select2("val", value.rejected_grade_type_id);
            $("#FreezeDetail" + (index + 1) + "Id").val(value.id);
//            alert(value.id);
            $("#FreezeDetail" + (index + 1) + "weight").val(value.weight);
        });
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

    var weightTotals = $('.weightTotals').val();

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
                $("#ratios").attr("data-original-title", "Ratio penurunan/kenaikan harus ±5% dari ratio Konversi!")
                        .tooltip('fixTitle')
                        .tooltip('show');
                $(".freezeNote").show();
            } else if (parseInt(ratio) > batasAtas) {
                $("#ratios").attr("data-original-title", "Ratio penurunan/kenaikan harus ±5% dari ratio Konversi!")
                        .tooltip('fixTitle')
                        .tooltip('show');
                $(".freezeNote").show();
            } else {
                $("#ratios").tooltip('hide');
                $(".freezeNote").hide();
            }
        });

        $('.currentProductWeight').on("keyup change", function () {
            var grandTotal = 0; //parseInt($('#grandTotal').val());
//            weightTotals = $(this).val();
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
                $("#ratios").attr("data-original-title", "Ratio penurunan/kenaikan harus ±5% dari ratio Konversi!")
                        .tooltip('fixTitle')
                        .tooltip('show');
                $(".freezeNote").show();
            } else if (parseInt(ratio) > batasAtas) {
                $("#ratios").attr("data-original-title", "Ratio penurunan/kenaikan harus ±5% dari ratio Konversi!")
                        .tooltip('fixTitle')
                        .tooltip('show');
                $(".freezeNote").show();
            } else {
                $("#ratios").tooltip('hide');
                $(".freezeNote").hide();
            }
        });
    }

    function replaceAll(str, find, replace) {
        return str.replace(new RegExp(find.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&'), 'g'), replace);
    }

    function unDisabled(n) {
        if ($("#selectedMaterial" + n).is(":checked")) {
            $("#currentProductWeight" + n).removeAttr("disabled");
            $("#currentMaterialEntryGradeId" + n).removeAttr("disabled");
            $("#currentMaterialEntryId" + n).removeAttr("disabled");
            $("#remainingWeight" + n).removeAttr("disabled");
        } else {
            $("#currentProductWeight" + n).attr('disabled', 'disabled');
            $("#currentMaterialEntryGradeId" + n).attr('disabled', 'disabled');
            $("#currentMaterialEntryId" + n).attr('disabled', 'disabled');
            $("#remainingWeight" + n).attr('disabled', 'disabled');
        }
    }

    function calcCurrentWeight(n) {
        stylingCurrentWeight = 0;
        weightTotals = 0;
        weightDifference = 0;
        var weight = $("#weight" + n).val();
        var remainingWeight = $("#remainingWeight" + n).val();
        var currentWeight = $("#currentProductWeight" + n).val();
        if (currentWeight != "") {
            weight = parseFloat($("#weight" + n).val());
            currentWeight = parseFloat($("#currentProductWeight" + n).val());
            weightDifference = weight - currentWeight;
            if (currentWeight > weight) {
                $("#currentProductWeight" + n).val("0")
                alert("Kesalahan! Berat yang diproses lebih besar dari berat tersedia!");
            } else {
                $(".currentProductWeight").each(function () {
                    if (parseFloat($(this).val()) != "") {
                        stylingCurrentWeight += parseFloat($(this).val());
                        weightTotals += parseFloat($(this).val());
                    }
                });
            }
        }
//        $('#processedWeight').val(stylingCurrentWeight);
        $("#remainingWeight" + n).val(weightDifference.toFixed(2));
        $('.weightTotals').val(stylingCurrentWeight.toFixed(2));
        listenerTotalWeight(n);
        //alert(weightTotals);
    }

    reloadStyled();
</script>
<script type="x-tmpl-mustache" id="tmpl-installment">
    <tr id="detail">
    <td class="text-center">{{i}}</td>
    <td class="text-center">{{detail}}</td>   
    <td class="text-center">{{size}}</td>        
    <td class="text-center"><div class="input-group"><input  type="text" class= "form-control text-right" name="data[FreezeSourceDetail][{{i}}][order_weight]" value="{{weight}}" id="weight{{i}}" readonly/><span class="input-group-addon"><strong>Kg</strong></span></div></td> 
    <td class="text-center"><div class="input-group"><input  type="text" class= "form-control text-right" name="data[FreezeSourceDetail][{{i}}][remaining_weight]" value="{{quantity}}" id="remainingWeight{{i}}" readonly disabled/><span class="input-group-addon"><strong>Kg</strong></span></div></td>   
    <td class="text-center"><div class="input-group"><input  type="text" class= "form-control currentProductWeight text-right" id="currentProductWeight{{i}}" data-nId="{{i}}" name="data[FreezeSourceDetail][{{i}}][weight]" value="{{processed_weight}}" onkeyup="calcCurrentWeight({{i}})"/>
    <input type="hidden" name="data[FreezeSourceDetail][{{i}}][material_entry_grade_id]" class="currentMaterialEntryGradeId" id="currentMaterialEntryGradeId{{i}}" value="{{material_entry_grade_id}}"/>
    <input type="hidden" name="data[Freeze][material_entry_id]" class="currentMaterialEntryId" id="currentMaterialEntryId{{i}}" value="{{material_entry_id}}"/>
    <input type="hidden" name="data[FreezeSourceDetail][{{i}}][id]" id="FreezeSourceDetail{{i}}Id" value="<?= $this->data['FreezeSourceDetail'][0]['id'] ?>"/>
    <span class="input-group-addon"><strong>Kg</strong></span></div></td>    
    </tr>
</script>
<script type="x-tmpl-mustache" id="tmpl-detail-kas-keluar">
    <tr class="detail-hasil-styling">
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
    <input name="data[FreezeDetail][{{n}}][weight]" id="FreezeDetail{{n}}weight" class="form-control totalWeight inputWeight{{n}} produkDeleteTrig text-right" data-trigger = "focus" maxlength="255" type="text">                                            
    <span class="input-group-addon">Kg</span>
    </div>
    </td>
    <td class="text-center">
    <a href="javascript:void(false)" onclick="deleteThisRow($(this))"><i class="icon-remove3"></i></a>
    </td>
    </tr>
</script>